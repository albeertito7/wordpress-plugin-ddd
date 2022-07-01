<?php

/**
 * Class EntitiesHotelsController
 */
class EntitiesHotelsController extends MasterController
{
    public function __construct()
    {
        add_action('wp_ajax_entities_hotels_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_hotels_controller', array($this, 'ajax'));
    }

    public function ajax()
    {
        if ( isset( $_POST['type'] ) ) {

            $action = $_POST['type'];
            switch ($action) {
                case "createHotel":
                    echo $this->createHotel();
                    break;
                case "getHotels":
                    echo $this->getHotels(true);
                    break;
                case "updateHotel":
                    echo $this->updateHotel($_POST['id']);
                    break;
                case "updateGridHotel":
                    echo $this->updateGridHotel();
                    break;
                case "deleteHotel":
                    $this->deleteHotel($_POST['id']);
                    break;
                default:
                    parent::ajax();
                    break;
            }
        }

        exit;
    }

    public static function getHotelById($id, $json_encode=false) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'entities_hotels';
        $current_blog_id = get_current_blog_id();
        $members = array();

        try {
            $sSQL = "SELECT * FROM $table_name WHERE blog_id=$current_blog_id AND id=$id";
            $res = $wpdb->get_results($sSQL);

            foreach($res as $row) {
                $members[] = Hotel::withRow($row);
            }
        }
        catch (Exception $ex) {

        }

        if($json_encode) {
            header('Content-type: application/json');
            return json_encode($members[0]);
        }

        return $members[0];
    }

    public static function getHotels($json_encode=false) {
        global $wpdb;
        $members = array();
        $table_name = $wpdb->prefix . 'entities_hotels';
        $current_blog_id = get_current_blog_id();

        try
        {
            $sSQL = "SELECT * FROM $table_name WHERE blog_id=$current_blog_id ORDER BY id ASC";
            $res = $wpdb->get_results($sSQL);

            foreach($res as $row) {
                $members[] = Hotel::withRow($row);
            }
        }
        catch(Exception $ex) {

        }

        if($json_encode) {
            header('Content-type: application/json');
            return json_encode($members);
        }

        return $members;
    }

    public static function deleteHotel($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'entities_hotels';
        $current_blog_id = get_current_blog_id();

        try
        {
            //$sSQL = "DELETE FROM $table_name WHERE blog_id=$current_blog_id AND id=$id";
            $wpdb->delete($table_name, array(
                'id' => $id,
                'blog_id' => $current_blog_id
            ));
        }
        catch(Exception $ex) {

        }
    }

    public static function createHotel() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'entities_hotels';
        $current_blog_id = get_current_blog_id();
        $result = array('success'=> false );

        try {

            $wpdb->insert($table_name, array(
                'blog_id' => $current_blog_id,
                'status' => $_POST['status'],
                'name' => $_POST['name'],
                'short_description' => $_POST['short_description'],
                'description' => $_POST['description'],
                'featured_image' => $_POST['featured_image'],
                'observations' => $_POST['observations'],
                'custom_order' => $_POST['custom_order'],
                'price' => $_POST['price'],
                'date_entrance' => $_POST['date_entrance'],
                'date_departure' => $_POST['date_departure']
            ));

            $result['success'] = true;
        }
        catch (Exception $ex) {

        }

        header('Content-type: application/json');
        return json_encode($result);
    }

    public static function updateHotel($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'entities_hotels';
        $current_blog_id = get_current_blog_id();
        $result = array('success'=> false );

        try {
            $wpdb->update($table_name, array(
                'status' => $_POST['status'],
                'name' => $_POST['name'],
                'short_description' => $_POST['short_description'],
                'description' => $_POST['description'],
                'featured_image' => $_POST['featured_image'],
                'observations' => $_POST['observations'],
                'custom_order' => $_POST['custom_order'],
                'price' => $_POST['price'],
                'date_entrance' => $_POST['date_entrance'],
                'date_departure' => $_POST['date_departure']
            ), array(
                'id' => $id,
                'blog_id' => $current_blog_id
            ));

            $result['success'] = true;
        }
        catch (Exception $ex) {

        }

        header('Content-type: application/json');
        return json_encode($result);
    }

    public static function updateGridHotel() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'entities_hotels';
        $current_blog_id = get_current_blog_id();
        $hotel = json_decode(stripslashes($_POST['hotel']));

        try {
            $wpdb->update($table_name, array(
                'status' => $hotel->status,
                'price' => $hotel->price,
                'name' => $hotel->name,
                'short_description' => $hotel->short_description,
                'custom_order' => $hotel->custom_order
            ), array(
                'id' => $hotel->id,
                'blog_id' => $current_blog_id
            ));

        }
        catch (Exception $ex) {

        }

        return json_encode($hotel);
    }

}

new EntitiesHotelsController;