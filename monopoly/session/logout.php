<?php
require_once "../includes/top.php";
require_once "../includes/sql.php";

// Find existing
$player = getPlayerWithSession($conn, session_id());
$game = getGame($conn, $player["game_pk"]);

if (isset($_GET["confirm"]) && $_GET["confirm"] == true) {
    if ($player == null) {
        echo "Error: player not found";
        return;
    }
    //Logout
    $stmt = $conn->prepare("DELETE FROM players WHERE pk = ?");
    $stmt->bind_param("i", $player["pk"]);
    $stmt->execute();
    header("Location: " . "/monopoly/");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../includes/head.inc"?>
    <title>Monopoly!</title>
</head>
<body>
    <div style="
    max-width: 600px;
    margin: 0px auto;
    text-align: center;
    ">
        <?php if ($player != null): ?>
        <h2>Current Game:</h2>
        <p>
        Username: <?=$player["username"]?>
        <br>
        Game code: <?=$game["code"]?>
        <h2>
        <a href="/monopoly/session/login.php">Rejoin Game</a>
        </h2>
        Quitting the game will delete all your progress (properties, money etc.)
        </p>
        <form action="" method="get">
        <input type="hidden" name="confirm" value="true"/>
        <button class="btn-1 logout" type="submit">Quit</button>
        </form>
        <?php else: ?>
            <h2>You are not currently in a game:</h2>
            <h2>
            <a href="/monopoly/">Join Game</a>
            </h2>
        <?php endif;?>
    </div>
</body>
</html>