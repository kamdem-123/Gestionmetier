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
        $emails = ['admin@example.com', 'admin@jobai.test'];

        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                User::create([
                    'name' => 'Admin JobAI',
                    'email' => $email,
                    'password' => Hash::make('AdminPass123!'),
                    'is_admin' => true,
                ]);
            } else {
                $user->update([
                    'name' => 'Admin JobAI',
                    'password' => Hash::make('AdminPass123!'),
                    'is_admin' => true,
                ]);
            }
        }
    }
}
