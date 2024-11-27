<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionsRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $superAdminPermissions = Permission::pluck('id')->toArray();
        
        $adminPermissions = Permission::whereIn('name', [
            'profile_access', 
            'profile_edit', 
            'user_access', 
            'user_create', 
            'user_edit', 
            'user_delete'
        ])->pluck('id')->toArray();

        $userPermissions = Permission::whereIn('name', [
            'profile_access', 
            'profile_edit'
        ])->pluck('id')->toArray();

        foreach ($roles as $role) {
            switch ($role->id) {
                case 1:
                    $role->permissions()->sync($superAdminPermissions);
                    break;
                case 2:
                    $role->permissions()->sync($adminPermissions);
                    break;
                case 3:
                    $role->permissions()->sync($userPermissions);
                    break;
                default:
                    break;
            }
        }
    }

}
