<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'producer',
        'importer',
        'product_code',
        'image',
        'target_lang',
        'original_lang',
        'translated_text',
        'barcode_type',
        'barcode',
        'qr_code',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function translation(): HasOne
    {
        return $this->hasOne(ProductTranslation::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function faultyProducts()
    {
        return $this->hasMany(FaultyProduct::class);
    }

    public function getProductCount()
    {
        return $this->where('user_id', auth()->id())->count();
    }

    public function getMonthlySuccessRate()
    {
        $currentMonth = now()->startOfMonth();
        
        // Get total products for current month
        $totalProducts = $this->where('user_id', auth()->id())
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        // Get faulty products for current month
        $faultyCount = FaultyProduct::whereHas('product', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        // Calculate success rate for current month
        $currentSuccessRate = 0;
        if ($totalProducts > 0) {
            $currentSuccessRate = round((($totalProducts - $faultyCount) / $totalProducts) * 100, 2);
        }

        // Get last month's metrics
        $lastMonth = $currentMonth->copy()->subMonth();
        
        $lastMonthTotal = $this->where('user_id', auth()->id())
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $lastMonthFaulty = FaultyProduct::whereHas('product', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        // Calculate last month's success rate
        $lastMonthSuccessRate = 0;
        if ($lastMonthTotal > 0) {
            $lastMonthSuccessRate = round((($lastMonthTotal - $lastMonthFaulty) / $lastMonthTotal) * 100, 2);
        }
        // Calculate error rate for current month
        $currentErrorRate = 0;
        if ($totalProducts > 0) {
            $currentErrorRate = round(($faultyCount / $totalProducts) * 100, 2);
        }

        // Calculate percentage improvement
        $improvement = 0;
        if ($lastMonthSuccessRate > 0) {
            $improvement = round($currentSuccessRate - $lastMonthSuccessRate, 2);
        }

        return [
            'faulty_count' => $faultyCount,
            'current_rate' => $currentSuccessRate,
            'last_month_rate' => $lastMonthSuccessRate,
            'improvement' => $improvement,
            'current_error_rate' => $currentErrorRate
        ];
    }

    /**
     * Get the full name of a language from its code
     * 
     * @param string $code The language code (e.g. 'en', 'tr')
     * @return string The full language name
     */
    public static function getLanguageName($code)
    {
        $languages = [
            'en' => 'English',
            'bg' => 'Bulgarian', 
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'tr' => 'Turkish',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'ar' => 'Arabic',
            'fr' => 'French',
            'it' => 'Italian',
            'de' => 'German'
        ];

        return $languages[$code] ?? $code;
    }

    /**
     * Get the full language name for this product's target language
     * 
     * @return string
     */
    public function getTargetLanguageName()
    {
        return self::getLanguageName($this->target_lang);
    }
    /**
     * Calculate total word count in untranslated products' texts for authenticated user
     * 
     * @return int Total word count
     */
    public function getTotalUntranslatedWords()
    {
        $untranslatedProducts = self::where('user_id', auth()->id())
            ->whereNotNull('translated_text')
            ->get();

        $totalWords = 0;
        foreach ($untranslatedProducts as $product) {
            if ($product->translated_text) {
                $totalWords += str_word_count($product->translated_text);
            }
        }

        return $totalWords;
    }

    /**
     * Get monthly translation counts for the current year for authenticated user
     * 
     * @return array Monthly counts indexed by month number (1-12)
     */
    public function getMonthlyTranslationCounts()
    {
        $currentYear = now()->year;
        
        // Initialize array with 0 counts for all 12 months
        $monthlyCounts = array_fill(1, 12, 0);

        // Get counts for each month
        $counts = self::where('user_id', auth()->id())
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        // Fill in actual counts
        foreach ($counts as $count) {
            $monthlyCounts[$count->month] = $count->count;
        }

        return $monthlyCounts;
    }

    /**
     * Get top 6 categories with product counts and percentages for authenticated user
     * Limited to categories with max 5 products
     * 
     * @return array Categories with stats
     */
    public function getTopCategoriesStats()
    {
        // Get total product count for percentage calculation
        $totalProducts = self::where('user_id', auth()->id())->count();

        if ($totalProducts === 0) {
            return [];
        }

        // Get categories with their product counts
        $categories = self::where('user_id', auth()->id())
            ->selectRaw('category_id, COUNT(*) as product_count')
            ->groupBy('category_id')
            ->having('product_count', '<=', 5) // Only categories with max 5 products
            ->orderBy('product_count', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($category) use ($totalProducts) {
                return [
                    'name' => $category->category->name,
                    'product_count' => $category->product_count,
                    'percentage' => round(($category->product_count / $totalProducts) * 100, 1)
                ];
            });

        return $categories->toArray();
    }
    
    /**
     * Get hourly activity data for the authenticated user's product actions in the last 24 hours
     * Returns count of products created or updated for each hour
     *
     * @return array Hourly activity counts
     */
    public function getHourlyActivityHeatmap()
    {
        // Initialize array with 24 hours, all set to 0
        $hourlyActivity = array_fill(0, 24, 0);

        // Get records from last 24 hours
        $activities = self::where('user_id', auth()->id())
            ->where(function($query) {
                $query->where('created_at', '>=', now()->subHours(24))
                      ->orWhere('updated_at', '>=', now()->subHours(24));
            })
            ->get();

        foreach ($activities as $activity) {
            // Count creations
            if ($activity->created_at >= now()->subHours(24)) {
                $hour = $activity->created_at->hour;
                $hourlyActivity[$hour]++;
            }
            
            // Count updates (if different from creation time)
            if ($activity->updated_at >= now()->subHours(24) && 
                $activity->updated_at->format('Y-m-d H:i:s') !== $activity->created_at->format('Y-m-d H:i:s')) {
                $hour = $activity->updated_at->hour;
                $hourlyActivity[$hour]++;
            }
        }

        return $hourlyActivity;
    }
} 