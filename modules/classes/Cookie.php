<?php
class Cookie
{
    public static function isset($key)
    {
        return isset($_COOKIE[$key]);
    }

    public static function get($key)
    {
        return self::isset($key) ? $_COOKIE[$key] : false;
    }

    public static function set($key, $value, $for = 30 * 24 * 60 * 60)
    {
        setcookie($key, $value, time() + $for);
    }

    public static function delete($key)
    {
        setcookie($key, '', 1);
    }
}
