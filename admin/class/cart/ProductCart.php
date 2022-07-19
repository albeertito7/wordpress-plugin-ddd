<?php

/**
 * Class ProductCart
 *
 * Static collection/repository of products
 */
class ProductCart
{
    const KEY_NAME = "entities_cart";

    private static $wp_session;
    private static $cart = [];
    private static $it;

    private static function storeCart() {
        self::$wp_session[self::KEY_NAME] = base64_encode(json_enconde(Self::$cart));
        CookieOne::set(Self::KEY_NAME, Self::size());
    }

    private static function loadCart() {
        self::$cart = json_decode(base64_decode(self::$wp_session[Self::KEY_NAME]), true);
        CookieOne::set(self::KEY_NAME, self::size());
    }

    /**
     * @return int
     */
    public static function size() {
        return count(self::$cart);
    }

    /**
     * @return bool
     */
    public static function isEmpty() {
        return self::size() == 0 ? true : false;
    }

    /**
     * For debugging purposes.
     */
    public static function debug() {
        var_dump(self::$cart);
    }

}