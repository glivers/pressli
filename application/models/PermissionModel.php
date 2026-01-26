<?php namespace Models;

use Rackage\Model;

/**
 * Permission Model - Pressli CMS
 *
 * Manages individual permissions that can be assigned to roles in Pressli.
 * Permissions define granular actions like edit_posts, delete_users, manage_themes.
 * Roles are granted permissions through the role_permissions junction table.
 *
 * Common Permissions:
 * - Posts: edit_posts, publish_posts, delete_posts, edit_others_posts
 * - Pages: edit_pages, publish_pages, delete_pages
 * - Media: upload_files, delete_files
 * - Users: create_users, edit_users, delete_users, manage_roles
 * - Settings: manage_settings, manage_themes, manage_plugins
 * - Comments: moderate_comments, edit_comments, delete_comments
 *
 * Table: permissions
 * Primary Key: id (auto-increment)
 * Indexes: key (unique)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class PermissionModel extends Model
{
    protected static $table = 'permissions';
    protected static $timestamps = false;

    /**
     * Unique permission identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Permission key (edit_posts, delete_users, etc)
     * @column
     * @varchar 100
     * @unique
     */
    protected $permission_key;

    /**
     * Human-readable permission description
     * @column
     * @varchar 255
     */
    protected $description;

    /**
     * Permission category for grouping (posts, users, settings, etc)
     * @column
     * @varchar 50
     * @nullable
     * @index
     */
    protected $category;
}
