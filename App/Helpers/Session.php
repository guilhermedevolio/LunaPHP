<?php

namespace Gui\Mvc\Helpers;

class Session {
    public static function get(string $name) {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return false;
    }

    public static function set(string $name, $val) {
        if(!isset($_SESSION[$name])) {
            return $_SESSION[$name] = $val;
        }

        return false;
    }
}