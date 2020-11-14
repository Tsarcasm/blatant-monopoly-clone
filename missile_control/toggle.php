<?php
require_once "includes/top.php";

if (isset($_GET["state"])) {
    createInstruction($conn, 1, $_GET["state"]);

}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href='toggle.php?state=defcon_idle'>Defcon Idle</a><br>
    <a href='toggle.php?state=defcon_armed'>Defcon Armed</a><br>
    <a href='toggle.php?state=defcon_launch'>Defcon Launch</a><br>
    <hr>
    <a href='toggle.php?state=doors_open'>Open doors</a><br>
    <a href='toggle.php?state=doors_close'>Close doors</a><br>
</body>
</html>


