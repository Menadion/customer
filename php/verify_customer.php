<?php
include 'db_connect.php';
require_once 'flash.php';

$token = trim($_GET['token'] ?? '');

if ($token === '') {
    setFlashMessage("Verification link is invalid or expired.");
    header("Location: customer_login.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT customer_id, status
    FROM customer_tbl
    WHERE email_verification_token = ?
    LIMIT 1
");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    setFlashMessage("Verification link is invalid or expired.");
    header("Location: customer_login.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

$update = $conn->prepare("
    UPDATE customer_tbl
    SET status = 'active',
        email_verified_at = NOW(),
        email_verification_token = NULL
    WHERE customer_id = ?
");
$update->bind_param("i", $user['customer_id']);
$update->execute();
$update->close();

setFlashMessage("Account verified. You may now log in.", "#1f4037");
header("Location: customer_login.php");
exit();
?>
