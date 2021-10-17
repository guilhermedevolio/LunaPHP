<?php


namespace Gui\Mvc\Core;

class Config {
    private static array $config = [];

    public static function set(string $name, $val) {
        self::$config[$name] = $val;
    }


    public static function get(string $name) {
        if(isset(self::$config[$name])) {
            return self::$config[$name];
        }

        return null;
    }
}