<?php

namespace GetHoppr\ModuleCommands;

use GetHoppr\ModuleCommands\Console\Commands\MakeModule;
use GetHoppr\ModuleCommands\Console\Commands\ResolveModuleStubs;
use Illuminate\Support\ServiceProvider;

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
            __DIR__.'/../stubs/module.service-provider.stub' => base_path('stubs'),
        ], 'module-command');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module-commands.php', 'module-commands');
    }
}
