<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

$amount = $_POST["amount"];
$pk = $_POST["pk"];
$player = getPlayer($conn, $pk);
changeBalance($conn, $pk, (double)$player["balance"] + (double)$amount);
echo "success";
