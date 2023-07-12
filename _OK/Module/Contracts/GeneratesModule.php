<?php declare(strict_types=1);

namespace App\Console\Commands\Module;

interface GeneratesModule {
    public function resolveNamespace(): string;
    public function resolveArguments(): array;
    public function resolveOptions(): array;
    public function resolveStub(): string;
    public function replaceStubTokens(): array;
}
