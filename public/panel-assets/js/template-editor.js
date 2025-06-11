// Template Editor JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    setupDragAndDrop();
    setupPreviewInteractions();
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

    // Template selection
    document.querySelectorAll('.template-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            updatePreviewTemplate(this.dataset.template);
        });
    });

    // Quality rating
    document.querySelectorAll('.quality-star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            const container = this.closest('.quality-rating');
            const stars = container.querySelectorAll('.quality-star');
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('inactive');
                    s.classList.add('bi-star-fill');
                    s.classList.remove('bi-star');
                } else {
                    s.classList.add('inactive');
                    s.classList.remove('bi-star-fill');
                    s.classList.add('bi-star');
                }
            });
        });
    });

    // Font controls
    document.getElementById('fontSize').addEventListener('input', function() {
        document.getElementById('fontSizeDisplay').textContent = this.value + 'px';
        updateSelectedElementFont();
    });

    document.getElementById('fontFamily').addEventListener('change', updateSelectedElementFont);

    // Zoom controls
    document.getElementById('zoomInBtn').addEventListener('click', () => zoomPreview(1.2));
    document.getElementById('zoomOutBtn').addEventListener('click', () => zoomPreview(0.8));
    document.getElementById('resetZoomBtn').addEventListener('click', () => resetZoom());

    // Action buttons
    document.getElementById('editProductBtn').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
        modal.show();
    });

    document.getElementById('retranslateBtn').addEventListener('click', retranslateAll);
    document.getElementById('addFieldBtn').addEventListener('click', addCustomField);
    document.getElementById('previewFullBtn').addEventListener('click', showFullPreview);
    document.getElementById('resetTemplateBtn').addEventListener('click', resetTemplate);
    document.getElementById('saveAndContinueBtn').addEventListener('click', saveAndContinue);

    // Language change
    document.getElementById('targetLanguage').addEventListener('change', updateTranslations);
    document.getElementById('previewLanguage').addEventListener('change', updatePreviewLanguage);

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

function setupDragAndDrop() {
    // Make translation items draggable
    document.querySelectorAll('.translation-text-item').forEach(item => {
        item.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', this.dataset.field);
            e.dataTransfer.setData('text/html', this.querySelector('.translated-text').textContent);
            this.classList.add('dragging');
        });

        item.addEventListener('dragend', function() {
            this.classList.remove('dragging');
        });
    });

    // Setup drop zones
    document.querySelectorAll('.field-slot').forEach(slot => {
        slot.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        slot.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });

        slot.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            
            const fieldType = e.dataTransfer.getData('text/plain');
            const textContent = e.dataTransfer.getData('text/html');
            
            // Update field slot
            this.classList.add('filled');
            this.innerHTML = `
                <div class="field-slot-content">
                    <div>
                        <strong>${fieldType.charAt(0).toUpperCase() + fieldType.slice(1).replace('-', ' ')}</strong>
                        <div class="small text-muted">${textContent}</div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger" onclick="clearField(this)">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            `;
            
            // Update preview
            updatePreviewField(this.dataset.field, textContent);
        });
    });
}

function setupPreviewInteractions() {
    // Make preview elements selectable and draggable
    document.querySelectorAll('.preview-element').forEach(element => {
        element.addEventListener('click', function() {
            document.querySelectorAll('.preview-element').forEach(el => el.classList.remove('selected'));
            this.classList.add('selected');
            updateFontControls(this);
        });

        // Make elements draggable within preview
        element.addEventListener('mousedown', function(e) {
            if (this.classList.contains('selected')) {
                let isDragging = false;
                const startX = e.clientX;
                const startY = e.clientY;
                const startLeft = parseInt(this.style.left) || 0;
                const startTop = parseInt(this.style.top) || 0;

                const onMouseMove = (e) => {
                    if (!isDragging && (Math.abs(e.clientX - startX) > 5 || Math.abs(e.clientY - startY) > 5)) {
                        isDragging = true;
                    }
                    
                    if (isDragging) {
                        const deltaX = e.clientX - startX;
                        const deltaY = e.clientY - startY;
                        this.style.left = (startLeft + deltaX) + 'px';
                        this.style.top = (startTop + deltaY) + 'px';
                    }
                };

                const onMouseUp = () => {
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                };

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            }
        });
    });
}

function clearField(button) {
    const fieldSlot = button.closest('.field-slot');
    fieldSlot.classList.remove('filled');
    fieldSlot.innerHTML = `
        <div class="text-muted">
            <i class="bi bi-plus-circle me-2"></i>
            Drop ${fieldSlot.dataset.field} text here
        </div>
    `;
}

function updatePreviewTemplate(templateType) {
    const canvas = document.getElementById('livePreviewCanvas');
    
    // Clear existing elements
    canvas.innerHTML = '';
    
    // Add elements based on template type
    switch (templateType) {
        case 'modern':
            canvas.innerHTML = `
                <div class="preview-element" style="top: 20px; left: 20px; font-size: 18px; font-weight: bold;">
                    Mezcla de Café Premium
                </div>
                <div class="preview-element" style="top: 50px; left: 20px; font-size: 12px;">
                    Mezcla de café rica y aromática
                </div>
                <div class="preview-element" style="top: 80px; left: 20px; font-size: 10px;">
                    100% Granos de Café Arábica
                </div>
                <div class="preview-element" style="bottom: 20px; left: 20px; font-size: 8px;">
                    Almacenar en lugar fresco y seco
                </div>
                <div class="preview-element" style="top: 20px; right: 20px;">
                    <div class="barcode-display" style="font-size: 8px; padding: 0.25rem;">
                        <i class="bi bi-upc-scan"></i>
                        <div>1234567890123</div>
                    </div>
                </div>
            `;
            break;
        case 'classic':
            canvas.innerHTML = `
                <div class="preview-element" style="top: 30px; left: 50%; transform: translateX(-50%); font-size: 16px; font-weight: bold; text-align: center;">
                    Mezcla de Café Premium
                </div>
                <div class="preview-element" style="top: 60px; left: 50%; transform: translateX(-50%); font-size: 11px; text-align: center;">
                    Mezcla de café rica y aromática
                </div>
                <div class="preview-element" style="top: 90px; left: 50%; transform: translateX(-50%); font-size: 9px; text-align: center;">
                    100% Granos de Café Arábica
                </div>
                <div class="preview-element" style="bottom: 30px; left: 50%; transform: translateX(-50%); font-size: 8px; text-align: center;">
                    Almacenar en lugar fresco y seco
                </div>
            `;
            break;
        case 'minimal':
            canvas.innerHTML = `
                <div class="preview-element" style="top: 40px; left: 30px; font-size: 20px; font-weight: bold;">
                    Mezcla de Café Premium
                </div>
                <div class="preview-element" style="bottom: 40px; left: 30px; font-size: 10px;">
                    100% Granos de Café Arábica
                </div>
            `;
            break;
        case 'blank':
            canvas.innerHTML = `
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                    <div class="text-center">
                        <i class="bi bi-plus-circle" style="font-size: 3rem;"></i>
                        <div class="mt-2">Click to add elements</div>
                    </div>
                </div>
            `;
            break;
    }
    
    // Re-setup interactions for new elements
    setupPreviewInteractions();
}

function updatePreviewField(fieldType, content) {
    // Update the corresponding preview element
    const previewElements = document.querySelectorAll('.preview-element');
    // Implementation would depend on field mapping logic
    showToast(`Updated ${fieldType} field`, 'success');
}

function updateFontControls(element) {
    const fontSize = parseInt(element.style.fontSize) || 12;
    const fontFamily = element.style.fontFamily || 'Arial';
    
    document.getElementById('fontSize').value = fontSize;
    document.getElementById('fontSizeDisplay').textContent = fontSize + 'px';
    document.getElementById('fontFamily').value = fontFamily;
}

function updateSelectedElementFont() {
    const selectedElement = document.querySelector('.preview-element.selected');
    if (selectedElement) {
        const fontSize = document.getElementById('fontSize').value;
        const fontFamily = document.getElementById('fontFamily').value;
        
        selectedElement.style.fontSize = fontSize + 'px';
        selectedElement.style.fontFamily = fontFamily;
    }
}

function zoomPreview(factor) {
    const canvas = document.getElementById('livePreviewCanvas');
    const currentScale = parseFloat(canvas.style.transform.replace('scale(', '').replace(')', '')) || 1;
    const newScale = Math.max(0.5, Math.min(2, currentScale * factor));
    canvas.style.transform = `scale(${newScale})`;
    canvas.style.transformOrigin = 'top left';
}

function resetZoom() {
    const canvas = document.getElementById('livePreviewCanvas');
    canvas.style.transform = 'scale(1)';
}

function retranslateAll() {
    showToast('Re-translating all text...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showToast('Translation completed successfully!', 'success');
    }, 2000);
}

function addCustomField() {
    const fieldMappingArea = document.getElementById('fieldMappingArea');
    const addButton = document.getElementById('addFieldBtn');
    
    const newField = document.createElement('div');
    newField.className = 'field-slot';
    newField.dataset.field = 'custom-' + Date.now();
    newField.innerHTML = `
        <div class="text-muted">
            <i class="bi bi-plus-circle me-2"></i>
            Drop custom text here
        </div>
    `;
    
    fieldMappingArea.insertBefore(newField, addButton);
    
    // Setup drag and drop for new field
    setupFieldDropZone(newField);
}

function setupFieldDropZone(slot) {
    slot.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    slot.addEventListener('dragleave', function() {
        this.classList.remove('drag-over');
    });

    slot.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        const fieldType = e.dataTransfer.getData('text/plain');
        const textContent = e.dataTransfer.getData('text/html');
        
        this.classList.add('filled');
        this.innerHTML = `
            <div class="field-slot-content">
                <div>
                    <strong>${fieldType.charAt(0).toUpperCase() + fieldType.slice(1).replace('-', ' ')}</strong>
                    <div class="small text-muted">${textContent}</div>
                </div>
                <button class="btn btn-sm btn-outline-danger" onclick="clearField(this)">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
    });
}

function updateTranslations() {
    const targetLang = document.getElementById('targetLanguage').value;
    showToast(`Switching to ${targetLang.toUpperCase()} translations...`, 'info');
    
    // Simulate language change
    const translations = {
        'es': {
            'Premium Coffee Blend': 'Mezcla de Café Premium',
            'Rich, aromatic coffee blend': 'Mezcla de café rica y aromática',
            '100% Arabica Coffee Beans': '100% Granos de Café Arábica',
            'Store in a cool, dry place': 'Almacenar en lugar fresco y seco'
        },
        'fr': {
            'Premium Coffee Blend': 'Mélange de Café Premium',
            'Rich, aromatic coffee blend': 'Mélange de café riche et aromatique',
            '100% Arabica Coffee Beans': '100% Grains de Café Arabica',
            'Store in a cool, dry place': 'Conserver dans un endroit frais et sec'
        }
    };
    
    // Update translation items
    setTimeout(() => {
        document.querySelectorAll('.translation-text-item').forEach(item => {
            const sourceText = item.querySelector('.source-text').textContent;
            const translatedElement = item.querySelector('.translated-text');
            if (translations[targetLang] && translations[targetLang][sourceText]) {
                translatedElement.textContent = translations[targetLang][sourceText];
            }
        });
        showToast('Translations updated!', 'success');
    }, 1000);
}

function updatePreviewLanguage() {
    const previewLang = document.getElementById('previewLanguage').value;
    showToast(`Preview updated to ${previewLang.toUpperCase()}`, 'info');
    // Update preview elements with selected language
}

function showFullPreview() {
    const previewContent = document.getElementById('livePreviewCanvas').innerHTML;
    
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
                    <div class="live-preview-canvas" style="height: 600px; transform: scale(1.5); transform-origin: top left;">
                        ${previewContent}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Export Preview</button>
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

function resetTemplate() {
    if (confirm('Are you sure you want to reset the template? All changes will be lost.')) {
        // Reset to default template
        document.querySelector('.template-card[data-template="modern"]').click();
        
        // Clear all field mappings except the first one
        document.querySelectorAll('.field-slot.filled').forEach((slot, index) => {
            if (index > 0) {
                clearField(slot.querySelector('button'));
            }
        });
        
        showToast('Template reset successfully', 'info');
    }
}

function saveAndContinue() {
    const saveBtn = document.getElementById('saveAndContinueBtn');
    const originalText = saveBtn.innerHTML;
    
    saveBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Saving...';
    saveBtn.disabled = true;
    
    // Simulate save process
    setTimeout(() => {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
        
        showToast('Template saved successfully!', 'success');
        
        // Simulate navigation to next step
        setTimeout(() => {
            showToast('Proceeding to preview & print...', 'info');
        }, 1500);
    }, 2000);
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
                    "I can help you improve your template design. Would you like suggestions for better text placement?",
                    "The translation quality looks good! Consider adjusting the font size for better readability.",
                    "For food products, make sure ingredient information is clearly visible and properly translated.",
                    "Your template layout follows good design principles. The barcode placement looks optimal.",
                    "Would you like me to suggest improvements for the Spanish translation quality?"
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

    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('saveAndContinueBtn').click();
    }
});