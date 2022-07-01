<?php

/**
 * Class Package
 */
class Package extends Product
{
    /**
     * Package constructor.
     */
    private function __construct($object)
    {
        // pass
    }

    /**
     * @param $row
     * @return Package
     */
    public static function withRow($row)
    {
        $instance = Utils::objectToObject(parent::withRow($row), get_class());
        return $instance;
    }

}