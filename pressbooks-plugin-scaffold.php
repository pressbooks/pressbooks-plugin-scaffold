<?php
/**
 * Plugin Name: Pressbooks Plugin Scaffold
 * Plugin URI: https://pressbooks.org
 * Requires at least: 6.5
 * Requires Plugins: pressbooks
 * Description: A scaffold for Pressbooks plugins.
 * Version: 0.0.1
 * Author: Pressbooks (Book Oven Inc.)
 * Author URI: https://pressbooks.org
 * Requires PHP: 8.1
 * Pressbooks tested up to: 6.16.0
 * Text Domain: pressbooks-plugin-scaffold
 * License: GPL v3 or later
 * Network: True
 */

use PressbooksPluginScaffold\Bootstrap;
use PressbooksPluginScaffold\Database\Migration;

register_activation_hook(__FILE__, [Migration::class, 'migrate']);

add_action('plugins_loaded', [Bootstrap::class, 'run']);
