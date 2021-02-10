<?php
require_once "entity.php";

class Data_Type extends Entity
{
    public $name;
    public $unit;
}

class Sensor_Type extends Entity
{
    public $name;
    public $descripton;
    public $data_type_pk;
}

class Machine_Source extends Entity
{
    public $machine_pk;
    public $sensor_type_pk;
    public $hardware_index;
    public $description;
    public $num_segments;
    public $enabled;
}

class Data_Upload extends Entity
{
    public $machine_pk;
    public $timestamp;

    public function getSegments() {
        return Segment::getAllWhere("data_upload_pk = ?", [$this->pk]);
    }

}

class Segment extends Entity
{
    public $data_upload_pk;
    public $idx;
    public $data;

}
