@extends('panel.layouts.master')

@section('title', 'Faulty Translations')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/products.css') }}">
@endsection

@section('meta')
    <meta name="description" content="Faulty Translations">
    <meta name="keywords" content="Faulty Translations">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div id="faultyTranslationsPage" class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Faulty Translations</h1>
                    <p class="text-muted mb-0">Manage products with translation issues</p>
                </div>
                <div class="d-flex action-buttons">
                    <a href="{{ route('panel.products') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Products
                    </a>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="filter-section">
                <form id="filterForm" method="GET" action="{{ route('panel.faulty-translations') }}">
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
                            <label class="form-label">Error Type</label>
                            <select class="form-select" name="error_type">
                                <option value="">All</option>
                                <option value="grammar" {{ request('error_type') == 'grammar' ? 'selected' : '' }}>Grammar Error</option>
                                <option value="meaning" {{ request('error_type') == 'meaning' ? 'selected' : '' }}>Meaning Error</option>
                                <option value="formatting" {{ request('error_type') == 'formatting' ? 'selected' : '' }}>Formatting Issue</option>
                                <option value="missing" {{ request('error_type') == 'missing' ? 'selected' : '' }}>Missing Translation</option>
                                <option value="other" {{ request('error_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search products...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <a href="{{ route('panel.faulty-translations') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">Products with Translation Issues</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="faultyTranslationsTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th width="80">Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Error Type</th>
                                    <th>Description</th>
                                    <th>Original Language</th>
                                    <th>Target Language</th>
                                    <th>Reported At</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
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
                                        <span class="badge bg-danger">{{ ucfirst($product->faultyProducts->first()->error_type) }}</span>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($product->faultyProducts->first()->description, 50) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $product->original_lang }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $product->target_lang }}</span>
                                    </td>
                                    <td>
                                        {{ $product->faultyProducts->first()->created_at->format('Y-m-d H:i') }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('panel.template-editor', ['product' => $product->id]) }}" class="btn btn-outline-primary" title="Fix Translation">
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
    <!-- Delete Confirmation Modal -->
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
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('panel-assets/js/products.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(function() {
                    const alert = bootstrap.Alert.getOrCreateInstance(successAlert);
                    alert.close();
                }, 5000);
            }

            // Initialize Select2 for multiple select
            if (document.querySelector('select[name="categories[]"]')) {
                $('select[name="categories[]"]').select2({
                    placeholder: 'Select categories',
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>
@endsection 