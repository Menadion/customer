<?php
session_start();
include 'db_connect.php';
include 'appointment_guard.php';
include 'customer_ui.php';

$topProfileImage = dh_get_customer_profile_image($conn, $_SESSION['customer_id'] ?? null);
?>
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
    <?php dh_render_customer_sidebar('services', $hasExistingAppointment); ?>

    <main class="main-content">
        <div class="topbar">
            <h2>Services</h2>

            <?php dh_render_top_actions($topProfileImage); ?>
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

<script src="../js/customer_ui_shared.js"></script>
<script src="../js/services_customer.js"></script>
<script src="../js/appointment_guard.js"></script>
</body>
</html>
