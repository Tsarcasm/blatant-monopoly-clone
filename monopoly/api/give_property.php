<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

if (!$_SESSION["admin"]) {
    return "no admin perms";
}

$property_pk = $_POST["property_pk"];
$player_pk = $_POST["player_pk"];
echo "prop pk: $property_pk   player pk: $player_pk";
//Todo check that card is free and we are allowed to give the player it
$result = giveCard($conn, $player_pk, $property_pk);
var_dump($result);
echo "success";