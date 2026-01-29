@extends('auth/layout')

@section('content')
        <!-- Main Content -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">Pressli</h1>
                <p class="auth-subtitle">Database Configuration</p>
            </div>

            <ul class="install-steps">
                <li class="install-step completed" data-step="1">Welcome</li>
                <li class="install-step active" data-step="2">Database</li>
                <li class="install-step" data-step="3">Setup</li>
                <li class="install-step" data-step="4">Complete</li>
            </ul>

            <!-- Uncomment to show success message after testing connection -->
            <!-- <div class="auth-message success">
                Connection successful! You can proceed to the next step.
            </div> -->

            <!-- Uncomment to show error message if connection fails -->
            <!-- <div class="auth-message error">
                Connection failed: Access denied for user 'root'@'localhost'
            </div> -->

            <form class="auth-form" action="install-setup.html">
                <div class="form-group">
                    <label class="form-label" for="db-host">Database Host</label>
                    <input type="text" id="db-host" class="text-input" value="localhost" required>
                    <p class="form-help">Usually localhost or 127.0.0.1</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="db-name">Database Name</label>
                    <input type="text" id="db-name" class="text-input" placeholder="pressli_db" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="db-user">Database Username</label>
                    <input type="text" id="db-user" class="text-input" placeholder="root" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="db-pass">Database Password</label>
                    <input type="password" id="db-pass" class="text-input" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label class="form-label" for="db-prefix">Table Prefix</label>
                    <input type="text" id="db-prefix" class="text-input" value="pr_" required>
                    <p class="form-help">Prefix for database tables (e.g., pr_posts, pr_users)</p>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" class="btn btn-secondary" style="flex: 1;">Test Connection</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Continue</button>
                </div>
            </form>

            <div class="auth-footer">
                <a href="install-welcome.html" class="auth-footer-link">← Back</a>
            </div>
        </div>
@endsection
