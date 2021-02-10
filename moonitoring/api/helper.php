<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function error($msg)
{
    echo json_encode(array("error" => $msg));
    exit();
}