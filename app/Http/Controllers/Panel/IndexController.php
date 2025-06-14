<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Barryvdh\DomPDF\Facade\Pdf;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->get();
        $productCount = $products->count();
        
        // Get last month's product count
        $lastMonthProducts = Product::where('user_id', auth()->id())
            ->where('created_at', '<=', now()->subMonth())
            ->count();

        // Calculate percentage change
        $productPercentageChange = 0;
        if ($lastMonthProducts > 0) {
            $productPercentageChange = round((($productCount - $lastMonthProducts) / $lastMonthProducts) * 100);
        }


        $translatedProductCount = $products->filter(function($product) {
            return $product->translations()->exists();
        })->count();

        // Get last month's translated product count
        $lastMonthTranslatedProducts = Product::where('user_id', auth()->id())
            ->where('created_at', '<=', now()->subMonth())
            ->whereHas('translations')
            ->count();

        // Calculate percentage change
        $translatedProductPercentageChange = 0;
        if ($lastMonthTranslatedProducts > 0) {
            $translatedProductPercentageChange = round((($translatedProductCount - $lastMonthTranslatedProducts) / $lastMonthTranslatedProducts) * 100);
        }



        // Get products translated in the last week
        $lastWeekTranslations = $products->filter(function($product) {
            return $product->translations()
                          ->where('created_at', '>=', now()->subWeek())
                          ->exists();
        })->count();
        // Get products translated in the previous week for comparison
        $previousWeekTranslations = $products->filter(function($product) {
            return $product->translations()
                          ->whereBetween('created_at', [
                              now()->subWeeks(2), 
                              now()->subWeek()
                          ])->exists();
        })->count();
        // Calculate percentage change
        $percentageChange = 0;
        if ($previousWeekTranslations > 0) {
            $percentageChange = round((($lastWeekTranslations - $previousWeekTranslations) / $previousWeekTranslations) * 100);
        }
        // Add to compact array
        $translationStats = [
            'lastWeek' => $lastWeekTranslations,
            'percentageChange' => $percentageChange
        ];


        // Get top 5 categories with product counts
        $topCategories = ProductCategory::withCount('products')
            ->whereHas('products', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->products_count
                ];
            });

        // Son 90 gün için günlük çeviri sayıları
        $dailyTranslatedCounts = [];
        $startDate = now()->subDays(89)->startOfDay();
        $endDate = now()->endOfDay();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $count = Product::where('user_id', auth()->id())
                ->whereHas('translations', function($q) use ($date) {
                    $q->whereDate('created_at', $date->toDateString());
                })
                ->count();
            $dailyTranslatedCounts[$date->format('Y-m-d')] = $count;
        }

        // Monthly Summary data
        $monthlySummary = [
            'labelsCreated' => $productCount,
            'translations' => $translatedProductCount,
            'printJobs' => 0, // Gerçek veriyle değiştirilebilir
            'templates' => 0, // Gerçek veriyle değiştirilebilir
        ];

        return view('panel.index', compact('products', 'productCount', 'translatedProductCount', 'translationStats', 'productPercentageChange', 'translatedProductPercentageChange', 'topCategories', 'dailyTranslatedCounts', 'monthlySummary'));
    }

    public function exportPdf()
    {
        $products = Product::where('user_id', auth()->id())->get();
        $productCount = $products->count();
        $lastMonthProducts = Product::where('user_id', auth()->id())
            ->where('created_at', '<=', now()->subMonth())
            ->count();
        $productPercentageChange = 0;
        if ($lastMonthProducts > 0) {
            $productPercentageChange = round((($productCount - $lastMonthProducts) / $lastMonthProducts) * 100);
        }
        $translatedProductCount = $products->filter(function($product) {
            return $product->translations()->exists();
        })->count();
        $lastMonthTranslatedProducts = Product::where('user_id', auth()->id())
            ->where('created_at', '<=', now()->subMonth())
            ->whereHas('translations')
            ->count();
        $translatedProductPercentageChange = 0;
        if ($lastMonthTranslatedProducts > 0) {
            $translatedProductPercentageChange = round((($translatedProductCount - $lastMonthTranslatedProducts) / $lastMonthTranslatedProducts) * 100);
        }
        $lastWeekTranslations = $products->filter(function($product) {
            return $product->translations()
                          ->where('created_at', '>=', now()->subWeek())
                          ->exists();
        })->count();
        $previousWeekTranslations = $products->filter(function($product) {
            return $product->translations()
                          ->whereBetween('created_at', [
                              now()->subWeeks(2), 
                              now()->subWeek()
                          ])->exists();
        })->count();
        $percentageChange = 0;
        if ($previousWeekTranslations > 0) {
            $percentageChange = round((($lastWeekTranslations - $previousWeekTranslations) / $previousWeekTranslations) * 100);
        }
        $translationStats = [
            'lastWeek' => $lastWeekTranslations,
            'percentageChange' => $percentageChange
        ];
        $topCategories = ProductCategory::withCount('products')
            ->whereHas('products', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->products_count
                ];
            });
        $dailyTranslatedCounts = [];
        $startDate = now()->subDays(89)->startOfDay();
        $endDate = now()->endOfDay();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $count = Product::where('user_id', auth()->id())
                ->whereHas('translations', function($q) use ($date) {
                    $q->whereDate('created_at', $date->toDateString());
                })
                ->count();
            $dailyTranslatedCounts[$date->format('Y-m-d')] = $count;
        }
        $monthlySummary = [
            'labelsCreated' => $productCount,
            'translations' => $translatedProductCount,
            'printJobs' => 0,
            'templates' => 0,
        ];
        $pdf = Pdf::loadView('panel.pdf.dashboard', compact(
            'products', 'productCount', 'translatedProductCount', 'translationStats',
            'productPercentageChange', 'translatedProductPercentageChange', 'topCategories',
            'dailyTranslatedCounts', 'monthlySummary'
        ));
        return $pdf->download('dashboard-summary.pdf');
    }
}
