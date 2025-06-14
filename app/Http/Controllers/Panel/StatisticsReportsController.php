<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
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

        return view('panel.statistics-reports', compact('products', 'productCount'));
    }
}
