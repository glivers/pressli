<?php namespace Controllers;

/**
 * Admin Base Controller - Pressli CMS
 *
 * Base controller for all admin panel controllers. Handles authentication
 * checks and responds appropriately based on request type (JSON for AJAX,
 * redirect for browser requests).
 *
 * All admin controllers should extend this class to inherit authentication.
 *
 * Routes:
 *   GET  /admin           - Admin dashboard
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\View;
use Rackage\Input;
use Rackage\Request;
use Rackage\Session;
use Rackage\Redirect;
use Rackage\Security;
use Rackage\Csrf;
use Rackage\Controller;
use Models\UserModel;
use Models\TokenModel;

class AdminController extends Controller
{
    /**
     * Constructor - Check authentication before any admin action
     *
     * Verifies user is logged in before allowing access to admin panel.
     * Responds based on request type:
     * - AJAX/JSON requests: Returns 401 JSON error
     * - Browser requests: Redirects to login page
     *
     * @return void
     */
    public function __construct()
    {
        // Check if user is authenticated
        if (!Session::has('user_id')) {
            
            // AJAX or API request expecting JSON
            if (Request::ajax()) {
                View::halt(['error' => 'Unauthorized. Please login to access this resource.'], 401);
            }

            // Normal browser request - redirect to login
            Redirect::to('login')->flash('error', 'Please login to access the admin panel');
        }
    }

    /**
     * Display admin on no method provided
     * 
     * Main landing page for admin dashboard
     * @param null
     * @return void
     */
    public function getIndex()
    {
        $data['title'] = 'Dashboard';
        View::render('admin/index', $data);
    }

    /**
     * Display admin dashboard
     *
     * Main landing page for authenticated admin users.
     *
     * @return void
     */
    public function dash()
    {
        $data['title'] = 'Dashboard';
        View::render('admin/index', $data);
    }

    /**
     * Display profile page with API tokens
     *
     * Shows current user's profile information and list of their API tokens
     * with usage statistics. User can edit profile and manage tokens from here.
     *
     * @return void
     */
    public function getProfile()
    {
        $userId = Session::get('user_id');
        $user = UserModel::where('id', $userId)->first();

        if (!$user) {
            Session::flash('error', 'User not found.');
            Redirect::to('admin/dashboard');
        }

        // Get user's API tokens
        $tokens = TokenModel::where('user_id', $userId)
            ->order('created_at', 'desc')
            ->all();

        View::render('admin/profile', [
            'title' => 'My Profile',
            'user' => $user,
            'tokens' => $tokens
        ]);
    }

    /**
     * Update own profile information
     *
     * Allows user to update personal information (name, email, password, bio, social).
     * Cannot change role or status (prevents privilege escalation). Password update
     * is optional - only updates if new password provided.
     *
     * @return void Redirects to profile on success, back on error
     */
    public function postProfile()
    {
        if (!Csrf::verify()) {
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        $userId = Session::get('user_id');
        $user = UserModel::where('id', $userId)->first();

        if (!$user) {
            Session::flash('error', 'User not found.');
            Redirect::to('admin/dashboard');
        }

        $username = Input::post('username');
        $email = Input::post('email');
        $firstName = Input::post('first-name');
        $lastName = Input::post('last-name');
        $bio = Input::post('bio');
        $website = Input::post('website');
        $twitter = Input::post('twitter');
        $facebook = Input::post('facebook');
        $linkedin = Input::post('linkedin');
        $github = Input::post('github');
        $password = Input::post('password');
        $passwordConfirm = Input::post('password-confirm');

        // Validate required fields
        if (empty($username) || empty($email)) {
            Session::flash('error', 'Username and email are required.');
            Redirect::back();
        }

        // Check username uniqueness excluding current user
        $existingUsername = UserModel::where('username', $username)
            ->where('id != ?', $userId)
            ->first();

        if ($existingUsername) {
            Session::flash('error', 'Username already taken by another user.');
            Redirect::back();
        }

        // Check email uniqueness excluding current user
        $existingEmail = UserModel::where('email', $email)
            ->where('id !=', $userId)
            ->first();

        if ($existingEmail) {
            Session::flash('error', 'Email already taken by another user.');
            Redirect::back();
        }

        // Build update array (excluding role and status)
        $updateData = [
            'username' => $username,
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'bio' => $bio,
            'website' => $website,
            'twitter' => $twitter,
            'facebook' => $facebook,
            'linkedin' => $linkedin,
            'github' => $github
        ];

        // Update password only if provided
        if (!empty($password)) {
            if ($password !== $passwordConfirm) {
                Session::flash('error', 'Passwords do not match.');
                Redirect::back();
            }

            if (strlen($password) < 8) {
                Session::flash('error', 'Password must be at least 8 characters long.');
                Redirect::back();
            }

            $updateData['password'] = Security::hash($password);
        }

        UserModel::where('id', $userId)->save($updateData);

        Session::flash('success', 'Profile updated successfully!');
        Redirect::to('admin/profile');
    }

    /**
     * Generate new API token
     *
     * Creates cryptographically secure token (64 chars) for API authentication.
     * Token is hashed (SHA256) before storage. Plain token shown once - user must
     * copy it immediately. Token never expires (long-lived for automation).
     *
     * @return void Returns JSON with token or error
     */
    public function postToken()
    {
        if (!Csrf::verify()) {
            View::json(['success' => false, 'message' => 'Invalid security token'], 403);
            return;
        }

        $userId = Session::get('user_id');
        $name = Input::post('token-name');

        // Validate token name
        if (empty($name)) {
            View::json(['success' => false, 'message' => 'Token name is required'], 400);
            return;
        }

        // Generate cryptographically secure token (64 characters)
        $plainToken = bin2hex(random_bytes(32));

        // Hash token for storage (never store plain token)
        $hashedToken = hash('sha256', $plainToken);

        // Save token to database
        $tokenId = TokenModel::save([
            'user_id' => $userId,
            'name' => $name,
            'token' => $hashedToken,
            'times_used' => 0
        ]);

        // Return plain token and token data
        View::json([
            'success' => true,
            'token' => $plainToken,
            'token_data' => [
                'id' => $tokenId,
                'name' => $name,
                'created_at' => date('M j, Y g:i A')
            ]
        ]);
    }

    /**
     * Revoke API token
     *
     * Permanently deletes token. All API requests using this token will fail.
     * Use for rotating tokens or revoking compromised credentials.
     *
     * @param int $id Token ID from URL
     * @return void Returns JSON with status
     */
    public function postRevoke($id)
    {
        if (!Csrf::verify()) {
            View::json(['success' => false, 'message' => 'Invalid security token'], 403);
            return;
        }

        $userId = Session::get('user_id');

        // Verify token belongs to current user (prevent revoking other users' tokens)
        $token = TokenModel::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$token) {
            View::json(['success' => false, 'message' => 'Token not found or access denied'], 404);
            return;
        }

        // Delete token permanently
        TokenModel::where('id', $id)->delete();

        View::json(['success' => true, 'message' => 'Token revoked successfully']);
    }
}
