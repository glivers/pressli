@extends('admin/layout')

@section('title', 'My Profile')

@section('content')
<div class="profile-page">
    <h1>My Profile</h1>

    <!-- Flash Messages -->
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-error">
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- Token copy modal (hidden by default) -->
    <div id="token-modal" class="token-modal" style="display:none;">
        <div class="token-modal-content">
            <h3>⚠️ Copy Your API Token Now</h3>
            <p id="token-modal-message">This token will only be shown once. Copy it immediately:</p>
            <div class="token-display">
                <code id="generated-token"></code>
                <button onclick="copyGeneratedToken()" class="btn btn-sm" id="copy-btn">Copy</button>
            </div>
            <p><small>Use this token in API requests: <code>Authorization: Bearer {token}</code></small></p>
            <button onclick="closeTokenModal()" class="btn btn-primary" style="margin-top:1rem;">I've Copied It</button>
        </div>
    </div>

    <div class="profile-grid">
        <!-- Profile Information -->
        <div class="profile-section">
            <h2>Profile Information</h2>
            <form method="POST" action="{{ Url::link('admin', 'profile') }}" class="profile-form">
                {{{ Csrf::field() }}}

                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" value="{{ $user['username'] }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ $user['email'] }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" value="{{ $user['first_name'] or '' }}">
                    </div>

                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" value="{{ $user['last_name'] or '' }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="4">{{ $user['bio'] or '' }}</textarea>
                </div>

                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="url" id="website" name="website" value="{{ $user['website'] or '' }}" placeholder="https://example.com">
                </div>

                <h3>Social Links</h3>

                <div class="form-group">
                    <label for="twitter">Twitter</label>
                    <input type="text" id="twitter" name="twitter" value="{{ $user['twitter'] or '' }}" placeholder="@username">
                </div>

                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input type="url" id="facebook" name="facebook" value="{{ $user['facebook'] or '' }}" placeholder="https://facebook.com/username">
                </div>

                <div class="form-group">
                    <label for="linkedin">LinkedIn</label>
                    <input type="url" id="linkedin" name="linkedin" value="{{ $user['linkedin'] or '' }}" placeholder="https://linkedin.com/in/username">
                </div>

                <div class="form-group">
                    <label for="github">GitHub</label>
                    <input type="text" id="github" name="github" value="{{ $user['github'] or '' }}" placeholder="username">
                </div>

                <h3>Change Password</h3>
                <p class="form-hint">Leave blank to keep current password</p>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" minlength="8" placeholder="Minimum 8 characters">
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input type="password" id="password-confirm" name="password-confirm">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>

        <!-- API Tokens -->
        <div class="tokens-section">
            <h2>API Tokens</h2>
            <p>Generate tokens to access the REST API for automation and headless CMS integrations.</p>

            <!-- Create Token Form -->
            <form id="token-form" class="token-form" onsubmit="return createToken(event)">
                {{{ Csrf::field() }}}
                <div class="form-group">
                    <label for="token-name">Token Name *</label>
                    <input type="text" id="token-name" name="token-name" required placeholder="e.g., n8n Automation, Mobile App">
                    <small>Descriptive name to identify this token</small>
                </div>
                <button type="submit" class="btn btn-primary">Generate New Token</button>
            </form>

            <!-- Existing Tokens -->
            <h3>Your Tokens</h3>
            <div id="tokens-list">
                @loopelse($tokens as $token)
                    <div class="token-row" data-token-id="{{ $token['id'] }}">
                        <div class="token-name">
                            <strong>{{ $token['name'] }}</strong>
                        </div>
                        <div class="token-meta">
                            <span>Created: {{ Date::format($token['created_at'], 'M j, Y g:i A') }}</span>
                            <span class="separator">•</span>
                            @if($token['last_used'])
                                <span>Status: Last used {{ Date::ago($token['last_used']) }}</span>
                            @else
                                <span>Status: Never used</span>
                            @endif
                        </div>
                        <div class="token-actions">
                            <button onclick="revokeToken({{ $token['id'] }})" class="btn btn-sm btn-danger">Revoke</button>
                        </div>
                    </div>
                @empty
                    <p class="no-tokens">No API tokens yet. Generate one above to access the REST API.</p>
                @endloop
            </div>

            <!-- API Documentation -->
            <div class="api-docs">
                <h3>Using Your Tokens</h3>
                <p>Include your token in API requests:</p>
                <pre><code>Authorization: Bearer {your-token}</code></pre>

                <h4>Example with cURL:</h4>
                <pre><code>curl -H "Authorization: Bearer {token}" \
  {{ Url::base() }}api/posts</code></pre>

                <h4>Example with n8n:</h4>
                <ol>
                    <li>HTTP Request node</li>
                    <li>Authentication: Generic Credential Type</li>
                    <li>Add header: <code>Authorization</code> = <code>Bearer {token}</code></li>
                </ol>

                <h4>Available Endpoints:</h4>
                <ul>
                    <li><code>GET /api/posts</code> - List posts</li>
                    <li><code>POST /api/posts/create</code> - Create post</li>
                    <li><code>GET /api/categories</code> - List categories</li>
                    <li><code>GET /api/pages</code> - List pages</li>
                    <li><code>GET /api/media</code> - List media</li>
                    <li><code>GET /api/comments</code> - List comments</li>
                    <li><code>GET /api/tags</code> - List tags</li>
                    <li><code>GET /api/menus</code> - List menus</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.profile-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-page h1 {
    margin-bottom: 2rem;
}

.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 4px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.token-alert h3 {
    margin-top: 0;
    font-size: 1.1rem;
}

.token-display {
    display: flex;
    gap: 1rem;
    align-items: center;
    margin: 1rem 0;
    padding: 1rem;
    background: #fff;
    border-radius: 4px;
}

.token-display code {
    flex: 1;
    background: #f5f5f5;
    padding: 0.5rem;
    border-radius: 4px;
    font-family: monospace;
    font-size: 0.9rem;
    word-break: break-all;
}

.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

@media (max-width: 968px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
}

.profile-section, .tokens-section {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.profile-section h2, .tokens-section h2 {
    margin-top: 0;
    margin-bottom: 1.5rem;
}

.profile-section h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-group small {
    display: block;
    margin-top: 0.25rem;
    color: #666;
    font-size: 0.875rem;
}

.form-hint {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.form-actions {
    margin-top: 2rem;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-danger {
    background: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background: #c82333;
}

.token-form {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #ddd;
}

.token-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 0.5rem;
}

.token-name {
    flex: 0 0 200px;
}

.token-meta {
    flex: 1;
    color: #666;
    font-size: 0.875rem;
}

.token-meta .separator {
    margin: 0 0.5rem;
}

.token-actions {
    flex: 0 0 auto;
}

.token-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.token-modal-content {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    max-width: 600px;
    width: 90%;
}

.token-modal-content h3 {
    margin-top: 0;
}

.no-tokens {
    color: #666;
    font-style: italic;
    padding: 1rem;
    text-align: center;
}

.api-docs {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #ddd;
}

.api-docs h3 {
    margin-top: 0;
}

.api-docs h4 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.api-docs pre {
    background: #f5f5f5;
    padding: 1rem;
    border-radius: 4px;
    overflow-x: auto;
    margin: 0.5rem 0;
}

.api-docs code {
    font-family: monospace;
    font-size: 0.9rem;
}

.api-docs ol, .api-docs ul {
    margin-left: 1.5rem;
}

.api-docs li {
    margin-bottom: 0.5rem;
}
</style>

<script>
const csrfToken = document.querySelector('input[name="csrf_token"]').value;

function createToken(event) {
    event.preventDefault();

    const form = event.target;
    const tokenName = form.querySelector('#token-name').value;
    const submitBtn = form.querySelector('button[type="submit"]');

    // Disable button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Generating...';

    fetch('{{ Url::link("admin", "token") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'csrf_token': csrfToken,
            'token-name': tokenName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show token in modal
            document.getElementById('generated-token').textContent = data.token;
            document.getElementById('token-modal').style.display = 'flex';

            // Add new token to list
            addTokenToList(data.token_data);

            // Reset form
            form.reset();
        } else {
            alert(data.message || 'Failed to create token');
        }
    })
    .catch(error => {
        alert('Error creating token: ' + error.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Generate New Token';
    });

    return false;
}

function addTokenToList(tokenData) {
    const tokensList = document.getElementById('tokens-list');

    // Remove "no tokens" message if exists
    const noTokens = tokensList.querySelector('.no-tokens');
    if (noTokens) {
        noTokens.remove();
    }

    // Create new token row
    const tokenRow = document.createElement('div');
    tokenRow.className = 'token-row';
    tokenRow.setAttribute('data-token-id', tokenData.id);
    tokenRow.innerHTML = `
        <div class="token-name">
            <strong>${tokenData.name}</strong>
        </div>
        <div class="token-meta">
            <span>Created: ${tokenData.created_at}</span>
            <span class="separator">•</span>
            <span>Status: Never used</span>
        </div>
        <div class="token-actions">
            <button onclick="revokeToken(${tokenData.id})" class="btn btn-sm btn-danger">Revoke</button>
        </div>
    `;

    // Insert at top of list
    tokensList.insertBefore(tokenRow, tokensList.firstChild);
}

function revokeToken(tokenId) {
    if (!confirm('Revoke this token? All API requests using it will fail.')) {
        return;
    }

    fetch('{{ Url::link("admin", "revoke") }}/' + tokenId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'csrf_token': csrfToken
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove token row from DOM
            const tokenRow = document.querySelector(`[data-token-id="${tokenId}"]`);
            if (tokenRow) {
                tokenRow.remove();
            }

            // Check if list is empty
            const tokensList = document.getElementById('tokens-list');
            if (tokensList.children.length === 0) {
                tokensList.innerHTML = '<p class="no-tokens">No API tokens yet. Generate one above to access the REST API.</p>';
            }

            alert('Token revoked successfully');
        } else {
            alert(data.message || 'Failed to revoke token');
        }
    })
    .catch(error => {
        alert('Error revoking token: ' + error.message);
    });
}

function copyGeneratedToken() {
    const tokenElement = document.getElementById('generated-token');
    const messageElement = document.getElementById('token-modal-message');
    const copyBtn = document.getElementById('copy-btn');
    const token = tokenElement.textContent;

    navigator.clipboard.writeText(token).then(() => {
        // Update message in modal
        messageElement.textContent = '✓ Token copied to clipboard!';
        messageElement.style.color = '#28a745';
        copyBtn.textContent = 'Copied!';
        copyBtn.disabled = true;
    }).catch(err => {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = token;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);

        // Update message in modal
        messageElement.textContent = '✓ Token copied to clipboard!';
        messageElement.style.color = '#28a745';
        copyBtn.textContent = 'Copied!';
        copyBtn.disabled = true;
    });
}

function closeTokenModal() {
    document.getElementById('token-modal').style.display = 'none';
}
</script>
@endsection
