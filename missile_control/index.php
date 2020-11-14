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
            <h1>MISSILE CONTROL</h1>
            <p>Missile control panel</p>
            <hr>
            <h2>Silos</h2>


                <?php foreach ($silos as $silo): ?>
                    <?php endforeach;?>
                    <table>
                    <tr>
                        <td>Id</td>
                        <td><?=$silo["pk"]?></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><?=$silo["name"]?></td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>x: <?=$silo["location_x"]?>, z: <?=$silo["location_z"]?></td>
                    </tr>
                    <tr>
                        <td>Target</td>
                        <td>x: <?=$silo["target_x"]?>, z: <?=$silo["target_z"]?></td>
                    </tr>
                    <tr>
                        <td>Doors open</td>
                        <td><?=$silo["doors_open"]?></td>
                    </tr>
                    <tr>
                        <td>Codes</td>
                        <td><?=$silo["auth_code"]?>, <?=$silo["launch_code"]?></td>
                    </tr>
                    <tr>
                        <td>Last Contact</td>
                        <td>
                        <?php 
                            echo getSiloLastContact($conn, $silo["pk"]);
                        ?>
                        </td>
                    </tr>
                    </table>


                <?php

?>

            <hr>





            <a href="#">TEST_L</a>
            <a href="#">AUNCH</a>

            <button>LAUNCH ALL</button>
            <button></button>
        </div>
    </div>
</body>
</html>
