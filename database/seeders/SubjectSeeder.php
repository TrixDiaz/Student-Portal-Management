<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::insert([
            [
                'id' => 1,
                'name' => 'Subject 1',
                'code' => 'SUBJ1',
                'description' => 'Subject 1 Description',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Subject 2',
                'code' => 'SUBJ2',
                'description' => 'Subject 2 Description',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Subject 3',
                'code' => 'SUBJ3',
                'description' => 'Subject 3 Description',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Subject 4',
                'code' => 'SUBJ4',
                'description' => 'Subject 4 Description',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'name' => 'Subject 5',
                'code' => 'SUBJ5',
                'description' => 'Subject 5 Description',
                'is_active' => true,
            ],
        ]);
    }
}
