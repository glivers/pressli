<?php namespace Models;

use Rackage\Model;

/**
 * User Model - Pressli CMS
 *
 * Manages user accounts for authentication, authorization, and profile management in Pressli.
 * Users are assigned roles which determine their permissions within the CMS.
 * Supports soft deletion to maintain referential integrity.
 *
 * Table: users
 * Primary Key: id (auto-increment)
 * Foreign Keys: role_id → roles(id)
 * Indexes: username (unique), email (unique), status, deleted_at
 *
 * @composite (email, deleted_at)
 * @composite (username, deleted_at)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class UserModel extends Model
{
    protected static $table = 'users';
    protected static $timestamps = true;

    /**
     * Unique user identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Unique username for login
     * @column
     * @varchar 60
     * @unique
     */
    protected $username;

    /**
     * User email address
     * @column
     * @varchar 255
     * @unique
     */
    protected $email;

    /**
     * Hashed password using bcrypt
     * @column
     * @varchar 255
     */
    protected $password;

    /**
     * User's first name
     * @column
     * @varchar 100
     * @nullable
     */
    protected $first_name;

    /**
     * User's last name
     * @column
     * @varchar 100
     * @nullable
     */
    protected $last_name;

    /**
     * User role ID for permissions
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign roles(id)
     * @ondelete RESTRICT
     */
    protected $role_id;

    /**
     * Account status
     * @column
     * @enum active,inactive,suspended
     * @default active
     * @index
     */
    protected $status;

    /**
     * User avatar URL or path
     * @column
     * @varchar 500
     * @nullable
     */
    protected $avatar;

    /**
     * User biography or description
     * @column
     * @text
     * @nullable
     */
    protected $bio;

    /**
     * User's website URL
     * @column
     * @varchar 255
     * @nullable
     */
    protected $website;

    /**
     * Twitter or X username
     * @column
     * @varchar 100
     * @nullable
     */
    protected $twitter;

    /**
     * Facebook profile URL
     * @column
     * @varchar 255
     * @nullable
     */
    protected $facebook;

    /**
     * LinkedIn profile URL
     * @column
     * @varchar 255
     * @nullable
     */
    protected $linkedin;

    /**
     * GitHub username
     * @column
     * @varchar 100
     * @nullable
     */
    protected $github;

    /**
     * Last successful login timestamp
     * @column
     * @datetime
     * @nullable
     */
    protected $last_login;

    /**
     * Remember me token for persistent authentication
     * @column
     * @varchar 100
     * @nullable
     * @index
     */
    protected $remember_token;

    /**
     * Password reset token sent via email
     * @column
     * @varchar 100
     * @nullable
     * @index
     */
    protected $reset_token;

    /**
     * Password reset token expiration timestamp
     * @column
     * @datetime
     * @nullable
     */
    protected $reset_token_expires;

    /**
     * When user account was created
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * When user account was last updated
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;

    /**
     * Soft delete timestamp for data retention
     * @column
     * @datetime
     * @nullable
     */
    protected $deleted_at;
}
