<?php

declare(strict_types=1);

namespace GetHoppr\ModuleCommands\Traits;

use Illuminate\Support\Str;

trait ActInModule
{

    public function resolveModuleName(): string
    {
        return $this->option('module');
    }

    protected function getModuleName(): string
    {
        return Str::studly($this->resolveModuleName());
    }

    protected function getPath($name)
    {
        $moduleRootPath = base_path(config('module-commands.path.root').'/'.$this->getModuleName());
        if ($name !== '') {
            $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name)).'.php';

            return $moduleRootPath.'/'.$name;
        }

        return $moduleRootPath;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\'.$this->resolveNamespace();
    }

    protected function rootNamespace()
    {
        $root = config('module-commands.namespace');

        return "$root\\".$this->getModuleName();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/'.$this->resolveStub());
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $stub = $this->replaceTokens($stub, $this->replaceStubTokens());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function replaceTokens(string $stub, array $tokens)
    {
        foreach ($tokens as $find => $replace) {
            $stub = str_replace($find, $replace, $stub);
        }

        return $stub;
    }

    public function resolveArguments(): array
    {
        return [];
    }

    public function resolveOptions(): array
    {
        return [];
    }

    protected function getArguments()
    {
        return [
            ...$this->resolveArguments(),
        ];
    }

    protected function getOptions()
    {
        return [
            ...$this->resolveOptions(),
        ];
    }
}
