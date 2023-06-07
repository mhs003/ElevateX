<?php
class Config
{
    private static $config_file = __DIR__ . '/../../Config.php';

    public static function getApp(string $key = null): string|int|bool|array
    {
        $conf = self::_parse();
        if ($key != null) {
            return $conf['app'][$key];
        }
        return $conf['app'];
    }

    public static function getDb(string $key = null): string|int|bool|array
    {
        $conf = self::_parse();
        if ($key !== null) {
            return $conf['db'][$key];
        }
        return $conf['db'];
    }

    public static function get(string $cat, string $key = null): string|int|bool|array
    {
        $conf = self::_parse();
        if ($conf[$cat]) {
            if ($key !== null) {
                return $conf[$cat][$key];
            }
            return $conf[$cat];
        }
    }

    private static function _parse(): array
    {
        require self::$config_file;
        return $Config;
    }
}