// Add New Product Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    setupFormValidation();
    setupImageUpload();
    setupCategorySelection();
    setupLanguageSelection();
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

    // Auto-generate SKU based on product name
    document.getElementById('productName').addEventListener('input', function() {
        if (!document.getElementById('productSku').value) {
            const sku = generateSKU(this.value);
            document.getElementById('productSku').value = sku;
        }
    });
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

    // Barcode generation
    document.getElementById('generateBarcode').addEventListener('click', generateBarcode);
    document.getElementById('barcodeType').addEventListener('change', updateBarcodePreview);
    document.getElementById('barcodeContent').addEventListener('input', updateBarcodePreview);

    // Quick action buttons
    document.getElementById('ocrScanBtn').addEventListener('click', function() {
        showToast('OCR scanning feature will be available soon!', 'info');
    });

    document.getElementById('importDataBtn').addEventListener('click', function() {
        showToast('CSV import feature will be available soon!', 'info');
    });

    document.getElementById('templateBtn').addEventListener('click', function() {
        showToast('Template selection feature will be available soon!', 'info');
    });

    // Preview button
    document.getElementById('previewBtn').addEventListener('click', previewProduct);

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

function setupFormValidation() {
    const form = document.getElementById('productForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            const formData = collectFormData();
            const isAddNew = e.submitter.id === 'saveAndAddNew';
            
            saveProduct(formData, isAddNew);
        }
    });
}

function validateForm() {
    const form = document.getElementById('productForm');
    const productName = document.getElementById('productName');
    
    let isValid = true;
    
    // Reset previous validation states
    form.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validate product name
    if (!productName.value.trim()) {
        productName.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate category selection
    if (!document.getElementById('selectedCategory').value) {
        showToast('Please select a product category', 'warning');
        isValid = false;
    }
    
    return isValid;
}

function collectFormData() {
    const formData = {
        name: document.getElementById('productName').value,
        sku: document.getElementById('productSku').value,
        description: document.getElementById('productDescription').value,
        category: document.getElementById('selectedCategory').value,
        barcodeType: document.getElementById('barcodeType').value,
        barcodeContent: document.getElementById('barcodeContent').value,
        images: Array.from(document.querySelectorAll('.image-preview')).map(preview => preview.dataset.src),
        languages: Array.from(document.querySelectorAll('.language-checkbox input:checked')).map(cb => cb.id.replace('lang_', '')),
        autoGenerateLabels: document.getElementById('autoGenerateLabels').checked,
        enableNotifications: document.getElementById('enableNotifications').checked,
        saveAsDraft: document.getElementById('saveAsDraft').checked
    };
    
    return formData;
}

function saveProduct(formData, isAddNew = false) {
    // Show loading state
    const submitBtn = isAddNew ? document.getElementById('saveAndAddNew') : document.getElementById('saveAndReturn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Saving...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        console.log('Product data:', formData);
        
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Show success message
        showToast('Product saved successfully!', 'success');
        
        if (isAddNew) {
            // Reset form for new product
            resetForm();
            showToast('Ready to add another product', 'info');
        } else {
            // Redirect to products list
            showToast('Redirecting to products list...', 'info');
            setTimeout(() => {
                // window.location.href = 'products.html';
            }, 1500);
        }
    }, 2000);
}

function setupImageUpload() {
    const uploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const browseBtn = document.getElementById('browseImages');
    
    // Browse button click
    browseBtn.addEventListener('click', () => imageInput.click());
    uploadArea.addEventListener('click', () => imageInput.click());
    
    // File input change
    imageInput.addEventListener('change', handleImageSelection);
    
    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        handleImageFiles(files);
    });
}

function handleImageSelection(e) {
    const files = Array.from(e.target.files);
    handleImageFiles(files);
}

function handleImageFiles(files) {
    const container = document.getElementById('imagePreviewContainer');
    
    files.forEach(file => {
        if (file.size > 5 * 1024 * 1024) { // 5MB limit
            showToast(`File ${file.name} is too large. Maximum size is 5MB.`, 'warning');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            addImagePreview(e.target.result, file.name);
        };
        reader.readAsDataURL(file);
    });
}

function addImagePreview(src, filename) {
    const container = document.getElementById('imagePreviewContainer');
    
    const preview = document.createElement('div');
    preview.className = 'image-preview';
    preview.dataset.src = src;
    preview.innerHTML = `
        <img src="${src}" alt="${filename}">
        <button type="button" class="remove-btn" onclick="removeImagePreview(this)">
            <i class="bi bi-x"></i>
        </button>
    `;
    
    container.appendChild(preview);
}

function removeImagePreview(btn) {
    btn.closest('.image-preview').remove();
}

function setupCategorySelection() {
    const categoryItems = document.querySelectorAll('.category-item');
    const selectedCategoryInput = document.getElementById('selectedCategory');
    
    categoryItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove previous selection
            categoryItems.forEach(cat => cat.classList.remove('selected'));
            
            // Add selection to clicked item
            this.classList.add('selected');
            
            // Update hidden input
            selectedCategoryInput.value = this.dataset.category;
            
            // Update visual feedback
            const categoryName = this.textContent.trim();
            showToast(`Selected category: ${categoryName}`, 'success');
        });
    });
}

/*function setupLanguageSelection() {
    const languageCheckboxes = document.querySelectorAll('.language-checkbox');
    
    languageCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            const input = this.querySelector('input[type="checkbox"]');
            if (!input.disabled) {
                input.checked = !input.checked;
                this.classList.toggle('selected', input.checked);
            }
        });
        
        // Initialize selected state
        const input = checkbox.querySelector('input[type="checkbox"]');
        if (input.checked) {
            checkbox.classList.add('selected');
        }
    });
}*/

function generateSKU(productName) {
    if (!productName) return '';
    
    const prefix = 'PRD';
    const nameCode = productName.substring(0, 3).toUpperCase().replace(/[^A-Z]/g, '');
    const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    
    return `${prefix}-${nameCode}${randomNum}`;
}

function generateBarcode() {
    const barcodeType = document.getElementById('barcodeType').value;
    let generatedCode = '';
    
    switch (barcodeType) {
        case 'ean13':
            generatedCode = generateEAN13();
            break;
        case 'ean8':
            generatedCode = generateEAN8();
            break;
        case 'upc':
            generatedCode = generateUPC();
            break;
        case 'code128':
            generatedCode = generateCode128();
            break;
        case 'qr':
            generatedCode = generateQRContent();
            break;
        case 'datamatrix':
            generatedCode = generateDataMatrix();
            break;
    }
    
    const barcodeInput = document.getElementById('barcodeContent');
    barcodeInput.value = generatedCode;
    updateBarcodePreview();
}

function generateEAN13() {
    // Generate 12 random digits, calculate check digit
    let code = '';
    for (let i = 0; i < 12; i++) {
        code += Math.floor(Math.random() * 10);
    }
    
    // Calculate EAN-13 check digit
    let sum = 0;
    for (let i = 0; i < 12; i++) {
        sum += parseInt(code[i]) * (i % 2 === 0 ? 1 : 3);
    }
    const checkDigit = (10 - (sum % 10)) % 10;
    
    return code + checkDigit;
}

function generateEAN8() {
    let code = '';
    for (let i = 0; i < 7; i++) {
        code += Math.floor(Math.random() * 10);
    }
    
    let sum = 0;
    for (let i = 0; i < 7; i++) {
        sum += parseInt(code[i]) * (i % 2 === 0 ? 3 : 1);
    }
    const checkDigit = (10 - (sum % 10)) % 10;
    
    return code + checkDigit;
}

function generateUPC() {
    let code = '';
    for (let i = 0; i < 11; i++) {
        code += Math.floor(Math.random() * 10);
    }
    
    let sum = 0;
    for (let i = 0; i < 11; i++) {
        sum += parseInt(code[i]) * (i % 2 === 0 ? 3 : 1);
    }
    const checkDigit = (10 - (sum % 10)) % 10;
    
    return code + checkDigit;
}

function generateCode128() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 10; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return code;
}

function generateQRContent() {
    const productName = document.getElementById('productName').value || 'Product';
    const sku = document.getElementById('productSku').value || generateSKU(productName);
    return `${productName} - ${sku}`;
}

function generateDataMatrix() {
    const timestamp = Date.now().toString();
    return timestamp.substring(timestamp.length - 10);
}

function updateBarcodePreview() {
    const barcodeType = document.getElementById('barcodeType').value;
    const barcodeContent = document.getElementById('barcodeContent').value;
    const preview = document.getElementById('barcodePreview');
    
    if (barcodeContent) {
        preview.innerHTML = `
            <div class="text-primary mb-2">
                <i class="bi bi-upc-scan" style="font-size: 2rem;"></i>
            </div>
            <div class="fw-bold">${barcodeType.toUpperCase()}</div>
            <div class="font-monospace small">${barcodeContent}</div>
        `;
    } else {
        preview.innerHTML = `
            <i class="bi bi-upc-scan text-muted" style="font-size: 2rem;"></i>
            <p class="text-muted mb-0 mt-2">Barcode preview will appear here</p>
        `;
    }
}

function previewProduct() {
    const formData = collectFormData();
    
    if (!formData.name) {
        showToast('Please enter a product name to preview', 'warning');
        return;
    }
    
    // Create preview modal content
    const previewContent = `
        <div class="modal fade" id="previewModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Product Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Basic Information</h6>
                                <p><strong>Name:</strong> ${formData.name}</p>
                                <p><strong>SKU:</strong> ${formData.sku || 'Not specified'}</p>
                                <p><strong>Description:</strong> ${formData.description || 'No description'}</p>
                                <p><strong>Category:</strong> ${formData.category || 'Not selected'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Barcode Information</h6>
                                <p><strong>Type:</strong> ${formData.barcodeType.toUpperCase()}</p>
                                <p><strong>Content:</strong> ${formData.barcodeContent || 'Not generated'}</p>
                                
                                <h6 class="fw-bold mt-3">Translation Languages</h6>
                                <p>${formData.languages.length > 0 ? formData.languages.join(', ') : 'English only'}</p>
                            </div>
                        </div>
                        
                        ${formData.images.length > 0 ? `
                            <h6 class="fw-bold mt-3">Product Images</h6>
                            <div class="d-flex gap-2 flex-wrap">
                                ${formData.images.map(img => `<img src="${img}" class="rounded" width="80" height="80" style="object-fit: cover;">`).join('')}
                            </div>
                        ` : ''}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('saveAndReturn').click(); bootstrap.Modal.getInstance(document.getElementById('previewModal')).hide();">Save Product</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing preview modal
    const existingModal = document.getElementById('previewModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add new preview modal
    document.body.insertAdjacentHTML('beforeend', previewContent);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}

function resetForm() {
    document.getElementById('productForm').reset();
    document.getElementById('selectedCategory').value = '';
    document.getElementById('imagePreviewContainer').innerHTML = '';
    document.getElementById('barcodePreview').innerHTML = `
        <i class="bi bi-upc-scan text-muted" style="font-size: 2rem;"></i>
        <p class="text-muted mb-0 mt-2">Barcode preview will appear here</p>
    `;
    
    // Reset category selection
    document.querySelectorAll('.category-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Reset language selection
    document.querySelectorAll('.language-checkbox').forEach(checkbox => {
        checkbox.classList.remove('selected');
        const input = checkbox.querySelector('input[type="checkbox"]');
        if (input.id === 'lang_en') {
            input.checked = true;
            checkbox.classList.add('selected');
        } else {
            input.checked = false;
        }
    });
    
    // Reset validation states
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    showToast('Form reset successfully', 'info');
}

// Sidebar and theme functions (same as dashboard)
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
                    "I can help you extract product information from images using OCR. Just upload an image!",
                    "Would you like me to suggest a product category based on the name you entered?",
                    "I can help generate barcode numbers for your products automatically.",
                    "For bulk product creation, consider using the CSV import feature.",
                    "Make sure to select the appropriate languages for automatic translation."
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
        document.getElementById('saveAndReturn').click();
    }
});

// Sayfa yüklendiğinde otomatik barkod oluştur
document.addEventListener('DOMContentLoaded', function() {
    // Barkod tipi değiştiğinde otomatik barkod oluştur
    document.getElementById('barcodeType').addEventListener('change', function() {
        generateBarcode();
    });

    // Sayfa ilk yüklendiğinde otomatik barkod oluştur
    generateBarcode();
});