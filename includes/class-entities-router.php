<?php

/**
 * Class EntitiesRouter
 */
class EntitiesRouter
{
    /**
     * match_request
     */
    public function match_request() {
        $page = $_GET['page'];
        $type = $_GET['type'];

        if (isset($page)) {
            switch ($page) {
                case 'packages':
                    include plugin_dir_path( dirname(__FILE__ ) ) . '\admin\pages\page-packages.php';
                    break;
                case 'add-package':
                    include plugin_dir_path( dirname(__FILE__ ) ) . '\admin\pages\page-add-package.php';
                    break;
                default:
                    include plugin_dir_path( dirname(__FILE__ ) ) . '\admin\partials\entities-admin-display.php';
                    break;
            }
        }
        else {
            include plugin_dir_path( dirname(__FILE__ ) ) . '\admin\pages\page-packages.php';
        }
    }
}