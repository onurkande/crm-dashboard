// Statistics & Reports JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    initializeCharts();
    generateHeatmap();
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

    // Set default dates
    const today = new Date();
    const lastWeek = new Date(today);
    lastWeek.setDate(lastWeek.getDate() - 7);
    
    document.getElementById('startDate').value = lastWeek.toISOString().split('T')[0];
    document.getElementById('endDate').value = today.toISOString().split('T')[0];
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

    // Filter tabs
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const period = this.dataset.period;
            if (period === 'custom') {
                document.getElementById('customDateRange').style.display = 'block';
            } else {
                document.getElementById('customDateRange').style.display = 'none';
                updateDataForPeriod(period);
            }
        });
    });

    // Export buttons
    document.getElementById('exportExcelBtn').addEventListener('click', exportToExcel);
    document.getElementById('exportPdfBtn').addEventListener('click', exportToPDF);
    document.getElementById('generateReportBtn').addEventListener('click', openCustomReportModal);
    document.getElementById('generateCustomReportBtn').addEventListener('click', generateCustomReport);

    // Custom date range
    document.getElementById('applyCustomRange').addEventListener('click', applyCustomDateRange);
    document.getElementById('resetFiltersBtn').addEventListener('click', resetFilters);

    // Chart options
    document.querySelectorAll('[data-chart-type]').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const chartType = this.dataset.chartType;
            updateChartType(chartType);
        });
    });

    // Error samples
    document.getElementById('viewAllErrorsBtn').addEventListener('click', viewAllErrors);

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

function updateDataForPeriod(period) {
    // Simulate data update based on selected period
    const metrics = {
        today: { labels: 12847, ocr: 94.2, cost: 2847, languages: 12 },
        week: { labels: 15234, ocr: 93.8, cost: 3456, languages: 14 },
        month: { labels: 45678, ocr: 94.7, cost: 8923, languages: 18 },
        year: { labels: 234567, ocr: 93.5, cost: 45678, languages: 25 }
    };

    const data = metrics[period] || metrics.today;
    
    document.getElementById('totalLabels').textContent = data.labels.toLocaleString();
    document.getElementById('ocrSuccessRate').textContent = data.ocr + '%';
    document.getElementById('totalCost').textContent = '$' + data.cost.toLocaleString();
    document.getElementById('languageCount').textContent = data.languages;

    // Update charts with new data
    updateChartsData(period);
    
    showToast(`Data updated for ${period} period`, 'info');
}

function applyCustomDateRange() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (!startDate || !endDate) {
        showToast('Please select both start and end dates', 'warning');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        showToast('Start date cannot be after end date', 'warning');
        return;
    }
    
    showToast(`Custom date range applied: ${startDate} to ${endDate}`, 'success');
    updateChartsData('custom');
}

function resetFilters() {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    document.querySelector('[data-period="today"]').classList.add('active');
    document.getElementById('customDateRange').style.display = 'none';
    updateDataForPeriod('today');
}

function initializeCharts() {
    // Production Trends Chart
    const productionCtx = document.getElementById('productionChart');
    if (productionCtx) {
        window.productionChart = new Chart(productionCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Labels Produced',
                    data: [1200, 1900, 3000, 2500, 2200, 3000, 3500, 4000, 3200, 2800, 3800, 4200],
                    backgroundColor: 'rgba(13, 110, 253, 0.8)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1000
                        }
                    }
                }
            }
        });
    }

    // Category Distribution Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Food & Beverages', 'Cosmetics', 'Electronics', 'Clothing', 'Others'],
                datasets: [{
                    data: [35.2, 24.3, 22.2, 11.9, 6.4],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(13, 202, 240, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Scheduler Success Chart
    const schedulerCtx = document.getElementById('schedulerChart');
    if (schedulerCtx) {
        window.schedulerChart = new Chart(schedulerCtx, {
            type: 'pie',
            data: {
                labels: ['Successful', 'Failed', 'Skipped'],
                datasets: [{
                    data: [94.2, 2.6, 3.2],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        display: true
                    }
                }
            }
        });
    }
}

function generateHeatmap() {
    const heatmapContainer = document.getElementById('activityHeatmap');
    heatmapContainer.innerHTML = '';
    
    // Generate 24 hours of activity data
    for (let hour = 0; hour < 24; hour++) {
        const cell = document.createElement('div');
        cell.className = 'heatmap-cell';
        
        // Simulate activity levels (higher during business hours)
        let level = 0;
        if (hour >= 8 && hour <= 18) {
            level = Math.floor(Math.random() * 4) + 2; // 2-5 for business hours
        } else if (hour >= 6 && hour <= 22) {
            level = Math.floor(Math.random() * 3) + 1; // 1-3 for extended hours
        } else {
            level = Math.floor(Math.random() * 2); // 0-1 for night hours
        }
        
        cell.classList.add(`level-${level}`);
        cell.title = `${hour}:00 - Activity Level: ${level}`;
        
        heatmapContainer.appendChild(cell);
    }
}

function updateChartType(chartType) {
    if (window.productionChart) {
        window.productionChart.config.type = chartType;
        window.productionChart.update();
        showToast(`Chart updated to ${chartType} view`, 'info');
    }
}

function updateChartsData(period) {
    // Simulate updating charts with new data based on period
    if (window.productionChart) {
        const newData = generateRandomData(period);
        window.productionChart.data.datasets[0].data = newData;
        window.productionChart.update();
    }
}

function generateRandomData(period) {
    const baseData = [1200, 1900, 3000, 2500, 2200, 3000, 3500, 4000, 3200, 2800, 3800, 4200];
    const multiplier = period === 'year' ? 1.5 : period === 'month' ? 1.2 : period === 'week' ? 0.8 : 1;
    
    return baseData.map(value => Math.floor(value * multiplier * (0.8 + Math.random() * 0.4)));
}

function exportToExcel() {
    showToast('Preparing Excel export...', 'info');
    
    // Simulate export process
    setTimeout(() => {
        showToast('Excel report exported successfully!', 'success');
        
        // Create a simulated download
        const link = document.createElement('a');
        link.href = '#';
        link.download = 'labelcraft-statistics-report.xlsx';
        link.click();
    }, 2000);
}

function exportToPDF() {
    showToast('Generating PDF report...', 'info');
    
    // Simulate export process
    setTimeout(() => {
        showToast('PDF report generated successfully!', 'success');
        
        // Create a simulated download
        const link = document.createElement('a');
        link.href = '#';
        link.download = 'labelcraft-statistics-report.pdf';
        link.click();
    }, 3000);
}

function openCustomReportModal() {
    const modal = new bootstrap.Modal(document.getElementById('customReportModal'));
    modal.show();
}

function generateCustomReport() {
    const reportType = document.getElementById('reportType').value;
    const dateRange = document.getElementById('reportDateRange').value;
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('customReportModal'));
    modal.hide();
    
    showToast('Generating custom report...', 'info');
    
    // Simulate report generation
    setTimeout(() => {
        showToast(`${reportType} report for ${dateRange} generated successfully!`, 'success');
    }, 4000);
}

function viewAllErrors() {
    showToast('Opening detailed error analysis...', 'info');
    
    // Simulate opening detailed view
    setTimeout(() => {
        showToast('Error analysis view loaded', 'success');
    }, 1500);
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
                    "I can help you analyze your statistics. What specific metrics would you like to explore?",
                    "Your OCR success rate of 94.2% is excellent! Would you like tips to improve it further?",
                    "The cost breakdown shows OCR processing is your largest expense. Consider optimizing image quality to reduce costs.",
                    "Spanish is your most translated language. Would you like insights on expanding to other markets?",
                    "Your template usage shows Modern layout is most popular. Consider creating variations of this design."
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

    // Ctrl/Cmd + E to export Excel
    if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        exportToExcel();
    }

    // Ctrl/Cmd + P to export PDF
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        exportToPDF();
    }
});