<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://albeertito7.github.com
 * @since             1.0.0
 * @package           Entities
 *
 * @wordpress-plugin
 * Plugin Name:       Entities
 * Plugin URI:        plugin_uri
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            albert
 * Author URI:        https://albeertito7.github.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       entities
 * Domain Path:       /languages
 */

namespace Entities;

// check whether the WordPress environment loaded or not
if (!defined('ABSPATH')) {
    die;
}

// if this file is called directly, abort
if (!defined('WPINC')) {
    die;
}

// checking Composer autoloader
if (!is_readable(__DIR__ . './vendor/autoload.php')) {
    die;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The biggest benefits of using namespaces is that the class names which
 * are declared in one namespace will not clash with the same class names declared in another namespace.
 * It is also referred as named group of classes having common features.
 *
 * This solves the problem of tackling the naming collision problem.
 * The namespaces should be used especially when building complex and large projects.
 */
use Entities\Includes\EntitiesEngine;
use Entities\Includes\EntitiesActivator;
use Entities\Includes\EntitiesDeactivator;

// custom global config
require_once 'src\my-config.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/EntitiesActivator.php
 */
function activate_plugin()
{
    EntitiesActivator::activate();
}
register_activation_hook(__FILE__, 'Entities\activate_plugin');

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/EntitiesDeactivator.php
 */
function deactivate_plugin()
{
    EntitiesDeactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'Entities\deactivate_plugin');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_entities()
{
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    $plugin_engine = new EntitiesEngine;
    $plugin_engine->run();
}

// custom shortcodes
//require_once 'src\my-shortcodes.php';
run_entities();
