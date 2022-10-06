<?php

namespace Drabbit\ColorSemantics;

use Database\Seeders\AlgorithmSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ConceptSeeder;
use Drabbit\ColorSemantics\Console\SeedPackageCommand;
use Drabbit\ColorSemantics\Providers\CommandsServiceProvider;
use Drabbit\ColorSemantics\Providers\EventServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ColorSemanticsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'color-semantics');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'color-semantics');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('color-semantics.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/color-semantics'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/color-semantics'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/color-semantics'),
            ], 'lang');*/
//            dd(Collection::make([
//                AlgorithmSeeder::class,
//                ColorSeeder::class,
//                ConceptSeeder::class
//            ])->map(function ($class) {
//                $basename = class_basename($class);
//                return [
//                    __DIR__ . "\..\database\seeders\\$basename.php" => database_path("seeders\\$basename.php"),
//                ];
//            })->collapse()->toArray());
            $this->publishes(Collection::make(SeedPackageCommand::$calls)->map(function ($class) {
                    $basename = class_basename($class);
                    return [
                        __DIR__ . "/../database/seeders/$basename.php" => database_path("seeders/$basename.php"),
                    ];
                })->collapse()->toArray(),
            SeedPackageCommand::$group);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandsServiceProvider::class);
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'color-semantics');

        // Register the main class to use with the facade
//        $this->app->singleton('color-semantics', function () {
//            return new ColorSemantics;
//        });
    }
}
