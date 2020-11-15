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

class Machine_Sensor extends Entity
{
    public $machine_pk;
    public $sensor_type_pk;
}

class Data extends Entity
{
    public $machine_sensor_pk;
    public $value;
    public $timestamp;

}
