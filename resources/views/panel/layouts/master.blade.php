<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('panel-assets/img/favicon-translation.png') }}">
    @yield('css')
    @yield('meta')
</head>
<body>
    <!-- Sidebar -->
    @include('panel.layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Sidebar Expand Button (when collapsed) -->
        <button class="sidebar-expand-btn" id="sidebarExpandBtn">
            <i class="bi bi-list"></i>
        </button>

        <!-- Top Navigation -->
        @include('panel.layouts.partials.navbar')

        <!-- Page Content -->
        @yield('content')
    </div>

    @yield('modals')

    <!-- Chat Button -->
    <button class="chat-fab" id="chatFab">
        <i class="bi bi-chat-dots"></i>
    </button>

    <!-- Chat Modal -->
    <div class="chat-modal" id="chatModal">
        <div class="chat-header">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <i class="bi bi-robot me-2"></i>
                    <div>
                        <h6 class="mb-0">AI Assistant</h6>
                        <small class="text-white-50">Online</small>
                    </div>
                </div>
                <button class="btn btn-link text-white p-0" id="closeChatModal">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
        
        <div class="chat-body" id="chatBody">
            <div class="chat-message bot">
                <div class="message-bubble">
                    Hello! I'm your AI assistant. How can I help you with your label management today?
                </div>
                <small class="text-muted">Just now</small>
            </div>
        </div>
        
        <div class="chat-footer">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Type your message..." id="chatInput">
                <button class="btn btn-primary" id="sendMessage">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @yield('js')
</body>
</html>