<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GetHoppr\ModuleCommands\Traits\ActInModule;
use App\Console\Commands\Module\GeneratesModule;
use App\Console\Commands\Module\Traits\InModule;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResolveModuleStubs extends Command implements GeneratesModule
{

    use ActInModule;

    protected $name = 'module:resolve-stubs';

    protected $description = '';

    protected $hidden = true;

    public function replaceStubTokens(): array
    {
        return [
            ...$this->argument('tokens'),
        ];
    }

    public function resolveNamespace(): string
    {
        return $this->argument('ns');
    }

    public function resolveStub(): string
    {
        return 'stubs/' . $this->argument('stub');
    }

    public function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the file'],
            ['stub', InputArgument::REQUIRED, 'stub to replace'],
            ['ns', InputArgument::OPTIONAL, 'namespace', ''],
            ['tokens', InputArgument::OPTIONAL, 'tokens', []],
        ];
    }

    public function getOptions(): array
    {
        return [
            ['module', InputOption::VALUE_REQUIRED, 'Name of the module']
        ];
    }

}
