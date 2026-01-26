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
                            @loopelse($menus as $menu)
                                <a href="{{ Url::link('admin/menus?menu_id=' . $menu['id']) }}" class="menu-list-item {{ $menu['id'] == $selectedMenuId ? 'active' : '' }}">
                                    <span class="menu-list-name">{{ $menu['name'] }}</span>
                                    <span class="menu-list-count">{{ $menu['item_count'] }} items</span>
                                </a>
                            @empty
                                <p style="padding: var(--spacing-md); color: var(--text-tertiary); text-align: center;">No menus yet</p>
                            @endloop
                        </div>
                    </div>

                    <!-- Add Items Panel (Always Visible) -->
                    <div class="card" style="margin-top: var(--spacing-md);">
                        <div class="card-header">
                            <h3>Add Items</h3>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <div class="menu-add-section">
                                <div class="menu-add-section-header">
                                    <h5>Pages</h5>
                                </div>
                                <div class="menu-add-section-body">
                                    <label class="form-label"><input type="checkbox"> Loading...</label>
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
                                    <label class="form-label"><input type="checkbox"> Loading...</label>
                                </div>
                                <button class="btn btn-sm btn-secondary btn-block">Add to Menu</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Editor -->
                <div class="menus-content">
                    @if($selectedMenu)
                    <div class="card">
                        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <h3>{{ $selectedMenu['name'] }}</h3>
                                <p style="font-size: 13px; color: var(--text-tertiary); margin: 4px 0 0;">Edit menu structure and items</p>
                            </div>
                            <button class="btn btn-danger-outline" data-menu-id="{{ $selectedMenu['id'] }}">Delete Menu</button>
                        </div>
                        <div class="card-body">
                            <div class="menu-editor-layout">
                                <!-- Menu Structure -->
                                <div class="menu-structure">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--spacing-md);">
                                        <h4 style="font-size: 14px; font-weight: 600; margin: 0;">Menu Structure</h4>
                                        @if(!empty($menuLocations))
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <label style="font-size: 13px; color: var(--text-secondary); margin: 0;">Location:</label>
                                                <select id="menuLocation" class="text-input" style="width: auto; padding: 4px 8px; font-size: 13px;">
                                                    <option value="">None</option>
                                                    @foreach($menuLocations as $key => $label)
                                                        <option value="{{ $key }}" {{ $selectedMenu['location'] == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="menu-items-list">
                                        @loopelse($menuItems as $item)
                                        <div class="menu-item-card {{ $item['parent_id'] ? 'nested' : '' }}"
                                             data-item-id="{{ $item['id'] }}"
                                             data-parent-id="{{ $item['parent_id'] or '0' }}"
                                             data-title="{{ $item['title'] }}"
                                             data-url="{{ $item['url'] }}"
                                             data-target="{{ $item['target'] or '_self' }}"
                                             draggable="true">
                                            <div class="menu-item-handle">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                                </svg>
                                            </div>
                                            <div class="menu-item-content">
                                                <div class="menu-item-title">{{ $item['title'] }}</div>
                                                <div class="menu-item-url">{{ $item['url'] }}</div>
                                            </div>
                                            <button class="menu-item-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @empty
                                        <p style="color: var(--text-tertiary); text-align: center; padding: var(--spacing-lg);">No menu items yet. Add items below.</p>
                                        @endloop
                                    </div>

                                    <button class="btn btn-secondary btn-block" style="margin-top: var(--spacing-md);">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add Menu Item
                                    </button>
                                </div>
                            </div>

                            <div class="form-actions" style="margin-top: var(--spacing-xl);">
                                <button class="btn btn-primary">Save Menu</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card">
                        <div class="card-body" style="text-align: center; padding: var(--spacing-xl);">
                            <p style="color: var(--text-tertiary);">Create a menu to get started</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Create Menu Modal -->
            <div class="modal" id="createMenuModal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Create New Menu</h2>
                        <button class="modal-close" id="closeCreateModal">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label" for="menuName">Menu Name</label>
                            <input type="text" id="menuName" class="text-input" placeholder="Main Navigation" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="menuLocation">Location <span style="color: var(--text-tertiary); font-weight: normal;">(optional)</span></label>
                            <input type="text" id="menuLocation" class="text-input" placeholder="primary, footer, sidebar, etc.">
                            <p style="font-size: 13px; color: var(--text-tertiary); margin-top: 4px;">You can assign this menu to a theme location later</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="cancelCreateMenu">Cancel</button>
                        <button class="btn btn-primary" id="submitCreateMenu">Create Menu</button>
                    </div>
                </div>
            </div>
        </main>
@endsection

@section('scripts')
    @parent
    <script src="{{ Url::assets('admin/js/menus.js') }}"></script>
@endsection