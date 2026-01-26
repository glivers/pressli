@extends('admin/layout')

@section('content')

        <!-- Profile Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Your Profile</h1>
            </div>

            <div class="profile-container">
                <!-- Left Column - Profile Picture -->
                <div class="profile-sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Profile Picture</h2>
                        </div>
                        <div class="card-body">
                            <div class="profile-picture-wrapper">
                                <img src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff&size=200" alt="Profile Picture" class="profile-picture">
                            </div>
                            <div class="profile-picture-actions">
                                <button class="btn btn-secondary btn-full">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                    Upload New Picture
                                </button>
                                <button class="btn btn-secondary btn-full">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Remove Picture
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Account Info</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-row">
                                <span class="detail-label">Role:</span>
                                <span class="detail-value">
                                    <span class="role-badge role-admin">Administrator</span>
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Member Since:</span>
                                <span class="detail-value">Jan 1, 2025</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Total Posts:</span>
                                <span class="detail-value">42</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Last Login:</span>
                                <span class="detail-value">Jan 14, 2026 2:30 PM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Profile Details -->
                <div class="profile-main">
                    <!-- Personal Information -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Personal Information</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="firstName">First Name</label>
                                    <input type="text" id="firstName" class="text-input" value="Admin">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="lastName">Last Name</label>
                                    <input type="text" id="lastName" class="text-input" value="User">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" id="username" class="text-input" value="admin" readonly>
                                <p class="form-help">Username cannot be changed</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" id="email" class="text-input" value="admin@pressli.com">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="website">Website</label>
                                <input type="url" id="website" class="text-input" value="https://pressli.com" placeholder="https://">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="bio">Biographical Info</label>
                                <textarea id="bio" class="textarea-input" rows="5" placeholder="Write a short bio about yourself...">Passionate CMS developer and content creator. Building better web experiences one project at a time.</textarea>
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary">Update Profile</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Change Password</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label" for="currentPassword">Current Password</label>
                                <input type="password" id="currentPassword" class="text-input" placeholder="Enter your current password">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="newPassword">New Password</label>
                                <input type="password" id="newPassword" class="text-input" placeholder="Enter new password">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                <input type="password" id="confirmPassword" class="text-input" placeholder="Confirm new password">
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary">Update Password</button>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Social Media</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label" for="twitter">Twitter / X</label>
                                <input type="text" id="twitter" class="text-input" placeholder="@username">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="facebook">Facebook</label>
                                <input type="url" id="facebook" class="text-input" placeholder="https://facebook.com/username">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="linkedin">LinkedIn</label>
                                <input type="url" id="linkedin" class="text-input" placeholder="https://linkedin.com/in/username">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="github">GitHub</label>
                                <input type="text" id="github" class="text-input" placeholder="@username">
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary">Update Social Links</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
