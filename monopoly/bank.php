<?php
include_once "includes/top.php";
include_once "includes/sql.php";


if (!$_SESSION["admin"]) {
    echo "You are not a game admin";
    return;
}

$player = getPlayerWithSession($conn, session_id());
$game = getGame($conn, $player["game_pk"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/head.inc"?>
    <title>Monopoly Bank Page</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
</head>
<body>

    <div id="property-modal" class="modal">
        <div class="modal-content">
            <h1>Choose a property <span id="close-property-modal-btn" class="close-modal-btn">[×]</span></h1>
            <hr>
            <div id="property-options">
                Loading...
            </div>
        </div>
    </div>

    <div class="bank-table">
        <div class="header">
            <h1>Bank Page</h1>
        </div>

        <div class="main">
            <h2>Players <small>(click to select)</small></h2>
            <div id="players">
        </div>
        </div>
        <div id="game-details" class="right">
        </div>

        <div class="cards">
            Selected player's cards
            <div id="selected-player-cards"></div>
        </div>

        <div class="button add-funds">
            <h2>Add Funds</h2>
            <form id="add-funds-form" action="api/change_funds.php" method="post">
                <input type="number"  name="amount" min="0" max="10000">
                <br>
                <input class="requires-selected-player" type="submit" value="Add" />
            </form>
        </div>
        <div class="button take-funds">
            <h2>Take Funds</h2>
            <form id="take-funds-form" action="api/change_funds.php" method="post">
                <input type="number"  name="amount" min="0" max="10000">
                <br>
                <input class="requires-selected-player" type="submit" value="Take" />
            </form>
        </div>
        <div class="button pass-go">
            <h2>Pass Go</h2>
            <form id="pass-go-form" action="api/change_funds.php" method="post">
                <input type="hidden"  name="amount" value="2000">
                (Add £2000)
                <br>
                <input class="requires-selected-player" type="submit" value="Pass Go" />
            </form>
        </div>
        <div class="button take-mort">
            <h2>Mortgage a property</h2>
            <button id="mortgage-btn" class="requires-selected-card">Mortgage</button>
        </div>
        <div class="button unmort">
            <h2>Unmortgage a property</h2>
            <button id="unmortgage-btn" class="requires-selected-card">Unmortgage</button>
        </div>

        <div class="button give-prop">
            <h2>Give a property</h2>
            <button id="give-prop-btn" class="requires-selected-player">Give</button>
        </div>

        <div class="button take-prop">
            <h2>Take a property</h2>
            <button id="take-prop-btn" class="requires-selected-player">Take</button>

        </div>
    </div>


    <script>
        let selectedPlayer;
        let selectedCard;
        let propertySelectMode;
        $(".requires-selected-player").prop('disabled', true);
        $(".requires-selected-card").prop('disabled', true);
        $('#players').load('dynamic/players.php?game_pk='+ <?=$game["pk"]?> );
        $('#game-details').load('dynamic/game.php?pk='+ <?=$game["pk"]?> );

        $(document).keyup(function(e) {
            if(e.key === "Escape") {
                if (selectedCard) {
                    deselectCard();
                } else {
                    delselectPlayer();
                }
            }
        });



        $("#give-prop-btn").on("click", function() {
            propertySelectMode = "give-prop";
            $("#property-options").load("dynamic/unowned_properties.php");
            openPropertyModal();
        });

        $("#take-prop-btn").on("click", function() {
            propertySelectMode = "take-prop";
            $("#property-options").load("dynamic/owned_properties.php?pk="+selectedPlayer.data("pk"));
            openPropertyModal();
        });


        $("#close-property-modal-btn").on("click", function() {
            closePropertyModal();
        });

        function openPropertyModal() {
            $(".modal").show();
        }

        function closePropertyModal() {
            propertySelectMode = "none";
            $(".modal").hide();
            $("#property-options").html("Loading...");
        }

        $("#property-options").on("click", ".property-modal-card", function(e) {
            let property_pk = $(e.target).closest("div.property-modal-card").data("pk")
            if (propertySelectMode == "give-prop") {
                //We want to give this player that property
                $.ajax({
                type: "POST",
                url: "api/give_property.php",
                data: {
                    "player_pk": selectedPlayer.data("pk"),
                    "property_pk" : property_pk
                },
                success: function(e) {
                    console.log(e);
                    closePropertyModal();
                    // delselectPlayer();
                    $('#selected-player-cards').load('dynamic/cards.php?pk=' + selectedPlayer.data("pk"));
                }});
            } else if (propertySelectMode == "take-prop") {
                //We want to take that property
                $.ajax({
                type: "POST",
                url: "api/take_property.php",
                data: {
                    "player_pk": selectedPlayer.data("pk"),
                    "property_pk" : property_pk
                },
                success: function(e) {
                    console.log(e);
                    closePropertyModal();  
                    // delselectPlayer();          
                    $('#selected-player-cards').load('dynamic/cards.php?pk=' + selectedPlayer.data("pk"));
                }});
            } 
        });


        function reload() {
            $('#players').load('dynamic/players.php?game_pk='+ <?=$game["pk"]?> );
            delselectPlayer();
        }
        function delselectPlayer() {
            if (selectedPlayer) selectedPlayer.removeClass("selected");
            selectedPlayer = null;
            $(".requires-selected-player").prop('disabled', true);
            deselectCard();
            $('#selected-player-cards').html("");
        }


        function selectPlayer(e) {
            deselectCard();
            if (selectedPlayer) selectedPlayer.removeClass("selected");
            e.addClass("selected");
            selectedPlayer = e;
            $(".requires-selected-player").prop('disabled', false);
            $('#selected-player-cards').load('dynamic/cards.php?pk=' + selectedPlayer.data("pk"));
        }

        function selectCard(e) {
            if (selectedCard) selectedCard.removeClass("selected");
            e.addClass("selected");
            selectedCard = e;
            $(".requires-selected-card").prop('disabled', false);
        }

        function deselectCard() {
            if (selectedCard) selectedCard.removeClass("selected");
            selectedCard = null;
            $(".requires-selected-card").prop('disabled', true);
        }


        $("#players").on("click", ".player", function(e) {
            selectPlayer($(e.target).closest("div.player"));
        });

        $("#cards").on("click", function(e) {
            deselectCard();
            alert("meme");
        });
        $("#selected-player-cards").on("click", ".card", function(e) {
            selectCard($(e.target).closest("div.card"));
        });



       // bind submit handler to form
        $('#add-funds-form').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                beforeSubmit: function(arr, $form, options) {
                    arr.push(
                        {"name" : "pk", "value" : selectedPlayer.data("pk")}
                    );
                    console.log(arr);
                },
                success: reload
            });
            return false;
        });

        $('#take-funds-form').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                beforeSubmit: function(arr, $form, options) {
                    arr[0].value = -arr[0].value;
                    arr.push(
                        {"name" : "pk", "value" : selectedPlayer.data("pk")}
                    );
                    console.log(arr);
                },
                success: reload
            });
            return false;
        });

        $('#pass-go-form').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                beforeSubmit: function(arr, $form, options) {
                    arr.push(
                        {"name" : "pk", "value" : selectedPlayer.data("pk")}
                    );
                    console.log(arr);
                },
                success: reload
            });
            return false;
        });

        $('#mortgage-btn').on('click', function(e) {
            $.ajax({
            type: "POST",
            url: "api/mortgage.php",
            data: {"pk": selectedCard.data("pk")},
            success: function() {
                $('#selected-player-cards').load('dynamic/cards.php?pk=' + selectedPlayer.data("pk"));
                deselectCard();
            }
            });
        });

        $('#unmortgage-btn').on('click', function(e) {
            $.ajax({
            type: "POST",
            url: "api/unmortgage.php",
            data: {"pk": selectedCard.data("pk")},
            success: function() {
                $('#selected-player-cards').load('dynamic/cards.php?pk=' + selectedPlayer.data("pk"));
                deselectCard();
            }
            });
        });


    </script>


</body>
</html>