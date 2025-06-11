@extends('panel.layouts.master')

@section('title', 'Statistics & Reports')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/statistics-reports.css') }}">
@endsection

@section('meta')
    <meta name="description" content="Statistics & Reports">
    <meta name="keywords" content="Statistics & Reports">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        <div class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Statistics & Reports</h1>
                    <p class="text-muted mb-0">Comprehensive analytics and insights for your label production</p>
                </div>
                <div class="export-buttons">
                    <a href="#" class="export-btn" id="exportExcelBtn">
                        <i class="bi bi-file-earmark-excel text-success"></i>
                        Export Excel
                    </a>
                    <a href="#" class="export-btn" id="exportPdfBtn">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        Export PDF
                    </a>
                    <button class="btn btn-primary" id="generateReportBtn">
                        <i class="bi bi-plus-circle me-1"></i> Generate Custom Report
                    </button>
                </div>
            </div>

            <!-- Time Range Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">
                            <i class="bi bi-calendar-range me-2"></i>Time Range Filter
                        </h6>
                        <button class="btn btn-outline-secondary btn-sm" id="resetFiltersBtn">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </button>
                    </div>
                    
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-period="today">Today</button>
                        <button class="filter-tab" data-period="week">This Week</button>
                        <button class="filter-tab" data-period="month">This Month</button>
                        <button class="filter-tab" data-period="year">This Year</button>
                        <button class="filter-tab" data-period="custom">Custom Range</button>
                    </div>
                    
                    <div class="row" id="customDateRange" style="display: none;">
                        <div class="col-md-4">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn btn-primary d-block" id="applyCustomRange">Apply Range</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Dashboard -->
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Total Labels</h6>
                                    <h2 class="fw-bold mb-0" id="totalLabels">12,847</h2>
                                    <small class="text-white-50">+15% from last period</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-tags"></i>
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
                                    <h6 class="card-subtitle mb-2 text-white-50">OCR Success Rate</h6>
                                    <h2 class="fw-bold mb-0" id="ocrSuccessRate">94.2%</h2>
                                    <small class="text-white-50">+2.1% improvement</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-eye"></i>
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
                                    <h6 class="card-subtitle mb-2 text-white-50">Total Cost</h6>
                                    <h2 class="fw-bold mb-0" id="totalCost">$2,847</h2>
                                    <small class="text-white-50">OCR + Translation</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-currency-dollar"></i>
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
                                    <h6 class="card-subtitle mb-2 text-white-50">Languages</h6>
                                    <h2 class="fw-bold mb-0" id="languageCount">12</h2>
                                    <small class="text-white-50">Active translations</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-translate"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Label Production Chart -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-graph-up me-2"></i>Label Production Trends
                            </h5>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-gear me-1"></i> Chart Options
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-chart-type="bar">Bar Chart</a></li>
                                    <li><a class="dropdown-item" href="#" data-chart-type="line">Line Chart</a></li>
                                    <li><a class="dropdown-item" href="#" data-chart-type="area">Area Chart</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="productionChart" class="chart-container large"></canvas>
                        </div>
                    </div>

                    <!-- Category Distribution -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-pie-chart me-2"></i>Label Generation by Category
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="categoryChart" class="chart-container"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <div class="progress-metric">
                                        <div class="d-flex justify-content-between">
                                            <span class="metric-label">Food & Beverages</span>
                                            <span class="metric-value">4,523 (35.2%)</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 35.2%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="progress-metric">
                                        <div class="d-flex justify-content-between">
                                            <span class="metric-label">Cosmetics</span>
                                            <span class="metric-value">3,124 (24.3%)</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 24.3%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="progress-metric">
                                        <div class="d-flex justify-content-between">
                                            <span class="metric-label">Electronics</span>
                                            <span class="metric-value">2,847 (22.2%)</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: 22.2%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="progress-metric">
                                        <div class="d-flex justify-content-between">
                                            <span class="metric-label">Clothing</span>
                                            <span class="metric-value">1,523 (11.9%)</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 11.9%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="progress-metric">
                                        <div class="d-flex justify-content-between">
                                            <span class="metric-label">Others</span>
                                            <span class="metric-value">830 (6.4%)</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" style="width: 6.4%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Activity Heatmap -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-calendar-heat me-2"></i>User Activity Heatmap
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Activity levels throughout the day (24-hour format)</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">00:00</small>
                                <small class="text-muted">12:00</small>
                                <small class="text-muted">23:00</small>
                            </div>
                            <div class="heatmap-container" id="activityHeatmap">
                                <!-- Heatmap cells will be generated by JavaScript -->
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">Less</small>
                                <div class="d-flex gap-1">
                                    <div class="heatmap-cell level-0"></div>
                                    <div class="heatmap-cell level-1"></div>
                                    <div class="heatmap-cell level-2"></div>
                                    <div class="heatmap-cell level-3"></div>
                                    <div class="heatmap-cell level-4"></div>
                                    <div class="heatmap-cell level-5"></div>
                                </div>
                                <small class="text-muted">More</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Translation Statistics -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-translate me-2"></i>Translation Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="language-stats">
                                <div class="language-item">
                                    <span class="language-flag">🇪🇸</span>
                                    <div>
                                        <div class="fw-semibold">Spanish</div>
                                        <small class="text-muted">3,247 translations</small>
                                    </div>
                                </div>
                                
                                <div class="language-item">
                                    <span class="language-flag">🇫🇷</span>
                                    <div>
                                        <div class="fw-semibold">French</div>
                                        <small class="text-muted">2,891 translations</small>
                                    </div>
                                </div>
                                
                                <div class="language-item">
                                    <span class="language-flag">🇩🇪</span>
                                    <div>
                                        <div class="fw-semibold">German</div>
                                        <small class="text-muted">2,456 translations</small>
                                    </div>
                                </div>
                                
                                <div class="language-item">
                                    <span class="language-flag">🇮🇹</span>
                                    <div>
                                        <div class="fw-semibold">Italian</div>
                                        <small class="text-muted">1,923 translations</small>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="metric-item">
                                <span class="metric-label">Translation Errors</span>
                                <span class="metric-value text-warning">127 (2.8%)</span>
                            </div>
                            
                            <div class="metric-item">
                                <span class="metric-label">Avg. Processing Time</span>
                                <span class="metric-value">1.2s</span>
                            </div>
                            
                            <div class="metric-item">
                                <span class="metric-label">Characters Processed</span>
                                <span class="metric-value">2.4M</span>
                            </div>
                        </div>
                    </div>

                    <!-- Template Usage -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-file-earmark-text me-2"></i>Template Usage Report
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="template-usage">
                                <div class="template-item">
                                    <div class="template-preview">
                                        <i class="bi bi-file-earmark-text text-primary"></i>
                                    </div>
                                    <div class="fw-semibold">Modern</div>
                                    <small class="text-muted">5,247 uses</small>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div class="progress-bar" style="width: 85%"></div>
                                    </div>
                                </div>
                                
                                <div class="template-item">
                                    <div class="template-preview">
                                        <i class="bi bi-file-earmark-text text-success"></i>
                                    </div>
                                    <div class="fw-semibold">Classic</div>
                                    <small class="text-muted">3,891 uses</small>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 63%"></div>
                                    </div>
                                </div>
                                
                                <div class="template-item">
                                    <div class="template-preview">
                                        <i class="bi bi-file-earmark-text text-info"></i>
                                    </div>
                                    <div class="fw-semibold">Minimal</div>
                                    <small class="text-muted">2,456 uses</small>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div class="progress-bar bg-info" style="width: 40%"></div>
                                    </div>
                                </div>
                                
                                <div class="template-item">
                                    <div class="template-preview">
                                        <i class="bi bi-file-earmark-text text-warning"></i>
                                    </div>
                                    <div class="fw-semibold">Custom</div>
                                    <small class="text-muted">1,253 uses</small>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div class="progress-bar bg-warning" style="width: 20%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-currency-dollar me-2"></i>Cost Distribution
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="cost-breakdown">
                                <div class="cost-item">
                                    <div>
                                        <div class="fw-semibold">OCR Processing</div>
                                        <small class="text-muted">2.4M characters processed</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">$1,847</div>
                                        <small class="text-muted">64.8%</small>
                                    </div>
                                </div>
                                
                                <div class="cost-item success">
                                    <div>
                                        <div class="fw-semibold">Translation</div>
                                        <small class="text-muted">847K characters translated</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">$823</div>
                                        <small class="text-muted">28.9%</small>
                                    </div>
                                </div>
                                
                                <div class="cost-item warning">
                                    <div>
                                        <div class="fw-semibold">Storage & Processing</div>
                                        <small class="text-muted">Infrastructure costs</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">$177</div>
                                        <small class="text-muted">6.3%</small>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total Monthly Cost</span>
                                <span class="fw-bold text-primary fs-5">$2,847</span>
                            </div>
                            
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Estimated based on current usage patterns
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Reports Section -->
            <div class="row mt-4">
                <!-- Scheduler Success Rates -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-calendar-check me-2"></i>Scheduler Success Rates
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="schedulerChart"></canvas>
                            </div>
                            
                            <div class="mt-3">
                                <div class="metric-item">
                                    <span class="metric-label">Successful Executions</span>
                                    <span class="metric-value text-success">847 (94.2%)</span>
                                </div>
                                
                                <div class="metric-item">
                                    <span class="metric-label">Failed Executions</span>
                                    <span class="metric-value text-danger">23 (2.6%)</span>
                                </div>
                                
                                <div class="metric-item">
                                    <span class="metric-label">Skipped/Paused</span>
                                    <span class="metric-value text-warning">29 (3.2%)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OCR Error Samples -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>OCR Error Samples
                            </h6>
                            <button class="btn btn-outline-primary btn-sm" id="viewAllErrorsBtn">
                                View All
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="error-sample">
                                <div class="d-flex gap-3">
                                    <img src="/placeholder.svg?height=80&width=80&text=Blurry+Image" 
                                        alt="Error Sample" class="error-image">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">Low Image Quality</div>
                                        <small class="text-muted">product_image_001.jpg</small>
                                        <p class="mb-2 small">Image resolution too low for accurate text recognition</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Retry
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-pencil me-1"></i> Manual Edit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="error-sample">
                                <div class="d-flex gap-3">
                                    <img src="/placeholder.svg?height=80&width=80&text=Complex+Layout" 
                                        alt="Error Sample" class="error-image">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">Complex Layout</div>
                                        <small class="text-muted">product_image_045.jpg</small>
                                        <p class="mb-2 small">Multiple text regions with overlapping elements</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Retry
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-pencil me-1"></i> Manual Edit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Showing 2 of 23 failed OCR attempts
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Custom Report Modal -->
    <div class="modal fade" id="customReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Custom Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="customReportForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Report Type</label>
                                <select class="form-select" id="reportType">
                                    <option value="summary">Executive Summary</option>
                                    <option value="detailed">Detailed Analytics</option>
                                    <option value="cost">Cost Analysis</option>
                                    <option value="performance">Performance Report</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date Range</label>
                                <select class="form-select" id="reportDateRange">
                                    <option value="week">Last 7 Days</option>
                                    <option value="month">Last 30 Days</option>
                                    <option value="quarter">Last 3 Months</option>
                                    <option value="year">Last 12 Months</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Include Sections</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeProduction" checked>
                                        <label class="form-check-label" for="includeProduction">
                                            Production Statistics
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeCosts" checked>
                                        <label class="form-check-label" for="includeCosts">
                                            Cost Analysis
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeOCR" checked>
                                        <label class="form-check-label" for="includeOCR">
                                            OCR Performance
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeTranslation" checked>
                                        <label class="form-check-label" for="includeTranslation">
                                            Translation Stats
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeScheduler">
                                        <label class="form-check-label" for="includeScheduler">
                                            Scheduler Performance
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeErrors">
                                        <label class="form-check-label" for="includeErrors">
                                            Error Analysis
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email Recipients (Optional)</label>
                            <input type="email" class="form-control" placeholder="Enter email addresses separated by commas">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="generateCustomReportBtn">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('panel-assets/js/statistics-reports.js') }}"></script>
@endsection