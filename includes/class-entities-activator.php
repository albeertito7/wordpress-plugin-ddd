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

        // upgrade contains the dbDelta function which review if a table name already exists
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        /*$table_name = $wpdb->prefix . 'entities_config';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              blog_id int NOT NULL,
              theme mediumint(9) NOT NULL DEFAULT 0,
              date_created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
              date_modified datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
              PRIMARY KEY  (id)
            ) $charset_collate;";

        dbDelta( $sql );*/

        $table_name = $wpdb->prefix . 'entities_packages';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              blog_id int NOT NULL,
              status varchar(20) DEFAULT 'draft' NOT NULL,
              date_created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
              date_modified datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
              name tinytext NOT NULL,
              short_description tinytext,
              description text,
              price int NOT NULL DEFAULT 0,
              featured_image text,
              gallery_images text,
              observations text,
              custom_order mediumint(9) DEFAULT -1,
              PRIMARY KEY  (id)
            ) $charset_collate;";

        dbDelta( $sql );

        $table_name = $wpdb->prefix . 'entities_hotels';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              blog_id int NOT NULL,
              status varchar(20) DEFAULT 'draft' NOT NULL,
              date_created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
              date_modified datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
              name tinytext NOT NULL,
              short_description tinytext,
              description text,
              price int NOT NULL DEFAULT 0,
              featured_image text,
              gallery_images text,
              observations text,
              custom_order mediumint(9) DEFAULT -1,
              date_entrance datetime,
              date_departure datetime,
              PRIMARY KEY  (id)
            ) $charset_collate;";

        dbDelta( $sql );

        $table_name = $wpdb->prefix . 'entities_activities';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              blog_id int NOT NULL,
              status varchar(20) DEFAULT 'draft' NOT NULL,
              date_created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
              date_modified datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
              name tinytext NOT NULL,
              short_description tinytext,
              description text,
              price int NOT NULL DEFAULT 0,
              featured_image text,
              gallery_images text,
              observations text,
              custom_order mediumint(9) DEFAULT -1
              PRIMARY KEY  (id)
            ) $charset_collate;";

        dbDelta( $sql );

        /*$table_name = $wpdb->prefix . 'entities_flights';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              blog_id int NOT NULL,
              status varchar(20) DEFAULT 'draft' NOT NULL,
              date_created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
              date_modified datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
              name tinytext NOT NULL,
              short_description tinytext,
              description text,
              price int NOT NULL DEFAULT 0,
              featured_image text,
              gallery_images text,
              observations text,
              custom_order mediumint(9) DEFAULT -1
              PRIMARY KEY  (id)
            ) $charset_collate;";

        dbDelta( $sql );*/
	}

}
