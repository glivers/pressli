<?php namespace Controllers;

use Rackage\Url;
use Rackage\Csrf;
use Rackage\Mail;
use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Redirect;
use Rackage\Security;
use Models\UserModel;
use Rackage\Controller;
use Models\SettingModel;

/**
 * Authentication Controller - Pressli CMS
 *
 * Handles user authentication including login, logout, and password reset functionality.
 * Uses session-based authentication with bcrypt password verification and secure token
 * generation for password resets. All state-changing operations are CSRF-protected.
 *
 * URLs:
 * - GET  /login              Display login form
 * - POST /login              Process login credentials
 * - GET  /logout             Destroy session and logout
 * - GET  /forgot-password    Display forgot password form
 * - POST /forgot-password    Send password reset email
 * - GET  /reset-password/{token}  Display reset password form
 * - POST /reset-password     Process password reset
 *
 * Security Features:
 * - CSRF protection on all POST requests
 * - Bcrypt password hashing
 * - Session regeneration on login (prevents fixation)
 * - Secure token generation for password resets (1-hour expiration)
 * - Email enumeration prevention (always show success message)
 * - Account status validation
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class AuthController extends Controller
{
    /**
     * Display login form
     *
     * Renders the user login page with username/email and password fields.
     * Redirects to admin dashboard if user is already authenticated.
     * Pulls site title from settings for dynamic page branding.
     *
     * @return void
     */
    public function getLogin()
    {
        // Redirect if already authenticated
        if (Session::has('user_id')) {
            Redirect::to('admin');
        }

        $siteTitle = SettingModel::get('site_title', 'Pressli');

        View::render('auth/login', [
            'title' => 'Login - ' . $siteTitle
        ]);
    }

    /**
     * Process login credentials and authenticate user
     *
     * Validates CSRF token and login credentials (username or email + password).
     * Verifies user exists, password is correct with bcrypt, and account status
     * is active. Creates session with user_id, username, and role_id. Updates
     * last_login timestamp and regenerates session ID to prevent fixation attacks.
     * Optionally sets remember me token for persistent authentication.
     *
     * Security: CSRF protection, bcrypt verification, session regeneration,
     * account status check.
     *
     * @return void
     */
    public function postLogin()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Redirect::back()->flash('error', 'Invalid security token. Please try again.');
        }

        // Get credentials
        $login = Input::post('login');  // Can be username or email
        $password = Input::post('password');
        $remember = Input::post('remember');

        // Validate input
        if (empty($login) || empty($password)) {
            Redirect::back()->flash('error', 'Please enter both username/email and password.');
        }

        // Find user by username or email
        $user = UserModel::where('username = ?', $login)->first();
        if (!$user) {
            $user = UserModel::where('email = ?', $login)->first();
        }

        // Verify user exists and password is correct
        if (!$user || !Security::verify($password, $user['password'])) {
            Redirect::back()->flash('error', 'Invalid username/email or password.');
        }

        // Check if user is active
        if ($user['status'] !== 'active') {
            Redirect::back()->flash('error', 'Your account is not active. Please contact an administrator.');
        }

        // Update last login timestamp
        UserModel::where('id', $user['id'])->save([
            'last_login' => date('Y-m-d H:i:s')
        ]);

        // Regenerate session ID (prevent session fixation)
        Session::refresh();

        // Create session
        Session::set('user_id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('role_id', $user['role_id']);

        // Set remember me cookie if checked (30 days)
        if ($remember) {
            $token = Security::randomToken();
            UserModel::where('id', $user['id'])->save([
                'remember_token' => $token
            ]);
            // Note: Cookie handling would go here in production
        }

        // Redirect to admin dashboard
        Redirect::to('admin/index')->flash('success', 'Welcome back, ' . $user['username'] . '!');
    }

    /**
     * Logout user and destroy session
     *
     * Clears the remember_token from database if it exists, destroys the entire
     * user session including user_id, username, and role_id, then redirects to
     * login page with success message.
     *
     * Security: Completely flushes session data to prevent session reuse.
     *
     * @return void
     */
    public function getLogout()
    {
        // Clear remember token if exists
        if (Session::has('user_id')) {
            UserModel::where('id', Session::get('user_id'))->save([
                'remember_token' => null
            ]);
        }

        // Destroy session
        Session::flush();

        // Redirect to login
        Redirect::to('login')->flash('success', 'You have been logged out successfully.');
    }

    /**
     * Display forgot password form
     *
     * Renders the password reset request form where users can enter their email
     * to receive a password reset link. Pulls site title from settings for
     * dynamic page branding.
     *
     * @return void
     */
    public function getForgot()
    {
        $siteTitle = SettingModel::get('site_title', 'Pressli');

        View::render('auth/forgot-password', [
            'title' => 'Forgot Password - ' . $siteTitle
        ]);
    }

    /**
     * Process forgot password request and send reset email
     *
     * Validates the submitted email address, generates a secure reset token,
     * saves it to the database with 1-hour expiration, and sends password
     * reset email with the reset link. Always shows success message even if
     * email doesn't exist to prevent email enumeration attacks.
     *
     * Security: Uses cryptographically secure token generation and doesn't
     * reveal whether email exists in system.
     *
     * @return void
     */
    public function postForgot()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Redirect::back()->flash('error', 'Invalid security token. Please try again.');
        }

        // Get email
        $email = Input::post('email');

        // Validate email
        if (empty($email)) {
            Redirect::back()->flash('error', 'Please enter your email address.');
        }

        // Find user by email
        $user = UserModel::where('email = ?', $email)->first();

        // Always show success message (security: don't reveal if email exists)
        if (!$user) {
            Redirect::back()->flash('success', 'If that email address is in our system, we\'ve sent you a password reset link.');
        }

        // Generate secure token (valid for 1 hour)
        $token = Security::randomToken();
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Save token to database
        UserModel::where('id', $user['id'])->save([
            'reset_token' => $token,
            'reset_token_expires' => $expires
        ]);

        // Send password reset email
        $siteTitle = SettingModel::get('site_title', 'Pressli');
        $resetUrl = Url::base() . 'reset-password/' . $token;

        $sent = Mail::to($user['email'])
            ->subject('Password Reset Request - ' . $siteTitle)
            ->body("Hello,\n\nYou requested a password reset for your account at {$siteTitle}.\n\nClick the link below to reset your password:\n{$resetUrl}\n\nThis link will expire in 1 hour.\n\nIf you didn't request this, please ignore this email.\n\nThank you,\n{$siteTitle} Team")
            ->send();

        if (!$sent) {
            Redirect::back()->flash('error', 'Failed to send reset email. Please try again later.');
        }

        Redirect::back()->flash('success', 'Password reset link sent! Check your email.');
    }

    /**
     * Display password reset form with token validation
     *
     * Validates the password reset token from the URL parameter. Checks if token
     * exists in database and hasn't expired (1-hour validity). If valid, renders
     * the password reset form. If invalid or expired, redirects to forgot password
     * page with error message.
     *
     * @param string|null $token Password reset token from URL
     * @return void
     */
    public function getReset($token = null)
    {
        // Validate token exists
        if (empty($token)) {
            Redirect::to('forgot-password')->flash('error', 'Invalid reset link.');
        }

        // Find user with valid token
        $user = UserModel::where('reset_token = ?', $token)
            ->where('reset_token_expires > ?', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            Redirect::to('forgot-password')->flash('error', 'Reset link is invalid or has expired.');
        }

        $siteTitle = SettingModel::get('site_title', 'Pressli');

        View::render('auth/reset-password', [
            'title' => 'Reset Password - ' . $siteTitle,
            'token' => $token
        ]);
    }

    /**
     * Process password reset and update user password
     *
     * Validates the password reset form submission including CSRF token, password
     * requirements (minimum 8 characters), and password confirmation match. Verifies
     * the reset token is still valid and not expired. Updates user password with
     * bcrypt hash and clears the reset token from database. Redirects to login
     * page on success.
     *
     * Security: Validates token expiration, requires password confirmation, enforces
     * minimum password length, and uses bcrypt for password hashing.
     *
     * @return void
     */
    public function postReset()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Redirect::back()->flash('error', 'Invalid security token. Please try again.');
        }

        // Get form data
        $token = Input::post('token');
        $password = Input::post('password');
        $passwordConfirm = Input::post('password_confirm');

        // Validate inputs
        if (empty($token) || empty($password) || empty($passwordConfirm)) {
            Redirect::back()->flash('error', 'All fields are required.');
        }

        // Check passwords match
        if ($password !== $passwordConfirm) {
            Redirect::back()->flash('error', 'Passwords do not match.');
        }

        // Check password length
        if (strlen($password) < 8) {
            Redirect::back()->flash('error', 'Password must be at least 8 characters.');
        }

        // Find user with valid token
        $user = UserModel::where('reset_token = ?', $token)
            ->where('reset_token_expires > ?', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            Redirect::to('forgot-password')->flash('error', 'Reset link is invalid or has expired.');
        }

        // Update password and clear reset token
        UserModel::where('id', $user['id'])->save([
            'password' => Security::hash($password),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);

        // Redirect to login
        Redirect::to('login')->flash('success', 'Password reset successfully! You can now login with your new password.');
    }
}
