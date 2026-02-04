@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Sign in to your account</p>
            </div>

            @if(Session::hasFlash('error'))
                <div class="alert alert-error">
                    {{ Session::flash('error') }}
                </div>
            @endif

            @if(Session::hasFlash('success'))
                <div class="alert alert-success">
                    {{ Session::flash('success') }}
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ Url::link('auth/login') }}">
                {{{ Csrf::field() }}}

                <div class="form-group">
                    <label class="form-label" for="login">Username or Email</label>
                    <input type="text" id="login" name="login" class="text-input" placeholder="admin" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="text-input" placeholder="••••••••" required>
                </div>

                <div class="auth-options">
                    <label class="form-label">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        Remember me
                    </label>
                    <a href="{{ Url::link('auth/forgot-password') }}" class="auth-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>

            <div class="auth-footer">
                <a href="{{ Url::link('/') }}" class="auth-footer-link">← Back to site</a>
            </div>
        </div>
@endsection
