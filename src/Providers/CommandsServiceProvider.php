<?php

namespace Drabbit\ColorSemantics\Providers;

use Drabbit\ColorSemantics\Console\SeedPackageCommand;
use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedPackageCommand::class,
            ]);
        }
    }
}
