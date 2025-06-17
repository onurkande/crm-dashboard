// Statistics & Reports JavaScript

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded'); // Debug: DOM yüklendi mi?
    initializePage();
    setupEventListeners();
    initializeCharts();
    
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




    // Chart options
    document.querySelectorAll('[data-chart-type]').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const chartType = this.dataset.chartType;
            updateChartType(chartType);
        });
    });


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


initializeCharts();
function initializeCharts() {
    // Production Trends Chart
    const productionCtx = document.getElementById('productionChart');
    if (productionCtx) {
        const monthlyCounts = window.monthlyTranslationCounts || [0,0,0,0,0,0,0,0,0,0,0,0];
        
        window.productionChart = new Chart(productionCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Labels Produced',
                    data: monthlyCounts,
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Category Distribution Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        // Dinamik kategori verilerini hazırla
        const categoryStats = window.categoryStats || [];
        const labels = categoryStats.map(cat => cat.name);
        const data = categoryStats.map(cat => cat.percentage);
        const counts = categoryStats.map(cat => cat.product_count);

        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
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
}

// Progress bar renklerini belirleyen yardımcı fonksiyon
function getProgressBarColor(index) {
    const colors = ['', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
    return colors[index % colors.length];
}
generateHeatmap();
function generateHeatmap() {
    const heatmapContainer = document.getElementById('activityHeatmap');
    heatmapContainer.innerHTML = '';

    // Backend'den gelen saatlik aktivite verisi
    const activityData = window.hourlyActivityHeatmap || Array(24).fill(0);

    // Aktivite seviyelerini normalize et (0-5 arası)
    const max = Math.max(...activityData);
    const min = Math.min(...activityData);

    for (let hour = 0; hour < 24; hour++) {
        const cell = document.createElement('div');
        cell.className = 'heatmap-cell';

        // Seviyeyi 0-5 arası bir değere dönüştür
        let level = 0;
        if (max > min) {
            level = Math.round(((activityData[hour] - min) / (max - min)) * 5);
        }
        cell.classList.add(`level-${level}`);
        cell.title = `${hour}:00 - Activity: ${activityData[hour]}`;

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
        'tr': '��🇷 TR'
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


});