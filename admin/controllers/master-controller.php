<?php

/**
 * Class MasterController
 */
class MasterController {

    public function ajax()
    {
        $action = $_POST['type'];

        switch ($action)
        {
            default:
                echo "Silence is golden";
                break;
        }

        exit;
    }
}
