<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder data menara di sini
        $this->call([
            DataMenaraSeeder::class,
        ]);
    }
}
