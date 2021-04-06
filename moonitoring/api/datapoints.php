<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

if (!isset($_GET["machine"])) {
    error("No machine provided");
}
if (!isset($_GET["limit"])) {
    $limit = 100;
} else {
    $limit = $_GET["limit"];
    if (!is_numeric($limit)) {
        error("Limit provided is not a number");
    }
}
if (!isset($_GET["sensor"])) {
    error("no sensor provided");
}

$machine = Machine::getWhere("h_id = ?", [$_GET["machine"]]);
if ($machine == null) {
    error("Machine does not exist with this hid");
}

$sensor = Machine_Sensor::getWhere("machine_pk = ? AND hardware_index = ?", [$machine->pk, $_GET["sensor"]]);
if ($sensor == null) {
    error("Sensor not found");
}
$interp = $sensor->getInterpreter();

$pdo = Database::getConnection();
$sql = "SELECT machine_segments.pk, upload_token.timestamp FROM `machine_segments`
INNER JOIN upload_token ON upload_token.pk = machine_segments.upload_token_pk
WHERE machine_segments.machine_pk = ?
ORDER BY timestamp DESC LIMIT ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$machine->pk, $limit]);
$arr = [];
$sensor_arr = $machine->getSensors();
$last_sensor = end($sensor_arr);
$expected_num_segs = $last_sensor->getSegmentRange()[1];
$seg_range = $sensor->getSegmentRange()[0];
while ($row = $stmt->fetch()) {
    $timestamp = $row["timestamp"];
    $segs = Data_Segment::getAllWhere("machine_segments_pk = ? ORDER BY idx ASC", [$row["pk"]]);
    if (count($segs) != $expected_num_segs) {
        continue;
    }

    $seg_slice = array_slice($segs, $seg_range, $sensor->num_segments);
    $data = $interp->applyFunction($seg_slice);
    if (is_null($data)) {
        // continue;
    }

    $newarr = [];
    $newarr["x"] = date_format(new DateTime($timestamp), "H:i:s");
    $newarr["y"] = $data;
    array_push($arr, $newarr);
    // array_push($arr, [date_format(new DateTime($timestamp),"H:i:s"), $data]);

}
echo (json_encode($arr));
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
