<?php namespace Controllers;

/**
 * Forms Controller - Pressli CMS
 *
 * Handles form submissions for contact forms, audit requests, and other
 * frontend forms. Validates input, sends emails, and returns JSON responses
 * for AJAX form handling.
 *
 * RESPONSIBILITIES:
 *   - Accept POST submissions from frontend forms
 *   - Validate CSRF tokens for security
 *   - Send email notifications using Mail class
 *   - Return JSON responses for AJAX handling
 *   - Block GET requests (forms must be POST only)
 *
 * ROUTING:
 *   POST /forms    → postIndex()  (accept form submissions)
 *   GET  /forms    → getIndex()   (rejected with 405 error)
 *
 * SECURITY:
 *   - CSRF token verification on all POST requests
 *   - Returns 403 if CSRF check fails
 *   - No file uploads (contact/audit forms are text only)
 *   - Email addresses validated before sending
 *
 * FORM TYPES:
 *   This controller handles all form types generically. Form-specific
 *   logic (recipient email, subject) should be determined by frontend
 *   or configuration. Current forms:
 *   - Contact forms (name, email, company, message)
 *   - SEO audit requests (name, email, company, website, goals)
 *   - Newsletter signups (email only)
 *
 * EMAIL CONFIGURATION:
 *   Uses Mail class with settings from config/mail.php
 *   Supports SMTP, sendmail, or mail() method
 *
 * RESPONSE FORMAT:
 *   Success: {"success": true, "message": "Form submitted successfully"}
 *   Error:   {"error": "Error message here"}
 *   HTTP status codes: 200 (success), 403 (CSRF), 405 (method), 500 (email failed)
 *
 * TODO:
 *   - Add database storage for form submissions (future plugin)
 *   - Add spam protection (honeypot, rate limiting)
 *   - Add form type routing (different handlers per form)
 *   - Migrate to plugin architecture for flexibility
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\Controller;
use Rackage\View;
use Rackage\Input;
use Rackage\Mail;
use Rackage\Csrf;

class FormsController extends Controller
{
    /**
     * GET requests not allowed
     *
     * Forms must be submitted via POST for security. GET requests
     * are rejected with 405 Method Not Allowed error.
     *
     * @return void Returns JSON error response with 405 status
     */
    public function getIndex()
    {
        View::json(['error' => 'Method not allowed. Forms must be submitted via POST.'], 405);
    }

    /**
     * Handle form submissions
     *
     * Accepts POST data from frontend forms, validates CSRF token,
     * sends email notification, and returns JSON response.
     *
     * PROCESS:
     *   1. Verify CSRF token (reject if invalid)
     *   2. Get all POST data
     *   3. Build email body from submitted fields
     *   4. Send email using Mail class
     *   5. Return success/error JSON response
     *
     * EXPECTED POST DATA:
     *   - csrf_token: CSRF token (required, validated)
     *   - All other fields: Form-specific data (name, email, message, etc.)
     *
     * EMAIL FORMAT:
     *   Plain text email with each field on new line:
     *   Name: John Doe
     *   Email: john@example.com
     *   Message: Hello...
     *
     * RESPONSE EXAMPLES:
     *   Success: {"success": true, "message": "Form submitted successfully"}
     *   CSRF fail: {"error": "Invalid request"} (403 status)
     *   Email fail: {"error": "Failed to send email"} (500 status)
     *
     * @return void Returns JSON response
     */
    public function postIndex()
    {
        // STEP 1: Verify CSRF token for security
        if (!Csrf::verify()) {
            return View::json(['error' => 'Invalid request'], 403);
        }

        // STEP 2: Get all form data
        $data = Input::post();

        // STEP 3: Build plain text email body
        $body = "New form submission:\n\n";
        foreach ($data as $key => $value) {
            // Skip CSRF token in email
            if ($key !== 'csrf_token') {
                $body .= ucfirst($key) . ": " . $value . "\n";
            }
        }

        // STEP 4: Send email using Mail class
        // TODO: Make recipient configurable per form type
        $sent = Mail::to('admin@yourdomain.com')
            ->subject('New Form Submission')
            ->body($body)
            ->send();

        // STEP 5: Return JSON response
        if ($sent) {
            View::json(['success' => true, 'message' => 'Form submitted successfully']);
        } else {
            View::json(['error' => 'Failed to send email. Please try again later.'], 500);
        }
    }
}
