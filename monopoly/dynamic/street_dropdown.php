<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

$streets = getStreets($conn);
foreach ($streets as $street) {
    echo "<option value='".$street["pk"]."' style='background-color: " . $street["color"]."'>";
    echo $street["name"] . "</option>";
}


