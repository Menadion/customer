<div class="container-fluid px-4 mt-3">
    <div class="notif-list">
        <div class="notif-item notif-clickable"
            data-bs-toggle="modal"
            data-bs-target="#notifModal">

            <div class="notif-top">
                <span class="notif-pill approved">Appointment</span>
                <span class="notif-time">May 16, 2025 at 11:30 AM</span>
            </div>

            <div class="notif-title approved-text">
                Approved
            </div>

            <div class="notif-desc">
                Your appointment on May 18, 2025 at 12:00 noon has been approved.
                Please proceed.
            </div>
        </div>

        <hr>

        <div class="notif-item">
            <div class="d-flex justify-content-between align-items-start">
                <span class="notif-pill pending">Appointment</span>
                <span class="notif-time">May 16, 2025 at 9:30 AM</span>
            </div>

            <div class="notif-title pending-text">
                Pending Status
            </div>

            <div class="notif-desc">
                Your appointment has been sent and is being reviewed by our personnel.
            </div>
        </div>
    </div>
</div>

<?php include 'notificationModal.php' ?>