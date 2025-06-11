<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;

class TemplateEditorController extends Controller
{
    public function index($product)
    {
        $product = Product::where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('panel.template-editor', compact('product'));
    }

    public function update(Request $request, $product)
    {
        // Check if the product belongs to the current user
        $product = Product::where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'design_translated_text' => 'required|string'
        ]);

        // Check if translation exists
        $translation = ProductTranslation::where('product_id', $product->id)->first();

        if ($translation) {
            // Update existing translation
            $translation->design_translated_text = $request->design_translated_text;
            $translation->save();
        } else {
            // Create new translation
            ProductTranslation::create([
                'product_id' => $product->id,
                'design_translated_text' => $request->design_translated_text
            ]);
        }

        return redirect()->route('panel.preview-export', ['product' => $product->id])
            ->with('success', 'Template design saved successfully.');
    }
}
