@extends('admin/layout')

@section('content')

        <!-- Add User Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="users.html" class="breadcrumb-link">Users</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Add New User</span>
                </div>
            </div>

            <div class="add-user-container">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">User Information</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="newUsername">Username <span class="required">*</span></label>
                            <input type="text" id="newUsername" class="text-input" placeholder="Enter username" required>
                            <p class="form-help">Username must be unique and contain only letters, numbers, and underscores</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="newEmail">Email Address <span class="required">*</span></label>
                            <input type="email" id="newEmail" class="text-input" placeholder="user@example.com" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="newFirstName">First Name</label>
                                <input type="text" id="newFirstName" class="text-input" placeholder="First name">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="newLastName">Last Name</label>
                                <input type="text" id="newLastName" class="text-input" placeholder="Last name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="newWebsite">Website</label>
                            <input type="url" id="newWebsite" class="text-input" placeholder="https://">
                        </div>

                        <div class="form-divider"></div>

                        <div class="form-group">
                            <label class="form-label" for="newPassword">Password <span class="required">*</span></label>
                            <input type="password" id="newPassword" class="text-input" placeholder="Enter password" required>
                            <p class="form-help">Password must be at least 8 characters long</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="newPasswordConfirm">Confirm Password <span class="required">*</span></label>
                            <input type="password" id="newPasswordConfirm" class="text-input" placeholder="Confirm password" required>
                        </div>

                        <div class="form-divider"></div>

                        <div class="form-group">
                            <label class="form-label" for="newRole">Role <span class="required">*</span></label>
                            <select id="newRole" class="select-input" required>
                                <option value="">Select a role...</option>
                                <option value="administrator">Administrator</option>
                                <option value="editor">Editor</option>
                                <option value="author" selected>Author</option>
                                <option value="subscriber">Subscriber</option>
                            </select>
                            <p class="form-help">Administrator has full access, Editor can publish posts, Author can write posts, Subscriber has read-only access</p>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox" id="sendEmail" checked>
                                <span>Send the new user an email about their account</span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                                Add New User
                            </button>
                            <a href="users.html" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
