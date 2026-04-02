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
    <title>Product Catalog</title>
    <link rel="stylesheet" href="../css/product_catalog.css">
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

            <a href="product_catalog.php" class="nav-item active">
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
            <h2 id="pageTitle">Tires</h2>

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

        <div class="products-card">
            <div class="products-header">
                <div class="tabs">
                    <button class="tab-btn active" data-tab="tires">Tires</button>
                    <button class="tab-btn" data-tab="battery">Battery</button>
                    <button class="tab-btn" data-tab="rims">Rims</button>
                </div>

                <div class="search-box">
                    <input type="text" placeholder="Search" id="searchInput">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <div class="table-header">
                <div>BRAND</div>
                <div>SIZE</div>
                <div>PRICE</div>
                <div>STOCK</div>
                <div>STATUS</div>
            </div>

            <div class="tab-content active" id="tab-tires">
                <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <h3>No tires available</h3>
                </div>
            </div>

            <div class="tab-content" id="tab-battery">
                <div class="empty-state">
                    <i class="fa-solid fa-car-battery"></i>
                    <h3>No battery available</h3>
                </div>
            </div>

            <div class="tab-content" id="tab-rims">
                <div class="empty-state">
                    <i class="fa-solid fa-circle-notch"></i>
                    <h3>No rims available</h3>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="../js/product_catalog.js"></script>
</body>
</html>