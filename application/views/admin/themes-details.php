@extends('admin/layout')

@section('content')

        <!-- Theme Detail Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="themes.html" class="breadcrumb-link">Themes</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Aurora</span>
                </div>
            </div>

            <div class="theme-detail-container">
                <!-- Theme Header -->
                <div class="theme-detail-header">
                    <div class="theme-detail-title-section">
                        <h1 class="theme-detail-title">Aurora</h1>
                        <p class="theme-detail-author">By <a href="#" class="theme-author-link">ThemeForge</a></p>
                    </div>
                    <div class="theme-detail-actions">
                        <button class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            Customize
                        </button>
                        <button class="btn btn-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            Live Preview
                        </button>
                    </div>
                </div>

                <!-- Hero Section: Slideshow + Quick Info -->
                <div class="theme-detail-hero">
                    <!-- Slideshow -->
                    <div class="theme-slideshow">
                        <div class="slideshow-container">
                            <div class="slideshow-slide active">
                                <img src="https://images.unsplash.com/photo-1618005198919-d3d4b5a92ead?w=800&h=600&fit=crop" alt="Aurora Screenshot 1">
                            </div>
                            <div class="slideshow-slide">
                                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&h=600&fit=crop" alt="Aurora Screenshot 2">
                            </div>
                            <div class="slideshow-slide">
                                <img src="https://images.unsplash.com/photo-1618004652321-13a63e576b80?w=800&h=600&fit=crop" alt="Aurora Screenshot 3">
                            </div>
                            <div class="slideshow-slide">
                                <img src="https://images.unsplash.com/photo-1618004912476-29818d81ae2e?w=800&h=600&fit=crop" alt="Aurora Screenshot 4">
                            </div>
                            <div class="slideshow-slide">
                                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&h=600&fit=crop" alt="Aurora Screenshot 5">
                            </div>
                        </div>
                        <button class="slideshow-btn prev">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <button class="slideshow-btn next">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                        <div class="slideshow-dots">
                            <span class="dot active" data-slide="0"></span>
                            <span class="dot" data-slide="1"></span>
                            <span class="dot" data-slide="2"></span>
                            <span class="dot" data-slide="3"></span>
                            <span class="dot" data-slide="4"></span>
                        </div>
                    </div>

                    <!-- Quick Info Sidebar -->
                    <div class="theme-quick-info">
                        <!-- Info Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-rating-display">
                                    <div class="rating-stars-small">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="star">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="star">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="star">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="star">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="star half">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                    <div class="rating-text-small">4.5 (1,247 reviews)</div>
                                </div>

                                <div class="theme-info-grid">
                                    <div class="info-item-compact">
                                        <span class="info-label">Version</span>
                                        <span class="info-value">2.1.4</span>
                                    </div>
                                    <div class="info-item-compact">
                                        <span class="info-label">Updated</span>
                                        <span class="info-value">Jan 10, 2026</span>
                                    </div>
                                    <div class="info-item-compact">
                                        <span class="info-label">Author</span>
                                        <a href="#" class="info-value info-link">ThemeForge</a>
                                    </div>
                                    <div class="info-item-compact">
                                        <span class="info-label">License</span>
                                        <span class="info-value">GPL v3</span>
                                    </div>
                                </div>

                                <div class="theme-price-display">
                                    <span class="price-label">Price</span>
                                    <span class="theme-price-large">$59</span>
                                </div>

                                <div class="theme-support-links">
                                    <a href="#" class="support-link-compact">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                        </svg>
                                        Documentation
                                    </a>
                                    <a href="#" class="support-link-compact">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        Support Forum
                                    </a>
                                    <a href="#" class="support-link-compact">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                        </svg>
                                        Report Issue
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Features Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Features</h3>
                            </div>
                            <div class="card-body">
                                <ul class="feature-list">
                                    <li>Fully responsive and mobile-optimized</li>
                                    <li>Dark mode support with automatic switching</li>
                                    <li>SEO optimized for better search rankings</li>
                                    <li>Lightning-fast performance (95+ PageSpeed score)</li>
                                    <li>Customizable colors and typography</li>
                                    <li>Multiple homepage layouts</li>
                                    <li>Blog layouts with various post formats</li>
                                    <li>Portfolio and gallery support</li>
                                    <li>WooCommerce ready for e-commerce</li>
                                    <li>Translation ready (WPML compatible)</li>
                                    <li>Regular updates and premium support</li>
                                    <li>Extensive documentation included</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Changelog -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Description</h2>
                    </div>
                    <div class="card-body">
                        <div class="theme-description-text">
                            <p style="margin-bottom: 16px;">Aurora is a modern, clean and responsive theme perfect for blogs and creative portfolios. Built with performance in mind, Aurora delivers lightning-fast load times without sacrificing visual appeal.</p>
                            <p style="margin-bottom: 16px;">Whether you're a blogger, photographer, designer, or small business owner, Aurora provides all the tools you need to create a stunning online presence. The theme is fully responsive and looks great on all devices, from desktop computers to smartphones.</p>
                            <p>With extensive customization options and multiple layout choices, you can easily make Aurora your own without touching a single line of code.</p>
                        </div>
                    </div>
                </div>

                <!-- Changelog -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Changelog</h2>
                    </div>
                    <div class="card-body">
                        <div class="changelog-grid">
                            <div class="changelog-item">
                                <div class="changelog-version">Version 2.1.4 <span class="changelog-date">January 10, 2026</span></div>
                                <ul class="changelog-list">
                                    <li>Fixed: Mobile menu animation on iOS devices</li>
                                    <li>Improved: Page load performance by 15%</li>
                                    <li>Updated: Font Awesome icons to version 6.5</li>
                                </ul>
                            </div>
                            <div class="changelog-item">
                                <div class="changelog-version">Version 2.1.3 <span class="changelog-date">December 20, 2025</span></div>
                                <ul class="changelog-list">
                                    <li>Added: New portfolio grid layout option</li>
                                    <li>Fixed: Dark mode toggle persistence issue</li>
                                    <li>Improved: Accessibility for screen readers</li>
                                </ul>
                            </div>
                            <div class="changelog-item">
                                <div class="changelog-version">Version 2.1.0 <span class="changelog-date">November 15, 2025</span></div>
                                <ul class="changelog-list">
                                    <li>Added: WooCommerce integration</li>
                                    <li>Added: Custom widget areas</li>
                                    <li>Improved: Overall theme performance</li>
                                </ul>
                            </div>
                            <div class="changelog-item">
                                <div class="changelog-version">Version 2.0.5 <span class="changelog-date">October 5, 2025</span></div>
                                <ul class="changelog-list">
                                    <li>Fixed: Comment form validation</li>
                                    <li>Improved: Mobile navigation UX</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

<!-- JS Scripts -->
@section('scripts')
    @parent
    <script>
        // Slideshow functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slideshow-slide');
        const dots = document.querySelectorAll('.slideshow-dots .dot');

        function showSlide(n) {
            if (n >= slides.length) currentSlide = 0;
            if (n < 0) currentSlide = slides.length - 1;

            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        function nextSlide() {
            currentSlide++;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide--;
            showSlide(currentSlide);
        }

        document.querySelector('.slideshow-btn.next').addEventListener('click', nextSlide);
        document.querySelector('.slideshow-btn.prev').addEventListener('click', prevSlide);

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
    </script>
@endsection