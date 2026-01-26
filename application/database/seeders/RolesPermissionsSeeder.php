<?php namespace Seeders;

use Models\RoleModel;
use Models\PermissionModel;
use Models\RolePermissionModel;

/**
 * Roles and Permissions Seeder - Pressli CMS
 *
 * Seeds the database with default roles and permissions for Pressli.
 * Creates a hierarchical role system with granular permission control.
 *
 * Roles (in order of privilege):
 * 1. Administrator - Full system access
 * 2. Editor - Manage all content
 * 3. Author - Manage own content
 * 4. Subscriber - Read-only access
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class RolesPermissionsSeeder
{
    public function run()
    {
        echo "→ Seeding Pressli roles and permissions...\n";

        // Create roles
        $roles = $this->seedRoles();
        echo "  ✓ Created " . count($roles) . " roles\n";

        // Create permissions
        $permissions = $this->seedPermissions();
        echo "  ✓ Created " . count($permissions) . " permissions\n";

        // Assign permissions to roles
        $this->assignPermissions($roles, $permissions);
        echo "  ✓ Assigned permissions to roles\n";

        echo "✓ Pressli roles and permissions seeded successfully!\n";
    }

    /**
     * Seed default roles
     */
    private function seedRoles()
    {
        $roles = [
            ['name' => 'administrator', 'description' => 'Full system access - can manage everything'],
            ['name' => 'editor', 'description' => 'Can publish and manage all posts and pages'],
            ['name' => 'author', 'description' => 'Can write and publish own posts'],
            ['name' => 'subscriber', 'description' => 'Read-only access to content'],
        ];

        $roleIds = [];
        foreach ($roles as $role) {
            $id = RoleModel::save($role);
            $roleIds[$role['name']] = $id;
        }

        return $roleIds;
    }

    /**
     * Seed all permissions grouped by category
     */
    private function seedPermissions()
    {
        $permissions = [
            // Posts
            ['permission_key' => 'edit_posts', 'description' => 'Edit posts', 'category' => 'posts'],
            ['permission_key' => 'edit_others_posts', 'description' => 'Edit posts created by other users', 'category' => 'posts'],
            ['permission_key' => 'publish_posts', 'description' => 'Publish posts', 'category' => 'posts'],
            ['permission_key' => 'delete_posts', 'description' => 'Delete posts', 'category' => 'posts'],
            ['permission_key' => 'delete_others_posts', 'description' => 'Delete posts created by other users', 'category' => 'posts'],

            // Pages
            ['permission_key' => 'edit_pages', 'description' => 'Edit pages', 'category' => 'pages'],
            ['permission_key' => 'edit_others_pages', 'description' => 'Edit pages created by other users', 'category' => 'pages'],
            ['permission_key' => 'publish_pages', 'description' => 'Publish pages', 'category' => 'pages'],
            ['permission_key' => 'delete_pages', 'description' => 'Delete pages', 'category' => 'pages'],
            ['permission_key' => 'delete_others_pages', 'description' => 'Delete pages created by other users', 'category' => 'pages'],

            // Media
            ['permission_key' => 'upload_files', 'description' => 'Upload media files', 'category' => 'media'],
            ['permission_key' => 'delete_files', 'description' => 'Delete media files', 'category' => 'media'],
            ['permission_key' => 'delete_others_files', 'description' => 'Delete media files uploaded by other users', 'category' => 'media'],

            // Comments
            ['permission_key' => 'moderate_comments', 'description' => 'Moderate and approve comments', 'category' => 'comments'],
            ['permission_key' => 'edit_comments', 'description' => 'Edit comments', 'category' => 'comments'],
            ['permission_key' => 'delete_comments', 'description' => 'Delete comments', 'category' => 'comments'],

            // Users
            ['permission_key' => 'create_users', 'description' => 'Create new users', 'category' => 'users'],
            ['permission_key' => 'edit_users', 'description' => 'Edit user accounts', 'category' => 'users'],
            ['permission_key' => 'delete_users', 'description' => 'Delete user accounts', 'category' => 'users'],
            ['permission_key' => 'manage_roles', 'description' => 'Manage user roles and permissions', 'category' => 'users'],

            // Taxonomies
            ['permission_key' => 'manage_categories', 'description' => 'Create, edit, and delete categories', 'category' => 'taxonomies'],
            ['permission_key' => 'manage_tags', 'description' => 'Create, edit, and delete tags', 'category' => 'taxonomies'],

            // Settings
            ['permission_key' => 'manage_settings', 'description' => 'Manage site settings', 'category' => 'settings'],
            ['permission_key' => 'manage_themes', 'description' => 'Install and activate themes', 'category' => 'settings'],
            ['permission_key' => 'manage_plugins', 'description' => 'Install and activate plugins', 'category' => 'settings'],
            ['permission_key' => 'manage_menus', 'description' => 'Create and edit navigation menus', 'category' => 'settings'],
        ];

        $permissionIds = [];
        foreach ($permissions as $permission) {
            $id = PermissionModel::save($permission);
            $permissionIds[$permission['permission_key']] = $id;
        }

        return $permissionIds;
    }

    /**
     * Assign permissions to roles
     */
    private function assignPermissions($roles, $permissions)
    {
        // Administrator - ALL permissions
        foreach ($permissions as $permissionId) {
            RolePermissionModel::save([
                'role_id' => $roles['administrator'],
                'permission_id' => $permissionId
            ]);
        }

        // Editor - All content management, no user/settings management
        $editorPermissions = [
            'edit_posts', 'edit_others_posts', 'publish_posts', 'delete_posts', 'delete_others_posts',
            'edit_pages', 'edit_others_pages', 'publish_pages', 'delete_pages', 'delete_others_pages',
            'upload_files', 'delete_files', 'delete_others_files',
            'moderate_comments', 'edit_comments', 'delete_comments',
            'manage_categories', 'manage_tags',
        ];
        foreach ($editorPermissions as $key) {
            RolePermissionModel::save([
                'role_id' => $roles['editor'],
                'permission_id' => $permissions[$key]
            ]);
        }

        // Author - Own content only
        $authorPermissions = [
            'edit_posts', 'publish_posts', 'delete_posts',
            'upload_files',
        ];
        foreach ($authorPermissions as $key) {
            RolePermissionModel::save([
                'role_id' => $roles['author'],
                'permission_id' => $permissions[$key]
            ]);
        }

        // Subscriber - No permissions (read-only access handled in controllers)
    }
}
