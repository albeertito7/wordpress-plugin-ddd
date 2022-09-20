<?php

namespace Entities\Domain\product;

use Entities\Domain\Utils;

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
        return Utils::objectToObject(parent::withRow($row), get_class());
    }
}
