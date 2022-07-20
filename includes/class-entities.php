<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       author_uri
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/includes
 */

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
class Entities {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Entities_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ENTITIES_VERSION' ) ) {
			$this->version = ENTITIES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'entities';

		$this->load_dependencies();
		$this->set_locale();

		$this->define_public_domain();
		$this->define_admin_domain();
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
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-entities-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-entities-i18n.php';

        /**
         * Domain models
         */
        $this->load_models();

        /**
         * Cart
         */
        $this->load_cart();

        /**
         * Access model objects and business logic services
         */
        $this->load_services();

        /**
         * Request handlers
         */
		$this->load_controllers();

        /**
         * Hook custom loader
         */
		$this->loader = new Entities_Loader();
	}

    /**
     * Public domain
     */
    private function define_public_domain() {

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-entities-public.php';

        $this->define_public_hooks();

    }

    /**
     * Admin domain
     */
    private function define_admin_domain() {

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-entities-admin.php';

        /**
         * Custom Router
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-entities-router.php';

        $this->define_admin_hooks();
    }

    /**
     * Domain models
     */
    private function load_models() {

        $directory = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class/';

        require_once $directory . 'Utils.php';
        require_once $directory . 'Logger.php';
        require_once $directory . 'Product.php';
        require_once $directory . 'Package.php';
        require_once $directory . 'Hotel.php';
        require_once $directory . 'Activity.php';

        // Product Value Objects
        //require_once $directory . 'product/ProductId.php';
        //require_once $directory . 'product/ProductStatus.php';
    }

    /**
     * Product Cart
     */
    public function load_cart() {
        $directory = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class/cart/';

        require_once $directory . 'CustomCookie.php';
        require_once $directory . 'ProductCart.php';

        // checking defined constants
        // WordPress constants at wp-includes/ms-default-constants.php
        if ( !defined('COOKIEPATH') ) {
            define('COOKIEPATH', preg_replace('|https?://[^/]+|i', '', get_option('home') . '/' ) );
        }

        if ( !defined('COOKIE_DOMAIN') ) {
            define('COOKIE_DOMAIN', false);
        }

        // initializing
        CustomCookie::init(COOKIEPATH, COOKIE_DOMAIN);
        ProductCart::init();
    }

    /**
     * Based on the Repository pattern, and
     * the DAO (Data Access Object) pattern
     */
    private function load_services() {

        $directory = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/services/';

        // load typos interface Repositories and DAOs
        require_once $directory .'ProductRepositoryInterface.php';

        // load Repositories and DAOs
        require_once $directory . 'MasterRepository.php';
        require_once $directory . 'PackageRepository.php';
        require_once $directory . 'ActivityRepository.php';
        require_once $directory . 'HotelRepository.php';
    }

    /**
     * Request handlers
     */
	private function load_controllers() {

	    $directory = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/controllers/';

        require_once $directory . 'master-controller.php';
        require_once $directory . 'entities-controller.php';
        require_once $directory . 'entities-hotels-controller.php';
        require_once $directory . 'entities-activities-controller.php';

        require_once $directory . 'entities-cart-controller.php';
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
	private function set_locale() {

		$plugin_i18n = new Entities_i18n($this->plugin_name);

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Entities_Admin( $this->get_plugin_name(), $this->get_version() );

		// enqueue plugins scripts and styles
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_plugins' );

        // enqueue main admin js and styles
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        // add the plugin menu
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_menu');

        // add custom page templates
        $this->loader->add_action('init', $plugin_admin, 'add_page_templates');

        //$this->loader->add_action('init', $plugin_admin, 'entities_my_custom_posts');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Entities_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Entities_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
