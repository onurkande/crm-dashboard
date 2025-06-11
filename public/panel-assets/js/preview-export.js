// Preview & Export Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    setupDownloadHandlers();
    setupZoomControls();
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

    // Action buttons
    document.getElementById('compareToggle').addEventListener('click', toggleImageComparison);
    document.getElementById('zoomImageBtn').addEventListener('click', zoomProductImage);
    document.getElementById('editLabelBtn').addEventListener('click', editLabel);
    document.getElementById('previewFullLabel').addEventListener('click', previewFullLabel);
    document.getElementById('fullScreenBtn').addEventListener('click', toggleFullScreen);

    // Final action buttons
    document.getElementById('archiveBtn').addEventListener('click', archiveLabel);
    document.getElementById('shareBtn').addEventListener('click', shareLabel);
    document.getElementById('emailBtn').addEventListener('click', emailLabel);
    document.getElementById('reEditBtn').addEventListener('click', reEditLabel);
    document.getElementById('finalizeBtn').addEventListener('click', finalizeLabel);

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

function setupDownloadHandlers() {
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const format = this.dataset.format;
            downloadLabel(format, this);
        });
    });
}

function setupZoomControls() {
    let zoomLevel = 1;
    const labelContent = document.getElementById('labelContent');
    
    document.getElementById('zoomInLabel').addEventListener('click', function() {
        zoomLevel = Math.min(zoomLevel * 1.2, 3);
        updateLabelZoom(zoomLevel);
    });
    
    document.getElementById('zoomOutLabel').addEventListener('click', function() {
        zoomLevel = Math.max(zoomLevel / 1.2, 0.5);
        updateLabelZoom(zoomLevel);
    });
    
    document.getElementById('resetZoomLabel').addEventListener('click', function() {
        zoomLevel = 1;
        updateLabelZoom(zoomLevel);
    });
}

function updateLabelZoom(level) {
    const labelContent = document.getElementById('labelContent');
    labelContent.style.transform = `scale(${level})`;
    labelContent.style.transformOrigin = 'center center';
}

function downloadLabel(format, buttonElement) {
    // Add processing state
    buttonElement.classList.add('processing');
    const originalContent = buttonElement.innerHTML;
    buttonElement.innerHTML = `
        <i class="bi bi-hourglass-split"></i>
        <div class="fw-semibold">Processing...</div>
        <small class="text-muted">Please wait</small>
    `;

    // Simulate download process
    setTimeout(() => {
        // Reset button state
        buttonElement.classList.remove('processing');
        buttonElement.innerHTML = originalContent;

        // Show success message
        showToast(`${format.toUpperCase()} download started!`, 'success');

        // Simulate file download
        const link = document.createElement('a');
        link.href = '#';
        link.download = `premium-coffee-label.${format === 'print' ? 'pdf' : format}`;
        
        // For demonstration, we'll just show a success message
        setTimeout(() => {
            showToast(`${format.toUpperCase()} file ready for download`, 'info');
        }, 2000);

    }, 3000);
}

function toggleImageComparison() {
    const originalImg = document.querySelector('.image-comparison-container:first-child img');
    const translatedImg = document.querySelector('.image-comparison-container:last-child img');
    
    // Toggle visibility or implement slider comparison
    showToast('Image comparison toggled', 'info');
}


function editLabel() {
    if (confirm('This will take you back to the template editor. Continue?')) {
        showToast('Redirecting to template editor...', 'info');
        // Simulate redirect
        setTimeout(() => {
            // window.location.href = 'template-editor.html';
        }, 1500);
    }
}

function previewFullLabel() {
    const labelContent = document.getElementById('labelContent').innerHTML;
    
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Full Label Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="label-content" style="transform: scale(2); margin: 100px;">
                            ${labelContent}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Download Preview</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    modal.addEventListener('hidden.bs.modal', () => {
        modal.remove();
    });
}
document.getElementById('fullScreenBtn').addEventListener('click', toggleFullScreen);

function toggleFullScreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
        document.getElementById('fullScreenBtn').innerHTML = '<i class="bi bi-fullscreen-exit me-1"></i> Exit Full Screen';
    } else {
        document.exitFullscreen();
        document.getElementById('fullScreenBtn').innerHTML = '<i class="bi bi-fullscreen me-1"></i> Full Screen';
    }
}

function archiveLabel() {
    if (confirm('Archive this label? It will be moved to your label history.')) {
        showToast('Label archived successfully!', 'success');
        
        // Simulate archive process
        setTimeout(() => {
            showToast('Label added to archive', 'info');
        }, 1500);
    }
}

function shareLabel() {
    const modal = new bootstrap.Modal(document.getElementById('shareModal'));
    modal.show();
}

function emailLabel() {
    const modal = new bootstrap.Modal(document.getElementById('emailModal'));
    modal.show();
}

function reEditLabel() {
    if (confirm('Return to template editor? Any unsaved changes will be lost.')) {
        showToast('Returning to template editor...', 'info');
        // Simulate redirect
        setTimeout(() => {
            // window.location.href = 'template-editor.html';
        }, 1500);
    }
}

function finalizeLabel() {
    if (confirm('Finalize this label? This will mark it as completed and ready for production.')) {
        const btn = document.getElementById('finalizeBtn');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Finalizing...';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Finalized!';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            
            showToast('Label finalized successfully!', 'success');
            
            // Show completion message
            setTimeout(() => {
                showToast('Label is now ready for production', 'info');
            }, 2000);
        }, 3000);
    }
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
                    "Your label looks great! The Spanish translation quality is excellent. Would you like me to suggest any final improvements?",
                    "For PDF export, I recommend using 300 DPI for the best print quality. The current settings look perfect!",
                    "The label design follows good typography principles. The text hierarchy is clear and readable.",
                    "Consider archiving this label for future reference. You can always create variations later.",
                    "The barcode placement and QR code are optimally positioned for scanning."
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

    // Ctrl/Cmd + S to finalize
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('finalizeBtn').click();
    }

    // Ctrl/Cmd + E to export PDF
    if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        document.querySelector('[data-format="pdf"]').click();
    }
});