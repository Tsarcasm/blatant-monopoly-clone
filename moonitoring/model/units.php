<?php
require_once "entity.php";
require_once "units.php";
class Base extends Entity
{
    public $h_id;
    public $name;
    public $ip_address;
    public $last_contact;

    public function getFarms()
    {
        return Farm::getAllWhere("base_pk = ?", [$this->pk]);
    }
}

class Farm extends Entity
{
    public $base_pk;
    public $h_id;
    public $name;
    public $location;
    public $last_contact;

    public function getMachines()
    {
        return Machine::getAllWhere("farm_pk = ?", [$this->pk]);
    }
}

class Machine extends Entity
{
    public $farm_pk;
    public $h_id;
    public $name;
    public $last_contact;

    public function getSensors()
    {
        return Machine_Sensor::getAllWhere("machine_pk = ?", [$this->pk]);
    }
}
