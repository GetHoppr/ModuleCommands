<?php

namespace GetHoppr\ModuleCommands\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use GetHoppr\ModuleCommands\Traits\ActInModule;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use GetHoppr\ModuleCommands\Contracts\GeneratesModule;

class ResolveModuleStubs extends GeneratorCommand implements GeneratesModule
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
        return  $this->argument('stub');
    }

    public function resolveArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the file'],
            ['stub', InputArgument::REQUIRED, 'stub to replace'],
            ['ns', InputArgument::OPTIONAL, 'namespace', ''],
            ['tokens', InputArgument::OPTIONAL, 'tokens', []],
        ];
    }

    public function resolveOptions(): array
    {
        return [
            ['module',  '', InputOption::VALUE_REQUIRED, 'Name of the module'],
        ];
    }
}
