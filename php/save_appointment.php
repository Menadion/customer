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

$existingStmt = $conn->prepare("
    SELECT appt_id
    FROM appointments_tbl
    WHERE customer_id = ?
      AND appt_status IN ('waiting for approval', 'approved')
    LIMIT 1
");
$existingStmt->bind_param("i", $customerId);
$existingStmt->execute();
$existingResult = $existingStmt->get_result();

if ($existingResult && $existingResult->num_rows > 0) {
    $existingStmt->close();
    echo json_encode([
        "success" => false,
        "message" => "You can't create more appointments because you already have an existing appointment."
    ]);
    exit();
}
$existingStmt->close();

$apptDate = $_POST['appt_date'] ?? '';
$apptTimeRaw = $_POST['appt_time'] ?? '';
$purpose = trim($_POST['purpose'] ?? '');
$notes = trim($_POST['notes'] ?? '');

$tiresProductId = !empty($_POST['tires_product_id']) ? (int)$_POST['tires_product_id'] : null;
$tiresQty = !empty($_POST['tires_qty']) ? (int)$_POST['tires_qty'] : null;

$batteriesProductId = !empty($_POST['batteries_product_id']) ? (int)$_POST['batteries_product_id'] : null;

$magwheelsProductId = !empty($_POST['magwheels_product_id']) ? (int)$_POST['magwheels_product_id'] : null;
$magwheelsQty = !empty($_POST['magwheels_qty']) ? (int)$_POST['magwheels_qty'] : null;

if ($apptDate === '' || $apptTimeRaw === '') {
    echo json_encode([
        "success" => false,
        "message" => "Date and time are required."
    ]);
    exit();
}

$timeObj = DateTime::createFromFormat('g:i A', $apptTimeRaw);
if (!$timeObj) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid time format."
    ]);
    exit();
}
$apptTime = $timeObj->format('H:i:s');

$totalCost = 0;

if ($tiresProductId) {
    $stmtTire = $conn->prepare("SELECT price FROM product_tbl WHERE product_id = ? LIMIT 1");
    $stmtTire->bind_param("i", $tiresProductId);
    $stmtTire->execute();
    $resultTire = $stmtTire->get_result();
    if ($rowTire = $resultTire->fetch_assoc()) {
        $totalCost += ((float)$rowTire['price']) * ($tiresQty ?: 1);
    }
    $stmtTire->close();
}

if ($batteriesProductId) {
    $stmtBattery = $conn->prepare("SELECT price FROM product_tbl WHERE product_id = ? LIMIT 1");
    $stmtBattery->bind_param("i", $batteriesProductId);
    $stmtBattery->execute();
    $resultBattery = $stmtBattery->get_result();
    if ($rowBattery = $resultBattery->fetch_assoc()) {
        $totalCost += (float)$rowBattery['price'];
    }
    $stmtBattery->close();
}

if ($magwheelsProductId) {
    $stmtMag = $conn->prepare("SELECT price FROM product_tbl WHERE product_id = ? LIMIT 1");
    $stmtMag->bind_param("i", $magwheelsProductId);
    $stmtMag->execute();
    $resultMag = $stmtMag->get_result();
    if ($rowMag = $resultMag->fetch_assoc()) {
        $totalCost += ((float)$rowMag['price']) * ($magwheelsQty ?: 1);
    }
    $stmtMag->close();
}

$stmt = $conn->prepare("
    INSERT INTO appointments_tbl
    (
        customer_id,
        service_id,
        employee_id,
        appt_date,
        appt_time,
        purpose,
        notes,
        tires_product_id,
        tires_qty,
        batteries_product_id,
        magwheels_product_id,
        magwheels_qty,
        total_cost,
        appt_status,
        created_at
    )
    VALUES
    (?, NULL, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'waiting for approval', NOW())
");

$stmt->bind_param(
    "issssiiiiid",
    $customerId,
    $apptDate,
    $apptTime,
    $purpose,
    $notes,
    $tiresProductId,
    $tiresQty,
    $batteriesProductId,
    $magwheelsProductId,
    $magwheelsQty,
    $totalCost
);

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