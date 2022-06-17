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

        wp_localize_script($this->plugin_name, 'my_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

	}

    /**
     *
     */
	public function enqueue_plugins() {

	    $plugins_dir = plugin_dir_url( __FILE__ ) . 'plugins/';

        /* jQuery */
        wp_enqueue_script( 'script-jquery', $plugins_dir . 'jquery/jquery-3.6.0.min.js', array( 'jquery' ), $this->version, false );

        /* Kendo scripts */
        wp_enqueue_script( 'script-kendo', $plugins_dir . 'kendo/kendo.all.min.js', '', $this->version, false );
        wp_enqueue_script( 'script-jszip', $plugins_dir . 'kendo/jszip.min.js', '', $this->version, false );

        /* Kendo styles */
        wp_enqueue_style( 'style-kendo-common', $plugins_dir . 'kendo/styles/kendo.common.min.css', array( 'kendo-common' ), $this->version, 'all' );
        wp_enqueue_style( 'style-kendo-default', $plugins_dir . 'kendo/styles/kendo.default.min.css', array( 'kendo-default' ), $this->version, 'all' );
    }

    /**
     *
     */
	public function add_plugin_menu() {

	    add_menu_page('Travel Manager', 'Travel Manager', 'custom_manage_options', 'travel-manager', array($this->router, 'match_request'), 'dashicons-database', 3);
        add_submenu_page('travel-manager', 'Escritori', 'Escritori', 'custom_manage_options', 'travel-manager', '', 1);
	    add_submenu_page('travel-manager', 'Paquets', 'Tots els paquets', 'custom_manage_options', 'packages', array($this->router, 'match_request'), 2);
        add_submenu_page('travel-manager', 'Afegeix', 'Afegeix un paquet', 'custom_manage_options', 'add-package', array($this->router, 'match_request'), 3);

    }

    /**
     *
     */
    public function add_page_templates() {

        //Add our custom template to the admin's templates dropdown
        add_filter( 'theme_page_templates', 'entities_template_as_option', 10, 3 );
        function entities_template_as_option( $page_templates, $theme, $post ){

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