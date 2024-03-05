<?php

namespace PressbooksPluginScaffold;

use Pressbooks\Container;

/**
 * Class Bootstrap
 * @package PressbooksPluginScaffold
 *
 */
final class Bootstrap
{
    private static ?Bootstrap $instance = null;

    public static function run(): void
    {
        if (!self::$instance) {
            self::$instance = new self;

            self::$instance->setUp();
        }
    }

    public function setUp(): void
    {
        $this->registerActions();
        $this->registerBlade();
        $this->enqueueScripts();
    }

    public function registerMenus(): void
    {
        //TODO: Register menus here.
    }

    private function registerActions(): void
    {
        //TODO: Register actions here.
    }

    private function registerBlade(): void
    {
        Container::get('Blade')->addNamespace(
            'PressbooksPluginScaffold',
            dirname(__DIR__).'/resources/views'
        );
    }

    private function registerServices(): void
    {
        //TODO: Register services here.
    }

    private function enqueueScripts(): void
    {
        //TODO: Enqueue scripts here.
        $handle = 'pressbooks-plugin-scaffold';

        add_action('wp_enqueue_scripts', function () use ($handle) {
            Vite\enqueue_asset(
                WP_PLUGIN_DIR . '/pressbooks-plugin-scaffold/dist',
                'resources/assets/js/pressbooks-plugin-scaffold.js',
                ['handle' => $handle]
            );
        });
    }
}
