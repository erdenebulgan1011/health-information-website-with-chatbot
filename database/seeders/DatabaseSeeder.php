<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            // VRContentSeeder::class,
            UserSeeder::class,
            EventSeeder::class,
            UserProfileSeeder::class,
            TopicSeeder::class,
            ReplySeeder::class,
            LikeSeeder::class,

        ]);

    }
}
