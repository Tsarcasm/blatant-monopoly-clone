<?php

function getPlayerWithSession($conn, $session)
{
    $stmt = $conn->prepare("
        SELECT pk, username, token, balance, jail_cards
        FROM players
        WHERE session_id = ?
    ");
    $stmt->bind_param("s", $session);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $username, $token, $balance, $jail_cards);
        if ($stmt->fetch()) {
            return array(
                "pk" => $pk,
                "session_id" => $session,
                "username" => $username,
                "token" => $token,
                "balance" => $balance,
                "jail_cards" => $jail_cards,
            );
        }
    }
}

function getPlayer($conn, $pk)
{
    $stmt = $conn->prepare("
        SELECT session_id, username, token, balance, jail_cards
        FROM players
        WHERE pk = ?
    ");
    $stmt->bind_param("i", $pk);
    if ($stmt->execute()) {
        $stmt->bind_result($session, $username, $token, $balance, $jail_cards);
        if ($stmt->fetch()) {
            return array(
                "pk" => $pk,
                "session_id" => $session,
                "username" => $username,
                "token" => $token,
                "balance" => $balance,
                "jail_cards" => $jail_cards,
            );
        }
    }
}

function getProperty($conn, $pk)
{
    $stmt = $conn->prepare("
    SELECT name, details, rents, street_pk
    FROM properties
    WHERE pk = ?
    ");
    $stmt->bind_param("i", $pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $name, $details, $rents, $street_pk);
        if ($stmt->fetch()) {
            return array(
                "pk" => $pk,
                "name" => $name,
                "details" => $details,
                "rents" => $rents,
                "street_pk" => $street_pk,
            );
        }
    }
}

function getStreet($conn, $pk)
{
    $stmt = $conn->prepare("
    SELECT name, color
    FROM streets
    WHERE pk = ?
    ");
    $stmt->bind_param("i", $pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $name, $color);
        if ($stmt->fetch()) {
            return array(
                "pk" => $pk,
                "name" => $name,
                "color" => $color,
            );
        }
    }
}

function changeBalance($conn, $pk, $amount)
{
    $stmt = $conn->prepare("
        UPDATE players
        SET balance = ?
        WHERE pk = ?
    ");
    $stmt->bind_param("di", $amount, $pk);
    return $stmt->execute();
}

function changeJailCards($conn, $pk, $new_cards)
{
    $stmt = $conn->prepare("
        UPDATE players
        SET jail_cards = ?
        WHERE pk = ?
    ");
    $stmt->bind_param("ii", $pk, $new_cards);
    return $stmt->execute();
}

function giveCard($conn, $player_pk, $card_pk)
{
    $stmt = $conn->prepare("
        INSERT INTO player_cards (player_pk, property_pk)
        VAULES (?, ?)
    ");
    $stmt->bind_param("ii", $player_pk, $card_pk);
    return $stmt->execute();
}

function takeCard($conn, $player_pk, $card_pk)
{
    $stmt = $conn->prepare("
        DELETE FROM player_cards
        WHERE player_pk = ? AND card_pk = ?
    ");
    $stmt->bind_param("ii", $player_pk, $card_pk);
    return $stmt->execute();
}

function mortgage($conn, $player_card_pk)
{
    $stmt = $conn->prepare("
        UPDATE player_cards
        SET mortgaged = 1
        WHERE pk = ?
    ");
    $stmt->bind_param("i", $player_card_pk);
    return $stmt->execute();
}

function unmortgage($conn, $player_card_pk)
{
    $stmt = $conn->prepare("
        UPDATE player_cards
        SET mortgaged = 0
        WHERE pk = ?
    ");
    $stmt->bind_param("i", $player_card_pk);
    return $stmt->execute();
}

function getPlayers($conn)
{
    $players = array();
    $stmt = $conn->prepare("
        SELECT pk, session_id, username, token, balance, jail_cards FROM players
    ");
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $session, $username, $token, $balance, $jail_cards);
        while ($stmt->fetch()) {
            array_push($players, array(
                "pk" => $pk,
                "session_id" => $session,
                "username" => $username,
                "token" => $token,
                "balance" => $balance,
                "jail_cards" => $jail_cards,
            ));
        }
    }
    return $players;
}

