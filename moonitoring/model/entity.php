<?php

require_once "connection.php";

abstract class Entity
{
    public $pk;

    // Instantiate an entity from an array
    protected static function objFromRow($row)
    {
        if ($row == false) return null;
        $class_name = get_called_class();
        $obj = new $class_name();
        
        foreach ($row as $key => $value) {
            $obj->$key = $value;
        }
        return $obj;
    }

    // Return an array of all properties and values of an entity
    protected static function objToRow($obj)
    {
        $fields = get_object_vars($obj);
        $arr = [];
        foreach ($fields as $name => $value) {
            array_push($arr, $obj->$name);
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

    // Generate an insert or update string
    private static function insertStr()
    {
        /*
        INSERT INTO base (...) VALUES (?,?...")
        ON DUPLICATE KEY UPDATE
        name = VALUES (name),
        h_id = VALUES (h_id)...
         */
        $class_name = get_called_class();
        $table_name = strtolower($class_name);
        $fields = get_class_vars(get_called_class());
        $str = "INSERT INTO " . $table_name . " (";
        foreach ($fields as $name => $value) {
            $str = $str . $name . ",";
        }
        $str = rtrim($str, ',') . ") VALUES (";
        foreach ($fields as $name => $value) {
            $str = $str . "?,";
        }
        $str = rtrim($str, ',') . ") ";
        $str = $str . "ON DUPLICATE KEY UPDATE ";
        foreach ($fields as $name => $value) {
            $str = $str . " $name = VALUES ( $name ),";
        }
        return rtrim($str, ',');
    }

    private static function deleteStr()
    {
        // DELETE FROM table_name WHERE condition;
        $class_name = get_called_class();
        $table_name = strtolower($class_name);
        return "DELETE FROM $table_name ";
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

    public static function getAllQuery($query, $variables) {
        $pdo = Database::getConnection();
        $sql = static::selectStr() . " " . $query;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($variables);
        $entities = array();
        while ($row = $stmt->fetch()) {
            $obj = static::objFromRow($row);
            array_push($entities, $obj);
        }

        return $entities;
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
        return static::getAllWhere("1=1", []);
    }

    public static function updateWhere($entity, $condition, $variables)
    {
        $pdo = Database::getConnection();
        $sql = static::updateStr() . " WHERE " . $condition;
        return $pdo->prepare($sql)->execute(array_merge(static::objToRow($entity), $variables));
    }

    public static function insertOrUpdate($entity)
    {
        $pdo = Database::getConnection();
        $sql = static::insertStr();
        $pdo->prepare($sql)->execute(static::objToRow($entity));
    }

    public static function deleteWhere($condition, $variables)
    {
        $pdo = Database::getConnection();
        $sql = static::deleteStr() . " WHERE " . $condition;
        return $pdo->prepare($sql)->execute($variables);
    }

    public function save()
    {
        static::insertOrUpdate($this);
    }

    public function delete()
    {
        if (static::deleteWhere("pk = ?", [$this->pk])) {
            foreach ($this as $key => $value) {
                $this->$key = null; //set to null
            }
        }

    }

}
