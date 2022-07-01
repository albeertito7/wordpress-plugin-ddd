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
    private function __construct($object)
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