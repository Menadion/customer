<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customerId = $_SESSION['customer_id'];
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

$fromDate = $_GET['from'] ?? '';
$toDate = $_GET['to'] ?? '';

$historyRows = [];

$sql = "
    SELECT 
        t.transaction_id,
        t.appt_id,
        t.total_amount,
        t.payment_method,
        t.created_at,
        GROUP_CONCAT(s.service_name SEPARATOR ', ') AS services
    FROM transaction_tbl t
    LEFT JOIN appointments_tbl a ON t.appt_id = a.appt_id
    LEFT JOIN appointment_services_tbl aps ON a.appt_id = aps.appt_id
    LEFT JOIN service_tbl s ON aps.service_id = s.service_id
    WHERE t.customer_id = ?
";

$params = [$customerId];
$types = "i";

if (!empty($fromDate)) {
    $sql .= " AND DATE(t.created_at) >= ?";
    $params[] = $fromDate;
    $types .= "s";
}

if (!empty($toDate)) {
    $sql .= " AND DATE(t.created_at) <= ?";
    $params[] = $toDate;
    $types .= "s";
}

$sql .= " GROUP BY t.transaction_id";
$sql .= " ORDER BY t.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $row['items_used'] = ['-'];
    $historyRows[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="../css/transaction_history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <div class="menu">
            <a href="homepage_customer.php" class="nav-item">
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

            <a href="transaction_history.php" class="nav-item active">
                <i class="fa-regular fa-clock"></i>
                <span>History</span>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <h2>Transaction History</h2>

            <div class="top-icons">
                <div class="notification-wrapper">
                    <button class="icon-btn" id="notificationBtn" type="button">
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

        <form method="GET" action="" class="filter-section">
            <button type="button" class="filter-btn" id="toggleFilterBtn">
                <i class="fa-solid fa-sliders"></i>
                <span>Filter by date</span>
            </button>

            <div class="date-filter-box hidden" id="dateFilterBox">
                <div class="date-group">
                    <label for="fromDate">From</label>
                    <input type="date" id="fromDate" name="from" value="<?php echo htmlspecialchars($fromDate); ?>">
                </div>

                <div class="date-group">
                    <label for="toDate">To</label>
                    <input type="date" id="toDate" name="to" value="<?php echo htmlspecialchars($toDate); ?>">
                </div>

                <button type="submit" class="apply-btn">Apply</button>
            </div>
        </form>

        <div class="history-card">
            <div class="history-header history-header-wide">
                <div>Date</div>
                <div>Price</div>
                <div>Receipt</div>
            </div>

            <?php if (empty($historyRows)): ?>
                <div class="empty-history">
                    <i class="fa-regular fa-folder-open"></i>
                    <h3>No transaction history yet</h3>
                    <p>No transaction records found for this customer.</p>
                </div>
            <?php else: ?>
                <?php foreach ($historyRows as $row): ?>
                   <div class="history-row history-row-wide">

                        <div>
                            <?php echo htmlspecialchars(date("M j, Y g:i A", strtotime($row['created_at']))); ?>
                        </div>

                        <div>
                            PHP <?php echo htmlspecialchars(number_format((float)$row['total_amount'], 2)); ?>
                        </div>

                        <div>
                            <button type="button"
                                class="receipt-btn openReceiptBtn"
                                data-transaction-id="<?php echo $row['transaction_id']; ?>"
                                data-date="<?php echo date('F j, Y g:i A', strtotime($row['created_at'])); ?>"
                                data-price="<?php echo number_format((float)$row['total_amount'],2); ?>"
                                data-payment="<?php echo $row['payment_method']; ?>"
                                data-services="<?php echo htmlspecialchars($row['services'] ?? '-'); ?>"
                                data-items="<?php echo implode(' | ', $row['items_used']); ?>"
                            >
                                View
                            </button>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="receipt-modal-overlay hidden" id="receiptModal">
    <div class="receipt-modal">
        <div class="receipt-modal-header">
            <h3>Transaction Receipt</h3>
            <button type="button" class="close-receipt-btn" id="closeReceiptBtn">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="receipt-body">
            <div class="receipt-line"><strong>Transaction ID:</strong> <span id="receiptTransactionId">-</span></div>
            <div class="receipt-line"><strong>Date:</strong> <span id="receiptDate">-</span></div>
            <div class="receipt-line"><strong>Payment Method:</strong> <span id="receiptPayment">-</span></div>
            <div class="receipt-line"><strong>Services Used:</strong> <span id="receiptServices">-</span></div>
            <div class="receipt-line"><strong>Items Used:</strong> <span id="receiptItems">-</span></div>
            <div class="receipt-line receipt-total"><strong>Total Amount:</strong> <span id="receiptPrice">PHP 0.00</span></div>
        </div>
    </div>
</div>
    </main>
</div>

<script src="../js/transaction_history.js"></script>
</body>
</html>