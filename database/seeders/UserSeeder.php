<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
           $user = User::updateOrCreate(
            ['phone' => '1234567890'], // Ensure uniqueness
            [
                'name' => 'Admin User',
                'email' => 'admin@mls.co.ls',
                'password' => Hash::make('admin'), // Replace with a secure password
                'is_active' => true,
                'is_phone_verified' => true,
                'remember_token' => Str::random(10),
            ]
        );
        $user->assignRole('super_admin'); // 👈 This is the key line!
    }
}
