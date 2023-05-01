# Pressbooks Plugin Scaffold

**Contributors:** conner_bw, greatislander, steelwagstaff \
**Tags:** pressbooks, plugin, scaffolding \
**Requires at least:** 6.2 \
**Tested up to:** 6.2 \
**Stable tag:** 0.5.0-dev \
**License:** GPLv3 or later \
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html

Scaffolding for a Pressbooks plugin.

## Description

This is not a plugin, but a tool that helps you scaffold a plugin.

## Installation

# Create Plugin

Run `composer create-project pressbooks/pressbooks-plugin-scaffold <your-plugin-slug>`.

Uncomment lines 34-43 of `pressbooks-plugin-scaffold.php` to enable Composer autoloader (you'll need to require a class to test for first).

Replace `pressbooks/pressbooks-plugin-scaffold` with `<your-github-username>/<your-plugin-slug>` throughout the project.

Replace `pressbooks-plugin-scaffold` with `<your-plugin-slug>` throughout the project (renaming files as needed).

Replace `PressbooksPluginScaffold` with `<YourNamespace>` throughout the project.

Run `npm install` to install dependencies.

Update readme.txt to reflect your plugin's name and description and run `composer readme` to generate an updated readme.md file.

# Optional Steps

Configure GitHub Action deploys (instructions to come).

Configure Transifex project and localization (instructions to come).

# Helpful Commands

`composer standards`: check PHP coding standards with PHP_CodeSniffer
`composer test`: run unit tests with PHPUnit
`composer readme`: generate a Markdown readme from readme.txt
`composer localize`: update localization files (requires Transifex to be configured)
`npm run test`: check SCSS/ES6 with StyleLint and ESLint
`npm run build`: build assets for distribution

## Changelog

### 0.5.0
#### Upgrade Notice
Pressbooks Plugin Scaffold 0.5.0 requires PHP 8.1, Pressbooks >= 6.9.3, and WordPress >= 6.2.

### 0.4.0
**Major Changes**
- Add support for Composer 2
- Add GitHub Actions for linting and testing
- Add Dependabot config
- Update Dependencies

### 0.2.0

**Major Changes**
- A new feature.

**Minor Changes**
- A backwards-compatible change.

**Patches**
- A bug fix.
