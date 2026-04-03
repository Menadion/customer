<?php
session_start();
include 'db_connect.php';

$topProfileImage = "../pictures/default_profile.png";

$customerFirstName = "";
$customerMiddleName = "";
$customerLastName = "";
$customerMobile = "";
$customerEmail = "";
$customerVehicleModel = "";

if (isset($_SESSION['customer_id'])) {
    $stmt = $conn->prepare("
        SELECT 
            profile_image,
            fname,
            mname,
            lname,
            mobile_number,
            email,
            vehicle_type
        FROM customer_tbl
        WHERE customer_id = ?
    ");
    $stmt->bind_param("i", $_SESSION['customer_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        if (!empty($user['profile_image'])) {
            $topProfileImage = $user['profile_image'];
        }

        $customerFirstName = $user['fname'] ?? "";
        $customerMiddleName = $user['mname'] ?? "";
        $customerLastName = $user['lname'] ?? "";
        $customerMobile = $user['mobile_number'] ?? "";
        $customerEmail = $user['email'] ?? "";
        $customerVehicleModel = $user['vehicle_type'] ?? "";
    }
}

$viewMode = $_GET['view'] ?? 'book';
$isUpcomingView = ($viewMode === 'upcoming');

$appointmentFound = false;
$appointmentRow = null;

if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    $apptStmt = $conn->prepare("
        SELECT 
        appt_date,
        appt_time,
        appt_status,
        created_at,
        purpose,
        notes,
        tires_product_id,
        tires_qty,
        batteries_product_id,
        magwheels_product_id,
        magwheels_qty,
        total_cost
        FROM appointments_tbl
        WHERE customer_id = ?
        AND appt_status IN ('waiting for approval','approved')
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

    $upcomingTireText = "-";
    $upcomingBatteryText = "-";
    $upcomingMagwheelText = "-";

    if ($appointmentFound && $appointmentRow) {
        if (!empty($appointmentRow['tires_product_id'])) {
            $stmt = $conn->prepare("SELECT brand, size, price FROM product_tbl WHERE product_id = ? LIMIT 1");
            $stmt->bind_param("i", $appointmentRow['tires_product_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $qty = (int)($appointmentRow['tires_qty'] ?? 1);
                $upcomingTireText = $qty . "x " . $row['brand'] . " " . $row['size'] . " - PHP " . number_format($row['price'], 2);
            }
            $stmt->close();
        }

        if (!empty($appointmentRow['batteries_product_id'])) {
            $stmt = $conn->prepare("SELECT brand, size, price FROM product_tbl WHERE product_id = ? LIMIT 1");
            $stmt->bind_param("i", $appointmentRow['batteries_product_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $upcomingBatteryText = $row['brand'] . " " . $row['size'] . " - PHP " . number_format($row['price'], 2);
            }
            $stmt->close();
        }

        if (!empty($appointmentRow['magwheels_product_id'])) {
            $stmt = $conn->prepare("SELECT brand, size, price FROM product_tbl WHERE product_id = ? LIMIT 1");
            $stmt->bind_param("i", $appointmentRow['magwheels_product_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $qty = (int)($appointmentRow['magwheels_qty'] ?? 1);
                $upcomingMagwheelText = $qty . "x " . $row['brand'] . " " . $row['size'] . " - PHP " . number_format($row['price'], 2);
            }
            $stmt->close();
        }
    }
}

$appointmentProducts = [
    'tires' => [],
    'batteries' => [],
    'magwheels' => []
];

$productQuery = $conn->query("
    SELECT 
        p.product_id,
        p.item_name,
        p.brand,
        p.size,
        p.price,
        p.category,
        p.status,
        COALESCE(SUM(sb.quantity), 0) AS stock
    FROM product_tbl p
    LEFT JOIN stockbatch_tbl sb ON p.product_id = sb.product_id
    WHERE p.category IN ('tire', 'battery', 'rim')
    GROUP BY p.product_id, p.item_name, p.brand, p.size, p.price, p.category, p.status
    ORDER BY p.category, p.brand, p.size
");

if ($productQuery) {
    while ($row = $productQuery->fetch_assoc()) {
        if ($row['category'] === 'tire') {
            $appointmentProducts['tires'][] = $row;
        } elseif ($row['category'] === 'battery') {
            $appointmentProducts['batteries'][] = $row;
        } elseif ($row['category'] === 'rim') {
            $appointmentProducts['magwheels'][] = $row;
        }
    }
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

                <div class="confirm-detail-line">
                    <strong>Purpose:</strong>
                    <?php echo !empty($appointmentRow['purpose']) ? htmlspecialchars($appointmentRow['purpose']) : '-'; ?>
                </div>

                <div class="confirm-detail-line">
                    <strong>Tires:</strong>
                    <?php echo htmlspecialchars($upcomingTireText); ?>
                </div>

                <div class="confirm-detail-line">
                    <strong>Battery:</strong>
                    <?php echo htmlspecialchars($upcomingBatteryText); ?>
                </div>

                <div class="confirm-detail-line">
                    <strong>Magwheels:</strong>
                    <?php echo htmlspecialchars($upcomingMagwheelText); ?>
                </div>

                <div class="confirm-detail-line">
                    <strong>Notes:</strong>
                    <?php echo !empty($appointmentRow['notes']) ? htmlspecialchars($appointmentRow['notes']) : '-'; ?>
                </div>

                <div class="confirm-detail-line">
                    <strong>Total Cost:</strong>
                    <?php echo "PHP " . number_format((float)($appointmentRow['total_cost'] ?? 0), 2); ?>
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
                            <input type="text" id="firstName" placeholder="First Name" value="<?php echo htmlspecialchars($customerFirstName); ?>">
                            <input type="text" id="middleName" placeholder="Middle Name" value="<?php echo htmlspecialchars($customerMiddleName); ?>">
                        </div>

                        <input type="text" id="lastName" placeholder="Last Name" value="<?php echo htmlspecialchars($customerLastName); ?>">
                        <input type="text" id="mobileNumber" placeholder="Mobile Number" value="<?php echo htmlspecialchars($customerMobile); ?>">
                        <input type="email" id="emailAddress" placeholder="Email Address" value="<?php echo htmlspecialchars($customerEmail); ?>">
                        <textarea id="vehicleModel" placeholder="Vehicle Name/Model"><?php echo htmlspecialchars($customerVehicleModel); ?></textarea>
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
                        <button type="button" class="service-item" data-enables="tires">TIRE AND WHEEL CHANGE</button>
                        <button type="button" class="service-item" data-enables="batteries">BATTERY CHANGE</button>
                        <button type="button" class="service-item" data-enables="magwheels">MAGWHEEL CHANGE</button>
                        <button type="button" class="service-item">UNDERCHASSIS</button>
                        <button type="button" class="service-item">VULCANIZE</button>
                    </div>

                    <textarea id="notes" class="notes-box" placeholder="Notes:"></textarea>
                </div>

                <div class="products-section">
                        <h2>PRODUCTS</h2>

                        <!-- TIRES -->
                        <div class="product-group product-group-disabled" data-product-group="tires">
                            <button type="button" class="product-title selectable-product">TIRES</button>

                            <button type="button"
                                    class="select-product-btn"
                                    data-product-type="tires">
                                Select Brand and Size
                            </button>

                            <div class="selected-product-info" id="tiresSelectedInfo">
                                <div><strong>Selected:</strong> <span id="tiresSelectedText">None</span></div>
                                <div><strong>Price:</strong> <span id="tiresPriceText">-</span></div>
                            </div>

                            <div class="quantity-simple-row">
                                <label for="tiresQtyInput">Quantity</label>
                                <input type="number" id="tiresQtyInput" class="qty-number-input" min="1" max="4" value="1">
                            </div>

                            <input type="hidden" id="tiresProductId">
                        </div>

                        <!-- BATTERIES -->
                        <div class="product-group product-group-disabled" data-product-group="batteries">
                            <button type="button" class="product-title selectable-product">BATTERIES</button>

                            <button type="button"
                                    class="select-product-btn"
                                    data-product-type="batteries">
                                Select Brand and Size
                            </button>

                            <div class="selected-product-info" id="batteriesSelectedInfo">
                                <div><strong>Selected:</strong> <span id="batteriesSelectedText">None</span></div>
                                <div><strong>Price:</strong> <span id="batteriesPriceText">-</span></div>
                            </div>

                            <input type="hidden" id="batteriesProductId">
                        </div>

                        <!-- MAGWHEELS -->
                        <div class="product-group product-group-disabled" data-product-group="magwheels">
                            <button type="button" class="product-title selectable-product">MAGWHEELS</button>

                            <button type="button"
                                    class="select-product-btn"
                                    data-product-type="magwheels">
                                Select Brand and Size
                            </button>

                            <div class="selected-product-info" id="magwheelsSelectedInfo">
                                <div><strong>Selected:</strong> <span id="magwheelsSelectedText">None</span></div>
                                <div><strong>Price:</strong> <span id="magwheelsPriceText">-</span></div>
                            </div>

                            <div class="quantity-simple-row">
                                <label for="magwheelsQtyInput">Quantity</label>
                                <input type="number" id="magwheelsQtyInput" class="qty-number-input" min="1" max="4" value="1">
                            </div>

                            <input type="hidden" id="magwheelsProductId">
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
                    <h2>Appointment Details</h2>
                    <button type="button" class="edit-btn" id="appointmentDetailsEditBtn">Edit</button>
                </div>

                <div class="confirm-detail-line"><strong>Full Name:</strong> <span id="confirmNameText">-</span></div>
                <div class="confirm-detail-line"><strong>Mobile Number:</strong> <span id="confirmMobileText">-</span></div>
                <div class="confirm-detail-line"><strong>Email:</strong> <span id="confirmEmailText">-</span></div>
                <div class="confirm-detail-line"><strong>Vehicle Name/Model:</strong> <span id="confirmVehicleText">-</span></div>
                <div class="confirm-detail-line"><strong>Date:</strong> <span id="confirmDateText">-</span></div>
                <div class="confirm-detail-line"><strong>Time:</strong> <span id="confirmTimeText">-</span></div>
                <div class="confirm-detail-line"><strong>Purpose of Visit:</strong> <span id="confirmPurposeText">-</span></div>
                <div class="confirm-detail-line"><span id="confirmProductText"></span></div>
                <div class="confirm-detail-line"><span id="confirmNotesText"></span></div>
                <div class="confirm-detail-line"><strong>Total Cost:</strong> <span id="confirmTotalText">PHP 0.00</span></div>
            </div>

            <div class="button-row">
                <button type="button" class="back-btn" id="step3BackBtn">Back</button>
                <button type="button" class="next-btn" id="finishBtn">Finish</button>
            </div>
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
    <div class="product-picker-popup">
        <div class="popup-header">
            <h3 id="popupTitle">Select Product</h3>
            <button type="button" class="close-popup" id="closePopup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="product-picker-toolbar">
            <input type="text" id="popupSearchInput" placeholder="Search brand or size">

            <select id="popupSortSelect" class="popup-sort-select">
                <option value="default">Sort By</option>
                <option value="price_asc">Low to High Cost</option>
                <option value="price_desc">High to Low Cost</option>
                <option value="brand_asc">Alphabetical A - Z</option>
                <option value="brand_desc">Alphabetical Z - A</option>
            </select>
        </div>

        <div class="product-picker-table-header">
            <div>BRAND</div>
            <div>SIZE</div>
            <div>PRICE</div>
            <div>STOCK</div>
            <div>STATUS</div>
        </div>

        <div class="product-picker-list" id="popupProductList"></div>
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

            <div class="payment-summary-box">
                <div class="payment-summary-line">
                    <strong>Total Cost:</strong>
                    <span id="paymentTotalText">PHP 0.00</span>
                </div>
                <div class="payment-summary-line">
                    <strong>Reservation Fee (30%):</strong>
                    <span id="reservationFeeText">PHP 0.00</span>
                </div>
            </div>

            <div class="payment-methods">
                <div class="payment-box">
                    <h4>QR PH / GCash / Maya</h4>

                    <img src="../pictures/fake_qr.png" alt="QR Payment" class="payment-qr">
                </div>

                <div class="payment-box">
                    <h4>Mobile Number</h4>

                    <p class="payment-number">09XX-XXX-XXXX</p>

                    <p class="payment-note">
                        Please send exactly the reservation fee amount shown above.
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
<script>
const appointmentProductData = <?php echo json_encode($appointmentProducts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>
</body>
</html>