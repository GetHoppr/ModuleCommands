<?php

namespace GetHoppr\ModuleCommands;

use Illuminate\Support\ServiceProvider;
use GetHoppr\ModuleCommands\Console\Commands\MakeModule;
use GetHoppr\ModuleCommands\Console\Commands\ResolveModuleStubs;

class ModuleCommandsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModule::class,
                ResolveModuleStubs::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/module-commands.php' => config_path('module-commands.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module-commands.php', 'module-commands');
    }
}