<?php

/**
 * Class EntitiesActivitiesController
 */
class EntitiesActivitiesController extends MasterController
{
    private $activityRepository;

    public function __construct()
    {
        $this->activityRepository = ActivityRepository::getInstance();

        add_action('wp_ajax_entities_activities_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_activities_controller', array($this, 'ajax'));
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

    /**
     * @param $id
     * @param bool $json_encode
     * @return Activity|false|string|null
     */
    public function getActivityById($id, $json_encode=false) {

        $activity = $this->activityRepository->findById($id);

        if($json_encode) {
            header('Content-type: application/json');
            return json_encode($activity);
        }

        return $activity;
    }

    /**
     * @param bool $json_encode
     * @return array|false|string
     */
    public function getActivities($json_encode=false) {

        $activities = array();
        $activities = $this->activityRepository->findAll();

        if ( $json_encode ) {
            header('Content-type: application/json');
            return json_encode($activities);
        }

        return $activities;

    }

    public function deleteActivity($id) {

        $response = array(
            'success' => false
        );

        $activity = new Activity();
        $activity->setId($id);

        $result = $this->activityRepository->remove($activity);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
    }

    /**
     * @return false|string
     */
    public function createActivity() {

        $activity = new Activity();
        $activity->setStatus($_POST['status']);
        $activity->setName($_POST['name']);
        $activity->setShortDescription($_POST['short_description']);
        $activity->setDescription($_POST['description']);
        $activity->setFeaturedImage($_POST['featured_image']);
        $activity->setObservations($_POST['observations']);
        $activity->setOrder($_POST['custom_order']);
        $activity->setPrice($_POST['price']);

        $result = $this->activityRepository->add($activity);

        header('Content-type: application/json');
        return json_encode($result);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function updateActivity($id) {

        $activity = new Activity();
        $activity->setId($id);
        $activity->setStatus($_POST['status']);
        $activity->setName($_POST['name']);
        $activity->setShortDescription($_POST['short_description']);
        $activity->setDescription($_POST['description']);
        $activity->setFeaturedImage($_POST['featured_image']);
        $activity->setObservations($_POST['observations']);
        $activity->setOrder($_POST['custom_order']);
        $activity->setPrice($_POST['price']);

        $result = $this->activityRepository->update($activity);

        header('Content-type: application/json');
        return json_encode($result);
    }


    /*public function updateGridActivity() {

    }*/

    /**
     * @return false|string
     */
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