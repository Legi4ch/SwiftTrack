<?php

namespace App\Database;

use App\Database\Interfaces\Connectable;
use Config\DbConfig;
use PDO;
use PDOException;


final class SqliteConnection implements Connectable
{

    private static ?PDO $dbInstance = null;


    private function __construct()
    {
        try {
            $db = new PDO("sqlite:".DbConfig::DB_FILE);
            self::$dbInstance = $db;
        } catch (PDOException $e) {
            error_log("PDO create error: " . $e->getMessage() . " >> " . $e->getCode());
        }
    }

    private static function getInstance(): PDO
    {
        if (self::$dbInstance === null) {
            new SqliteConnection();
        }
        return self::$dbInstance;
    }

    public static function getConnection(): PDO
    {
        return self::getInstance();
    }


}

