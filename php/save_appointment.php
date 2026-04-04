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
$services = $_POST['services'] ?? [];

$notes = trim($_POST['notes'] ?? '');
$notes = ($notes === '' || $notes === '-') ? null : $notes;

if ($apptDate === '' || $apptTimeRaw === '') {
    echo json_encode([
        "success" => false,
        "message" => "Date and time are required."
    ]);
    exit();
}

if (empty($services)) {
    echo json_encode([
        "success" => false,
        "message" => "At least one service is required."
    ]);
    exit();
}

$timeObj = DateTime::createFromFormat('g:i A', $apptTimeRaw)
    ?: DateTime::createFromFormat('H:i:s', $apptTimeRaw);

if (!$timeObj) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid time format."
    ]);
    exit();
}

$apptTime = $timeObj->format('H:i:s');
$stmt = $conn->prepare("
    INSERT INTO appointments_tbl
    (
        customer_id,
        employee_id,
        appt_date,
        appt_time,
        notes,
        appt_status,
        created_at
    )
    VALUES
    (?, NULL, ?, ?, ?, 'waiting for approval', NOW())
");

$stmt->bind_param(
    "isss",
    $customerId,
    $apptDate,
    $apptTime,
    $notes
);

$conn->begin_transaction();
$checkStmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM appointments_tbl
    WHERE appt_date = ?
    AND appt_time = ?
    AND appt_status != 'cancelled'
");

$checkStmt->bind_param("ss", $apptDate, $apptTime);
$checkStmt->execute();

$result = $checkStmt->get_result()->fetch_assoc();

if ($result['total'] > 0) {
    throw new Exception("Selected time slot is already booked.");
}

$checkStmt->close();

try {
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $apptId = $conn->insert_id;

    $serviceStmt = $conn->prepare("
        INSERT INTO appointment_services_tbl (appt_id, service_id)
        VALUES (?, ?)
    ");

    foreach ($services as $serviceId) {
        $serviceId = (int)$serviceId;

        if ($serviceId <= 0) {
            throw new Exception("Invalid service ID");
        }

        $serviceStmt->bind_param("ii", $apptId, $serviceId);

        if (!$serviceStmt->execute()) {
            throw new Exception($serviceStmt->error);
        }
    }

    $serviceStmt->close();
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Appointment saved."
    ]);

} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$stmt->close();
$conn->close();
?>