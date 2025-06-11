// Product Management JavaScript

let productsTable;
let currentEditId = null;
let currentDeleteId = null;

// Sample product data
const sampleProducts = [
    {
        id: 1,
        name: "Premium Coffee Blend",
        category: "food",
        barcode: "1234567890123",
        barcodeType: "ean13",
        status: "active",
        tagged: true,
        translated: true,
        created: "2024-01-15",
        description: "Premium arabica coffee blend with rich flavor",
        tags: ["premium", "coffee", "organic"],
        image: "https://hips.hearstapps.com/hmg-prod/images/gh-best-skincare-products-6557978b58b57.png?crop=0.888888888888889xw:1xh;center,top&resize=1200"
    },
    {
        id: 2,
        name: "Wireless Headphones",
        category: "electronics",
        barcode: "9876543210987",
        barcodeType: "qr",
        status: "active",
        tagged: false,
        translated: false,
        created: "2024-01-14",
        description: "High-quality wireless headphones with noise cancellation",
        tags: ["electronics", "audio", "wireless"],
        image: "/placeholder.svg?height=50&width=50&text=Headphones"
    },
    {
        id: 3,
        name: "Cotton T-Shirt",
        category: "clothing",
        barcode: "5555666677778",
        barcodeType: "code128",
        status: "inactive",
        tagged: true,
        translated: true,
        created: "2024-01-13",
        description: "100% cotton comfortable t-shirt",
        tags: ["clothing", "cotton", "casual"],
        image: "/placeholder.svg?height=50&width=50&text=Shirt"
    },
    {
        id: 4,
        name: "Moisturizing Cream",
        category: "cosmetics",
        barcode: "1111222233334",
        barcodeType: "ean13",
        status: "active",
        tagged: true,
        translated: false,
        created: "2024-01-12",
        description: "Hydrating moisturizing cream for all skin types",
        tags: ["skincare", "moisturizer", "beauty"],
        image: "/placeholder.svg?height=50&width=50&text=Cream"
    },
    {
        id: 5,
        name: "JavaScript Guide",
        category: "books",
        barcode: "9999888877776",
        barcodeType: "upc",
        status: "active",
        tagged: false,
        translated: true,
        created: "2024-01-11",
        description: "Complete guide to JavaScript programming",
        tags: ["programming", "javascript", "education"],
        image: "/placeholder.svg?height=50&width=50&text=Book"
    }
];

document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();
    initializeDataTable();
    setupEventListeners();
    setupChat();
});

function initializeDashboard() {
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

function initializeDataTable() {
    productsTable = $('#productsTable').DataTable({
        data: sampleProducts,
        columns: [
            {
                data: null,
                render: function(data, type, row) {
                    return `<input type="checkbox" class="form-check-input product-checkbox" value="${row.id}">`;
                },
                orderable: false
            },
            {
                data: 'image',
                render: function(data, type, row) {
                    return `<img src="${data}" alt="${row.name}" class="product-thumbnail">`;
                },
                orderable: false
            },
            {
                data: 'name',
                render: function(data, type, row) {
                    return `<div>
                        <strong>${data}</strong>
                        <br><small class="text-muted">${row.description.substring(0, 50)}...</small>
                    </div>`;
                }
            },
            {
                data: 'category',
                render: function(data) {
                    const categoryMap = {
                        'electronics': 'Electronics',
                        'clothing': 'Clothing',
                        'food': 'Food & Beverage',
                        'cosmetics': 'Cosmetics',
                        'books': 'Books',
                        'toys': 'Toys'
                    };
                    return `<span class="badge bg-secondary">${categoryMap[data] || data}</span>`;
                }
            },
            {
                data: 'barcode',
                render: function(data, type, row) {
                    return `<div>
                        <code>${data}</code>
                        <br><small class="text-muted">${row.barcodeType.toUpperCase()}</small>
                    </div>`;
                }
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    const isActive = data === 'active';
                    return `<div class="form-check form-switch">
                        <input class="form-check-input quick-toggle" type="checkbox" ${isActive ? 'checked' : ''} 
                               onchange="toggleStatus(${row.id}, this.checked)">
                        <label class="form-check-label">
                            <span class="badge ${isActive ? 'bg-success' : 'bg-secondary'}">${isActive ? 'Active' : 'Inactive'}</span>
                        </label>
                    </div>`;
                },
                orderable: false
            },
            {
                data: 'tagged',
                render: function(data) {
                    return `<span class="tag-status">
                        ${data ? '<i class="bi bi-check-circle text-success"></i> Tagged' : '<i class="bi bi-x-circle text-danger"></i> Waiting'}
                    </span>`;
                }
            },
            {
                data: 'translated',
                render: function(data) {
                    return `<span class="badge ${data ? 'bg-success' : 'bg-warning'}">${data ? 'Translated' : 'Pending'}</span>`;
                }
            },
            {
                data: 'created',
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `<div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="quickView(${row.id})" title="Quick View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-secondary" onclick="editProduct(${row.id})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteProduct(${row.id})" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>`;
                },
                orderable: false
            }
        ],
        pageLength: 10,
        responsive: true,
        language: {
            search: "Search products:",
            lengthMenu: "Show _MENU_ products per page",
            info: "Showing _START_ to _END_ of _TOTAL_ products",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });

    // Select all checkbox functionality
    $('#selectAll').on('change', function() {
        $('.product-checkbox').prop('checked', this.checked);
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

    // Search input
    document.getElementById('searchInput').addEventListener('keyup', function() {
        productsTable.search(this.value).draw();
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

// Product Management Functions
function applyFilters() {
    // This would typically make an API call with filter parameters
    showToast('Filters applied successfully', 'success');
}

function clearFilters() {
    document.getElementById('categoryFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('tagStatusFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('languageFilter').value = '';
    document.getElementById('barcodeFilter').value = '';
    document.getElementById('searchInput').value = '';
    
    productsTable.search('').draw();
    showToast('Filters cleared', 'info');
}

function saveProduct() {
    const form = document.getElementById('addProductForm');
    const formData = new FormData(form);
    
    // Simulate API call
    setTimeout(() => {
        const newProduct = {
            id: sampleProducts.length + 1,
            name: formData.get('productName'),
            category: formData.get('category'),
            barcode: formData.get('barcodeValue') || Math.random().toString().substr(2, 13),
            barcodeType: formData.get('barcodeType'),
            status: formData.get('isActive') ? 'active' : 'inactive',
            tagged: false,
            translated: false,
            created: new Date().toISOString().split('T')[0],
            description: formData.get('description'),
            tags: formData.get('tags').split(',').map(tag => tag.trim()),
            image: "/placeholder.svg?height=50&width=50&text=New"
        };
        
        sampleProducts.push(newProduct);
        productsTable.row.add(newProduct).draw();
        
        bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
        form.reset();
        showToast('Product added successfully', 'success');
    }, 500);
}

function editProduct(id) {
    const product = sampleProducts.find(p => p.id === id);
    if (!product) return;
    
    currentEditId = id;
    const form = document.getElementById('editProductForm');
    
    form.productId.value = product.id;
    form.productName.value = product.name;
    form.category.value = product.category;
    form.barcodeType.value = product.barcodeType;
    form.barcodeValue.value = product.barcode;
    form.description.value = product.description;
    form.tags.value = product.tags.join(', ');
    form.isActive.checked = product.status === 'active';
    
    new bootstrap.Modal(document.getElementById('editProductModal')).show();
}

function updateProduct() {
    const form = document.getElementById('editProductForm');
    const formData = new FormData(form);
    
    // Simulate API call
    setTimeout(() => {
        const productIndex = sampleProducts.findIndex(p => p.id === currentEditId);
        if (productIndex !== -1) {
            sampleProducts[productIndex] = {
                ...sampleProducts[productIndex],
                name: formData.get('productName'),
                category: formData.get('category'),
                barcode: formData.get('barcodeValue'),
                barcodeType: formData.get('barcodeType'),
                status: formData.get('isActive') ? 'active' : 'inactive',
                description: formData.get('description'),
                tags: formData.get('tags').split(',').map(tag => tag.trim())
            };
            
            productsTable.clear().rows.add(sampleProducts).draw();
        }
        
        bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
        showToast('Product updated successfully', 'success');
    }, 500);
}

function deleteProduct(id) {
    currentDeleteId = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function confirmDelete() {
    // Simulate API call
    setTimeout(() => {
        const productIndex = sampleProducts.findIndex(p => p.id === currentDeleteId);
        if (productIndex !== -1) {
            sampleProducts.splice(productIndex, 1);
            productsTable.clear().rows.add(sampleProducts).draw();
        }
        
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
        showToast('Product deleted successfully', 'success');
    }, 500);
}

function quickView(id) {
    const product = sampleProducts.find(p => p.id === id);
    if (!product) return;
    
    document.getElementById('quickViewImage').src = product.image;
    document.getElementById('quickViewName').textContent = product.name;
    document.getElementById('quickViewCategory').textContent = product.category;
    document.getElementById('quickViewDescription').textContent = product.description;
    document.getElementById('quickViewBarcode').textContent = `${product.barcode} (${product.barcodeType.toUpperCase()})`;
    document.getElementById('quickViewStatus').innerHTML = `<span class="badge ${product.status === 'active' ? 'bg-success' : 'bg-secondary'}">${product.status}</span>`;
    document.getElementById('quickViewTagged').innerHTML = product.tagged ? '<i class="bi bi-check-circle text-success"></i> Tagged' : '<i class="bi bi-x-circle text-danger"></i> Waiting';
    document.getElementById('quickViewCreated').textContent = new Date(product.created).toLocaleDateString();
    
    const tagsHtml = product.tags.map(tag => `<span class="badge bg-primary me-1">${tag}</span>`).join('');
    document.getElementById('quickViewTags').innerHTML = tagsHtml;
    
    currentEditId = id;
    new bootstrap.Modal(document.getElementById('quickViewModal')).show();
}

function editProductFromQuickView() {
    bootstrap.Modal.getInstance(document.getElementById('quickViewModal')).hide();
    setTimeout(() => editProduct(currentEditId), 300);
}

function toggleStatus(id, isActive) {
    const productIndex = sampleProducts.findIndex(p => p.id === id);
    if (productIndex !== -1) {
        sampleProducts[productIndex].status = isActive ? 'active' : 'inactive';
        showToast(`Product ${isActive ? 'activated' : 'deactivated'} successfully`, 'success');
    }
}

function bulkAction(action) {
    const selectedIds = $('.product-checkbox:checked').map(function() {
        return this.value;
    }).get();
    
    if (selectedIds.length === 0) {
        showToast('Please select products first', 'warning');
        return;
    }
    
    switch(action) {
        case 'tag':
            showToast(`Tagging ${selectedIds.length} products...`, 'info');
            break;
        case 'category':` products...`, 'info';
            break;
        case 'category':
            showToast(`Assigning category to ${selectedIds.length} products...`, 'info');
            break;
        case 'delete':
            if (confirm(`Are you sure you want to delete ${selectedIds.length} products?`)) {
                showToast(`Deleting ${selectedIds.length} products...`, 'info');
            }
            break;
    }
}

function exportProducts(format) {
    // Simulate export functionality
    showToast(`Exporting products as ${format.toUpperCase()}...`, 'info');
    
    setTimeout(() => {
        // Create a simple CSV export simulation
        if (format === 'csv') {
            const csvContent = "data:text/csv;charset=utf-8," 
                + "Name,Category,Barcode,Status,Tagged,Created\n"
                + sampleProducts.map(p => 
                    `"${p.name}","${p.category}","${p.barcode}","${p.status}","${p.tagged}","${p.created}"`
                ).join("\n");
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "products.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        showToast(`Products exported successfully as ${format.toUpperCase()}`, 'success');
    }, 1000);
}

function bulkExport() {
    showToast('Preparing bulk export template...', 'info');
    
    setTimeout(() => {
        const csvContent = "data:text/csv;charset=utf-8," 
            + "Name,Category,Description,Barcode,BarcodeType,Tags,Status\n"
            + "Sample Product,electronics,Sample description,1234567890,ean13,tag1;tag2,active\n";
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "bulk_import_template.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showToast('Bulk export template downloaded', 'success');
    }, 1000);
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
            
            // Simulate AI response
            setTimeout(() => {
                const responses = [
                    "I can help you add new products to your catalog. Would you like me to guide you through the process?",
                    "To bulk import products, you can download the template and fill it with your product data.",
                    "You can filter products by category, status, or tag status using the filters above the table.",
                    "For product tagging, select the products you want to tag and use the bulk tag action.",
                    "I can help you export your product data in Excel or CSV format. Which would you prefer?"
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

// Toast notification function
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
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    container.style.zIndex = '1055';
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
    // Ctrl/Cmd + B to toggle sidebar
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        toggleSidebar();
    }
    
    // Ctrl/Cmd + D to toggle theme
    if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
        e.preventDefault();
        toggleTheme();
    }

    // ESC to close modals and chat
    if (e.key === 'Escape') {
        document.getElementById('chatModal').style.display = 'none';
    }

    // Ctrl/Cmd + N to add new product
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        new bootstrap.Modal(document.getElementById('addProductModal')).show();
    }
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});