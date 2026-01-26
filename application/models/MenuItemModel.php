<?php namespace Models;

/**
 * MenuItem Model - Pressli CMS
 *
 * Represents individual menu items within a menu container.
 * Supports nested menu structures via parent_id for sub-menus.
 *
 * Relationship: MenuItem belongsTo Menu
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\Model;

class MenuItemModel extends Model
{
    // ==================== MODEL PROPERTIES ====================

    /**
     * Database table name for this model
     *
     * Defines which database table this model maps to. Used by the
     * Query builder for all database operations on this model's records.
     *
     * @var string
     */
    protected static $table = 'menu_items';

    /**
     * Enable automatic timestamp management
     *
     * When enabled, automatically updates created_at on insert and
     * updated_at on update. Set to true if using timestamp columns.
     *
     * @var bool
     */
    protected static $timestamps = true;

    // ==================== TABLE COLUMNS ====================
    // Uncomment and modify the example columns below to match your table structure

    /**
     * Primary key identifier for the record
     * @column
     * @primary
     * @autonumber
     */
    protected $id;

    /**
     * Parent menu container ID
     *
     * References the menu this item belongs to (e.g., Primary Menu, Footer Menu).
     * CASCADE delete when menu is deleted removes all its items.
     *
     * @column
     * @int
     * @unsigned
     * @foreign menus(id)
     * @ondelete CASCADE
     * @index
     */
    protected $menu_id;

    /**
     * Parent menu item for nesting
     *
     * NULL for top-level items, references parent item ID for sub-menus.
     * No foreign key to allow flexible deletion without cascade issues.
     *
     * @column
     * @int
     * @unsigned
     * @nullable
     * @index
     */
    protected $parent_id;

    /**
     * Link text displayed to users
     *
     * Human-readable label shown in navigation.
     * Examples: "Home", "About Us", "Contact"
     *
     * @column
     * @varchar 200
     */
    protected $title;

    /**
     * Link destination URL
     *
     * Can be absolute (https://example.com) or relative (/about).
     * May reference pages, posts, categories, or external sites.
     *
     * @column
     * @varchar 500
     */
    protected $url;

    /**
     * Link target attribute
     *
     * Controls how link opens: _self (same window) or _blank (new tab).
     * NULL defaults to _self behavior.
     *
     * @column
     * @varchar 20
     * @nullable
     */
    protected $target;

    /**
     * Custom CSS classes for styling
     *
     * Space-separated class names added to menu item markup.
     * Used for theme-specific styling or JavaScript hooks.
     *
     * @column
     * @varchar 200
     * @nullable
     */
    protected $css_classes;

    /**
     * Display order within menu
     *
     * Lower numbers appear first, allows drag-and-drop reordering.
     * Default 0 for new items.
     *
     * @column
     * @int
     * @default 0
     * @index
     */
    protected $sort_order;

    /**
     * Menu item visibility status
     *
     * Controls whether item renders in front-end navigation.
     * Inactive items hidden but preserved for future use.
     *
     * @column
     * @enum active,inactive
     * @default active
     * @index
     */
    protected $status;

    /**
     * Menu item creation timestamp
     *
     * Automatically set when menu item is first created.
     * Managed by framework when $timestamps = true.
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * Menu item last modified timestamp
     *
     * Automatically updated whenever menu item is saved.
     * Managed by framework when $timestamps = true.
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;

    // ==================== MODEL METHODS ====================

    // Add your business logic methods here
}
