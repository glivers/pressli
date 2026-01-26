<?php namespace Models;

use Rackage\Model;

/**
 * Post Model - Pressli CMS
 *
 * Unified content model for all content types (posts, pages, jobs, products, etc.).
 * Uses type discriminator to distinguish between content types, enabling flexible
 * plugin architecture without schema changes.
 *
 * CONTENT TYPES:
 * - post: Blog articles with categories, tags, comments
 * - page: Static content (About, Contact) with hierarchy support
 * - Custom types: Plugins can register (job, product, portfolio, etc.)
 *
 * STATUS WORKFLOW:
 * - draft: Work in progress, not visible to public
 * - published: Live content (published_at <= NOW)
 * - scheduled: Auto-publish when published_at reached
 * - trash: Soft deleted via deleted_at timestamp
 *
 * RELATIONSHIPS:
 * - Author: Many posts belong to one user (RESTRICT delete)
 * - Featured Image: Optional media attachment (SET NULL on delete)
 * - Categories/Tags: Many-to-many via post_taxonomies junction table
 * - Custom Meta: One-to-many with post_meta for extensible fields
 * - Parent: Self-referencing for hierarchical pages
 *
 * Table: posts
 * Primary Key: id (auto-increment)
 * Foreign Keys: author_id → users(id), featured_image_id → media(id), parent_id → posts(id)
 *
 * @composite (type, status, published_at)
 * @composite (slug, deleted_at)
 * @composite (author_id, status)
 * @composite (parent_id, menu_order)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class PostModel extends Model
{
    protected static $table = 'posts';
    protected static $timestamps = true;

    /**
     * Unique post identifier
     *
     * Auto-incremented primary key.
     * Referenced by post_taxonomies and comments tables.
     *
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Post title
     *
     * Display name shown in listings and single post view.
     * Used in <title> tag if meta_title is empty.
     *
     * @column
     * @varchar 255
     */
    protected $title;

    /**
     * URL-friendly slug identifier
     *
     * Must be unique per post, used in URLs: /blog/{slug}
     * Auto-generated from title if not provided.
     *
     * @column
     * @varchar 255
     * @unique
     * @index
     */
    protected $slug;

    /**
     * Full post content (HTML)
     *
     * Rich text from WYSIWYG editor (TinyMCE/CKEditor).
     * Supports formatting, images, embeds. Sanitized to prevent XSS.
     *
     * @column
     * @longtext
     */
    protected $content;

    /**
     * Short excerpt for previews
     *
     * Used in listing pages, RSS feeds, social sharing (150-160 chars recommended).
     * Auto-generated from content if null.
     *
     * @column
     * @text
     * @nullable
     */
    protected $excerpt;

    /**
     * Author user ID
     *
     * Foreign key to users table.
     * RESTRICT delete prevents user deletion if they have posts.
     *
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign users(id)
     * @ondelete RESTRICT
     */
    protected $author_id;

    /**
     * Publication status
     *
     * Controls visibility workflow: draft → published/scheduled → trash.
     * Scheduled posts auto-publish when published_at <= NOW.
     *
     * @column
     * @enum draft,published,scheduled,trash
     * @default draft
     * @index
     */
    protected $status;

    /**
     * Post visibility level
     *
     * public: visible to all, private: logged-in users only,
     * password: requires password stored in password field.
     *
     * @column
     * @enum public,private,password
     * @default public
     */
    protected $visibility;

    /**
     * Password for password-protected posts
     *
     * Only used when visibility = 'password'.
     * Stored hashed using Security::hash(), verify with Security::verify().
     *
     * @column
     * @varchar 255
     * @nullable
     */
    protected $password;

    /**
     * Featured image media ID
     *
     * Optional thumbnail/header image from media library.
     * SET NULL on media delete (post remains, just loses image).
     *
     * @column
     * @int
     * @unsigned
     * @nullable
     * @foreign media(id)
     * @ondelete SET NULL
     */
    protected $featured_image_id;

    /**
     * Publication datetime
     *
     * When post was/will be published. NULL for drafts.
     * Future dates trigger scheduled status with auto-publish via cron.
     *
     * @column
     * @datetime
     * @nullable
     * @index
     */
    protected $published_at;

    /**
     * Comment count (cached)
     *
     * Total approved comments on this post.
     * Updated when comments added/removed to avoid expensive COUNT queries.
     *
     * @column
     * @int
     * @unsigned
     * @default 0
     */
    protected $comment_count;

    /**
     * View count for analytics
     *
     * Total page views for this post.
     * Increment atomically: PostModel::where('id', $id)->increment(['view_count']).
     *
     * @column
     * @int
     * @unsigned
     * @default 0
     */
    protected $view_count;

    /**
     * Allow comments flag
     *
     * Enables/disables comment form on this post.
     * Can override global comment settings per-post.
     *
     * @column
     * @boolean
     * @default 1
     */
    protected $allow_comments;

    /**
     * SEO meta title
     *
     * Custom title for <title> tag and social sharing (overrides post title).
     * Recommended length: 50-60 characters for optimal SEO.
     *
     * @column
     * @varchar 255
     * @nullable
     */
    protected $meta_title;

    /**
     * SEO meta description
     *
     * Custom description for search engines and social sharing.
     * Recommended length: 150-160 characters. Falls back to excerpt if null.
     *
     * @column
     * @varchar 500
     * @nullable
     */
    protected $meta_description;

    /**
     * Creation timestamp
     *
     * When post was initially created (first saved as draft).
     * Auto-set by framework when $timestamps = true.
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * Last update timestamp
     *
     * When post was last modified (any field change).
     * Auto-updated by framework on every save().
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;

    /**
     * Soft delete timestamp
     *
     * When post was moved to trash. NULL for active posts.
     * Use WHERE deleted_at IS NULL to exclude trashed posts from queries.
     *
     * @column
     * @datetime
     * @nullable
     * @index
     */
    protected $deleted_at;

    /**
     * Content type discriminator
     *
     * Identifies content type: post, page, job, product, etc.
     * Enables plugins to add custom types without schema changes.
     *
     * @column
     * @varchar 50
     * @default post
     * @index
     */
    protected $type;

    /**
     * Parent content ID
     *
     * Self-referencing foreign key for hierarchical content (pages, categories).
     * NULL for top-level content, references parent ID for children.
     *
     * @column
     * @int
     * @unsigned
     * @nullable
     * @index
     */
    protected $parent_id;

    /**
     * Custom template identifier
     *
     * Template file name for custom page layouts (e.g., 'full-width', 'sidebar-left').
     * NULL uses default template for type. Used by pages and custom post types.
     *
     * @column
     * @varchar 100
     * @nullable
     */
    protected $template;

    /**
     * Display order
     *
     * Manual sorting order for pages in navigation menus or custom ordering.
     * Lower numbers appear first. Default 0.
     *
     * @column
     * @int
     * @default 0
     * @index
     */
    protected $menu_order;

    // ==================== META HELPER METHODS ====================

    /**
     * Get meta value(s)
     *
     * Retrieves metadata for post. If key provided, returns single value.
     * If key omitted, returns all meta as associative array.
     *
     * @param int $postId Post ID
     * @param string|null $key Meta key (NULL for all meta)
     * @return mixed Single value, array of all meta, or NULL if not found
     */
    public static function getMeta($postId, $key = null)
    {
        if ($key === null) {
            // Get all meta as associative array
            $metaRows = PostMetaModel::where('post_id', $postId)->all();

            $meta = [];
            foreach ($metaRows as $row) {
                $meta[$row['meta_key']] = $row['meta_value'];
            }

            return $meta;
        }

        // Get single meta value
        $meta = PostMetaModel::where('post_id', $postId)
            ->where('meta_key', $key)
            ->first();

        return $meta ? $meta['meta_value'] : null;
    }

    /**
     * Set/update meta value
     *
     * Creates meta if doesn't exist, updates if exists.
     * Deletes meta row if value is NULL.
     *
     * @param int $postId Post ID
     * @param string $key Meta key
     * @param mixed $value Meta value (NULL to delete)
     * @return bool Success
     */
    public static function setMeta($postId, $key, $value)
    {
        if ($value === null) {
            return self::deleteMeta($postId, $key);
        }

        $existing = PostMetaModel::where('post_id', $postId)
            ->where('meta_key', $key)
            ->first();

        if ($existing) {
            PostMetaModel::where('id', $existing['id'])
                ->save(['meta_value' => $value]);
        } else {
            PostMetaModel::save([
                'post_id' => $postId,
                'meta_key' => $key,
                'meta_value' => $value
            ]);
        }

        return true;
    }

    /**
     * Delete meta value
     *
     * Removes metadata key for post.
     * No-op if key doesn't exist.
     *
     * @param int $postId Post ID
     * @param string $key Meta key
     * @return bool Success
     */
    public static function deleteMeta($postId, $key)
    {
        return PostMetaModel::where('post_id', $postId)
            ->where('meta_key', $key)
            ->delete() > 0;
    }
}
