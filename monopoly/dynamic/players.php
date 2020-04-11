<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

$game_pk = $_GET["game_pk"];
$players = getPlayers($conn, $game_pk);

foreach ($players as $player) {
    echo "<div class='player' data-pk='" . $player["pk"] . "'>";
    echo "<h2>[" . $player["pk"] . "]" . $player["username"] . "</h2>";
    echo "Balance: £" . $player["balance"];
    echo "</div>";
}
