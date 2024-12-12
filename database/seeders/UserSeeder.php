<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Зашифрованный пароль
            'role' => 'admin',
            'path' => 'images/default.png'
        ]);

        User::create([
            'name' => 'Эксперт',
            'email' => 'expert@example.com',
            'password' => Hash::make('expert123'), // Зашифрованный пароль
            'role' => 'expert',
            'path' => 'images/default.png'
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'), // Зашифрованный пароль
            'role' => 'user',
            'path' => 'images/default.png'
        ]);

        User::create([
            'name' => 'User2',
            'email' => 'user2@example.com',
            'password' => Hash::make('user123'), // Зашифрованный пароль
            'role' => 'user',
            'path' => 'images/default.png'
        ]);
    }
}
