<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view_user_management']);
        Permission::create(['name' => 'update_user_management']);
        Permission::create(['name' => 'delete_user_management']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'User']);
        $role1->givePermissionTo([
            'view_user_management'
        ]);
        
        $role2 = Role::create(['name' => 'Admin']);
        $role2->givePermissionTo([
            'view_user_management',
            'update_user_management',
            'delete_user_management'
        ]);

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'User BIASA',
            'email' => 'tester@example.com',
            'password' => bcrypt('userbiasa1234'),
            'is_active' => true,
        ]);
        $user->assignRole($role1);
        
        $user = \App\Models\User::factory()->create([
            'name' => 'User ADMIN',
            'email' => 'admin@example.com',
            'password' => bcrypt('useradmin1234'),
            'is_active' => true,
        ]);
        $user->assignRole($role2);
    }
}