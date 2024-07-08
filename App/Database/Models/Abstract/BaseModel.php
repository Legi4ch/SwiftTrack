<?php

namespace app\Database\Models\Abstract;

abstract class BaseModel
{
    protected string $tableName;
    protected array $fields = array();

    public function migrate(): bool
    {
        return true;
    }


    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /*
     * $orderAr - simple array for ex array ("fieldName"=>"asc", "fieldName2"=>"desc")
     * $whereAr - array of arrays, where key is field name and value of  key is an array with conditions for sql where clause
     * example array( array( "field1","!=","12" ), array( "and field2",">","10" ) )
     * this will transform to where field1 !=12 and field2 > 10
     * this can be used without prepare params
     */


    private function setQueryFields(array $fieldsList = null):string {
        $fields = "";
        if (!is_array($fieldsList) || count($fieldsList) == 0) {
            return  "*";
        } else {
            foreach ($fieldsList as $field) {
                $fields .= $field.", ";
            }
            return substr($fields,0,-2)." ";
        }
    }

    private function setWhereClause(array $whereAr = null):string {
        if (is_array($whereAr) && count($whereAr) > 0) {
            $where = " where";
            foreach ($whereAr as $key=>$conditions) {
                $where .= " $conditions[0] $conditions[1] '$conditions[2]'";
            }
            return $where." ";
        } else {
            return " ";
        }

    }

    private function setOrder(array $orderAr = null):string {
        if (is_array($orderAr) && count($orderAr) > 0) {
            $result = " order by";
            foreach ($orderAr as $field=>$order) {
                $result .= " $field $order,";
            }
            return substr($result,0,-1);
        } else {
            return " ";
        }
    }

    private function setJoin(array $ojoinAr = null):string {
        if (is_array($ojoinAr) && count($ojoinAr) > 0) {
            $result = "";
            foreach ($ojoinAr as $table=>$clause) {
                $result .= " join $clause[0] $clause[1]";
            }
            return $result;
        } else {
            return " ";
        }
    }


    public function getSelectSqlInstructions(array $fieldsList=null, array $whereAr=null, array $orderAr=null, bool $distinct = false):string {
        $fields = $this->setQueryFields($fieldsList);
        $where = $this->setWhereClause($whereAr);
        $order = $this->setOrder($orderAr);
        $dist = $distinct ?"distinct":"";
        return "select $dist $fields from ".$this->getTableName()." $where $order";
    }

    public function getSelectJointSqlInstructions(array $fieldsList=null, array $joinAr, array $whereAr=null, array $orderAr=null, string $mainAlias, bool $distinct = false):string {
        $fields = $this->setQueryFields($fieldsList);
        $where = $this->setWhereClause($whereAr);
        $order = $this->setOrder($orderAr);
        $join = $this->setJoin($joinAr);
        $dist = $distinct ?"distinct":"";
        return "select $dist $fields from ".$this->getTableName()." as $mainAlias $join $where $order";
    }

    public function getDeleteSqlInstructions() {
        return "delete from ".$this->getTableName()." where id = :id";
    }

    // make sql for insert
    public function getInsertSqlInsructions():string {
        //METHOD NOT FINISHED
        $fields = "";
        $values = "";
        foreach($this->getFields() as $key=>$value) {
            $fields .= "`$key`,";
            $values .= ":$key,";
        }
        return "insert into ".$this->getTableName()." (".substr($fields,0,-1).") values (".substr($values,0,-1).")";
    }


    // make params array for insert&update with PDO
    //TO-DO need to add check keys of model and array
    public function getParamsForQuery(array $valuesAr, int $id=0):array {
        $result = array();
        foreach ($valuesAr as $field=>$value) {
            $result[":$field"] = $value;
        }
        if ($id > 0) {
            $result[":id"] = $id;
        }
        return $result;
    }


    // make sql for update with user fields and values array
    function getUpdateSqlInstructions(array $fieldsAr, array $whereAr = null):string {
        $result = "update ".$this->getTableName()." set";
        foreach ($fieldsAr as $field => $value) {
            $result .= " $field = :$field,";
        }

        if (isset($whereAr) && is_array($whereAr)) {
            $where = $this->setWhereClause($whereAr);
        } else {
            $where = " where id = :id";
        }

        //return substr($result,0,-1)." where id = :id";
        return substr($result,0,-1).$where;
    }

}