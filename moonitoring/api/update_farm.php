<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

if (!isset($_POST["pk"])) {
    error("Must provide pk");
}

$farm = Farm::get($_POST["pk"]);
if ($farm == null) {
    error("Invalid pk");
}

if (isset($_POST["location"]) && $_POST["location"] != "") {
    $farm->location = $_POST["location"];
}
if (isset($_POST["name"]) && $_POST["name"] != "") {
    $farm->name = $_POST["name"];
}

$farm->save();
// var_dump($farm);
echo "success";
