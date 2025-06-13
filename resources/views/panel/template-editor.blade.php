@extends('panel.layouts.master')

@section('title', 'Template Editor')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/template-editor.css') }}">
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

        /* Resim önizleme modal stilleri */
        .product-image {
            transition: transform 0.2s ease-in-out;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        #imagePreviewModal .modal-content {
            background-color: transparent;
            border: none;
        }

        #imagePreviewModal .modal-header {
            position: absolute;
            right: 0;
            z-index: 1;
        }

        #imagePreviewModal .btn-close {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem;
            margin: 0.5rem;
            border-radius: 50%;
        }

        #imagePreviewModal .btn-close:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        #imagePreviewModal .modal-body {
            text-align: center;
        }

        #imagePreviewModal img {
            max-height: 80vh;
            object-fit: contain;
        }
    </style>
@endsection

@section('meta')
    <meta name="description" content="Template Editor">
    <meta name="keywords" content="Template Editor">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        <div class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Template Editor</h1>
                    <p class="text-muted mb-0">Design and customize your product label template</p>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-secondary" href="{{route('panel.products')}}">
                        <i class="bi bi-arrow-left me-1"></i> Back to Products
                    </a>
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
                <div class="step active">
                    <div class="step-number">2</div>
                    <span>Template Design</span>
                </div>
                <div class="step-connector"></div>
                <div class="step">
                    <div class="step-number">3</div>
                    <span>Preview & Print</span>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-4">
                    <!-- Product Information Section -->
                    <div class="card mb-4">
                        <div class="card-header product-info-card">
                            <h5 class="section-title text-white border-white mb-3">
                                <i class="bi bi-box me-2"></i>Product Information
                            </h5>
                            <div class="row text-white">
                                <div class="col-12 mb-3">
                                    <h6 class="fw-bold mb-1">{{$product->name}}</h6>
                                    <small class="text-white-50">{{$product->product_code}}</small>
                                </div>
                                @if($product->description)
                                <div class="col-12 mb-3">
                                    <small class="text-white-50 d-block">Description:</small>
                                    <p class="mb-0 small">{{$product->description}}</p>
                                </div>
                                @endif
                                <div class="col-6">
                                    <small class="text-white-50 d-block">Category:</small>
                                    <span class="small">{{$product->category->name}}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-white-50 d-block">Barcode Type:</small>
                                    <span class="small">{{$product->barcode_type}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label small fw-bold">Barcode</label>
                                    <div class="barcode-display">
                                        <div class="mb-2">
                                            <i class="bi bi-upc-scan" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="small">{{$product->barcode}}</div>
                                    </div>
                                </div>
                                @if($product->qr_code)
                                <div class="col-6">
                                    <label class="form-label small fw-bold">QR Code</label>
                                    <div class="qr-code-display">
                                        <i class="bi bi-qr-code" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="mt-3">
                                <label class="form-label small fw-bold">Product Image</label>
                                <img src="{{asset('storage/'.$product->image)}}" alt="Product" class="img-fluid rounded border product-image" style="width: 100%; height: 120px; object-fit: cover; cursor: pointer;">
                            </div>
                            
                            <div class="d-grid mt-3">
                                <button class="btn btn-outline-primary btn-sm" id="editProductBtn" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                    <i class="bi bi-pencil me-1"></i> Edit Product Information
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- Right Column -->
                <div class="col-lg-8">
                    <!-- Live Preview -->
                    <div class="card">
                        <form action="{{ route('panel.template-editor.update', ['product' => $product->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h5 class="section-title">
                                    <i class="bi bi-eye me-2"></i>Live Preview
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Template Design</label>
                                    @if($product->translation)
                                        <textarea id="editor-content" name="design_translated_text" class="form-control" rows="15">{{$product->translation->design_translated_text}}</textarea>
                                    @else
                                        <textarea id="editor-content" name="design_translated_text" class="form-control" rows="15">{{$product->translated_text}}</textarea>
                                    @endif
                                </div>
                            </div>

                            <!-- Sticky Actions -->
                            <div class="sticky-actions">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="hidden" id="saveAsDraft">
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-1"></i> Save & Continue
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img src="{{asset('storage/'.$product->image)}}" alt="Product" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{route('panel.products.update', $product->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Limited Editing:</strong> Some fields like barcode type and SKU cannot be changed to maintain data integrity.
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" value="{{$product->name}}" name="name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Category</label>
                            <select class="form-select" name="category_id">
                                @foreach(auth()->user()->categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Product Code / SKU</label>
                            <input type="text" class="form-control" value="{{$product->product_code}}" disabled>
                            <small class="form-text text-muted">SKU cannot be changed</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" name="description">{{$product->description}}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Barcode Type</label>
                            <select class="form-select" disabled>
                                <option value="{{$product->barcode_type}}">{{$product->barcode_type}}</option>
                            </select>
                            <small class="form-text text-muted">Barcode type cannot be changed</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('panel-assets/js/template-editor.js') }}"></script>
    <script>
        // Success mesajını 5 saniye sonra otomatik kapat
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(function() {
                    const alert = bootstrap.Alert.getOrCreateInstance(successMessage);
                    alert.close();
                }, 5000);
            }

            // Resim önizleme modalı
            const productImage = document.querySelector('.product-image');
            if (productImage) {
                productImage.addEventListener('click', function() {
                    const imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                    imagePreviewModal.show();
                });
            }

            // ESC tuşu ile modalı kapatma
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const imagePreviewModal = bootstrap.Modal.getInstance(document.getElementById('imagePreviewModal'));
                    if (imagePreviewModal) {
                        imagePreviewModal.hide();
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.config.versionCheck = false;
        CKEDITOR.replace('editor-content');
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endsection