@extends('panel.layouts.master')

@section('title', 'Add Product')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/add-product.css') }}">
@endsection

@section('meta')
    <meta name="description" content="Add Product">
    <meta name="keywords" content="Add Product">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        <div class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Add New Product</h1>
                    <p class="text-muted mb-0">Create a new product and generate labels automatically</p>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-secondary" href="{{ route('panel.products') }}">
                        <i class="bi bi-arrow-left me-1"></i> Back to Products
                    </a>
                </div>
            </div>

            <!-- Product Form -->
            <form action="{{ route('panel.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Basic Information Section -->
                        <div class="card form-section">
                            <div class="card-body">
                                <h5 class="section-title">
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="productName" class="form-label">
                                            Product Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="productName" required 
                                            placeholder="Enter product name" name="name">
                                        <div class="invalid-feedback">
                                            Please enter a product name.
                                        </div>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="productSku" class="form-label">
                                            Product Code / SKU
                                        </label>
                                        <input type="text" class="form-control" id="productSku" 
                                            placeholder="e.g., PRD-001" name="product_code">
                                        <small class="form-text text-muted">Optional but recommended for tracking</small>
                                        @error('product_code')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sourceLang" class="form-label">
                                            Source Language <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="sourceLang" name="original_lang" required>
                                            <option value="">Select source language</option>
                                            <option value="tr">🇹🇷 Turkish</option>
                                            <option value="en">🇺🇸 English</option>
                                            <option value="fr">🇫🇷 French</option>
                                            <option value="de">🇩🇪 German</option>
                                            <option value="it">🇮🇹 Italian</option>
                                            <option value="pt">🇵🇹 Portuguese</option>
                                            <option value="ar">🇸🇦 Arabic</option>
                                        </select>
                                        <small class="form-text text-muted">Select the language of your original product text</small>
                                        @error('original_lang')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="productDescription" class="form-label">Product Description</label>
                                    <textarea class="form-control" id="productDescription" rows="4" 
                                            placeholder="Detailed information about the product, features, specifications..." name="description"></textarea>
                                    <small class="form-text text-muted">Optional - Provide detailed product information</small>
                                    @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Category and Barcode Section -->
                        <div class="card form-section">
                            <div class="card-body">
                                <h5 class="section-title">
                                    <i class="bi bi-tags me-2"></i>Category & Barcode
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0">Product Category</label>
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                                <i class="bi bi-plus-circle me-1"></i> Add Category
                                            </button>
                                        </div>
                                        <div class="category-tree" id="categoryTree">
                                            @if($categories->count() > 0)
                                            @foreach ($categories as $category)
                                                <div class="category-item">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="category_id" id="cat_{{ $category->name }}" value="{{ $category->id }}">
                                                        <label class="form-check-label" for="cat_{{ $category->name }}">
                                                            {{ $category->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @else
                                                <div class="alert alert-warning">No categories found. Please add a category first.</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcodeType" class="form-label">Barcode Type</label>
                                            <select class="form-select" id="barcodeType" name="barcode_type">
                                                <option value="ean13">EAN-13</option>
                                                <option value="ean8">EAN-8</option>
                                                <option value="upc">UPC-A</option>
                                                <option value="code128">Code 128</option>
                                                <option value="qr">QR Code</option>
                                                <option value="datamatrix">Data Matrix</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="barcodeContent" class="form-label">Barcode Content</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="barcodeContent" 
                                                    placeholder="Enter barcode number or content" name="barcode">
                                                <button class="btn btn-outline-secondary" type="button" id="generateBarcode">
                                                    <i class="bi bi-arrow-clockwise"></i> Generate
                                                </button>
                                            </div>
                                            <small class="form-text text-muted">Leave empty to auto-generate</small>
                                        </div>
                                        
                                        <div class="barcode-preview" id="barcodePreview">
                                            <i class="bi bi-upc-scan text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mb-0 mt-2">Barcode preview will appear here</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Images Section -->
                        <div class="card form-section">
                            <div class="card-body">
                                <h5 class="section-title">
                                    <i class="bi bi-images me-2"></i>Product Images
                                </h5>
                                
                                <div class="image-upload-area" id="imageUploadArea">
                                    <i class="bi bi-cloud-upload text-primary" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3 mb-2">Drag & Drop Images Here</h6>
                                    <p class="text-muted mb-3">or click to browse files</p>
                                    <button type="button" class="btn btn-primary" id="browseImages">
                                        <i class="bi bi-folder2-open me-1"></i> Browse Files
                                    </button>
                                    <input type="file" id="imageInput" accept="image/*" style="display: none;" name="image">
                                    <small class="d-block mt-2 text-muted">
                                        Supported formats: JPG, PNG, GIF, WebP (Max 5MB)
                                    </small>
                                </div>
                                
                                <div class="image-preview-container" id="imagePreviewContainer">
                                    <!-- Image previews will be added here dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Language Options Section -->
                        <div class="card form-section">
                            <div class="card-body">
                                <h5 class="section-title">
                                    <i class="bi bi-translate me-2"></i>Language Options
                                </h5>
                                
                                <p class="text-muted small mb-3">
                                    Select languages for automatic label translation
                                </p>
                                
                                <div class="language-options">
                                    <div class="language-checkbox" data-lang="en">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="target_lang" id="lang_en" value="en" checked>
                                            <label class="form-check-label" for="lang_en">
                                                🇺🇸 English (Primary)
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="language-checkbox" data-lang="tr">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="target_lang" id="lang_tr" value="tr">
                                            <label class="form-check-label" for="lang_tr">
                                                🇹🇷 Turkish
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="language-checkbox" data-lang="fr">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="target_lang" id="lang_fr" value="fr">
                                            <label class="form-check-label" for="lang_fr">
                                                🇫🇷 French
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="language-checkbox" data-lang="de">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="target_lang" id="lang_de" value="de">
                                            <label class="form-check-label" for="lang_de">
                                                🇩🇪 German
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="language-checkbox" data-lang="it">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="target_lang" id="lang_it" value="it">
                                            <label class="form-check-label" for="lang_it">
                                                🇮🇹 Italian
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="language-checkbox" data-lang="pt">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="target_lang" id="lang_pt" value="pt">
                                            <label class="form-check-label" for="lang_pt">
                                                🇵🇹 Portuguese
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="language-checkbox" data-lang="ar">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="target_lang" id="lang_ar" value="ar">
                                            <label class="form-check-label" for="lang_ar">
                                                🇸🇦 Arabic
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Selected language will be used for automatic translation after product creation.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Action Buttons -->
                <div class="card mt-4">
                    <div class="sticky-actions">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" id="saveAsDraft">
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Reset Form
                                </button>
                                
                                <button type="submit" class="btn btn-primary" id="saveAndReturn">
                                    <i class="bi bi-check-circle me-1"></i> Save & Proceed to Template
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" action="{{ route('panel.categories.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">   
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="parentCategory" class="form-label">Description </label>
                            <textarea class="form-control" id="categoryDescription" rows="4" placeholder="Enter category description" name="description"></textarea>
                            <small class="form-text text-muted">Optional - Provide detailed category information</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="addCategoryForm">Save Category</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('panel-assets/js/add-product.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category form validation
            const categoryName = document.getElementById('categoryName');
            const addCategoryForm = document.getElementById('addCategoryForm');
            
            categoryName.addEventListener('input', function() {
                if (!this.value) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid'); 
                }
            });

            // Form submit validation
            addCategoryForm.addEventListener('submit', function(e) {
                if (!categoryName.value) {
                    e.preventDefault();
                    categoryName.classList.add('is-invalid');
                }
            });

            // Resim yükleme işlevselliği
            const uploadArea = document.getElementById('imageUploadArea');
            const imageInput = document.getElementById('imageInput');
            const browseBtn = document.getElementById('browseImages');
            const previewContainer = document.getElementById('imagePreviewContainer');

            // Dosya seçme butonuna tıklama
            browseBtn.addEventListener('click', function() {
                imageInput.click();
            });

            // Yükleme alanına tıklama
            uploadArea.addEventListener('click', function() {
                imageInput.click();
            });

            // Dosya seçildiğinde
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    handleFile(file);
                }
            });

            // Sürükle-bırak işlemleri
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const file = e.dataTransfer.files[0];
                if (file) {
                    handleFile(file);
                }
            });

            // Dosyayı işleme
            function handleFile(file) {
                if (!file.type.startsWith('image/')) {
                    alert('Lütfen sadece resim dosyası yükleyin.');
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('Dosya boyutu 5MB\'dan büyük olamaz.');
                    return;
                }

                // Önceki önizlemeyi temizle
                previewContainer.innerHTML = '';

                const reader = new FileReader();
                reader.onload = function(e) {
                    addImagePreview(e.target.result, file.name);
                };
                reader.readAsDataURL(file);
            }

            // Resim önizleme ekleme
            function addImagePreview(src, filename) {
                const preview = document.createElement('div');
                preview.className = 'image-preview';
                preview.innerHTML = `
                    <img src="${src}" alt="${filename}">
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                previewContainer.appendChild(preview);
            }

            // Dil seçimi işlevselliği
            const languageCheckboxes = document.querySelectorAll('.language-checkbox');
            
            languageCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function(e) {
                    const radioInput = this.querySelector('input[type="radio"]');
                    
                    if (!radioInput.checked) {
                        document.querySelectorAll('input[name="target_lang"]').forEach(input => {
                            input.checked = false;
                        });
                        
                        radioInput.checked = true;
                    }
                });

                const radioInput = checkbox.querySelector('input[type="radio"]');
                radioInput.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });
    </script>
@endsection