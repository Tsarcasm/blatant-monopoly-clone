<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/data.php";

$bases = Base::getAll();
if (count($bases) != 1) {
    error("Unsupported number of bases");
}

$base = $bases[0];
$base_arr = (array)$base;

$farms = $base->getFarms();
$base_arr["farms"] = [];

foreach ($farms as $farm) {
    $farm_arr = (array)$farm;
    $farm_arr["machines"] = [];
    foreach ($farm->getMachines() as $machine) {
        $machine_arr = (array)$machine;
        $machine_arr["sensors"] = $machine->getSources();
        array_push($farm_arr["machines"], $machine_arr);
    }
    array_push($base_arr["farms"], $farm_arr);
}


echo json_encode($base_arr);
