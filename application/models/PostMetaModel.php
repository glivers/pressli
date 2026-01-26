<?php namespace Models;

use Rackage\Model;

/**
 * PostMeta Model - Pressli CMS
 *
 * Extensible key-value metadata storage for posts using EAV (Entity-Attribute-Value) pattern.
 * Allows plugins to add custom fields without schema changes. Each post can have unlimited
 * meta fields stored as individual rows.
 *
 * COMMON USE CASES:
 * - Custom post fields (salary, location for job posts)
 * - Plugin data (SEO meta, social media data)
 * - Theme options (custom layouts, colors)
 * - Temporary data (draft revisions, import metadata)
 *
 * PERFORMANCE NOTES:
 * - Composite index on (post_id, meta_key) for fast lookups
 * - Use PostModel JOINs for queries filtering by meta
 * - Avoid N+1 queries by eager loading meta with posts
 *
 * RELATIONSHIPS:
 * - Post: Many meta rows belong to one post (CASCADE delete)
 *
 * Table: post_meta
 * Primary Key: id (auto-increment)
 * Foreign Keys: post_id → posts(id)
 *
 * @composite (post_id, meta_key)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class PostMetaModel extends Model
{
    protected static $table = 'post_meta';
    protected static $timestamps = false;

    /**
     * Unique meta identifier
     *
     * Auto-incremented primary key.
     * Not typically used directly (queries use post_id + meta_key).
     *
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Parent post ID
     *
     * Foreign key to posts table.
     * CASCADE delete removes all meta when post deleted.
     *
     * @column
     * @int
     * @unsigned
     * @foreign posts(id)
     * @ondelete CASCADE
     * @index
     */
    protected $post_id;

    /**
     * Meta key (field name)
     *
     * Identifier for this metadata field (e.g., 'salary', 'location', 'seo_title').
     * Use namespaces for plugins: 'plugin_name:field_name'.
     *
     * @column
     * @varchar 255
     * @index
     */
    protected $meta_key;

    /**
     * Meta value
     *
     * Actual data stored for this field. Can be string, number, or serialized array/object.
     * For complex data, use JSON encoding: json_encode(['key' => 'value']).
     *
     * @column
     * @longtext
     * @nullable
     */
    protected $meta_value;
}
