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
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $visionService;
    protected $translateService;

    public function __construct(VisionService $visionService, TranslateService $translateService)
    {
        $this->visionService = $visionService;
        $this->translateService = $translateService;
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'translation', 'faultyProducts']);

        // Category filter
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // Date range filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Tag status filter
        if ($request->has('tag_status') && !empty($request->tag_status)) {
            if ($request->tag_status === 'tagged') {
                $query->whereNotNull('translated_text');
            } else {
                $query->whereNull('translated_text');
            }
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Language status filter
        if ($request->has('language_status') && !empty($request->language_status)) {
            if ($request->language_status === 'translated') {
                $query->whereNotNull('translated_text');
            } else {
                $query->whereNull('translated_text');
            }
        }

        // Barcode type filter
        if ($request->has('barcode_type') && !empty($request->barcode_type)) {
            $query->where('barcode_type', $request->barcode_type);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('barcode', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('product_code', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Exclude products with faulty translations
        $query->whereDoesntHave('faultyProducts', function($q) {
            $q->where('status', 'pending');
        });

        // Get categories for filter dropdown
        $categories = ProductCategory::all();

        // Get filtered and paginated products
        $products = $query->paginate(10);
        $products->appends(request()->query());

        return view('panel.products', compact('products', 'categories'));
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
            'producer' => 'required|string|max:255',
            'importer' => 'required|string|max:255',
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
                $product->producer = $request->producer;
                $product->importer = $request->importer;
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
            'producer' => 'required|string|max:255',
            'importer' => 'required|string|max:255',
        ]);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->producer = $request->producer;
        $product->importer = $request->importer;
        
        $product->save();

        return redirect()->route('panel.template-editor', ['product' => $product->id])->with('success', 'Product basic information has been updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('panel.products')->with('success', 'Product deleted successfully.');
    }

    public function updateStatus(Request $request, Product $product)
    {
        $product->status = $request->status;
        $product->save();

        return redirect()->back()->with('success', 'Product status updated successfully');
    }

    public function bulkDelete(Request $request)
    {
        $productIds = json_decode($request->product_ids);
        
        foreach ($productIds as $id) {
            $product = Product::find($id);
            if ($product && $product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
        }

        return redirect()->back()->with('success', count($productIds) . ' products deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function faultyTranslations(Request $request)
    {
        $query = Product::with(['category', 'translation', 'faultyProducts'])
            ->whereHas('faultyProducts', function($q) {
                $q->where('status', 'pending');
            });

        // Category filter
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // Date range filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Error type filter
        if ($request->has('error_type') && !empty($request->error_type)) {
            $query->whereHas('faultyProducts', function($q) use ($request) {
                $q->where('error_type', $request->error_type);
            });
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('barcode', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('product_code', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Get categories for filter dropdown
        $categories = ProductCategory::all();

        // Get filtered and paginated products
        $products = $query->paginate(10);
        $products->appends(request()->query());

        return view('panel.faulty-translations', compact('products', 'categories'));
    }
} 