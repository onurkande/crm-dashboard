<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\VisionService;
use Illuminate\Support\Facades\Log;
use App\Services\TranslateService;

class ProductController extends Controller
{
    protected $visionService;
    protected $translateService;

    public function __construct(VisionService $visionService, TranslateService $translateService)
    {
        $this->visionService = $visionService;
        $this->translateService = $translateService;
    }

    public function index()
    {
        $products = Product::with(['category', 'translation'])->get();
        return view('panel.products', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('panel.add-product', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'description' => 'nullable|string',
            'product_code' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'target_lang' => 'required|string|max:10',
            'original_lang' => 'required|string|max:10',
            'barcode_type' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'qr_code' => 'nullable|string|max:255',
        ]);

        $product = new Product();
        $product->user_id = auth()->id();

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePathh = $image->storeAs('products', $imageName, 'public');

                $imagePath = config('filesystems.disks.public.root') . '/products/' . $imageName;
                
                // Detect text from image using Vision API
                $detectedText = $this->visionService->detectText($imagePath);
                
                // Here you can process the detected text
                // For example, you might want to store it in the database
                // or pass it to the translation service

                $translation = $this->translateService->translate(
                    $detectedText,
                    $request->target_lang,
                    $request->original_lang
                );
                
                $product->category_id = $request->category_id;
                $product->name = $request->name;
                $product->description = $request->description;
                $product->product_code = $request->product_code;
                $product->image = $imagePathh;
                $product->target_lang = $request->target_lang;
                $product->original_lang = $request->original_lang;
                $product->translated_text = $translation['translated_text'];
                $product->barcode_type = $request->barcode_type;
                $product->barcode = $request->barcode;
                $product->qr_code = $request->qr_code;
                $product->save();

                return redirect()->route('panel.template-editor', ['product' => $product->id])->with('success', 'Product created successfully.');
            }

            Log::warning('No image uploaded in product creation');
            return response()->json([
                'success' => false,
                'message' => 'No image uploaded'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error processing image in product creation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
        ]);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        
        $product->save();

        return redirect()->route('panel.template-editor', ['product' => $product->id])->with('success', 'Product basic information has been updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully.');
    }
} 