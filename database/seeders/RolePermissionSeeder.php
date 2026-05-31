<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'users.manage',
            'crops.view',
            'crops.create',
            'crops.update',
            'crops.delete',
            'crops.approve',
            'orders.view',
            'orders.manage',
            'reports.manage',
            'settings.manage',
            'weather.view',
            'disease_reports.create',
            'disease_reports.view',
            'questions.create',
            'questions.answer',
            'reviews.create',
            'favorites.manage',
            'cart.manage',
            'checkout.process',
            'api.access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $roles = [
            'Admin' => $permissions,
            'Farmer' => [
                'dashboard.view',
                'crops.view',
                'crops.create',
                'crops.update',
                'crops.delete',
                'orders.view',
                'weather.view',
                'disease_reports.create',
                'disease_reports.view',
                'questions.create',
                'api.access',
            ],
            'Buyer' => [
                'dashboard.view',
                'crops.view',
                'orders.view',
                'reviews.create',
                'favorites.manage',
                'cart.manage',
                'checkout.process',
                'api.access',
            ],
            'Expert' => [
                'dashboard.view',
                'crops.view',
                'disease_reports.view',
                'questions.answer',
                'api.access',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePermissions);
        }
    }
}
