<?php
session_start();
include 'db_connect.php';

$upcomingTitle = "UPCOMING APPOINTMENT";
$upcomingText = "No upcoming appointment";
$upcomingLink = "appointment_customer.php?view=upcoming";

if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    $apptStmt = $conn->prepare("
        SELECT appt_date, appt_time, appt_status
        FROM appointments_tbl
        WHERE customer_id = ?
          AND appt_status IN ('waiting for approval', 'approved')
        ORDER BY appt_date ASC, appt_time ASC
        LIMIT 1
    ");
    $apptStmt->bind_param("i", $customerId);
    $apptStmt->execute();
    $apptResult = $apptStmt->get_result();

    if ($apptRow = $apptResult->fetch_assoc()) {
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

$topProfileImage = "../pictures/default_profile.png";

if (isset($_SESSION['customer_id'])) {
    $stmt = $conn->prepare("SELECT profile_image FROM customer_tbl WHERE customer_id = ?");
    $stmt->bind_param("i", $_SESSION['customer_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!empty($user['profile_image'])) {
        $topProfileImage = $user['profile_image'];
    }
}
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

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-menu">
                <a href="homepage_customer.php" class="nav-item active">
                    <i class="fa-solid fa-table-cells-large"></i>
                    <span>Homepage</span>
                </a>

                <a href="appointment_customer.php" class="nav-item">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Appointment</span>
                </a>

                <a href="product_catalog.php" class="nav-item">
                    <i class="fa-solid fa-circle-notch"></i>
                    <span>Products</span>
                </a>

                <a href="services_customer.php" class="nav-item">
                    <i class="fa-solid fa-gears"></i>
                    <span>Services</span>
                </a>

                <a href="transaction_history.php" class="nav-item">
                    <i class="fa-regular fa-clock"></i>
                    <span>History</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="content-area">
            <div class="top-bar">
                <h2>Homepage</h2>

                <div class="top-actions">
                    <div class="notification-wrapper">
                        <button class="icon-btn" id="notificationBtn">
                            <i class="fa-solid fa-bell"></i>
                        </button>

                        <div class="notification-popup" id="notificationPopup">
                            <p>No notification yet</p>
                        </div>
                    </div>

                    <div class="profile-dropdown">
                        <button type="button" class="profile-btn" id="profileToggle">
                            <img src="<?php echo htmlspecialchars($topProfileImage); ?>" class="top-profile-img" alt="Profile">
                        </button>

                        <div class="profile-menu hidden" id="profileMenu">
                            <a href="profile_customer.php">Profile</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h1 class="welcome-text">Welcome User</h1>

            <div class="top-cards">
                <button class="book-card" id="bookAppointmentBtn">
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

    <script src="../js/homepage_customer.js"></script>
</body>
</html>