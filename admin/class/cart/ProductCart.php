<?php

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
    private static $cart = [];

    /**
     * Sets a new cart to the cookies session
     */
    private static function storeCart() {
        //self::$wp_session[self::KEY_NAME] = base64_encode(json_encode(self::$cart));
        //CustomCookie::set(self::KEY_NAME, self::size());

        CustomCookie::set(self::KEY_NAME, base64_encode(json_encode(self::$cart)));
        //CustomCookie::set(self::KEY_NAME, json_encode(self::$cart));
    }

    /**
     * Retrieves the cart from the cookies, and
     * sets up the control static php variables registering the products
     */
    private static function loadCart() {
        //self::$cart = json_decode(base64_decode(self::$wp_session[self::KEY_NAME]), true);
        //CustomCookie::set(self::KEY_NAME, self::size());

        self::$cart = json_decode($_COOKIE[self::KEY_NAME], true);
        CustomCookie::set(self::KEY_NAME, base64_decode(json_encode(self::$cart)));
        //CustomCookie::set(self::KEY_NAME, json_encode(self::$cart));
    }

    public static function init() {

        if ( !isset( $_COOKIE[self::KEY_NAME] )) {
            self::storeCart();
        }
        else {
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
     * @param $qty
     * @param $max
     */
    public static function addProduct(/*$serializedProduct,*/ $id, $class, $qty, $max) {

        self::$cart[$class][$id] = [
            //'serializedProduct' => $serializedProduct,
            'qty' => $qty,
            //'max' => $max
        ];

        self::storeCart();
    }

    /**
     * @param $id
     * @param $class
     */
    public static function removeProduct($id, $class) {
        unset(self::$cart[$class][$id]);
        self::storeCart();
    }

    /**
     * @param $id
     * @param $class
     * @param $qty
     */
    public static function updateProduct($id, $class, $qty) {

        if ( isset( self::$cart[$class][$id] ) ) {

            if ( $qty == 0 ) {
                self::removeProduct($id, $class);
            }
            else {
                self::$cart[$class][$id]['qty'] = $qty;
            }

            self::storeCart();
        }

    }

    /**
     * @return array
     */
    public static function collect() {
        return self::$cart;
    }

    /**
     * Clears up the cart in memory, and
     * resets the cookie management
     */
    public static function clear() {
        self::$cart = [];
        self::storeCart();
    }

    /**
     * @return int
     *
     * Return the number of products.
     */
    public static function size() {

        $countProducts = 0;

        foreach(self::$cart as $key => $array) {
            $countProducts += count($array);
        }

        return $countProducts;
    }

    /**
     * @return bool
     */
    public static function isEmpty() {
        return self::size() == 0 ? true : false;
    }

    /**
     * For debugging/testing purposes.
     */
    public static function debug() {
        var_dump(self::$cart);
    }

}