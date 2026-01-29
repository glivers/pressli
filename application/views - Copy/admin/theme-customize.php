<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Aurora - Pressli CMS</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="customizer-mode">
    <!-- Customizer Layout -->
    <div class="customizer-container">
        <!-- Customizer Header -->
        <div class="customizer-header">
            <div class="customizer-header-left">
                <a href="themes.html" class="customizer-back-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </a>
                <div class="customizer-title">
                    <span class="customizer-title-label">Customizing</span>
                    <span class="customizer-title-name">Aurora</span>
                </div>
            </div>
            <div class="customizer-header-right">
                <button class="btn btn-secondary btn-sm">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                    </svg>
                    Reset
                </button>
                <button class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Publish
                </button>
            </div>
        </div>

        <!-- Customizer Body -->
        <div class="customizer-body">
            <!-- Controls Sidebar -->
            <div class="customizer-sidebar">
                <div class="customizer-controls">
                    <!-- Site Identity -->
                    <div class="customizer-section">
                        <button class="customizer-section-header" data-section="identity">
                            <span>Site Identity</span>
                            <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                        <div class="customizer-section-content">
                            <div class="customizer-control">
                                <label class="customizer-label">Logo</label>
                                <button class="btn btn-secondary btn-full btn-sm">Upload Logo</button>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="siteTitle">Site Title</label>
                                <input type="text" id="siteTitle" class="text-input" value="Pressli CMS">
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="siteTagline">Tagline</label>
                                <input type="text" id="siteTagline" class="text-input" value="Just another Pressli site">
                            </div>
                            <div class="customizer-control">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" checked>
                                    <span>Display site title</span>
                                </label>
                            </div>
                            <div class="customizer-control">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" checked>
                                    <span>Display tagline</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Colors -->
                    <div class="customizer-section">
                        <button class="customizer-section-header" data-section="colors">
                            <span>Colors</span>
                            <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                        <div class="customizer-section-content">
                            <div class="customizer-control">
                                <label class="customizer-label" for="primaryColor">Primary Color</label>
                                <div class="color-picker-wrapper">
                                    <input type="color" id="primaryColor" class="color-picker" value="#4f46e5">
                                    <input type="text" class="text-input" value="#4f46e5" readonly>
                                </div>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="accentColor">Accent Color</label>
                                <div class="color-picker-wrapper">
                                    <input type="color" id="accentColor" class="color-picker" value="#10b981">
                                    <input type="text" class="text-input" value="#10b981" readonly>
                                </div>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="bgColor">Background Color</label>
                                <div class="color-picker-wrapper">
                                    <input type="color" id="bgColor" class="color-picker" value="#ffffff">
                                    <input type="text" class="text-input" value="#ffffff" readonly>
                                </div>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="textColor">Text Color</label>
                                <div class="color-picker-wrapper">
                                    <input type="color" id="textColor" class="color-picker" value="#1f2937">
                                    <input type="text" class="text-input" value="#1f2937" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Typography -->
                    <div class="customizer-section">
                        <button class="customizer-section-header" data-section="typography">
                            <span>Typography</span>
                            <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                        <div class="customizer-section-content">
                            <div class="customizer-control">
                                <label class="customizer-label" for="headingFont">Heading Font</label>
                                <select id="headingFont" class="select-input">
                                    <option>System Default</option>
                                    <option selected>Inter</option>
                                    <option>Roboto</option>
                                    <option>Open Sans</option>
                                    <option>Lato</option>
                                    <option>Montserrat</option>
                                    <option>Playfair Display</option>
                                    <option>Merriweather</option>
                                </select>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="bodyFont">Body Font</label>
                                <select id="bodyFont" class="select-input">
                                    <option>System Default</option>
                                    <option selected>Inter</option>
                                    <option>Roboto</option>
                                    <option>Open Sans</option>
                                    <option>Lato</option>
                                    <option>PT Serif</option>
                                </select>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="fontSize">Base Font Size</label>
                                <div class="range-control">
                                    <input type="range" id="fontSize" class="range-input" min="14" max="20" value="16">
                                    <span class="range-value">16px</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="customizer-section">
                        <button class="customizer-section-header" data-section="header">
                            <span>Header</span>
                            <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                        <div class="customizer-section-content">
                            <div class="customizer-control">
                                <label class="customizer-label" for="headerLayout">Header Layout</label>
                                <select id="headerLayout" class="select-input">
                                    <option selected>Centered</option>
                                    <option>Left Aligned</option>
                                    <option>Split (Logo Left, Menu Right)</option>
                                </select>
                            </div>
                            <div class="customizer-control">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" checked>
                                    <span>Sticky header</span>
                                </label>
                            </div>
                            <div class="customizer-control">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>Transparent header on homepage</span>
                                </label>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="headerBg">Header Background</label>
                                <div class="color-picker-wrapper">
                                    <input type="color" id="headerBg" class="color-picker" value="#ffffff">
                                    <input type="text" class="text-input" value="#ffffff" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Homepage Settings -->
                    <div class="customizer-section">
                        <button class="customizer-section-header" data-section="homepage">
                            <span>Homepage Settings</span>
                            <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                        <div class="customizer-section-content">
                            <div class="customizer-control">
                                <label class="customizer-label" for="heroLayout">Hero Section Layout</label>
                                <select id="heroLayout" class="select-input">
                                    <option selected>Full Width</option>
                                    <option>Centered</option>
                                    <option>Split (Image + Text)</option>
                                    <option>None</option>
                                </select>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="postsLayout">Posts Layout</label>
                                <select id="postsLayout" class="select-input">
                                    <option selected>Grid (3 columns)</option>
                                    <option>Grid (2 columns)</option>
                                    <option>List</option>
                                    <option>Masonry</option>
                                </select>
                            </div>
                            <div class="customizer-control">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" checked>
                                    <span>Show featured posts section</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="customizer-section">
                        <button class="customizer-section-header" data-section="footer">
                            <span>Footer</span>
                            <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                        <div class="customizer-section-content">
                            <div class="customizer-control">
                                <label class="customizer-label" for="footerColumns">Footer Columns</label>
                                <select id="footerColumns" class="select-input">
                                    <option>1 Column</option>
                                    <option>2 Columns</option>
                                    <option>3 Columns</option>
                                    <option selected>4 Columns</option>
                                </select>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="copyrightText">Copyright Text</label>
                                <textarea id="copyrightText" class="textarea-input" rows="2">© 2026 Pressli CMS. All rights reserved.</textarea>
                            </div>
                            <div class="customizer-control">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" checked>
                                    <span>Show social icons</span>
                                </label>
                            </div>
                            <div class="customizer-control">
                                <label class="customizer-label" for="footerBg">Footer Background</label>
                                <div class="color-picker-wrapper">
                                    <input type="color" id="footerBg" class="color-picker" value="#1f2937">
                                    <input type="text" class="text-input" value="#1f2937" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Iframe -->
            <div class="customizer-preview">
                <div class="customizer-preview-toolbar">
                    <div class="preview-device-buttons">
                        <button class="preview-device-btn active" data-device="desktop" title="Desktop">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        </button>
                        <button class="preview-device-btn" data-device="tablet" title="Tablet">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                            </svg>
                        </button>
                        <button class="preview-device-btn" data-device="mobile" title="Mobile">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="7" y="2" width="10" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="customizer-preview-frame">
                    <iframe src="about:blank" title="Preview"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="js/admin.js"></script>
    <script>
        // Simple accordion for customizer sections
        document.querySelectorAll('.customizer-section-header').forEach(function(header) {
            header.addEventListener('click', function() {
                const section = this.parentElement;
                const isOpen = section.classList.contains('open');

                // Close all sections
                document.querySelectorAll('.customizer-section').forEach(function(s) {
                    s.classList.remove('open');
                });

                // Open clicked section if it was closed
                if (!isOpen) {
                    section.classList.add('open');
                }
            });
        });

        // Open first section by default
        document.querySelector('.customizer-section').classList.add('open');

        // Device preview buttons
        document.querySelectorAll('.preview-device-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.preview-device-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                const device = this.getAttribute('data-device');
                const previewFrame = document.querySelector('.customizer-preview-frame');
                previewFrame.className = 'customizer-preview-frame device-' + device;
            });
        });
    </script>
</body>
</html>
