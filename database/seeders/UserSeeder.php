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
    // public function run(): void
    // {

    //     User::create([
    //         'name' => 'Admin',
    //         'email' => 'admin@example.com',
    //         'password' => Hash::make('password'),
    //     ])->assignRole('admin');


    //     for ($i = 1; $i <= 10; $i++) {
    //         User::create([
    //             'name' => "Teacher $i",
    //             'email' => "teacher$i@example.com",
    //             'password' => Hash::make('password'),
    //         ])->assignRole('teacher');
    //     }


    //     for ($i = 1; $i <= 10; $i++) {
    //         User::create([
    //             'name' => "Dean $i",
    //             'email' => "dean$i@example.com",
    //             'password' => Hash::make('password'),
    //         ])->assignRole('dean');
    //     }


    //     for ($i = 1; $i <= 10; $i++) {
    //         User::create([
    //             'name' => "Student $i",
    //             'email' => "student$i@example.com",
    //             'password' => Hash::make('password'),
    //         ])->assignRole('student');
    //     }
    // }

    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole(['admin', 'teacher', 'dean', 'student']);

        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('teacher');

        User::create([
            'name' => 'Dean',
            'email' => 'dean@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('dean');

        User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('student');

        User::create([
            'name' => 'Student 2',
            'email' => 'student2@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('student');

        User::create([
            'name' => 'Student 3',
            'email' => 'student3@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('student');

        User::create([
            'name' => 'Student 4',
            'email' => 'student4@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('student');

        User::create([
            'name' => 'Student 5',
            'email' => 'student5@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('student');
    }
}
