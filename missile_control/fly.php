<?php
require_once "includes/top.php";


$silos = getSilos($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISSILE CONTROL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-wrap">
        <div class="content">
            <h1>FLYING MACHINE CONTROL</h1>
            <p>Flying machine panel</p>
            <hr>
            <h2>Machine is at:</h2>
            <?php 
            $machine = getFlyingMachineLocation($conn, 1);
            $x = $machine["x"];
            $y = $machine["y"];
            $z = $machine["z"];
            echo "X: $x, Z: $z";
            echo "<br>";
            echo "Y: $y"; 
            ?>
        </div>
    </div>
</body>
</html>
