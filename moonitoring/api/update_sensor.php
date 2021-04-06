<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

if (!isset($_POST["pk"])) {
    error("Must provide pk");
}

$sensor = Machine_Sensor::get($_POST["pk"]);
if ($sensor == null) {
    error("Invalid pk");
}

if (isset($_POST["description"]) && $_POST["description"] != "") {
    $sensor->description = $_POST["description"];
}

$sensor->save();
// var_dump($farm);
echo "success";
