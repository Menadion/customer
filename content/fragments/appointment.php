<div class="container-fluid px-4 py-3 flex-grow-1">
    <div class="mx-auto" style="max-width: 1200px;">
        <div class="bg-white border rounded-4 p-4 mb-4">
            <div id="step1">
                <h6 class="fw-bold mb-3">DETAILS</h6>

                <div class="mx-auto" style="max-width: 1100px;">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="mb-3 fw-semibold text-teal">Choose Date</div>
                            <div class="card shadow-sm rounded-4 p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <button class="btn btn-sm btn-light" id="prevMonth">‹</button>
                                    <div class="fw-semibold" id="calendarLabel"></div>
                                    <button class="btn btn-sm btn-light" id="nextMonth">›</button>
                                </div>

                                <div class="d-grid text-center small mb-1"
                                    style="grid-template-columns: repeat(7, 1fr); gap: .25rem;">
                                    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div>
                                    <div>Thu</div><div>Fri</div><div>Sat</div>
                                </div>

                                <div class="d-grid text-center small"
                                    id="calendarGrid"
                                    style="grid-template-columns: repeat(7, 1fr); gap: .25rem;">
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary w-100 rounded-pill">
                                Choose Time
                            </button>
                        </div>

                        <div class="col-md-8">
                            <div class="card shadow-sm rounded-4 p-4">
                                <h6 class="fw-semibold mb-3">Personal Information</h6>

                                <div class="row g-3 mb-2">
                                    <div class="col">
                                        <input class="form-control" placeholder="First Name">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" placeholder="Middle Name">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <input class="form-control" placeholder="Surname">
                                </div>

                                <div class="mb-3">
                                    <input class="form-control" placeholder="Mobile Number">
                                </div>

                                <div class="mb-3">
                                    <input class="form-control" placeholder="Email Address">
                                </div>

                                <div>
                                    <input class="form-control" placeholder="Vehicle Name/Model">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="step2" class="d-none">
                <h6 class="fw-bold mb-3">PURPOSE OF APPOINTMENT</h6>
                
                <div class="step-body">
                    <div class="row g-4">

                        <div class="col-md-5">
                            <div class="fw-semibold mb-2">SERVICES</div>

                        <div class="list-group service-group mb-4">
                            <button type="button" class="list-group-item service-item">
                                TIRE AND WHEEL CHANGE
                            </button>
                            <button type="button" class="list-group-item service-item">
                                UNDERCHASSIS
                            </button>
                            <button type="button" class="list-group-item service-item">
                                VULCANIZE
                            </button>
                            <button type="button" class="list-group-item service-item">
                                BATTERY CHANGE
                            </button>
                        </div>

                            <textarea class="form-control notes-textarea" placeholder="Notes..."></textarea>
                        </div>

                        <div class="col-md-7">
                            <div class="fw-semibold mb-2">PRODUCTS</div>
                                <div class="accordion" id="productsAccordion">

                                    <!-- TIRES -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-semibold"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#tiresPanel">
                                                TIRES
                                            </button>
                                        </h2>

                                        <div id="tiresPanel"
                                            class="accordion-collapse collapse"
                                            data-bs-parent="#productsAccordion">
                                            <div class="accordion-body">

                                                <select class="form-select mb-2">
                                                    <option selected disabled>Wheel Size</option>
                                                    <option>185-65-14</option>
                                                    <option>195-55-15</option>
                                                </select>

                                                <select class="form-select mb-3">
                                                    <option selected disabled>Brand</option>
                                                    <option>Westlake</option>
                                                    <option>Bridgestone</option>
                                                </select>

                                            <div class="d-flex gap-2 justify-content-start qty-group">
                                                <button class="btn btn-outline-secondary btn-sm qty-btn">1</button>
                                                <button class="btn btn-outline-secondary btn-sm qty-btn">2</button>
                                                <button class="btn btn-outline-secondary btn-sm qty-btn">3</button>
                                                <button class="btn btn-outline-secondary btn-sm qty-btn">4</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BATTERIES -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-semibold"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#batteriesPanel">
                                                BATTERIES
                                            </button>
                                        </h2>

                                        <div id="batteriesPanel"
                                            class="accordion-collapse collapse"
                                            data-bs-parent="#productsAccordion">
                                            <div class="accordion-body">

                                                <select class="form-select mb-2">
                                                    <option selected disabled>Size</option>
                                                </select>

                                                <select class="form-select">
                                                    <option selected disabled>Brand</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- MAGWHEELS -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-semibold"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#magwheelsPanel">
                                                MAGWHEELS
                                            </button>
                                        </h2>

                                        <div id="magwheelsPanel"
                                            class="accordion-collapse collapse"
                                            data-bs-parent="#productsAccordion">
                                            <div class="accordion-body">

                                                <select class="form-select mb-2">
                                                    <option selected disabled>Size</option>
                                                </select>

                                                <select class="form-select">
                                                    <option selected disabled>Brand</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="step3" class="d-none">
                <h6 class="fw-bold mb-3">CONFIRMATION</h6>
                <div class="mx-auto" style="max-width: 900px;">
                    <div class="card shadow-sm rounded-4 p-3 mb-4">
                        <h6 class="fw-semibold mb-3">Personal Info</h6>

                        <div class="edit-row">
                            <small class="text-muted">Name</small>
                            <div class="edit-grid">
                                <div>
                                    <div class="edit-display fw-semibold">Petra B. Parker</div>
                                    <input class="form-control edit-input d-none" value="Petra B. Parker">
                                </div>
                                <button class="btn btn-outline-secondary btn-sm edit-toggle">Edit</button>
                            </div>
                        </div>

                        <div class="edit-row">
                            <small class="text-muted">Mobile Number</small>
                            <div class="edit-grid">
                                <div>
                                    <div class="edit-display fw-semibold">0966942069</div>
                                    <input class="form-control edit-input d-none" value="0966942069">
                                </div>
                                <button class="btn btn-outline-secondary btn-sm edit-toggle">Edit</button>
                            </div>
                        </div>

                        <div class="edit-row">
                            <small class="text-muted">Email</small>
                            <div class="edit-grid">
                                <div>
                                    <div class="edit-display fw-semibold">petrabparker@gmail.com</div>
                                    <input class="form-control edit-input d-none" value="petrabparker@gmail.com">
                                </div>
                                <button class="btn btn-outline-secondary btn-sm edit-toggle">Edit</button>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded-4 p-3">
                        <h6 class="fw-semibold mb-3">Appointment Details</h6>

                        <div class="edit-row">
                            <small class="text-muted">Date</small>
                            <div class="edit-grid">
                                <div>
                                    <div class="edit-display fw-semibold">May 18, 2025</div>
                                    <input type="date" class="form-control edit-input d-none" value="2025-05-18">
                                </div>
                                <button class="btn btn-outline-secondary btn-sm edit-toggle">Edit</button>
                            </div>
                        </div>

                        <div class="edit-row">
                            <small class="text-muted">Time</small>
                            <div class="edit-grid">
                                <div>
                                    <div class="edit-display fw-semibold">12:00 Noon</div>
                                    <input type="time" class="form-control edit-input d-none" value="12:00">
                                </div>
                                <button class="btn btn-outline-secondary btn-sm edit-toggle">Edit</button>
                            </div>
                        </div>

                        <div class="edit-row">
                            <small class="text-muted">Purpose of Visit</small>
                            <div class="edit-grid">
                                <div>
                                    <div class="edit-display fw-semibold">
                                        Tire Change<br>
                                        <small class="text-muted">4x 185-65-14 Westlake</small>
                                    </div>
                                    <textarea class="form-control edit-input d-none" rows="2">
                                        Tire Change – 4x 185-65-14 Westlake
                                    </textarea>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm edit-toggle">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center px-1">
            <button id="backBtn" class="btn btn-secondary rounded-pill px-4">
                Back
            </button>

            <button id="nextBtn" class="btn btn-success rounded-pill px-4">
                Next
            </button>
        </div>
    </div>
</div>

<?php include 'appointmentModal.php' ?>