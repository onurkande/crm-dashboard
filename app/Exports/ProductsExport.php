<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Product::with(['category'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Category',
            'Description',
            'Barcode',
            'Barcode Type',
            'Status',
            'Original Language',
            'Target Language',
            'Created At',
            'Updated At'
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category->name,
            $product->description,
            $product->barcode,
            $product->barcode_type,
            $product->status,
            $product->original_lang,
            $product->target_lang,
            $product->created_at->format('Y-m-d H:i:s'),
            $product->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
} 