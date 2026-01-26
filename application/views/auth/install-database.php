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

            @if(Session::hasFlash('error'))
                <div class="auth-message error">{{ Session::flash('error') }}</div>
            @endif

            <div id="test-message" style="display: none;"></div>

            <form class="auth-form" method="POST" action="{{ Url::link('install/database') }}">
                {{{ Csrf::field() }}}

                <div class="form-group">
                    <label class="form-label" for="db-host">Database Host</label>
                    <input type="text" id="db-host" name="db_host" class="text-input" value="localhost" required>
                    <p class="form-help">Usually localhost or 127.0.0.1</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="db-name">Database Name</label>
                    <input type="text" id="db-name" name="db_name" class="text-input" placeholder="pressli_db" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="db-user">Database Username</label>
                    <input type="text" id="db-user" name="db_user" class="text-input" placeholder="root" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="db-pass">Database Password</label>
                    <input type="password" id="db-pass" name="db_pass" class="text-input" placeholder="••••••••">
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" id="test-btn" class="btn btn-secondary" style="flex: 1;">Test Connection</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Continue</button>
                </div>
            </form>

            <div class="auth-footer">
                <a href="{{ Url::link('install') }}" class="auth-footer-link">← Back</a>
            </div>

            <script>
            document.getElementById('test-btn').addEventListener('click', function() {
                const btn = this;
                const msg = document.getElementById('test-message');

                btn.disabled = true;
                btn.textContent = 'Testing...';
                btn.classList.add('testing');
                msg.style.display = 'none';

                const formData = new FormData();
                formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
                formData.append('db_host', document.getElementById('db-host').value);
                formData.append('db_name', document.getElementById('db-name').value);
                formData.append('db_user', document.getElementById('db-user').value);
                formData.append('db_pass', document.getElementById('db-pass').value);

                fetch('{{ Url::link("install/test") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    msg.className = 'auth-message ' + (data.success ? 'success' : 'error');
                    msg.textContent = data.message;
                    msg.style.display = 'block';
                })
                .catch(() => {
                    msg.className = 'auth-message error';
                    msg.textContent = 'Failed to test connection. Please try again.';
                    msg.style.display = 'block';
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = 'Test Connection';
                    btn.classList.remove('testing');
                });
            });
            </script>

            <style>
            .btn-secondary.testing {
                background: var(--bg-hover);
                border-color: var(--text-primary);
            }
            </style>
        </div>
@endsection
