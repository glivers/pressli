@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Reset your password</p>
            </div>

            <form class="auth-form" method="POST" action="{{ Url::link('forgot-password') }}">
                {{{ Csrf::field() }}}

                <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: var(--spacing-lg);">
                    Enter your email address and we'll send you a link to reset your password.
                </p>

                @if(Session::hasFlash('error'))
                    <div class="alert alert-error">{{ Session::flash('error') }}</div>
                @endif

                @if(Session::hasFlash('success'))
                    <div class="alert alert-success">{{ Session::flash('success') }}</div>
                @endif

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="text-input" placeholder="email@example.com" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
            </form>

            <div class="auth-footer">
                <a href="{{ Url::link('login') }}" class="auth-footer-link">← Back to login</a>
            </div>
        </div>
@endsection
