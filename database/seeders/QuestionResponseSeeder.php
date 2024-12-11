<?php

namespace Database\Seeders;

use App\Models\QuestionResponse;
use Illuminate\Database\Seeder;

class QuestionResponseSeeder extends Seeder
{
    public function run(): void
    {
        QuestionResponse::factory()
            ->count(1000)
            ->create();
    }
}
