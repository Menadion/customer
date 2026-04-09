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
    <title>Services</title>
    <link rel="stylesheet" href="../css/services_customer.css">
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

            <a href="services_customer.php" class="nav-item active">
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
            <h2>Services</h2>

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

        <div class="services-header">
            <h1>Our Services</h1>
            <p>
                We provide vehicle support services focused on safety, performance,
                and dependable maintenance for everyday and heavy-duty vehicle needs.
            </p>
        </div>

        <div class="services-grid">

            <div class="service-card">
                <div class="service-image wheel-bg"></div>
                <div class="service-body">
                    <h2>Wheel Change</h2>
                    <p class="service-summary">
                        Wheel change service for worn-out, damaged, or replacement tire and wheel requirements.
                    </p>

                    <div class="service-section">
                        <h3>What we do</h3>
                        <ul>
                            <li>Remove and replace damaged or worn wheels/tires</li>
                            <li>Assist with proper fitting for sedan to truck-type vehicles</li>
                            <li>Check visible tire condition before installation</li>
                            <li>Help ensure safer and more stable vehicle operation</li>
                        </ul>
                    </div>

                    <div class="service-section">
                        <h3>Best for</h3>
                        <p>Vehicles with worn tires, damaged wheels, puncture replacement needs, or upgrade requests.</p>
                    </div>

                    <div class="service-section">
                        <h3>Important notes</h3>
                        <p>Customers are advised to ensure compatibility of tire size and wheel type with the vehicle.</p>
                    </div>
                </div>
            </div>

            <div class="service-card">
                <div class="service-image battery-bg"></div>
                <div class="service-body">
                    <h2>Battery Change</h2>
                    <p class="service-summary">
                        Battery replacement service for vehicles with weak, old, or non-functioning batteries.
                    </p>

                    <div class="service-section">
                        <h3>What we do</h3>
                        <ul>
                            <li>Remove old or defective battery</li>
                            <li>Install the replacement battery properly</li>
                            <li>Check terminals and visible connections</li>
                            <li>Help support reliable starting power for the vehicle</li>
                        </ul>
                    </div>

                    <div class="service-section">
                        <h3>Best for</h3>
                        <p>Vehicles with weak battery performance, difficulty starting, or battery replacement needs.</p>
                    </div>

                    <div class="service-section">
                        <h3>Important notes</h3>
                        <p>Battery type and specifications should match the vehicle’s required capacity and size.</p>
                    </div>
                </div>
            </div>

            <div class="service-card">
                <div class="service-image chassis-bg"></div>
                <div class="service-body">
                    <h2>Under Chassis</h2>
                    <p class="service-summary">
                        Under chassis inspection and support service for steering, suspension, and ride stability concerns.
                    </p>

                    <div class="service-section">
                        <h3>What we do</h3>
                        <ul>
                            <li>Inspect visible under chassis components</li>
                            <li>Check suspension and steering-related concerns</li>
                            <li>Help identify worn or problematic parts</li>
                            <li>Support smoother and more stable vehicle performance</li>
                        </ul>
                    </div>

                    <div class="service-section">
                        <h3>Best for</h3>
                        <p>Vehicles with unusual sounds, unstable ride feel, pulling, vibration, or suspension concerns.</p>
                    </div>

                    <div class="service-section">
                        <h3>Important notes</h3>
                        <p>Further repair recommendations may depend on the actual condition of the under chassis parts.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<script src="../js/services_customer.js"></script>
</body>
</html>