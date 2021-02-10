<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

$types = Interpreter_Type::getAll();

if (isset($_GET["field"])) {
    $types = array_column($types, $_GET["field"]);
}

// foreach ($farms as $farm) {
//     $farm_arr = (array)$farm;
//     $farm_arr["machines"] = [];
//     foreach ($farm->getMachines() as $machine) {
//         $machine_arr = (array)$machine;
//         $machine_arr["sensors"] = $machine->getSources();
//         array_push($farm_arr["machines"], $machine_arr);
//     }
//     array_push($base_arr["farms"], $farm_arr);
// }

echo json_encode($types);
