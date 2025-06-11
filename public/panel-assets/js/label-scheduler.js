// Label Planner & Scheduler JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    initializeCalendar();
    setupChat();
});

function initializePage() {
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

    // Set default date and time
    const now = new Date();
    const tomorrow = new Date(now);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    document.getElementById('startDate').value = tomorrow.toISOString().split('T')[0];
    document.getElementById('startTime').value = '10:00';
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

    // Main action buttons
    document.getElementById('createScheduleBtn').addEventListener('click', openCreateScheduleModal);
    document.getElementById('quickScheduleBtn').addEventListener('click', openCreateScheduleModal);
    document.getElementById('importScheduleBtn').addEventListener('click', importSchedule);
    document.getElementById('exportSchedulesBtn').addEventListener('click', exportSchedules);
    document.getElementById('runAllActiveBtn').addEventListener('click', runAllActive);
    document.getElementById('pauseAllActiveBtn').addEventListener('click', pauseAllActive);
    document.getElementById('refreshSchedulesBtn').addEventListener('click', refreshSchedules);

    // Modal form handlers
    document.getElementById('saveScheduleBtn').addEventListener('click', saveSchedule);
    document.getElementById('productSelector').addEventListener('click', openProductSelector);

    // Template selection
    document.querySelectorAll('.template-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('selectedTemplate').value = this.dataset.template;
        });
    });

    // Notification options
    document.querySelectorAll('.notification-option').forEach(option => {
        option.addEventListener('click', function() {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            this.classList.toggle('selected', checkbox.checked);
        });
    });

    // Calendar navigation
    document.getElementById('prevMonth').addEventListener('click', () => navigateMonth(-1));
    document.getElementById('nextMonth').addEventListener('click', () => navigateMonth(1));

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

function openCreateScheduleModal() {
    document.getElementById('scheduleModalTitle').textContent = 'Create New Schedule';
    document.getElementById('scheduleForm').reset();
    
    // Reset template selection
    document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
    document.getElementById('selectedTemplate').value = '';
    
    // Reset product selection
    document.getElementById('productSelector').classList.remove('has-products');
    document.getElementById('selectedProducts').innerHTML = '';
    
    // Reset notification options
    document.querySelectorAll('.notification-option').forEach(option => {
        const checkbox = option.querySelector('input[type="checkbox"]');
        option.classList.toggle('selected', checkbox.checked);
    });

    const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
    modal.show();
}

function openProductSelector() {
    // Simulate product selection
    const products = [
        { id: 1, name: 'Premium Coffee', image: '/placeholder.svg?height=80&width=80&text=Coffee' },
        { id: 2, name: 'Organic Tea', image: '/placeholder.svg?height=80&width=80&text=Tea' },
        { id: 3, name: 'Dark Chocolate', image: '/placeholder.svg?height=80&width=80&text=Chocolate' }
    ];

    const selector = document.getElementById('productSelector');
    const grid = document.getElementById('selectedProducts');
    
    selector.classList.add('has-products');
    selector.innerHTML = `
        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
        <h6 class="mt-2 mb-1">3 Products Selected</h6>
        <p class="text-muted mb-2">Click to modify selection</p>
    `;

    grid.innerHTML = products.map(product => `
        <div class="product-item">
            <img src="${product.image}" alt="${product.name}">
            <button class="remove-btn" onclick="removeProduct(${product.id})">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `).join('');
}

function removeProduct(productId) {
    // Remove product from selection
    showToast('Product removed from selection', 'info');
}

function saveSchedule() {
    const form = document.getElementById('scheduleForm');
    
    if (!validateScheduleForm()) {
        return;
    }

    const formData = {
        planName: document.getElementById('planName').value,
        template: document.getElementById('selectedTemplate').value,
        startDate: document.getElementById('startDate').value,
        startTime: document.getElementById('startTime').value,
        repeatFrequency: document.getElementById('repeatFrequency').value,
        endDate: document.getElementById('endDate').value,
        labelQuantity: document.getElementById('labelQuantity').value,
        notifications: {
            email: document.getElementById('emailNotification').checked,
            system: document.getElementById('systemNotification').checked,
            sms: document.getElementById('smsNotification').checked
        }
    };

    // Show loading state
    const saveBtn = document.getElementById('saveScheduleBtn');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Saving...';
    saveBtn.disabled = true;

    // Simulate API call
    setTimeout(() => {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
        
        showToast('Schedule created successfully!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('scheduleModal'));
        modal.hide();
        
        // Add new schedule to list
        addScheduleToList(formData);
        
    }, 2000);
}

function validateScheduleForm() {
    let isValid = true;
    
    // Validate required fields
    const requiredFields = ['planName', 'startDate', 'startTime', 'repeatFrequency', 'labelQuantity'];
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Validate template selection
    if (!document.getElementById('selectedTemplate').value) {
        showToast('Please select a label template', 'warning');
        isValid = false;
    }

    // Validate product selection
    if (!document.getElementById('productSelector').classList.contains('has-products')) {
        showToast('Please select at least one product', 'warning');
        isValid = false;
    }

    return isValid;
}

function addScheduleToList(formData) {
    const schedulesList = document.getElementById('schedulesList');
    const scheduleId = Date.now(); // Simple ID generation
    
    const scheduleItem = document.createElement('div');
    scheduleItem.className = 'schedule-item active';
    scheduleItem.dataset.scheduleId = scheduleId;
    
    const nextRun = getNextRunText(formData.repeatFrequency, formData.startDate, formData.startTime);
    
    scheduleItem.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h6 class="fw-bold mb-0">${formData.planName}</h6>
                    <span class="status-badge active">
                        <i class="bi bi-play-circle"></i>
                        Active
                    </span>
                </div>
                <p class="text-muted mb-2">Produces ${formData.labelQuantity} labels ${formData.repeatFrequency}</p>
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Template: ${formData.template}</small>
                        <small class="text-muted d-block">Products: 3 selected</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Next Run: ${nextRun}</small>
                        <small class="text-muted d-block">Last Run: Never</small>
                    </div>
                </div>
            </div>
            <div class="schedule-controls">
                <button class="btn btn-outline-warning btn-sm" onclick="pauseSchedule(${scheduleId})">
                    <i class="bi bi-pause"></i>
                </button>
                <button class="btn btn-outline-primary btn-sm" onclick="runNow(${scheduleId})">
                    <i class="bi bi-play"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="editSchedule(${scheduleId})">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-outline-danger btn-sm" onclick="deleteSchedule(${scheduleId})">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    
    schedulesList.insertBefore(scheduleItem, schedulesList.firstChild);
}

function getNextRunText(frequency, startDate, startTime) {
    const date = new Date(startDate + 'T' + startTime);
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    switch (frequency) {
        case 'daily':
            return `Daily at ${startTime}`;
        case 'weekly':
            return `${date.toLocaleDateString('en-US', { weekday: 'long' })} at ${startTime}`;
        case 'monthly':
            return `Monthly on ${date.getDate()}${getOrdinalSuffix(date.getDate())} at ${startTime}`;
        default:
            return date.toLocaleDateString('en-US', options);
    }
}

function getOrdinalSuffix(day) {
    if (day > 3 && day < 21) return 'th';
    switch (day % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
    }
}

// Schedule control functions
function pauseSchedule(scheduleId) {
    const scheduleItem = document.querySelector(`[data-schedule-id="${scheduleId}"]`);
    scheduleItem.classList.remove('active');
    scheduleItem.classList.add('paused');
    
    const badge = scheduleItem.querySelector('.status-badge');
    badge.className = 'status-badge paused';
    badge.innerHTML = '<i class="bi bi-pause-circle"></i> Paused';
    
    showToast('Schedule paused successfully', 'warning');
}

function resumeSchedule(scheduleId) {
    const scheduleItem = document.querySelector(`[data-schedule-id="${scheduleId}"]`);
    scheduleItem.classList.remove('paused');
    scheduleItem.classList.add('active');
    
    const badge = scheduleItem.querySelector('.status-badge');
    badge.className = 'status-badge active';
    badge.innerHTML = '<i class="bi bi-play-circle"></i> Active';
    
    showToast('Schedule resumed successfully', 'success');
}

function runNow(scheduleId) {
    if (confirm('Run this schedule now? This will execute the label production immediately.')) {
        showToast('Schedule execution started...', 'info');
        
        // Simulate execution
        setTimeout(() => {
            showToast('Labels produced successfully!', 'success');
            addLogEntry('Manual execution completed', 'success');
        }, 3000);
    }
}

function editSchedule(scheduleId) {
    document.getElementById('scheduleModalTitle').textContent = 'Edit Schedule';
    // Pre-populate form with existing data
    const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
    modal.show();
}

function deleteSchedule(scheduleId) {
    if (confirm('Are you sure you want to delete this schedule? This action cannot be undone.')) {
        const scheduleItem = document.querySelector(`[data-schedule-id="${scheduleId}"]`);
        scheduleItem.remove();
        showToast('Schedule deleted successfully', 'info');
    }
}

function runAllActive() {
    if (confirm('Run all active schedules now? This will execute all active label production schedules.')) {
        showToast('Executing all active schedules...', 'info');
        
        setTimeout(() => {
            showToast('All schedules executed successfully!', 'success');
        }, 5000);
    }
}

function pauseAllActive() {
    if (confirm('Pause all active schedules? You can resume them individually later.')) {
        document.querySelectorAll('.schedule-item.active').forEach(item => {
            const scheduleId = item.dataset.scheduleId;
            pauseSchedule(scheduleId);
        });
    }
}

function refreshSchedules() {
    showToast('Refreshing schedules...', 'info');
    
    // Simulate refresh
    setTimeout(() => {
        showToast('Schedules refreshed successfully', 'success');
    }, 1500);
}

function importSchedule() {
    showToast('Import feature will be available soon!', 'info');
}

function exportSchedules() {
    showToast('Exporting schedules...', 'info');
    
    // Simulate export
    setTimeout(() => {
        showToast('Schedules exported successfully!', 'success');
    }, 2000);
}

function addLogEntry(message, type) {
    const historyLog = document.querySelector('.history-log');
    const now = new Date();
    
    const logEntry = document.createElement('div');
    logEntry.className = 'log-entry';
    
    const iconClass = type === 'success' ? 'bi-check' : type === 'warning' ? 'bi-exclamation-triangle' : 'bi-x';
    
    logEntry.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="log-icon ${type}">
                <i class="bi ${iconClass}"></i>
            </div>
            <div>
                <div class="fw-semibold">${message}</div>
                <small class="text-muted">Manual execution</small>
            </div>
        </div>
        <div class="text-end">
            <div class="small">${now.toLocaleDateString()}</div>
            <div class="small text-muted">${now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
        </div>
    `;
    
    historyLog.insertBefore(logEntry, historyLog.firstChild);
}

function initializeCalendar() {
    const currentDate = new Date();
    generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
}

function generateCalendar(year, month) {
    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonth = document.getElementById('currentMonth');
    
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];
    
    currentMonth.textContent = `${monthNames[month]} ${year}`;
    
    // Clear previous calendar
    calendarGrid.innerHTML = '';
    
    // Add day headers
    const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayHeaders.forEach(day => {
        const dayHeader = document.createElement('div');
        dayHeader.className = 'calendar-day fw-bold text-muted';
        dayHeader.textContent = day;
        dayHeader.style.cursor = 'default';
        calendarGrid.appendChild(dayHeader);
    });
    
    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    
    // Add empty cells for days before month starts
    for (let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day';
        calendarGrid.appendChild(emptyDay);
    }
    
    // Add days of month
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = day;
        
        // Check if it's today
        if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
            dayElement.classList.add('today');
        }
        
        // Simulate scheduled days
        if ([2, 9, 16, 23, 30].includes(day)) {
            dayElement.classList.add('has-schedule');
            dayElement.title = 'Scheduled label production';
        }
        
        dayElement.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day.selected').forEach(d => d.classList.remove('selected'));
            this.classList.add('selected');
        });
        
        calendarGrid.appendChild(dayElement);
    }
}

let currentCalendarDate = new Date();

function navigateMonth(direction) {
    currentCalendarDate.setMonth(currentCalendarDate.getMonth() + direction);
    generateCalendar(currentCalendarDate.getFullYear(), currentCalendarDate.getMonth());
}

// Sidebar and theme functions (same as previous pages)
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
                    "I can help you create automated schedules for label production. What type of schedule would you like to set up?",
                    "For recurring schedules, I recommend setting up daily or weekly frequencies for consistent production.",
                    "Make sure to select the right template and products for your scheduled production runs.",
                    "You can pause or modify schedules anytime. The system will notify you when jobs complete.",
                    "Consider setting up different schedules for different product categories to optimize your workflow."
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
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
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

    // Ctrl/Cmd + N to create new schedule
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        document.getElementById('createScheduleBtn').click();
    }
});