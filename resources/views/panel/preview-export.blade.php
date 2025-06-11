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
                                <div class="download-btn" data-format="pdf">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                    <div class="fw-semibold">PDF</div>
                                    <small class="text-muted">Print Ready</small>
                                </div>
                                
                                <div class="download-btn" data-format="png">
                                    <i class="bi bi-file-earmark-image text-primary"></i>
                                    <div class="fw-semibold">PNG</div>
                                    <small class="text-muted">High Quality</small>
                                </div>
                                
                                <div class="download-btn" data-format="svg">
                                    <i class="bi bi-file-earmark-code text-success"></i>
                                    <div class="fw-semibold">SVG</div>
                                    <small class="text-muted">Vector</small>
                                </div>
                                
                                <div class="download-btn" data-format="print">
                                    <i class="bi bi-printer text-warning"></i>
                                    <div class="fw-semibold">Print</div>
                                    <small class="text-muted">Direct Print</small>
                                </div>
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
                            
                            <!--<div class="label-design-canvas" id="labelCanvas">-->
                                {!! $product->translation->design_translated_text !!}
                                
                            <!--</div>-->
                            
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
                                <button class="action-btn btn btn-success" id="archiveBtn">
                                    <i class="bi bi-archive"></i>
                                    Archive Label
                                </button>
                                
                                <button class="action-btn btn btn-info" id="shareBtn">
                                    <i class="bi bi-share"></i>
                                    Share Label
                                </button>
                                
                                <button class="action-btn btn btn-primary" id="emailBtn">
                                    <i class="bi bi-envelope"></i>
                                    Send by Email
                                </button>
                                
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
                    <div class="mb-3">
                        <label class="form-label">Share with</label>
                        <input type="email" class="form-control" placeholder="Enter email addresses (comma separated)">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message (Optional)</label>
                        <textarea class="form-control" rows="3" placeholder="Add a message..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Permissions</label>
                        <select class="form-select">
                            <option>View only</option>
                            <option>Can comment</option>
                            <option>Can edit</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Recipients will receive a link to view this label design.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Send Share Link</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send by Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">To</label>
                        <input type="email" class="form-control" placeholder="recipient@company.com">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" value="Label Design: Premium Coffee Blend">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="4">Hi,Please find attached the label design for Premium Coffee Blend. The design includes Spanish translations and is ready for production.Best regards,John Smith</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Attachments</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="attachPDF" checked>
                            <label class="form-check-label" for="attachPDF">
                                PDF (Print Ready)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="attachPNG">
                            <label class="form-check-label" for="attachPNG">
                                PNG (High Resolution)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Send Email</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('panel-assets/js/preview-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Success mesajını 5 saniye sonra otomatik kapat
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(function() {
                    const alert = bootstrap.Alert.getOrCreateInstance(successMessage);
                    alert.close();
                }, 5000);
            }

            // Resim zoom modalı
            const zoomImageBtn = document.getElementById('zoomImageBtn');
            if (zoomImageBtn) {
                zoomImageBtn.addEventListener('click', function() {
                    const imageZoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
                    imageZoomModal.show();
                });
            }

            // ESC tuşu ile modalı kapatma
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const imageZoomModal = bootstrap.Modal.getInstance(document.getElementById('imageZoomModal'));
                    if (imageZoomModal) {
                        imageZoomModal.hide();
                    }
                }
            });
        });
    </script>
@endsection
