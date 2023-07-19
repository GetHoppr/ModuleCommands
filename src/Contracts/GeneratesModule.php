<?php declare(strict_types=1);

namespace GetHoppr\ModuleCommands\Contracts;

interface GeneratesModule
{
    public function resolveModuleName(): string;

    public function resolveNamespace(): string;

    public function resolveArguments(): array;

    public function resolveOptions(): array;

    public function resolveStub(): string;

    public function replaceStubTokens(): array;
}
