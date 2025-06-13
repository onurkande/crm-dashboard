@extends('panel.layouts.master')

@section('title', 'Dashboard')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/index.css') }}">
@endsection

@section('meta')
    <meta name="description" content="LabelCraft Dashboard">
    <meta name="keywords" content="LabelCraft, Dashboard, Label Management">
    <meta name="author" content="LabelCraft">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        <!-- Dashboard Page -->
        <div id="dashboardPage" class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold">Dashboard Overview</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-download me-1"></i> Export Report
                    </button>
                    <a href="{{ route('panel.add-product') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Create New Label
                    </a>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Total Products</h6>
                                    <h2 class="fw-bold mb-0">1,247</h2>
                                    <small class="text-white-50">+12% from last month</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-box"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Labels Created</h6>
                                    <h2 class="fw-bold mb-0">8,924</h2>
                                    <small class="text-white-50">+28% from last month</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-tags"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Planned Jobs</h6>
                                    <h2 class="fw-bold mb-0">156</h2>
                                    <small class="text-white-50">+5% from last week</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Recent Translations</h6>
                                    <h2 class="fw-bold mb-0">342</h2>
                                    <small class="text-white-50">+18% from last week</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-translate"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <h5 class="fw-semibold mb-3">Quick Actions</h5>
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <div class="card quick-action-card h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-plus-circle text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h6 class="card-title">Create New Label</h6>
                                    <p class="card-text text-muted small">Start creating labels from product images</p>
                                    <a href="{{ route('panel.add-product') }}" class="btn btn-primary btn-sm">Create Now</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="card quick-action-card h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-cloud-upload text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <h6 class="card-title">Bulk Upload</h6>
                                    <p class="card-text text-muted small">Upload multiple product images at once</p>
                                    <button class="btn btn-success btn-sm">Upload Files</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="card quick-action-card h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-translate text-info" style="font-size: 2rem;"></i>
                                    </div>
                                    <h6 class="card-title">Auto Translate</h6>
                                    <p class="card-text text-muted small">Translate existing labels to new languages</p>
                                    <button class="btn btn-info btn-sm">Translate</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="card quick-action-card h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-graph-up-arrow text-danger" style="font-size: 2rem;"></i>
                                    </div>
                                    <h6 class="card-title">Analytics</h6>
                                    <p class="card-text text-muted small">Track print history and usage</p>
                                    <a href="{{ route('panel.statistics-reports') }}" class="btn btn-danger btn-sm">View Stats</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Analytics -->
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">Daily Labeling Activity (Last 30 Days)</h6>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    Last 30 Days
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="dailyChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Recent System Messages</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-check text-white small"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Translation batch completed</h6>
                                            <p class="mb-1 text-muted small">50 labels translated to French</p>
                                            <small class="text-muted">5 minutes ago</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-robot text-white small"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">OCR processing finished</h6>
                                            <p class="mb-1 text-muted small">12 new products processed</p>
                                            <small class="text-muted">1 hour ago</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-printer text-white small"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Print job scheduled</h6>
                                            <p class="mb-1 text-muted small">1000 labels queued for printing</p>
                                            <small class="text-muted">2 hours ago</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-exclamation-triangle text-white small"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Template update required</h6>
                                            <p class="mb-1 text-muted small">5 templates need updating</p>
                                            <small class="text-muted">3 hours ago</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn btn-outline-primary btn-sm w-100 mt-3">View All Messages</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="row g-4 mt-2">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Monthly Summary</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Most Printed Products</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Premium Coffee Blend</span>
                                        <span class="fw-bold">2,847 labels</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar" style="width: 85%"></div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Organic Tea Collection</span>
                                        <span class="fw-bold">1,923 labels</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 68%"></div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Artisan Chocolate</span>
                                        <span class="fw-bold">1,456 labels</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-info" style="width: 52%"></div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Natural Skincare</span>
                                        <span class="fw-bold">1,098 labels</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-warning" style="width: 39%"></div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Gourmet Spices</span>
                                        <span class="fw-bold">876 labels</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-danger" style="width: 31%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Pages (Placeholder) -->
        <div id="labelsPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Label Management</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-tags display-1 text-muted"></i>
                    <h4 class="mt-3">Label Management</h4>
                    <p class="text-muted">Create, edit and manage your product labels.</p>
                </div>
            </div>
        </div>

        <div id="productsPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Product Management</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-box display-1 text-muted"></i>
                    <h4 class="mt-3">Product Catalog</h4>
                    <p class="text-muted">Manage your product database and information.</p>
                </div>
            </div>
        </div>

        <div id="templatesPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Label Templates</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                    <h4 class="mt-3">Design Templates</h4>
                    <p class="text-muted">Create and customize label templates for printing.</p>
                </div>
            </div>
        </div>

        <div id="translationsPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Translation Center</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-translate display-1 text-muted"></i>
                    <h4 class="mt-3">Multi-language Support</h4>
                    <p class="text-muted">Translate labels to different languages automatically.</p>
                </div>
            </div>
        </div>

        <div id="print-jobsPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Print Jobs</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-printer display-1 text-muted"></i>
                    <h4 class="mt-3">Print Queue Management</h4>
                    <p class="text-muted">Monitor and manage your print jobs.</p>
                </div>
            </div>
        </div>

        <div id="analyticsPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Analytics & Reports</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-bar-chart display-1 text-muted"></i>
                    <h4 class="mt-3">Detailed Analytics</h4>
                    <p class="text-muted">View comprehensive reports and analytics.</p>
                </div>
            </div>
        </div>

        <div id="ai-toolsPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">AI Tools</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-robot display-1 text-muted"></i>
                    <h4 class="mt-3">AI-Powered Features</h4>
                    <p class="text-muted">OCR, translation, and smart label generation tools.</p>
                </div>
            </div>
        </div>

        <div id="settingsPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Settings</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-gear display-1 text-muted"></i>
                    <h4 class="mt-3">System Settings</h4>
                    <p class="text-muted">Configure your application preferences.</p>
                </div>
            </div>
        </div>

        <div id="helpPage" class="page-content d-none">
            <h1 class="h3 mb-4 fw-bold">Help Center</h1>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-question-circle display-1 text-muted"></i>
                    <h4 class="mt-3">Support & Documentation</h4>
                    <p class="text-muted">Get help and learn how to use the platform.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('panel-assets/js/index.js') }}"></script>
@endsection
