@extends('admin/layout')

@section('content')

        <!-- Add Plugin Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="plugins.html" class="breadcrumb-link">Plugins</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Add New</span>
                </div>
            </div>

            <!-- Upload Plugin -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Upload Plugin</h2>
                </div>
                <div class="card-body">
                    <div class="upload-area">
                        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <p class="upload-text">Drop plugin .zip file here or <span class="upload-link">browse</span></p>
                        <p class="upload-help">Maximum file size: 50 MB</p>
                        <input type="file" class="upload-input" accept=".zip">
                    </div>
                </div>
            </div>

            <!-- Browse Plugin Directory -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Browse Plugin Directory</h2>
                </div>
                <div class="card-body">
                    <div class="theme-directory-filters">
                        <div class="search-box" style="flex: 1;">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                            <input type="search" placeholder="Search plugins...">
                        </div>
                        <select class="select-input">
                            <option>All Categories</option>
                            <option>SEO</option>
                            <option>Security</option>
                            <option>Performance</option>
                            <option>Forms</option>
                            <option>E-commerce</option>
                            <option>Social Media</option>
                        </select>
                        <select class="select-input">
                            <option>Sort by Popularity</option>
                            <option>Sort by Rating</option>
                            <option>Sort by Latest</option>
                            <option>Sort by Name</option>
                        </select>
                    </div>

                    <div class="themes-grid" style="margin-top: var(--spacing-lg);">
                        <!-- Plugin Card -->
                        <div class="theme-card">
                            <div class="theme-screenshot">
                                <div class="plugin-icon" style="width: 100%; height: 200px; border-radius: 0;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div class="theme-overlay">
                                    <button class="btn btn-primary">Install</button>
                                    <button class="btn btn-secondary">More Info</button>
                                </div>
                            </div>
                            <div class="theme-card-body">
                                <h4 class="theme-card-name">Performance Booster</h4>
                                <div class="theme-rating-mini">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    <span>4.8</span>
                                </div>
                                <p class="theme-card-author">By SpeedLabs</p>
                            </div>
                        </div>

                        <!-- Plugin Card -->
                        <div class="theme-card">
                            <div class="theme-screenshot">
                                <div class="plugin-icon" style="width: 100%; height: 200px; border-radius: 0;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </div>
                                <div class="theme-overlay">
                                    <button class="btn btn-primary">Install</button>
                                    <button class="btn btn-secondary">More Info</button>
                                </div>
                            </div>
                            <div class="theme-card-body">
                                <h4 class="theme-card-name">Firewall Pro</h4>
                                <div class="theme-rating-mini">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    <span>4.9</span>
                                </div>
                                <p class="theme-card-author">By SecureNet</p>
                            </div>
                        </div>

                        <!-- Plugin Card -->
                        <div class="theme-card">
                            <div class="theme-screenshot">
                                <div class="plugin-icon" style="width: 100%; height: 200px; border-radius: 0;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                </div>
                                <div class="theme-overlay">
                                    <button class="btn btn-primary">Install</button>
                                    <button class="btn btn-secondary">More Info</button>
                                </div>
                            </div>
                            <div class="theme-card-body">
                                <h4 class="theme-card-name">Live Chat Support</h4>
                                <div class="theme-rating-mini">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    <span>4.7</span>
                                </div>
                                <p class="theme-card-author">By ChatWorks</p>
                            </div>
                        </div>

                        <!-- Plugin Card -->
                        <div class="theme-card">
                            <div class="theme-screenshot">
                                <div class="plugin-icon" style="width: 100%; height: 200px; border-radius: 0;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </div>
                                <div class="theme-overlay">
                                    <button class="btn btn-primary">Install</button>
                                    <button class="btn btn-secondary">More Info</button>
                                </div>
                            </div>
                            <div class="theme-card-body">
                                <h4 class="theme-card-name">Social Amplify</h4>
                                <div class="theme-rating-mini">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    <span>4.6</span>
                                </div>
                                <p class="theme-card-author">By SocialBoost</p>
                            </div>
                        </div>

                        <!-- Plugin Card -->
                        <div class="theme-card">
                            <div class="theme-screenshot">
                                <div class="plugin-icon" style="width: 100%; height: 200px; border-radius: 0;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                                <div class="theme-overlay">
                                    <button class="btn btn-primary">Install</button>
                                    <button class="btn btn-secondary">More Info</button>
                                </div>
                            </div>
                            <div class="theme-card-body">
                                <h4 class="theme-card-name">Payment Gateway</h4>
                                <div class="theme-rating-mini">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    <span>4.9</span>
                                </div>
                                <p class="theme-card-author">By PaymentPro</p>
                            </div>
                        </div>

                        <!-- Plugin Card -->
                        <div class="theme-card">
                            <div class="theme-screenshot">
                                <div class="plugin-icon" style="width: 100%; height: 200px; border-radius: 0;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    </svg>
                                </div>
                                <div class="theme-overlay">
                                    <button class="btn btn-primary">Install</button>
                                    <button class="btn btn-secondary">More Info</button>
                                </div>
                            </div>
                            <div class="theme-card-body">
                                <h4 class="theme-card-name">Analytics Dashboard</h4>
                                <div class="theme-rating-mini">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    <span>4.8</span>
                                </div>
                                <p class="theme-card-author">By DataInsights</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
