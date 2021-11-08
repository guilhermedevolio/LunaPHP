<?php

namespace Gui\Mvc\Core;

class Database
{
    public static $pdo;

    public static function connect(): \PDO
    {

        $host = 'localhost';
        $db = 'LunaPHP';
        $password = '';
        $user = 'root';

        if (self::$pdo == null) {
            try {
                self::$pdo = new \PDO("mysql:host=$host;dbname=$db", $user, $password, array(PDO::ATTR_PERSISTENT => true));
            } catch (\Exception $e) {
                exit(json_encode(['code' => '500', 'message' => 'Failed to connect to database']));
            }

        }
        return self::$pdo;
    }

}
