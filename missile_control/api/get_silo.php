<?php
require_once "../includes/top.php";

function error($str)
{
    echo (json_encode(array('error' => $str)));
}

if (!isset($_GET["pk"])) {
    error("no pk included");
    return;
}
$pk = $_GET["pk"];

$silo = getSilo($conn, $pk);
if ($silo == null) {
    error("silo not found");
    return;
}

echo json_encode($silo);
