<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

if (!isset($_GET["t"])) {
    error("Must provide token");
}
if (!isset($_GET["d"])) {
    error("Must provide data");
}
if (!isset($_GET["i"])) {
    error("Must provide sensor index");
}

$data_index = $_GET["t"];
$token = Upload_Token::get($data_index);
if ($token == null) {
    error("Token is not valid");
}

$sensor_string = $_GET["d"];
$sensor_index = $_GET["i"];
$sensors = explode(';', $sensor_string);
foreach ($sensors as $sensor_str) {
    $parts = explode(',', $sensor_str);
    if (count($parts) != 2) {
        error("invalid sensor string");
    }
    $machine_hid = $parts[0];
    $sensor_info = $parts[1];

    // we need to extract the components of the sensor info
    // 0-7  = code
    // 8-14 = number of segments
    // 15   = enabled or not
    /**/$data_type_code = 0b0000000011111111 & $sensor_info;
    /*  */$num_segments = (0b0111111100000000 & $sensor_info) >> 8;
    /*       */$enabled = (0b1000000000000000 & $sensor_info) >> 15;

    echo $sensor_info;
    echo "<br>";
    echo $data_type_code;
    echo "<br>";
    echo $num_segments;
    echo "<br>";
    echo $enabled;
    echo "<br>";

    // create a machine if one doesn't exist
    $machine = Machine::getWhere("h_id = ?", [$machine_hid]);
    if ($machine == null) {
        // we need to create a machine
        $machine = new Machine();
        $machine->farm_pk = $token->farm_pk;
        $machine->h_id = $machine_hid;
        $machine->name = "new machine";
        $machine->save();
    }

    // Update or create the sensor info 
    $sensor = Machine_Sensor::getWhere("machine_pk = ? AND hardware_index = ?", [$machine->pk, $sensor_index]);
    if ($sensor == null) {
        // We have to create a sensor
        $sensor = new Machine_Sensor();
        $sensor->hardware_index = $sensor_index;
        $sensor->machine_pk = $machine->pk;
        $sensor->description = "no description";
    }
    // Update the sensor based on potentially new information
    $sensor->sensor_type_pk = $data_type_code;
    $sensor->num_segments = $num_segments;
    $sensor->enabled = $enabled;
    // Update the sensor (or create if it's new)
    $sensor->save();
}
