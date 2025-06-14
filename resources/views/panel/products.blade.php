@extends('panel.layouts.master')

@section('title', 'Products')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/products.css') }}">
    <style>
        /* Pagination Styles */
        .pagination {
            margin: 0;
        }
        
        .page-link {
            color: #6c757d;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .page-link:hover {
            color: #0d6efd;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }
        
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
        
        .page-link i {
            font-size: 0.875rem;
        }
    </style>
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
        <!-- Success Message Alert -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Product Management Page -->
        <div id="productsPage" class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Product Management</h1>
                    <p class="text-muted mb-0">Manage your product catalog and information</p>
                </div>
                <div class="d-flex action-buttons">
                    <!--<button class="btn btn-outline-secondary" id="archivedProductsBtn">
                        <i class="bi bi-archive me-1"></i> Archived Products
                    </button>-->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('panel.products.export') }}">
                                    <i class="bi bi-file-earmark-excel me-2"></i>Export as Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('panel.add-product') }}" class="btn btn-primary" >
                        <i class="bi bi-plus-circle me-1"></i> Add New Product
                    </a>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="filter-section">
                <form id="filterForm" method="GET" action="{{ route('panel.products') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="categories[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, request('categories', [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date Range</label>
                            <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="From">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="To">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tag Status</label>
                            <select class="form-select" name="tag_status">
                                <option value="">All</option>
                                <option value="tagged" {{ request('tag_status') == 'tagged' ? 'selected' : '' }}>Tagged</option>
                                <option value="untagged" {{ request('tag_status') == 'untagged' ? 'selected' : '' }}>Untagged</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">Language Status</label>
                            <select class="form-select" name="language_status">
                                <option value="">All</option>
                                <option value="translated" {{ request('language_status') == 'translated' ? 'selected' : '' }}>Translated</option>
                                <option value="not-translated" {{ request('language_status') == 'not-translated' ? 'selected' : '' }}>Not Translated</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Barcode Type</label>
                            <select class="form-select" name="barcode_type">
                                <option value="">All</option>
                                <option value="qr" {{ request('barcode_type') == 'qr' ? 'selected' : '' }}>QR Code</option>
                                <option value="ean13" {{ request('barcode_type') == 'ean13' ? 'selected' : '' }}>EAN-13</option>
                                <option value="code128" {{ request('barcode_type') == 'code128' ? 'selected' : '' }}>Code 128</option>
                                <option value="upc" {{ request('barcode_type') == 'upc' ? 'selected' : '' }}>UPC</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search products...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <a href="{{ route('panel.products') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">Product Catalog</h6>
                    <div class="d-flex gap-2">
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
                                    <th>Id</th>
                                    <th width="80">Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Barcode</th>
                                    <th>Status</th>
                                    <th>Original Language</th>
                                    <th>Target Language</th>
                                    <th>Producer</th>
                                    <th>Importer</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input product-checkbox" value="{{ $product->id }}">
                                    </td>
                                    <td>
                                        {{ $product->id }}
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-thumbnail">
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <code>{{ $product->barcode }}</code>
                                            <br><small class="text-muted">{{ strtoupper($product->barcode_type) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <form action="{{ route('panel.products.status.update', $product->id) }}" method="POST" class="status-form">
                                                @csrf
                                                <input type="hidden" name="status" value="{{ $product->status === 'active' ? 'inactive' : 'active' }}">
                                                <input class="form-check-input quick-toggle" type="checkbox" 
                                                       {{ $product->status === 'active' ? 'checked' : '' }} 
                                                       onchange="this.form.submit()">
                                                <label class="form-check-label">
                                                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $product->status === 'active' ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </label>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $product->original_lang }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $product->target_lang }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $product->producer }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $product->importer }}</span>
                                    </td>
                                    <td>
                                        {{ $product->created_at->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quickViewModal{{ $product->id }}" title="Quick View">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <a href="{{ route('panel.template-editor', ['product' => $product->id]) }}" class="btn btn-outline-secondary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
@foreach($products as $product)
    <!-- Quick View Modal for each product -->
    <div class="modal fade" id="quickViewModal{{ $product->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $product->name }}</h4>
                            <p class="text-muted">{{ $product->category->name }}</p>
                            <p>{{ $product->description }}</p>
                            
                            @if($product->producer || $product->importer)
                            <div class="mt-3">
                                @if($product->producer)
                                <p class="mb-1"><strong>Producer:</strong> {{ $product->producer }}</p>
                                @endif
                                @if($product->importer)
                                <p class="mb-1"><strong>Importer:</strong> {{ $product->importer }}</p>
                                @endif
                            </div>
                            @endif
                            
                            <div class="row g-3 mt-3">
                                <div class="col-6">
                                    <strong>Barcode:</strong>
                                    <p>
                                        <code>{{ $product->barcode }}</code>
                                        <br>
                                        <small class="text-muted">{{ strtoupper($product->barcode_type) }}</small>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <strong>Status:</strong>
                                    <p>
                                        <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $product->status === 'active' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <strong>Original Language:</strong>
                                    <p>
                                        <span class="badge bg-primary">{{ $product->original_lang }}</span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <strong>Target Language:</strong>
                                    <p>
                                        <span class="badge bg-primary">{{ $product->target_lang }}</span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <strong>Created:</strong>
                                    <p>{{ $product->created_at->format('Y-m-d') }}</p>
                                </div>
                                @if($product->qr_code)
                                    <div class="col-6">
                                        <strong>Qr Code:</strong>
                                        <p>
                                            <span class="badge bg-primary">{{ $product->qr_code }}</span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('panel.preview-export', ['product' => $product->id]) }}" class="btn btn-primary">View Product</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal for each product -->
    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
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
                    <a href="{{ route('panel.products.delete', ['product' => $product->id]) }}" type="button" class="btn btn-danger">Delete Product</a>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Bulk Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <span id="selectedCount" class="fw-bold">0</span> selected products? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    This will also remove all associated labels and translations for the selected products.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('panel.products.bulk-delete') }}" method="POST" id="bulkDeleteForm">
                    @csrf
                    <input type="hidden" name="product_ids" id="productIds">
                    <button type="submit" class="btn btn-danger">Delete Selected Products</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('panel-assets/js/products.js') }}"></script>
    <script>
        // Auto dismiss success alert after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(function() {
                    const alert = bootstrap.Alert.getOrCreateInstance(successAlert);
                    alert.close();
                }, 5000);
            }

            // Bulk delete functionality
            const bulkDeleteBtn = document.querySelector('[onclick="bulkAction(\'delete\')"]');
            const bulkDeleteModal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
            const selectedCountSpan = document.getElementById('selectedCount');
            const productIdsInput = document.getElementById('productIds');

            bulkDeleteBtn.addEventListener('click', function() {
                const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');
                const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
                
                if (selectedIds.length === 0) {
                    alert('Please select at least one product to delete.');
                    return;
                }

                selectedCountSpan.textContent = selectedIds.length;
                productIdsInput.value = JSON.stringify(selectedIds);
                bulkDeleteModal.show();
            });
        });
    </script>
@endsection
