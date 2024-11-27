<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Super Admin',
                'email'             => 'superadmin@gmail.com',
                'role_id'           => Role::where('name', 'Super Admin')->first()->id,
            ],
            [
                'name'              => 'Admin',
                'email'             => 'admin@gmail.com',
                'role_id'           => Role::where('name', 'Admin')->first()->id,
            ],
            [
                'name'              => "User",
                'email'             => 'user@gmail.com',
                'role_id'           => Role::where('name', 'User')->first()->id,
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
