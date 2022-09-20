<?php

namespace Entities\Domain\cart;

/**
 * Class ProductCart
 *
 * Static collection/repository of products
 */
class ProductCart
{
    const KEY_NAME = "entities_cart";

    // static in memory
    //private static $wp_session;
    private static array $cart = [];

    /**
     * Sets a new cart to the cookies session.
     */
    private static function storeCart()
    {
        //self::$wp_session[self::KEY_NAME] = base64_encode(json_encode(self::$cart));

        CustomCookie::set(self::KEY_NAME, json_encode(self::$cart));
        //CustomCookie::set(self::KEY_NAME, base64_encode(json_encode(self::$cart)));
    }

    /**
     * Retrieves the cart from the cookies, and
     * sets up the control static php variables registering the products.
     */
    private static function loadCart()
    {
        //self::$cart = json_decode(base64_decode(self::$wp_session[self::KEY_NAME]), true);

        $decoded = json_decode($_COOKIE[self::KEY_NAME], true);
        //$decoded = json_decode(base64_decode($_COOKIE[self::KEY_NAME]), true);
        if (!$decoded) {
            self::$cart = [];
        } else {
            self::$cart = $decoded;
        }

        //self::$cart = json_decode(base64_decode($_COOKIE[self::KEY_NAME]), true);

        CustomCookie::set(self::KEY_NAME, json_encode(self::$cart));
        //CustomCookie::set(self::KEY_NAME, base64_encode(json_encode(self::$cart)));
    }

    /**
     * @return void
     *
     * Initiates the product cart,
     * setting up the cart collection instance upon the custom cookie,
     * as it creates a new one or loads it if exists.
     */
    public static function init()
    {
        if (!isset($_COOKIE[self::KEY_NAME])) {
            self::storeCart();
        } else {
            self::loadCart();
        }

        /*self::$wp_session = WP_Session::get_instance();

        if ( !isset( self::$wp_session[self::KEY_NAME] ) ) {
            self::storeCart();
        } else {
            self::loadCart();
        }*/
    }

    /**
     * @param $id
     * @param $class
     * @param $quantity
     * @return int
     *
     * Adds a new product to the cart.
     * If the product is already added => updates the properties.
     */
    public static function addProduct(/*$serializedProduct,*/ $id, $class, $quantity): int
    {
        self::$cart[$class][$id] = [
            //'serializedProduct' => $serializedProduct,
            'qty' => $quantity
        ];

        self::storeCart();

        return self::size();
    }

    /**
     * @param $id
     * @param $class
     *
     * Removes a product from the id and class.
     */
    public static function removeProduct($id, $class)
    {
        unset(self::$cart[$class][$id]);
        self::storeCart();
    }

    /**
     * @param $id
     * @param $class
     * @param $quantity
     *
     * Updates the properties of a specific product.
     */
    public static function updateProduct($id, $class, $quantity)
    {
        if (isset(self::$cart[$class][$id])) {
            if ($quantity == 0) {
                self::removeProduct($id, $class);
            } else {
                self::$cart[$class][$id]['qty'] = $quantity;
            }

            self::storeCart();
        }
    }

    /**
     * @return array
     *
     * Retrieves the actual cart.
     */
    public static function collect(): array
    {
        return self::$cart;
    }

    /**
     * @return void
     *
     * Clears up the cart in memory, and
     * resets the cookie management.
     */
    public static function clear()
    {
        self::$cart = [];
        self::storeCart();
    }

    /**
     * @return int
     *
     * Return the number of products.
     */
    public static function size(): int
    {
        $countProducts = 0;

        foreach (self::$cart as $key => $product_array) {
            $countProducts += count($product_array);
        }

        return $countProducts;
    }

    /**
     * @return bool
     *
     * Checks if there are products or not added to the cart.
     */
    public static function isEmpty(): bool
    {
        return self::size() == 0;
    }

    /**
     * @return void
     *
     * For debugging/testing purposes.
     */
    public static function debug()
    {
        var_dump(self::$cart);
    }
}
