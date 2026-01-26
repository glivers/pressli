<?php namespace Controllers;

use Rackage\View;
use Rackage\Input;
use Rackage\Request;
use Rackage\Session;
use Models\UserModel;
use Models\TokenModel;
use Rackage\Controller;

/**
 * API Base Controller - Pressli CMS
 *
 * Base controller for all REST API endpoints providing headless CMS functionality.
 * Handles Bearer token authentication and establishes user sessions so existing
 * AdminController logic can be reused without modification.
 *
 * AUTHENTICATION FLOW:
 * 1. Extract Bearer token from Authorization header
 * 2. Hash token (SHA256) and lookup in api_tokens table
 * 3. Validate token exists and associated user is active
 * 4. Create user session (Session::set('user_id')) for admin code compatibility
 * 5. Track usage: update last_used, last_ip, increment times_used
 * 6. Exit with 401 JSON if any step fails
 *
 * USAGE:
 * All API controllers extend this class. Authentication runs automatically
 * via constructor before any route method executes.
 *
 * Example API controller:
 *   class ApiPostsController extends ApiController
 *   {
 *       public function postCreate() {
 *           // Session already set, user authenticated
 *           // Call existing admin logic or use $this->user
 *       }
 *   }
 *
 * CLIENT USAGE:
 * Include token in every request:
 *   Authorization: Bearer {token}
 *
 * Example with curl:
 *   curl -H "Authorization: Bearer abc123..." https://site.com/api/posts
 *
 * Example with n8n HTTP Request node:
 *   Authentication: Generic Credential Type
 *   Add "Authorization" header with value "Bearer {token}"
 *
 * SECURITY:
 * - Tokens stored as SHA256 hash (never plain text)
 * - Plain token shown once at generation - user must save it
 * - No token expiration (self-hosted, user manages revocation)
 * - Rate limiting not implemented (self-hosted assumption)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class ApiController extends Controller
{
    /**
     * Authenticated user data
     *
     * Populated after successful token authentication.
     * Contains full user record from users table.
     *
     * @var array User data (id, username, email, role_id, etc.)
     */
    protected $user;

    /**
     * Constructor - Authenticate API request via Bearer token
     *
     * Runs before any API controller method. Validates Authorization header,
     * looks up token in database, verifies user is active, and establishes
     * session for compatibility with existing admin code.
     *
     * Exits with 401 JSON response if:
     * - Authorization header missing
     * - Token invalid/not found
     * - User inactive/deleted
     *
     * On success:
     * - Sets Session user_id and role_id
     * - Populates $this->user property
     * - Updates token usage tracking (last_used, last_ip, times_used)
     *
     * @return void Exits on authentication failure
     */
    public function __construct()
    {
        // Extract token from Authorization: Bearer {token} header
        $token = Request::bearer();

        if (!$token) {
            View::halt([
                'success' => false,
                'error' => 'Missing authorization token',
                'message' => 'Include Authorization: Bearer {token} header'
            ], 401);
        }

        // Hash token for database lookup (tokens stored as SHA256)
        $hashedToken = hash('sha256', $token);
        $apiToken = TokenModel::where('token', $hashedToken)->first();

        if (!$apiToken) {
            View::halt([
                'success' => false,
                'error' => 'Invalid authorization token',
                'message' => 'Token not found or has been revoked'
            ], 401);
        }

        // Verify user exists and is active
        $user = UserModel::where('id', $apiToken['user_id'])
            ->where('status', 'active')
            ->first();

        if (!$user) {
            View::halt([
                'success' => false,
                'error' => 'User account inactive or deleted',
                'message' => 'The user associated with this token is no longer active'
            ], 401);
        }

        // Parse JSON body and populate Input for admin controller compatibility
        if (Request::isJson()) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            if ($jsonData) {
                $_POST = array_merge($_POST, $jsonData);
                Input::setPost();
            }
        }

        // Set session for admin controller compatibility (same as login)
        Session::set('user_id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('role_id', $user['role_id']);
        $this->user = $user;

        // Bypass CSRF for API requests (Bearer token already authenticates)
        Session::set('api_request', true);

        // Track token usage for security monitoring
        TokenModel::where('id', $apiToken['id'])->save([
            'last_used' => date('Y-m-d H:i:s'),
            'last_ip' => Request::ip()
        ]);

        TokenModel::where('id', $apiToken['id'])->increment(['times_used']);
    }
}
