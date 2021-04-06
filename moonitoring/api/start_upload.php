<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

// $base = new Base();
// // $base->pk = ;
// $base->h_id = 4;
// $base->name = "test name";
// $base->ip_address = "192.168.0.10";
// $base->save();

// return;

// make sure we have a base and a farm
if (!isset($_GET["b"]) || !isset($_GET["f"])) {
    error("Must provide a base and a farm");
}

$base_hid = $_GET["b"];
$farm_hid = $_GET["f"];
$base = Base::getWhere("h_id = ?", [$base_hid]);
// var_dump($base);
if ($base == null) {
    // we need to create a base
    $base = new Base();
    $base->h_id = $base_hid;
    $base->name = "test name";
    $base->ip_address = "192.168.0.10";
    $base->save();
}
$farm = Farm::getWhere("h_id = ?", [$farm_hid]);
if ($farm == null) {
    // we need to create a base
    $farm = new Farm();
    $farm->base_pk = $base->pk;
    $farm->h_id = $farm_hid;
    $farm->name = "new farm";
    $farm->location = "set location";
    $farm->save();
}
// Now we have found our farm and base, we can create a new data upload

$upload_token = new Upload_Token();
$upload_token->farm_pk = $farm->pk;
$upload_token->save();
echo json_encode(array("token" => $upload_token->pk));
