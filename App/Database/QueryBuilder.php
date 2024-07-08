<?php

namespace App\Database;

use app\Database\Models\Abstract\BaseModel;
use App\Exceptions\QueryBuilderExceptions;
use Config\Config;
use PDO;
use PDOException;


class QueryBuilder
{
    private BaseModel $model;
    private PDO $instance;


    public function __construct($model, $dbConnect)
    {
        if (in_array("App\Database\Interfaces\Connectable", class_implements($dbConnect))) {
            $this->model = new $model();
            $this->instance = $dbConnect::getConnection();
        } else throw new QueryBuilderExceptions(Config::QUERY_BUILDER_CREATE_ERROR);
    }


    public function getAll(array $order = null):array {
        $return = array();
        $sql = $this->model->getSelectSqlInstructions($order);
        $query = $this->instance->prepare($sql);
        $query->execute();
        return $query->fetchAll((PDO::FETCH_ASSOC));
    }

    public function getAllWhere(array $order = null, array $where = null):array {
        $sql = $this->model->getSelectSqlInstructions(null,$where,$order);
        $query = $this->instance->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFieldsWhere(array $fields = null, array $order = null, array $where = null):array {
        $sql = $this->model->getSelectSqlInstructions($fields,$where,$order);
        $query = $this->instance->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSelectWithJoin(array $fieldsAr, array $joinAr, array $whereAr, array $orderAr, $alias):array {
        $sql = $this->model->getSelectJointSqlInstructions($fieldsAr,$joinAr, $whereAr, $orderAr, $alias);
        $query = $this->instance->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRowsByFieldValue(string $fieldName, $fieldValue):array {
        $where = array(array($fieldName,"=", $fieldValue));
        $sql = $this->model->getSelectSqlInstructions(null,$where);
        $query = $this->instance->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRowByValue(string $fieldName, $fieldValue):array {
        $where = array(array($fieldName,"=", $fieldValue));
        $sql = $this->model->getSelectSqlInstructions(null,$where);
        $query = $this->instance->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : array();
    }


    // return last id value when ok
    public function insert(array $valuesAr):int {
        $lastId = 0;
        $sql = $this->model->getInsertSqlInsructions();
        $params = $this->model->getParamsForQuery($valuesAr);
        $query = $this->instance->prepare($sql);
        try {
            $this->instance->beginTransaction();
            $query->execute($params);
            $lastId = $this->instance->lastInsertId();
            $this->instance->commit();
        } catch (PDOException $e) {
            error_log("Insertion error on ".$this->model->getTableName(). " table with message : ".$e->getMessage());
            $this->instance->rollBack();
            if ($e->errorInfo[1] == 1062) {
                return -1062; //duplicate error
            } else {
                return -1; //other error
            }
        }
        return $lastId;
    }

    public function delete(int $id):bool {
        $result = false;
        $sql = $this->model->getDeleteSqlInstructions();
        $params = array(":id"=>$id);
        $query = $this->instance->prepare($sql);
        try {
            $this->instance->beginTransaction();
            $query->execute($params);
            $this->instance->commit();
            $result = true;
        } catch (PDOException $e) {
            $this->instance->rollBack();
        }
        return $result;
    }

    public function update(int $id, array $updateAr):bool {
        $result = false;
        $params = $this->model->getParamsForQuery($updateAr, $id);
        $sql = $this->model->getUpdateSqlInstructions($updateAr);
        $query = $this->instance->prepare($sql);
        try {
            $this->instance->beginTransaction();
            $query->execute($params);
            $this->instance->commit();
            $result = true;
        } catch (PDOException $e) {
            $this->instance->rollBack();
        }
        return $result;
    }

    public function updateWhere(array $whereArr, array $updateAr):bool {
        $result = false;
        $params = $this->model->getParamsForQuery($updateAr);
        $sql = $this->model->getUpdateSqlInstructions($updateAr,$whereArr);
        $query = $this->instance->prepare($sql);
        try {
            $this->instance->beginTransaction();
            $query->execute($params);
            $this->instance->commit();
            $result = true;
        } catch (PDOException $e) {
            $this->instance->rollBack();
        }
        return $result;
    }


}

