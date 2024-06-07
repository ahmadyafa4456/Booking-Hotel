<?php
namespace App\Cores;

require_once __DIR__ . "/../Config/Config.php";
class Database
{
    private static ?\PDO $pdo = null;
    public static function getConnection()
    {
        if (self::$pdo == null) {
            self::$pdo = new \PDO(DB_URL, DB_USER, DB_PASSWORD);
        }
        return self::$pdo;
    }
}