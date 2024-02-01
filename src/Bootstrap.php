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
        $this->fixSymlinks();
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
                'resources/assets/js/pressbooks-plugin-scaffold.js',
                ['handle' => $handle]
            );
        });
    }

    /**
     * This is a hack to fix the symlinks in the generated script tags meanwhile we found a better way to enqueue Vite assets
     * plugin_dir_path(__DIR__).'dist'
     * @return void
     */
    private function fixSymlinks(): void
    {
        add_filter('script_loader_src', function ($src, $handle) {
            if ($handle === 'pressbooks-plugin-scaffold') {
                $src = preg_replace('|/app/srv/www/bedrocks/[^/]+/releases/\d+/web/|', '/', $src);
            }
            // If the handle doesn't match, return the original $src
            return $src;
        }, 10, 2);
        add_filter('style_loader_src', function ($src, $handle) {
            if (str_starts_with($handle, 'pressbooks-plugin-scaffold')) {
                $src = preg_replace('|/app/srv/www/bedrocks/[^/]+/releases/\d+/web/|', '/', $src);
            }
            // If the handle or conditions don't match, return the original $src
            return $src;
        }, 10, 2);
    }
}
