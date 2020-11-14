<?php
require_once "../includes/top.php";

function error($str)
{
    echo (json_encode(array('error' => $str)));
}

if (!isset($_GET["pk"])) {
    error("no pk included");
    return;
}
$pk = $_GET["pk"];

$machine = getFlyingMachine($conn, $pk);
if ($machine == null) {
    error("machine not found");
    return;
}

if (!isset($_GET["auth_code"])) {
    error("no auth code included");
    return;
}
$auth_code = $_GET["auth_code"];
if ($auth_code != $machine["auth_code"]) {
    error("auth code incorrect");
    return;
}

if (!isset($_GET["x"], $_GET["y"], $_GET["z"])) {
    error("no location provided");
    return;
}

// Update the location of the flying machine
setFlyingMachineLocation($conn, $pk, $_GET["x"], $_GET["y"], $_GET["z"]);

// Return the target
$output = array(intval($machine["target_x"]), intval($machine["target_y"]), intval($machine["target_z"]));
echo json_encode($output);
