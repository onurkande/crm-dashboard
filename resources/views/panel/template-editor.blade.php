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

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                <div class="d-flex align-items-center">
                    <div class="error-icon me-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="error-content">
                        <h6 class="alert-heading mb-1">Error!</h6>
                        <p class="mb-0">{{ session('error') }}</p>
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

            @php
                $pendingFaulty = $product->faultyProducts()->where('status', 'pending')->latest()->first();
            @endphp
            @if($pendingFaulty)
                <div class="alert alert-warning d-flex align-items-start gap-3">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="mb-1"><b>Translation Issue Reported</b></div>
                        <div><b>Error Type:</b> <span class="badge bg-danger text-white">{{ ucfirst($pendingFaulty->error_type) }}</span></div>
                        <div class="mt-1"><b>Description:</b> {{ $pendingFaulty->description }}</div>
                        <form action="{{ route('panel.template-editor.retranslate', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-auto">
                                    <label class="form-label mb-0">Original Language:</label>
                                    <select name="original_lang" class="form-select form-select-sm" required>
                                        <option value="en">English</option>
                                        <option value="tr">Turkish</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="es">Spanish</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label class="form-label mb-0">Target Language:</label>
                                    <select name="target_lang" class="form-select form-select-sm" required>
                                        <option value="tr">Turkish</option>
                                        <option value="en">English</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="es">Spanish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <label class="form-label mb-0">Upload New Image:</label>
                                <input type="file" name="new_image" accept="image/*" class="form-control form-control-sm w-auto" required>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-arrow-repeat me-1"></i> Retranslate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

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
                                        @if($product->faultyProducts()->where('status', 'pending')->exists())
                                            <div class="alert alert-warning mb-0 d-flex align-items-center">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                <span>This product's translation has been marked as incorrect and is awaiting review.</span>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reportFaultyModal">
                                                <i class="bi bi-exclamation-triangle me-1"></i> Report Translation Issue
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-circle me-1"></i> Save & Continue
                                            </button>
                                        @endif
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Producer <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="producer" value="{{$product->producer}}" 
                                       placeholder="Enter producer name" required>
                                @error('producer')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Importer <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="importer" value="{{$product->importer}}" 
                                       placeholder="Enter importer name" required>
                                @error('importer')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
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

    <!-- Report Faulty Translation Modal -->
    <div class="modal fade" id="reportFaultyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Report Translation Issue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('panel.template-editor.report-faulty', $product->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Error Type</label>
                            <select class="form-select" name="error_type" required>
                                <option value="">Select error type</option>
                                <option value="grammar">Grammar Error</option>
                                <option value="meaning">Meaning Error</option>
                                <option value="formatting">Formatting Issue</option>
                                <option value="missing">Missing Translation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required placeholder="Please describe the translation issue..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Submit Report</button>
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

            const errorMessage = document.querySelector('.error-message');
            if (errorMessage) {
                setTimeout(function() {
                    const alert = bootstrap.Alert.getOrCreateInstance(errorMessage);
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