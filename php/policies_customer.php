<?php
session_start();
include 'db_connect.php';
include 'appointment_guard.php';
include 'customer_ui.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$topProfileImage = dh_get_customer_profile_image($conn, $_SESSION['customer_id'] ?? null);
$customerNotifications = dh_get_customer_notifications($conn, $_SESSION['customer_id'] ?? null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policies</title>
    <link rel="stylesheet" href="../css/policies_customer.css">
    <link rel="stylesheet" href="../css/customer_ui_shared.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
    <?php dh_render_customer_sidebar('policies', $hasExistingAppointment, 'menu', $topProfileImage, $customerNotifications); ?>

    <main class="main-content">
        <div class="topbar">
            <h2>Policies</h2>
        </div>

        <hr>

        <div class="policy-layout">
            <section class="policy-card">
                <h1>Terms and Conditions</h1>
                <h3>Account Terms and Conditions</h3>
                <ol>
                    <li>You must provide true, complete, and accurate personal and contact information.</li>
                    <li>You are responsible for keeping your account credentials and password secure.</li>
                    <li>The company may suspend or remove accounts that contain false information or are used for abusive, fraudulent, or unauthorized activity.</li>
                    <li>All appointment and transaction notifications will be sent through the Customer Portal and email.</li>
                    <li>Your personal information is collected and used only for payment, appointment, and related business processing.</li>
                    <li>You may update and correct your account details directly in your account settings.</li>
                    <li>The company may update these Terms and Conditions from time to time. Continued use of the platform means you accept the updated terms.</li>
                </ol>

                <h3>Appointment, Reservation Fee, and Refund Terms</h3>
                <ol>
                    <li>An appointment is considered confirmed only after reservation payment proof is submitted and approved.</li>
                    <li>Reservation payments are non-transferable to another person or account.</li>
                    <li>The reservation fee is deductible from the total service cost.</li>
                    <li>No-show appointments will be handled through reschedule policy.</li>
                    <li>Late arrival beyond 15 minutes from the scheduled time may result in rescheduling.</li>
                    <li>Rescheduling is allowed only if requested at least 4 hours before the appointment time.</li>
                    <li>Each appointment is allowed a maximum of one (1) reschedule.</li>
                    <li>Uploaded payment proof must match the declared reference number, amount, and payment details. Invalid or fraudulent proof may result in rejection or cancellation.</li>
                    <li>Refund Policy:
                        <ul>
                            <li>Reservation fee is generally non-refundable once payment is approved.</li>
                            <li>If cancellation is requested at least 4 hours before the appointment and no service has started, the company may approve either reschedule or refund, subject to verification.</li>
                            <li>If the company cancels the appointment and cannot provide a replacement schedule, the customer may request a full refund of the reservation fee.</li>
                            <li>Approved refunds (if any) are processed within 7 business days using the available payment channel.</li>
                        </ul>
                    </li>
                    <li>Any concerns or disputes must be reported within seven (7) days from the transaction or appointment date, with the receipt or reference number as proof.</li>
                    <li>The company is not responsible for indirect or consequential losses, including loss of income, business interruption, or personal inconvenience, unless required by law.</li>
                </ol>
            </section>

            <section class="policy-card">
                <h1>Privacy Policy</h1>
                <p>By creating an account and using the Customer Portal, you agree to this Privacy Policy.</p>
                <ol>
                    <li>Your personal information is collected and used only for payment, appointment, and related business processing.</li>
                    <li>Appointment and transaction notifications are sent through the Customer Portal and email.</li>
                    <li>You may update and correct your account details directly in your account settings.</li>
                    <li>Payment references and proof uploads are stored for verification and dispute handling.</li>
                    <li>Any concerns or disputes must be reported within seven (7) days from the transaction or appointment date, with the receipt or reference number as proof.</li>
                    <li>Your data is processed in accordance with applicable privacy and data protection laws.</li>
                </ol>
            </section>
        </div>
    </main>
</div>

<script src="../js/customer_ui_shared.js"></script>
<script src="../js/policies_customer.js"></script>
<script src="../js/appointment_guard.js"></script>
</body>
</html>
