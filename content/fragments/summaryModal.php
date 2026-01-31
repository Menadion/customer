<div class="modal fade" id="upcomingAppointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold text-uppercase">
                    Upcoming Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="border rounded-4 p-3 h-100">
                            <h6 class="fw-semibold mb-3">Personal Info</h6>
                            <p class="mb-1"><strong>Name:</strong> Petra B. Parker</p>
                            <p class="mb-1"><strong>Mobile Number:</strong> 09696942069</p>
                            <p class="mb-0"><strong>Email:</strong> PetraBarker@gmail.com</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded-4 p-3 h-100">
                            <h6 class="fw-semibold mb-3">Appointment Details</h6>
                            <p class="mb-1"><strong>Date:</strong> May 18, 2025</p>
                            <p class="mb-1"><strong>Time:</strong> 12:00 Noon</p>
                            <p class="mb-0"><strong>Purpose of Visit:</strong> Tire Change</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 d-flex justify-content-between">
                <button class="btn btn-success rounded-pill px-4" data-bs-dismiss="modal">
                    Back
                </button>

                <button class="btn btn-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#cancelReasonModal" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelReasonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">
                    Reason for Cancellation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="border rounded-4 p-3 ps-3 mb-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancelReason" id="reason1">
                            <label class="form-check-label" for="reason1">
                                Book wrong date and time
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancelReason" id="reason2">
                            <label class="form-check-label" for="reason2">
                                Change service type
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancelReason" id="reason3">
                            <label class="form-check-label" for="reason3">
                                Wrong information
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cancelReason" id="reasonOther">
                            <label class="form-check-label" for="reasonOther">
                                Others
                            </label>
                        </div>

                    </div>

                    <textarea
                        class="form-control"
                        rows="4"
                        placeholder="Please specify your reason (optional)">
                    </textarea>

                </form>
            </div>

            <div class="modal-footer border-0 d-flex justify-content-between">
                <button
                    type="button"
                    class="btn btn-secondary rounded-pill px-4"
                    data-bs-dismiss="modal">
                    Close
                </button>

                <button
                    type="button"
                    class="btn btn-success rounded-pill px-4">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>