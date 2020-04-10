<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($conn)) {
    require $_SERVER['DOCUMENT_ROOT'] . "/dbconn.php";
}

require_once "sql.php";

// Update session
$stmt = $conn->prepare("
    INSERT INTO sessions (code, ip_address)
    VALUES (?, ?)
    ON DUPLICATE KEY UPDATE ip_address = ?, last_active = CURRENT_TIMESTAMP()
");
$session_id = session_id();
$ip_addr = $_SERVER['REMOTE_ADDR'];
$stmt->bind_param("sss", $session_id, $ip_addr, $ip_addr);
$stmt->execute();

if (isAdminSession($conn, $session_id)) {
    $_SESSION["admin"] = true;
} else {
    $_SESSION["admin"] = false;
}