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
            @if($active_theme)
            <div class="current-theme-section">
                <h2 class="section-title">Current Theme</h2>
                <div class="current-theme-card">
                    <div class="current-theme-screenshot">
                        <img src="{{ $active_theme['screenshot'] }}" alt="{{ $active_theme['display_name'] }}">
                        <div class="theme-active-badge">Active</div>
                    </div>
                    <div class="current-theme-info">
                        <h3 class="theme-name">{{ $active_theme['display_name'] }}</h3>
                        <p class="theme-description">{{ $active_theme['description'] }}</p>
                        <div class="theme-meta">
                            <span class="theme-version">Version {{ $active_theme['version'] }}</span>
                            <span class="separator">•</span>
                            <span class="theme-author">By <span class="theme-author-link">{{ $active_theme['author'] }}</span></span>
                        </div>
                        <div class="current-theme-actions">
                            <a href="{{ Url::link('admin/themes', 'customize', $active_theme['name']) }}" class="btn btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                                Customize
                            </a>
                            <a href="{{ Url::link('admin/themes', 'details', $active_theme['name']) }}" class="btn btn-secondary">Theme Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Available Themes -->
            @if(!empty($available_themes))
            <div class="available-themes-section">
                <h2 class="section-title">Available Themes</h2>
                <div class="themes-grid">
                    @foreach($available_themes as $theme)
                    <!-- Theme Card -->
                    <div class="theme-card">
                        <div class="theme-screenshot">
                            <img src="{{ $theme['screenshot'] }}" alt="{{ $theme['display_name'] }}">
                            <div class="theme-overlay">
                                <form method="POST" action="{{ Url::link('admin/themes', 'activate', $theme['name']) }}" style="display: inline;">
                                    {{{ Csrf::field() }}}
                                    <button type="submit" class="btn btn-primary btn-sm">Activate</button>
                                </form>
                                <button class="btn btn-secondary btn-sm">Live Preview</button>
                            </div>
                        </div>
                        <div class="theme-card-body">
                            <h4 class="theme-card-name">{{ $theme['display_name'] }}</h4>
                            <p class="theme-card-author">By {{ $theme['author'] }}</p>
                            <div class="theme-card-actions">
                                <button class="theme-action-btn" title="Theme Details">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"></circle>
                                    </svg>
                                </button>
                                <button class="theme-action-btn danger" title="Delete Theme">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(empty($active_theme) && empty($available_themes))
            <div class="empty-state">
                <p>No themes found. Please install a theme to get started.</p>
            </div>
            @endif

        </main>
@endsection
