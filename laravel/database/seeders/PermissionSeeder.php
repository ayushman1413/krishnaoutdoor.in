<?php

namespace Database\Seeders;

use App\Enums\Permission as EnumsPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (EnumsPermission::cases() as $permission) {
            if (!Permission::where('name', $permission->value)->exists()) {
                Permission::create([
                    'name' => $permission->value,
                    'guard_name' => 'admin'
                ]);
            }
        }

        // Give new permissions to all admin roles and clear spatie cache
        $allPermissions = Permission::where('guard_name', 'admin')->get();
        $roles = Role::where('guard_name', 'admin')->get();
        foreach ($roles as $role) {
            $role->givePermissionTo($allPermissions);
        }
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}