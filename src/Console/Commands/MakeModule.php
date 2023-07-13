<?php

declare(strict_types=1);

namespace GetHoppr\ModuleCommands\Console\Commands;

use GetHoppr\ModuleCommands\Traits\ActInModule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Console\Input\InputArgument;

class MakeModule extends Command
{
    use ActInModule;

    protected $name = 'make:module';

    protected $type = 'Module';

    protected $description = 'Make a module';

    public function handle(): int
    {
        $this->scaffoldFolders(path: $this->getPath(''));
        $this->resolveServiceProvider();
        $this->makeConfig();
        $this->makeRoutes();

        return self::SUCCESS;
    }

    private function scaffoldFolders(string $path): void
    {
        $this->info("Scaffold folder structure for module...$path");
        Process::run("mkdir -p $path");

        collect(config('module-commands.structure'))
            ->each(fn ($folder) => Process::run("mkdir -p $path/$folder"));
    }

    private function resolveServiceProvider(): void
    {
        $this->info('Generate service provider...');

        $this->call('module:resolve-stubs', [
            '--module' => $this->getModuleName(),
            'name' => $this->getModuleName().'ServiceProvider',
            'ns' => 'Providers',
            'stub' => '../../stubs/module.service-provider.stub',
            'tokens' => [
                '{{config}}' => strtolower($this->getModuleName()),
            ],
        ]);

        $this->info('Create route service provider...');
        $routeNS = config('modules.rootNS').'\\'.$this->getModuleName()."\Http\Controllers";

        $this->call('module:resolve-stubs', [
            '--module' => $this->getModuleName(),
            'name' => 'RouteServiceProvider',
            'ns' => 'Providers',
            'stub' => '../../stubs/module.route-service-provider.stub',
            'tokens' => [
                '{{module}}' => strtolower($this->getModuleName()),
                '{{prefix}}' => strtolower($this->getModuleName()),
                '{{routeNS}}' => $routeNS,
            ],
        ]);
    }

    public function resolveModuleName(): string
    {
        return $this->argument('moduleName');
    }

    public function makeConfig(): void
    {
        $this->info('Create config...');
        $this->call('module:resolve-stubs', [
            '--module' => $this->getModuleName(),
            'name' => 'config',
            'ns' => '',
            'stub' => '../../stubs/module.config.stub',
            'tokens' => [
                '{{moduleName}}' => $this->getModuleName(),
                '{{name}}' => strtolower($this->getModuleName()),
            ]
        ]);
    }

    private function makeRoutes(): void
    {
        $this->info('Create web routes...');
        $this->call('module:resolve-stubs', [
            '--module' => $this->getModuleName(),
            'name' => 'web.route',
            'ns' => '',
            'stub' => '../../stubs/module.routes.stub',
            'tokens' => [
                '{{name}}' => strtolower($this->getModuleName()),
                '{{moduleName}}' => $this->getModuleName(),
            ]
        ]);

        $this->info('Create api routes...');
        $this->call('module:resolve-stubs', [
            '--module' => $this->getModuleName(),
            'name' => 'api.route',
            'ns' => '',
            'stub' => '../../stubs/module.routes.stub',
            'tokens' => [
                '{{name}}' => strtolower($this->getModuleName()),
                '{{moduleName}}' => $this->getModuleName(),
            ]
        ]);
    }

    protected function resolveArguments(): array
    {
        return [
            ['moduleName', InputArgument::REQUIRED, 'The name of the module'],
        ];
    }
}
