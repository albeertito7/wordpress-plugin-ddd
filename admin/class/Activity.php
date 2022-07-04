<?php

/**
 * Class Hotel
 */
class Activity extends Product
{
    // properties

    /**
     * Activity constructor.
     */
    public function __construct()
    {
        // pass
    }

    /**
     * @param $row
     * @return Activity
     */
    public static function withRow($row)
    {
        $instance = Utils::objectToObject(parent::withRow($row), get_class());
        return $instance;
    }

}