<?php

namespace Entities\Domain\product;

use Entities\Domain\Utils;

/**
 * Class Hotel
 */
class Hotel extends Product
{
    protected $date_entrance;
    protected $date_departure;

    /**
     * Hotel constructor.
     */
    public function __construct()
    {
        // pass
        /* Initializing class properties
        foreach($object as $property => $value) {
            $this->$property = $value;
        }*/
    }

    /**
     * @param $row
     * @return Hotel
     */
    public static function withRow($row): Hotel
    {
        /*$instance = new self(parent::withRow($row));
        $instance->date_entrance = $row->date_entrance;
        $instance->date_leave = $row->date_leave;
        return $instance;*/

        $instance = Utils::objectToObject(parent::withRow($row), get_class());

        $instance->date_entrance = $row->date_entrance;
        $instance->date_departure = $row->date_departure;

        return $instance;
    }
}
