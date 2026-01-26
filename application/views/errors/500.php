<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <link rel="stylesheet" href="{{Url::assets('admin/css/admin.css')}}">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div style="text-align: center; margin-bottom: var(--spacing-xl);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 80px; height: 80px; margin: 0 auto var(--spacing-lg); color: var(--danger);">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <h1 style="font-size: 72px; font-weight: 700; color: var(--text-primary); margin: 0 0 var(--spacing-sm) 0; line-height: 1;">
                    500
                </h1>
                <h2 style="font-size: 20px; font-weight: 600; color: var(--text-primary); margin: 0 0 var(--spacing-sm) 0;">
                    Internal Server Error
                </h2>
                <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">
                    Something went wrong on our end. Please try again later.
                </p>
            </div>

            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="{{Url::base()}}" class="btn btn-secondary" style="flex: 1;">Reload Page</a>
                <a href="{{Url::link('admin/dash')}}" class="btn btn-primary" style="flex: 1; text-align: center; text-decoration: none;">Go to Dashboard</a>
            </div>

            <div style="margin-top: var(--spacing-lg); text-align: center;">
                <p style="font-size: 13px; color: var(--text-tertiary);">
                    If the problem persists, please contact your site administrator.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
