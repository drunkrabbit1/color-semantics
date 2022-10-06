<?php

namespace Drabbit\ColorSemantics\Console;

use Database\Seeders\AlgorithmSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ConceptSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

/**
 * Комманда создает Сиды в новом проекте, с базовыми данными, для работы с проектом
 *
 */
class SeedPackageCommand extends Command
{
    protected $signature = 'color-semantics:seed';

    public static array $calls = [
        AlgorithmSeeder::class,
        ColorSeeder::class,
        ConceptSeeder::class
    ];

    public static $group = 'cs-upload-seeds';

    public function handle()
    {
        // публикуем сиды
        Artisan::call('vendor:publish --tag=' . self::$group);

        Collection::make([
            // ..
        ])->each(fn($table) => \DB::table($table)->truncate());

        Collection::make(self::$calls)->each(function ($class) { // Запускаем сиды
            $basename = class_basename($class);
            $this->info("seeding $basename");
            Artisan::call('db:seed --class=' . $basename);
            $this->alert("success full $basename");
        });
    }
}
