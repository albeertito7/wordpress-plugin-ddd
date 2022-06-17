<?php

/**
 * Fired during plugin activation
 *
 * @link       author_uri
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Entities
 * @subpackage Entities/includes
 * @author     albert <albertperez@compsaonline.com>
 */
class Entities_Activator {

	/**
	 * Plugin setting up
	 *
	 * Add new tables to the database or create and store plugin's own options in wp_options,
     * among other things.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	    // Check and creation database tables
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'entities_packages';

        /*$sql = "CREATE TABLE $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              name tinytext NOT NULL,
              text text NOT NULL,
              url varchar(55) DEFAULT '' NOT NULL,
              PRIMARY KEY  (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );*/

        /* Creation of the entities packages table */
        $table_name = $wpdb->prefix . 'entities_packages';
        $sql = "CREATE TABLE $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              blog_id int NOT NULL,
              title tinytext,
              description text,
              PRIMARY KEY  (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
	}

}
