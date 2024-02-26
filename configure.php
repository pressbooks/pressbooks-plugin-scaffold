#!/usr/bin/env php
<?php

function ask(string $question, string $default = ''): string
{
    $answer = readline($question . ($default ? " ({$default})" : null) . ': ');

    if (! $answer) {
        return $default;
    }

    return $answer;
}

function confirm(string $question, bool $default = false): bool
{
    $answer = ask($question .' (' . ($default ? 'Y/n' : 'y/N') . ')');

    if (! $answer) {
        return $default;
    }

    return strtolower($answer) === 'y';
}

function writeln(string $line): void
{
    echo $line.PHP_EOL;
}

function slugify(string $subject): string
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subject), '-'));
}

function titleCase(string $subject): string
{
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $subject)));
}

function replaceInFile(string $file, array $replacements): void
{
    $contents = file_get_contents($file);

    file_put_contents($file, str_replace(
        array_keys($replacements),
        array_values($replacements),
        $contents
    ));
}

function separator(string $path): string
{
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function run(string $command): string
{
    return trim((string) shell_exec($command));
}

function getReplaceableFiles(): array
{
    $namedFiles = explode(PHP_EOL, run('find ./* -name "pressbooks-plugin-scaffold*"'));

    $contentFiles = explode(PHP_EOL, run('grep -E -r -l -i "PressbooksPluginScaffold|pressbooks-plugin-scaffold|Pressbooks Plugin Scaffold" --exclude-dir=vendor ./* ./.github/* | grep -v '.basename(__FILE__)));

    return array_unique(
        array_merge($namedFiles, $contentFiles)
    );
}

// --------------- SCRIPT START --------------- //
$currentDirectory = getcwd();

$pluginName = ask('Plugin name', basename($currentDirectory));

$kebabCaseName = slugify($pluginName);
$titleCaseName = ask('Namespace name', titleCase($pluginName));
$description = ask('Plugin description', "This is my plugin {$kebabCaseName}");

writeln('------');
writeln("Name           : {$pluginName}");
writeln("Plugin         : {$kebabCaseName} <{$description}>");
writeln("Namespace      : Pressbooks\\{$titleCaseName}");
writeln("Class name     : {$titleCaseName}");
writeln("Root file name : {$kebabCaseName}");
writeln('------');

writeln('This script will replace the above values in all relevant files in the project directory.');

if (! confirm('Modify files?', true)) {
    exit(1);
}

$files = getReplaceableFiles();

foreach ($files as $file) {
    replaceInFile($file, [
        'pressbooks-plugin-scaffold' => $kebabCaseName,
        'PressbooksPluginScaffold' => $titleCaseName,
        'Pressbooks Plugin Scaffold' => $pluginName,
        'A scaffold for Pressbooks plugins.' => $description,
    ]);

    match (true) {
        str_contains($file, separator('resources/assets/js/pressbooks-plugin-scaffold.js')) => rename($file, separator('./resources/assets/js/' . $kebabCaseName . '.js')),
        str_contains($file, separator('resources/assets/css/pressbooks-plugin-scaffold.css')) => rename($file, separator('./resources/assets/css/' . $kebabCaseName . '.css')),
        str_contains($file, separator('pressbooks-plugin-scaffold.php')) => rename($file, separator('./' . $kebabCaseName . '.php')),
        default => null,
    };
}

confirm('Execute `composer install`?') && run('composer install');

confirm('Let this script delete itself?', true) && unlink(__FILE__);

writeln('Script completed.');
