<?php

/**
 * Class MasterRepository
 *
 * Data access object mode
 * Separating the database access layer as a public access interface is a common design pattern
 */
abstract class MasterRepository implements ProductRepository {

    // config properties
    protected $db_user;
    protected $db_password;
    protected $db_name;
    protected $db_host;

    // database instance connection
    protected $db;

    // multisite management
    protected $current_blog_id;

    /**
     * MasterRepository constructor.
     * @throws Exception
     */
    public function __construct()
    {
        global $wpdb;

        $this->db_user     = defined( 'DB_USER' ) ? DB_USER : '';
        $this->db_password = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : '';
        $this->db_name     = defined( 'DB_NAME' ) ? DB_NAME : '';
        $this->db_host     = defined( 'DB_HOST' ) ? DB_HOST : '';

        if ( function_exists( 'get_current_blog_id' ) ) {
            $this->current_blog_id = get_current_blog_id();
        }

        if ( !isset( $wpdb ) ) {

            if ( defined( ABSPATH ) && define( WPINC ) && defined( WP_CONTENT_DIR ) ) {

                require_once ABSPATH . WPINC . '/wp-db.php';
                if ( file_exists( WP_CONTENT_DIR . '/db.php' ) ) {
                    require_once WP_CONTENT_DIR . '/db.php';
                }

                $wpdb = new wpdb( $this->db_user, $this->db_password, $this->db_name, $this->db_host );
            }
            else {
                throw new Exception( "WordPress not loaded." );
            }
        }

        $this->db = $wpdb;
    }
}
