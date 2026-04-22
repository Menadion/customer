<?php
session_start();
include 'db_connect.php';
include 'customer_ui.php';

$upcomingTitle = "UPCOMING APPOINTMENT";
$upcomingText = "No upcoming appointment";
$upcomingLink = "appointment_customer.php?view=upcoming";
$hasExistingAppointment = false;

if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    $apptStmt = $conn->prepare("
    SELECT a.appt_id, a.appt_date, a.appt_time, a.appt_status
    FROM appointments_tbl a
    WHERE a.customer_id = ?
      AND (
            a.appt_status = 'waiting for approval'
            OR (
                a.appt_status = 'approved'
                AND NOT EXISTS (
                    SELECT 1
                    FROM transaction_tbl t
                    WHERE t.appt_id = a.appt_id
                )
            )
          )
    ORDER BY a.appt_date ASC, a.appt_time ASC
    LIMIT 1
");
    $apptStmt->bind_param("i", $customerId);
    $apptStmt->execute();
    $apptResult = $apptStmt->get_result();

    if ($apptRow = $apptResult->fetch_assoc()) {
        $hasExistingAppointment = true;

        $formattedDate = date("F j, Y", strtotime($apptRow['appt_date']));
        $formattedTime = date("g:i A", strtotime($apptRow['appt_time']));

        if ($apptRow['appt_status'] === 'waiting for approval') {
            $upcomingText = "Waiting for approval";
        } else {
            $upcomingText = "Approved - " . $formattedDate . " at " . $formattedTime;
        }

        $upcomingLink = "appointment_customer.php?view=upcoming";
    }

    $apptStmt->close();
}

$topProfileImage = dh_get_customer_profile_image($conn, $_SESSION['customer_id'] ?? null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Homepage</title>

    <link rel="stylesheet" href="../css/homepage_customer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="main-layout">

        <?php dh_render_customer_sidebar('home', $hasExistingAppointment, 'sidebar-menu'); ?>

        <!-- Main Content -->
        <main class="content-area">
            <div class="top-bar">
                <h2>Homepage</h2>

                <?php dh_render_top_actions($topProfileImage, 'popup', 'top-actions'); ?>
            </div>

            <hr>

            <h1 class="welcome-text">Welcome User</h1>

            <div class="top-cards">
                <button
                    class="book-card"
                    id="bookAppointmentBtn"
                    data-has-existing-appointment="<?php echo $hasExistingAppointment ? '1' : '0'; ?>"
                >
                    <div class="book-icon">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <span>Book Appointment</span>
                </button>

                <div class="appointment-card" id="upcomingAppointmentCard" data-link="<?php echo htmlspecialchars($upcomingLink); ?>">
                    <div class="appointment-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <div class="appointment-details">
                        <h3>UPCOMING APPOINTMENT</h3>
                        <p><?php echo htmlspecialchars($upcomingText); ?></p>
                    </div>
                </div>
            </div>

            <hr class="section-line">

            <h2 class="services-title">Services</h2>

            <div class="services-slider">
                <div class="slide active" data-index="0">
                    <div class="slide-overlay">
                        <h3>Wheel Change</h3>
                        <p>
                            We change wheels for different vehicle types, from sedans to SUVs,
                            vans, and truck-type vehicles, with proper fitting and safe installation.
                        </p>
                    </div>
                </div>

                <div class="slide" data-index="1">
                    <div class="slide-overlay">
                        <h3>Battery Change</h3>
                        <p>
                            We provide battery replacement service with proper installation,
                            terminal checking, and dependable power support for your vehicle.
                        </p>
                    </div>
                </div>

                <div class="slide" data-index="2">
                    <div class="slide-overlay">
                        <h3>Under Chassis</h3>
                        <p>
                            We inspect and service under chassis parts to help maintain vehicle
                            stability, steering performance, and smoother driving condition.
                        </p>
                    </div>
                </div>

                <div class="slider-dots">
                    <span class="dot active" data-slide="0"></span>
                    <span class="dot" data-slide="1"></span>
                    <span class="dot" data-slide="2"></span>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/customer_ui_shared.js"></script>
    <script src="../js/homepage_customer.js"></script>
</body>
</html>
