<?php
require_once "../includes/top.php";
include_once "../includes/sql.php";
$pk = $_GET["pk"];
$player = getPlayer($conn, $pk);

echo json_encode($player, JSON_PRETTY_PRINT);  
