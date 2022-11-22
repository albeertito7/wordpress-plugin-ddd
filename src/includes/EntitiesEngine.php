<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://albeertito7.github.io
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/includes
 */

namespace Entities\Includes;

use Entities\Controllers;

use Entities\Domain\cart\CustomCookie;
use Entities\Domain\cart\ProductCart;

use Entities\AdminDomain\EntitiesAdmin;
use Entities\PublicDomain\EntitiesPublic;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Entities
 * @subpackage Entities/includes
 * @author     albert <albertperez@compsaonline.com>
 */
class EntitiesEngine
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      EntitiesLoader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected EntitiesLoader $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected string $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected string $version;


    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = 'entities';
        $this->version = '1.0.0';
        $this->loader = new EntitiesLoader; // Hook custom loader

        $this->definePublicDomain();
        if (function_exists('is_admin')) {
            if (is_admin()) {
                $this->defineAdminDomain();
            }
        } else {
            $this->defineAdminDomain();
        }
    }

    /**
     * Public domain.
     */
    private function definePublicDomain()
    {
        $this->loadCart();
        $plugin_public = new EntitiesPublic($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('init', $this, 'gas');

        $this->loader->addAction('wp_head', $plugin_public, 'enqueueMyVariables');

        //$this->loader->addAction('wp_enqueue_scripts', $plugin_public, 'enqueuePlugins');
        $this->loader->addAction('wp_enqueue_scripts', $plugin_public, 'enqueueStyles');
        $this->loader->addAction('wp_enqueue_scripts', $plugin_public, 'enqueueScripts');

        $this->loader->addFilter('theme_page_templates', $plugin_public, 'entitiesTemplateAsOption');
        $this->loader->addFilter('template_include', $plugin_public, 'entitiesLoadTemplate');
    }

    /**
     * Admin domain.
     */
    private function defineAdminDomain()
    {
        $plugin_admin = new EntitiesAdmin($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('admin_init', $this, 'turbo');

        $this->loader->addAction('admin_head', $plugin_admin, 'enqueueMyAdminVariables');

        // add the plugin menu
        $this->loader->addAction('admin_menu', $plugin_admin, 'addPluginMenu');

        // enqueue plugins scripts and styles
        $this->loader->addAction('admin_enqueue_scripts', $plugin_admin, 'enqueuePlugins');

        // enqueue main admin js and styles
        $this->loader->addAction('admin_enqueue_scripts', $plugin_admin, 'enqueueStyles');
        $this->loader->addAction('admin_enqueue_scripts', $plugin_admin, 'enqueueScripts');
    }

    /**
     * Product Cart.
     */
    public function loadCart()
    {
        // checking defined constants
        // WordPress constants at wp-includes/ms-default-constants.php
        if (!defined('COOKIEPATH')) {
            define('COOKIEPATH', preg_replace('|https?://[^/]+|i', '', get_option('home') . '/'));
        }

        if (!defined('COOKIE_DOMAIN')) {
            define('COOKIE_DOMAIN', false);
        }

        // initializing
        CustomCookie::init(COOKIEPATH, COOKIE_DOMAIN);
        ProductCart::init();
    }

    /**
     * Request handlers.
     *
     * Loading the application entry points.
     */
    private function loadControllers()
    {
        new Controllers\PackagesController;
        new Controllers\HotelsController;
        new Controllers\ActivitiesController;
        new Controllers\CartController;
        new Controllers\CommentsController;
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Entities_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setLocale()
    {
        global $textdomain, $lang_dir;
        $plugin_i18n = new EntitiesI18n($textdomain, $lang_dir);
        $this->loader->addAction('plugins_loaded', $plugin_i18n, 'loadPluginTextDomain');
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function getPluginName(): string
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    EntitiesLoader    Orchestrates the hooks of the plugin.
     */
    public function getLoader(): EntitiesLoader
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Run the loader to execute all the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * N/A for beginners.
     */
    public function gas()
    {
        $this->loadControllers();
        $this->setLocale();
    }

    /**
     * No one knows.
     */
    public function turbo()
    {
    }
}
