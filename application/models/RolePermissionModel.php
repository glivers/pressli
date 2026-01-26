<?php namespace Models;

use Rackage\Model;

/**
 * Role Permission Model - Pressli CMS
 *
 * Junction table connecting roles to their assigned permissions in Pressli.
 * Enables many-to-many relationship: one role can have many permissions,
 * and one permission can belong to many roles.
 *
 * Table: role_permissions
 * Primary Key: id (auto-increment)
 * Foreign Keys: role_id → roles(id), permission_id → permissions(id)
 * Indexes: Composite unique (role_id, permission_id) prevents duplicates
 *
 * @compositeUnique (role_id, permission_id)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class RolePermissionModel extends Model
{
    protected static $table = 'role_permissions';
    protected static $timestamps = false;

    /**
     * Unique identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Role identifier
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign roles(id)
     * @ondelete CASCADE
     */
    protected $role_id;

    /**
     * Permission identifier
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign permissions(id)
     * @ondelete CASCADE
     */
    protected $permission_id;
}
