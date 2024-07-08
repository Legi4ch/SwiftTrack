<?php

namespace App\Database;

use App\Database\Interfaces\Connectable;
use Config\Config;
use Config\DbConfig;
use PDO;
use PDOException;


final class MysqlConnection implements Connectable
{

    private static ?PDO $dbInstance = null;


    private function __construct()
    {
        try {
            $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PWD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbInstance = $db;
        } catch (PDOException $e) {
            error_log("PDO create error: " . $e->getMessage() . " >> " . $e->getCode());
        }
    }

    private static function getInstance(): PDO
    {
        if (self::$dbInstance === null) {
            new MysqlConnection();
        }
        return self::$dbInstance;
    }

    public static function getConnection(): PDO
    {
        return self::getInstance();
    }


}

