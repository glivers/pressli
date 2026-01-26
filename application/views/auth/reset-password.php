@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Create a new password</p>
            </div>

            <form class="auth-form" method="POST" action="{{ Url::link('reset-password') }}">
                {{{ Csrf::field() }}}
                <input type="hidden" name="token" value="{{ $token }}">

                @if(Session::hasFlash('error'))
                    <div class="alert alert-error">{{ Session::flash('error') }}</div>
                @endif

                <div class="form-group">
                    <label class="form-label" for="password">New Password</label>
                    <input type="password" id="password" name="password" class="text-input" placeholder="••••••••" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirm">Confirm Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="text-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            </form>

            <div class="auth-footer">
                <a href="{{ Url::link('login') }}" class="auth-footer-link">← Back to login</a>
            </div>
        </div>
@endsection
