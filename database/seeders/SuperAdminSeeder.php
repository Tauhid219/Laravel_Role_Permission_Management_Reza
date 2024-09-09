<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user
        $user = User::create([
            'name' => 'Ahmad',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // Assign role
        $role = Role::where('name', 'super-admin')->first();
        if ($role) {
            $user->syncRoles($role);
        }
    }
}
