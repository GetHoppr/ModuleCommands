<?php declare(strict_types=1);

namespace App\Console\Commands\Module\Traits;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

trait InModule
{

    protected function getPath($name)
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name)).'.php';

        return base_path( config('modules.path.root') .'/'. $this->argument('moduleName') . $name);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\' .$this->resolveNamespace();
    }

    protected function rootNamespace()
    {
        $root = config('modules.namespace');

        return "$root\\" . $this->argument('moduleName');
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/' . $this->resolveStub());
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
        foreach($tokens as $find => $replace) {
            $stub = str_replace($find, $replace, $stub);
        }

        return $stub;
    }

    public function resolveArguments(): array
    {
        return [];
    }

    protected function getArguments()
    {
        return [
            ...$this->resolveArguments()
        ];
    }

    protected function getOptions()
    {
        return []
    }

}
