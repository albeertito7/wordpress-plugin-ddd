<?php

/**
 * Class EntitiesController
 */
class EntitiesController extends MasterController
{
    private $packageRepository;

    public function __construct()
    {
        $this->packageRepository = PackageRepository::getInstance();

        add_action('wp_ajax_entities_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_controller', array($this, 'ajax'));
    }

    public function ajax()
    {
        if ( isset( $_POST['type'] ) ) {

            $action = $_POST['type'];

            switch ($action) {
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
        }

        exit;
    }

    /**
     * @return false|string
     */
    public function createPackage() {

        $response = array('success'=> false );

        // creation package object
        $package = new Package();
        $package->setStatus($_POST['status']);
        $package->setName($_POST['name']);
        $package->setShortDescription($_POST['short_description']);
        $package->setDescription($_POST['description']);
        $package->setFeaturedImage($_POST['featured_image']);
        $package->setObservations($_POST['observations']);
        $package->setCustomOrder($_POST['custom_order']);
        $package->setPrice($_POST['price']);

        $result = $this->packageRepository->add($package);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
    }

    /**
     * @param $id
     * @param bool $json_encode
     * @return false|Package|string|null
     */
    public function getPackageById($id, $json_encode=false) {

        $package = $this->packageRepository->findById($id);

        if ( $json_encode ) {
            header('Content-type: application/json');
            return json_encode($package);
        }

        return $package;
    }

    /**
     * @param bool $json_encode
     * @return array|false|string
     * @throws Exception
     */
    public function getPackages($json_encode=false) {

        $packages = array();

        try {
            $packages = $this->packageRepository->findAll();
        }
        catch (Exception $e) {

        }

        if($json_encode) {
            header('Content-type: application/json');
            return json_encode($packages);
        }

        return $packages;
    }

    /**
     * @param $id
     * @return false|string
     */
    public function updatePackage($id) {

        $response = array('success'=> false );

        // creation package object
        $package = new Package();
        $package->setId($id);
        $package->setStatus($_POST['status']);
        $package->setName($_POST['name']);
        $package->setShortDescription($_POST['short_description']);
        $package->setDescription($_POST['description']);
        $package->setFeaturedImage($_POST['featured_image']);
        $package->setObservations($_POST['observations']);
        $package->setCustomOrder($_POST['custom_order']);
        $package->setPrice($_POST['price']);

        $result = $this->packageRepository->update($package);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
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

    /**
     * @param $id
     * @return bool
     */
    public function deletePackage($id) {

        $response = array(
            'success' => false
        );

        $package = new Package();
        $package->setId($id);

        $result = $this->packageRepository->remove($package);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
    }

}

new EntitiesController;