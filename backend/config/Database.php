<?php

class Database
{
    private static $host = "localhost";
    private static $database_name = "pim";
    private static $username = "root";
    private static $password = "";

    public static $conn = null;

    public static function getConnection()
    {
        if(isset(self::$conn)){
            return self::$conn;
        }
        return self::createConnection();
    }

    private static function createConnection()
    {
        try {
            self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$database_name, self::$username, self::$password);
            self::$conn->exec("set names utf8");
        } catch (PDOException $e) {
            die("Database could not be connected: " . $e->getMessage());
        }
        return self::$conn;
    }
}
