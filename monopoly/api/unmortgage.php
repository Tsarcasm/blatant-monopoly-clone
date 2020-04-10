<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

if (!$_SESSION["admin"]) {
    return "no admin perms";
}

$pk = $_POST["pk"];
unmortgage($conn, $pk);
echo "success";

