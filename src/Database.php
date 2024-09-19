<?php

namespace App;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new \mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
            if (self::$connection->connect_error) {
                die('Kapcsolódási hiba: ' . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }
}
