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
$customerNotifications = dh_get_customer_notifications($conn, $_SESSION['customer_id'] ?? null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Homepage</title>

    <link rel="stylesheet" href="../css/homepage_customer.css">
    <link rel="stylesheet" href="../css/customer_ui_shared.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="home-shell">
        <?php dh_render_customer_sidebar('home', $hasExistingAppointment, 'menu', $topProfileImage, $customerNotifications); ?>

        <section class="hero-section">
            <div class="hero-copy">
                <h1>Your Trusted Partner for Tire and Auto Care</h1>
                <p>
                    Fast, reliable, and honest service for tire replacement, battery support,
                    wheel alignment prep, and underchassis checks.
                </p>
            </div>
        </section>

        <section class="appointment-summary-row">
            <div class="book-card-mini">
                <div class="book-mini-icon"><i class="fa-regular fa-calendar-plus"></i></div>
                <div>
                    <h3>Need Service Today?</h3>
                    <p>Reserve your preferred date and time in a few clicks.</p>
                </div>
                <button
                    class="book-mini-btn"
                    id="bookAppointmentBtnSecondary"
                    data-has-existing-appointment="<?php echo $hasExistingAppointment ? '1' : '0'; ?>"
                >
                    Book Now
                </button>
            </div>

            <div class="appointment-card" id="upcomingAppointmentCard" data-link="<?php echo htmlspecialchars($upcomingLink); ?>">
                <div class="appointment-icon">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="appointment-details">
                    <h3>Upcoming Appointment</h3>
                    <p><?php echo htmlspecialchars($upcomingText); ?></p>
                </div>
                <span class="appointment-open">View</span>
            </div>
        </section>

        <section class="services-area">
            <div class="services-heading">
                <h2>Our Automotive Services</h2>
                <p>Choose from our most requested services designed for safe, smooth, and reliable driving.</p>
            </div>

            <div class="services-grid-home">
                <article class="service-tile">
                    <div class="service-icon"><i class="fa-solid fa-car-battery"></i></div>
                    <h3>Battery Change</h3>
                    <p>Quick replacement and terminal check to keep your vehicle starting strong.</p>
                </article>

                <article class="service-tile">
                    <div class="service-icon"><i class="fa-solid fa-compact-disc"></i></div>
                    <h3>Tire & Wheel Change</h3>
                    <p>Safe tire and wheel fitting with proper size and compatibility guidance.</p>
                </article>

                <article class="service-tile">
                    <div class="service-icon"><i class="fa-solid fa-circle-dot"></i></div>
                    <h3>Magwheel Change</h3>
                    <p>Upgrade or replace magwheels with secure installation and balancing support.</p>
                </article>

                <article class="service-tile">
                    <div class="service-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <h3>Underchassis</h3>
                    <p>Inspection for steering and suspension issues affecting comfort and stability.</p>
                </article>

                <article class="service-tile">
                    <div class="service-icon"><i class="fa-solid fa-life-ring"></i></div>
                    <h3>Vulcanize</h3>
                    <p>Puncture repair service to restore tire usability and reduce roadside risk.</p>
                </article>
            </div>
        </section>

        <section class="location-section">
            <div class="location-card">
                <div class="location-image">
                    <img src="../pictures/Location.png" alt="D.H Azada Tire Supply Location">
                </div>
                <div class="location-content">
                    <h2>Visit Our Location</h2>
                    <p>Drop by our shop for tire, battery, wheel, and underchassis services.</p>
                    <div class="location-address">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Kaypian Road Barangay Kaypian San Jose Del Monte City, Bulacan, Philippines</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="../js/customer_ui_shared.js"></script>
    <script src="../js/homepage_customer.js"></script>
</body>
</html>
