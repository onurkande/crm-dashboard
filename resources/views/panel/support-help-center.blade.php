@extends('panel.layouts.master')

@section('title', 'Support Help Center')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/support-help-center.css') }}">
@endsection

@section('meta')
    <meta name="description" content="Support Help Center">
    <meta name="keywords" content="Support Help Center">
    <meta name="author" content="labeltranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div class="container-fluid p-4">
        <div class="page-content">
            <!-- Hero Section -->
            <div class="hero-section">
                <h1 class="display-5 fw-bold mb-3">How can we help you?</h1>
                <p class="lead mb-4">Search our knowledge base, watch tutorials, or get in touch with our support team</p>
                
                <!-- Search Container -->
                <div class="search-container">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" 
                            placeholder="Search for help articles, tutorials, or FAQs..." 
                            id="helpSearch">
                    </div>
                    
                    <!-- Search Suggestions -->
                    <div class="search-suggestions" id="searchSuggestions">
                        <div class="search-suggestion" data-query="How does OCR work?">
                            <i class="bi bi-search me-2"></i>How does OCR work?
                        </div>
                        <div class="search-suggestion" data-query="Create label template">
                            <i class="bi bi-search me-2"></i>Create label template
                        </div>
                        <div class="search-suggestion" data-query="Translation not working">
                            <i class="bi bi-search me-2"></i>Translation not working
                        </div>
                        <div class="search-suggestion" data-query="Print quality issues">
                            <i class="bi bi-search me-2"></i>Print quality issues
                        </div>
                        <div class="search-suggestion" data-query="Bulk upload products">
                            <i class="bi bi-search me-2"></i>Bulk upload products
                        </div>
                    </div>
                </div>

                <!-- Popular Searches -->
                <div class="popular-searches">
                    <span class="text-white-50 me-2">Popular searches:</span>
                    <a href="#" class="popular-search-tag" data-query="OCR accuracy">OCR accuracy</a>
                    <a href="#" class="popular-search-tag" data-query="Template design">Template design</a>
                    <a href="#" class="popular-search-tag" data-query="Printing setup">Printing setup</a>
                    <a href="#" class="popular-search-tag" data-query="API integration">API integration</a>
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <h3 class="fw-bold mb-4">Browse by Category</h3>
                </div>
                
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card category-card" data-category="getting-started">
                        <div class="card-body text-center">
                            <div class="category-icon getting-started">
                                <i class="bi bi-play-circle"></i>
                            </div>
                            <h6 class="fw-semibold">Getting Started</h6>
                            <p class="text-muted small mb-0">Basic setup and first steps</p>
                            <small class="text-primary">12 articles</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card category-card" data-category="ocr">
                        <div class="card-body text-center">
                            <div class="category-icon ocr">
                                <i class="bi bi-eye"></i>
                            </div>
                            <h6 class="fw-semibold">OCR & Recognition</h6>
                            <p class="text-muted small mb-0">Text extraction and processing</p>
                            <small class="text-success">18 articles</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card category-card" data-category="templates">
                        <div class="card-body text-center">
                            <div class="category-icon templates">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <h6 class="fw-semibold">Templates</h6>
                            <p class="text-muted small mb-0">Design and customization</p>
                            <small class="text-warning">15 articles</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card category-card" data-category="translations">
                        <div class="card-body text-center">
                            <div class="category-icon translations">
                                <i class="bi bi-translate"></i>
                            </div>
                            <h6 class="fw-semibold">Translations</h6>
                            <p class="text-muted small mb-0">Multi-language support</p>
                            <small class="text-info">9 articles</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card category-card" data-category="printing">
                        <div class="card-body text-center">
                            <div class="category-icon printing">
                                <i class="bi bi-printer"></i>
                            </div>
                            <h6 class="fw-semibold">Printing</h6>
                            <p class="text-muted small mb-0">Print setup and quality</p>
                            <small class="text-danger">11 articles</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card category-card" data-category="troubleshooting">
                        <div class="card-body text-center">
                            <div class="category-icon troubleshooting">
                                <i class="bi bi-tools"></i>
                            </div>
                            <h6 class="fw-semibold">Troubleshooting</h6>
                            <p class="text-muted small mb-0">Common issues and fixes</p>
                            <small class="text-secondary">14 articles</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Featured Articles -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-star me-2"></i>Featured Articles
                            </h5>
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-sm" id="articleSort">
                                    <option value="featured">Featured</option>
                                    <option value="newest">Newest</option>
                                    <option value="most-read">Most Read</option>
                                    <option value="highest-rated">Highest Rated</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="articlesList">
                                <!-- Article 1 -->
                                <div class="article-card card mb-3" data-article-id="1">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2">Getting Started with labeltranslate: Complete Setup Guide</h6>
                                                <p class="text-muted mb-2">Learn how to set up your labeltranslate account, upload your first product images, and create professional labels in minutes.</p>
                                                <div class="article-meta d-flex align-items-center gap-3">
                                                    <span><i class="bi bi-calendar3 me-1"></i>Dec 5, 2024</span>
                                                    <span><i class="bi bi-eye me-1"></i>2,847 views</span>
                                                    <span><i class="bi bi-clock me-1"></i>5 min read</span>
                                                    <div class="article-rating">
                                                        <span class="rating-stars">★★★★★</span>
                                                        <span>(4.8)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary">Getting Started</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article 2 -->
                                <div class="article-card card mb-3" data-article-id="2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2">Improving OCR Accuracy: Best Practices and Tips</h6>
                                                <p class="text-muted mb-2">Discover techniques to enhance text recognition accuracy, including image quality optimization and preprocessing methods.</p>
                                                <div class="article-meta d-flex align-items-center gap-3">
                                                    <span><i class="bi bi-calendar3 me-1"></i>Dec 4, 2024</span>
                                                    <span><i class="bi bi-eye me-1"></i>1,923 views</span>
                                                    <span><i class="bi bi-clock me-1"></i>8 min read</span>
                                                    <div class="article-rating">
                                                        <span class="rating-stars">★★★★☆</span>
                                                        <span>(4.6)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge bg-success">OCR</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article 3 -->
                                <div class="article-card card mb-3" data-article-id="3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2">Creating Custom Label Templates: Design Guidelines</h6>
                                                <p class="text-muted mb-2">Step-by-step guide to designing professional label templates with proper typography, spacing, and branding elements.</p>
                                                <div class="article-meta d-flex align-items-center gap-3">
                                                    <span><i class="bi bi-calendar3 me-1"></i>Dec 3, 2024</span>
                                                    <span><i class="bi bi-eye me-1"></i>1,456 views</span>
                                                    <span><i class="bi bi-clock me-1"></i>12 min read</span>
                                                    <div class="article-rating">
                                                        <span class="rating-stars">★★★★★</span>
                                                        <span>(4.9)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge bg-warning">Templates</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article 4 -->
                                <div class="article-card card mb-3" data-article-id="4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2">Troubleshooting Translation Issues</h6>
                                                <p class="text-muted mb-2">Common translation problems and their solutions, including API configuration and language support.</p>
                                                <div class="article-meta d-flex align-items-center gap-3">
                                                    <span><i class="bi bi-calendar3 me-1"></i>Dec 2, 2024</span>
                                                    <span><i class="bi bi-eye me-1"></i>1,098 views</span>
                                                    <span><i class="bi bi-clock me-1"></i>6 min read</span>
                                                    <div class="article-rating">
                                                        <span class="rating-stars">★★★★☆</span>
                                                        <span>(4.4)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge bg-info">Translations</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article 5 -->
                                <div class="article-card card mb-3" data-article-id="5">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2">Print Quality Optimization: Settings and Calibration</h6>
                                                <p class="text-muted mb-2">Achieve perfect print results with proper printer settings, paper selection, and color calibration techniques.</p>
                                                <div class="article-meta d-flex align-items-center gap-3">
                                                    <span><i class="bi bi-calendar3 me-1"></i>Dec 1, 2024</span>
                                                    <span><i class="bi bi-eye me-1"></i>876 views</span>
                                                    <span><i class="bi bi-clock me-1"></i>10 min read</span>
                                                    <div class="article-rating">
                                                        <span class="rating-stars">★★★★☆</span>
                                                        <span>(4.5)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge bg-danger">Printing</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button class="btn btn-outline-primary" id="loadMoreArticles">
                                    <i class="bi bi-arrow-down me-1"></i> Load More Articles
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Educational Videos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-play-circle me-2"></i>Educational Videos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Video 1 -->
                                <div class="col-md-6">
                                    <div class="video-card card h-100">
                                        <div class="video-thumbnail">
                                            <img src="/placeholder.svg?height=200&width=300&text=labeltranslate+Tutorial+1" 
                                                class="img-fluid" alt="Getting Started Tutorial">
                                            <button class="video-play-btn" data-video-id="tutorial-1">
                                                <i class="bi bi-play-fill"></i>
                                            </button>
                                            <span class="video-duration">8:42</span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="fw-semibold">Getting Started with labeltranslate</h6>
                                            <p class="text-muted small mb-2">Complete walkthrough of setting up your account and creating your first label</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-eye me-1"></i>12,847 views
                                                </small>
                                                <small class="text-muted">Dec 5, 2024</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Video 2 -->
                                <div class="col-md-6">
                                    <div class="video-card card h-100">
                                        <div class="video-thumbnail">
                                            <img src="/placeholder.svg?height=200&width=300&text=OCR+Tutorial" 
                                                class="img-fluid" alt="OCR Tutorial">
                                            <button class="video-play-btn" data-video-id="tutorial-2">
                                                <i class="bi bi-play-fill"></i>
                                            </button>
                                            <span class="video-duration">12:15</span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="fw-semibold">OCR Best Practices</h6>
                                            <p class="text-muted small mb-2">Learn how to optimize image quality for better text recognition results</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-eye me-1"></i>8,923 views
                                                </small>
                                                <small class="text-muted">Dec 4, 2024</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Video 3 -->
                                <div class="col-md-6">
                                    <div class="video-card card h-100">
                                        <div class="video-thumbnail">
                                            <img src="/placeholder.svg?height=200&width=300&text=Template+Design" 
                                                class="img-fluid" alt="Template Design Tutorial">
                                            <button class="video-play-btn" data-video-id="tutorial-3">
                                                <i class="bi bi-play-fill"></i>
                                            </button>
                                            <span class="video-duration">15:30</span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="fw-semibold">Advanced Template Design</h6>
                                            <p class="text-muted small mb-2">Create professional label templates with custom layouts and branding</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-eye me-1"></i>6,456 views
                                                </small>
                                                <small class="text-muted">Dec 3, 2024</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Video 4 -->
                                <div class="col-md-6">
                                    <div class="video-card card h-100">
                                        <div class="video-thumbnail">
                                            <img src="/placeholder.svg?height=200&width=300&text=Bulk+Operations" 
                                                class="img-fluid" alt="Bulk Operations Tutorial">
                                            <button class="video-play-btn" data-video-id="tutorial-4">
                                                <i class="bi bi-play-fill"></i>
                                            </button>
                                            <span class="video-duration">10:22</span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="fw-semibold">Bulk Upload & Processing</h6>
                                            <p class="text-muted small mb-2">Efficiently process multiple products and create labels in batches</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-eye me-1"></i>4,789 views
                                                </small>
                                                <small class="text-muted">Dec 2, 2024</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button class="btn btn-outline-primary" id="loadMoreVideos">
                                    <i class="bi bi-arrow-down me-1"></i> Load More Videos
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Community Q&A -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-chat-square-dots me-2"></i>Community Q&A
                            </h5>
                            <button class="btn btn-primary btn-sm" id="askQuestionBtn">
                                <i class="bi bi-plus-circle me-1"></i> Ask Question
                            </button>
                        </div>
                        <div class="card-body">
                            <!-- Question 1 -->
                            <div class="community-question">
                                <div class="question-meta">
                                    <img src="/placeholder.svg?height=24&width=24&text=U1" 
                                        class="rounded-circle" width="24" height="24" alt="User">
                                    <span class="fw-semibold">Sarah Johnson</span>
                                    <span>•</span>
                                    <span>2 hours ago</span>
                                    <span class="badge bg-success ms-auto">Answered</span>
                                </div>
                                <h6 class="fw-semibold mb-2">How can I improve OCR accuracy for handwritten text?</h6>
                                <p class="text-muted mb-0">I'm having trouble with OCR recognition when processing handwritten product labels. The accuracy is quite low compared to printed text. Are there any specific settings or preprocessing steps I should follow?</p>
                                <div class="question-stats">
                                    <div class="stat-item">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        <span>12</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="bi bi-chat"></i>
                                        <span>3 answers</span>
                                    </div>
                                    <button class="me-too-btn">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        I have this problem too (8)
                                    </button>
                                </div>
                            </div>

                            <!-- Question 2 -->
                            <div class="community-question">
                                <div class="question-meta">
                                    <img src="/placeholder.svg?height=24&width=24&text=U2" 
                                        class="rounded-circle" width="24" height="24" alt="User">
                                    <span class="fw-semibold">Mike Chen</span>
                                    <span>•</span>
                                    <span>5 hours ago</span>
                                    <span class="badge bg-warning ms-auto">Pending</span>
                                </div>
                                <h6 class="fw-semibold mb-2">Best practices for multi-language label templates?</h6>
                                <p class="text-muted mb-0">I need to create labels that support both English and Spanish text. What's the best approach for handling different text lengths and character sets in template design?</p>
                                <div class="question-stats">
                                    <div class="stat-item">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        <span>7</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="bi bi-chat"></i>
                                        <span>1 answer</span>
                                    </div>
                                    <button class="me-too-btn">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        I have this problem too (5)
                                    </button>
                                </div>
                            </div>

                            <!-- Question 3 -->
                            <div class="community-question">
                                <div class="question-meta">
                                    <img src="/placeholder.svg?height=24&width=24&text=U3" 
                                        class="rounded-circle" width="24" height="24" alt="User">
                                    <span class="fw-semibold">Emma Rodriguez</span>
                                    <span>•</span>
                                    <span>1 day ago</span>
                                    <span class="badge bg-success ms-auto">Answered</span>
                                </div>
                                <h6 class="fw-semibold mb-2">Integration with external printing services?</h6>
                                <p class="text-muted mb-0">Is it possible to integrate labeltranslate with third-party printing services like PrintNode or similar APIs? Looking for automated printing workflows.</p>
                                <div class="question-stats">
                                    <div class="stat-item">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        <span>15</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="bi bi-chat"></i>
                                        <span>4 answers</span>
                                    </div>
                                    <button class="me-too-btn active">
                                        <i class="bi bi-check-circle me-1"></i>
                                        I have this problem too (12)
                                    </button>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button class="btn btn-outline-primary" id="loadMoreQuestions">
                                    <i class="bi bi-arrow-down me-1"></i> Load More Questions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- How To Cards -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-lightbulb me-2"></i>Quick How-To Guides
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- How To 1 -->
                            <div class="how-to-card mb-3">
                                <div class="step-number">1</div>
                                <h6 class="fw-semibold mb-2">Upload Product Image</h6>
                                <p class="text-muted small mb-0">Click the upload button and select a clear, high-resolution image of your product label.</p>
                            </div>

                            <!-- How To 2 -->
                            <div class="how-to-card mb-3">
                                <div class="step-number">2</div>
                                <h6 class="fw-semibold mb-2">Review OCR Results</h6>
                                <p class="text-muted small mb-0">Check the extracted text for accuracy and make any necessary corrections before proceeding.</p>
                            </div>

                            <!-- How To 3 -->
                            <div class="how-to-card mb-3">
                                <div class="step-number">3</div>
                                <h6 class="fw-semibold mb-2">Select Template</h6>
                                <p class="text-muted small mb-0">Choose from our pre-designed templates or create a custom layout for your labels.</p>
                            </div>

                            <!-- How To 4 -->
                            <div class="how-to-card">
                                <div class="step-number">4</div>
                                <h6 class="fw-semibold mb-2">Generate & Download</h6>
                                <p class="text-muted small mb-0">Preview your label, make final adjustments, and download in your preferred format.</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-question-circle me-2"></i>Frequently Asked Questions
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- FAQ 1 -->
                            <div class="faq-item">
                                <button class="faq-question" data-faq="1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>What image formats are supported for OCR?</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <div class="faq-answer" id="faq-1">
                                    <p class="mb-0">labeltranslate supports JPG, PNG, TIFF, and PDF formats. For best OCR results, use high-resolution images (300 DPI or higher) with clear, well-lit text.</p>
                                </div>
                            </div>

                            <!-- FAQ 2 -->
                            <div class="faq-item">
                                <button class="faq-question" data-faq="2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>How many languages are supported for translation?</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <div class="faq-answer" id="faq-2">
                                    <p class="mb-0">We support over 100 languages including Spanish, French, German, Chinese, Japanese, and many more. Check our language support page for the complete list.</p>
                                </div>
                            </div>

                            <!-- FAQ 3 -->
                            <div class="faq-item">
                                <button class="faq-question" data-faq="3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Can I customize label templates?</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <div class="faq-answer" id="faq-3">
                                    <p class="mb-0">Yes! You can modify existing templates or create completely custom designs. Our template editor supports custom fonts, colors, layouts, and branding elements.</p>
                                </div>
                            </div>

                            <!-- FAQ 4 -->
                            <div class="faq-item">
                                <button class="faq-question" data-faq="4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>What's the maximum file size for uploads?</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <div class="faq-answer" id="faq-4">
                                    <p class="mb-0">Individual files can be up to 50MB. For bulk uploads, you can process up to 100 files at once with a total size limit of 500MB.</p>
                                </div>
                            </div>

                            <!-- FAQ 5 -->
                            <div class="faq-item">
                                <button class="faq-question" data-faq="5">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Is there an API for integration?</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                                <div class="faq-answer" id="faq-5">
                                    <p class="mb-0">Yes, we provide a comprehensive REST API for OCR, translation, and label generation. Check our API documentation for detailed integration guides.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Support -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="fw-semibold mb-0">
                                <i class="bi bi-headset me-2"></i>Need More Help?
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Can't find what you're looking for? Our support team is here to help!</p>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="contactSupportBtn">
                                    <i class="bi bi-envelope me-2"></i>
                                    Contact Support
                                </button>
                                
                                <button class="btn btn-outline-secondary" id="liveChatBtn">
                                    <i class="bi bi-chat-dots me-2"></i>
                                    Live Chat
                                </button>
                                
                                <button class="btn btn-outline-info" id="scheduleCallBtn">
                                    <i class="bi bi-telephone me-2"></i>
                                    Schedule a Call
                                </button>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="text-center">
                                <small class="text-muted">
                                    <strong>Response Time:</strong><br>
                                    Email: 24 hours<br>
                                    Live Chat: 5 minutes<br>
                                    Phone: Same day
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Article Modal -->
    <div class="modal fade" id="articleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="articleModalTitle">Article Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="articleModalBody">
                    <!-- Article content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <div class="article-helpful w-100">
                        <h6>Was this article helpful?</h6>
                        <div class="helpful-buttons">
                            <button class="helpful-btn yes">
                                <i class="bi bi-hand-thumbs-up me-1"></i>
                                Yes, it was helpful
                            </button>
                            <button class="helpful-btn no">
                                <i class="bi bi-hand-thumbs-down me-1"></i>
                                No, it wasn't helpful
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalTitle">Video Tutorial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoFrame" src="/placeholder.svg" allowfullscreen></iframe>
                    </div>
                    <div class="mt-3">
                        <h6 id="videoDescription">Video Description</h6>
                        <div id="relatedArticles">
                            <h6 class="mt-3">Related Articles:</h6>
                            <ul class="list-unstyled">
                                <li><a href="#" class="text-decoration-none">Getting Started Guide</a></li>
                                <li><a href="#" class="text-decoration-none">OCR Best Practices</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Contact Modal -->
    <div class="modal fade" id="supportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact Support</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="supportForm">
                        <div class="mb-3">
                            <label for="supportName" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supportName" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="supportEmail" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="supportEmail" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="supportCategory" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="supportCategory" required>
                                <option value="">Select a category...</option>
                                <option value="technical">Technical Support</option>
                                <option value="billing">Billing & Account</option>
                                <option value="feature">Feature Request</option>
                                <option value="bug">Bug Report</option>
                                <option value="training">Training Request</option>
                                <option value="feedback">General Feedback</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="supportSubject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supportSubject" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="supportMessage" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="supportMessage" rows="5" required 
                                    placeholder="Please describe your issue or question in detail..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="supportPriority" class="form-label">Priority</label>
                            <select class="form-select" id="supportPriority">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="supportAttachment">
                            <label class="form-check-label" for="supportAttachment">
                                I have screenshots or files to attach (we'll follow up via email)
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitSupportRequest">
                        <i class="bi bi-send me-1"></i> Send Request
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ask Question Modal -->
    <div class="modal fade" id="askQuestionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ask a Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="questionForm">
                        <div class="mb-3">
                            <label for="questionTitle" class="form-label">Question Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="questionTitle" required 
                                placeholder="Summarize your question in one line">
                        </div>
                        
                        <div class="mb-3">
                            <label for="questionCategory" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="questionCategory" required>
                                <option value="">Select a category...</option>
                                <option value="getting-started">Getting Started</option>
                                <option value="ocr">OCR & Recognition</option>
                                <option value="templates">Templates</option>
                                <option value="translations">Translations</option>
                                <option value="printing">Printing</option>
                                <option value="troubleshooting">Troubleshooting</option>
                                <option value="api">API & Integration</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="questionDetails" class="form-label">Question Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="questionDetails" rows="5" required 
                                    placeholder="Provide as much detail as possible about your question or issue..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="questionTags" class="form-label">Tags (Optional)</label>
                            <input type="text" class="form-control" id="questionTags" 
                                placeholder="Add relevant tags separated by commas (e.g., ocr, template, printing)">
                            <small class="form-text text-muted">Tags help others find and answer your question</small>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Before posting:</strong> Please search existing questions and articles to see if your question has already been answered.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitQuestion">
                        <i class="bi bi-send me-1"></i> Post Question
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('panel-assets/js/support-help-center.js') }}"></script>
@endsection