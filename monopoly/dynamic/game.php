<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/top.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/monopoly/includes/sql.php";


$game = getGame($conn, $_GET["pk"]);
$players = getPlayers($conn, $game["pk"]);
$admin = getPlayer($conn, $game["admin_pk"]);
?>
<h2>Game 
<span style="float: right;">[<?=$game["code"]?>]
</span>  
</h2>
<p>
Players: <?=count($players)?>
<br>
Admin: <?=$admin["username"]?>
</p>