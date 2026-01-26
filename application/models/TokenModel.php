<?php namespace Models;

use Rackage\Model;

/**
 * Token Model - Pressli CMS
 *
 * Manages API authentication tokens for headless CMS and automation integrations.
 * Tokens enable password-free access to REST API endpoints (n8n, webhooks, etc.).
 *
 * SECURITY:
 * - Tokens are hashed (SHA256) before storage - never store plain text
 * - Plain token shown only once at generation - user must save it
 * - No expiration by default (long-lived for automation)
 * - User can revoke anytime from profile page
 *
 * Table: tokens
 * Primary Key: id (auto-increment)
 * Foreign Keys: user_id → users(id)
 * Indexes: token (unique, hashed), user_id
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class TokenModel extends Model
{
    protected static $table = 'api_tokens';
    protected static $timestamps = true;

    /**
     * Unique token identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * User who owns this token
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign users(id)
     * @ondelete CASCADE
     */
    protected $user_id;

    /**
     * Token name for identification
     *
     * User-friendly label like "n8n Automation", "Mobile App", "Webhook Integration".
     * Helps identify token purpose when managing multiple tokens.
     *
     * @column
     * @varchar 100
     */
    protected $name;

    /**
     * Hashed token value (SHA256)
     *
     * NEVER store plain token. Hash with hash('sha256', $plainToken) before saving.
     * Plain token shown only once at generation - user must copy/save it.
     *
     * @column
     * @varchar 64
     * @unique
     * @index
     */
    protected $token;

    /**
     * Total API requests made with this token
     *
     * Incremented on each successful API call.
     * Helps monitor token usage and detect unusual activity.
     *
     * @column
     * @int
     * @unsigned
     * @default 0
     */
    protected $times_used;

    /**
     * Last API request timestamp
     *
     * Updated when token is used for any API call.
     * NULL if never used since creation.
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $last_used;

    /**
     * IP address of last API request
     *
     * Updated with Request::ip() on each API call.
     * Helps detect token theft or unauthorized usage.
     *
     * @column
     * @varchar 45
     * @nullable
     */
    protected $last_ip;

    /**
     * When token was created
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * When token was last modified
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;
}
