<?php

function getSilos($conn)
{
    $silos = array();
    $stmt = $conn->prepare("
        SELECT pk, name, location_x, location_z, target_x, target_x, doors_open, auth_code, launch_code
        FROM silos
    ");
    // $stmt->bind_param("i", $game_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $name, $location_x, $location_z, $target_x, $target_z, $doors_open, $auth_code, $launch_code);
        while ($stmt->fetch()) {
            array_push($silos, array(
                "pk" => $pk,
                "name" => $name,
                "location_x" => $location_x,
                "location_z" => $location_z,
                "target_x" => $target_x,
                "target_z" => $target_z,
                "doors_open" => $doors_open,
                "auth_code" => $auth_code,
                "launch_code" => $launch_code,
            ));
        }
    }
    return $silos;
}

function getSilo($conn, $silo_pk)
{
    $stmt = $conn->prepare("
    SELECT pk, name, location_x, location_z, target_x, target_z, doors_open, auth_code, launch_code
    FROM silos
    WHERE pk = ?
    ");
    $stmt->bind_param("i", $silo_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $name, $location_x, $location_z, $target_x, $target_z, $doors_open, $auth_code, $launch_code);
        if ($stmt->fetch()) {
            return array(
                "pk" => $pk,
                "name" => $name,
                "location_x" => $location_x,
                "location_z" => $location_z,
                "target_x" => $target_x,
                "target_z" => $target_z,
                "doors_open" => $doors_open,
                "auth_code" => $auth_code,
                "launch_code" => $launch_code,
            );
        }
    }
}

function getFlyingMachine($conn, $fly_pk)
{
    $stmt = $conn->prepare("
    SELECT pk, name, auth_code, target_x, target_y, target_z
    FROM flying_machines
    WHERE pk = ?
    ");
    $stmt->bind_param("i", $fly_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $name, $auth_code, $target_x, $target_y, $target_z);
        if ($stmt->fetch()) {
            return array(
                "pk" => $pk,
                "name" => $name,
                "auth_code" => $auth_code,
                "target_x" => $target_x,
                "target_y" => $target_y,
                "target_z" => $target_z,
            );
        }
    }
}

function getFlyingMachineLocation($conn, $fly_pk)
{
    $stmt = $conn->prepare("
    SELECT x, y, z, timestamp FROM flying_machine_position_updates
    WHERE flying_machine_pk = ?
    ORDER BY timestamp DESC LIMIT 1
    ");
    $stmt->bind_param("i", $fly_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($x, $y, $z, $timestamp);
        if ($stmt->fetch()) {
            return array(
                "x" => $x,
                "y" => $y,
                "z" => $z,
                "timestamp" => $timestamp,
            );
        }
    }
}

function setFlyingMachineLocation($conn, $fly_pk, $x, $y, $z) {
    $stmt = $conn->prepare("
        INSERT INTO flying_machine_position_updates
        (flying_machine_pk, x, y, z)
        VALUES
        (?,?,?,?)
    ");
    $stmt->bind_param("iiii", $fly_pk, $x, $y, $z);
    return $stmt->execute();
}

function getFlyingMachineLocationHistory($conn, $fly_pk) {
    $locations = array();
    $stmt = $conn->prepare("
    SELECT x, y, z, timestamp FROM flying_machine_position_updates
    WHERE flying_machine_pk = ?
    ORDER BY timestamp DESC
    ");
    $stmt->bind_param("i", $silo_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($x, $y, $z, $timestamp);
        while ($stmt->fetch()) {
            array_push($locations, array(
                "x" => $x,
                "y" => $y,
                "z" => $z,
                "timestamp" => $timestamp,
            ));
        }
    }
    return $locations;
}


function getInstructionsForSilo($conn, $silo_pk)
{
    $instructions = array();
    $stmt = $conn->prepare("
        SELECT pk, silo_pk, instruction, extra_auth, timestamp
        FROM instructions
        WHERE silo_pk = ?
    ");
    $stmt->bind_param("i", $silo_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($pk, $silo_pk, $instruction, $extra_auth, $timestamp);
        while ($stmt->fetch()) {
            array_push(
                // $instructions, $instruction
                $instructions, array(
                    "pk" => $pk,
                    "silo_pk" => $silo_pk,
                    "instruction" => $instruction,
                    "extra_auth" => $extra_auth,
                    "timestamp" => $timestamp,
                )
            );
        }
    }
    return $instructions;
}

function getSiloLastContact($conn, $silo_pk)
{
    $stmt = $conn->prepare("
    SELECT timestamp FROM logs
    WHERE silo_pk = ?
    ORDER BY timestamp DESC LIMIT 1
    ");
    $stmt->bind_param("i", $silo_pk);
    if ($stmt->execute()) {
        $stmt->bind_result($timestamp);
        if ($stmt->fetch()) {
            return $timestamp;
        }
    }
    return null;
}

function createInstruction($conn, $silo_pk, $instruction)
{
    $stmt = $conn->prepare("
        INSERT INTO instructions
        (silo_pk, instruction)
        VALUES
        (?,?)
    ");
    $stmt->bind_param("is", $silo_pk, $instruction);
    return $stmt->execute();

}

function deleteInstruction($conn, $instruction_pk)
{
    $stmt = $conn->prepare("
    DELETE FROM instructions
    WHERE pk = ?
    ");
    $stmt->bind_param("i", $instruction_pk);
    return $stmt->execute();
}

function setDoorsOpen($conn, $silo_pk, $door_status)
{
    $stmt = $conn->prepare("
        UPDATE silos
        SET doors_open = ?
        WHERE pk = ?
    ");
    $stmt->bind_param("ii", $door_status, $silo_pk);
    return $stmt->execute();
}

function createLog($conn, $silo_pk, $data)
{
    $stmt = $conn->prepare("
        INSERT INTO logs
        (silo_pk,data)
        VALUES
        (?,?)
    ");
    $stmt->bind_param("ss", $silo_pk, $data);
    return $stmt->execute();
}
