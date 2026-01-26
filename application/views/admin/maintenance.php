<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div style="text-align: center; margin-bottom: var(--spacing-xl);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 80px; height: 80px; margin: 0 auto var(--spacing-lg); color: var(--primary);">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                </svg>
                <h1 style="font-size: 28px; font-weight: 700; color: var(--text-primary); margin: 0 0 var(--spacing-sm) 0;">
                    We'll Be Right Back
                </h1>
                <p style="font-size: 14px; color: var(--text-secondary); margin: 0 0 var(--spacing-lg) 0; line-height: 1.6;">
                    We're currently performing scheduled maintenance.<br>
                    The site will be back online shortly.
                </p>
            </div>

            <div style="padding: var(--spacing-md); background: var(--bg-secondary); border-radius: 8px; text-align: center;">
                <p style="font-size: 13px; color: var(--text-tertiary); margin: 0;">
                    Expected downtime: <strong style="color: var(--text-primary);">30 minutes</strong>
                </p>
            </div>

            <div style="margin-top: var(--spacing-lg); text-align: center;">
                <button onclick="location.reload()" class="btn btn-primary">Check Again</button>
            </div>
        </div>
    </div>
</body>
</html>
