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
                    <button class="plugin-tab active" data-filter="all">All <span class="plugin-tab-count">({{ count($plugins) }})</span></button>
                    <button class="plugin-tab" data-filter="active">Active <span class="plugin-tab-count active-count"></span></button>
                    <button class="plugin-tab" data-filter="inactive">Inactive <span class="plugin-tab-count inactive-count"></span></button>
                </div>

                <div class="card-body" style="padding: 0;">
                    <div class="plugins-list">
                        @loopelse($plugins as $plugin)
                            <!-- Plugin Item -->
                            <div class="plugin-item {{ $plugin['status'] === 'active' ? 'active' : '' }}" data-status="{{ $plugin['status'] }}">
                                <div class="plugin-icon {{ $plugin['status'] === 'inactive' ? 'inactive' : '' }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 6v6l4 2"></path>
                                    </svg>
                                </div>
                                <div class="plugin-info">
                                    <div class="plugin-header">
                                        <h3 class="plugin-name">{{ $plugin['name'] }}</h3>
                                        @if($plugin['status'] === 'active')
                                            <span class="plugin-status-badge active">Active</span>
                                        @endif
                                        <div class="plugin-actions">
                                            @if($plugin['status'] === 'active')
                                                <button class="plugin-action-link deactivate-plugin" data-id="{{ $plugin['id'] }}" data-name="{{ $plugin['name'] }}">Deactivate</button>
                                                <span class="plugin-separator">|</span>
                                            @else
                                                <button class="plugin-action-link primary activate-plugin" data-id="{{ $plugin['id'] }}" data-name="{{ $plugin['name'] }}">Activate</button>
                                                <span class="plugin-separator">|</span>
                                            @endif
                                            <button class="plugin-action-link danger delete-plugin" data-id="{{ $plugin['id'] }}" data-name="{{ $plugin['name'] }}">Delete</button>
                                        </div>
                                    </div>
                                    <p class="plugin-description">{{ $plugin['description'] or 'No description available.' }}</p>
                                    <div class="plugin-footer">
                                        <span class="plugin-version">Version {{ $plugin['version'] }}</span>
                                        @isset($plugin['author'])
                                            <span class="plugin-separator">|</span>
                                            <span class="plugin-author">By
                                                @isset($plugin['author_uri'])
                                                    <a href="{{ $plugin['author_uri'] }}" target="_blank">{{ $plugin['author'] }}</a>
                                                @else
                                                    {{ $plugin['author'] }}
                                                @endisset
                                            </span>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 40px; text-align: center; color: #666;">
                                <p>No plugins installed. Click "Add New" to upload a plugin.</p>
                            </div>
                        @endloop
                    </div>
                </div>
            </div>
        </main>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = '{{ Csrf::token() }}';

            // Update tab counts
            const activeCount = document.querySelectorAll('.plugin-item[data-status="active"]').length;
            const inactiveCount = document.querySelectorAll('.plugin-item[data-status="inactive"]').length;
            document.querySelector('.active-count').textContent = `(${activeCount})`;
            document.querySelector('.inactive-count').textContent = `(${inactiveCount})`;

            // Tab filtering
            document.querySelectorAll('.plugin-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.plugin-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.dataset.filter;
                    document.querySelectorAll('.plugin-item').forEach(item => {
                        if (filter === 'all') {
                            item.style.display = '';
                        } else {
                            item.style.display = item.dataset.status === filter ? '' : 'none';
                        }
                    });
                });
            });

            // Activate plugin
            document.querySelectorAll('.activate-plugin').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    if (!confirm(`Activate plugin: ${name}?`)) return;

                    fetch(`{{ Url::base() }}admin/plugins/activate/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `csrf_token=${csrfToken}`
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Failed to activate plugin');
                        }
                    })
                    .catch(err => alert('Error: ' + err.message));
                });
            });

            // Deactivate plugin
            document.querySelectorAll('.deactivate-plugin').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    if (!confirm(`Deactivate plugin: ${name}?`)) return;

                    fetch(`{{ Url::base() }}admin/plugins/deactivate/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `csrf_token=${csrfToken}`
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Failed to deactivate plugin');
                        }
                    })
                    .catch(err => alert('Error: ' + err.message));
                });
            });

            // Delete plugin
            document.querySelectorAll('.delete-plugin').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    if (!confirm(`Delete plugin: ${name}?\n\nThis will remove the plugin files from your server.`)) return;

                    const deleteData = confirm('Also delete plugin data from database?\n\nClick OK to delete data, or Cancel to keep it.');

                    fetch(`{{ Url::base() }}admin/plugins/delete/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `csrf_token=${csrfToken}&delete_data=${deleteData}`
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Failed to delete plugin');
                        }
                    })
                    .catch(err => alert('Error: ' + err.message));
                });
            });
        });
        </script>
@endsection
