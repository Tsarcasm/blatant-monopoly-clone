<?php
require_once "entity.php";
require_once "interpreter.php";

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
    public $hardware_index;
    public $sensor_type_pk;
    public $num_segments;
    public $enabled;
    public $description;

    public function getInterpreter() {
        return Sensor_Interpreter::getWhere("machine_sensor_pk = ?", [$this->pk]);
    }

    public function getSegmentRange() {
        $machine = Machine::get($this->machine_pk);
        $sensors = $machine->getSensors();
        $startSeg = 0;
        for ($i=0; $i < count($sensors); $i++) { 
            if ($sensors[$i]->pk == $this->pk) break;
            $startSeg += $sensors[$i]->num_segments;
        }

        return array($startSeg, $startSeg + $this->num_segments);
    }

}

class Machine_Segments extends Entity
{
    public $machine_pk;
    public $upload_token_pk;

    public function getSegments() {
        return Data_Segment::getAllWhere("machine_segments_pk = ?", [$this->pk]);
    }

}

class Data_Segment extends Entity
{
    public $machine_segments_pk;
    public $idx;
    public $data;
}

class Upload_Token extends Entity
{
    public $farm_pk;
    public $timestamp;
}