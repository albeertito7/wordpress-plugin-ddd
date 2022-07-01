<?php

/**
 * Class EntitiesActivitiesController
 */
class EntitiesActivitiesController extends MasterController
{
    /**
     * @var
     */
    private $current_blog_id;

    /**
     * @var
     */
    private $table_name;

    public function __construct()
    {
        if( isset( $GLOBALS['wpdb'] ) )
        {
            global $wpdb;

            $this->table_name = $wpdb->prefix . 'entities_activities';
            $this->current_blog_id = get_current_blog_id();

            add_action('wp_ajax_entities_activities_controller', array($this, 'ajax'));
            add_action('wp_ajax_nopriv_entities_activities_controller', array($this, 'ajax'));
        }
    }

    public function ajax()
    {
        if ( isset( $_POST['type'] ) ) {

            $action = $_POST['type'];
            switch ($action) {
                case "createActivity":
                    echo $this->createActivity();
                    break;
                case "getActivities":
                    echo $this->getActivities( true );
                    break;
                case "updateActivity":
                    if ( isset( $_POST['id'] ) ) {
                        echo $this->updateActivity( $_POST['id'] );
                    }
                    break;
                case "updateGridActivity":
                    echo $this->updateGridActivity();
                    break;
                case "deleteActivity":
                    if ( isset( $_POST['id'] ) ) {
                        $this->deleteActivity( $_POST['id'] );
                    }
                    break;
                default:
                    parent::ajax();
                    break;
            }
        }

        exit;
    }

    public static function getActivityById($id, $json_encode=false) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'entities_activities';
        $current_blog_id = get_current_blog_id();
        $members = array();

        try {
            $sSQL = "SELECT * FROM $table_name WHERE blog_id=$current_blog_id AND id=$id";
            $res = $wpdb->get_results($sSQL);

            foreach($res as $row) {
                $members[] = Product::withRow($row);
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

    public static function getActivities($json_encode=false) {
        global $wpdb;

        $members = array();
        $table_name = $wpdb->prefix . 'entities_activities';
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

    public static function deleteActivity($id) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'entities_activities';
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

    public static function createActivity() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'entities_activities';
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
                'price' => $_POST['price']
            ));

            $result['success'] = true;
        }
        catch (Exception $ex) {

        }

        header('Content-type: application/json');
        return json_encode($result);
    }

    public static function updateActivity($id) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'entities_activities';
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
                'price' => $_POST['price']
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

    public static function updateGridActivity() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'entities_activities';
        $current_blog_id = get_current_blog_id();
        $activity = json_decode(stripslashes($_POST['activity']));

        try {
            $wpdb->update($table_name, array(
                'status' => $activity->status,
                'price' => $activity->price,
                'name' => $activity->name,
                'short_description' => $activity->short_description,
                'custom_order' => $activity->custom_order
            ), array(
                'id' => $activity->id,
                'blog_id' => $current_blog_id
            ));

        }
        catch (Exception $ex) {

        }

        return json_encode($activity);
    }

}

new EntitiesActivitiesController;