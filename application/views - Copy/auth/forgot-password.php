@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Reset your password</p>
            </div>

            <form class="auth-form">
                <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: var(--spacing-lg);">
                    Enter your email address and we'll send you a link to reset your password.
                </p>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" class="text-input" placeholder="admin@example.com" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
            </form>

            <div class="auth-footer">
                <a href="login.html" class="auth-footer-link">← Back to login</a>
            </div>
        </div>
@endsection
