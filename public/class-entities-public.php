<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       author_uri
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Entities
 * @subpackage Entities/public
 * @author     albert <albertperez@compsaonline.com>
 */

class Entities_Public {

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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        //add_action( 'widgets_init' , array($this, 'remove_search_widget') );

        //add_filter('wp_nav_menu_items', array($this, 'menuProgrammatically') );

    }

    /*public function remove_search_widget() {
        unregister_widget('WP_Widget_Search');
    }*/

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/entities-public.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Entities_Loader as all the hooks are defined
         * in that particular class.
         *
         * The Entities_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name . '_public', plugin_dir_url( __FILE__ ) . 'js/entities-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name . '_public', 'my_vars', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));

        /* Sweetalert2 */
        wp_enqueue_script('script-entities-es6-promise', plugin_dir_url( __FILE__ ) .  '/plugins/sweetalert2/es6-promise.min.js', array(), $this->version, false);
        wp_enqueue_script('script-entities-sweetalert2', plugin_dir_url( __FILE__ ) . '/plugins/sweetalert2/sweetalert2.all.min.js', array(), $this->version, false);
        wp_enqueue_style('style-entities-sweetalert2', plugin_dir_url( __FILE__ ) . '/plugins/sweetalert2/sweetalert2.min.css', array(), $this->version, false);
    }

    public function menuProgrammatically($items): string
    {
        $num = ProductCart::size();
        return "<li><a href='/multisite/cart/'>Cart: <span class='entities_cart_num'>$num</span></a></li>";
    }
}
