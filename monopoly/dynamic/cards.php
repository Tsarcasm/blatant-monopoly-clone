<?php
include_once "../includes/top.php";
include_once "../includes/sql.php";
$pk = $_GET["pk"];
$cards = getCards($conn, $pk);

echo "<div>";
foreach ($cards as $card) {
    echo "
    <div class='card";
    if ($card["mortgaged"]) {
        echo " mortgaged";
    }
    
    echo "' data-pk='";
    echo $card["pk"];
    echo "'>
        <div>";
        if ($card["mortgaged"]) {
            echo "
            <h2 class='mort'>MORTGAGED</h2>
            ";
        }
        echo "
        <h1 style='background: " . $card["color"] . "'>" . $card["name"] . "</h1>
        <p> " . $card["details"] . "</p>
        </div>
    </div>";

}
