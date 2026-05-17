<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * This seeder contains common seeds for all domains
 */
class CommonSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
            ],
            [
                'name' => 'employee',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('11223344'),
        ]);

        $user->assignRole('super_admin');
    }
}
