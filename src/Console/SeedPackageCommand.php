<?php

namespace Drabbit\ColorSemantics\Console;

use Database\Seeders\AlgorithmSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ConceptSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedPackageCommand extends Command
{
    protected $signature = 'color-semantics:seed';

    public static array $calls = [
        AlgorithmSeeder::class,
        ColorSeeder::class,
        ConceptSeeder::class
    ];

    public static $group = 'cs-seeds';

    public function handle()
    {
        Artisan::call('vendor:publish --tag=' . self::$group);

        collect([
            // ..
        ])->each(fn($table) => \DB::table($table)->truncate());

        collect(self::$calls)->each(function ($class) {
            $basename = class_basename($class);
            $this->info("seeding $basename");
            Artisan::call('db:seed --class=' . $basename);
            $this->alert("success full $basename");
        });
    }
}
