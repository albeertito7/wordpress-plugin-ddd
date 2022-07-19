<?php

if ( !defined('COOKIEPATH') ) {
    define('COOKIEPATH', preg_replace('|https?://[^/]+|i', '', get_option('home') . '/' ) );
}

if ( !defined('COOKIE_DOMAIN') ) {
    define('COOKIE_DOMAIN', false);
}

/**
 * Class CustomCookie
 *
 * setCookie: defines a cookie to be sent along with the rest of the HTTP headers.
 *
 * Once the cookies have been set, they can be accessed on the next page load with the $_COOKIE array,
 * moreover cookie values may also exist in $_REQUEST.
 */
class CustomCookie {

    const EXPIRY_TIME = 21600;
    private static $cookies;

    public static function init() {
        foreach($_COOKIE as $k => $v) {
            self::$cookies[$k] = $v;
        }
    }

    public static function exists($key) {
        return isset(self::$cookies[$key]);
    }

    public static function get($key) {
        return isset(self::$cookies[$key]) ? self::$cookies[$key] : NULL;
    }

    public static function set($key, $value, $expiry = self::EXPIRY_TIME) {
        setcookie($key, $value,  time() + $expiry, COOKIEPATH, COOKIE_DOMAIN );
        self::$cookies[$key] = $value;
    }

    public static function delete($key) {
        setcookie($key, "NULL",  time() - self::EXPIRY_TIME * 10, COOKIEPATH, COOKIE_DOMAIN );
        if ( isset( self::$cookies[$key] ) ) {
            unset( self::$cookies[$key] );
        }
    }

}



