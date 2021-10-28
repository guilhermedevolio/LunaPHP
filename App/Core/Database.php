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
                echo "Falha ao estabelecer conexão com o banco de dados";
                die();
            }

        }
        return self::$pdo;
    }

}
