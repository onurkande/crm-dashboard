@extends('panel.layouts.master')

@section('title', 'Label Scheduler')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/label-scheduler.css') }}">
@endsection

@section('meta')
    <meta name="description" content="Label Scheduler">
    <meta name="keywords" content="Label Scheduler">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <!-- Page Content -->
    <div class="container-fluid p-4">
        <div class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Label Planner & Scheduler</h1>
                    <p class="text-muted mb-0">Automate your label production with intelligent scheduling</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" id="importScheduleBtn">
                        <i class="bi bi-upload me-1"></i> Import Schedule
                    </button>
                    <button class="btn btn-primary" id="createScheduleBtn">
                        <i class="bi bi-plus-circle me-1"></i> Create New Schedule
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Active Schedules</h6>
                                    <h2 class="fw-bold mb-0">12</h2>
                                    <small class="text-white-50">+3 this week</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-calendar-check"></i>
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
                                    <h6 class="card-subtitle mb-2 text-white-50">Completed Today</h6>
                                    <h2 class="fw-bold mb-0">847</h2>
                                    <small class="text-white-50">Labels produced</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-check-circle"></i>
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
                                    <h6 class="card-subtitle mb-2 text-white-50">Upcoming Jobs</h6>
                                    <h2 class="fw-bold mb-0">24</h2>
                                    <small class="text-white-50">Next 7 days</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-clock"></i>
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
                                    <h6 class="card-subtitle mb-2 text-white-50">Success Rate</h6>
                                    <h2 class="fw-bold mb-0">98.5%</h2>
                                    <small class="text-white-50">Last 30 days</small>
                                </div>
                                <div class="fs-1 text-white-50">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Active Schedules -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-calendar-week me-2"></i>Active Schedules
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary btn-sm" id="pauseAllBtn">
                                    <i class="bi bi-pause"></i> Pause All
                                </button>
                                <button class="btn btn-outline-primary btn-sm" id="refreshSchedulesBtn">
                                    <i class="bi bi-arrow-clockwise"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="schedulesList">
                                <!-- Schedule Item 1 -->
                                <div class="schedule-item active" data-schedule-id="1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <h6 class="fw-bold mb-0">Weekly Coffee Labels</h6>
                                                <span class="status-badge active">
                                                    <i class="bi bi-play-circle"></i>
                                                    Active
                                                </span>
                                            </div>
                                            <p class="text-muted mb-2">Produces 500 coffee labels every Monday at 10:00 AM</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Template: Modern Layout</small>
                                                    <small class="text-muted d-block">Products: 3 selected</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Next Run: Monday, 10:00 AM</small>
                                                    <small class="text-muted d-block">Last Run: 2 days ago (Success)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-controls">
                                            <button class="btn btn-outline-warning btn-sm" onclick="pauseSchedule(1)">
                                                <i class="bi bi-pause"></i>
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="runNow(1)">
                                                <i class="bi bi-play"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm" onclick="editSchedule(1)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteSchedule(1)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Schedule Item 2 -->
                                <div class="schedule-item active" data-schedule-id="2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <h6 class="fw-bold mb-0">Daily Tea Collection</h6>
                                                <span class="status-badge active">
                                                    <i class="bi bi-play-circle"></i>
                                                    Active
                                                </span>
                                            </div>
                                            <p class="text-muted mb-2">Produces 200 tea labels daily at 2:00 PM</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Template: Classic Layout</small>
                                                    <small class="text-muted d-block">Products: 5 selected</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Next Run: Today, 2:00 PM</small>
                                                    <small class="text-muted d-block">Last Run: Yesterday (Success)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-controls">
                                            <button class="btn btn-outline-warning btn-sm" onclick="pauseSchedule(2)">
                                                <i class="bi bi-pause"></i>
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="runNow(2)">
                                                <i class="bi bi-play"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm" onclick="editSchedule(2)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteSchedule(2)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Schedule Item 3 -->
                                <div class="schedule-item paused" data-schedule-id="3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <h6 class="fw-bold mb-0">Monthly Chocolate Labels</h6>
                                                <span class="status-badge paused">
                                                    <i class="bi bi-pause-circle"></i>
                                                    Paused
                                                </span>
                                            </div>
                                            <p class="text-muted mb-2">Produces 1000 chocolate labels first Monday of each month</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Template: Minimal Layout</small>
                                                    <small class="text-muted d-block">Products: 2 selected</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Next Run: First Monday of next month</small>
                                                    <small class="text-muted d-block">Last Run: Last month (Success)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-controls">
                                            <button class="btn btn-outline-success btn-sm" onclick="resumeSchedule(3)">
                                                <i class="bi bi-play"></i>
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="runNow(3)">
                                                <i class="bi bi-play"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm" onclick="editSchedule(3)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteSchedule(3)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Execution History -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-clock-history me-2"></i>Execution History
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="history-log">
                                <div class="log-entry">
                                    <div class="d-flex align-items-center">
                                        <div class="log-icon success">
                                            <i class="bi bi-check"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Weekly Coffee Labels</div>
                                            <small class="text-muted">500 labels produced successfully</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small">Dec 4, 2024</div>
                                        <div class="small text-muted">10:00 AM</div>
                                    </div>
                                </div>

                                <div class="log-entry">
                                    <div class="d-flex align-items-center">
                                        <div class="log-icon success">
                                            <i class="bi bi-check"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Daily Tea Collection</div>
                                            <small class="text-muted">200 labels produced successfully</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small">Dec 5, 2024</div>
                                        <div class="small text-muted">2:00 PM</div>
                                    </div>
                                </div>

                                <div class="log-entry">
                                    <div class="d-flex align-items-center">
                                        <div class="log-icon warning">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Skincare Labels</div>
                                            <small class="text-muted">Partial completion - 150/300 labels</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small">Dec 3, 2024</div>
                                        <div class="small text-muted">3:30 PM</div>
                                    </div>
                                </div>

                                <div class="log-entry">
                                    <div class="d-flex align-items-center">
                                        <div class="log-icon error">
                                            <i class="bi bi-x"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Spice Labels</div>
                                            <small class="text-muted">Failed - Template not found</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small">Dec 2, 2024</div>
                                        <div class="small text-muted">11:15 AM</div>
                                    </div>
                                </div>

                                <div class="log-entry">
                                    <div class="d-flex align-items-center">
                                        <div class="log-icon success">
                                            <i class="bi bi-check"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Monthly Chocolate Labels</div>
                                            <small class="text-muted">1000 labels produced successfully</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small">Dec 1, 2024</div>
                                        <div class="small text-muted">9:00 AM</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Calendar Widget -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-calendar3 me-2"></i>Schedule Calendar
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="calendar-widget">
                                <div class="calendar-header">
                                    <button class="btn btn-sm btn-outline-secondary" id="prevMonth">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <h6 class="mb-0" id="currentMonth">December 2024</h6>
                                    <button class="btn btn-sm btn-outline-secondary" id="nextMonth">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                                
                                <div class="calendar-grid" id="calendarGrid">
                                    <!-- Calendar days will be generated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-lightning me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="quickScheduleBtn">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Quick Schedule
                                </button>
                                
                                <button class="btn btn-outline-success" id="runAllActiveBtn">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Run All Active
                                </button>
                                
                                <button class="btn btn-outline-warning" id="pauseAllActiveBtn">
                                    <i class="bi bi-pause-circle me-2"></i>
                                    Pause All Active
                                </button>
                                
                                <button class="btn btn-outline-info" id="exportSchedulesBtn">
                                    <i class="bi bi-download me-2"></i>
                                    Export Schedules
                                </button>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>System Status:</span>
                                    <span class="text-success">
                                        <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                                        Online
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Queue Status:</span>
                                    <span class="text-info">3 pending</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Last Sync:</span>
                                    <span>2 min ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Create/Edit Schedule Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalTitle">Create New Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm">
                        <!-- Plan Name -->
                        <div class="mb-3">
                            <label for="planName" class="form-label">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="planName" required 
                                   placeholder="e.g., Weekly Coffee Labels">
                        </div>

                        <!-- Label Template Selection -->
                        <div class="mb-3">
                            <label class="form-label">Label Template <span class="text-danger">*</span></label>
                            <div class="template-selector">
                                <div class="template-card" data-template="modern">
                                    <div class="template-preview">
                                        <i class="bi bi-file-earmark-text text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <div class="fw-semibold">Modern Layout</div>
                                    <small class="text-muted">Clean design</small>
                                </div>

                                <div class="template-card" data-template="classic">
                                    <div class="template-preview">
                                        <i class="bi bi-file-earmark-text text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <div class="fw-semibold">Classic Layout</div>
                                    <small class="text-muted">Traditional</small>
                                </div>

                                <div class="template-card" data-template="minimal">
                                    <div class="template-preview">
                                        <i class="bi bi-file-earmark-text text-info" style="font-size: 2rem;"></i>
                                    </div>
                                    <div class="fw-semibold">Minimal Layout</div>
                                    <small class="text-muted">Simple</small>
                                </div>
                            </div>
                            <input type="hidden" id="selectedTemplate" name="template" required>
                        </div>

                        <!-- Product Selection -->
                        <div class="mb-3">
                            <label class="form-label">Product Selection <span class="text-danger">*</span></label>
                            <div class="product-selector" id="productSelector">
                                <i class="bi bi-images text-primary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2 mb-1">Select Products</h6>
                                <p class="text-muted mb-2">Click to choose products for this schedule</p>
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i> Add Products
                                </button>
                            </div>
                            <div class="product-grid" id="selectedProducts">
                                <!-- Selected products will appear here -->
                            </div>
                        </div>

                        <!-- Schedule Settings -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="startDate" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="startDate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="startTime" class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="startTime" required>
                            </div>
                        </div>

                        <!-- Repeat Frequency -->
                        <div class="mb-3">
                            <label for="repeatFrequency" class="form-label">Repeat Frequency <span class="text-danger">*</span></label>
                            <select class="form-select" id="repeatFrequency" required>
                                <option value="">Select frequency...</option>
                                <option value="once">Once (No repeat)</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>

                        <!-- End Date -->
                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date (Optional)</label>
                            <input type="date" class="form-control" id="endDate">
                            <small class="form-text text-muted">Leave empty for unlimited recurrence</small>
                        </div>

                        <!-- Label Quantity -->
                        <div class="mb-3">
                            <label for="labelQuantity" class="form-label">Label Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="labelQuantity" required min="1" 
                                   placeholder="e.g., 500">
                        </div>

                        <!-- Notification Settings -->
                        <div class="mb-3">
                            <label class="form-label">Notification Preferences</label>
                            <div class="notification-settings">
                                <div class="notification-option">
                                    <input class="form-check-input" type="checkbox" id="emailNotification" checked>
                                    <i class="bi bi-envelope text-primary"></i>
                                    <div>
                                        <div class="fw-semibold">Email Notification</div>
                                        <small class="text-muted">Get notified via email when jobs complete</small>
                                    </div>
                                </div>

                                <div class="notification-option">
                                    <input class="form-check-input" type="checkbox" id="systemNotification" checked>
                                    <i class="bi bi-bell text-info"></i>
                                    <div>
                                        <div class="fw-semibold">In-System Notification</div>
                                        <small class="text-muted">Show notifications in the dashboard</small>
                                    </div>
                                </div>

                                <div class="notification-option">
                                    <input class="form-check-input" type="checkbox" id="smsNotification">
                                    <i class="bi bi-phone text-success"></i>
                                    <div>
                                        <div class="fw-semibold">SMS Notification</div>
                                        <small class="text-muted">Send SMS alerts (if available)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveScheduleBtn">
                        <i class="bi bi-check-circle me-1"></i> Save Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('panel-assets/js/label-scheduler.js') }}"></script>
@endsection