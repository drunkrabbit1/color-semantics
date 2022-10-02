<?php

namespace Database\Seeders;

use Drabbit\ColorSemantics\Models\Color;
use Drabbit\ColorSemantics\Enums\ColorEnum;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ColorEnum::cases() as $colorEnum) {
            $values = [
                'title' => $colorEnum->name,
                'index' => $colorEnum,
            ];
            $rgbColor = $colorEnum->rgbFormat()->toArray();

            Color::query()->updateOrCreate(array_merge($values, $rgbColor));
        }
    }
}
