<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('site.show', compact('product'));
    }
} 