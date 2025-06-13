<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Label Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .label-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .label-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .label-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .label-header p {
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .label-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .label-image {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }
        
        .label-image img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
        
        .label-details {
            padding: 1rem;
        }
        
        .detail-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .detail-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        
        .detail-value {
            font-size: 1rem;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .share-section {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }
        
        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: all 0.2s ease;
        }
        
        .share-btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        
        .facebook { background-color: #1877f2; }
        .twitter { background-color: #000000; }
        .linkedin { background-color: #0a66c2; }
        .whatsapp { background-color: #25d366; }
        
        @media (max-width: 768px) {
            .label-content {
                grid-template-columns: 1fr;
            }
            
            .share-btn {
                margin: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="label-container">
        <div class="label-header">
            <h1>{{ $product->name }}</h1>
            <p>Label Design Preview</p>
        </div>
        
        <div class="label-content">
            <div class="label-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>
            
            <div class="label-details">
                <div class="detail-item">
                    <div class="detail-label">Product Name</div>
                    <div class="detail-value">{{ $product->name }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">SKU / Barcode</div>
                    <div class="detail-value">{{ $product->product_code }} / {{ $product->barcode }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Category</div>
                    <div class="detail-value">{{ $product->category->name }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Original Language</div>
                    <div class="detail-value">{{ $product->original_lang }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Translation Language</div>
                    <div class="detail-value">{{ $product->target_lang }}</div>
                </div>
                
                @if($product->qr_code)
                <div class="detail-item">
                    <div class="detail-label">QR Code</div>
                    <div class="detail-value">
                        <i class="bi bi-qr-code"></i> Available
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="share-section">
            <h5 class="mb-3">Share this label</h5>
            <div>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                   target="_blank" class="share-btn facebook">
                    <i class="bi bi-facebook"></i>
                    <span>Facebook</span>
                </a>
                
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" 
                   target="_blank" class="share-btn twitter">
                    <i class="bi bi-twitter-x"></i>
                    <span>Twitter</span>
                </a>
                
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($product->name) }}" 
                   target="_blank" class="share-btn linkedin">
                    <i class="bi bi-linkedin"></i>
                    <span>LinkedIn</span>
                </a>
                
                <a href="https://wa.me/?text={{ urlencode(request()->url()) }}" 
                   target="_blank" class="share-btn whatsapp">
                    <i class="bi bi-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 