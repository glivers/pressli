        <!-- Sidebar Nav -->
        <nav class="sidebar-nav">
            <a href="{{Url::link('admin/index')}}" class="nav-item {{ strpos(Request::path(), 'admin/index') !== false || Request::path() === 'admin' || Request::path() === '' ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{Url::link('admin/posts')}}" class="nav-item {{ strpos(Request::path(), 'posts') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Posts</span>
                <span class="badge">12</span>
            </a>

            <a href="{{Url::link('admin/pages')}}" class="nav-item {{ strpos(Request::path(), 'pages') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Pages</span>
            </a>

            <a href="{{Url::link('admin/media')}}" class="nav-item {{ strpos(Request::path(), 'media') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <span>Media</span>
            </a>

            <a href="{{Url::link('admin/comments')}}" class="nav-item {{ strpos(Request::path(), 'comments') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span>Comments</span>
                <span class="badge">3</span>
            </a>

            <div class="nav-divider"></div>
                <a href="{{Url::link('admin/categories')}}" class="nav-item {{ strpos(Request::path(), 'categories') !== false ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Categories</span>
                </a>

                <a href="{{Url::link('admin/menus')}}" class="nav-item {{ strpos(Request::path(), 'menus') !== false ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <span>Menus</span>
                </a>

                <a href="{{Url::link('admin/tags')}}" class="nav-item {{ strpos(Request::path(), 'tags') !== false ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                    </svg>
                    <span>Tags</span>
                </a>

            <div class="nav-divider"></div>

            <a href="{{Url::link('admin/users')}}" class="nav-item {{ strpos(Request::path(), 'users') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>Users</span>
            </a>

            <a href="{{Url::link('admin/themes/index')}}" class="nav-item {{ strpos(Request::path(), 'themes') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                    <rect x="1" y="3" width="22" height="5"></rect>
                    <line x1="10" y1="12" x2="14" y2="12"></line>
                </svg>
                <span>Themes</span>
            </a>

            <a href="{{Url::link('admin/plugins')}}" class="nav-item {{ strpos(Request::path(), 'plugins') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                <span>Plugins</span>
            </a>

            <a href="{{Url::link('admin/settings')}}" class="nav-item {{ strpos(Request::path(), 'settings') !== false ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 1v6m0 6v6m8.66-10a9 9 0 1 1-17.32 0"></path>
                    <line x1="12" y1="1" x2="12" y2="7"></line>
                    <path d="M19.07 4.93A10 10 0 0 0 4.93 19.07"></path>
                </svg>
                <span>Settings</span>
            </a>
        </nav>
