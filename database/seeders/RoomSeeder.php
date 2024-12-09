<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::insert([
            [
                'name' => 'Room 1',
                'building_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Room 2',
                'building_id' => 1,
                'is_active' => true,
            ],
            // Add more rooms as needed
        ]);
    }
}
