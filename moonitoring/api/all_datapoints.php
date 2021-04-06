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

$machine = Machine::getWhere("h_id = ?", [$_GET["machine"]]);
if ($machine == null) {
    error("Machine does not exist with this hid");
}

$sensors = $machine->getSensors();

$pdo = Database::getConnection();
$sql = "SELECT machine_segments.pk, upload_token.timestamp FROM `machine_segments`
INNER JOIN upload_token ON upload_token.pk = machine_segments.upload_token_pk
WHERE machine_segments.machine_pk = ?
ORDER BY timestamp DESC LIMIT ?";


// $sql = "SELECT timestamp, "

$stmt = $pdo->prepare($sql);
$stmt->execute([$machine->pk, $limit + 1]);
$arr = [];
// Discard the most recent data
$stmt->fetch();

$last_sensor = $sensors[count($sensors) - 1];
$expected_num_segs = $last_sensor->getSegmentRange()[1];

while ($row = $stmt->fetch()) {
    $timestamp = $row["timestamp"];
    $segs = Data_Segment::getAllWhere("machine_segments_pk = ? ORDER BY idx ASC", [$row["pk"]]);
    if (count($segs) != $expected_num_segs) {
        continue;
    }
    $newarr = [];
    if (isset($_GET["shorthand"])) {
    $newarr["x"] = date_format(new DateTime($timestamp), "H:i:s");
    } else {
    $newarr["x"] = date_format(new DateTime($timestamp), "Y-m-d H:i:s");
    }
    $newarr["y"] = [];
    foreach ($sensors as $sensor) {
        $interp = $sensor->getInterpreter();
        $seg_slice = array_slice($segs, $sensor->getSegmentRange()[0], $sensor->num_segments);
        
        if ($interp == null) {
            continue;
        }

        $data = $interp->applyFunction($seg_slice);
        if (is_null($data)) {
            // continue;
        }
        array_push($newarr["y"], $data);

    }

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
