<?php

namespace Entities\Controllers;

use Entities\Domain\product\Package;
use Entities\Services\PackageRepository;
use Exception;

/**
 * Class PackagesController
 */
class PackagesController extends MasterController
{
    private PackageRepository $packageRepository;

    public function __construct()
    {
        $this->packageRepository = PackageRepository::getInstance();

        add_action('wp_ajax_entities_packages_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_packages_controller', array($this, 'ajax'));
    }

    public function ajax()
    {
        if (isset($_POST['type'])) {
            $action = $_POST['type'];

            switch ($action) {
                case "createPackage":
                    echo $this->createPackage();
                    break;
                case "getPackages":
                    echo $this->getPackages(true);
                    break;
                case "updatePackage":
                    if (isset($_POST['id'])) {
                        echo $this->updatePackage($_POST['id']);
                    }
                    break;
                case "updateGridPackage":
                    echo $this->updateGridPackage();
                    break;
                case "deletePackage":
                    if (isset($_POST['id'])) {
                        echo $this->deletePackage($_POST['id']);
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
     * @return false|string
     */
    public function createPackage()
    {
        $response = array('success'=> false);

        // creation package object
        $package = new Package();
        //$package->setId($this->packageRepository->generateId()); // generating id as uuid at the application logic
        $package->setStatus($_POST['status']);
        $package->setName($_POST['name']);
        $package->setShortDescription($_POST['short_description']);
        $package->setDescription($_POST['description']);
        $package->setFeaturedImage($_POST['featured_image']);
        $package->setObservations($_POST['observations']);
        $package->setCustomOrder($_POST['custom_order']);
        $package->setPrice($_POST['price']);

        $result = $this->packageRepository->add($package);
        if ($result) {
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
    public function getPackageById($id, bool $json_encode = false)
    {
        $package = $this->packageRepository->findById($id);

        if ($json_encode) {
            header('Content-type: application/json');
            return json_encode($package);
        }

        return $package;
    }

    /**
     * @param bool $json_encode
     * @return array|false|string
     */
    public function getPackages(bool $json_encode = false)
    {
        $packages = array();

        try {
            $packages = $this->packageRepository->findAll();
        } catch (Exception $e) {
        }

        if ($json_encode) {
            header('Content-type: application/json');
            return json_encode($packages);
        }

        return $packages;
    }

    /**
     * @param $id
     * @return false|string
     */
    public function updatePackage($id)
    {
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
        if ($result) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
    }

    /**
     * @return false|string
     */
    public function updateGridPackage()
    {
        if (isset($_POST['package'])) {
            $package_data = json_decode(stripslashes($_POST['package']));
            $package = Package::withRow($package_data);

            $result = $this->packageRepository->update($package);
            if ($result) {
                $response['success'] = true;
            }

            return json_encode($package);
        }

        exit;
    }

    /**
     * @param $id
     * @return false|string
     */
    public function deletePackage($id)
    {
        $response = array('success' => false);

        $package = new Package();
        $package->setId($id);

        $result = $this->packageRepository->remove($package);
        if ($result) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);
    }
}

//new EntitiesController;
