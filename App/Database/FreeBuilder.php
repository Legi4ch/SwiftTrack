<?php

namespace App\Database;

use Config\Config;
use App\Exceptions\QueryBuilderExceptions;
use PDO;
use PDOException;


class FreeBuilder {

    private PDO $instance;
    public function __construct($dbConnect)
    {
        if (in_array("App\Database\Interfaces\Connectable", class_implements($dbConnect))) {
            $this->instance = $dbConnect::getConnection();
        } else throw new QueryBuilderExceptions(Config::QUERY_BUILDER_CREATE_ERROR);
    }

    public function getAll(int $id = 0): array {
        $sql = "SELECT * FROM test_table WHERE id > :id";
        $query = $this->instance->prepare($sql);
        $query->execute([":id" => $id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}