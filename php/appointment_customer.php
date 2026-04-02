<?php
session_start();
include 'db_connect.php';

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

$viewMode = $_GET['view'] ?? 'book';
$isUpcomingView = ($viewMode === 'upcoming');

$appointmentFound = false;
$appointmentRow = null;

if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    $apptStmt = $conn->prepare("
        SELECT appt_date, appt_time, appt_status, created_at
        FROM appointments_tbl
        WHERE customer_id = ?
          AND appt_status IN ('waiting for approval', 'approved')
        ORDER BY appt_date ASC, appt_time ASC
        LIMIT 1
    ");
    $apptStmt->bind_param("i", $customerId);
    $apptStmt->execute();
    $apptResult = $apptStmt->get_result();

    if ($apptResult && $apptResult->num_rows > 0) {
        $appointmentFound = true;
        $appointmentRow = $apptResult->fetch_assoc();
    }

    $apptStmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isUpcomingView ? 'Upcoming Appointment' : 'Book an Appointment'; ?></title>
    <link rel="stylesheet" href="../css/appointment_customer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <div class="menu">
            <a href="homepage_customer.php">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Homepage</span>
            </a>

            <a href="appointment_customer.php" class="active">
                <i class="fa-solid fa-calendar-check"></i>
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

    <main class="main-content">
        <div class="topbar">
        <h2><?php echo $isUpcomingView ? 'Upcoming Appointment' : 'Book an Appointment'; ?></h2>

        <div class="top-icons">

            <div class="notification-wrapper">
                <button class="icon-btn" type="button" id="notificationBtn">
                    <i class="fa-solid fa-bell"></i>
                </button>

                <div class="notification-box hidden" id="notificationBox">
                    <h4>Notifications</h4>
                    <div class="notification-empty">No notification yet</div>
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

        <?php if ($isUpcomingView): ?>

    <div class="upcoming-page-card">
        <?php if (!$appointmentFound): ?>
            <div class="empty-upcoming-box">
                <i class="fa-regular fa-calendar-xmark empty-upcoming-icon"></i>
                <h1>No appointment created yet</h1>
                <p>You do not have any upcoming appointment at the moment.</p>

                <button type="button" class="next-btn" onclick="window.location.href='appointment_customer.php'">
                    Book Appointment
                </button>
            </div>
        <?php else: ?>
            <div class="upcoming-details-card">
                <h1>Your Upcoming Appointment</h1>

                <div class="confirm-detail-line">
                    <strong>Date:</strong>
                    <?php echo htmlspecialchars(date("F j, Y", strtotime($appointmentRow['appt_date']))); ?>
                </div>

                <div class="confirm-detail-line">
                    <strong>Time:</strong>
                    <?php echo htmlspecialchars(date("g:i A", strtotime($appointmentRow['appt_time']))); ?>
                </div>

                <div class="confirm-detail-line">
                    <strong>Status:</strong>
                    <span class="appointment-status-badge">
                        <?php echo htmlspecialchars($appointmentRow['appt_status']); ?>
                    </span>
                </div>

                <div class="confirm-detail-line">
                    <strong>Created at:</strong>
                    <?php echo htmlspecialchars(date("F j, Y g:i A", strtotime($appointmentRow['created_at']))); ?>
                </div>

                <div class="button-row">
                    <button type="button" class="back-btn" onclick="window.location.href='homepage_customer.php'">
                        Back
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>

        <!-- STEP 1 -->
        <div class="appointment-card step-section" id="step1">
            <h1>DETAILS</h1>

            <div class="details-grid">
                <div class="left-panel">
                    <h2 class="section-title">Choose Date</h2>

                    <div class="calendar-card">
                        <div class="calendar-header">
                            <button type="button" class="month-btn" id="prevMonth">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>

                            <h3 id="monthYear">May 2025</h3>

                            <button type="button" class="month-btn" id="nextMonth">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="weekdays">
                            <span>Sun</span>
                            <span>Mon</span>
                            <span>Tue</span>
                            <span>Wed</span>
                            <span>Th</span>
                            <span>Fri</span>
                            <span>Sat</span>
                        </div>

                        <div class="calendar-grid" id="calendarGrid"></div>
                    </div>

                    <button type="button" class="time-select-btn" id="openTimePopup">
                        <span id="selectedTimeText">Choose Time</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <input type="hidden" id="selectedDate">
                    <input type="hidden" id="selectedTime">
                </div>

                <div class="right-panel">
                    <div class="info-box">
                        <h2>Personal Information</h2>

                        <div class="name-row">
                            <input type="text" id="firstName" placeholder="First Name">
                            <input type="text" id="middleName" placeholder="Middle Name">
                        </div>

                        <input type="text" id="lastName" placeholder="Last Name">
                        <input type="text" id="mobileNumber" placeholder="Mobile Number">
                        <input type="email" id="emailAddress" placeholder="Email Address">
                        <textarea id="vehicleModel" placeholder="Vehicle Name/Model"></textarea>
                    </div>
                </div>
            </div>

            <div class="button-row">
                <button type="button" class="back-btn" onclick="goHome()">Back</button>
                <button type="button" class="next-btn" id="step1NextBtn">Next</button>
            </div>
        </div>

        <!-- STEP 2 -->
        <div class="purpose-card step-section hidden-step" id="step2">
            <h1>PURPOSE OF APPOINTMENT</h1>

            <div class="purpose-grid">
                <div class="services-section">
                    <h2>SERVICES</h2>

                    <div class="service-list">
                        <button type="button" class="service-item">TIRE AND WHEEL CHANGE</button>
                        <button type="button" class="service-item">UNDERCHASSIS</button>
                        <button type="button" class="service-item">VULCANIZE</button>
                        <button type="button" class="service-item">BATTERY CHANGE</button>
                    </div>

                    <textarea id="notes" class="notes-box" placeholder="Notes:"></textarea>
                </div>

                <div class="products-section">
                    <h2>PRODUCTS</h2>

                    <div class="product-group">
                        <button type="button" class="product-title selectable-product">TIRES</button>

                        <div class="dropdown-group">
                            <button type="button" class="fake-dropdown" data-type="size">
                                <span class="dropdown-label">Size</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                            <button type="button" class="fake-dropdown" data-type="brand">
                                <span class="dropdown-label">Brand</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>

                        <div class="quantity-row">
                            <button type="button" class="qty-btn" data-group="tires">1</button>
                            <button type="button" class="qty-btn" data-group="tires">2</button>
                            <button type="button" class="qty-btn" data-group="tires">3</button>
                            <button type="button" class="qty-btn" data-group="tires">4</button>
                        </div>
                    </div>

                    <div class="product-group">
                        <button type="button" class="product-title selectable-product">BATTERIES</button>

                        <div class="dropdown-group">
                            <button type="button" class="fake-dropdown" data-type="size">
                                <span class="dropdown-label">Size</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                            <button type="button" class="fake-dropdown" data-type="brand">
                                <span class="dropdown-label">Brand</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>

                    <div class="product-group">
                        <button type="button" class="product-title selectable-product">MAGWHEELS</button>

                        <div class="dropdown-group">
                            <button type="button" class="fake-dropdown" data-type="size">
                                <span class="dropdown-label">Size</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                            <button type="button" class="fake-dropdown" data-type="brand">
                                <span class="dropdown-label">Brand</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>

                        <div class="quantity-row">
                            <button type="button" class="qty-btn" data-group="magwheels">1</button>
                            <button type="button" class="qty-btn" data-group="magwheels">2</button>
                            <button type="button" class="qty-btn" data-group="magwheels">3</button>
                            <button type="button" class="qty-btn" data-group="magwheels">4</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-row">
                <button type="button" class="back-btn" id="step2BackBtn">Back</button>
                <button type="button" class="next-btn" id="step2NextBtn">Next</button>
            </div>
        </div>

        <!-- STEP 3 -->
        <div class="confirmation-card step-section hidden-step" id="step3">
            <h1>Confirmation Page</h1>

            <div class="confirm-box">
                <div class="confirm-header-row">
                    <h2>Personal Info</h2>
                </div>

                <div class="confirm-line">
                    <div class="confirm-text">
                        <strong>Name :</strong>
                        <span id="confirmNameText">-</span>

                        <div class="edit-input-group hidden-edit" id="nameEditGroup">
                            <input type="text" id="editFirstName" placeholder="First Name">
                            <input type="text" id="editMiddleName" placeholder="Middle Name">
                            <input type="text" id="editLastName" placeholder="Last Name">
                        </div>
                    </div>
                    <button type="button" class="edit-btn" data-edit="name">Edit</button>
                </div>

                <div class="confirm-line">
                    <div class="confirm-text">
                        <strong>Mobile Number:</strong>
                        <span id="confirmMobileText">-</span>

                        <div class="edit-input-group hidden-edit" id="mobileEditGroup">
                            <input type="text" id="editMobileNumber" placeholder="Mobile Number">
                        </div>
                    </div>
                    <button type="button" class="edit-btn" data-edit="mobile">Edit</button>
                </div>

                <div class="confirm-line">
                    <div class="confirm-text">
                        <strong>Email:</strong>
                        <span id="confirmEmailText">-</span>

                        <div class="edit-input-group hidden-edit" id="emailEditGroup">
                            <input type="email" id="editEmailAddress" placeholder="Email Address">
                        </div>
                    </div>
                    <button type="button" class="edit-btn" data-edit="email">Edit</button>
                </div>
            </div>

            <div class="confirm-box">
                <div class="confirm-header-row">
                    <h2>Appointment Details</h2>
                    <button type="button" class="edit-btn" id="appointmentDetailsEditBtn">Edit</button>
                </div>

                <div class="confirm-detail-line"><strong>Date:</strong> <span id="confirmDateText">-</span></div>
                <div class="confirm-detail-line"><strong>Time:</strong> <span id="confirmTimeText">-</span></div>
                <div class="confirm-detail-line"><strong>Purpose of Visit:</strong> <span id="confirmPurposeText">-</span></div>
                <div class="confirm-detail-line"><span id="confirmProductText"></span></div>
                <div class="confirm-detail-line"><span id="confirmNotesText"></span></div>
            </div>

            <div class="button-row">
                <button type="button" class="back-btn" id="step3BackBtn">Back</button>
                <button type="button" class="next-btn" id="finishBtn">Finish</button>
            </div>
        </div>
    </main>
</div>

<!-- TIME POPUP -->
<div class="popup-overlay" id="timePopupOverlay">
    <div class="time-popup">
        <div class="popup-header">
            <h3>Choose Time</h3>
            <button type="button" class="close-popup" id="closeTimePopup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <p class="popup-note">Service hours: 8:00 AM to 7:00 PM</p>
        <div class="time-options" id="timeOptions"></div>
    </div>
</div>

<!-- DROPDOWN POPUP -->
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <div class="popup-header">
            <h3 id="popupTitle">Options</h3>
            <button type="button" class="close-popup" id="closePopup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="popup-content" id="popupContent"></div>
    </div>
</div>

<!-- PAYMENT POPUP -->
<div class="popup-overlay" id="paymentPopupOverlay">
    <div class="payment-popup">
        <div class="popup-header">
            <h3>Reservation Payment</h3>
            <button type="button" class="close-popup" id="closePaymentPopup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="payment-content">
            <p class="payment-text">
                To continue with your appointment reservation, please send the reservation payment using the details below.
            </p>

            <div class="payment-methods">
                <div class="payment-box">
                    <h4>QR PH / GCash / Maya</h4>

                    <!-- CHANGE THIS IMAGE PATH WHEN YOU HAVE THE REAL QR -->
                    <img src="../pictures/fake_qr.png" alt="QR Payment" class="payment-qr">
                </div>

                <div class="payment-box">
                    <h4>Mobile Number</h4>

                    <!-- CHANGE THIS NUMBER WHEN YOU HAVE THE REAL GCASH / MAYA NUMBER -->
                    <p class="payment-number">09XX-XXX-XXXX</p>

                    <p class="payment-note">
                        You may use this number for GCash or Maya payment.
                    </p>
                </div>
            </div>

            <div class="payment-buttons">
                <button type="button" class="cancel-payment-btn" id="cancelPaymentBtn">Cancel</button>
                <button type="button" class="done-payment-btn" id="donePaymentBtn">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- APPOINTMENT CREATED POPUP -->
<div class="popup-overlay" id="successPopupOverlay">
    <div class="success-popup">
        <div class="popup-header">
            <h3>Appointment Created</h3>
            <button type="button" class="close-popup" id="closeSuccessPopup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="success-content">
            <p class="success-message">
                Your appointment has been created.
            </p>

            <p class="success-instruction">
                Please screenshot your reservation payment and send it through Facebook Messenger for payment confirmation.
            </p>

            <!-- CHANGE THIS LINK WHEN YOU HAVE THE REAL FACEBOOK PAGE LINK -->
            <a href="https://www.facebook.com/" target="_blank" class="facebook-link">
                Open Facebook Messenger Page
            </a>

            <div class="payment-buttons">
                <button type="button" class="done-payment-btn" id="closeSuccessBtn">OK</button>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<script src="../js/appointment_customer.js"></script>
</body>
</html>