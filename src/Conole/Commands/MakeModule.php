<?php declare(strict_types=1);

namespace GetHoppr\ModuleCommands\Conole\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use GetHoppr\ModuleCommands\Traits\ActInModule;
use Symfony\Component\Console\Input\InputArgument;

class MakeModule extends Command
{
    use ActInModule;

    protected $signature = 'make:module {moduleName}';

    protected $type = 'Module';

    protected $description = 'Make a module';

    private string $moduleName;

    public function handle(): int
    {
        $this->scaffoldFolders(path: $this->getPath(''));
        $this->resolveServiceProvider();
        // $this->makeConfig();
        // $this->makeRoutes();

        return self::SUCCESS;
    }

    private function scaffoldFolders(string $path): void
    {
        $this->info("Scaffold folder structure for module...$path");
        Process::run("mkdir -p $path");

        collect(config('module-commands.structure'))
            ->each(fn($folder) => Process::run("mkdir -p $path/$folder"));
    }

    private function resolveServiceProvider(): void
    {
        $this->info('Generate service provider...');
        $this->call('module:files', [
            'moduleName' => $this->moduleName,
            'name' => $this->moduleName . 'ServiceProvider',
            'ns' => 'Providers',
            'stub' => 'module.service-provider.stub',
            'tokens' => [
                '{{config}}' => strtolower($this->moduleName),
            ]
        ]);

        $this->info('Create route service provider...');
        $routeNS = config('modules.rootNS').'\\'. $this->moduleName."\Http\Controllers";

        $this->call('module:files', [
            'moduleName' => $this->moduleName,
            'name' => 'RouteServiceProvider',
            'ns' => 'Providers',
            'stub' => 'module.route-service-provider.stub',
            'tokens' => [
                '{{module}}' => strtolower($this->moduleName),
                '{{prefix}}' => strtolower($this->moduleName),
                '{{routeNS}}' => $routeNS,
            ]
        ]);
    }

    public function makeConfig(): void
    {
        $this->info('Create config...');
        $this->call('module:files', [
            'moduleName' => $this->moduleName,
            'name' => 'config',
            'ns' => '',
            'stub' => 'module.config.stub',
            'tokens' => [
                '{{moduleName}}' => $this->moduleName,
                '{{name}}' => strtolower($this->moduleName),
            ]
        ]);
    }

    private function makeRoutes(): void
    {
        $this->info('Create web routes...');
        $this->call('module:files', [
            'moduleName' => $this->moduleName,
            'name' => 'web.route',
            'ns' => '',
            'stub' => 'module.routes.stub',
            'tokens' => [
                '{{name}}' => strtolower($this->moduleName),
                '{{moduleName}}' => $this->moduleName,
            ]
        ]);

        $this->info('Create api routes...');
        $this->call('module:files', [
            'moduleName' => $this->moduleName,
            'name' => 'api.route',
            'ns' => '',
            'stub' => 'module.routes.stub',
            'tokens' => [
                '{{name}}' => strtolower($this->moduleName),
                '{{moduleName}}' => $this->moduleName,
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



