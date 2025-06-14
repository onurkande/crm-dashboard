<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\FaultyProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\VisionService;
use App\Services\TranslateService;
use Illuminate\Support\Facades\Log;

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

        // If there is a reviewed faulty record, set it to fixed
        $faulty = $product->faultyProducts()->where('status', 'reviewed')->latest()->first();
        if ($faulty) {
            $faulty->status = 'fixed';
            $faulty->save();
        }

        return redirect()->route('panel.preview-export', ['product' => $product->id])
            ->with('success', 'Template design saved successfully.');
    }

    public function reportFaulty(Request $request, $product)
    {
        $product = Product::where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'description' => 'required|string',
            'error_type' => 'required|string'
        ]);

        // Check if faulty product record exists
        $faultyProduct = FaultyProduct::where('product_id', $product->id)->first();

        if ($faultyProduct) {
            // Update existing record
            $faultyProduct->update([
                'description' => $request->description,
                'error_type' => $request->error_type,
                'status' => 'pending'
            ]);
        } else {
            // Create new record
            FaultyProduct::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'description' => $request->description,
                'error_type' => $request->error_type,
                'status' => 'pending'
            ]);
        }

        // Delete existing translation if it exists
        ProductTranslation::where('product_id', $product->id)->delete();

        return redirect()->back()->with('success', 'Translation issue has been reported successfully.');
    }

    public function retranslate(Request $request, $product)
    {
        $product = Product::where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'new_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'original_lang' => 'required|string|max:10',
            'target_lang' => 'required|string|max:10'
        ]);

        try {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Save new image
            $image = $request->file('new_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePathh = $image->storeAs('products', $imageName, 'public');
            $imagePath = config('filesystems.disks.public.root') . '/products/' . $imageName;

            // Detect text from image using Vision API
            $detectedText = app(VisionService::class)->detectText($imagePath);

            // Translate the detected text
            $translation = app(TranslateService::class)->translate(
                $detectedText,
                $request->target_lang,
                $request->original_lang
            );

            // Update product
            $product->image = $imagePathh;
            $product->original_lang = $request->original_lang;
            $product->target_lang = $request->target_lang;
            $product->translated_text = $translation['translated_text'];
            $product->save();

            // Delete existing translation if it exists
            //ProductTranslation::where('product_id', $product->id)->delete();

            // Find the latest pending faulty record and set to reviewed
            $faulty = $product->faultyProducts()->where('status', 'pending')->latest()->first();
            if ($faulty) {
                $faulty->status = 'reviewed';
                $faulty->save();
            }

            return redirect()->back()->with('success', 'New image uploaded and translation completed successfully.');
        } catch (\Exception $e) {
            Log::error('Error in retranslation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error processing image: ' . $e->getMessage());
        }
    }
}
