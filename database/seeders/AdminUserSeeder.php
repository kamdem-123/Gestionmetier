<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('AdminPass123!'),
                'is_admin' => true,
            ]);
        } else {
            // Ensure admin flag and name are set but do NOT change the existing password
            $user->update([
                'name' => 'Admin',
                'is_admin' => true,
            ]);
        }
    }
}
