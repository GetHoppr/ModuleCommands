<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Module\GeneratesModule;
use App\Console\Commands\Module\Traits\InModule;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleInsertFiles extends Command implements GeneratesModule
{

    use InModule;

    protected $name = 'module:files';

    protected $description = 'Used when creating a new module';

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
