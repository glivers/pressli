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

                                <!-- Update Theme Section -->
                                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                                    <h3 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 12px;">Update Theme</h3>

                                    <div id="updateStatus" class="alert" style="display: none; margin-bottom: 12px;"></div>

                                    <div id="updateArea" style="border: 2px dashed #d1d5db; border-radius: 8px; padding: 20px; text-align: center; background: #f9fafb; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#6366f1'; this.style.background='#eef2ff'" onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f9fafb'">
                                        <svg style="width: 32px; height: 32px; margin: 0 auto 8px; color: #6b7280;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                        </svg>
                                        <p id="updateText" style="color: #6b7280; font-size: 13px; margin: 0;">Drop new version ZIP or <span style="color: #6366f1; cursor: pointer;" id="updateBrowse">browse</span></p>
                                        <p id="updateHelp" style="color: #9ca3af; font-size: 12px; margin: 4px 0 0 0;">Maximum file size: 10 MB</p>
                                        <input type="file" id="updateFile" accept=".zip" style="display: none;">
                                    </div>

                                    <button id="updateBtn" class="btn btn-primary" style="width: 100%; margin-top: 12px; display: none;">Update Now</button>
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

        // Theme Update functionality
        const updateArea = document.getElementById('updateArea');
        const updateFile = document.getElementById('updateFile');
        const updateBrowse = document.getElementById('updateBrowse');
        const updateBtn = document.getElementById('updateBtn');
        const updateStatus = document.getElementById('updateStatus');
        const updateText = document.getElementById('updateText');
        const updateHelp = document.getElementById('updateHelp');

        // Browse link click
        updateBrowse.addEventListener('click', (e) => {
            e.stopPropagation();
            updateFile.click();
        });

        // Area click to open file picker
        updateArea.addEventListener('click', () => {
            updateFile.click();
        });

        // File input change
        updateFile.addEventListener('change', () => {
            if (updateFile.files[0]) {
                updateUploadUI(updateFile.files[0]);
                updateBtn.style.display = 'block';
            }
        });

        // Drag and drop
        updateArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            updateArea.style.borderColor = '#6366f1';
            updateArea.style.background = '#eef2ff';
        });

        updateArea.addEventListener('dragleave', () => {
            updateArea.style.borderColor = '#d1d5db';
            updateArea.style.background = '#f9fafb';
        });

        updateArea.addEventListener('drop', (e) => {
            e.preventDefault();
            updateArea.style.borderColor = '#d1d5db';
            updateArea.style.background = '#f9fafb';

            if (e.dataTransfer.files.length > 0) {
                updateFile.files = e.dataTransfer.files;
                updateUploadUI(e.dataTransfer.files[0]);
                updateBtn.style.display = 'block';
            }
        });

        // Update UI with selected file
        function updateUploadUI(file) {
            updateText.innerHTML = `<strong>${file.name}</strong> selected`;
            updateHelp.textContent = `Size: ${(file.size / (1024 * 1024)).toFixed(2)} MB`;
        }

        // Update button click
        updateBtn.addEventListener('click', async () => {
            if (!updateFile.files[0]) {
                showUpdateStatus('error', 'Please select a theme file to upload');
                return;
            }

            const file = updateFile.files[0];

            // Validate file type
            if (!file.name.endsWith('.zip')) {
                showUpdateStatus('error', 'Please upload a ZIP file');
                return;
            }

            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                showUpdateStatus('error', 'File size exceeds 10MB limit');
                return;
            }

            // Confirmation dialog
            if (!confirm('This will update your active theme. Your site will reload after update. Continue?')) {
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('theme_file', file);
            formData.append('csrf_token', '{{ Csrf::token() }}');

            // Disable button and show loading
            updateBtn.disabled = true;
            updateBtn.textContent = 'Updating...';
            showUpdateStatus('info', 'Uploading and updating theme...');

            try {
                const response = await fetch('{{ Url::link("admin/themes/update", $theme["name"]) }}', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showUpdateStatus('success', result.message);
                    // Reload page after 2 seconds to show new version
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
                else {
                    showUpdateStatus('error', result.message || 'Theme update failed');
                    updateBtn.disabled = false;
                    updateBtn.textContent = 'Update Now';
                }
            }
            catch (error) {
                showUpdateStatus('error', 'Failed to update theme. Please try again.');
                updateBtn.disabled = false;
                updateBtn.textContent = 'Update Now';
            }
        });

        function showUpdateStatus(type, message) {
            updateStatus.style.display = 'block';
            updateStatus.className = 'alert alert-' + type;
            updateStatus.textContent = message;
        }
    </script>
@endsection