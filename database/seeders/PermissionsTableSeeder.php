<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $modules = ['dashboard', 'profile', 'user', 'role', 'permission', 'notification'];

        $data = [];
        foreach ($modules as $module) {
            $data = array_merge($data, $this->generatePermissions($module));
        }

        Permission::insert($data);
    }

    public function generatePermissions($module)
        {
            $data = [];
            $now = date('Y-m-d H:i:s');

            if ($module === 'profile') {
                $data[] = [
                    'name'       => $module . '_access',
                    'title'      => ucfirst($module) . ' Access',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                
                $data[] = [
                    'name'       => $module . '_edit',
                    'title'      => ucfirst($module) . ' Edit',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            } else if($module === 'dashboard'){
                $data[] = [
                    'name'       => $module . '_access',
                    'title'      => ucfirst($module) . ' Access',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }else{
                $permissions = [
                    'access' => 'Access',
                    'create' => 'Add',
                    'edit'   => 'Edit',
                    'show'   => 'Show',
                    'delete' => 'Delete',
                ];

                foreach ($permissions as $key => $title) {
                    $data[] = [
                        'name'       => $module . '_' . $key,
                        'title'      => ucfirst($module) . ' ' . ucfirst($key),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            return $data;
        }
}
