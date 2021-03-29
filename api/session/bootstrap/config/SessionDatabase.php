<?php


class SessionDatabase
{

    private static string $host = "83.98.243.187";
    private static string $db = "nts_site";
    private static string $username = "poweruser";
    private static string $password = "iMfFIg7gAxCmstc76KyQ";


//    private static string $host = "localhost";
//    private static string $db = "nts_site";
//    private static string $username = "projectuser";
//    private static string $password = "wgnd8b";

    private static $INSTANCE = null;

    private function __construct()
    {
    }

    public static function getInstance(): SessionDatabase
    {
        if (self::$INSTANCE == null)
            self::$INSTANCE = new SessionDatabase();
        return self::$INSTANCE;
    }

    public static function getConnection()
    {
        $conn = null;
        try {
            $conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db, self::$username, self::$password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOExeption $exception) {
            return "Conection Error: " . $exception->getMessage();
        }
        return $conn;
    }
}