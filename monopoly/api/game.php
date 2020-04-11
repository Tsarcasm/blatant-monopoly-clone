<?php
require_once "../includes/top.php";
include_once "../includes/sql.php";
$code = $_GET["code"];
$game = getGameWithCode($conn, $code);
if ($game == null) $game = "error";



echo json_encode($game, JSON_PRETTY_PRINT);  
