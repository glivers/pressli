<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div style="text-align: center; margin-bottom: var(--spacing-xl);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 80px; height: 80px; margin: 0 auto var(--spacing-lg); color: var(--text-tertiary);">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <h1 style="font-size: 72px; font-weight: 700; color: var(--text-primary); margin: 0 0 var(--spacing-sm) 0; line-height: 1;">
                    404
                </h1>
                <h2 style="font-size: 20px; font-weight: 600; color: var(--text-primary); margin: 0 0 var(--spacing-sm) 0;">
                    Page Not Found
                </h2>
                <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">
                    The page you are looking for doesn't exist or has been moved.
                </p>
            </div>

            <div style="display: flex; gap: var(--spacing-sm);">
                <button onclick="history.back()" class="btn btn-secondary" style="flex: 1;">Go Back</button>
                <a href="index.html" class="btn btn-primary" style="flex: 1; text-align: center; text-decoration: none;">Go to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
