<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{{ Csrf::token() }}}">
    <title>Customize {{ $theme['display_name'] ?? 'Theme' }} - Pressli CMS</title>
    <script>
        window.BASE = "{{ Url::base() }}";
    </script>
    <link rel="stylesheet" href="{{ Url::assets('admin/css/admin.css') }}">
</head>
<body class="customizer-mode">
    <!-- Customizer Layout -->
    <div class="customizer-container">
        <!-- Customizer Header -->
        <div class="customizer-header">
            <div class="customizer-header-left">
                <a href="{{ Url::link('admin/themes') }}" class="customizer-back-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </a>
                <div class="customizer-title">
                    <span class="customizer-title-label">Customizing</span>
                    <span class="customizer-title-name">{{ $theme['display_name'] ?? 'Theme' }}</span>
                </div>
            </div>
            <div class="customizer-header-right">
                <button type="button" class="btn btn-secondary btn-sm" id="reset-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                    </svg>
                    Reset
                </button>
                <button type="button" class="btn btn-primary" id="save-customizations">
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
                <!-- Message Container -->
                <div id="message-container"></div>

                <form id="customizer-form" method="POST" action="{{ Url::link('admin/themes/customize', $theme['name']) }}">
                    {{{ Csrf::field() }}}

                    <div class="customizer-controls">
                        <!-- Site Identity -->
                        <div class="customizer-section">
                            <button type="button" class="customizer-section-header" data-section="identity">
                                <span>Site Identity</span>
                                <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                            <div class="customizer-section-content">
                                <div class="customizer-control">
                                    <label class="customizer-label">Site Logo</label>
                                    <input type="hidden" name="site_logo" id="site-logo" value="{{ $settings['site_logo'] ?? '' }}">
                                    <button type="button" class="btn btn-secondary btn-full btn-sm" id="upload-logo-btn">
                                        {{ isset($settings['site_logo']) && $settings['site_logo'] ? 'Change Logo' : 'Upload Logo' }}
                                    </button>
                                    <div style="margin-top: 0.5rem;" id="logo-preview-container">
                                        <img src="{{ isset($settings['site_logo']) && $settings['site_logo'] ? $settings['site_logo'] : '' }}" alt="Logo preview" id="logo-preview" style="max-width: 100%; max-height: 80px; {{ isset($settings['site_logo']) && $settings['site_logo'] ? '' : 'display: none;' }}">
                                    </div>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label">Site Favicon</label>
                                    <input type="hidden" name="site_favicon" id="site-favicon" value="{{ $settings['site_favicon'] ?? '' }}">
                                    <button type="button" class="btn btn-secondary btn-full btn-sm" id="upload-favicon-btn">
                                        {{ isset($settings['site_favicon']) && $settings['site_favicon'] ? 'Change Favicon' : 'Upload Favicon' }}
                                    </button>
                                    <div style="margin-top: 0.5rem;" id="favicon-preview-container">
                                        <img src="{{ isset($settings['site_favicon']) && $settings['site_favicon'] ? $settings['site_favicon'] : '' }}" alt="Favicon preview" id="favicon-preview" style="max-width: 32px; max-height: 32px; {{ isset($settings['site_favicon']) && $settings['site_favicon'] ? '' : 'display: none;' }}">
                                    </div>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="site_title">Site Title</label>
                                    <input type="text" id="site_title" name="site_title" class="text-input" value="{{ $settings['site_title'] ?? '' }}">
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="site_tagline">Tagline</label>
                                    <input type="text" id="site_tagline" name="site_tagline" class="text-input" value="{{ $settings['site_tagline'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Colors -->
                        <div class="customizer-section">
                            <button type="button" class="customizer-section-header" data-section="colors">
                                <span>Colors</span>
                                <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                            <div class="customizer-section-content">
                                <div class="customizer-control">
                                    <label class="customizer-label" for="primary_color">Primary Color</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" id="primary_color" name="primary_color" class="color-picker" value="{{ $settings['primary_color'] ?? '' }}">
                                        <input type="text" class="text-input color-text" value="{{ $settings['primary_color'] ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="accent_color">Accent Color</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" id="accent_color" name="accent_color" class="color-picker" value="{{ $settings['accent_color'] ?? '' }}">
                                        <input type="text" class="text-input color-text" value="{{ $settings['accent_color'] ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="background_color">Background Color</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" id="background_color" name="background_color" class="color-picker" value="{{ $settings['background_color'] ?? '' }}">
                                        <input type="text" class="text-input color-text" value="{{ $settings['background_color'] ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="text_color">Text Color</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" id="text_color" name="text_color" class="color-picker" value="{{ $settings['text_color'] ?? '' }}">
                                        <input type="text" class="text-input color-text" value="{{ $settings['text_color'] ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="heading_color">Heading Color</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" id="heading_color" name="heading_color" class="color-picker" value="{{ $settings['heading_color'] ?? '' }}">
                                        <input type="text" class="text-input color-text" value="{{ $settings['heading_color'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Typography -->
                        <div class="customizer-section">
                            <button type="button" class="customizer-section-header" data-section="typography">
                                <span>Typography</span>
                                <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                            <div class="customizer-section-content">
                                <div class="customizer-control">
                                    <label class="customizer-label" for="heading_font">Heading Font</label>
                                    <select id="heading_font" name="heading_font" class="select-input">
                                        <option value="system" {{ ($settings['heading_font'] ?? '') == 'system' ? 'selected' : '' }}>System Default</option>
                                        <option value="inter" {{ ($settings['heading_font'] ?? '') == 'inter' ? 'selected' : '' }}>Inter</option>
                                        <option value="roboto" {{ ($settings['heading_font'] ?? '') == 'roboto' ? 'selected' : '' }}>Roboto</option>
                                        <option value="opensans" {{ ($settings['heading_font'] ?? '') == 'opensans' ? 'selected' : '' }}>Open Sans</option>
                                        <option value="lato" {{ ($settings['heading_font'] ?? '') == 'lato' ? 'selected' : '' }}>Lato</option>
                                        <option value="montserrat" {{ ($settings['heading_font'] ?? '') == 'montserrat' ? 'selected' : '' }}>Montserrat</option>
                                        <option value="playfair" {{ ($settings['heading_font'] ?? '') == 'playfair' ? 'selected' : '' }}>Playfair Display</option>
                                        <option value="merriweather" {{ ($settings['heading_font'] ?? '') == 'merriweather' ? 'selected' : '' }}>Merriweather</option>
                                    </select>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="body_font">Body Font</label>
                                    <select id="body_font" name="body_font" class="select-input">
                                        <option value="system" {{ ($settings['body_font'] ?? '') == 'system' ? 'selected' : '' }}>System Default</option>
                                        <option value="inter" {{ ($settings['body_font'] ?? '') == 'inter' ? 'selected' : '' }}>Inter</option>
                                        <option value="roboto" {{ ($settings['body_font'] ?? '') == 'roboto' ? 'selected' : '' }}>Roboto</option>
                                        <option value="opensans" {{ ($settings['body_font'] ?? '') == 'opensans' ? 'selected' : '' }}>Open Sans</option>
                                        <option value="lato" {{ ($settings['body_font'] ?? '') == 'lato' ? 'selected' : '' }}>Lato</option>
                                        <option value="ptserif" {{ ($settings['body_font'] ?? '') == 'ptserif' ? 'selected' : '' }}>PT Serif</option>
                                    </select>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="body_font_size">Base Font Size</label>
                                    <div class="range-control">
                                        <input type="range" id="body_font_size" name="body_font_size" class="range-input" min="14" max="20" value="{{ $settings['body_font_size'] ?? '' }}">
                                        <span class="range-value">{{ $settings['body_font_size'] ?? '' }}px</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Layout -->
                        <div class="customizer-section">
                            <button type="button" class="customizer-section-header" data-section="layout">
                                <span>Layout</span>
                                <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                            <div class="customizer-section-content">
                                <div class="customizer-control">
                                    <label class="customizer-label" for="sidebar_position">Sidebar Position</label>
                                    <select id="sidebar_position" name="sidebar_position" class="select-input">
                                        <option value="left" {{ ($settings['sidebar_position'] ?? '') == 'left' ? 'selected' : '' }}>Left</option>
                                        <option value="right" {{ ($settings['sidebar_position'] ?? '') == 'right' ? 'selected' : '' }}>Right</option>
                                        <option value="none" {{ ($settings['sidebar_position'] ?? '') == 'none' ? 'selected' : '' }}>None</option>
                                    </select>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="content_width">Content Width</label>
                                    <select id="content_width" name="content_width" class="select-input">
                                        <option value="narrow" {{ ($settings['content_width'] ?? '') == 'narrow' ? 'selected' : '' }}>Narrow (800px)</option>
                                        <option value="medium" {{ ($settings['content_width'] ?? '') == 'medium' ? 'selected' : '' }}>Medium (1000px)</option>
                                        <option value="wide" {{ ($settings['content_width'] ?? '') == 'wide' ? 'selected' : '' }}>Wide (1200px)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Header -->
                        <div class="customizer-section">
                            <button type="button" class="customizer-section-header" data-section="header">
                                <span>Header</span>
                                <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                            <div class="customizer-section-content">
                                <div class="customizer-control">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="show_site_title" value="1" class="checkbox" {{ ($settings['show_site_title'] ?? '') == '1' ? 'checked' : '' }}>
                                        <span>Display Site Title</span>
                                    </label>
                                </div>

                                <div class="customizer-control">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="show_tagline" value="1" class="checkbox" {{ ($settings['show_tagline'] ?? '') == '1' ? 'checked' : '' }}>
                                        <span>Display Tagline</span>
                                    </label>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="header_layout">Header Layout</label>
                                    <select id="header_layout" name="header_layout" class="select-input">
                                        <option value="logo-left" {{ ($settings['header_layout'] ?? '') == 'logo-left' ? 'selected' : '' }}>Logo Left</option>
                                        <option value="logo-center" {{ ($settings['header_layout'] ?? '') == 'logo-center' ? 'selected' : '' }}>Logo Center</option>
                                        <option value="logo-right" {{ ($settings['header_layout'] ?? '') == 'logo-right' ? 'selected' : '' }}>Logo Right</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="customizer-section">
                            <button type="button" class="customizer-section-header" data-section="footer">
                                <span>Footer</span>
                                <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                            <div class="customizer-section-content">
                                <div class="customizer-control">
                                    <label class="customizer-label" for="footer_text">Copyright Text</label>
                                    <textarea id="footer_text" name="footer_text" class="textarea-input" rows="2">{{ $settings['footer_text'] ?? '' }}</textarea>
                                </div>

                                <div class="customizer-control">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="show_social_links" value="1" class="checkbox" {{ ($settings['show_social_links'] ?? '') == '1' ? 'checked' : '' }}>
                                        <span>Show Social Icons</span>
                                    </label>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="footer_columns">Footer Columns</label>
                                    <select id="footer_columns" name="footer_columns" class="select-input">
                                        <option value="1" {{ ($settings['footer_columns'] ?? '') == '1' ? 'selected' : '' }}>1 Column</option>
                                        <option value="2" {{ ($settings['footer_columns'] ?? '') == '2' ? 'selected' : '' }}>2 Columns</option>
                                        <option value="3" {{ ($settings['footer_columns'] ?? '') == '3' ? 'selected' : '' }}>3 Columns</option>
                                        <option value="4" {{ ($settings['footer_columns'] ?? '') == '4' ? 'selected' : '' }}>4 Columns</option>
                                    </select>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="footer_background">Footer Background</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" id="footer_background" name="footer_background" class="color-picker" value="{{ $settings['footer_background'] ?? '' }}">
                                        <input type="text" class="text-input color-text" value="{{ $settings['footer_background'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Blog -->
                        <div class="customizer-section">
                            <button type="button" class="customizer-section-header" data-section="blog">
                                <span>Blog</span>
                                <svg class="customizer-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                            <div class="customizer-section-content">
                                <div class="customizer-control">
                                    <label class="customizer-label" for="excerpt_length">Excerpt Length</label>
                                    <select id="excerpt_length" name="excerpt_length" class="select-input">
                                        <option value="50" {{ ($settings['excerpt_length'] ?? '') == '50' ? 'selected' : '' }}>50 words</option>
                                        <option value="100" {{ ($settings['excerpt_length'] ?? '') == '100' ? 'selected' : '' }}>100 words</option>
                                        <option value="150" {{ ($settings['excerpt_length'] ?? '') == '150' ? 'selected' : '' }}>150 words</option>
                                        <option value="200" {{ ($settings['excerpt_length'] ?? '') == '200' ? 'selected' : '' }}>200 words</option>
                                    </select>
                                </div>

                                <div class="customizer-control">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="show_featured_image" value="1" class="checkbox" {{ ($settings['show_featured_image'] ?? '') == '1' ? 'checked' : '' }}>
                                        <span>Show Featured Image on Archive</span>
                                    </label>
                                </div>

                                <div class="customizer-control">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="show_post_date" value="1" class="checkbox" {{ ($settings['show_post_date'] ?? '') == '1' ? 'checked' : '' }}>
                                        <span>Show Post Date</span>
                                    </label>
                                </div>

                                <div class="customizer-control">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="show_author" value="1" class="checkbox" {{ ($settings['show_author'] ?? '') == '1' ? 'checked' : '' }}>
                                        <span>Show Author Name</span>
                                    </label>
                                </div>

                                <div class="customizer-control">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="show_categories" value="1" class="checkbox" {{ ($settings['show_categories'] ?? '') == '1' ? 'checked' : '' }}>
                                        <span>Show Categories</span>
                                    </label>
                                </div>

                                <div class="customizer-control">
                                    <label class="customizer-label" for="posts_layout">Posts Layout</label>
                                    <select id="posts_layout" name="posts_layout" class="select-input">
                                        <option value="grid-3" {{ ($settings['posts_layout'] ?? '') == 'grid-3' ? 'selected' : '' }}>Grid (3 columns)</option>
                                        <option value="grid-2" {{ ($settings['posts_layout'] ?? '') == 'grid-2' ? 'selected' : '' }}>Grid (2 columns)</option>
                                        <option value="list" {{ ($settings['posts_layout'] ?? '') == 'list' ? 'selected' : '' }}>List</option>
                                        <option value="masonry" {{ ($settings['posts_layout'] ?? '') == 'masonry' ? 'selected' : '' }}>Masonry</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Preview Iframe -->
            <div class="customizer-preview">
                <div class="customizer-preview-toolbar">
                    <div class="preview-device-buttons">
                        <button type="button" class="preview-device-btn active" data-device="desktop" title="Desktop">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        </button>
                        <button type="button" class="preview-device-btn" data-device="tablet" title="Tablet">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                            </svg>
                        </button>
                        <button type="button" class="preview-device-btn" data-device="mobile" title="Mobile">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="7" y="2" width="10" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="customizer-preview-frame">
                    <iframe id="theme-preview" src="{{ Url::base() }}" title="Preview"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ Url::assets('admin/js/admin.js') }}"></script>
    <script src="{{ Url::assets('admin/js/media.js') }}"></script>
    <script src="{{ Url::assets('admin/js/media-picker.js') }}"></script>
    <script src="{{ Url::assets('admin/js/theme-customizer.js') }}"></script>
    <script>
        // Accordion for customizer sections
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

        // Media picker for logo
        document.getElementById('upload-logo-btn').addEventListener('click', function() {
            const picker = new MediaPicker(function(media) {
                document.getElementById('site-logo').value = media.url;
                const preview = document.getElementById('logo-preview');
                if (preview) {
                    preview.src = media.url;
                    preview.style.display = 'block';
                }
            });
            picker.open();
        });

        // Media picker for favicon
        document.getElementById('upload-favicon-btn').addEventListener('click', function() {
            const picker = new MediaPicker(function(media) {
                document.getElementById('site-favicon').value = media.url;
                const preview = document.getElementById('favicon-preview');
                if (preview) {
                    preview.src = media.url;
                    preview.style.display = 'block';
                }
            });
            picker.open();
        });

        // Reset button
        document.getElementById('reset-btn').addEventListener('click', function() {
            if (confirm('Are you sure you want to reset all customizations to default values?')) {
                window.location.href = '{{ Url::link("admin/themes/reset", $theme["name"]) }}';
            }
        });
    </script>
</body>
</html>
