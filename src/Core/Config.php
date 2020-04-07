<?php


namespace Core;


class Config
{
    private static $config;

    public static function init()
    {
        self::$config = require_once ROOT . '/configs/main.php';
    }


    public static function get($key)
    {
        $keys = explode('.', $key);
        $config = self::$config;
        foreach ($keys as $val) {
            if (isset($config[$val])) {
                $config = $config[$val];
            }
        }
        return $config;
    }

    public function set($key, $value)
    {

    }


}