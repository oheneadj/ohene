<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create exactly 3 featured videos
        \App\Models\Video::factory()->count(3)->create([
            'is_featured' => true,
        ]);

        // Create some regular, non-featured videos
        \App\Models\Video::factory()->count(7)->create([
            'is_featured' => false,
        ]);
    }
}
