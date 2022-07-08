<?php

/**
 * Class EntitiesController
 */
class EntitiesController extends MasterController
{
    private $packageRepository;

    public function __construct()
    {
        $this->packageRepository = new PackageRepository();

        add_action('wp_ajax_entities_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_controller', array($this, 'ajax'));
    }

    /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */
    public function ajax(/*Request $request*/)
    {
        $action = $_POST['type'];

        switch ($action)
        {
            case "createPackage":
                echo $this->createPackage();
                break;
            case "getPackages":
                echo $this->getPackages(true);
                break;
            case "updatePackage":
                echo $this->updatePackage($_POST['id']);
                break;
            case "updateGridPackage":
                echo $this->updateGridPackage();
                break;
            case "deletePackage":
                echo $this->deletePackage($_POST['id']);
                break;
            default:
                parent::ajax();
                break;
        }

        exit;
    }

    /**
     * @param $id
     * @param bool $json_encode
     * @return false|mixed|string
     */
    public static function getPackageById($id, $json_encode=false) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'entities_packages';
        $current_blog_id = get_current_blog_id();
        $members = array();

        try {
            $sSQL = "SELECT * FROM $table_name WHERE blog_id=$current_blog_id AND id=$id";
            $res = $wpdb->get_results($sSQL);

            foreach($res as $row) {
                $members[] = Package::withRow($row);
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

    /**
     * @param bool $json_encode
     * @return array|false|string
     */
    public function getPackages($json_encode=false) {

        $packages = $this->packageRepository->getPackages();

        if($json_encode) {
            header('Content-type: application/json');
            return json_encode($packages);
        }

        return $packages;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deletePackage($id) {

        $response = array(
            'success' => false
        );

        $result = $this->packageRepository->deletePackage($id);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
    }

    /**
     * @return false|string
     */
    public function createPackage() {

        // create Package or data array
        /*$data = array(
            'status' => $_POST['status'],
            'name' => $_POST['name'],
            'short_description' => $_POST['short_description'],
            'description' => $_POST['description'],
            'featured_image' => $_POST['featured_image'],
            'observations' => $_POST['observations'],
            'custom_order' => $_POST['custom_order'],
            'price' => $_POST['price']
        );*/

        // creation package object
        $package = new Package();
        $package->setStatus($_POST['status']);
        $package->setName($_POST['name']);
        $package->setShortDescription($_POST['short_description']);
        $package->setDescription($_POST['description']);
        $package->setFeaturedImage($_POST['featured_image']);
        $package->setObservations($_POST['observations']);
        $package->setOrder($_POST['custom_order']);
        $package->setPrice($_POST['price']);


        $result = $this->packageRepository->createPackage($package);

        /*global $wpdb;
        $table_name = $wpdb->prefix . 'entities_packages';
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

        }*/

        header('Content-type: application/json');
        return json_encode($result);
    }

    /**
     * @param $id
     * @return false|string
     */
    public static function updatePackage($id) {

        global $wpdb;

        $table_name = $wpdb->prefix . 'entities_packages';
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

    /**
     * @return false|string
     */
    public static function updateGridPackage() {

        global $wpdb;

        $table_name = $wpdb->prefix . 'entities_packages';
        $current_blog_id = get_current_blog_id();
        $package = json_decode(stripslashes($_POST['package']));

        try {
            $wpdb->update($table_name, array(
                'status' => $package->status,
                'price' => $package->price,
                'name' => $package->name,
                'short_description' => $package->short_description,
                'custom_order' => $package->custom_order
            ), array(
                'id' => $package->id,
                'blog_id' => $current_blog_id
            ));

        }
        catch (Exception $ex) {

        }

        return json_encode($package);
    }

}

new EntitiesController;