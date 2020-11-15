<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "model/connection.php";
if (!defined('PDO::ATTR_DRIVER_NAME')) {
    echo 'PDO unavailable';
}

require_once "model/units.php";

// var_dump(
//     Base::get(1)->getFarms()//Farm::getAll()
// );

// echo "<hr>";


$base = Base::get(1);
var_dump($base);
$base->name = "scoones farm 3.0";
$base->save();


$new_farm = new Farm();
$new_farm->base_pk = 1;
$new_farm->name = "New Farm";
$new_farm->location = "Somewhere";
$new_farm->h_id = 22;

$new_farm->save();


$farm_to_delete = Farm::getWhere("name = ?", ["New Farm"]);
$farm_to_delete->delete();
// end(Base::getAll())->delete();

// $base2 = new Base();
// $base2->h_id = 3;
// $base2->name = "new base";
// $base2->ip_address = "0.0.0.0";
// $base2->save();
// var_dump($base->getFarms()[0]);

// Base::info();

// var_dump(
//     Base::getAll()
// );


