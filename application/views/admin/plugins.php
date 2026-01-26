@extends('admin/layout')

@section('content')

        <!-- Plugins Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="content-title">Plugins</h1>
                <div class="content-actions">
                    <a href="plugin-add.html" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="plugin-tabs">
                    <button class="plugin-tab active">All <span class="plugin-tab-count">(7)</span></button>
                    <button class="plugin-tab">Active <span class="plugin-tab-count">(4)</span></button>
                    <button class="plugin-tab">Inactive <span class="plugin-tab-count">(3)</span></button>
                    <button class="plugin-tab">Updates <span class="plugin-tab-count">(2)</span></button>
                </div>

                <div class="card-body" style="padding: 0;">
                    <div class="plugins-list">
                        <!-- Plugin Item -->
                        <div class="plugin-item active">
                            <div class="plugin-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 6v6l4 2"></path>
                                </svg>
                            </div>
                            <div class="plugin-info">
                                <div class="plugin-header">
                                    <h3 class="plugin-name">Cache Pro</h3>
                                    <span class="plugin-status-badge active">Active</span>
                                    <div class="plugin-actions">
                                        <button class="plugin-action-link">Settings</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link">Deactivate</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link danger">Delete</button>
                                    </div>
                                </div>
                                <p class="plugin-description">Advanced caching solution that speeds up your site by storing static versions of pages and assets. Supports Redis and Memcached.</p>
                                <div class="plugin-footer">
                                    <span class="plugin-version">Version 3.2.1</span>
                                    <span class="plugin-separator">|</span>
                                    <span class="plugin-author">By <a href="#">CacheLabs</a></span>
                                </div>
                            </div>
                        </div>

                        <!-- Plugin Item -->
                        <div class="plugin-item active">
                            <div class="plugin-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                </svg>
                            </div>
                            <div class="plugin-info">
                                <div class="plugin-header">
                                    <h3 class="plugin-name">SEO Master</h3>
                                    <span class="plugin-status-badge active">Active</span>
                                    <div class="plugin-actions">
                                        <button class="plugin-action-link">Settings</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link">Deactivate</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link danger">Delete</button>
                                    </div>
                                </div>
                                <p class="plugin-description">Complete SEO toolkit with meta tags, sitemaps, schema markup, and social media integration. Improve your search rankings effortlessly.</p>
                                <div class="plugin-footer">
                                    <span class="plugin-version">Version 5.8.0</span>
                                    <span class="plugin-separator">|</span>
                                    <span class="plugin-author">By <a href="#">SEO Solutions</a></span>
                                </div>
                            </div>
                        </div>

                        <!-- Plugin Item -->
                        <div class="plugin-item active">
                            <div class="plugin-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <div class="plugin-info">
                                <div class="plugin-header">
                                    <h3 class="plugin-name">Security Shield</h3>
                                    <span class="plugin-status-badge active">Active</span>
                                    <div class="plugin-actions">
                                        <button class="plugin-action-link">Settings</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link">Deactivate</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link danger">Delete</button>
                                    </div>
                                </div>
                                <p class="plugin-description">Comprehensive security plugin with firewall, malware scanning, login protection, and two-factor authentication to keep your site safe.</p>
                                <div class="plugin-footer">
                                    <span class="plugin-version">Version 2.9.4</span>
                                    <span class="plugin-separator">|</span>
                                    <span class="plugin-author">By <a href="#">SecureWP</a></span>
                                </div>
                            </div>
                        </div>

                        <!-- Plugin Item -->
                        <div class="plugin-item active">
                            <div class="plugin-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </div>
                            <div class="plugin-info">
                                <div class="plugin-header">
                                    <h3 class="plugin-name">Contact Form Builder</h3>
                                    <span class="plugin-status-badge active">Active</span>
                                    <div class="plugin-actions">
                                        <button class="plugin-action-link">Settings</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link">Deactivate</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link danger">Delete</button>
                                    </div>
                                </div>
                                <p class="plugin-description">Drag-and-drop form builder with spam protection, email notifications, and integration with popular email marketing services.</p>
                                <div class="plugin-footer">
                                    <span class="plugin-version">Version 4.5.2</span>
                                    <span class="plugin-separator">|</span>
                                    <span class="plugin-author">By <a href="#">FormWorks</a></span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin Item -->
                        <div class="plugin-item">
                            <div class="plugin-icon inactive">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            <div class="plugin-info">
                                <div class="plugin-header">
                                    <h3 class="plugin-name">Backup Manager</h3>
                                    <div class="plugin-actions">
                                        <button class="plugin-action-link primary">Activate</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link danger">Delete</button>
                                    </div>
                                </div>
                                <p class="plugin-description">Automated backup solution with cloud storage support. Schedule backups and restore your site with one click.</p>
                                <div class="plugin-footer">
                                    <span class="plugin-version">Version 1.8.3</span>
                                    <span class="plugin-separator">|</span>
                                    <span class="plugin-author">By <a href="#">BackupPro</a></span>
                                </div>
                            </div>
                        </div>

                        <!-- Plugin Item -->
                        <div class="plugin-item">
                            <div class="plugin-icon inactive">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </div>
                            <div class="plugin-info">
                                <div class="plugin-header">
                                    <h3 class="plugin-name">Social Share Pro</h3>
                                    <div class="plugin-actions">
                                        <button class="plugin-action-link primary">Activate</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link danger">Delete</button>
                                    </div>
                                </div>
                                <p class="plugin-description">Add beautiful social sharing buttons to your posts and pages. Supports all major social networks with customizable styles.</p>
                                <div class="plugin-footer">
                                    <span class="plugin-version">Version 2.3.1</span>
                                    <span class="plugin-separator">|</span>
                                    <span class="plugin-author">By <a href="#">ShareTools</a></span>
                                </div>
                            </div>
                        </div>

                        <!-- Plugin Item -->
                        <div class="plugin-item">
                            <div class="plugin-icon inactive">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div class="plugin-info">
                                <div class="plugin-header">
                                    <h3 class="plugin-name">WooCommerce</h3>
                                    <div class="plugin-actions">
                                        <button class="plugin-action-link primary">Activate</button>
                                        <span class="plugin-separator">|</span>
                                        <button class="plugin-action-link danger">Delete</button>
                                    </div>
                                </div>
                                <p class="plugin-description">Transform your site into a fully functional online store. Sell physical and digital products with secure payment processing.</p>
                                <div class="plugin-footer">
                                    <span class="plugin-version">Version 7.4.0</span>
                                    <span class="plugin-separator">|</span>
                                    <span class="plugin-author">By <a href="#">Automattic</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection