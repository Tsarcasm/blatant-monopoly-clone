<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "model/connection.php";
if (!defined('PDO::ATTR_DRIVER_NAME')) {
    echo 'PDO unavailable';
}

require_once "model/farm.php";
require_once "model/base.php";

// var_dump(
//     Farm::getAll()
// );

// echo "<hr>";


$base = Base::get(1);
var_dump($base->farms());

// Base::info();

// var_dump(
//     Base::getAll()
// );


