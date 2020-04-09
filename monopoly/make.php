<?php
require_once "includes/top.php";
require_once "includes/sql.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/head.inc"?>
    <title>Make page</title>
</head>
<body>
    <h1>Setup page</h1>
    <form style="border: 1px black solid; display: inline-block; padding: 5px" method="post" action="api/create_property.php">
        <p>
            Create a property here
        </p>    
        Name 
        <input type="text" name="name">
        <hr>
        Details 
        <textarea type="text" name="details" cols="30" rows="4"></textarea>
        <hr>
        Rents
        <input type="text" name="rents">
        <hr>
        Street
        <select name="street">
            <?php include "dynamic/street_dropdown.php" ?>
        </select>
        <input type="submit">
    </form>
    <br>
    <br>
    <br>
    <form style="border: 1px black solid; display: inline-block; padding: 5px" method="post" action="api/create_street.php">
        <p>
            Create a street here
        </p>    
        Name 
        <input type="text" name="name">
        <hr>
        Colour
        <input type="text" name="color">
        <input type="submit">
    </form>
</body>
</html>