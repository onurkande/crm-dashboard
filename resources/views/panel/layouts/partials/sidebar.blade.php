<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span class="sidebar-brand">🏷️ labeltranslate</span>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="mobile-close-btn" id="mobileCloseBtn">
            <i class="bi bi-x"></i>
        </button>
    </div>
    
    <div class="sidebar-content">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('panel.dashboard') ? 'active' : '' }}" href="{{ route('panel.dashboard') }}">
                <i class="bi bi-house"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('panel.products') ? 'active' : '' }}" href="{{ route('panel.products') }}">
                <i class="bi bi-box"></i>
                <span class="nav-text">Products</span>
            </a>
            <a class="nav-link {{ request()->routeIs('panel.add-product') ? 'active' : '' }}" href="{{ route('panel.add-product') }}">
                <i class="bi bi-plus-circle"></i>
                <span class="nav-text">Add Products</span>
            </a>
            <!--<a class="nav-link {{ request()->routeIs('panel.template-editor.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span class="nav-text">Templates</span>
            </a>
            <a class="nav-link {{ request()->routeIs('panel.preview-export.*') ? 'active' : '' }}">
                <i class="bi bi-printer"></i>
                <span class="nav-text">Print Jobs</span>
            </a>-->
            <a class="nav-link {{ request()->routeIs('panel.statistics-reports') ? 'active' : '' }}" href="{{ route('panel.statistics-reports') }}">
                <i class="bi bi-bar-chart"></i>
                <span class="nav-text">Analytics</span>
            </a>
            <a class="nav-link {{ request()->routeIs('panel.label-scheduler') ? 'active' : '' }}" href="{{ route('panel.label-scheduler') }}">
                <i class="bi bi-calendar-check"></i>
                <span class="nav-text">Scheduler</span>
            </a>
        </nav>
        </nav>
    </div>
    
    <div class="sidebar-footer">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('panel.account-settings') ? 'active' : '' }}" href="{{ route('panel.account-settings') }}">
                <i class="bi bi-gear"></i>
                <span class="nav-text">Settings</span>
            </a>
            <a class="nav-link {{ request()->routeIs('panel.support-help-center') ? 'active' : '' }}" href="{{ route('panel.support-help-center') }}">
                <i class="bi bi-question-circle"></i>
                <span class="nav-text">Help Center</span>
            </a>
        </nav>
    </div>
</div>