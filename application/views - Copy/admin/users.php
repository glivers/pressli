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
                            <!-- User Row 1 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff" alt="Admin User" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Admin User</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">admin@pressli.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-admin">Administrator</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">42</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Jan 1, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 2 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=10b981&color=fff" alt="Sarah Johnson" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Sarah Johnson</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">sarah.j@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-editor">Editor</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">28</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Feb 15, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 3 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Chen&background=f59e0b&color=fff" alt="Mike Chen" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Mike Chen</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">mike.chen@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-author">Author</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">15</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Mar 22, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 4 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Emma+Davis&background=ec4899&color=fff" alt="Emma Davis" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Emma Davis</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">emma.d@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-editor">Editor</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">31</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Apr 8, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 5 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=James+Wilson&background=8b5cf6&color=fff" alt="James Wilson" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">James Wilson</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">james.w@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-author">Author</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">19</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">May 3, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 6 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Olivia+Brown&background=14b8a6&color=fff" alt="Olivia Brown" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Olivia Brown</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">olivia.b@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-author">Author</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">23</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Jun 12, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 7 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=David+Miller&background=ef4444&color=fff" alt="David Miller" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">David Miller</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">david.m@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-subscriber">Subscriber</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">0</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Jul 19, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 8 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Sophia+Garcia&background=06b6d4&color=fff" alt="Sophia Garcia" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Sophia Garcia</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">sophia.g@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-admin">Administrator</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">37</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Aug 25, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 9 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Liam+Taylor&background=84cc16&color=fff" alt="Liam Taylor" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Liam Taylor</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">liam.t@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-author">Author</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">11</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Sep 14, 2025</div>
                                </td>
                            </tr>

                            <!-- User Row 10 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-user">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name=Ava+Martinez&background=f97316&color=fff" alt="Ava Martinez" class="user-cell-avatar">
                                        <div>
                                            <div class="user-cell-name">Ava Martinez</div>
                                            <div class="row-actions">
                                                <a href="#">Edit</a>
                                                <span class="separator">|</span>
                                                <a href="#" class="danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">ava.m@example.com</td>
                                <td class="col-role">
                                    <span class="role-badge role-editor">Editor</span>
                                </td>
                                <td class="col-posts">
                                    <a href="#" class="posts-count">26</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">Oct 5, 2025</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <div class="table-info">
                        Showing 1 to 10 of 24 users
                    </div>
                    <div class="pagination">
                        <button class="page-btn" disabled>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
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

