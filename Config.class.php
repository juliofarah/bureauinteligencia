<?php
class Config
{
    private static $config;

    public static function get($item)
    {
        if ( isset(self::$config[$item]) )
            return self::$config[$item];

        require 'config.php';
        self::$config = $config;
        return isset(self::$config[$item]) ? self::$config[$item] : false;
    }
}
