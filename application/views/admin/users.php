@extends('admin/layout')

@section('content')
        <!-- Users Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Users</h1>
                <div class="header-actions-group">
                    <a href="{{ Url::link('admin/users/create') }}" class="btn btn-primary" id="addUserBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                        Add New User
                    </a>
                </div>
            </div>

            <!-- Filters & Actions Bar -->
            <div class="card">
                <div class="table-toolbar">
                    <div class="table-tabs">
                        <button class="tab-btn active" data-filter="all">
                            All <span class="tab-count">{{ $totalUsers }}</span>
                        </button>
                        <button class="tab-btn" data-filter="administrator">
                            Administrator <span class="tab-count">{{ $roleCounts['Administrator'] or 0 }}</span>
                        </button>
                        <button class="tab-btn" data-filter="editor">
                            Editor <span class="tab-count">{{ $roleCounts['Editor'] or 0 }}</span>
                        </button>
                        <button class="tab-btn" data-filter="author">
                            Author <span class="tab-count">{{ $roleCounts['Author'] or 0 }}</span>
                        </button>
                        <button class="tab-btn" data-filter="subscriber">
                            Subscriber <span class="tab-count">{{ $roleCounts['Subscriber'] or 0 }}</span>
                        </button>
                    </div>

                    <div class="table-actions">
                        <div class="bulk-actions">
                            <select class="select-input" disabled id="bulkActionUsers">
                                <option value="">Bulk Actions</option>
                                <option value="delete">Delete</option>
                                <option value="role-admin">Change Role to Admin</option>
                                <option value="role-editor">Change Role to Editor</option>
                                <option value="role-author">Change Role to Author</option>
                            </select>
                            <button class="btn btn-secondary" disabled id="applyBulkUsers">Apply</button>
                        </div>

                        <div class="search-box">
                            <input type="search" placeholder="Search users..." class="search-input">
                            <svg class="search-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="table-container">
                    <table class="data-table users-table">
                        <thead>
                            <tr>
                                <th class="col-check">
                                    <input type="checkbox" id="selectAllUsers" class="checkbox">
                                </th>
                                <th class="col-user">User</th>
                                <th class="col-email">Email</th>
                                <th class="col-role">Role</th>
                                <th class="col-posts">Posts</th>
                                <th class="col-date">Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Random colors for avatars
                                $avatarColors = ['4f46e5', '10b981', 'f59e0b', 'ec4899', '8b5cf6', '14b8a6', 'ef4444', '06b6d4', '84cc16', 'f97316'];
                            @endphp

                            @loopelse($users as $index => $user)
                                @php
                                    // Build display name
                                    $displayName = trim(($user['first_name'] or '') . ' ' . ($user['last_name'] or ''));
                                    if (empty($displayName)) {
                                        $displayName = $user['username'];
                                    }

                                    // Generate avatar URL
                                    $colorIndex = $index % count($avatarColors);
                                    $avatarBg = $avatarColors[$colorIndex];
                                    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=' . $avatarBg . '&color=fff';

                                    // Generate role badge class
                                    $roleName = $user['role_name'] or 'Subscriber';
                                    $roleClass = 'role-' . strtolower($roleName);
                                @endphp

                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox" class="checkbox row-check">
                                    </td>
                                    <td class="col-user">
                                        <div class="user-cell">
                                            <img src="{{ $avatarUrl }}" alt="{{ $displayName }}" class="user-cell-avatar">
                                            <div>
                                                <div class="user-cell-name">{{ $displayName }}</div>
                                                <div class="row-actions">
                                                    <a href="{{ Url::link('admin/users/edit', $user['id']) }}">Edit</a>
                                                    <span class="separator">|</span>
                                                    <a href="{{ Url::link('admin/users/delete', $user['id']) }}" class="danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-email">{{ $user['email'] }}</td>
                                    <td class="col-role">
                                        <span class="role-badge {{ $roleClass }}">{{ $roleName }}</span>
                                    </td>
                                    <td class="col-posts">
                                        <a href="#" class="posts-count">0</a>
                                    </td>
                                    <td class="col-date">
                                        <div class="date-cell">{{ Date::format($user['created_at'], 'M j, Y') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem;">
                                        <p>No users found.</p>
                                    </td>
                                </tr>
                            @endloop
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <div class="table-info">
                        Showing {{ count($users) }} of {{ $totalUsers }} users
                    </div>
                </div>
            </div>
        </main>
@endsection

<!-- JS Scripts -->
@section('scripts')
    @parent
    <script src="{{Url::assets('js/users.js')}}"></script>
@endsection

