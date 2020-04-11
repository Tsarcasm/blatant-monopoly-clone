<?php
require_once "../includes/top.php";
include_once "../includes/sql.php";
$game_pk = $_GET["game_pk"];
$username = $_GET["username"];


$stmt = $conn->prepare("
        SELECT pk
        FROM players
        WHERE username = ? AND game_pk = ?
");
$stmt->bind_param("si", $username, $game_pk);
if ($stmt->execute()) {
    $stmt->bind_result($pk);
    if ($stmt->fetch()) {
        echo json_encode("taken", JSON_PRETTY_PRINT);  
    } else {
        echo json_encode("available", JSON_PRETTY_PRINT);  
    }
}


