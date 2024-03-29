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

function titleCase(string $subject, bool $removeSpaces = false): string
{
    $value = ucwords(str_replace(['-', '_'], ' ', $subject));

    return $removeSpaces ? str_replace(' ', '', $value) : $value;
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

$pluginName = ask('Plugin name', titleCase(basename($currentDirectory), removeSpaces: false));

$kebabCaseName = slugify($pluginName);
$titleCaseName = ask('Namespace name', titleCase($pluginName, removeSpaces: true));
$description = ask('Plugin description', "This is my plugin {$kebabCaseName}");

writeln('------');
writeln("Plugin name     : {$pluginName}");
writeln("Plugin          : {$kebabCaseName} <{$description}>");
writeln("Namespace       : Pressbooks\\{$titleCaseName}");
writeln("Classname       : {$titleCaseName}");
writeln("Root file name  : {$kebabCaseName}");
writeln('------');

writeln('This script will replace the above values in all relevant files in the project directory.');

if (! confirm('Modify files?', true)) {
    exit(1);
}

$files = getReplaceableFiles();

foreach ($files as $file) {
    if (str_contains($file, 'README.md')) {
        $contents = file_get_contents($file);

        file_put_contents(
            $file,
            <<<TEXT
# {$pluginName}

{$description}

TEXT
        );
    } else {
        replaceInFile($file, [
            'pressbooks-plugin-scaffold' => $kebabCaseName,
            'PressbooksPluginScaffold' => $titleCaseName,
            'Pressbooks Plugin Scaffold' => $pluginName,
            'A scaffold for Pressbooks plugins.' => $description,
        ]);
    }

    if (str_contains($file, 'pressbooks-plugin-scaffold')) {
        rename($file, str_replace('pressbooks-plugin-scaffold', $kebabCaseName, $file));
    }
}

confirm('Execute `composer install` & `npm install`?') && run('composer install & npm install');

confirm('Let this script delete itself?', true) && unlink(__FILE__);

writeln('Script completed.');
