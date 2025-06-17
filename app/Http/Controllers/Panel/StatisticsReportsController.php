<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FaultyProduct;

class StatisticsReportsController extends Controller
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

        $product = new Product();
        $getMonthlySuccessRate = $product->getMonthlySuccessRate();
        $current_rate = $getMonthlySuccessRate['current_rate'];
        $last_month_rate = $getMonthlySuccessRate['last_month_rate'];
        $improvement = $getMonthlySuccessRate['improvement'];
        $translationErrorsCount = $getMonthlySuccessRate['faulty_count'];
        $translationErrorsPercentage = $getMonthlySuccessRate['current_error_rate'];


        // Get count of distinct target languages for the authenticated user's products
        // Get count of distinct languages
        $distinctLanguagesCount = Product::where('user_id', auth()->id())
            ->distinct()
            ->whereNotNull('target_lang')
            ->count('target_lang');

        // Get top 4 most translated languages with their counts
        $topLanguages = Product::where('user_id', auth()->id())
            ->whereNotNull('target_lang')
            ->selectRaw('target_lang, count(*) as count')
            ->groupBy('target_lang')
            ->orderBy('count', 'desc')
            ->limit(4)
            ->get();


        $totalUntranslatedWords = $product->getTotalUntranslatedWords();

        $getMonthlyTranslationCounts = $product->getMonthlyTranslationCounts();

        $getTopCategoriesStats = $product->getTopCategoriesStats();

        $getHourlyActivityHeatmap = $product->getHourlyActivityHeatmap();

        // Get faulty products for authenticated user
        $faultyProducts = FaultyProduct::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->limit(5)
            ->get();


        return view('panel.statistics-reports', compact('products', 'productCount', 'current_rate', 'last_month_rate', 'improvement', 'productPercentageChange', 'distinctLanguagesCount', 'topLanguages', 'translationErrorsCount', 'translationErrorsPercentage', 'totalUntranslatedWords', 'getMonthlyTranslationCounts', 'getTopCategoriesStats', 'getHourlyActivityHeatmap', 'faultyProducts'));
    }
}
