<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

if (!$_SESSION["admin"]) {
    return "no admin perms";
}

$name = $_POST["name"];
$details = $_POST["details"];
$rents = $_POST["rents"];
$street_pk = $_POST["street"];

$stmt = $conn->prepare("
    INSERT INTO properties
    (name, details, rents, street_pk)
    VALUES (?, ?, ?, ?)
    ");
$stmt->bind_param("sssi", $name, $details, $rents, $street_pk);
if ($stmt->execute()) {
    echo "Success, you can now return";
} else {
    echo "Error creating";
}
