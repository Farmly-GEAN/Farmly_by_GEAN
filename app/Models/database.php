<?php

class Database
{
    private static $conn;

    public static function connect()
    {
        if (!self::$conn) {
            self::$conn = new PDO(
                "pgsql:host=localhost;port=5432;dbname=Farmly",
                "postgres",
                "Aakash@1032",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }
        return self::$conn;
    }
}
