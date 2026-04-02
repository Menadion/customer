<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['customer_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in."
    ]);
    exit();
}

$customerId = $_SESSION['customer_id'];

$apptDate = $_POST['appt_date'] ?? '';
$apptTimeRaw = $_POST['appt_time'] ?? '';
$purpose = trim($_POST['purpose'] ?? '');

if ($apptDate === '' || $apptTimeRaw === '') {
    echo json_encode([
        "success" => false,
        "message" => "Date and time are required."
    ]);
    exit();
}

/*
    Convert "8:00 AM" to MySQL TIME format
*/
$timeObj = DateTime::createFromFormat('g:i A', $apptTimeRaw);
if (!$timeObj) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid time format."
    ]);
    exit();
}
$apptTime = $timeObj->format('H:i:s');

/*
    Temporary: service_id and employee_id are NULL for now
*/
$stmt = $conn->prepare("
    INSERT INTO appointments_tbl
    (customer_id, service_id, employee_id, appt_date, appt_time, appt_status, created_at)
    VALUES (?, NULL, NULL, ?, ?, 'waiting for approval', NOW())
");

$stmt->bind_param("iss", $customerId, $apptDate, $apptTime);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Appointment saved."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to save appointment."
    ]);
}

$stmt->close();
$conn->close();
?>