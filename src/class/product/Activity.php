<?php

namespace Entities\Domain\product;

use Entities\Domain\Utils;

/**
 * Class Activity
 */
class Activity extends Product
{
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
    public static function withRow($row): Activity
    {
        return Utils::objectToObject(parent::withRow($row), get_class());
    }
}
