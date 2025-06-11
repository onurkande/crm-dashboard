// Account Settings JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeSettings();
    setupEventListeners();
    setupChat();
    setupImageUpload();
});

function initializeSettings() {
    // Set initial theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
    
    // Initialize sidebar state
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (sidebarCollapsed) {
        document.getElementById('sidebar').classList.add('collapsed');
    }

    // Initialize language
    const savedLanguage = localStorage.getItem('language') || 'en';
    setLanguage(savedLanguage);

    // Show profile tab by default
    showTab('profile');
}

function setupEventListeners() {
    // Sidebar toggle
    document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);
    document.getElementById('sidebarExpandBtn').addEventListener('click', expandSidebar);
    
    // Mobile menu toggle
    document.getElementById('mobileMenuToggle').addEventListener('click', toggleMobileMenu);
    document.getElementById('mobileCloseBtn').addEventListener('click', closeMobileMenu);
    
    // Theme toggle
    document.getElementById('themeToggle').addEventListener('click', toggleTheme);
    
    // Language selector
    document.querySelectorAll('[data-lang]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const lang = this.getAttribute('data-lang');
            setLanguage(lang);
        });
    });

    // Settings tabs
    document.querySelectorAll('.settings-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            showTab(tabName);
        });
    });

    // Password visibility toggles
    setupPasswordToggles();

    // Password strength checker
    document.getElementById('newPassword').addEventListener('input', checkPasswordStrength);

    // Two-factor authentication toggle
    document.getElementById('twoFactorToggle').addEventListener('change', function() {
        const setup = document.getElementById('twoFactorSetup');
        const enabled = document.getElementById('twoFactorEnabled');
        
        if (this.checked) {
            setup.classList.remove('d-none');
            enabled.classList.add('d-none');
        } else {
            setup.classList.add('d-none');
            enabled.classList.add('d-none');
        }
    });

    // Form submissions
    document.getElementById('profileForm').addEventListener('submit', saveProfileSettings);
    document.getElementById('passwordForm').addEventListener('submit', changePassword);

    // Save buttons
    document.getElementById('saveAllBtn').addEventListener('click', saveAllSettings);
    document.getElementById('resetAllBtn').addEventListener('click', resetAllSettings);

    // Billing actions
    document.getElementById('addPaymentMethodBtn').addEventListener('click', () => {
        new bootstrap.Modal(document.getElementById('addPaymentModal')).show();
    });

    // Danger zone actions
    document.getElementById('deleteAccountBtn').addEventListener('click', () => {
        new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
    });

    document.getElementById('freezeAccountBtn').addEventListener('click', freezeAccount);

    // Delete account confirmation
    document.getElementById('deleteConfirmation').addEventListener('input', function() {
        const confirmBtn = document.getElementById('confirmDeleteAccount');
        confirmBtn.disabled = this.value !== 'DELETE';
    });

    document.getElementById('confirmDeleteAccount').addEventListener('click', deleteAccount);

    // Session management
    document.getElementById('terminateAllSessions').addEventListener('click', terminateAllSessions);

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 991.98) {
            const sidebar = document.getElementById('sidebar');
            const mobileToggle = document.getElementById('mobileMenuToggle');
            
            if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
}

function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('d-none');
    });

    // Show selected tab
    const targetTab = document.getElementById(tabName + 'Tab');
    if (targetTab) {
        targetTab.classList.remove('d-none');
    }

    // Update tab buttons
    document.querySelectorAll('.settings-tab').forEach(tab => {
        tab.classList.remove('active');
    });

    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
}

function setupPasswordToggles() {
    const toggleButtons = [
        { toggle: 'toggleCurrentPassword', input: 'currentPassword' },
        { toggle: 'toggleNewPassword', input: 'newPassword' },
        { toggle: 'toggleConfirmPassword', input: 'confirmPassword' }
    ];

    toggleButtons.forEach(item => {
        const button = document.getElementById(item.toggle);
        const input = document.getElementById(item.input);
        
        if (button && input) {
            button.addEventListener('click', function() {
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                
                const icon = this.querySelector('i');
                icon.className = type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
            });
        }
    });
}

function checkPasswordStrength() {
    const password = document.getElementById('newPassword').value;
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordStrengthText');
    
    let strength = 0;
    let feedback = '';
    
    if (password.length >= 8) strength += 25;
    if (/[a-z]/.test(password)) strength += 25;
    if (/[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 12.5;
    if (/[^A-Za-z0-9]/.test(password)) strength += 12.5;
    
    strengthBar.style.width = strength + '%';
    
    if (strength < 25) {
        strengthBar.className = 'progress-bar bg-danger';
        feedback = 'Very Weak';
    } else if (strength < 50) {
        strengthBar.className = 'progress-bar bg-warning';
        feedback = 'Weak';
    } else if (strength < 75) {
        strengthBar.className = 'progress-bar bg-info';
        feedback = 'Good';
    } else {
        strengthBar.className = 'progress-bar bg-success';
        feedback = 'Strong';
    }
    
    strengthText.textContent = feedback;
}

function setupImageUpload() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('profileImageInput');
    const changeBtn = document.getElementById('changePhotoBtn');
    const removeBtn = document.getElementById('removePhotoBtn');
    const profileImg = document.getElementById('profileImage');

    // Click to upload
    uploadArea.addEventListener('click', () => fileInput.click());
    changeBtn.addEventListener('click', () => fileInput.click());

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleImageUpload(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleImageUpload(this.files[0]);
        }
    });

    // Remove photo
    removeBtn.addEventListener('click', function() {
        profileImg.src = '/placeholder.svg?height=120&width=120&text=User';
        showToast('Profile photo removed', 'info');
    });
}

function handleImageUpload(file) {
    // Validate file
    if (!file.type.startsWith('image/')) {
        showToast('Please select an image file', 'error');
        return;
    }

    if (file.size > 5 * 1024 * 1024) { // 5MB
        showToast('File size must be less than 5MB', 'error');
        return;
    }

    // Preview image
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('profileImage').src = e.target.result;
        showToast('Profile photo updated', 'success');
    };
    reader.readAsDataURL(file);
}

function saveProfileSettings(e) {
    e.preventDefault();
    
    const formData = {
        firstName: document.getElementById('firstName').value,
        lastName: document.getElementById('lastName').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        company: document.getElementById('company').value,
        bio: document.getElementById('bio').value,
        timezone: document.getElementById('timezone').value,
        primaryLanguage: document.getElementById('primaryLanguage').value
    };

    // Simulate API call
    showToast('Saving profile...', 'info');
    
    setTimeout(() => {
        showToast('Profile settings saved successfully!', 'success');
    }, 1500);
}

function changePassword(e) {
    e.preventDefault();
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (newPassword !== confirmPassword) {
        showToast('New passwords do not match', 'error');
        return;
    }

    if (newPassword.length < 8) {
        showToast('Password must be at least 8 characters long', 'error');
        return;
    }

    // Simulate API call
    showToast('Changing password...', 'info');
    
    setTimeout(() => {
        showToast('Password changed successfully!', 'success');
        document.getElementById('passwordForm').reset();
    }, 2000);
}

function saveAllSettings() {
    showToast('Saving all settings...', 'info');
    
    setTimeout(() => {
        showToast('All settings saved successfully!', 'success');
    }, 2000);
}

function resetAllSettings() {
    if (confirm('Are you sure you want to reset all settings to defaults?')) {
        showToast('Settings reset to defaults', 'info');
        location.reload();
    }
}

function terminateAllSessions() {
    if (confirm('This will log you out of all devices except this one. Continue?')) {
        showToast('All other sessions terminated', 'success');
        
        // Hide non-current sessions
        const sessions = document.querySelectorAll('.session-item:not(.current)');
        sessions.forEach(session => {
            session.style.display = 'none';
        });
    }
}

function freezeAccount() {
    if (confirm('This will temporarily suspend your account. You can reactivate it by contacting support. Continue?')) {
        showToast('Account freeze request submitted', 'warning');
    }
}

function deleteAccount() {
    const password = document.getElementById('deletePassword').value;
    const confirmation = document.getElementById('deleteConfirmation').value;

    if (!password) {
        showToast('Please enter your password', 'error');
        return;
    }

    if (confirmation !== 'DELETE') {
        showToast('Please type DELETE to confirm', 'error');
        return;
    }

    // Simulate account deletion
    showToast('Processing account deletion...', 'info');
    
    setTimeout(() => {
        showToast('Account deletion request submitted. You will receive a confirmation email.', 'warning');
        bootstrap.Modal.getInstance(document.getElementById('deleteAccountModal')).hide();
    }, 3000);
}

// Sidebar and theme functions
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
}

function expandSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.remove('collapsed');
    localStorage.setItem('sidebarCollapsed', 'false');
}

function toggleMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
}

function closeMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.remove('show');
}

function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    setTheme(newTheme);
}

function setTheme(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem('theme', theme);
    
    const themeIcon = document.getElementById('themeIcon');
    if (themeIcon) {
        themeIcon.className = theme === 'dark' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
    }
}

function setLanguage(lang) {
    const languageMap = {
        'en': '🇺🇸 EN',
        'es': '🇪🇸 ES',
        'fr': '🇫🇷 FR',
        'de': '🇩🇪 DE',
        'tr': '🇹🇷 TR'
    };
    
    document.getElementById('currentLanguage').textContent = languageMap[lang].split(' ')[1];
    localStorage.setItem('language', lang);
}

function setupChat() {
    const chatFab = document.getElementById('chatFab');
    const chatModal = document.getElementById('chatModal');
    const closeChatModal = document.getElementById('closeChatModal');
    const chatInput = document.getElementById('chatInput');
    const sendMessage = document.getElementById('sendMessage');

    chatFab.addEventListener('click', function() {
        chatModal.style.display = chatModal.style.display === 'flex' ? 'none' : 'flex';
    });

    closeChatModal.addEventListener('click', function() {
        chatModal.style.display = 'none';
    });

    function sendChatMessage() {
        const message = chatInput.value.trim();
        if (message) {
            addChatMessage(message, 'user');
            chatInput.value = '';
            
            setTimeout(() => {
                const responses = [
                    "I can help you with profile settings, security configuration, and billing questions. What specific area would you like assistance with?",
                    "For password changes, make sure to use a strong password with at least 8 characters including letters, numbers, and symbols.",
                    "Two-factor authentication adds an extra layer of security to your account. I recommend enabling it in the Security tab.",
                    "You can export all your data from the Advanced tab. The export may take up to 24 hours to process.",
                    "If you need to update your billing information, you can manage payment methods in the Billing tab.",
                    "Language preferences affect OCR accuracy and translation quality. Make sure to select all languages you work with."
                ];
                const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                addChatMessage(randomResponse, 'bot');
            }, 1000);
        }
    }

    sendMessage.addEventListener('click', sendChatMessage);
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendChatMessage();
        }
    });
}

function addChatMessage(message, sender) {
    const chatBody = document.getElementById('chatBody');
    const messageDiv = document.createElement('div');
    messageDiv.className = `chat-message ${sender}`;
    
    const now = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    messageDiv.innerHTML = `
        <div class="message-bubble">${message}</div>
        <small class="text-muted">${now}</small>
    `;
    
    chatBody.appendChild(messageDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
}

function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    document.body.appendChild(container);
    return container;
}

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth > 991.98) {
        document.getElementById('sidebar').classList.remove('show');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        toggleSidebar();
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
        e.preventDefault();
        toggleTheme();
    }

    if (e.key === 'Escape') {
        document.getElementById('chatModal').style.display = 'none';
    }

    // Ctrl/Cmd + S to save settings
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveAllSettings();
    }
});