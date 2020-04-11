<?php
require_once "includes/top.php";
require_once "includes/sql.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/head.inc"?>
    <title>Monopoly!</title>
</head>
<body>
    <div class="page-wrap">
        <div class="title">
        <h1 style=>Monopoly!</h1>
        </div>
        <div class="nav">
            <a href="hand.php">Player</a>
            <a href="bank.php">Bank</a>
        </div>
        <?php 
        $player = getPlayerWithSession($conn, session_id());
        $game = getGame($conn, $player["game_pk"]);
        $code = "";
        if (isset($_GET["code"])) {
            $code = $_GET["code"];
        }
        ?>
        
        <div class="login-panel">
        <?php if($player != null): ?>
        <div>
            <h2>You are already in a game</h2>
            <p>
                Username: <?=$player["username"]?>
                <br>
                Game code: <?=$game["code"]?>
            </p>
            <h2><a href="/monopoly/session/login.php">Rejoin Game</a> |  
            <a href="/monopoly/session/logout.php" style="color: #ff2f2f">Leave Game</a></h2>
            <p>Logging into a second game will remove you from the first</p>
            <hr>
        </div>
        <?php endif; ?>
        <h1>Join Game</h1>
        <form id="login-form" style="margin: 0px auto; border: none;" action="session/login.php" method="post">
            <table>
                <tr>
                    <td>Game Code:</td>
                    <td><input id="game-code" type="text" name="code" value="<?=$code?>"/></td>
                    <td id="game-code-valid">◽</td>
                </tr>
                <tr>
                    <td id="game-preview" class="game-preview" colspan="3"></td>
                </tr>

                <tr class="requires-game" style="display: none;">
                    <td>Username:</td>
                    <td><input id="username" type="text" name="username" /></td>
                    <td id="username-valid"></td>
                </tr>
                <tr class="requires-game" style="display: none;">
                    <td>Token:</td>
                    <td>
                        <select name="token" style="
                        float: left;
                        width: 100%;
                        ">
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="shoe">Shoe</option>
                            <option value="boat">Boat</option>
                            <option value="car">Car</option>
                            <option value="salt">Salt</option>
                            <option value="barrow">Wheelbarrow</option>
                            <option value="hat">Hat</option>
                        </select>
                    </td>
                </tr>
                <tr class="requires-game" style="display: none;">
                    <td colspan="3"><button id="login-btn" class="btn-1 login" type="submit">Login!</button></td>
                </tr>
                <tr>
                    <td></td>
                    <td id="create-game">
                    <button id="create-game-btn" class="btn-1 login" type="submit" style="margin: 0px; padding: 3px; width: 100%">Create Game</button>
                    </td>
                    <td></td>
                </tr>
            </table>
        </form>

        </div>
        <div class="footer">
            Charles
        </div>
    </div>

    <script>
        let foundGame;
        gameCodeChanged();

        function makeGame() {
            $.ajax({
                dataType: "json",
                url: "api/get_game_code.php",
                success: function(e) {
                    console.log(e);
                    $("#game-code").val(e.code);
                    $("#game-code").prop("readonly", true);
                    $("#login-form").prop("action", "session/start_game.php");
                    $("#create-game-btn").remove();
                    handleGame(e.code);
                    $("#game-preview").html("Creating new game!");
                }
            });
        }

        function handleGame(g) {
            if (g == "error") {
                $(".requires-game").hide(500, function(){
                    $("#game-preview").html("");
                    $("#create-game-btn").show();
                });
                if ($('#game-code').val() == "") {
                    $("#game-code-valid").text("◽");
                } else {
                    $("#game-code-valid").text("×");
                }
            } else {
                foundGame = g;
                $("#game-code-valid").text("✔");
                $("#game-preview").html("Game found!");
                $(".requires-game").show(500);
                $("#create-game-btn").hide();
                handleUsername();
            }

        }

        function handleUsername(e) {
            var username = $('#username').val();
            if (username == "") {
                $("#username-valid").text("");
                $("#login-btn").prop("disabled", true);
                $("#login-btn").addClass("disabled");
                return;
            }
            
            if (e == "available") {
                $("#username-valid").text("✔");
                $("#login-btn").prop("disabled", false);
                $("#login-btn").removeClass("disabled");
            } else {
                $("#username-valid").text("×");
                $("#login-btn").prop("disabled", true);
                $("#login-btn").addClass("disabled");
            }
        }

        function gameCodeChanged() {
            var gamecode = $('#game-code').val();
            console.log(gamecode);
            $.ajax({
                dataType: "json",
                url: "api/game.php?code=" + gamecode,
                success: handleGame
            });
        }

        function usernameChanged() {
            var username = $('#username').val();
            console.log(username);
            $.ajax({
                dataType: "json",
                url: "api/username_check.php?game_pk=" + foundGame.pk + "&username=" + username,
                success: handleUsername
            });
        }

        $('#username').on('input',function(e){
            usernameChanged();
        });

        $('#game-code').on('input',function(e){
            gameCodeChanged();
        });

        $('#create-game-btn').on('click',function(e){
            event.preventDefault();
            makeGame();
            return false;
        });
    </script>
</body>
</html>