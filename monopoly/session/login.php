<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";

// Find existing
$player = getPlayerWithSession($conn, session_id());

// If they provide a code
if (isset($_POST["code"])) {
    // We need to find a game with that code
    $code = $_POST["code"];
    $game_to_join = getGameWithCode($conn, $code);
    if ($game_to_join == null) {
        // We can't find a game with that code
        echo "No game found with that code";
        return;
    }

    // If the session has no player (not in a game yet)
    if ($player == null) {
        // We need to create a player
        if (isset($_POST["username"]) && isset($_POST["token"])) {
            createPlayer($conn, $game_to_join["pk"], session_id(), $_POST["username"], $_POST["token"]);
            header("Location: " . "/monopoly/hand.php");
        } else {
            echo "You need to provide a username and a token";

        }
    } else {
        // There is already a player 
        $player_current_game = getGameForPlayer($conn, $player["pk"]);
        if ($player_current_game["pk"] != $game_to_join["pk"]) {
            // They are already in a game and trying to join another one
            // Propt them to quit the previous game
            header("Location: " . "/monopoly/session/logout.php");
            return;
        } 

        // They are trying to join the same game as the code they provided
        // Redirect them to their logged-in screen
        header("Location: " . "/monopoly/hand.php");
        return;
    }

} else {
    // The user is trying to login but has supplied no gamecode
    if ($player != null) {
        // If they are an admin then send them straight to the admin page
        if (isAdminPlayer($conn, $player)) {
            header("Location: " . "/monopoly/bank.php");
        } else {
            header("Location: " . "/monopoly/hand.php");
        }
        return;
    } else {
        // The session has no player but has provided no code
        echo "You haven't joined a game yet, and have provided no game code.";
        return;
    }
}
