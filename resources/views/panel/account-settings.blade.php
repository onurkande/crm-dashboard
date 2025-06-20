@extends('panel.layouts.master')

@section('title', 'Account Settings')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/account-settings.css') }}">
@endsection

@section('meta')
    <meta name="description" content="Account Settings">
    <meta name="keywords" content="Account Settings">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        <div class="page-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Account Settings</h1>
                    <p class="text-muted mb-0">Manage your account preferences and security settings</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" id="resetAllBtn">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset All
                    </button>
                </div>
            </div>

              <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Settings Tabs -->
            <div class="settings-tabs">
                <button class="settings-tab active" data-tab="profile">
                    <i class="bi bi-person me-2"></i>Profile
                </button>
                <button class="settings-tab" data-tab="security">
                    <i class="bi bi-shield-lock me-2"></i>Security
                </button>
                <button class="settings-tab" data-tab="notifications">
                    <i class="bi bi-bell me-2"></i>Notifications
                </button>
                <button class="settings-tab" data-tab="billing">
                    <i class="bi bi-credit-card me-2"></i>Billing
                </button>
                <button class="settings-tab" data-tab="advanced">
                    <i class="bi bi-gear me-2"></i>Advanced
                </button>
            </div>

            <!-- Profile Tab -->
            <div id="profileTab" class="tab-content">
                <div class="row g-4">
                    <!-- Profile Information -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-person me-2"></i>Profile Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <form id="profileForm" action="{{ route('panel.account-settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstName" name="name" value="{{ $user->name }}" required>
                                            @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastName" name="surname" value="{{ $user->surname }}" required>
                                            @error('surname')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                                            @error('phone')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="company" class="form-label">Company</label>
                                            <input type="text" class="form-control" id="company" name="company_name" required value="{{ $user->company_name }}">
                                            @error('company_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="producer" class="form-label">Producer <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="producer" name="producer_name" placeholder="Enter producer name" required value="{{ $user->producer_name }}">
                                            <small class="form-text text-muted">Required - Name of the product producer</small>
                                            @error('producer_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="importer" class="form-label">Importer <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="importer" name="importer_name" placeholder="Enter importer name" required value="{{ $user->importer_name }}">
                                            <small class="form-text text-muted">Required - Name of the product importer</small>
                                            @error('importer_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter your address">{{ $user->address }}</textarea>
                                            @error('address')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="bio" class="form-label">Bio</label>
                                            <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Tell us about yourself...">{{$user->bio}}</textarea>
                                            @error('bio')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save me-1"></i>Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Language Preferences -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-translate me-2"></i>Language Preferences
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Your Custom Languages</label>
                                        <div class="language-list mb-3" id="userLanguagesList">
                                            @if($user->userLanguages && $user->userLanguages->count() > 0)
                                                @foreach($user->userLanguages as $language)
                                                    <div class="badge bg-primary me-2 mb-2 p-2 user-language-item" data-language-id="{{ $language->id }}">
                                                        <strong>{{ $language->language_code }}</strong>: {{ $language->language_name }}
                                                        <a href="{{ route('panel.user-languages.destroy', $language->id) }}" type="button" class="btn-close btn-close-white ms-2 remove-language-btn" 
                                                            data-language-id="{{ $language->id }}"
                                                            aria-label="Remove"></a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted">No custom languages added yet.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Default Available Languages</label>
                                        <div class="default-languages mb-3">
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇺🇸 English</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇧🇬 Bulgarian</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇷🇴 Romanian</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇷🇺 Russian</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇹🇷 Turkish</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇯🇵 Japanese</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇰🇷 Korean</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇸🇦 Arabic</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇫🇷 French</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇮🇹 Italian</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇩🇪 German</div>
                                            <div class="badge bg-secondary me-2 mb-2 p-2">🇵🇹 Portuguese</div>
                                        </div>
                                        <small class="text-muted">These languages are available by default and don't need to be added manually.</small>
                                    </div>

                                    <div class="col-12">
                                        <hr class="my-3">
                                        <label class="form-label">Add New Custom Language</label>
                                        <form id="addLanguageForm" action="{{ route('panel.user-languages.store') }}" method="POST">
                                            @csrf
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="languageCode" name="language_code" 
                                                           placeholder="Language Code (e.g., ce)" maxlength="10" required>
                                                    <small class="text-muted">ISO language code</small>
                                                    @error('language_code')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="languageName" name="language_name" 
                                                           placeholder="Language Name (e.g., Chechen)" maxlength="100" required>
                                                    <small class="text-muted">Full language name</small>
                                                    @error('language_name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary w-100" id="addLanguageBtn">
                                                        <i class="bi bi-plus-lg"></i> Add
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Add custom languages that are not in the default list. These languages will be used for OCR and translation features. 
                                            Please use valid ISO language codes (e.g., "ce" for Chechen, "hy" for Armenian).
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Picture & Subscription -->
                    <div class="col-lg-4">
                        <!-- Profile Picture -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-camera me-2"></i>Profile Picture
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="row">
                                    @if($user->profile_photo)
                                        <div class="col-6">
                                            <p class="text-muted mb-2">Current Profile Picture:</p>
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                alt="Current Profile Picture" class="profile-avatar mb-3">
                                            <small class="d-block text-muted">Last updated: {{ $user->updated_at->format('M d, Y') }}</small>
                                        </div>
                                    @endif
                                    <div class="col-6">
                                        <img src="/placeholder.svg?height=120&width=120&text=JS" 
                                        alt="New Profile Picture" class="profile-avatar mb-3" id="profileImage">
                                    </div>
                                </div>
                                
                                <form action="{{ route('panel.account-settings.updateImage') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="upload-area" id="uploadArea">
                                        <i class="bi bi-cloud-upload display-6 text-muted"></i>
                                        <p class="mb-2">Click or drag to upload new photo</p>
                                        <small class="text-muted">Max file size: 5MB<br>Formats: JPG, PNG, GIF</small>
                                        <input type="file" class="d-none" id="profileImageInput" accept="image/jpeg,image/png,image/gif,image/webp" required name="profile_photo">
                                        @error('profile_photo')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                
                                <div class="d-flex gap-2 mt-3">
                                    <button class="btn btn-outline-primary btn-sm flex-fill" id="changePhotoBtn">
                                        <i class="bi bi-camera me-1"></i>Change
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm flex-fill" id="removePhotoBtn">
                                        <i class="bi bi-trash me-1"></i>Remove
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="bi bi-save me-1"></i>Save Changes
                                </button>
                            </form>
                            </div>
                        </div>

                        <!-- Subscription Info -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-star me-2"></i>Subscription
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <span class="subscription-badge">{{$user->user_type}} Plan</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Status:</span>
                                    <span class="badge bg-success">{{$user->status}}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Next Billing:</span>
                                    <span class="fw-semibold">Jan 15, 2025</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Monthly Cost:</span>
                                    <span class="fw-semibold">$29.99</span>
                                </div>
                                
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar" style="width: 65%"></div>
                                </div>
                                <small class="text-muted">{{$user->getLastMonthProductCount()}} / 15,000 labels used this month</small>
                                
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-arrow-up-circle me-1"></i>Upgrade Plan
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-receipt me-1"></i>View Billing
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- How-To Guide -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-lightbulb me-2"></i>Quick Tips
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="how-to-card">
                                    <div class="step-number">1</div>
                                    <h6 class="fw-semibold mb-1">Update Profile Photo</h6>
                                    <p class="small text-muted mb-0">Upload a professional photo to personalize your account</p>
                                </div>
                                
                                <div class="how-to-card">
                                    <div class="step-number">2</div>
                                    <h6 class="fw-semibold mb-1">Set Language Preferences</h6>
                                    <p class="small text-muted mb-0">Choose your preferred languages for better OCR accuracy</p>
                                </div>
                                
                                <div class="how-to-card">
                                    <div class="step-number">3</div>
                                    <h6 class="fw-semibold mb-1">Enable Two-Factor Auth</h6>
                                    <p class="small text-muted mb-0">Secure your account with additional protection</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="securityTab" class="tab-content d-none">
                <div class="row g-4">
                    <!-- Password Change -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-key me-2"></i>Change Password
                                </h5>
                            </div>
                            <div class="card-body">
                                <form id="passwordForm" action="{{ route('panel.account-settings.updatePassword') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="currentPassword" class="form-label">Current Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" required name="current_password">
                                           
                                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="newPassword" placeholder="New Password" required name="new_password">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">
                                            Password must be at least 8 characters with letters, numbers and symbols
                                        </div>
                                        @error('new_password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirmPassword" required name="new_password_confirmation">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('confirm_password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Password Strength Indicator -->
                                    <div class="mb-3">
                                        <label class="form-label">Password Strength</label>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-danger" id="passwordStrength"></div>
                                        </div>
                                        <small class="text-muted" id="passwordStrengthText">Weak</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-shield-check me-1"></i>Update Password
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Two-Factor Authentication -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-shield-shaded me-2"></i>Two-Factor Authentication
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">2FA Status</h6>
                                        <p class="text-muted small mb-0">Additional security for your account</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="twoFactorToggle">
                                        <label class="form-check-label" for="twoFactorToggle"></label>
                                    </div>
                                </div>
                                
                                <div id="twoFactorSetup" class="d-none">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Setup Required:</strong> Scan the QR code with your authenticator app
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <img src="/placeholder.svg?height=150&width=150&text=QR+Code" 
                                            alt="QR Code" class="border rounded" style="width: 150px; height: 150px;">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="verificationCode" class="form-label">Verification Code</label>
                                        <input type="text" class="form-control" id="verificationCode" 
                                            placeholder="Enter 6-digit code from your app">
                                    </div>
                                    
                                    <button class="btn btn-success" id="verify2FA">
                                        <i class="bi bi-check-circle me-1"></i>Verify & Enable
                                    </button>
                                </div>
                                
                                <div id="twoFactorEnabled" class="d-none">
                                    <div class="alert alert-success">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Two-factor authentication is <strong>enabled</strong>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-qr-code me-1"></i>Show Backup Codes
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-x-circle me-1"></i>Disable 2FA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Sessions -->
                    <!--<div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-device-hdd me-2"></i>Active Sessions
                                </h5>
                                <button class="btn btn-outline-danger btn-sm" id="terminateAllSessions">
                                    <i class="bi bi-power me-1"></i>End All
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="session-item current">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-laptop me-2 text-success"></i>
                                                <span class="fw-semibold">Current Session</span>
                                                <span class="badge bg-success ms-2">Active</span>
                                            </div>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-geo-alt me-1"></i>New York, United States
                                            </p>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-browser-chrome me-1"></i>Chrome 120.0 on Windows 11
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-clock me-1"></i>Started 2 hours ago
                                            </p>
                                        </div>
                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </div>
                                </div>

                                
                                <div class="session-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-phone me-2 text-primary"></i>
                                                <span class="fw-semibold">Mobile Device</span>
                                            </div>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-geo-alt me-1"></i>New York, United States
                                            </p>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-browser-safari me-1"></i>Safari on iPhone 15
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-clock me-1"></i>Last active 1 day ago
                                            </p>
                                        </div>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="session-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-laptop me-2 text-warning"></i>
                                                <span class="fw-semibold">Home Computer</span>
                                            </div>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-geo-alt me-1"></i>New York, United States
                                            </p>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-browser-firefox me-1"></i>Firefox 121.0 on macOS
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-clock me-1"></i>Last active 3 days ago
                                            </p>
                                        </div>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-clock-history me-2"></i>Recent Login Activity
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-check text-white small"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="mb-1">Successful Login</h6>
                                                    <small class="text-muted">2 hours ago</small>
                                                </div>
                                                <p class="mb-0 text-muted small">Chrome on Windows • New York, US</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-phone text-white small"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="mb-1">Mobile Login</h6>
                                                    <small class="text-muted">1 day ago</small>
                                                </div>
                                                <p class="mb-0 text-muted small">Safari on iPhone • New York, US</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-exclamation-triangle text-white small"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="mb-1">Failed Login Attempt</h6>
                                                    <small class="text-muted">2 days ago</small>
                                                </div>
                                                <p class="mb-0 text-muted small">Unknown device • London, UK</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="btn btn-outline-primary btn-sm w-100 mt-3">
                                    <i class="bi bi-eye me-1"></i>View Full History
                                </button>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Notifications Tab -->
            <div id="notificationsTab" class="tab-content d-none">
                <div class="row g-4">
                    <!-- Email Notifications -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-envelope me-2"></i>Email Notifications
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Label Processing Complete</h6>
                                        <p class="text-muted small mb-0">When OCR processing finishes</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Translation Updates</h6>
                                        <p class="text-muted small mb-0">When translations are ready</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Print Job Status</h6>
                                        <p class="text-muted small mb-0">Updates on print queue progress</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">New Product Added</h6>
                                        <p class="text-muted small mb-0">When new products are uploaded</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Weekly Reports</h6>
                                        <p class="text-muted small mb-0">Summary of weekly activity</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Marketing Updates</h6>
                                        <p class="text-muted small mb-0">Product updates and news</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Notifications -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-bell me-2"></i>System Notifications
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Browser Notifications</h6>
                                        <p class="text-muted small mb-0">Show notifications in browser</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Sound Alerts</h6>
                                        <p class="text-muted small mb-0">Play sound for important notifications</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Security Alerts</h6>
                                        <p class="text-muted small mb-0">Login attempts and security events</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">System Maintenance</h6>
                                        <p class="text-muted small mb-0">Scheduled maintenance notifications</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Feature Updates</h6>
                                        <p class="text-muted small mb-0">New features and improvements</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar Reminders -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-calendar-check me-2"></i>Calendar Reminders
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Scheduled Print Jobs</h6>
                                        <p class="text-muted small mb-0">Remind before scheduled printing</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Subscription Renewal</h6>
                                        <p class="text-muted small mb-0">Remind before billing date</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="notification-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Template Updates</h6>
                                        <p class="text-muted small mb-0">When templates need updating</p>
                                    </div>
                                    <label class="notification-toggle">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reminderTime" class="form-label">Default Reminder Time</label>
                                    <select class="form-select" id="reminderTime">
                                        <option value="15">15 minutes before</option>
                                        <option value="30" selected>30 minutes before</option>
                                        <option value="60">1 hour before</option>
                                        <option value="120">2 hours before</option>
                                        <option value="1440">1 day before</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Tab -->
            <div id="billingTab" class="tab-content d-none">
                <div class="row g-4">
                    <!-- Payment Methods -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-credit-card me-2"></i>Payment Methods
                                </h5>
                                <button class="btn btn-primary btn-sm" id="addPaymentMethodBtn">
                                    <i class="bi bi-plus-circle me-1"></i>Add New
                                </button>
                            </div>
                            <div class="card-body">
                                <!-- Primary Payment Method -->
                                <div class="payment-method-item border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="bi bi-credit-card-2-front display-6 text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">
                                                    •••• •••• •••• 4242
                                                    <span class="badge bg-primary ms-2">Primary</span>
                                                </h6>
                                                <p class="text-muted small mb-1">Visa ending in 4242</p>
                                                <p class="text-muted small mb-0">Expires 12/2027</p>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                                <li><a class="dropdown-item" href="#">Set as Primary</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Secondary Payment Method -->
                                <div class="payment-method-item border rounded p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="bi bi-credit-card-2-back display-6 text-secondary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">•••• •••• •••• 8888</h6>
                                                <p class="text-muted small mb-1">Mastercard ending in 8888</p>
                                                <p class="text-muted small mb-0">Expires 03/2026</p>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                                <li><a class="dropdown-item" href="#">Set as Primary</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Billing History -->
                        <div class="card mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-receipt me-2"></i>Billing History
                                </h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-download me-1"></i>Export
                                    </button>
                                    <select class="form-select form-select-sm" style="width: auto;">
                                        <option>Last 6 months</option>
                                        <option>Last year</option>
                                        <option>All time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Dec 15, 2024</td>
                                                <td>Professional Plan - Monthly</td>
                                                <td>$29.99</td>
                                                <td><span class="badge bg-success">Paid</span></td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nov 15, 2024</td>
                                                <td>Professional Plan - Monthly</td>
                                                <td>$29.99</td>
                                                <td><span class="badge bg-success">Paid</span></td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Oct 15, 2024</td>
                                                <td>Professional Plan - Monthly</td>
                                                <td>$29.99</td>
                                                <td><span class="badge bg-success">Paid</span></td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sep 15, 2024</td>
                                                <td>Professional Plan - Monthly</td>
                                                <td>$29.99</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>
                                                        <i class="bi bi-hourglass"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Aug 15, 2024</td>
                                                <td>Plan Upgrade - Pro to Enterprise</td>
                                                <td>$49.99</td>
                                                <td><span class="badge bg-success">Paid</span></td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Management -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-star me-2"></i>Current Plan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <h3 class="fw-bold text-primary">Professional</h3>
                                    <p class="text-muted">$29.99/month</p>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Labels Used:</span>
                                        <span class="fw-semibold">8,924 / 15,000</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" style="width: 59.5%"></div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted">Next Billing:</span>
                                        <span class="fw-semibold">Jan 15, 2025</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted">Auto-Renew:</span>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="autoRenewToggle" checked>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" id="changePlanBtn">
                                        <i class="bi bi-arrow-up-circle me-1"></i>Change Plan
                                    </button>
                                    <button class="btn btn-outline-secondary">
                                        <i class="bi bi-receipt me-1"></i>Usage Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-geo-alt me-2"></i>Billing Address
                                </h5>
                            </div>
                            <div class="card-body">
                                <address class="mb-3">
                                    <strong>Acme Corporation</strong><br>
                                    123 Business Street<br>
                                    Suite 100<br>
                                    New York, NY 10001<br>
                                    United States
                                </address>
                                
                                <button class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-pencil me-1"></i>Edit Address
                                </button>
                            </div>
                        </div>

                        <!-- Plan Comparison -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>Need More Labels?
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="plan-card current mb-3">
                                    <div class="text-center">
                                        <h6 class="fw-semibold">Professional</h6>
                                        <p class="h4 fw-bold text-primary">$29.99</p>
                                        <p class="text-muted small">15,000 labels/month</p>
                                    </div>
                                </div>
                                
                                <div class="plan-card">
                                    <div class="text-center">
                                        <h6 class="fw-semibold">Enterprise</h6>
                                        <p class="h4 fw-bold">$49.99</p>
                                        <p class="text-muted small">50,000 labels/month</p>
                                        <button class="btn btn-primary btn-sm mt-2">
                                            Upgrade
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Tab -->
            <div id="advancedTab" class="tab-content d-none">
                <div class="row g-4">
                    <!-- API & Integrations -->
                    <div class="col-lg-8">
                        <!-- Data Export & Import -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-database me-2"></i>Data Management
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 text-center">
                                            <i class="bi bi-download display-6 text-primary mb-2"></i>
                                            <h6>Export Data</h6>
                                            <p class="text-muted small">Download all your data</p>
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-download me-1"></i>Request Export
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 text-center">
                                            <i class="bi bi-upload display-6 text-success mb-2"></i>
                                            <h6>Import Data</h6>
                                            <p class="text-muted small">Upload bulk product data</p>
                                            <button class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-upload me-1"></i>Import CSV
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning mt-3">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Data Export:</strong> Exports may take up to 24 hours to process. You'll receive an email when ready.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="col-lg-4">

                        <!-- Account Actions -->
                        <div class="danger-zone mt-4">
                            <h5 class="text-danger mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                            </h5>
                            
                            <div class="mb-3">
                                <h6>Freeze Account</h6>
                                <p class="text-muted small mb-2">Temporarily suspend your account while preserving data</p>
                                <button class="btn btn-outline-warning btn-sm" id="freezeAccountBtn">
                                    <i class="bi bi-pause-circle me-1"></i>Request Freeze
                                </button>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Download All Data</h6>
                                <p class="text-muted small mb-2">Get a complete backup before making changes</p>
                                <button class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-download me-1"></i>Download Backup
                                </button>
                            </div>
                            
                            <div>
                                <h6 class="text-danger">Delete Account</h6>
                                <p class="text-muted small mb-2">Permanently delete your account and all data. This cannot be undone.</p>
                                <button class="btn btn-danger btn-sm" id="deleteAccountBtn">
                                    <i class="bi bi-trash me-1"></i>Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Add Payment Method Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm">
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="expiryDate" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cvv" class="form-label">CVV <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cvv" placeholder="123" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cardholderName" class="form-label">Cardholder Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cardholderName" required>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="setPrimary">
                            <label class="form-check-label" for="setPrimary">
                                Set as primary payment method
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="savePaymentMethod">
                        <i class="bi bi-credit-card me-1"></i>Add Card
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Delete Account
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Warning:</strong> This action cannot be undone. All your data will be permanently deleted.
                    </div>
                    
                    <p>To confirm account deletion, please:</p>
                    <ol>
                        <li>Enter your current password</li>
                        <li>Complete two-factor authentication if enabled</li>
                        <li>Type "DELETE" to confirm</li>
                    </ol>
                    
                    <form id="deleteAccountForm">
                        <div class="mb-3">
                            <label for="deletePassword" class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="deletePassword" required>
                        </div>
                        
                        <div class="mb-3" id="delete2FASection" style="display: none;">
                            <label for="delete2FACode" class="form-label">2FA Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="delete2FACode" placeholder="Enter 6-digit code">
                        </div>
                        
                        <div class="mb-3">
                            <label for="deleteConfirmation" class="form-label">Type "DELETE" to confirm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="deleteConfirmation" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteAccount" disabled>
                        <i class="bi bi-trash me-1"></i>Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection 

@section('js')
    <script>
        window.activeTabFromSession = "{{ session('active_tab') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('panel-assets/js/account-settings.js') }}"></script>
    @if(session('active_tab'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showTab('{{ session('active_tab') }}');
        });
    </script>
    @endif
@endsection