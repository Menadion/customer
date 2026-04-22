<?php
session_start();
include 'db_connect.php';
include 'appointment_guard.php';
include 'customer_ui.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customerId = $_SESSION['customer_id'];
$topProfileImage = dh_get_customer_profile_image($conn, $_SESSION['customer_id'] ?? null);

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
        a.purpose,
        a.tires_product_id,
        a.tires_qty,
        a.batteries_product_id,
        a.magwheels_product_id,
        a.magwheels_qty
    FROM transaction_tbl t
    LEFT JOIN appointments_tbl a ON t.appt_id = a.appt_id
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

$sql .= " ORDER BY t.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $row['items_used'] = [];

    if (!empty($row['tires_product_id'])) {
        $productStmt = $conn->prepare("SELECT brand, size FROM product_tbl WHERE product_id = ?");
        $productStmt->bind_param("i", $row['tires_product_id']);
        $productStmt->execute();
        $productResult = $productStmt->get_result();
        if ($product = $productResult->fetch_assoc()) {
            $qty = (int)($row['tires_qty'] ?? 1);
            $row['items_used'][] = $qty . "x Tire - " . $product['brand'] . " " . $product['size'];
        }
        $productStmt->close();
    }

    if (!empty($row['batteries_product_id'])) {
        $productStmt = $conn->prepare("SELECT brand, size FROM product_tbl WHERE product_id = ?");
        $productStmt->bind_param("i", $row['batteries_product_id']);
        $productStmt->execute();
        $productResult = $productStmt->get_result();
        if ($product = $productResult->fetch_assoc()) {
            $row['items_used'][] = "Battery - " . $product['brand'] . " " . $product['size'];
        }
        $productStmt->close();
    }

    if (!empty($row['magwheels_product_id'])) {
        $productStmt = $conn->prepare("SELECT brand, size FROM product_tbl WHERE product_id = ?");
        $productStmt->bind_param("i", $row['magwheels_product_id']);
        $productStmt->execute();
        $productResult = $productStmt->get_result();
        if ($product = $productResult->fetch_assoc()) {
            $qty = (int)($row['magwheels_qty'] ?? 1);
            $row['items_used'][] = $qty . "x Magwheel - " . $product['brand'] . " " . $product['size'];
        }
        $productStmt->close();
    }

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
    <?php dh_render_customer_sidebar('history', $hasExistingAppointment); ?>

    <main class="main-content">
        <div class="topbar">
            <h2>Transaction History</h2>

            <?php dh_render_top_actions($topProfileImage); ?>
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
                                data-services="<?php echo $row['purpose']; ?>"
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

<script src="../js/customer_ui_shared.js"></script>
<script src="../js/transaction_history.js"></script>
<script src="../js/appointment_guard.js"></script>
</body>
</html>
