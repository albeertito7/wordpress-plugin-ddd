<?php

namespace Entities\Domain\cart;

/**
 * Class CustomCookie
 *
 * setCookie: defines a cookie to be sent along with the rest of the HTTP headers.
 * https://www.php.net/manual/en/function.setcookie.php
 *
 * Once the cookies have been set, they can be accessed on the next page load with the $_COOKIE array,
 * moreover cookie values may also exist in $_REQUEST.
 */
class CustomCookie
{
    const EXPIRY_TIME = 21600; // 21600 seconds => 360 minutes => 6 hours

    private static $cookies;

    private static $cookie_path;
    private static $cookie_domain;

    public static function init($cookie_path, $cookie_domain)
    {
        self::$cookie_path = $cookie_path;
        self::$cookie_domain = $cookie_domain;

        foreach ($_COOKIE as $key => $value) {
            self::$cookies[$key] = $value;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public static function exists($key): bool
    {
        return isset(self::$cookies[$key]);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        return self::$cookies[$key] ?? null;
    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     */
    public static function set($key, $value, int $expiry = self::EXPIRY_TIME)
    {
        setcookie($key, $value, time() + $expiry, self::$cookie_path, self::$cookie_domain);
        self::$cookies[$key] = $value;
    }

    /**
     * @param $key
     */
    public static function delete($key)
    {
        setcookie($key, "NULL", time() - self::EXPIRY_TIME * 10, self::$cookie_path, self::$cookie_domain);
        if (isset(self::$cookies[$key])) {
            unset(self::$cookies[$key]);
        }
    }
}
