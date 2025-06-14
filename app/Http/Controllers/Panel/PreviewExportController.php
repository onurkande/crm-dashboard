<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PreviewExportController extends Controller
{
    public function show($product)
    {
        $product = Product::with(['category', 'translation'])
            ->where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check if product has any faulty reports
        $hasFaultyReport = $product->faultyProducts()
            ->where('status', 'pending')
            ->exists();

        if ($hasFaultyReport) {
            return redirect()->route('panel.template-editor', ['product' => $product->id])
                ->with('error', 'This product has pending issues that need to be resolved.');
        }

        return view('panel.preview-export', compact('product'));
    }

    public function downloadPDF($product)
    {
        $product = Product::with(['category', 'translation'])
            ->where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = PDF::loadView('panel.pdf.product-label', compact('product'));
        
        return $pdf->download($product->name . '-label.pdf');
    }

    /*public function downloadPNG(Request $request, $product)
    {
        $product = Product::with(['category', 'translation'])
            ->where('id', $product)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $width = $request->input('width', 800);
        $height = $request->input('height', 600);
        $quality = $request->input('quality', 100);

        $text = strip_tags($product->translation->design_translated_text);

        $manager = new ImageManager(new Driver());
        $image = $manager->create($width, $height, '#ffffff'); // boş canvas

        // Yazı ekle (Not: v3'te doğrudan `text()` fonksiyonu yok, eklentilerle destekleniyor)

        // PNG olarak çıktıyı al
        $png = $image->toPng();

        return response($png->toString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $product->name . '-label.png"');
    }*/
} 