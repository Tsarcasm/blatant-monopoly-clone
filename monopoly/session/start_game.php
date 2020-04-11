<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

$code = $_POST["code"];
$username = $_POST["username"];
$token = $_POST["token"];
$player = getPlayerWithSession($conn, session_id());

// If they are already in a game then disconnect them
if ($player != null) {
    header("Location: "."/monopoly/session/logout.php");
    return;
}

// If a game already exists with this code
if (getGameWithCode($conn, $code)) {
    echo "A game already exists with this code";
    return;
}

// Else we are good to create a new game
if (!createGame($conn, $code)) {
    echo "Error creating game";
    return;
}
$game = getGameWithCode($conn, $code);

// Now make a player
if (!createPlayer($conn, $game["pk"], session_id(), $username, $token)) {
    echo "Error creating player";
    return;
}
$player = getPlayerWithSession($conn, session_id());

// Set this player as the admin
var_dump($player);
echo "<br>";
setGameAdmin($conn, $code, $player["pk"]);

var_dump(getGameWithCode($conn, $code));







