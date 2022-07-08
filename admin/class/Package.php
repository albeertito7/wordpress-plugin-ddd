<?php

/**
 * Class Package
 */
class Package extends Product implements JsonSerializable
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
    public static function withRow($row)
    {
        $instance = Utils::objectToObject(parent::withRow($row), get_class());
        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

}