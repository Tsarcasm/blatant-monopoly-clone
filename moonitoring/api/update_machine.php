<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

if (!isset($_POST["pk"])) {
    error("Must provide pk");
}

$machine = Machine::get($_POST["pk"]);
if ($machine == null) {
    error("Invalid pk");
}

if (isset($_POST["name"]) && $_POST["name"] != "") {
    $machine->name = $_POST["name"];
}

$machine->save();
// var_dump($farm);
echo "success";
