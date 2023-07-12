<?php

namespace GetHoppr\ModuleCommands;

use Illuminate\Support\ServiceProvider;
use GetHoppr\ModuleCommands\Conole\Commands\MakeModule;

class ModuleCommandsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModule::class,
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
