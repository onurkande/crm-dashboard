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
            </div>

            <!-- Key Metrics Dashboard -->
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Total Labels</h6>
                                    <h2 class="fw-bold mb-0" id="totalLabels">{{ $productCount }}</h2>
                                    <small class="text-white-50">{{ $productPercentageChange }}% from last period</small>
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
                                    <h2 class="fw-bold mb-0" id="ocrSuccessRate">{{ $current_rate }}%</h2>
                                    <small class="text-white-50">{{ $improvement }}% improvement</small>
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
                                    <h2 class="fw-bold mb-0" id="languageCount">{{ $distinctLanguagesCount }}</h2>
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
                                    @foreach ($getTopCategoriesStats as $category)
                                        <div class="progress-metric">
                                            <div class="d-flex justify-content-between">
                                                <span class="metric-label">{{ $category['name'] }}</span>
                                                <span class="metric-value">{{ $category['product_count'] }} ({{ $category['percentage'] }}%)</span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: {{ $category['percentage'] }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
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
                                @foreach ($topLanguages as $language)
                                <div class="language-item">
                                    <span class="language-flag">{{ $language->target_lang }}</span>
                                    <div>
                                        <div class="fw-semibold">{{ $language->getTargetLanguageName() }}</div>
                                        <small class="text-muted">{{ $language->count }} translations</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="metric-item">
                                <span class="metric-label">Translation Errors:</span>
                                <span class="metric-value text-warning">{{ $translationErrorsCount }} ({{ $translationErrorsPercentage }}%)</span>
                            </div>
                            
                            <div class="metric-item">
                                <span class="metric-label">Words Processed</span>
                                <span class="metric-value">{{ $totalUntranslatedWords }}</span>
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
                <!-- OCR Error Samples -->
                @if ($faultyProducts->count() > 0)
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="fw-semibold mb-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>OCR Error Samples
                                </h6>
                                <a href="{{ route('panel.faulty-translations') }}" class="btn btn-outline-primary btn-sm" id="viewAllErrorsBtn">
                                    View All
                                </a>
                            </div>
                            <div class="card-body">
                                @foreach ($faultyProducts as $faultyProduct)
                                    <div class="error-sample">
                                        <div class="d-flex gap-3">
                                            <img src="{{ asset('storage/' . $faultyProduct->product->image) }}" 
                                                alt="Error Sample" class="error-image">
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">{{ $faultyProduct->product->name }}</div>
                                                <small class="text-muted">{{ $faultyProduct->product->image }}</small>
                                                <p class="mb-2 small">{{ $faultyProduct->description }}</p>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('panel.template-editor', $faultyProduct->product->id) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-arrow-clockwise me-1"></i> Retry
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                @endforeach
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        Showing {{ $translationErrorsCount }} of {{ $productCount }} failed OCR attempts
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('modals')

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.monthlyTranslationCounts = @json(array_values($getMonthlyTranslationCounts));
        window.categoryStats = @json($getTopCategoriesStats);
        window.hourlyActivityHeatmap = @json(array_values($getHourlyActivityHeatmap));
    </script>
    <script src="{{ asset('panel-assets/js/statistics-reports.js') }}"></script>
@endsection