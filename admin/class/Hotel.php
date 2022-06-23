<?php

/**
 * Class Hotel
 */
class Hotel extends Product
{
    var $date_entrance;
    var $date_leave;

    /**
     * Product constructor.
     */
    private function __construct($object)
    {
        // pass
        /* Initializing class properties
        foreach($object as $property => $value) {
            $this->$property = $value;
        }*/
    }

    /**
     * @param $row
     * @return Product
     */
    public static function withRow($row)
    {
        /*$instance = new self(parent::withRow($row));
        $instance->date_entrance = $row->date_entrance;
        $instance->date_leave = $row->date_leave;
        return $instance;*/

        $instance = Utils::objectToObject(parent::withRow($row), get_class());

        $instance->date_entrance = $row->date_entrance;
        $instance->date_leave = $row->date_leave;

        return $instance;
    }

}