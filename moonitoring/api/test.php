<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

if (!isset($_GET["machine"])) {
    error("No machine provided");
}
$limit = 3000;
if (isset($_GET["limit"])) {
    $limit = $_GET["limit"];    
}
// $token = $_GET["token"];
$machine = Machine::getWhere("h_id = ?", [$_GET["machine"]]);
if ($machine == null) {
    error("Machine does not exist with this hid");
}

$sensors = $machine->getSensors();

$pdo = Database::getConnection();
$sql = "SELECT machine_segments.pk, upload_token.timestamp FROM `machine_segments`
INNER JOIN upload_token ON upload_token.pk = machine_segments.upload_token_pk
WHERE machine_segments.machine_pk = ? 
AND upload_token.timestamp > DATE_SUB(NOW(), INTERVAL 24 HOUR)
ORDER BY timestamp DESC";//AND machine_segments.upload_token_pk = ?
//";

$stmt = $pdo->prepare($sql);
$stmt->execute([$machine->pk]);
$arr = [];
echo "start: <hr>";
// Discard the most recent data
// $stmt->fetch();
$total = 0;
$errors = 0;
while ($row = $stmt->fetch()) {
    $total++;
    $timestamp = $row["timestamp"];
    $segs = Data_Segment::getAllWhere("machine_segments_pk = ? ORDER BY idx ASC", [$row["pk"]]);
    // var_dump($segs);
    $newarr = [];
    $newarr["x"] = date_format(new DateTime($timestamp), "H:i:s");
    $newarr["y"] = [];
    if (count($segs) == 7) continue; 
    $errors++;
    // echo(count($segs));
    // echo "<br>";
    echo date_format(new DateTime($timestamp), "H:i:s");
    echo ", ";
    echo count($segs);
    echo "<br>";

    continue;
    foreach ($segs as $seg) {
        var_dump($seg);
        echo "<br>";
    }
    
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
        var_dump($sensor->getSegmentRange()[0]);
        var_dump($sensor->getSegmentRange()[1]);
        var_dump($segs[0]);
        echo "<br>";
        array_push($newarr["y"], $seg_slice);
        array_push($newarr["y"], $data);

    }

    array_push($arr, $newarr);
    // array_push($arr, [date_format(new DateTime($timestamp),"H:i:s"), $data]);
    echo "<br><br>===========================<br>";

}
echo "<br><br>";
echo "done";
echo $errors." / ".$total;
// echo (json_encode($arr));