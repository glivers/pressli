@extends('admin/layout')

@section('content')

        <!-- Menus Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="content-title">Menus</h1>
                <button class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Create Menu
                </button>
            </div>

            <div class="menus-layout">
                <!-- Menu List Sidebar -->
                <div class="menus-sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h3>Your Menus</h3>
                        </div>
                        <div class="menu-list">
                            <button class="menu-list-item active">
                                <span class="menu-list-name">Primary Menu</span>
                                <span class="menu-list-count">5 items</span>
                            </button>
                            <button class="menu-list-item">
                                <span class="menu-list-name">Footer Menu</span>
                                <span class="menu-list-count">3 items</span>
                            </button>
                            <button class="menu-list-item">
                                <span class="menu-list-name">Social Links</span>
                                <span class="menu-list-count">4 items</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Editor -->
                <div class="menus-content">
                    <div class="card">
                        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <h3>Primary Menu</h3>
                                <p style="font-size: 13px; color: var(--text-tertiary); margin: 4px 0 0;">Edit menu structure and items</p>
                            </div>
                            <button class="btn btn-danger-outline">Delete Menu</button>
                        </div>
                        <div class="card-body">
                            <div class="menu-editor-layout">
                                <!-- Menu Structure -->
                                <div class="menu-structure">
                                    <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 var(--spacing-md);">Menu Structure</h4>
                                    <div class="menu-items-list">
                                        <div class="menu-item-card">
                                            <div class="menu-item-handle">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                                </svg>
                                            </div>
                                            <div class="menu-item-content">
                                                <div class="menu-item-title">Home</div>
                                                <div class="menu-item-url">/</div>
                                            </div>
                                            <button class="menu-item-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="menu-item-card">
                                            <div class="menu-item-handle">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                                </svg>
                                            </div>
                                            <div class="menu-item-content">
                                                <div class="menu-item-title">Blog</div>
                                                <div class="menu-item-url">/blog</div>
                                            </div>
                                            <button class="menu-item-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="menu-item-card">
                                            <div class="menu-item-handle">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                                </svg>
                                            </div>
                                            <div class="menu-item-content">
                                                <div class="menu-item-title">About</div>
                                                <div class="menu-item-url">/about</div>
                                            </div>
                                            <button class="menu-item-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="menu-item-card">
                                            <div class="menu-item-handle">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                                </svg>
                                            </div>
                                            <div class="menu-item-content">
                                                <div class="menu-item-title">Services</div>
                                                <div class="menu-item-url">/services</div>
                                            </div>
                                            <button class="menu-item-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="menu-item-card">
                                            <div class="menu-item-handle">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                                </svg>
                                            </div>
                                            <div class="menu-item-content">
                                                <div class="menu-item-title">Contact</div>
                                                <div class="menu-item-url">/contact</div>
                                            </div>
                                            <button class="menu-item-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <button class="btn btn-secondary btn-block" style="margin-top: var(--spacing-md);">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add Menu Item
                                    </button>
                                </div>

                                <!-- Add Items Panel -->
                                <div class="menu-add-panel">
                                    <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 var(--spacing-md);">Add Items</h4>

                                    <div class="menu-add-section">
                                        <div class="menu-add-section-header">
                                            <h5>Pages</h5>
                                        </div>
                                        <div class="menu-add-section-body">
                                            <label class="form-label"><input type="checkbox"> Home</label>
                                            <label class="form-label"><input type="checkbox"> About</label>
                                            <label class="form-label"><input type="checkbox"> Services</label>
                                            <label class="form-label"><input type="checkbox"> Contact</label>
                                        </div>
                                        <button class="btn btn-sm btn-secondary btn-block">Add to Menu</button>
                                    </div>

                                    <div class="menu-add-section">
                                        <div class="menu-add-section-header">
                                            <h5>Custom Link</h5>
                                        </div>
                                        <div class="menu-add-section-body">
                                            <div class="form-group">
                                                <label class="form-label" for="custom-url">URL</label>
                                                <input type="text" id="custom-url" class="text-input" placeholder="https://example.com">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="custom-label">Link Text</label>
                                                <input type="text" id="custom-label" class="text-input" placeholder="My Link">
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-secondary btn-block">Add to Menu</button>
                                    </div>

                                    <div class="menu-add-section">
                                        <div class="menu-add-section-header">
                                            <h5>Categories</h5>
                                        </div>
                                        <div class="menu-add-section-body">
                                            <label class="form-label"><input type="checkbox"> Technology</label>
                                            <label class="form-label"><input type="checkbox"> Design</label>
                                            <label class="form-label"><input type="checkbox"> Business</label>
                                        </div>
                                        <button class="btn btn-sm btn-secondary btn-block">Add to Menu</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions" style="margin-top: var(--spacing-xl);">
                                <button class="btn btn-primary">Save Menu</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection