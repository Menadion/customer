<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($hasExistingAppointment)) {
    $hasExistingAppointment = false;
}

if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    $apptGuardStmt = $conn->prepare("
        SELECT appt_id
        FROM appointments_tbl
        WHERE customer_id = ?
          AND appt_status IN ('waiting for approval', 'approved')
        LIMIT 1
    ");
    $apptGuardStmt->bind_param("i", $customerId);
    $apptGuardStmt->execute();
    $apptGuardResult = $apptGuardStmt->get_result();

    if ($apptGuardResult && $apptGuardResult->num_rows > 0) {
        $hasExistingAppointment = true;
    }

    $apptGuardStmt->close();
}
?>