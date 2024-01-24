<?php

namespace PressbooksPluginScaffold;

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
    }

    public function registerMenus(): void
    {
        //TODO: Register menus here.
        add_action('network_admin_menu', [$this, 'registerMenus'], 11);
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
        Container::getInstance()->bind(DemoController::class, fn () => new DemoController);
    }

    private function enqueueScripts(): void
    {
        //TODO: Enqueue scripts here.
        $handle = 'pressbooks-plugin-scaffold';

        add_action('wp_enqueue_scripts', function () use ($handle) {
            Vite\enqueue_asset(
                plugin_dir_path(__DIR__).'dist',
                'resources/assets/js/pressbooks-plugin-scaffoold.js',
                ['handle' => $handle]
            );
        });
    }
}
