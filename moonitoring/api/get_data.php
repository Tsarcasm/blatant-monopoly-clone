<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/data.php";
require_once "../model/interpreter.php";

if (!isset($_GET["machine"])) {
    error("No machine provided");
}
if (!isset($_GET["limit"])) {
    $limit = 1;
} else {
    $limit = $_GET["limit"];
    if (!is_numeric($limit)) {
        error("Limit provided is not a number");
    }
}

$machine = Machine::get($_GET["machine"]);
if ($machine == null) {
    error("Machine provided does not exist");
}

$machine_data = Data_Upload::getAllQuery("WHERE machine_pk = ? ORDER BY timestamp DESC LIMIT ?", [$machine->pk, $limit]);

$machine_data_arr = [];
foreach ($machine_data as $data) {
    $data_arr = (array) $data;
    $data_arr["segments"] = [];
    foreach ($data->getSegments() as $d) {
        array_push($data_arr["segments"], $d->data);
    }
    array_push($machine_data_arr, $data_arr);
}

echo json_encode($machine_data_arr);

// $machine = Machine::getAllQuery("ORDER BY pk DESC LIMIT 10", []);

// var_dump($machine);

// $bases = Base::getAll();
// if (count($bases) != 1) {
//     error("Unsupported number of bases");
// }

// $types = Data_Upload::getAll();

// if (isset($_GET["field"])) {
//     $types = array_column($types, $_GET["field"]);
// }
