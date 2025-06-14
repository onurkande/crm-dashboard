<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Product Label - {{ $product->name }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        .product-info {
            margin-bottom: 30px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .info-item {
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 12px;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 14px;
        }
        .product-image {
            text-align: center;
            margin: 20px 0;
        }
        .product-image img {
            max-width: 300px;
            height: auto;
        }
        .producer-importer {
            margin-top: 15px;
            font-size: 12px;
            color: #666;
        }
        .producer-importer div {
            margin-bottom: 5px;
        }
        .producer-importer strong {
            color: #333;
        }
        .translation-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .translation-section h2 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .barcode-section {
            text-align: center;
            margin: 20px 0;
        }
        .barcode-section img {
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Product Label Details</h1>
    </div>

    <div class="product-info">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Product Name</div>
                <div class="info-value">{{ $product->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Product Code / SKU</div>
                <div class="info-value">{{ $product->product_code }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Category</div>
                <div class="info-value">{{ $product->category->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Original Language</div>
                <div class="info-value">{{ $product->original_lang }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Target Language</div>
                <div class="info-value">{{ $product->target_lang }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Created Date</div>
                <div class="info-value">{{ $product->created_at->format('d F Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Description</div>
                <div class="info-value">{{ $product->description }}</div>
            </div>
            @if($product->producer || $product->importer)
            <div class="producer-importer">
                @if($product->producer)
                <div><strong>Producer:</strong> {{ $product->producer }}</div>
                @endif
                @if($product->importer)
                <div><strong>Importer:</strong> {{ $product->importer }}</div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="product-image">
        <img src="{{ storage_path('app/public/' . $product->image) }}" alt="{{ $product->name }}">
    </div>

    @if($product->barcode)
    <div class="barcode-section">
        <div class="info-label">Barcode</div>
        <div class="info-value">{{ $product->barcode }}</div>
    </div>
    @endif
    @if($product->qr_code)
    <div class="qr-code-section">
        <div class="info-label">QR Code</div>
        <div class="info-value">{{ $product->qr_code }}</div>
    </div>
    @endif

    <div class="translation-section">
        <h2>Translated Content</h2>
        <div class="info-value">
            {!! $product->translation->design_translated_text ?? $product->translated_text !!}
        </div>
    </div>

    <div class="footer">
        <p>Generated on {{ now()->format('d F Y H:i:s') }}</p>
        <p>© {{ date('Y') }} LabelTranslate. All rights reserved.</p>
    </div>
</body>
</html> 