<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <h4 class="fw-semibold p-0 text-center">
                Welcome, <span class="fw-bold">Petra B. Parker</span>
            </h4>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 col-lg-3">
                    <a href="../pages/appointmentPage.php" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm rounded-4 book-card">
                            <div class="card-body d-flex align-items-center gap-3">
                                <span>📅</span>
                                <span class="fw-medium">Book Appointment</span>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="card h-100 shadow-sm rounded-4 upcoming-card text-white" role="button" data-bs-toggle="modal" data-bs-target="#upcomingAppointmentModal">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="icon-box d-flex align-items-center justify-content-center">
                                <i class="bi bi-info-circle fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-uppercase">
                                    Upcoming Appointment
                                </div>
                                <div class="small opacity-75">
                                    June 12, 2025 &nbsp; 10:00 AM
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'summaryModal.php' ?>