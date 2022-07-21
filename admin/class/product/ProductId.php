<?php

use Ramsey\Uuid\Uuid;

/**
 * Class ProductId
 *
 * PHP final class: prevents overriding a method of the child classes just by the final prefix with the definition.
 */
final class ProductId implements JsonSerializable
{
    /** @var string */
    private $id;

    /**
     * @param $str
     * @constructor
     */
    private function __contruct($id) {

        if ( strlen( $id ) === 0 ) {
            throw new InvalidArgumentException('The given id should not be empty');
        }

        $this->id = $id;
    }

    private static function isValid($guid) {
        //$guid = 'A98C5A1E-A742-4808-96FA-6F409E799937';

        // preg_match => performs a regular expression match
        if (preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', $guid)) {
            var_dump('ok');
        } else {
            var_dump('not ok');
        }
    }

    /**
     * @param $str
     * @return ProductId
     */
    public static function fromString($str) {
        return new self($str);
    }

    /**
     * @return ProductId
     */
    public static function generate() {
        $id = Uuid::uuid4();
        return new self($id->toString());
    }

    /**
     * @param $productId
     * @return bool
     *
     * Inner auto validation method.
     */
    public function equals($productId) {
        return $this->id === $productId->id;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->__toString();
    }
}