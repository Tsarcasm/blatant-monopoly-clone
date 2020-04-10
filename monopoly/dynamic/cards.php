<?php
include_once "../includes/top.php";
include_once "../includes/sql.php";
$pk = $_GET["pk"];

function getCards($conn, $pk)
{
    $cards = array();
    $stmt = $conn->prepare("
        SELECT player_cards.pk, properties.name, properties.details, player_cards.mortgaged, player_cards.houses, streets.name, streets.color
        FROM properties
        INNER JOIN player_cards ON player_cards.property_pk = properties.pk
        INNER JOIN players ON players.pk = player_cards.player_pk
        INNER JOIN streets ON streets.pk = properties.street_pk
        WHERE players.pk = ?
    ");
    $stmt->bind_param("i", $pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $name, $details, $mortgaged, $houses, $street_name, $color);
        while ($stmt->fetch()) {
            array_push($cards, array(
                "pk" => $pk,
                "name" => $name,
                "details" => $details,
                "mortgaged" => $mortgaged,
                "houses" => $houses,
                "street_name" => $street_name,
                "color" => $color,
            ));
        }
        return $cards;
    }
}

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
