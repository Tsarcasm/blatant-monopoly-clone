<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

function echoProperty($pk, $name, $color) {
    echo "<div class='property-modal-card' data-pk='$pk'>
            <h2 style='color: $color'>$name</h2>      
          </div>";
}


$stmt = $conn->prepare("
    SELECT properties.pk, properties.name, streets.color
    FROM properties
    INNER JOIN streets ON streets.pk = properties.street_pk
    LEFT JOIN player_cards ON player_cards.property_pk = properties.pk
    WHERE player_cards.property_pk IS NULL
");

if ($stmt->execute()) {
    $stmt->bind_result($pk, $name, $color);
    $num = 0;
    while ($stmt->fetch()) {
        echoProperty($pk, $name, $color);
        $num++;
    }
    if ($num == 0) {
        echo "There are no properties remaining";
    }
}



