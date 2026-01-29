@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Create a new password</p>
            </div>

            <form class="auth-form">
                <div class="form-group">
                    <label class="form-label" for="password">New Password</label>
                    <input type="password" id="password" class="text-input" placeholder="••••••••" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password-confirm">Confirm Password</label>
                    <input type="password" id="password-confirm" class="text-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            </form>

            <div class="auth-footer">
                <a href="login.html" class="auth-footer-link">← Back to login</a>
            </div>
        </div>
@endsection
