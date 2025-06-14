// Support & Help Center JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    setupSearch();
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

    // Category cards
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            const category = this.dataset.category;
            filterArticlesByCategory(category);
        });
    });

    // Article cards
    document.querySelectorAll('.article-card').forEach(card => {
        card.addEventListener('click', function() {
            const articleId = this.dataset.articleId;
            openArticle(articleId);
        });
    });

    // Video cards
    document.querySelectorAll('.video-play-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const videoId = this.dataset.videoId;
            openVideo(videoId);
        });
    });

    // FAQ questions
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', function() {
            const faqId = this.dataset.faq;
            toggleFAQ(faqId);
        });
    });

    // Support buttons
    document.getElementById('contactSupportBtn').addEventListener('click', openSupportModal);
    document.getElementById('liveChatBtn').addEventListener('click', startLiveChat);
    document.getElementById('scheduleCallBtn').addEventListener('click', scheduleCall);

    // Modal buttons
    document.getElementById('askQuestionBtn').addEventListener('click', openAskQuestionModal);
    document.getElementById('submitSupportRequest').addEventListener('click', submitSupportRequest);
    document.getElementById('submitQuestion').addEventListener('click', submitQuestion);

    // Load more buttons
    document.getElementById('loadMoreArticles').addEventListener('click', loadMoreArticles);
    document.getElementById('loadMoreVideos').addEventListener('click', loadMoreVideos);
    document.getElementById('loadMoreQuestions').addEventListener('click', loadMoreQuestions);

    // Article sorting
    document.getElementById('articleSort').addEventListener('change', function() {
        sortArticles(this.value);
    });

    // Me too buttons
    document.querySelectorAll('.me-too-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            toggleMeToo(this);
        });
    });

    // Helpful buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('helpful-btn')) {
            handleHelpfulVote(e.target);
        }
    });

    // Popular search tags
    document.querySelectorAll('.popular-search-tag').forEach(tag => {
        tag.addEventListener('click', function(e) {
            e.preventDefault();
            const query = this.dataset.query;
            performSearch(query);
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

function setupSearch() {
    const searchInput = document.getElementById('helpSearch');
    const suggestions = document.getElementById('searchSuggestions');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                showSearchSuggestions(query);
            }, 300);
        } else {
            hideSearchSuggestions();
        }
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch(this.value);
            hideSearchSuggestions();
        }
    });

    // Handle suggestion clicks
    suggestions.addEventListener('click', function(e) {
        if (e.target.classList.contains('search-suggestion')) {
            const query = e.target.dataset.query;
            searchInput.value = query;
            performSearch(query);
            hideSearchSuggestions();
        }
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            hideSearchSuggestions();
        }
    });
}

function showSearchSuggestions(query) {
    const suggestions = document.getElementById('searchSuggestions');
    
    // Filter suggestions based on query
    const allSuggestions = suggestions.querySelectorAll('.search-suggestion');
    let visibleCount = 0;
    
    allSuggestions.forEach(suggestion => {
        const text = suggestion.textContent.toLowerCase();
        if (text.includes(query.toLowerCase())) {
            suggestion.style.display = 'block';
            visibleCount++;
        } else {
            suggestion.style.display = 'none';
        }
    });
    
    if (visibleCount > 0) {
        suggestions.style.display = 'block';
    } else {
        hideSearchSuggestions();
    }
}

function hideSearchSuggestions() {
    document.getElementById('searchSuggestions').style.display = 'none';
}

function performSearch(query) {
    document.getElementById('helpSearch').value = query;
    
    // Simulate search results
    showToast(`Searching for: "${query}"`, 'info');
    
    // Filter articles based on search query
    filterArticlesBySearch(query);
}

function filterArticlesByCategory(category) {
    showToast(`Showing articles for: ${category}`, 'info');
    
    // Simulate category filtering
    const articles = document.querySelectorAll('.article-card');
    articles.forEach(article => {
        // Simple simulation - in real app, this would filter based on actual category data
        article.style.display = Math.random() > 0.3 ? 'block' : 'none';
    });
}

function filterArticlesBySearch(query) {
    const articles = document.querySelectorAll('.article-card');
    
    articles.forEach(article => {
        const title = article.querySelector('h6').textContent.toLowerCase();
        const content = article.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(query.toLowerCase()) || content.includes(query.toLowerCase())) {
            article.style.display = 'block';
        } else {
            article.style.display = 'none';
        }
    });
}

function sortArticles(sortBy) {
    showToast(`Sorting articles by: ${sortBy}`, 'info');
    
    // Simulate sorting - in real app, this would re-order the articles
    const articlesList = document.getElementById('articlesList');
    const articles = Array.from(articlesList.children);
    
    // Simple shuffle for demonstration
    articles.sort(() => Math.random() - 0.5);
    
    articles.forEach(article => {
        articlesList.appendChild(article);
    });
}

function openArticle(articleId) {
    const modal = new bootstrap.Modal(document.getElementById('articleModal'));
    const title = document.getElementById('articleModalTitle');
    const body = document.getElementById('articleModalBody');
    
    // Simulate loading article content
    title.textContent = 'Getting Started with labeltranslate: Complete Setup Guide';
    body.innerHTML = `
        <div class="article-content">
            <div class="mb-3">
                <span class="badge bg-primary me-2">Getting Started</span>
                <small class="text-muted">Published on Dec 5, 2024 • 5 min read</small>
            </div>
            
            <h4>Introduction</h4>
            <p>Welcome to labeltranslate! This comprehensive guide will walk you through setting up your account and creating your first professional label in just a few minutes.</p>
            
            <h4>Step 1: Account Setup</h4>
            <p>After signing up, you'll be taken to the dashboard where you can start uploading product images immediately. Make sure to verify your email address to unlock all features.</p>
            
            <h4>Step 2: Upload Your First Image</h4>
            <p>Click the "Create New Label" button and upload a clear, high-resolution image of your product. Supported formats include JPG, PNG, and TIFF.</p>
            
            <h4>Step 3: Review OCR Results</h4>
            <p>Our AI will automatically extract text from your image. Review the results and make any necessary corrections before proceeding to template selection.</p>
            
            <h4>Step 4: Choose a Template</h4>
            <p>Select from our library of professional templates or create a custom design. You can customize colors, fonts, and layout to match your brand.</p>
            
            <h4>Step 5: Generate and Download</h4>
            <p>Preview your label, make final adjustments, and download in your preferred format (PDF, PNG, or SVG).</p>
            
            <div class="alert alert-info mt-4">
                <i class="bi bi-lightbulb me-2"></i>
                <strong>Pro Tip:</strong> For best OCR results, ensure your product images are well-lit and the text is clearly visible.
            </div>
        </div>
    `;
    
    modal.show();
}

function openVideo(videoId) {
    const modal = new bootstrap.Modal(document.getElementById('videoModal'));
    const title = document.getElementById('videoModalTitle');
    const frame = document.getElementById('videoFrame');
    const description = document.getElementById('videoDescription');
    
    // Simulate video data
    const videos = {
        'tutorial-1': {
            title: 'Getting Started with labeltranslate',
            url: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            description: 'Complete walkthrough of setting up your account and creating your first label'
        },
        'tutorial-2': {
            title: 'OCR Best Practices',
            url: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            description: 'Learn how to optimize image quality for better text recognition results'
        },
        'tutorial-3': {
            title: 'Advanced Template Design',
            url: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            description: 'Create professional label templates with custom layouts and branding'
        },
        'tutorial-4': {
            title: 'Bulk Upload & Processing',
            url: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            description: 'Efficiently process multiple products and create labels in batches'
        }
    };
    
    const video = videos[videoId];
    if (video) {
        title.textContent = video.title;
        frame.src = video.url;
        description.textContent = video.description;
    }
    
    modal.show();
    
    // Clear video when modal is closed
    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
        frame.src = '';
    });
}

function toggleFAQ(faqId) {
    const answer = document.getElementById(`faq-${faqId}`);
    const question = document.querySelector(`[data-faq="${faqId}"]`);
    const icon = question.querySelector('i');
    
    if (answer.classList.contains('show')) {
        answer.classList.remove('show');
        icon.className = 'bi bi-chevron-down';
    } else {
        // Close all other FAQs
        document.querySelectorAll('.faq-answer.show').forEach(openAnswer => {
            openAnswer.classList.remove('show');
        });
        document.querySelectorAll('.faq-question i').forEach(openIcon => {
            openIcon.className = 'bi bi-chevron-down';
        });
        
        // Open this FAQ
        answer.classList.add('show');
        icon.className = 'bi bi-chevron-up';
    }
}

function openSupportModal() {
    const modal = new bootstrap.Modal(document.getElementById('supportModal'));
    modal.show();
}

function openAskQuestionModal() {
    const modal = new bootstrap.Modal(document.getElementById('askQuestionModal'));
    modal.show();
}

function startLiveChat() {
    // Simulate live chat
    showToast('Connecting to live chat...', 'info');
    
    setTimeout(() => {
        showToast('Live chat is currently unavailable. Please try again later or contact support via email.', 'warning');
    }, 2000);
}

function scheduleCall() {
    showToast('Redirecting to call scheduling...', 'info');
    
    // Simulate redirect to scheduling system
    setTimeout(() => {
        showToast('Call scheduling feature will be available soon!', 'info');
    }, 1500);
}

function submitSupportRequest() {
    const form = document.getElementById('supportForm');
    
    if (!validateForm(form)) {
        return;
    }
    
    const btn = document.getElementById('submitSupportRequest');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Sending...';
    btn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        showToast('Support request submitted successfully! We\'ll get back to you within 24 hours.', 'success');
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('supportModal'));
        modal.hide();
        
        form.reset();
    }, 2000);
}

function submitQuestion() {
    const form = document.getElementById('questionForm');
    
    if (!validateForm(form)) {
        return;
    }
    
    const btn = document.getElementById('submitQuestion');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Posting...';
    btn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        showToast('Question posted successfully! You\'ll be notified when someone answers.', 'success');
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('askQuestionModal'));
        modal.hide();
        
        form.reset();
    }, 2000);
}

function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

function toggleMeToo(button) {
    if (button.classList.contains('active')) {
        button.classList.remove('active');
        button.innerHTML = '<i class="bi bi-plus-circle me-1"></i>I have this problem too (8)';
    } else {
        button.classList.add('active');
        button.innerHTML = '<i class="bi bi-check-circle me-1"></i>I have this problem too (9)';
    }
}

function handleHelpfulVote(button) {
    const isYes = button.classList.contains('yes');
    
    // Disable both buttons
    const container = button.parentElement;
    container.querySelectorAll('.helpful-btn').forEach(btn => {
        btn.disabled = true;
    });
    
    // Show thank you message
    const message = isYes ? 'Thank you for your feedback!' : 'Thank you for your feedback. We\'ll work to improve this article.';
    showToast(message, 'success');
    
    // Update button text
    if (isYes) {
        button.innerHTML = '<i class="bi bi-check-circle me-1"></i>Thanks for your feedback!';
        button.classList.add('btn-success');
    } else {
        button.innerHTML = '<i class="bi bi-check-circle me-1"></i>Thanks for your feedback!';
        button.classList.add('btn-secondary');
    }
}

function loadMoreArticles() {
    const btn = document.getElementById('loadMoreArticles');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Loading...';
    btn.disabled = true;
    
    // Simulate loading
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        showToast('More articles loaded!', 'success');
    }, 1500);
}

function loadMoreVideos() {
    const btn = document.getElementById('loadMoreVideos');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Loading...';
    btn.disabled = true;
    
    // Simulate loading
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        showToast('More videos loaded!', 'success');
    }, 1500);
}

function loadMoreQuestions() {
    const btn = document.getElementById('loadMoreQuestions');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Loading...';
    btn.disabled = true;
    
    // Simulate loading
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        showToast('More questions loaded!', 'success');
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
                    "I can help you find information about OCR, templates, translations, and more. What specific topic are you looking for?",
                    "For OCR issues, I recommend checking our 'Improving OCR Accuracy' article. Would you like me to find it for you?",
                    "Template design questions are very common. Have you seen our video tutorial on advanced template design?",
                    "If you're having translation problems, our troubleshooting guide covers the most common issues and solutions.",
                    "For technical support, you can contact our team directly using the support form. They typically respond within 24 hours."
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
        hideSearchSuggestions();
    }

    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('helpSearch').focus();
    }
});