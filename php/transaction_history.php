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
?>
<!DOCTYPE html>
<html lang="en">
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

    <main class="content-area">
            <div class="top-bar">
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
                            <img src="<?php echo htmlspecialchars($topProfileImage); ?>" class="top-profile-img" id="profileToggle" alt="Profile">
                        </button>

                        <div class="profile-menu hidden" id="profileMenu">
                            <a href="profile_customer.php">Profile</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
        </div>
    </div>
        <hr>

        <div class="filter-section">
            <button type="button" class="filter-btn" id="toggleFilterBtn">
                <i class="fa-solid fa-sliders"></i>
                <span>Filter by date</span>
            </button>

            <div class="date-filter-box hidden" id="dateFilterBox">
                <div class="date-group">
                    <label for="fromDate">From</label>
                    <input type="date" id="fromDate">
                </div>

                <div class="date-group">
                    <label for="toDate">To</label>
                    <input type="date" id="toDate">
                </div>

                <button type="button" class="apply-btn" id="applyDateBtn">Apply</button>
            </div>
        </div>

        <div class="history-card">
            <div class="history-header">
                <div>Date</div>
                <div>Price</div>
                <div>Receipt</div>
            </div>

            <div class="empty-history">
                <i class="fa-regular fa-folder-open"></i>
                <h3>No transaction history yet</h3>
                <p>No records available because the database is not connected yet.</p>
            </div>
        </div>
    </main>
</div>

<script src="../js/transaction_history.js"></script>
</body>
</html>