<?php

namespace PressbooksPluginScaffold\Database;

use FilesystemIterator;
use Illuminate\Support\Collection;
use PressbooksPluginScaffold\Interfaces\MigrationInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Migration
{
    public static function migrate(): bool
    {
        (new static)
            ->getMigrationFiles()
            ->sortKeys()
            ->each(fn (MigrationInterface $class) => $class->up());

        return true;
    }

    private function getMigrationFiles(): Collection
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                directory: __DIR__ . '/Migrations',
                flags: FilesystemIterator::SKIP_DOTS
            )
        );

        return Collection::make($iterator)
            ->filter(fn (SplFileInfo $record) => $record->isFile())
            ->map(fn (SplFileInfo $record) => require $record->getPathname());
    }
}
