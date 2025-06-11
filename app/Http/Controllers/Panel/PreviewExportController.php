<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PreviewExportController extends Controller
{
    public function show($product)
    {
        $product = Product::with(['category', 'translation'])
            ->where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('panel.preview-export', compact('product'));
    }
} 