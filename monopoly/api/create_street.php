<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

if (!$_SESSION["admin"]) {
    return "no admin perms";
}

$name = $_POST["name"];
$color = $_POST["color"];

$stmt = $conn->prepare("
    INSERT INTO streets
    (name, color)
    VALUES (?, ?)
    ");
$stmt->bind_param("ss", $name, $color);
if ($stmt->execute()) {
    echo "Success, you can now return";
} else {
    echo "Error creating";
}
