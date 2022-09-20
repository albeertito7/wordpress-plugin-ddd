<?php

namespace Entities\Controllers;

use Entities\Domain\cart\ProductCart;

/**
 * Class CartController
 */
class CartController extends MasterController
{
    public function __construct()
    {
        add_action('wp_ajax_entities_cart_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_cart_controller', array($this, 'ajax'));
    }

    public function ajax()
    {
        if (isset($_POST['type'])) {
            $action = $_POST['type'];

            switch ($action) {
                case "addProduct":
                    echo $this->addProduct();
                    break;
                case "deleteProduct":
                    $this->deleteProduct();
                    break;
                default:
                    parent::ajax();
                    break;
            }
        }

        exit;
    }

    public function addProduct()
    {
        if (isset($_POST['id']) && isset($_POST['class'])) {
            // parameters
            $id = $_POST['id'];
            $class = $_POST['class'];
            $qty = 1; //$_POST['qty'];
            $max = 1;

            // adding the id
            return ProductCart::addProduct($id, $class, $qty, $max);
        }
    }

    public function deleteProduct()
    {
        if (isset($_POST['id']) && isset($_POST['class'])) {
            // parameters
            $id = $_POST['id'];
            $class = $_POST['class'];

            // removing the id
            ProductCart::removeProduct($id, $class);
        }
    }
}

//new EntitiesCartController;
