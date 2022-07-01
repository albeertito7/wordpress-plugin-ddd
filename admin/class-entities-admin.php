<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       author_uri
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Entities
 * @subpackage Entities/admin
 * @author     albert <albertperez@compsaonline.com>
 */
class Entities_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * @var EntitiesRouter
     */
	private $router;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->router = new EntitiesRouter();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Entities_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Entities_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/entities-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Entities_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Entities_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/entities-admin.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'my_vars', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));

        wp_enqueue_script( 'script-entities-utils', plugin_dir_url( __FILE__ ) . 'js/utils.js', array( 'jquery' ), $this->version, false );

        if ( isset( $_GET['page'] ) ) {
            switch( $_GET['page'] ) {
                case "packages":
                    wp_enqueue_script( "script-entities-packages", plugin_dir_url( __FILE__ ) . 'js/packages.js', array( 'jquery' ), $this->version, false );
                    break;
                case "hotels":
                    wp_enqueue_script( "script-entities-hotels", plugin_dir_url( __FILE__ ) . 'js/hotels.js', array( 'jquery' ), $this->version, false );
                    break;
            }

        }
	}

    /**
     *
     */
    public function enqueue_plugins() {

        $plugins_dir = plugin_dir_url( __DIR__ ) . 'plugins/';

        /* Kendo scripts */
        wp_enqueue_script( 'kendo-all-js', $plugins_dir . 'kendo/kendo.all.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'kendo-jszip-js', $plugins_dir . 'kendo/jszip.min.js', array( 'jquery' ), $this->version, false );

        /* Kendo styles */
        wp_enqueue_style( 'kendo-common-styles', $plugins_dir . 'kendo/styles/kendo.common.min.css', array(), $this->version, false );
        wp_enqueue_style( 'style-kendo-custom', $plugins_dir . 'kendo/styles/kendo.default.min.css', array(), $this->version, false );

        /* Font Awesome */
        wp_enqueue_style('style-entities-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', $this->version, false);

        /* Sweetalert2 */
        wp_enqueue_script('script-entities-es6-promise', $plugins_dir . 'sweetalert2/es6-promise.min.js', array(), $this->version, false);
        wp_enqueue_script('script-entities-sweetalert2', $plugins_dir . 'sweetalert2/sweetalert2.all.min.js', array(), $this->version, false);
        wp_enqueue_style('style-entities-sweetalert2', $plugins_dir . 'sweetalert2/sweetalert2.min.css', array(), $this->version, false);
    }

    /**
     * Building the plugin WordPress menu
     */
	public function add_plugin_menu() {

	    add_menu_page('Travel Manager', 'Travel Manager', 'administrator', 'travel-manager', array($this->router, 'match_request'), 'dashicons-database', 0);
        add_submenu_page('travel-manager', 'Desktop', 'Desktop', 'administrator', 'travel-manager', '', 1);

        // Packages
        add_submenu_page('travel-manager', 'Packages', 'Packages', 'administrator', 'packages', array($this->router, 'match_request'), 2);
        add_submenu_page('packages', 'Add a package', 'Add a package', 'administrator', 'add-package', array($this->router, 'match_request'), -1);

        // Hotels
        add_submenu_page('travel-manager', 'Hotels', 'Hotels', 'administrator', 'hotels', array($this->router, 'match_request'), 3);
        add_submenu_page('hotels', 'Add an hotel', 'Add an hotel', 'administrator', 'add-hotel', array($this->router, 'match_request'), -1);

        // Activities
        add_submenu_page('travel-manager', 'Activities', 'Activitites', 'administrator', 'activities', array($this->router, 'match_request'), 4);
        add_submenu_page('activities', 'Add an activity', 'Add an activity', 'administrator', 'add-activity', array($this->router, 'match_request'), -1);

        // Flights
        //add_submenu_page('travel-manager', 'Flights', 'Flights', 'administrator', 'flights', array($this->router, 'match_request'), 5);
        //add_submenu_page('flights', 'Add a flight', 'Add a flight', 'administrator', 'add-flight', array($this->router, 'match_request'), -1);
    }

    /**
     * Adding custom plugin page templates,
     * to visualize the entities at the front-end
     */
    public function add_page_templates() {

        //Add our custom template to the admin's templates dropdown
        add_filter( 'theme_page_templates', 'entities_template_as_option', 10, 3 );
        function entities_template_as_option( $page_templates, $theme, $post ) {

            $page_templates['template-landing.php'] = 'Template landing';

            return $page_templates;

        }

        //When our custom template has been chosen then display it for the page
        add_filter( 'template_include', 'entities_load_template', 99 );
        function entities_load_template( $template ) {

            global $post;
            $custom_template_slug   = 'template-landing.php';
            $page_template_slug     = get_page_template_slug( $post->ID );

            if( $page_template_slug == $custom_template_slug ){
                return plugin_dir_path( __FILE__ ) . 'page-templates/' . $custom_template_slug;
            }

            return $template;
        }

    }

}