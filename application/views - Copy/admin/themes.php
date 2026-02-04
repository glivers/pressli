@extends('admin/layout')

@section('content')

        <!-- Themes Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Themes</h1>
                <div class="header-actions-group">
                    <button class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Theme
                    </button>
                </div>
            </div>

            <!-- Current Theme -->
            <div class="current-theme-section">
                <h2 class="section-title">Current Theme</h2>
                <div class="current-theme-card">
                    <div class="current-theme-screenshot">
                        <img src="https://images.unsplash.com/photo-1618005198919-d3d4b5a92ead?w=800&h=600&fit=crop" alt="Aurora Theme">
                        <div class="theme-active-badge">Active</div>
                    </div>
                    <div class="current-theme-info">
                        <h3 class="theme-name">Aurora</h3>
                        <p class="theme-description">A modern, clean and responsive theme perfect for blogs and creative portfolios. Features dark mode support, customizable colors, and optimized performance.</p>
                        <div class="theme-meta">
                            <span class="theme-version">Version 2.1.4</span>
                            <span class="separator">•</span>
                            <span class="theme-author">By <a href="#" class="theme-author-link">ThemeForge</a></span>
                        </div>
                        <div class="current-theme-actions">
                            <button class="btn btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                                Customize
                            </button>
                            <button class="btn btn-secondary">Theme Details</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Themes -->
            <div class="available-themes-section">
                <h2 class="section-title">Available Themes</h2>
                <div class="themes-grid">
                    <!-- Theme Card 1 -->
                    <div class="theme-card">
                        <div class="theme-screenshot">
                            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop" alt="Horizon">
                            <div class="theme-overlay">
                                <button class="btn btn-primary btn-sm">Activate</button>
                                <button class="btn btn-secondary btn-sm">Live Preview</button>
                            </div>
                        </div>
                        <div class="theme-card-body">
                            <h4 class="theme-card-name">Horizon</h4>
                            <p class="theme-card-author">By DesignLab</p>
                            <div class="theme-card-actions">
                                <button class="theme-action-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                    </svg>
                                </button>
                                <button class="theme-action-btn danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Card 2 -->
                    <div class="theme-card">
                        <div class="theme-screenshot">
                            <img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?w=400&h=300&fit=crop" alt="Minimal">
                            <div class="theme-overlay">
                                <button class="btn btn-primary btn-sm">Activate</button>
                                <button class="btn btn-secondary btn-sm">Live Preview</button>
                            </div>
                        </div>
                        <div class="theme-card-body">
                            <h4 class="theme-card-name">Minimal</h4>
                            <p class="theme-card-author">By SimpleCraft</p>
                            <div class="theme-card-actions">
                                <button class="theme-action-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                    </svg>
                                </button>
                                <button class="theme-action-btn danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Card 3 -->
                    <div class="theme-card">
                        <div class="theme-screenshot">
                            <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop" alt="Velocity">
                            <div class="theme-overlay">
                                <button class="btn btn-primary btn-sm">Activate</button>
                                <button class="btn btn-secondary btn-sm">Live Preview</button>
                            </div>
                        </div>
                        <div class="theme-card-body">
                            <h4 class="theme-card-name">Velocity</h4>
                            <p class="theme-card-author">By SpeedThemes</p>
                            <div class="theme-card-actions">
                                <button class="theme-action-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                    </svg>
                                </button>
                                <button class="theme-action-btn danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Card 4 -->
                    <div class="theme-card">
                        <div class="theme-screenshot">
                            <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?w=400&h=300&fit=crop" alt="Bloom">
                            <div class="theme-overlay">
                                <button class="btn btn-primary btn-sm">Activate</button>
                                <button class="btn btn-secondary btn-sm">Live Preview</button>
                            </div>
                        </div>
                        <div class="theme-card-body">
                            <h4 class="theme-card-name">Bloom</h4>
                            <p class="theme-card-author">By CreativeWorks</p>
                            <div class="theme-card-actions">
                                <button class="theme-action-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                    </svg>
                                </button>
                                <button class="theme-action-btn danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Card 5 -->
                    <div class="theme-card">
                        <div class="theme-screenshot">
                            <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=400&h=300&fit=crop" alt="CodePress">
                            <div class="theme-overlay">
                                <button class="btn btn-primary btn-sm">Activate</button>
                                <button class="btn btn-secondary btn-sm">Live Preview</button>
                            </div>
                        </div>
                        <div class="theme-card-body">
                            <h4 class="theme-card-name">CodePress</h4>
                            <p class="theme-card-author">By DevStudio</p>
                            <div class="theme-card-actions">
                                <button class="theme-action-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                    </svg>
                                </button>
                                <button class="theme-action-btn danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Card 6 -->
                    <div class="theme-card">
                        <div class="theme-screenshot">
                            <img src="https://images.unsplash.com/photo-1555421689-d68471e189f2?w=400&h=300&fit=crop" alt="Portfolio Pro">
                            <div class="theme-overlay">
                                <button class="btn btn-primary btn-sm">Activate</button>
                                <button class="btn btn-secondary btn-sm">Live Preview</button>
                            </div>
                        </div>
                        <div class="theme-card-body">
                            <h4 class="theme-card-name">Portfolio Pro</h4>
                            <p class="theme-card-author">By ProThemes</p>
                            <div class="theme-card-actions">
                                <button class="theme-action-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                    </svg>
                                </button>
                                <button class="theme-action-btn danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
