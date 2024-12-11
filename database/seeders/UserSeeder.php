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
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole(['admin', 'teacher', 'dean', 'student']);

        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Teacher $i",
                'email' => "teacher$i@example.com",
                'password' => Hash::make('password'),
            ])->assignRole('teacher');
        }

        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Dean $i",
                'email' => "dean$i@example.com",
                'password' => Hash::make('password'),
            ])->assignRole('dean');
        }

        for ($i = 1; $i <= 1000; $i++) {
            User::create([
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'password' => Hash::make('password'),
            ])->assignRole('student');
        }
    }
}
