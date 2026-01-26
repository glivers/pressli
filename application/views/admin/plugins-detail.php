@extends('admin/layout')

@section('content')
        <!-- Plugin Detail Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="plugins.html" class="breadcrumb-link">Plugins</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Cache Pro</span>
                </div>
            </div>

            <!-- Plugin Header -->
            <div class="plugin-detail-header">
                <div class="plugin-detail-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 6v6l4 2"></path>
                    </svg>
                </div>
                <div class="plugin-detail-info">
                    <h1 class="plugin-detail-title">Cache Pro</h1>
                    <p class="plugin-detail-author">By <a href="#">CacheLabs</a> | Version 3.2.1</p>
                </div>
                <div class="plugin-detail-actions">
                    <button class="btn btn-danger">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        Deactivate
                    </button>
                </div>
            </div>

            <!-- Settings Tabs -->
            <div class="card">
                <div class="plugin-settings-tabs">
                    <button class="plugin-settings-tab active">General</button>
                    <button class="plugin-settings-tab">Advanced</button>
                    <button class="plugin-settings-tab">Cache Rules</button>
                    <button class="plugin-settings-tab">CDN</button>
                </div>

                <div class="card-body">
                    <form class="settings-form">
                        <!-- General Settings -->
                        <div class="settings-section">
                            <h3 class="settings-section-title">Cache Settings</h3>

                            <div class="form-group-grid">
                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox" checked>
                                        Enable Page Caching
                                    </label>
                                    <p class="form-help">Cache entire pages to improve load times</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox" checked>
                                        Enable Browser Caching
                                    </label>
                                    <p class="form-help">Set browser cache expiration headers</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox">
                                        Enable Object Caching
                                    </label>
                                    <p class="form-help">Cache database query results (requires Redis or Memcached)</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="cache-lifetime">Cache Lifetime</label>
                                    <select id="cache-lifetime" class="text-input">
                                        <option>1 hour</option>
                                        <option>6 hours</option>
                                        <option selected>12 hours</option>
                                        <option>24 hours</option>
                                        <option>7 days</option>
                                        <option>30 days</option>
                                    </select>
                                    <p class="form-help">How long cached content should be stored</p>
                                </div>
                            </div>
                        </div>

                        <div class="settings-section">
                            <h3 class="settings-section-title">Asset Optimization</h3>

                            <div class="form-group-grid">
                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox" checked>
                                        Minify HTML
                                    </label>
                                    <p class="form-help">Remove whitespace and comments from HTML</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox" checked>
                                        Minify CSS
                                    </label>
                                    <p class="form-help">Compress CSS files for faster loading</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox" checked>
                                        Minify JavaScript
                                    </label>
                                    <p class="form-help">Compress JavaScript files</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox">
                                        Combine CSS Files
                                    </label>
                                    <p class="form-help">Merge multiple CSS files into one</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <input type="checkbox">
                                        Combine JavaScript Files
                                    </label>
                                    <p class="form-help">Merge multiple JavaScript files into one</p>
                                </div>
                            </div>
                        </div>

                        <div class="settings-section">
                            <h3 class="settings-section-title">Exclusions</h3>

                            <div class="form-group">
                                <label class="form-label" for="exclude-urls">Exclude URLs from Caching</label>
                                <textarea id="exclude-urls" class="textarea-input" rows="4" placeholder="/cart&#10;/checkout&#10;/my-account&#10;/admin/*"></textarea>
                                <p class="form-help">One URL pattern per line. Use * as wildcard.</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="exclude-cookies">Exclude Cookies</label>
                                <input type="text" id="exclude-cookies" class="text-input" placeholder="wordpress_logged_in_, comment_author_">
                                <p class="form-help">Comma-separated list of cookie names to exclude from caching</p>
                            </div>
                        </div>

                        <div class="settings-section">
                            <h3 class="settings-section-title">Cache Management</h3>

                            <div class="form-group">
                                <label class="form-label">Cache Statistics</label>
                                <div class="stats-row">
                                    <div class="stat-item">
                                        <div class="stat-value">2.4 GB</div>
                                        <div class="stat-label">Cache Size</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">1,247</div>
                                        <div class="stat-label">Cached Pages</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">89%</div>
                                        <div class="stat-label">Hit Rate</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Clear Cache</label>
                                <div style="display: flex; gap: 12px;">
                                    <button type="button" class="btn btn-secondary">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="1 4 1 10 7 10"></polyline>
                                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                        </svg>
                                        Clear All Cache
                                    </button>
                                    <button type="button" class="btn btn-secondary">Clear Page Cache</button>
                                    <button type="button" class="btn btn-secondary">Clear Asset Cache</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary">Reset to Defaults</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
@endsection
