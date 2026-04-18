<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

function respond($success, $message) {
    echo json_encode([
        "success" => $success,
        "message" => $message
    ]);
    exit();
}

function parseTimeTo24($timeRaw) {
    $timeObj = DateTime::createFromFormat('g:i A', $timeRaw);
    if (!$timeObj) {
        return null;
    }
    return $timeObj->format('H:i:s');
}

function toMinutesFromTime($time24) {
    $parts = explode(':', $time24);
    if (count($parts) < 2) return null;
    return ((int)$parts[0] * 60) + (int)$parts[1];
}

function purposeHasUnderchassis($purposeText) {
    return stripos((string)$purposeText, 'UNDERCHASSIS') !== false;
}

if (!isset($_SESSION['customer_id'])) {
    respond(false, "User not logged in.");
}

$customerId = (int)$_SESSION['customer_id'];

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
    respond(false, "You can't create more appointments because you already have an existing appointment.");
}
$existingStmt->close();

$apptDate = trim($_POST['appt_date'] ?? '');
$apptTimeRaw = trim($_POST['appt_time'] ?? '');
$purpose = trim($_POST['purpose'] ?? '');
$notes = trim($_POST['notes'] ?? '');
$reservationReference = trim($_POST['reservation_reference'] ?? '');

$tiresProductId = !empty($_POST['tires_product_id']) ? (int)$_POST['tires_product_id'] : null;
$tiresQty = !empty($_POST['tires_qty']) ? (int)$_POST['tires_qty'] : null;
$batteriesProductId = !empty($_POST['batteries_product_id']) ? (int)$_POST['batteries_product_id'] : null;
$magwheelsProductId = !empty($_POST['magwheels_product_id']) ? (int)$_POST['magwheels_product_id'] : null;
$magwheelsQty = !empty($_POST['magwheels_qty']) ? (int)$_POST['magwheels_qty'] : null;

$serviceTires = ($_POST['service_tires'] ?? '0') === '1';
$serviceBatteries = ($_POST['service_batteries'] ?? '0') === '1';
$serviceMagwheels = ($_POST['service_magwheels'] ?? '0') === '1';
$serviceUnderchassis = ($_POST['service_underchassis'] ?? '0') === '1';
$serviceVulcanize = ($_POST['service_vulcanize'] ?? '0') === '1';
$currentUsesUnderchassisPool = $serviceUnderchassis;
$slotLimit = $currentUsesUnderchassisPool ? 2 : 3;

if ($apptDate === '' || $apptTimeRaw === '') {
    respond(false, "Date and time are required.");
}

$apptTime = parseTimeTo24($apptTimeRaw);
if ($apptTime === null) {
    respond(false, "Invalid time format.");
}

if ($reservationReference === '') {
    respond(false, "Reference number is required.");
}

if (!isset($_FILES['payment_proof']) || !is_array($_FILES['payment_proof'])) {
    respond(false, "Payment proof screenshot is required.");
}

$proofFile = $_FILES['payment_proof'];
if (($proofFile['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    respond(false, "Failed to upload payment proof.");
}

if (($proofFile['size'] ?? 0) > 5 * 1024 * 1024) {
    respond(false, "Payment proof must be 5MB or below.");
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($proofFile['tmp_name']);
$allowedMimes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
];

if (!isset($allowedMimes[$mime])) {
    respond(false, "Payment proof must be JPG, PNG, or WEBP.");
}

$totalCost = 0.0;

if ($tiresProductId) {
    $stmt = $conn->prepare("SELECT price FROM product_tbl WHERE product_id = ? LIMIT 1");
    $stmt->bind_param("i", $tiresProductId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $totalCost += ((float)$row['price']) * max(1, (int)($tiresQty ?: 1));
    }
    $stmt->close();
}

if ($batteriesProductId) {
    $stmt = $conn->prepare("SELECT price FROM product_tbl WHERE product_id = ? LIMIT 1");
    $stmt->bind_param("i", $batteriesProductId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $totalCost += (float)$row['price'];
    }
    $stmt->close();
}

if ($magwheelsProductId) {
    $stmt = $conn->prepare("SELECT price FROM product_tbl WHERE product_id = ? LIMIT 1");
    $stmt->bind_param("i", $magwheelsProductId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $totalCost += ((float)$row['price']) * max(1, (int)($magwheelsQty ?: 1));
    }
    $stmt->close();
}

$estimatedDuration = 0;
if ($serviceBatteries && $batteriesProductId) $estimatedDuration += 10;
if ($serviceTires && $tiresProductId) $estimatedDuration += 15 * max(1, (int)($tiresQty ?: 1));
if ($serviceMagwheels && $magwheelsProductId) $estimatedDuration += 15 * max(1, (int)($magwheelsQty ?: 1));
if ($serviceUnderchassis) $estimatedDuration += 60;
if ($serviceVulcanize) $estimatedDuration += 30;

if ($estimatedDuration <= 0) {
    respond(false, "Please select at least one valid service.");
}

$startMinutes = toMinutesFromTime($apptTime);
if ($startMinutes === null) {
    respond(false, "Invalid appointment start time.");
}
$endMinutes = $startMinutes + $estimatedDuration;
$openMinutes = 8 * 60;
$closeMinutes = 19 * 60;

if ($startMinutes < $openMinutes || $endMinutes > $closeMinutes) {
    respond(false, "Appointment must be within business hours (8:00 AM to 7:00 PM).");
}

$endHour = floor($endMinutes / 60);
$endMin = $endMinutes % 60;
$apptEndTime = sprintf('%02d:%02d:00', $endHour, $endMin);

$overlapQuery = $conn->prepare("
    SELECT appt_time, purpose, COALESCE(estimated_duration_minutes, 60) AS estimated_duration_minutes
    FROM appointments_tbl
    WHERE appt_date = ?
      AND appt_status IN ('waiting for approval', 'approved')
");

if (!$overlapQuery) {
    $overlapQuery = $conn->prepare("
        SELECT appt_time, purpose, 60 AS estimated_duration_minutes
        FROM appointments_tbl
        WHERE appt_date = ?
          AND appt_status IN ('waiting for approval', 'approved')
    ");
}

$overlapQuery->bind_param("s", $apptDate);
$overlapQuery->execute();
$overlapResult = $overlapQuery->get_result();

$overlapCount = 0;
while ($row = $overlapResult->fetch_assoc()) {
    $existingStart = toMinutesFromTime($row['appt_time']);
    $existingDuration = max(1, (int)($row['estimated_duration_minutes'] ?? 60));
    $existingUsesUnderchassisPool = purposeHasUnderchassis($row['purpose'] ?? '');

    if ($currentUsesUnderchassisPool !== $existingUsesUnderchassisPool) {
        continue;
    }

    $existingEnd = $existingStart + $existingDuration;

    $isOverlap = ($startMinutes < $existingEnd) && ($endMinutes > $existingStart);
    if ($isOverlap) {
        $overlapCount++;
    }
}
$overlapQuery->close();

if ($overlapCount >= $slotLimit) {
    respond(false, "Selected time slot is already full. Please choose another time.");
}

$reservationFee = round($totalCost * 0.30, 2);

$uploadDirFs = dirname(__DIR__) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "payment_proofs";
if (!is_dir($uploadDirFs) && !mkdir($uploadDirFs, 0775, true)) {
    respond(false, "Failed to prepare upload folder.");
}

$ext = $allowedMimes[$mime];
$filename = 'proof_' . $customerId . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
$targetFsPath = $uploadDirFs . DIRECTORY_SEPARATOR . $filename;

if (!move_uploaded_file($proofFile['tmp_name'], $targetFsPath)) {
    respond(false, "Failed to save payment proof.");
}

$paymentProofPath = '../uploads/payment_proofs/' . $filename;

$stmt = $conn->prepare("
    INSERT INTO appointments_tbl
    (
        customer_id,
        service_id,
        employee_id,
        appt_date,
        appt_time,
        appt_end_time,
        purpose,
        notes,
        tires_product_id,
        tires_qty,
        batteries_product_id,
        magwheels_product_id,
        magwheels_qty,
        total_cost,
        estimated_duration_minutes,
        reservation_reference,
        reservation_fee,
        payment_proof_path,
        appt_status,
        created_at
    )
    VALUES
    (?, NULL, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'waiting for approval', NOW())
");

if (!$stmt) {
    @unlink($targetFsPath);
    respond(false, "Database is missing required appointment columns. Please run the new migration SQL.");
}

$stmt->bind_param(
    "isssssiiiiidisds",
    $customerId,
    $apptDate,
    $apptTime,
    $apptEndTime,
    $purpose,
    $notes,
    $tiresProductId,
    $tiresQty,
    $batteriesProductId,
    $magwheelsProductId,
    $magwheelsQty,
    $totalCost,
    $estimatedDuration,
    $reservationReference,
    $reservationFee,
    $paymentProofPath
);

if ($stmt->execute()) {
    respond(true, "Appointment saved.");
}

@unlink($targetFsPath);
respond(false, "Failed to save appointment.");
