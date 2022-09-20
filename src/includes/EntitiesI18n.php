<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://albeertito7.github.io
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/includes
 */

namespace Entities\Includes;

/**
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Entities
 * @subpackage Entities/includes
 * @author     albert <albertperez@compsaonline.com>
 */
class EntitiesI18n
{

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    private $domain;

    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return void
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            $this->domain,
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
