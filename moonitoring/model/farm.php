<?php
require_once "entity.php";
class Farm extends Entity
{
    public $base_pk;
    public $h_id;
    public $name;
    public $location;

    // const SELECT_STR = "SELECT pk, base_pk, h_id, name, location FROM farm";
    // protected static function selectStr()
    // {
    //     return "SELECT pk, base_pk, h_id, name, location FROM farm";
    // }

    // protected static function objFromRow($row)
    // {
    //     $farm = new Farm();
    //     $farm->pk = $row["pk"];
    //     $farm->base_pk = $row["base_pk"];
    //     $farm->h_id = $row["h_id"];
    //     $farm->name = $row["name"];
    //     $farm->location = $row["location"];
    //     return $farm;
    // }

    // protected static function updateStr()
    // {
    //     return "UPDATE farm SET pk = ?, base_pk = ?, h_id = ?, name = ?, location = ?";
    // }

    // protected static function objToRow($obj)
    // {
    //     return [
    //         $obj->pk,
    //         $obj->base_pk,
    //         $obj->h_id,
    //         $obj->name,
    //         $obj->location,
    //     ];
    // }
}
