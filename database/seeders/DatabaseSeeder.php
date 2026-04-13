<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Inventaris',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password_text' => 'admin123',
            ],
            [
                'name' => 'Operator Inventaris',
                'email' => 'operator@gmail.com',
                'role' => 'operator',
                'password_text' => 'operator123',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'role' => $data['role'],
                    'password' => Hash::make($data['password_text']),
                ]
            );

            $user->update([
                'name' => $data['name'],
                'role' => $data['role'],
                'password' => Hash::make($data['password_text']),
                'password_text' => $data['password_text'],
            ]);
        }
    }
}
