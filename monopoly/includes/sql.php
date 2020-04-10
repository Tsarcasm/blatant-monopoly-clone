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
        $stmt->bind_result($name, $details, $rents, $street_pk);
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

function getPlayerProperty($conn, $pk)
{
    $properties = array();
    $stmt = $conn->prepare("
        SELECT player_pk, property_pk, mortgaged, houses
        FROM player_cards
        WHERE pk = ?
    ");
    $stmt->bind_param("i", $pk);
    if ($stmt->execute()) {
        $stmt->bind_result($player_pk, $property_pk, $mortgaged, $houses);
        if ($stmt->fetch()) {
            return array(
                "pk" => $pk,
                "player_pk" => $player_pk,
                "property_pk" => $property_pk,
                "mortgaged" => $mortgaged,
                "houses" => $houses,
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

function getStreets($conn) {
    $streets = array();
    $stmt = $conn->prepare("
    SELECT pk, name, color
    FROM streets
    ");
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $name, $color);
        while ($stmt->fetch()) {
            array_push($streets, array(
                "pk" => $pk,
                "name" => $name,
                "color" => $color,
            ));
        }
    }
    return $streets;
}

function getPlayerProperties($conn, $player_pk)
{
    $properties = array();
    $stmt = $conn->prepare("
        SELECT pk, property_pk, mortgaged, houses
        FROM players
        WHERE player_pk = ?
    ");
    $stmt->bind_param("i", $player_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $property_pk, $mortgaged, $houses);
        while ($stmt->fetch()) {
            array_push($players, array(
                "pk" => $pk,
                "player_pk" => $player_pk,
                "property_pk" => $property_pk,
                "mortgaged" => $mortgaged,
                "houses" => $houses,
            ));
        }
    }
    return $players;
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
        VALUES (?, ?)
    ");
    $stmt->bind_param("ii", $player_pk, $card_pk);
    return $stmt->execute();
}

function takeCard($conn, $player_pk, $card_pk)
{
    $stmt = $conn->prepare("
        DELETE FROM player_cards
        WHERE player_pk = ? AND property_pk = ?
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

function streetSize($conn, $street_pk)
{
    $stmt = $conn->prepare("
        SELECT count(*) as count FROM properties
        WHERE street_pk = ?
    ");
    $stmt->bind_param("i", $street_pk);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_assoc()["count"];
    }
}

function playerNumOwnedOnStreet($conn, $player_pk, $street_pk)
{
    $stmt = $conn->prepare("
        SELECT count(*) as count
        FROM properties
        INNER JOIN player_cards ON player_cards.property_pk = properties.pk
        WHERE properties.street_pk = ? AND player_cards.player_pk = ?
    ");
    $stmt->bind_param("ii", $street_pk, $player_pk);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_assoc()["count"];
    }
}

function rents($property)
{
    return explode(",", $property["rents"]);
}

function calculateRent($conn, $player_property_pk)
{
    $player_property = getPlayerProperty($conn, $player_property_pk);
    $owner_pk = $player_property["player_pk"];
    $property = getProperty($conn, $player_property["property_pk"]);

    // First find if player has all the properties on the street
    $street_count = streetSize($conn, $property["street_pk"]);

    // Does the player own all the cards on that street?
    if (playerNumOwnedOnStreet($conn, $owner_pk, $property["street_pk"]) == $street_count) {
        // If they own a house return that rent price
        if ($player_property["houses"] > 0) {
            return rents($property)[$player_property["houses"]];
        } else {
            // Otherwise return twice the usual rent
            return rents($property)[0] * 2;
        }
    } else {
        // Just return normal rent
        return rents($property)[0];
    }
}
