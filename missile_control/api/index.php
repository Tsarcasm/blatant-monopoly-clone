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

$silo = getSilo($conn, $pk);
if ($silo == null) {
    error("silo not found");
    return;
}

if (!isset($_GET["auth_code"])) {
    error("no auth code included");
    return;
}
$auth_code = $_GET["auth_code"];
if ($auth_code != $silo["auth_code"]) {
    error("auth code incorrect");
    return;
}


// Decode door status from get 
$door_status = "_";
if (isset($_GET["door_status"])) {
    $door_status = $_GET["door_status"] == "open" ? 1 : 0;
    setDoorsOpen($conn, $pk, $door_status);
}

$power_level = "_";
$missiles = "_";
$target = "_";
$log_data = array(
    "door_status" => $door_status,
    "power_level" => $power_level,
    "missiles" => $missiles,
    "target" => $target,
);

// Create a log with this data
createLog($conn, $pk, json_encode($log_data));


// Now get a list of instructions

$instructions = getInstructionsForSilo($conn, $pk);

$clean_instructions = array();

foreach ($instructions as $instruction) {
    array_push($clean_instructions, $instruction["instruction"]);
}



$output = array(
    "auth_code" => $silo["auth_code"]
);
if (count($instructions) > 0) {
    $output["instructions"] = $clean_instructions;   
}


foreach ($instructions as $instruction) {
    deleteInstruction($conn, $instruction["pk"]);
}


echo json_encode($output);



