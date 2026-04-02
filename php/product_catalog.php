<?php
?>
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

            <a href="#" class="nav-item">
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

                <button class="profile-btn" type="button" id="profileBtn">
                    <i class="fa-solid fa-user"></i>
                </button>
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