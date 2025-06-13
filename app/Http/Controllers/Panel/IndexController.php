<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

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

        return view('panel.index', compact('products', 'productCount', 'translatedProductCount', 'translationStats', 'productPercentageChange', 'topCategories'));
    }
}
