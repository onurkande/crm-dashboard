@extends('panel.layouts.master')

@section('title', 'Preview & Export')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/preview-export.css') }}">
    <style>
        .success-message {
            background-color: #d4edda;
            border: none;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .success-message .success-icon {
            font-size: 1.5rem;
            color: #198754;
        }
        
        .success-message .alert-heading {
            color: #0f5132;
            font-weight: 600;
        }
        
        .success-message p {
            color: #0f5132;
            font-size: 0.95rem;
        }
        
        .success-message .btn-close {
            opacity: 0.5;
            transition: opacity 0.2s ease-in-out;
        }
        
        .success-message .btn-close:hover {
            opacity: 0.75;
        }
        
        .success-message.fade {
            transition: opacity 0.3s linear;
        }
        
        .success-message.fade.show {
            opacity: 1;
        }

        /* Resim zoom modal stilleri */
        #imageZoomModal .modal-content {
            background-color: transparent;
            border: none;
        }

        #imageZoomModal .modal-header {
            position: absolute;
            right: 0;
            z-index: 1;
        }

        #imageZoomModal .btn-close {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem;
            margin: 0.5rem;
            border-radius: 50%;
        }

        #imageZoomModal .btn-close:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        #imageZoomModal .modal-body {
            text-align: center;
        }

        #imageZoomModal img {
            max-height: 80vh;
            object-fit: contain;
        }

        /* Paylaşım butonları stilleri */
        .share-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 1rem;
        }
        
        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .share-btn i {
            font-size: 1.25rem;
        }
        
        .share-btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        
        .facebook {
            background-color: #1877f2;
        }
        
        .twitter {
            background-color: #000000;
        }
        
        .linkedin {
            background-color: #0a66c2;
        }
        
        .whatsapp {
            background-color: #25d366;
        }
        
        .email {
            background-color: #ea4335;
        }
        
        .copy-link {
            background-color: #6c757d;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        
        .copy-link:hover {
            background-color: #5a6268;
        }
    </style>
@endsection

@section('meta')
    <meta name="description" content="Preview & Export">
    <meta name="keywords" content="Preview & Export">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        <div class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Preview & Export</h1>
                    <p class="text-muted mb-0">Review your label design and export in multiple formats</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('panel.template-editor', ['product' => $product->id]) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Editor
                    </a>
                    <button class="btn btn-outline-primary" id="fullScreenBtn">
                        <i class="bi bi-fullscreen me-1"></i> Full Screen
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show success-message" role="alert">
                <div class="d-flex align-items-center">
                    <div class="success-icon me-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="success-content">
                        <h6 class="alert-heading mb-1">Success!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step completed">
                    <div class="step-number">1</div>
                    <span>Product Info</span>
                </div>
                <div class="step-connector"></div>
                <div class="step completed">
                    <div class="step-number">2</div>
                    <span>Template Design</span>
                </div>
                <div class="step-connector"></div>
                <div class="step active">
                    <div class="step-number">3</div>
                    <span>Preview & Export</span>
                </div>
            </div>

            <!-- Product Information Summary -->
            <div class="card mb-4">
                <div class="card-header product-info-summary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-white mb-1">
                                <i class="bi bi-info-circle me-2"></i>Product Information Summary
                            </h5>
                            <div class="status-badge ready">
                                <i class="bi bi-check-circle"></i>
                                Ready for Export
                            </div>
                        </div>
                        <div class="text-end text-white">
                            <div class="small">Created: {{ $product->created_at->format('d F Y') }}</div>
                            <div class="small">Last Modified: {{ $product->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="metadata-grid">
                        <div class="metadata-item">
                            <div class="metadata-label">Product Name</div>
                            <div class="metadata-value">{{ $product->name }}</div>
                        </div>
                        <div class="metadata-item">
                            <div class="metadata-label">SKU / Barcode</div>
                            <div class="metadata-value">{{ $product->product_code }} / {{ $product->barcode }}</div>
                        </div>
                        <div class="metadata-item">
                            <div class="metadata-label">Category</div>
                            <div class="metadata-value">{{ $product->category->name }}</div>
                        </div>
                        <div class="metadata-item">
                            <div class="metadata-label">Original Language</div>
                            <div class="metadata-value">{{ $product->original_lang }}</div>
                        </div>
                        <div class="metadata-item">
                            <div class="metadata-label">Translation Language</div>
                            <div class="metadata-value">{{ $product->target_lang }}</div>
                        </div>
                        @if($product->qr_code)
                        <div class="metadata-item">
                            <div class="metadata-label">QR Code</div>
                            <div class="metadata-value">
                                <i class="bi bi-qr-code me-1"></i>
                                Generated
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <!-- Original vs Translated Product Image -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="section-title">
                                <i class="bi bi-images me-2"></i>Product Image Comparison
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold mb-2">Original Product Image</h6>
                                    <div class="image-comparison-container">
                                        <div class="image-comparison-item">
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                alt="Original Product" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                
                                <!--<div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold mb-2">Translated Version</h6>
                                    <div class="image-comparison-container">
                                        <div class="image-comparison-item">
                                            <img src="/placeholder.svg?height=300&width=300&text=Coffee+Product+with+Spanish+Text" 
                                                alt="Translated Product" class="img-fluid">
                                            <div class="image-overlay">
                                                <div class="overlay-text" style="top: 20px; left: 20px;">
                                                    Mezcla de Café Premium
                                                </div>
                                                <div class="overlay-text" style="top: 50px; left: 20px;">
                                                    Rica y aromática
                                                </div>
                                                <div class="overlay-text" style="bottom: 20px; left: 20px;">
                                                    100% Granos Arábica
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                            
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-outline-secondary btn-sm" id="zoomImageBtn">
                                    <i class="bi bi-zoom-in me-1"></i> Zoom
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Download Options -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="section-title">
                                <i class="bi bi-download me-2"></i>Download Options
                            </h5>
                            
                            <div class="download-options">
                                <a href="{{ route('panel.preview-export.pdf', ['product' => $product->id]) }}" class="download-btn" data-format="pdf">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                    <div class="fw-semibold">PDF</div>
                                    <small class="text-muted">Print Ready</small>
                                </a>
                                
                                <button id="takeScreenshot" class="download-btn">
                                    <i class="bi bi-file-earmark-image text-primary"></i>
                                    <div class="fw-semibold">PNG</div>
                                    <small class="text-muted">High Quality</small>
                                </button>
                                
                                <button id="downloadSvg" class="download-btn">
                                    <i class="bi bi-file-earmark-code text-success"></i>
                                    <div class="fw-semibold">SVG</div>
                                    <small class="text-muted">Vector</small>
                                </button>
                                
                                <button class="download-btn" id="printButton">
                                    <i class="bi bi-printer text-warning"></i>
                                    <div class="fw-semibold">Print</div>
                                    <small class="text-muted">Direct Print</small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6">
                    <!-- Clean Label Design -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="section-title">
                                <i class="bi bi-file-earmark-text me-2"></i>Clean Label Design
                            </h5>
                            
                            <div class="label-design-canvas">
                                <iframe id="designFrame" style="width: 100%; height: 400px; border: none; overflow: hidden;"></iframe>
                            </div>
                            
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Label Size: 300x200px</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('panel.template-editor', ['product' => $product->id]) }}" class="btn btn-outline-primary btn-sm" id="editLabelBtn">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" id="previewFullLabel">
                                            <i class="bi bi-eye me-1"></i> Full Preview
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Final Actions -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="section-title">
                                <i class="bi bi-check-circle me-2"></i>Final Actions
                            </h5>
                            
                            <div class="action-buttons">
                                <a href="{{ route('show.label', ['id' => $product->id]) }}" class="action-btn btn btn-success" id="archiveBtn">
                                    <i class="bi bi-archive"></i>
                                    Archive Label
                                </a>
                                
                                <button class="action-btn btn btn-info" id="shareBtn">
                                    <i class="bi bi-share"></i>
                                    Share Label
                                </button>
                                
                                <a href="mailto:?subject=Label Preview&body=Check out this label: {{ route('show.label', ['id' => $product->id]) }}" class="action-btn btn btn-primary" id="emailBtn">
                                    <i class="bi bi-envelope"></i>
                                    Send by Email
                                </a>
                                
                                <a href="{{ route('panel.template-editor', ['product' => $product->id]) }}" class="action-btn btn btn-outline-secondary" id="reEditBtn">
                                    <i class="bi bi-pencil-square"></i>
                                    Re-edit Label
                                </a>
                            </div>
                            
                            <!--<hr class="my-4">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-semibold mb-1">Ready to finalize?</h6>
                                    <small class="text-muted">This will mark the label as completed and ready for production.</small>
                                </div>
                                <button class="btn btn-primary btn-lg" id="finalizeBtn">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Finalize Label
                                </button>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Image Zoom Modal -->
    <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Zoomed Product" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share Label</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="share-options">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('show.label', ['id' => $product->id])) }}" 
                           target="_blank" class="share-btn facebook">
                            <i class="bi bi-facebook"></i>
                            <span>Facebook</span>
                        </a>
                        
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('show.label', ['id' => $product->id])) }}&text={{ urlencode($product->name) }}" 
                           target="_blank" class="share-btn twitter">
                            <i class="bi bi-twitter-x"></i>
                            <span>Twitter</span>
                        </a>
                        
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('show.label', ['id' => $product->id])) }}&title={{ urlencode($product->name) }}" 
                           target="_blank" class="share-btn linkedin">
                            <i class="bi bi-linkedin"></i>
                            <span>LinkedIn</span>
                        </a>
                        
                        <a href="https://wa.me/?text={{ urlencode(route('show.label', ['id' => $product->id])) }}" 
                           target="_blank" class="share-btn whatsapp">
                            <i class="bi bi-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                        
                        <a href="mailto:?subject={{ urlencode($product->name) }}&body={{ urlencode('Check out this label: ' . route('show.label', ['id' => $product->id])) }}" 
                           class="share-btn email">
                            <i class="bi bi-envelope"></i>
                            <span>Email</span>
                        </a>
                        
                        <button class="share-btn copy-link" onclick="copyShareLink()">
                            <i class="bi bi-link-45deg"></i>
                            <span>Copy Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PNG Settings Modal -->
    <!--<div class="modal fade" id="pngSettingsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PNG Export Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="pngSettingsForm" action="" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Width (px)</label>
                            <input type="number" class="form-control" name="width" value="800" min="100" max="3000">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Height (px)</label>
                            <input type="number" class="form-control" name="height" value="600" min="100" max="3000">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Quality (%)</label>
                            <input type="range" class="form-range" name="quality" min="1" max="100" value="100">
                            <div class="text-end"><span id="qualityValue">100%</span></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="pngSettingsForm" class="btn btn-primary">Download PNG</button>
                </div>
            </div>
        </div>
    </div>-->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="{{ asset('panel-assets/js/preview-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CKEditor içeriğini iframe'e yerleştir
            const designContent = `{!! $product->translation->design_translated_text ?? $product->translated_text !!}`;
            const iframe = document.getElementById('designFrame');
            iframe.onload = function() {
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                iframeDoc.open();
                iframeDoc.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <style>
                            body { margin: 0; padding: 0; }
                            img { max-width: 100%; height: auto; }
                        </style>
                    </head>
                    <body>
                        ${designContent}
                    </body>
                    </html>
                `);
                iframeDoc.close();
                //iframe.style.height = iframeDoc.body.scrollHeight + 'px';
            };
            iframe.src = 'about:blank';

            // Quality range input handler
            const qualityRange = document.querySelector('input[name="quality"]');
            const qualityValue = document.getElementById('qualityValue');
            
            if (qualityRange && qualityValue) {
                qualityRange.addEventListener('input', function() {
                    qualityValue.textContent = this.value + '%';
                });
            }
            
            // Success message auto close
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(function() {
                    const alert = bootstrap.Alert.getOrCreateInstance(successMessage);
                    alert.close();
                }, 5000);
            }

            // Image zoom modal
            const zoomImageBtn = document.getElementById('zoomImageBtn');
            if (zoomImageBtn) {
                zoomImageBtn.addEventListener('click', function() {
                    const imageZoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
                    imageZoomModal.show();
                });
            }

            // Screenshot functionality
            const takeScreenshotBtn = document.getElementById('takeScreenshot');
            if (takeScreenshotBtn) {
                takeScreenshotBtn.addEventListener('click', function() {
                    // Loading durumunu göster
                    takeScreenshotBtn.disabled = true;
                    const originalContent = takeScreenshotBtn.innerHTML;
                    takeScreenshotBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Processing...';
                    
                    // iframe içeriğini seç
                    const iframe = document.getElementById('designFrame');
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    const designElement = iframeDoc.body;
                    
                    // html2canvas ile ekran görüntüsü al
                    html2canvas(designElement, {
                        scale: 2, // Daha yüksek kalite için
                        useCORS: true, // Cross-origin resimler için
                        logging: false, // Log'ları kapat
                        allowTaint: true, // Cross-origin resimlere izin ver
                        foreignObjectRendering: true // Daha iyi render kalitesi
                    }).then(canvas => {
                        // Canvas'ı PNG'ye çevir
                        const image = canvas.toDataURL('image/png');
                        
                        // İndirme linki oluştur
                        const link = document.createElement('a');
                        link.download = 'label-design-' + new Date().getTime() + '.png';
                        link.href = image;
                        link.click();
                        
                        // Butonu eski haline getir
                        takeScreenshotBtn.disabled = false;
                        takeScreenshotBtn.innerHTML = originalContent;
                    }).catch(error => {
                        console.error('Screenshot error:', error);
                        alert('Screenshot alınırken bir hata oluştu.');
                        
                        // Hata durumunda butonu eski haline getir
                        takeScreenshotBtn.disabled = false;
                        takeScreenshotBtn.innerHTML = originalContent;
                    });
                });
            }

            // ESC key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const imageZoomModal = bootstrap.Modal.getInstance(document.getElementById('imageZoomModal'));
                    if (imageZoomModal) {
                        imageZoomModal.hide();
                    }
                }
            });

            // Link kopyalama fonksiyonu
            window.copyShareLink = function() {
                const shareUrl = '{{ route('show.label', ['id' => $product->id]) }}';
                navigator.clipboard.writeText(shareUrl).then(() => {
                    const copyBtn = document.querySelector('.copy-link');
                    const originalText = copyBtn.innerHTML;
                    copyBtn.innerHTML = '<i class="bi bi-check"></i><span>Copied!</span>';
                    setTimeout(() => {
                        copyBtn.innerHTML = originalText;
                    }, 2000);
                });
            };

            // Print functionality
            const printButton = document.getElementById('printButton');
            if (printButton) {
                printButton.addEventListener('click', function() {
                    const iframe = document.getElementById('designFrame');
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    
                    // Yazdırma için geçici bir div oluştur
                    const printDiv = document.createElement('div');
                    printDiv.innerHTML = `
                        <style>
                            @media print {
                                body * {
                                    visibility: hidden;
                                }
                                #printContent, #printContent * {
                                    visibility: visible;
                                }
                                #printContent {
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                }
                            }
                        </style>
                        <div id="printContent">
                            ${iframeDoc.body.innerHTML}
                        </div>
                    `;
                    
                    // Geçici div'i sayfaya ekle
                    document.body.appendChild(printDiv);
                    
                    // Yazdırma işlemini başlat
                    window.print();
                    
                    // Yazdırma işlemi tamamlandığında geçici div'i kaldır
                    setTimeout(() => {
                        document.body.removeChild(printDiv);
                    }, 1000);
                });
            }

            // SVG Download functionality
            const downloadSvgBtn = document.getElementById('downloadSvg');
            if (downloadSvgBtn) {
                downloadSvgBtn.addEventListener('click', function() {
                    // Loading durumunu göster
                    downloadSvgBtn.disabled = true;
                    const originalContent = downloadSvgBtn.innerHTML;
                    downloadSvgBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Processing...';
                    
                    const iframe = document.getElementById('designFrame');
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    const designElement = iframeDoc.body;
                    
                    // HTML içeriğini temizle ve düzenle
                    let cleanHtml = designElement.innerHTML
                        .replace(/&nbsp;/g, ' ') // &nbsp; karakterlerini boşluğa çevir
                        .replace(/&amp;/g, '&') // &amp; karakterlerini &'ye çevir
                        .replace(/&lt;/g, '<') // &lt; karakterlerini <'ye çevir
                        .replace(/&gt;/g, '>') // &gt; karakterlerini >'ye çevir
                        .replace(/&quot;/g, '"') // &quot; karakterlerini "'ye çevir
                        .replace(/&#39;/g, "'") // &#39; karakterlerini ''ye çevir
                        .replace(/&mdash;/g, '—') // &mdash; karakterlerini em dash'e çevir
                        .replace(/&ndash;/g, '–') // &ndash; karakterlerini en dash'e çevir
                        .replace(/&hellip;/g, '…') // &hellip; karakterlerini üç noktaya çevir
                        .replace(/&copy;/g, '©') // &copy; karakterlerini copyright işaretine çevir
                        .replace(/&reg;/g, '®') // &reg; karakterlerini registered işaretine çevir
                        .replace(/&trade;/g, '™') // &trade; karakterlerini trademark işaretine çevir
                        .replace(/&euro;/g, '€') // &euro; karakterlerini euro işaretine çevir
                        .replace(/&pound;/g, '£') // &pound; karakterlerini pound işaretine çevir
                        .replace(/&cent;/g, '¢') // &cent; karakterlerini cent işaretine çevir
                        .replace(/&deg;/g, '°') // &deg; karakterlerini derece işaretine çevir
                        .replace(/&plusmn;/g, '±') // &plusmn; karakterlerini plus-minus işaretine çevir
                        .replace(/&times;/g, '×') // &times; karakterlerini çarpma işaretine çevir
                        .replace(/&divide;/g, '÷') // &divide; karakterlerini bölme işaretine çevir
                        .replace(/&sup2;/g, '²') // &sup2; karakterlerini kare işaretine çevir
                        .replace(/&sup3;/g, '³') // &sup3; karakterlerini küp işaretine çevir
                        .replace(/&micro;/g, 'µ') // &micro; karakterlerini mikro işaretine çevir
                        .replace(/&para;/g, '¶') // &para; karakterlerini paragraf işaretine çevir
                        .replace(/&middot;/g, '·') // &middot; karakterlerini orta noktaya çevir
                        .replace(/&bull;/g, '•') // &bull; karakterlerini bullet işaretine çevir
                        .replace(/&larr;/g, '←') // &larr; karakterlerini sol ok işaretine çevir
                        .replace(/&rarr;/g, '→') // &rarr; karakterlerini sağ ok işaretine çevir
                        .replace(/&uarr;/g, '↑') // &uarr; karakterlerini yukarı ok işaretine çevir
                        .replace(/&darr;/g, '↓') // &darr; karakterlerini aşağı ok işaretine çevir
                        .replace(/&spades;/g, '♠') // &spades; karakterlerini maça işaretine çevir
                        .replace(/&clubs;/g, '♣') // &clubs; karakterlerini sinek işaretine çevir
                        .replace(/&hearts;/g, '♥') // &hearts; karakterlerini kupa işaretine çevir
                        .replace(/&diams;/g, '♦'); // &diams; karakterlerini karo işaretine çevir
                    
                    // SVG içeriğini oluştur
                    const svgContent = `
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xhtml="http://www.w3.org/1999/xhtml" width="100%" height="100%" viewBox="0 0 800 600">
                            <foreignObject width="100%" height="100%">
                                <div xmlns="http://www.w3.org/1999/xhtml">
                                    ${cleanHtml}
                                </div>
                            </foreignObject>
                        </svg>
                        `;
                    
                    // SVG'yi indirilebilir dosya haline getir
                    const blob = new Blob([svgContent], { type: 'image/svg+xml;charset=utf-8' });
                    const url = URL.createObjectURL(blob);
                    
                    // İndirme linki oluştur
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'label-design-' + new Date().getTime() + '.svg';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    // URL'i temizle
                    URL.revokeObjectURL(url);
                    
                    // Butonu eski haline getir
                    downloadSvgBtn.disabled = false;
                    downloadSvgBtn.innerHTML = originalContent;
                });
            }
        });
    </script>
@endsection
