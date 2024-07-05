<?php

namespace App\Database\Interfaces;

use PDO;

interface Connectable
{
    public static function getConnection(): PDO;
}