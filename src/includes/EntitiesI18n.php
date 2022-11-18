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
     * @return   string     The plugin textdomain.
     */
    private string $textdomain;

    /**
     * Relative path to WPç_PLUGIN_DIR where the .mo file resides.
     * @var string
     */
    private string $lang_dir;

    /**
     * @param string $textdomain
     * @param string $lang_dir
     */
    public function __construct(string $textdomain, string $lang_dir)
    {
        $this->textdomain = $textdomain;
        $this->lang_dir = $lang_dir;
    }

    /**
     * Callback function.
     * Loads the plugin's translated strings.
     * True when textdomain is successfully loaded, false otherwise.
     *
     * @since   1.0.0
     * @return bool
     */
    public function loadPluginTextDomain(): bool
    {
        /**
         * If the path is not given then it will be the root of the plugin directory.
         * The .mo file should be named based on the text domain with a dash, and then the locale exactly.
         */
        return load_plugin_textdomain($this->textdomain, false, $this->lang_dir);
    }
}
