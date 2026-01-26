<?php namespace Models;

use Rackage\Model;

/**
 * Role Model - Pressli CMS
 *
 * Manages user roles and their hierarchical permissions within Pressli.
 * Roles define what actions users can perform (admin, editor, author, subscriber).
 * Each role can have multiple permissions assigned through the role_permissions table.
 *
 * Default Roles:
 * - Administrator: Full system access
 * - Editor: Can publish and manage all posts
 * - Author: Can write and publish own posts
 * - Subscriber: Read-only access
 *
 * Table: roles
 * Primary Key: id (auto-increment)
 * Indexes: name (unique)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class RoleModel extends Model
{
    protected static $table = 'roles';
    protected static $timestamps = false;

    /**
     * Unique role identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Role name (administrator, editor, author, subscriber)
     * @column
     * @varchar 50
     * @unique
     */
    protected $name;

    /**
     * Human-readable role description
     * @column
     * @varchar 255
     * @nullable
     */
    protected $description;
}
