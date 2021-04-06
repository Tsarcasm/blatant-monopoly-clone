<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/data.php";
require_once "../model/interpreter.php";

$bases = Base::getAll();
if (count($bases) != 1) {
    error("Unsupported number of bases");
}

$base = $bases[0];
$base_arr = (array) $base;

$farms = $base->getFarms();
$base_arr["farms"] = [];

foreach ($farms as $farm) {
    $farm_arr = (array) $farm;
    $farm_arr["last_contact"] = $farm->getLastContact();
    $farm_arr["machines"] = [];
    foreach ($farm->getMachines() as $machine) {
        $machine_arr = (array) $machine;
        $machine_arr["last_contact"] = $machine->getLastContact();
        $data = $machine->getData(2);
        array_shift($data);
        
        $machine_arr["segments"] = [];
        if (count($data) > 0) {
            $machine_arr["segments"] = [];
            foreach ($data[0]->getSegments() as $seg) {
                array_push($machine_arr["segments"], $seg->data);
            }
        }
        $machine_arr["interpreters"] = [];
        $machine_arr["sensors"] = [];

        foreach ($machine->getSensors() as $sensor) {
            $sensor_arr = (array) $sensor;
            $interp = $sensor->getInterpreter();
            if ($interp != null) {
                $interp_arr = (array) $interp;
                // var_dump($interp_arr);
                // echo "<br>";
                $interp_type = $interp->getInterpreterType();
                $interp_arr["type"] = $interp_type;
                $interp_arr["data"] = [];
                if (count($data) > 0) {
                    $segs = $data[0]->getSegments();
                    $seg_slice = array_slice($segs, $sensor->getSegmentRange()[0], $sensor->num_segments);
                    $interp_arr["data"] = $interp->applyFunction($seg_slice);
                    $sensor_arr["data"] = $interp->applyFunction($seg_slice);
                    $sensor_arr["units"] = $interp_type->units;
                }
                array_push($machine_arr["interpreters"], $interp_arr);
            }
            array_push($machine_arr["sensors"], $sensor_arr);
        }

        if (count($data) > 0) {
            $data = $data[0];

            $data_arr = (array) $data;
            $data_arr["segments"] = [];
            foreach ($data->getSegments() as $s) {
                array_push($data_arr["segments"], $s->data);
            }
            $machine_arr["data"] = $data_arr;
        }

        array_push($farm_arr["machines"], $machine_arr);
    }
    array_push($base_arr["farms"], $farm_arr);
}

echo json_encode($base_arr);
