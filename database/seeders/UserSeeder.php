<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $adminRole      = Role::where('name', 'Admin')->first();

        $superAdmin = User::create([
            'name'     => 'Shiro Oni',
            'email'    => 'test1@example.com',
            'password' => Hash::make('password123'),
            'status'   => 'active',
        ]);
        $superAdmin->roles()->attach($superAdminRole);

        $admin = User::create([
            'name'     => 'Legend',
            'email'    => 'test2@example.com',
            'password' => Hash::make('password123'),
            'status'   => 'active',
        ]);
        $admin->roles()->attach($adminRole);
    }
}
