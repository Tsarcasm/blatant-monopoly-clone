<?php
require_once "entity.php";
require_once "farm.php";
class Base extends Entity
{
    // const table_name = "Base";
    public $h_id;
    public $name;
    public $ip_address;

    // protected static function selectStr()
    // {
    //     return "SELECT pk, h_id, name, ip_address FROM base";
    // }
    
    // protected static function fieldNames() {
    //     return ["pk", "h_id", "name", "ip_address"];
    // }
    // protected static function tableName() {
    //     return "base";
    // }


    // protected static function objFromRow($row)
    // {
    //     $base = new Base();
    //     $base->pk = $row["pk"];
    //     $base->h_id = $row["h_id"];
    //     $base->name = $row["name"];
    //     $base->ip_address = $row["ip_address"];
    //     return $base;
    // }

    // // protected static function updateStr()
    // // {
    // //     return "UPDATE base SET pk = ?, h_id = ?, name = ?, ip_address = ?";
    // // }

    // protected static function objToRow($obj)
    // {
    //     return [
    //         $obj->pk,
    //         $obj->h_id,
    //         $obj->name,
    //         $obj->ip_address,
    //     ];
    // }

    public function farms()
    {
        return Farm::getAllWhere("base_pk = ?", [$this->pk]);
    }
}
