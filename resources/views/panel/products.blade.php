@extends('panel.layouts.master')

@section('title', 'Products')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/products.css') }}">
@endsection

@section('meta')
    <meta name="description" content="Products">
    <meta name="keywords" content="Products">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <!-- Page Content -->
    <div class="container-fluid p-4">
        <!-- Product Management Page -->
        <div id="productsPage" class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Product Management</h1>
                    <p class="text-muted mb-0">Manage your product catalog and information</p>
                </div>
                <div class="d-flex action-buttons">
                    <button class="btn btn-outline-secondary" id="archivedProductsBtn">
                        <i class="bi bi-archive me-1"></i> Archived Products
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="exportProducts('excel')">
                                <i class="bi bi-file-earmark-excel me-2"></i>Export as Excel
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="exportProducts('csv')">
                                <i class="bi bi-file-earmark-text me-2"></i>Export as CSV
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="bulkExport()">
                                <i class="bi bi-cloud-download me-2"></i>Bulk Export Template
                            </a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="bi bi-plus-circle me-1"></i> Add New Product
                    </button>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="filter-section">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="categoryFilter" multiple>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                            <option value="food">Food & Beverage</option>
                            <option value="cosmetics">Cosmetics</option>
                            <option value="books">Books</option>
                            <option value="toys">Toys</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date Range</label>
                        <input type="date" class="form-control" id="dateFrom" placeholder="From">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <input type="date" class="form-control" id="dateTo" placeholder="To">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tag Status</label>
                        <select class="form-select" id="tagStatusFilter">
                            <option value="">All</option>
                            <option value="tagged">Tagged</option>
                            <option value="untagged">Untagged</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <button class="btn btn-primary w-100" onclick="applyFilters()">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label class="form-label">Language Status</label>
                        <select class="form-select" id="languageFilter">
                            <option value="">All</option>
                            <option value="translated">Translated</option>
                            <option value="not-translated">Not Translated</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Barcode Type</label>
                        <select class="form-select" id="barcodeFilter">
                            <option value="">All</option>
                            <option value="qr">QR Code</option>
                            <option value="ean13">EAN-13</option>
                            <option value="code128">Code 128</option>
                            <option value="upc">UPC</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search products...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">Product Catalog</h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm" onclick="bulkAction('tag')">
                            <i class="bi bi-tags me-1"></i> Bulk Tag
                        </button>
                        <button class="btn btn-outline-warning btn-sm" onclick="bulkAction('category')">
                            <i class="bi bi-folder me-1"></i> Assign Category
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')">
                            <i class="bi bi-trash me-1"></i> Bulk Delete
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="productsTable">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th width="80">Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Barcode</th>
                                    <th>Status</th>
                                    <th>Tagged</th>
                                    <th>Language</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" name="productName" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category *</label>
                                <select class="form-select" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="clothing">Clothing</option>
                                    <option value="food">Food & Beverage</option>
                                    <option value="cosmetics">Cosmetics</option>
                                    <option value="books">Books</option>
                                    <option value="toys">Toys</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Barcode Type</label>
                                <select class="form-select" name="barcodeType">
                                    <option value="qr">QR Code</option>
                                    <option value="ean13">EAN-13</option>
                                    <option value="code128">Code 128</option>
                                    <option value="upc">UPC</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Barcode Value</label>
                                <input type="text" class="form-control" name="barcodeValue">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Product Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="productImage" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tags</label>
                                <input type="text" class="form-control" name="tags" placeholder="Enter tags separated by commas">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="isActive" checked>
                                    <label class="form-check-label">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProduct()">Save Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" name="productId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" name="productName" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category *</label>
                                <select class="form-select" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="clothing">Clothing</option>
                                    <option value="food">Food & Beverage</option>
                                    <option value="cosmetics">Cosmetics</option>
                                    <option value="books">Books</option>
                                    <option value="toys">Toys</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Barcode Type</label>
                                <select class="form-select" name="barcodeType">
                                    <option value="qr">QR Code</option>
                                    <option value="ean13">EAN-13</option>
                                    <option value="code128">Code 128</option>
                                    <option value="upc">UPC</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Barcode Value</label>
                                <input type="text" class="form-control" name="barcodeValue">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Product Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="productImage" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tags</label>
                                <input type="text" class="form-control" name="tags" placeholder="Enter tags separated by commas">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="isActive">
                                    <label class="form-check-label">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateProduct()">Update Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="quickViewImage" src="/placeholder.svg" alt="Product Image" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h4 id="quickViewName"></h4>
                            <p class="text-muted" id="quickViewCategory"></p>
                            <p id="quickViewDescription"></p>
                            
                            <div class="row g-3 mt-3">
                                <div class="col-6">
                                    <strong>Barcode:</strong>
                                    <p id="quickViewBarcode"></p>
                                </div>
                                <div class="col-6">
                                    <strong>Status:</strong>
                                    <p id="quickViewStatus"></p>
                                </div>
                                <div class="col-6">
                                    <strong>Tagged:</strong>
                                    <p id="quickViewTagged"></p>
                                </div>
                                <div class="col-6">
                                    <strong>Created:</strong>
                                    <p id="quickViewCreated"></p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <strong>Tags:</strong>
                                <div id="quickViewTags"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editProductFromQuickView()">Edit Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product? This action cannot be undone.</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        This will also remove all associated labels and translations.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Product</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('panel-assets/js/products.js') }}"></script>
@endsection
