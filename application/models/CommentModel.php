<?php namespace Models;

use Rackage\Model;

/**
 * Comment Model - Pressli CMS
 *
 * Manages user comments on posts. Supports threaded/nested replies via parent_id,
 * moderation workflow (pending → approved/spam), and soft deletion for recovery.
 * Stores commenter information and IP for spam prevention.
 *
 * RELATIONSHIPS:
 * - Post: Many comments belong to one post (RESTRICT delete)
 * - Parent: Comments can be nested (replies to other comments)
 *
 * MODERATION STATES:
 * - pending: Awaiting approval (default for new comments)
 * - approved: Visible on public site
 * - spam: Marked as spam, hidden from public
 *
 * Table: comments
 * Primary Key: id (auto-increment)
 * Foreign Keys: post_id → posts(id), parent_id → comments(id)
 *
 * @composite (post_id, created_at)
 * @composite (status, created_at)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class CommentModel extends Model
{
    protected static $table = 'comments';
    protected static $timestamps = true;

    /**
     * Unique comment identifier
     *
     * Auto-incremented primary key for comment records.
     *
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Post this comment belongs to
     *
     * Foreign key to posts table. RESTRICT prevents deleting posts with comments.
     * Use post_id to fetch all comments for a specific post.
     *
     * @column
     * @int
     * @unsigned
     * @index
     */
    protected $post_id;

    /**
     * Commenter's display name
     *
     * Name shown in comment thread. Required for all comments.
     * May be user's real name, username, or nickname.
     *
     * @column
     * @varchar 255
     */
    protected $author_name;

    /**
     * Commenter's email address
     *
     * Email for notifications and Gravatar. Required but not displayed publicly.
     * Used for spam filtering and author identification.
     *
     * @column
     * @varchar 255
     * @index
     */
    protected $author_email;

    /**
     * Commenter's website URL
     *
     * Optional website link shown with comment.
     * Should be validated to prevent spam/malicious links.
     *
     * @column
     * @varchar 255
     * @nullable
     */
    protected $author_url;

    /**
     * Commenter's IP address
     *
     * IP at time of submission for spam detection and abuse prevention.
     * Supports IPv4 (15 chars) and IPv6 (45 chars).
     *
     * @column
     * @varchar 45
     */
    protected $author_ip;

    /**
     * Comment text content
     *
     * The actual comment message. HTML is stripped/escaped before storage.
     * Supports plain text with basic formatting (line breaks preserved).
     *
     * @column
     * @text
     */
    protected $content;

    /**
     * Moderation status
     *
     * Current state in moderation workflow:
     * - pending: New comment awaiting approval (default)
     * - approved: Passed moderation, visible on public site
     * - spam: Flagged as spam, hidden from public
     *
     * @column
     * @enum pending,approved,spam
     * @default pending
     * @index
     */
    protected $status;

    /**
     * Parent comment for threaded replies
     *
     * NULL for top-level comments. For replies, references parent comment ID.
     * Enables nested comment threads (e.g., Reply to John's comment).
     *
     * @column
     * @int
     * @unsigned
     * @nullable
     * @index
     */
    protected $parent_id;

    /**
     * Comment creation timestamp
     *
     * When comment was originally submitted by user.
     * Auto-set by Rachie when $timestamps = true.
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * Last edit timestamp
     *
     * When comment content or metadata was last modified.
     * Auto-updated by Rachie on every save().
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;

    /**
     * Soft delete timestamp
     *
     * When comment was moved to trash. NULL for active comments.
     * Allows recovery before permanent deletion.
     *
     * @column
     * @datetime
     * @nullable
     * @index
     */
    protected $deleted_at;
}
