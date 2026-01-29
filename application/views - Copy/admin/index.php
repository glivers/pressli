@extends('admin/layout')

@section('content')

        <!-- Dashboard Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Dashboard</h1>
                <button class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    New Post
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">147</div>
                        <div class="stat-label">Total Posts</div>
                        <div class="stat-change positive">+12% from last month</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">2,845</div>
                        <div class="stat-label">Total Visitors</div>
                        <div class="stat-change positive">+23% from last month</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">89</div>
                        <div class="stat-label">Comments</div>
                        <div class="stat-change">3 pending approval</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: #fce7f3; color: #db2777;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">94%</div>
                        <div class="stat-label">Performance</div>
                        <div class="stat-change positive">+2% from last week</div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Recent Posts -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Recent Posts</h2>
                        <a href="#" class="card-link">View all</a>
                    </div>
                    <div class="card-body">
                        <div class="list">
                            <div class="list-item">
                                <div class="list-item-content">
                                    <div class="list-item-title">Getting Started with Pressli CMS</div>
                                    <div class="list-item-meta">
                                        <span class="meta-item">Published</span>
                                        <span class="meta-dot">•</span>
                                        <span class="meta-item">2 hours ago</span>
                                    </div>
                                </div>
                                <div class="list-item-actions">
                                    <button class="btn-icon" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="list-item">
                                <div class="list-item-content">
                                    <div class="list-item-title">10 Tips for Better Content Management</div>
                                    <div class="list-item-meta">
                                        <span class="meta-item">Published</span>
                                        <span class="meta-dot">•</span>
                                        <span class="meta-item">1 day ago</span>
                                    </div>
                                </div>
                                <div class="list-item-actions">
                                    <button class="btn-icon" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="list-item">
                                <div class="list-item-content">
                                    <div class="list-item-title">Understanding PHP MVC Architecture</div>
                                    <div class="list-item-meta">
                                        <span class="meta-item">Draft</span>
                                        <span class="meta-dot">•</span>
                                        <span class="meta-item">3 days ago</span>
                                    </div>
                                </div>
                                <div class="list-item-actions">
                                    <button class="btn-icon" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="list-item">
                                <div class="list-item-content">
                                    <div class="list-item-title">How to Create Custom Themes</div>
                                    <div class="list-item-meta">
                                        <span class="meta-item">Published</span>
                                        <span class="meta-dot">•</span>
                                        <span class="meta-item">5 days ago</span>
                                    </div>
                                </div>
                                <div class="list-item-actions">
                                    <button class="btn-icon" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Recent Activity</h2>
                    </div>
                    <div class="card-body">
                        <div class="activity-feed">
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #eff6ff; color: #2563eb;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">
                                        <strong>Admin User</strong> published a new post
                                    </div>
                                    <div class="activity-time">2 hours ago</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon" style="background: #f0fdf4; color: #16a34a;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">
                                        New comment on <strong>"Getting Started"</strong>
                                    </div>
                                    <div class="activity-time">5 hours ago</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon" style="background: #fef3c7; color: #d97706;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">
                                        New user <strong>john.doe</strong> registered
                                    </div>
                                    <div class="activity-time">1 day ago</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon" style="background: #f3e8ff; color: #9333ea;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">
                                        Plugin <strong>"SEO Tools"</strong> activated
                                    </div>
                                    <div class="activity-time">2 days ago</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon" style="background: #fce7f3; color: #db2777;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                        <rect x="1" y="3" width="22" height="5"></rect>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">
                                        Theme updated to <strong>"Modern Blog v2.0"</strong>
                                    </div>
                                    <div class="activity-time">3 days ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Quick Actions</h2>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="#" class="quick-action">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                            <span>Create Post</span>
                        </a>
                        <a href="#" class="quick-action">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            <span>Create Page</span>
                        </a>
                        <a href="#" class="quick-action">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>Upload Media</span>
                        </a>
                        <a href="#" class="quick-action">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Add User</span>
                        </a>
                        <a href="#" class="quick-action">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                <rect x="1" y="3" width="22" height="5"></rect>
                            </svg>
                            <span>Browse Themes</span>
                        </a>
                        <a href="#" class="quick-action">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="20" x2="12" y2="10"></line>
                                <line x1="18" y1="20" x2="18" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="16"></line>
                            </svg>
                            <span>View Analytics</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
@endsection