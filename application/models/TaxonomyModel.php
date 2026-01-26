<?php namespace Models;

use Rackage\Model;

/**
 * Taxonomy Model - Pressli CMS
 *
 * Unified taxonomy system managing both categories and tags in a single table.
 * Categories support hierarchical structure (parent-child relationships),
 * while tags remain flat. Both types connect to posts via post_taxonomies junction table.
 *
 * TAXONOMY TYPES:
 * - category: Hierarchical classification (can have parent/children)
 * - tag: Flat keyword system (no hierarchy, all equal level)
 *
 * RELATIONSHIPS:
 * - Posts: Many-to-many via post_taxonomies junction table
 * - Parent Category: Self-referential (CASCADE delete removes children)
 *
 * Table: taxonomies
 * Primary Key: id (auto-increment)
 * Foreign Keys: parent_id → taxonomies(id)
 *
 * @compositeUnique (slug, type, deleted_at)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class TaxonomyModel extends Model
{
    protected static $table = 'taxonomies';
    protected static $timestamps = true;

    /**
     * Unique taxonomy identifier
     *
     * Auto-incremented primary key.
     * Referenced by post_taxonomies junction table.
     *
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Taxonomy name (display title)
     *
     * Human-readable label shown in admin and frontend.
     * Can contain spaces, capitals, special characters.
     *
     * @column
     * @varchar 200
     */
    protected $name;

    /**
     * URL-friendly slug identifier
     *
     * Auto-generated from name if not provided. Unique per type.
     * Used in URLs: /category/{slug} or /tag/{slug}.
     *
     * @column
     * @varchar 200
     * @index
     */
    protected $slug;

    /**
     * Taxonomy type discriminator
     *
     * category: Hierarchical classification (can have parent/children).
     * tag: Flat keyword system (no hierarchy).
     *
     * @column
     * @enum category,tag
     * @index
     */
    protected $type;

    /**
     * Optional taxonomy description
     *
     * Extended information about category/tag purpose.
     * Displayed on archive pages and admin listings.
     *
     * @column
     * @text
     * @nullable
     */
    protected $description;

    /**
     * Parent category ID (hierarchical categories only)
     *
     * Self-referential foreign key for parent-child relationships.
     * NULL for top-level categories and all tags.
     *
     * @column
     * @int
     * @unsigned
     * @nullable
     * @index
     * @foreign taxonomies(id)
     * @ondelete CASCADE
     */
    protected $parent_id;

    /**
     * Display sort order priority
     *
     * Controls sequence in dropdowns, menus, listings.
     * Lower numbers appear first (0, 10, 20, 30...).
     *
     * @column
     * @int
     * @default 0
     */
    protected $sort_order;

    /**
     * Post count (cached)
     *
     * Total published posts using this category/tag.
     * Updated when post_taxonomies records added/removed.
     *
     * @column
     * @int
     * @unsigned
     * @default 0
     */
    protected $post_count;

    /**
     * Creation timestamp
     *
     * When taxonomy was initially created.
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
     * When taxonomy was last modified (any field change).
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
     * When taxonomy was moved to trash. NULL for active taxonomies.
     * Part of composite unique index (allows trashed slugs to be reused).
     *
     * @column
     * @datetime
     * @nullable
     * @index
     */
    protected $deleted_at;
}
