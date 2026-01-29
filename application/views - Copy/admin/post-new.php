@extends('admin/layout')

@section('content')

        <!-- Add New Post Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Add New Post</h1>
                <div class="header-actions-group">
                    <button class="btn btn-secondary">Save Draft</button>
                    <button class="btn btn-primary">Publish</button>
                </div>
            </div>

            <div class="editor-layout">
                <!-- Main Editor Area -->
                <div class="editor-main">
                    <!-- Title Input -->
                    <div class="editor-title-wrapper">
                        <input type="text" class="editor-title" placeholder="Add title" autofocus>
                    </div>

                    <!-- Permalink -->
                    <div class="permalink-wrapper">
                        <span class="permalink-label">Permalink:</span>
                        <a href="#" class="permalink-url">https://yoursite.com/</a>
                        <input type="text" class="permalink-input" placeholder="post-slug">
                        <button class="permalink-edit-btn">Edit</button>
                    </div>

                    <!-- Content Editor -->
                    <div class="editor-content-wrapper">
                        <textarea class="editor-content" placeholder="Start writing your post..."></textarea>
                    </div>

                    <!-- Editor Toolbar (Simple) -->
                    <div class="editor-toolbar">
                        <button class="toolbar-btn" title="Bold" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                                <path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                            </svg>
                        </button>
                        <button class="toolbar-btn" title="Italic" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="19" y1="4" x2="10" y2="4"></line>
                                <line x1="14" y1="20" x2="5" y2="20"></line>
                                <line x1="15" y1="4" x2="9" y2="20"></line>
                            </svg>
                        </button>
                        <button class="toolbar-btn" title="Link" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                            </svg>
                        </button>
                        <div class="toolbar-divider"></div>
                        <button class="toolbar-btn" title="Heading" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="4 7 4 4 20 4 20 7"></polyline>
                                <line x1="9" y1="20" x2="15" y2="20"></line>
                                <line x1="12" y1="4" x2="12" y2="20"></line>
                            </svg>
                        </button>
                        <button class="toolbar-btn" title="Bullet List" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                        </button>
                        <button class="toolbar-btn" title="Numbered List" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="10" y1="6" x2="21" y2="6"></line>
                                <line x1="10" y1="12" x2="21" y2="12"></line>
                                <line x1="10" y1="18" x2="21" y2="18"></line>
                                <path d="M4 6h1v4"></path>
                                <path d="M4 10h2"></path>
                                <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path>
                            </svg>
                        </button>
                        <div class="toolbar-divider"></div>
                        <button class="toolbar-btn" title="Image" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </button>
                        <button class="toolbar-btn" title="Code" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                            </svg>
                        </button>
                    </div>

                    <!-- Excerpt -->
                    <div class="form-section">
                        <label class="form-label">Excerpt</label>
                        <textarea class="form-textarea" rows="3" placeholder="Write a short excerpt for this post..."></textarea>
                        <p class="form-help">The excerpt is used in search results and social media previews.</p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="editor-sidebar">
                    <!-- Publish Options -->
                    <div class="sidebar-panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Publish</h3>
                        </div>
                        <div class="panel-body">
                            <div class="publish-options">
                                <div class="publish-option">
                                    <span class="option-label">Status:</span>
                                    <span class="option-value">Draft</span>
                                </div>
                                <div class="publish-option">
                                    <span class="option-label">Visibility:</span>
                                    <span class="option-value">Public</span>
                                </div>
                                <div class="publish-option">
                                    <span class="option-label">Publish:</span>
                                    <span class="option-value">Immediately</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-secondary btn-block">Save Draft</button>
                            <button class="btn btn-primary btn-block">Publish</button>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Categories</h3>
                        </div>
                        <div class="panel-body">
                            <div class="checkbox-list">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>Tutorials</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>Development</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>Design</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>Tips & Tricks</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>SEO</span>
                                </label>
                            </div>
                            <button class="btn-link">+ Add New Category</button>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="sidebar-panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Featured Image</h3>
                        </div>
                        <div class="panel-body">
                            <div class="featured-image-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <button class="btn btn-secondary btn-block">Set Featured Image</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="sidebar-panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Tags</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-input" placeholder="Add tags separated by commas">
                            <p class="form-help">Separate tags with commas</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection