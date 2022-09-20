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
        if (defined('ENTITIES_VERSION')) {
            $this->version = ENTITIES_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'entities';

        $this->loadDependencies();
        $this->setLocale();

        $this->definePublicDomain();
        $this->defineAdminDomain();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Entities_Loader. Orchestrates the hooks of the plugin.
     * - Entities_i18n. Defines internationalization functionality.
     * - Entities_Admin. Defines all hooks for the admin area.
     * - Entities_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function loadDependencies()
    {
        /**
         * Cart.
         */
        $this->loadCart();

        /**
         * Request handlers.
         */
        $this->loadControllers();

        /**
         * Hook custom loader.
         */
        $this->loader = new EntitiesLoader;
    }

    /**
     * Public domain.
     */
    private function definePublicDomain()
    {
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        //require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-entities-public.php';

        $this->definePublicHooks();
    }

    /**
     * Admin domain.
     */
    private function defineAdminDomain()
    {
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        //require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-entities-admin.php';

        /**
         * Custom Router.
         */
        //require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-entities-router.php';

        $this->defineAdminHooks();
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
        $plugin_i18n = new EntitiesI18n($this->getPluginName());

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineAdminHooks()
    {
        $plugin_admin = new EntitiesAdmin($this->getPluginName(), $this->getVersion());

        // enqueue plugins scripts and styles
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_plugins');

        // enqueue main admin js and styles
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        // add the plugin menu
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_menu');

        $this->loader->add_filter('theme_page_templates', $plugin_admin, 'entities_template_as_option');
        $this->loader->add_filter('template_include', $plugin_admin, 'entities_load_template');

        // add custom page templates
        //$this->loader->add_action('init', $plugin_admin, 'add_page_templates');

        //$this->loader->add_action('init', $plugin_admin, 'entities_my_custom_posts');
    }

    /**
     * Register all the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function definePublicHooks()
    {
        $plugin_public = new EntitiesPublic($this->getPluginName(), $this->getVersion());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
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
}
