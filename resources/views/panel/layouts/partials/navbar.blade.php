<nav class="navbar navbar-expand-lg border-bottom">
  <div class="container-fluid">
      <!-- Mobile menu button -->
      <button class="btn btn-link d-lg-none" id="mobileMenuToggle">
          <i class="bi bi-list"></i>
      </button>
      
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="d-none d-md-block">
          <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page" id="currentPage">Dashboard</li>
          </ol>
      </nav>

      <!-- Right side items -->
      <div class="d-flex align-items-center gap-2">
          <!-- Language Selector -->
          <div class="dropdown language-selector">
              <button class="language-btn" type="button" data-bs-toggle="dropdown">
                  <i class="bi bi-globe"></i>
                  <span id="currentLanguage">EN</span>
                  <i class="bi bi-chevron-down"></i>
              </button>
              <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-lang="en">🇺🇸 English</a></li>
                  <li><a class="dropdown-item" href="#" data-lang="es">🇪🇸 Español</a></li>
                  <li><a class="dropdown-item" href="#" data-lang="fr">🇫🇷 Français</a></li>
                  <li><a class="dropdown-item" href="#" data-lang="de">🇩🇪 Deutsch</a></li>
                  <li><a class="dropdown-item" href="#" data-lang="tr">🇹🇷 Türkçe</a></li>
              </ul>
          </div>

          <!-- Notifications -->
          <div class="dropdown">
              <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown">
                  <i class="bi bi-bell"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      3
                      <span class="visually-hidden">unread messages</span>
                  </span>
              </button>
              <div class="dropdown-menu dropdown-menu-end" style="width: 350px;">
                  <h6 class="dropdown-header">Recent Notifications</h6>
                  <div class="px-3 py-2 border-bottom">
                      <div class="d-flex">
                          <div class="me-3">
                              <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                  <i class="bi bi-check text-white"></i>
                              </div>
                          </div>
                          <div class="flex-grow-1">
                              <p class="mb-1 fw-medium">Label Translation Complete</p>
                              <p class="mb-1 text-muted small">Product XYZ labels translated to Spanish</p>
                              <p class="mb-0 text-muted small">2 minutes ago</p>
                          </div>
                      </div>
                  </div>
                  <div class="px-3 py-2 border-bottom">
                      <div class="d-flex">
                          <div class="me-3">
                              <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                  <i class="bi bi-printer text-white"></i>
                              </div>
                          </div>
                          <div class="flex-grow-1">
                              <p class="mb-1 fw-medium">Print Job Completed</p>
                              <p class="mb-1 text-muted small">500 labels printed successfully</p>
                              <p class="mb-0 text-muted small">15 minutes ago</p>
                          </div>
                      </div>
                  </div>
                  <div class="px-3 py-2">
                      <div class="d-flex">
                          <div class="me-3">
                              <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                  <i class="bi bi-exclamation-triangle text-white"></i>
                              </div>
                          </div>
                          <div class="flex-grow-1">
                              <p class="mb-1 fw-medium">OCR Processing Failed</p>
                              <p class="mb-1 text-muted small">Image quality too low for text recognition</p>
                              <p class="mb-0 text-muted small">1 hour ago</p>
                          </div>
                      </div>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="px-3 py-2">
                      <button class="btn btn-link btn-sm w-100">View All Notifications</button>
                  </div>
              </div>
          </div>

          <!-- Theme Toggle -->
          <button class="btn btn-link" id="themeToggle">
              <i class="bi bi-sun-fill" id="themeIcon"></i>
          </button>

          <!-- User Profile -->
          <div class="dropdown">
              <button class="btn btn-link d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                  <img src="/placeholder.svg?height=32&width=32&text=User" 
                       alt="Profile" class="rounded-circle" width="32" height="32">
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                  <li><h6 class="dropdown-header">
                      <div>{{auth()->user()->name}} {{auth()->user()->surname}}</div>
                      <small class="text-muted">{{auth()->user()->email}}</small>
                  </h6></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="{{route('panel.account-settings')}}" data-page="settings">Profile</a></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">Log out</button>
                    </form>
                  </li>
              </ul>
          </div>
      </div>
  </div>
</nav>