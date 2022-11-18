<?php

namespace Entities\Includes;

/**
 * Class EntitiesRouter
 */
class EntitiesRouter
{
    /**
     * match_request
     */
    public function match_request()
    {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            //$type = $_GET['type'];

            $directory = plugin_dir_path(dirname(__FILE__)) . '/admin/pages';

            switch ($page) {
                case 'packages':
                    include $directory .'/page-packages.php';
                    break;
                case 'add-package':
                    include $directory . '/page-add-package.php';
                    break;
                case 'hotels':
                    include  $directory . '/page-hotels.php';
                    break;
                case 'add-hotel':
                    include  $directory . '/page-add-hotel.php';
                    break;
                case 'activities':
                    include  $directory . '/page-activities.php';
                    break;
                case 'add-activity':
                    include  $directory . '/page-add-activity.php';
                    break;
                case 'flights':
                    include  $directory . '/page-flights.php';
                    break;
                case 'add-flight':
                    include  $directory . '/page-add-flight.php';
                    break;
                case 'comments':
                    include  $directory . '/page-comments.php';
                    break;
                default:
                    include  plugin_dir_path(dirname(__FILE__)) . '/admin/pages/entities-admin-display.php';
                    break;
            }
        } else {
            include  plugin_dir_path(dirname(__FILE__)) . '/admin/pages/entities-admin-display.php';
        }
    }
}
