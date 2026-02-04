@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Installation Complete!</p>
            </div>

            <ul class="install-steps">
                <li class="install-step completed" data-step="1">Welcome</li>
                <li class="install-step completed" data-step="2">Database</li>
                <li class="install-step completed" data-step="3">Setup</li>
                <li class="install-step completed" data-step="4">Complete</li>
            </ul>

            <div class="auth-message success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 48px; height: 48px; margin: 0 auto var(--spacing-md); display: block;">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <p style="text-align: center; font-size: 16px; font-weight: 600; margin: 0 0 var(--spacing-sm) 0;">
                    Pressli has been installed successfully!
                </p>
                <p style="text-align: center; font-size: 14px; margin: 0;">
                    Your site is ready to go. You can now log in to the admin dashboard.
                </p>
            </div>

            <div style="margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0 0 var(--spacing-md) 0;">
                    What's Next?
                </h3>
                <ul style="font-size: 14px; color: var(--text-secondary); line-height: 1.8; margin: 0 0 0 var(--spacing-lg);">
                    <li>Log in to your dashboard</li>
                    <li>Choose and activate a theme</li>
                    <li>Create your first post</li>
                    <li>Configure your site settings</li>
                </ul>
            </div>

            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="index.html" class="btn btn-secondary" style="flex: 1; text-align: center; text-decoration: none;">View Site</a>
                <a href="login.html" class="btn btn-primary" style="flex: 1; text-align: center; text-decoration: none;">Log In</a>
            </div>

            <div style="margin-top: var(--spacing-lg); padding: var(--spacing-md); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px;">
                <p style="font-size: 13px; color: var(--danger); margin: 0; font-weight: 500;">
                    <strong>Security Note:</strong> For security reasons, please delete the installation files from your server.
                </p>
            </div>
        </div>
@endsection