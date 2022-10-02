<?php

namespace Database\Seeders;

use Drabbit\ColorSemantics\Models\Algorithm\Algorithm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AlgorithmSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(ConceptSeeder::class);
    }
}
