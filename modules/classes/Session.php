<?php
class Session
{
    public static function isset($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key)
    {
        return self::isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function remove($key)
    {
        $_SESSION[$key] = '';
    }

    public static function unset()
    {
        session_unset();
    }

    public static function destroy()
    {
        session_destroy();
    }

}
