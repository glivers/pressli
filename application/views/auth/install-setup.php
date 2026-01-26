@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Site & Admin Setup</p>
            </div>

            <ul class="install-steps">
                <li class="install-step completed" data-step="1">Welcome</li>
                <li class="install-step completed" data-step="2">Database</li>
                <li class="install-step active" data-step="3">Setup</li>
                <li class="install-step" data-step="4">Complete</li>
            </ul>

            @if(Session::hasFlash('error'))
                <div class="auth-message error">{{ Session::flash('error') }}</div>
            @endif

            <form class="auth-form" method="POST" action="{{ Url::link('install/setup') }}">
                {{{ Csrf::field() }}}

                <h3 style="font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0 0 var(--spacing-md) 0;">
                    Site Information
                </h3>

                <div class="form-group">
                    <label class="form-label" for="site-title">Site Title</label>
                    <input type="text" id="site-title" name="site_title" class="text-input" placeholder="Website Name" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="site-tagline">Tagline (Optional)</label>
                    <input type="text" id="site-tagline" name="site_tagline" class="text-input" placeholder="Let's build something amazing here">
                </div>

                <h3 style="font-size: 15px; font-weight: 600; color: var(--text-primary); margin: var(--spacing-lg) 0 var(--spacing-md) 0;">
                    Administrator Account
                </h3>

                <div class="form-group">
                    <label class="form-label" for="admin-user">Username</label>
                    <input type="text" id="admin-user" name="username" class="text-input" placeholder="admin" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin-email">Email Address</label>
                    <input type="email" id="admin-email" name="email" class="text-input" placeholder="email@example.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin-pass">Password</label>
                    <input type="password" id="admin-pass" name="password" class="text-input" placeholder="••••••••" required>
                    <p class="form-help">Use a strong password with letters, numbers, and symbols</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin-pass-confirm">Confirm Password</label>
                    <input type="password" id="admin-pass-confirm" name="password_confirm" class="text-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Install Pressli</button>
            </form>

            <div class="auth-footer">
                <a href="{{ Url::link('install/database') }}" class="auth-footer-link">← Back</a>
            </div>
        </div>
@endsection
