<?php

require_once "connection.php";

abstract class Entity
{
    public $pk;

    // Instantiate an entity from an array
    protected static function objFromRow($row) {
        $class_name = get_called_class();
        $obj = new $class_name();
        foreach ($row as $key => $value) {
            $obj->$key = $value;
        }
        return $obj;
    }

    // Return an array of all properties and values of an entity
    protected static function objToRow($obj) {
        $fields = get_class_vars(get_called_class());
        $arr = [];
        foreach ($fields as $name => $value) {
            array_push($arr, $value);
        }
        return $arr;
    }

    // Generate an sql select string 
    private static function selectStr()
    {
        $class_name = get_called_class();
        $table_name = strtolower($class_name);
        $fields = get_class_vars(get_called_class());
        $str = "SELECT ";

        foreach ($fields as $name => $value) {
            $str = $str . $name . ",";
        }
        $str = rtrim($str, ',');
        return $str . " FROM " . $table_name;
    }

    // Generate an sql update string
    private static function updateStr()
    {
        $class_name = get_called_class();
        $table_name = strtolower($class_name);
        $fields = get_class_vars(get_called_class());
        $str = "SELECT " . $table_name . " SET ";

        foreach ($fields as $name => $value) {
            $str = $str . $name . " = ?,";
        }
        $str = rtrim($str, ',');
        return $str;
    }

    public static function getWhere($condition, $variables)
    {
        $pdo = Database::getConnection();
        $sql = static::selectStr() . " WHERE " . $condition;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($variables);
        $row = $stmt->fetch();
        return static::objFromRow($row);
    }

    public static function get($pk)
    {
        return static::getWhere("pk = ?", [$pk]);
    }

    public static function getAllWhere($condition, $variables)
    {
        $pdo = Database::getConnection();
        $sql = static::selectStr() . " WHERE " . $condition;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($variables);
        $entities = array();
        while ($row = $stmt->fetch()) {
            $obj = static::objFromRow($row);
            array_push($entities, $obj);
        }

        return $entities;
    }
    public static function getAll()
    {
        $pdo = Database::getConnection();
        $sql = static::selectStr();
        echo $sql;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $entities = array();

        while ($row = $stmt->fetch()) {
            $obj = static::objFromRow($row);
            array_push($entities, $obj);
        }
        return $entities;
    }

    public static function updateWhere($entity, $condition, $variables)
    {
        $pdo = Database::getConnection();
        $sql = static::updateStr() . " WHERE " . $condition;
        return $pdo->prepare($sql)->execute(array_merge(static::objToRow($entity), $variables));
    }

    public function save()
    {
        static::updateWhere($this, "pk = ?", [$this->pk]);
    }

    
    
}
