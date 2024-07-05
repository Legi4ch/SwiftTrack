<?php

namespace App\Database\Models;

use app\Database\Models\Abstract\BaseModel;

class SampleModel extends BaseModel
{
    /*
     * id не нужен в наборе полей, подразумевается что это всегда id и всегда autoincrement
     */


    protected string $tableName = "test_table";
    protected array $fields = array(
        "name" => "string",
        "value" => "string",
    );


    //you can define own methods for model if you need
    public static function getUid($length = 5) {
        $bytes = random_bytes($length);
        return substr(bin2hex($bytes), 0, $length);
    }
}