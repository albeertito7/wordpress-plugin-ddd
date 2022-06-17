<?php

/**
 * Class EntitiesController
 */
class EntitiesController
{
    public function __construct()
    {
        add_action('wp_ajax_entities_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_controller', array($this, 'ajax'));
    }

    public function ajax()
    {
        $action = $_POST['type'];

        switch ($action) {
            case "test":
                echo "asdf";
                break;
            case "getPackages":
                echo $this->getStaticPackages(true);
                break;
        }

        exit;
    }

    public static function getStaticPackages($json_encode=false) {
        global $wpdb;
        $members = array();

        $table_name = $wpdb->prefix . 'entities_packages';
        $current_blog_id = get_current_blog_id();
        try
        {
            $sSQL = "SELECT * FROM $table_name WHERE blog_id=$current_blog_id ORDER BY id ASC";
            $res = $wpdb->get_results($sSQL);

            foreach($res as $row)
            {
                /*$members[] = array(
                    'id' => $row->id,
                    'blog_id' => $row->blog_id,
                    'title' => $row->title,
                    'description' => $row->description);*/

                $members[] = Product::withRow($row);
            }
        }
        catch(Exception $ex) {

        }

        if($json_encode) {
            return json_encode($members);
        }

        return $members;
    }
}

new EntitiesController;