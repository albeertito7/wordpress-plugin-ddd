<?php

/**
 * Class Package
 */
class Package extends Product
{
    /**
     * Package constructor.
     */
    public function __construct()
    {
        // pass
    }

    /**
     * @param $row
     * @return Package
     */
    public static function withRow($row): Package
    {
        $instance = Utils::objectToObject(parent::withRow($row), get_class());
        return $instance;
    }
}