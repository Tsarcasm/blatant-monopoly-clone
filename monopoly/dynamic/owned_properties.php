<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

$player_pk = $_GET["pk"];

function echoProperty($pk, $name, $color) {
    echo "<div class='property-modal-card' data-pk='$pk'>
            <h2 style='color: $color'>$name</h2>      
          </div>";
}


$stmt = $conn->prepare("
    SELECT properties.pk, player_cards.property_pk, properties.name, streets.color
    FROM properties
    INNER JOIN streets ON streets.pk = properties.street_pk
    LEFT JOIN player_cards ON player_cards.property_pk = properties.pk
    WHERE player_cards.property_pk IS NOT NULL AND player_cards.player_pk = ? 
");
$stmt->bind_param("i", $player_pk);
if ($stmt->execute()) {
    $stmt->bind_result($pk, $player_property_pk, $name, $color);
    $num = 0;
    while ($stmt->fetch()) {
        echoProperty($pk, $name, $color);
        $num++;
    }
    if ($num == 0) {
        echo "This player owns no properties";
    }
}



