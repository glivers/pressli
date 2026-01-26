<?php namespace Controllers\Admin;

use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Redirect;
use Rackage\Security;
use Rackage\Csrf;
use Models\UserModel;
use Models\RoleModel;
use Controllers\Admin\AdminController;

/**
 * Users Controller - Pressli CMS
 *
 * Manages user accounts in the admin panel. Handles creating, editing, and deleting
 * user accounts with role assignment and profile management. All state-changing
 * operations are CSRF-protected and passwords are hashed with bcrypt.
 *
 * Routes (automatic URL-based routing):
 * - GET  /users           List all users with role filtering
 * - GET  /users/create    Display user creation form
 * - POST /users/create    Process new user creation
 * - GET  /users/edit/{id} Display user edit form
 * - POST /users/update/{id} Process user update
 * - GET  /users/delete/{id} Soft delete user account
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class AdminUsersController extends AdminController
{
    /**
     * Display list of all users with role filtering
     *
     * Fetches all non-deleted users with their role names via LEFT JOIN.
     * Calculates user counts per role for filter tab badges. Orders by
     * created_at descending (newest first).
     *
     * @return void
     */
    public function getIndex()
    {
        // Fetch users with role names to avoid N+1 query problem
        $users = UserModel::leftJoin('roles', 'role_id = id', ['name as role_name'])
            ->whereNull('deleted_at')
            ->order('created_at', 'desc')
            ->all();

        // Calculate counts for each role filter tab
        $roleCounts = [];
        $allRoles = RoleModel::all();

        foreach ($allRoles as $role) {
            $count = UserModel::where('role_id', $role['id'])
                ->whereNull('deleted_at')
                ->count();
            $roleCounts[$role['name']] = $count;
        }

        View::render('admin/users', [
            'title' => 'Users',
            'users' => $users,
            'roleCounts' => $roleCounts,
            'totalUsers' => count($users)
        ]);
    }

    /**
     * Display form to create new user
     *
     * Loads all available roles for dropdown selection in the form.
     *
     * @return void
     */
    public function getCreate()
    {
        $roles = RoleModel::order('name', 'asc')->all();

        View::render('admin/users-add', [
            'title' => 'Add New User',
            'roles' => $roles
        ]);
    }

    /**
     * Process new user creation
     *
     * Validates input, checks username/email uniqueness, hashes password with bcrypt,
     * and creates user with 'active' status.
     *
     * Validation: username, email, password, role_id required; password min 8 chars;
     * passwords must match; username and email must be unique.
     *
     * @return void Redirects to /users on success, back on error
     */
    public function postCreate()
    {
        if (!Csrf::verify()) {
            Redirect::back()->flash('error', 'Invalid security token. Please try again.');
        }

        $username = Input::post('username');
        $email = Input::post('email');
        $password = Input::post('password');
        $passwordConfirm = Input::post('password-confirm');
        $firstName = Input::post('first-name');
        $lastName = Input::post('last-name');
        $website = Input::post('website');
        $roleId = Input::post('role-id');

        // Validate required fields
        if (empty($username) || empty($email) || empty($password) || empty($roleId)) {
            Redirect::back()->flash('error', 'Please fill in all required fields.');
        }

        // Validate password
        if ($password !== $passwordConfirm) {
            Redirect::back()->flash('error', 'Passwords do not match.');
        }

        if (strlen($password) < 8) {
            Redirect::back()->flash('error', 'Password must be at least 8 characters long.');
        }

        // Check uniqueness
        if (UserModel::where('username', $username)->first()) {
            Redirect::back()->flash('error', 'Username already exists. Please choose another.');
        }

        if (UserModel::where('email', $email)->first()) {
            Redirect::back()->flash('error', 'Email already exists. Please use another.');
        }

        // Create user with hashed password
        UserModel::save([
            'username' => $username,
            'email' => $email,
            'password' => Security::hash($password),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'website' => $website,
            'role_id' => $roleId,
            'status' => 'active'
        ]);

        Redirect::to('admin/users')->flash('success', 'User created successfully!');
    }

    /**
     * Display form to edit user profile
     *
     * Loads user data and all roles for editing. Returns 404 if user not found
     * or already deleted.
     *
     * @param int $id User ID from URL
     * @return void
     */
    public function getEdit($id)
    {
        $user = UserModel::where('id', $id)->whereNull('deleted_at')->first();

        if (!$user) {
            Redirect::to('admin/users')->flash('error', 'User not found.');
        }

        $roles = RoleModel::order('name', 'asc')->all();

        View::render('admin/users-profile', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Process user profile update
     *
     * Updates user information including profile fields, social links, role, and status.
     * Password update is optional - only updates if new password provided.
     * Validates username/email uniqueness excluding current user.
     *
     * @param int $id User ID from URL
     * @return void Redirects to /users on success, back on error
     */
    public function postUpdate($id)
    {
        if (!Csrf::verify()) {
            Redirect::back()->flash('error', 'Invalid security token. Please try again.');
        }

        $user = UserModel::where('id', $id)->whereNull('deleted_at')->first();

        if (!$user) {
            Redirect::to('admin/users')->flash('error', 'User not found.');
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
        $roleId = Input::post('role-id');
        $status = Input::post('status');
        $password = Input::post('password');
        $passwordConfirm = Input::post('password-confirm');

        // Validate required fields
        if (empty($username) || empty($email)) {
            Redirect::back()->flash('error', 'Username and email are required.');
        }

        // Check uniqueness excluding current user
        $existingUsername = UserModel::where('username', $username)
            ->where('id !=', $id)
            ->first();

        if ($existingUsername) {
            Redirect::back()->flash('error', 'Username already taken by another user.');
        }

        $existingEmail = UserModel::where('email', $email)
            ->where('id !=', $id)
            ->first();

        if ($existingEmail) {
            Redirect::back()->flash('error', 'Email already taken by another user.');
        }

        // Build update array
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
            'github' => $github,
            'role_id' => $roleId,
            'status' => $status
        ];

        // Update password only if provided
        if (!empty($password)) {
            if ($password !== $passwordConfirm) {
                Redirect::back()->flash('error', 'Passwords do not match.');
            }

            if (strlen($password) < 8) {
                Redirect::back()->flash('error', 'Password must be at least 8 characters long.');
            }

            $updateData['password'] = Security::hash($password);
        }

        UserModel::where('id', $id)->save($updateData);

        Redirect::to('admin/users')->flash('success', 'User updated successfully!');
    }

    /**
     * Soft delete user account
     *
     * Sets deleted_at timestamp instead of removing record. Preserves data integrity
     * for posts/comments authored by user. Prevents self-deletion to avoid lockout.
     *
     * @param int $id User ID from URL
     * @return void Redirects to /users with status message
     */
    public function getDelete($id)
    {
        // Prevent self-deletion
        if ($id == Session::get('user_id')) {
            Redirect::to('admin/users')->flash('error', 'You cannot delete your own account.');
        }

        $user = UserModel::where('id', $id)->whereNull('deleted_at')->first();

        if (!$user) {
            Redirect::to('admin/users')->flash('error', 'User not found.');
        }

        // Soft delete by setting timestamp
        UserModel::where('id', $id)->save([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);

        Redirect::to('admin/users')->flash('success', 'User deleted successfully.');
    }
}
