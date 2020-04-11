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
    <h1>Your properties:</h1>
<?php
$player = getPlayerWithSession($conn, session_id());
?>
    <div id="cards">
    </div>
    <h1>Your balance:
        $<span id="balance"></span>
    </h1>
    <h1>
        Get out of jail cards:<span id="jail_cards"></span>
    </h1>


    <script>
        let pk = <?=$player["pk"]?>;
        $('#cards').load('dynamic/cards.php?pk=' + pk);
        loadPlayer();


        
        window.setInterval(function(){
            $('#cards').load('dynamic/cards.php?pk=' + pk);
            loadPlayer();
        }, 1000);




        function loadPlayer() {
            $.getJSON("api/player.php?pk=" + pk, function(data) {
                $("#balance").text(data["balance"]);
                $("#jail_cards").text(data["jail_cards"]);
            }, 
            function() {
                console.log("ajax error");
            }
            );
        }

    </script>


</body>
</html>