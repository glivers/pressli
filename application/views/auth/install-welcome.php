@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Welcome to Pressli CMS</p>
            </div>

            <ul class="install-steps">
                <li class="install-step active" data-step="1">Welcome</li>
                <li class="install-step" data-step="2">Database</li>
                <li class="install-step" data-step="3">Setup</li>
                <li class="install-step" data-step="4">Complete</li>
            </ul>

            <div style="margin-bottom: var(--spacing-xl);">
                <h2 style="font-size: 18px; font-weight: 600; margin: 0 0 var(--spacing-md) 0; color: var(--text-primary);">
                    Before Getting Started
                </h2>
                <p style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: var(--spacing-md);">
                    You will need the following information to complete the installation:
                </p>
                <ul style="font-size: 14px; color: var(--text-secondary); line-height: 1.8; margin: 0 0 var(--spacing-lg) var(--spacing-lg);">
                    <li>Database name</li>
                    <li>Database username</li>
                    <li>Database password</li>
                    <li>Database host (usually localhost)</li>
                </ul>
                <p style="font-size: 13px; color: var(--text-tertiary); line-height: 1.6; margin: 0;">
                    If you don't have this information, contact your web hosting provider.
                </p>
            </div>

            <a href="{{ Url::link('install/database') }}" class="btn btn-primary btn-block" style="display: block; text-align: center; text-decoration: none;">Let's Go!</a>
        </div>
@endsection
