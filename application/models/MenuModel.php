<?php namespace Models;

/**
 * Menu Model - Pressli CMS
 *
 * Represents menu containers (Primary Menu, Footer Menu, etc.).
 * Each menu can have multiple menu items (MenuItemModel).
 *
 * Relationship: Menu hasMany MenuItems
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\Model;

class MenuModel extends Model
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
    protected static $table = 'menus';

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
     * Menu name displayed in admin
     *
     * Human-readable name shown in menu management interface.
     * Examples: "Primary Menu", "Footer Menu", "Social Links"
     *
     * @column
     * @varchar 100
     * @unique
     */
    protected $name;

    /**
     * URL-friendly identifier for menu
     *
     * Used for programmatic access and theme template queries.
     * Auto-generated from name, lowercase with hyphens.
     *
     * @column
     * @varchar 100
     * @unique
     * @index
     */
    protected $slug;

    /**
     * Theme location where menu renders
     *
     * Theme-defined location identifier (e.g., "primary", "footer", "sidebar").
     * NULL if menu not assigned to any location yet.
     *
     * @column
     * @varchar 50
     * @nullable
     */
    protected $location;

    /**
     * Menu visibility status
     *
     * Controls whether menu is available for display on site.
     * Only active menus render in theme templates.
     *
     * @column
     * @enum active,inactive
     * @default active
     * @index
     */
    protected $status;

    /**
     * Menu creation timestamp
     *
     * Automatically set when menu is first created.
     * Managed by framework when $timestamps = true.
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * Menu last modified timestamp
     *
     * Automatically updated whenever menu is saved.
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
