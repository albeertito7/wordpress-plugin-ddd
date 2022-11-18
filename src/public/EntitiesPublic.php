<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://albeertito7.github.io
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/public
 */

namespace Entities\PublicDomain;

use Entities\Domain\cart\ProductCart;

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

class EntitiesPublic
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private string $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private string $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct(string $plugin_name, string $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueueStyles()
    {
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/entities-public.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
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

        wp_enqueue_script($this->plugin_name . '_public', plugin_dir_url(__FILE__) . 'js/entities-public.min.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name . '_public', 'my_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

        /* Sweetalert2 */
        wp_enqueue_script('script-entities-es6-promise', plugin_dir_url(__FILE__) .  '../plugins/sweetalert2/es6-promise.min.js', array(), $this->version, false);
        wp_enqueue_script('script-entities-sweetalert2', plugin_dir_url(__FILE__) . '../plugins/sweetalert2/sweetalert2.all.min.js', array(), $this->version, false);
        wp_enqueue_style('style-entities-sweetalert2', plugin_dir_url(__FILE__) . '../plugins/sweetalert2/sweetalert2.min.css', array(), $this->version, false);
    }

    /**
     * @return void
     */
    public function enqueueMyVariables()
    {
        ?><script type="text/javascript">const ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';</script><?php
    }

    public function menuProgrammatically($items): string
    {
        $num = ProductCart::size();
        return "<li><a href='/multisite/cart/'>Cart: <span class='entities_cart_num'>$num</span></a></li>";
    }

    /**
     * Adding custom plugin page templates,
     * to visualize the entities at the front-end
     *
     * Hook: theme_page_templates
     *  - Filters list of page templates for a theme.
     *
     * Hook: template_include
     *  - Filters the path of the current template before including it.
     *
     */
    function entitiesTemplateAsOption($page_templates)
    {
        $custom_templates = array(
            'template-landing' => 'Template landing',
            'template-landing-row' => 'Template landing row',
            'template-packages-landing' => 'Template Packages landing',
            'template-packages-landing-row' => 'Template Packages landing row',
            'template-activities-landing' => 'Template Activities landing',
            'template-activities-landing-row' => 'Template Activities landing row',
            'template-hotels-landing' => 'Template Hotels landing',
            'template-hotels-landing-row' => 'Template Hotels landing row',
            'template-cart' => 'Template Cart'
        );

        foreach ($custom_templates as $key => $template) {
            $page_templates[$key] = $template;
        }

        return $page_templates;
    }

    function entitiesLoadTemplate($template)
    {
        global $post;
        $page_template_slug = get_page_template_slug($post->ID);
        $directory = plugin_dir_path(dirname(__FILE__)) . 'public/page-templates/';

        switch ($page_template_slug) {
            case 'template-landing':
                return $directory . 'template-landing.php';
                break;
            case 'template-landing-row':
                return $directory . 'template-landing-row.php';
                break;
            case 'template-packages-landing':
                return $directory . 'template-packages-landing.php';
                break;
            case 'template-packages-landing-row':
                return $directory . 'template-packages-landing-row.php';
                break;
            case 'template-activities-landing':
                return $directory . 'template-activities-landing.php';
                break;
            case 'template-activities-landing-row':
                return $directory . 'template-activities-landing-row.php';
                break;
            case 'template-hotels-landing':
                return $directory . 'template-hotels-landing.php';
                break;
            case 'template-hotels-landing-row':
                return $directory . 'template-hotels-landing-row.php';
                break;
            case 'template-cart':
                return $directory . 'template-cart.php';
                break;
        }

        return $template;
    }
}
