<?php namespace Seeders;

use Models\UserModel;
use Models\RoleModel;
use Rackage\Security;

/**
 * Admin User Seeder - Pressli CMS
 *
 * Creates the first administrator account for Pressli.
 * Default credentials: admin@pressli.local / admin123
 *
 * IMPORTANT: Change the password immediately after first login!
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class AdminUserSeeder
{
    public function run()
    {
        echo "→ Creating default admin user...\n";

        // Get administrator role
        $adminRole = RoleModel::where('name', 'administrator')->first();

        if (!$adminRole) {
            echo "  ✗ Administrator role not found! Run RolesPermissions seeder first.\n";
            return;
        }

        // Check if admin already exists
        $existingAdmin = UserModel::where('username', 'admin')->first();
        if ($existingAdmin) {
            echo "  ⚠ Admin user already exists. Skipping.\n";
            return;
        }

        // Create admin user
        UserModel::save([
            'username' => 'admin',
            'email' => 'admin@pressli.local',
            'password' => Security::hash('admin123'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'role_id' => $adminRole['id'],
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        echo "  ✓ Admin user created successfully!\n";
        echo "\n";
        echo "  Login credentials:\n";
        echo "  Username: admin\n";
        echo "  Email: admin@pressli.local\n";
        echo "  Password: admin123\n";
        echo "\n";
        echo "  ⚠ IMPORTANT: Change this password after first login!\n";
    }
}
