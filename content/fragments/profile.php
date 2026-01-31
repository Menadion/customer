<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div class="d-flex gap-3 align-items-center">
            <div class="card shadow-sm p-3 rounded-4">
                <div class="rounded-circle overflow-hidden"
                    style="width:120px; height:120px;">
                    <img
                        src="<?= ROOT_URL ?>assets/profPic.svg"
                        alt="Profile Picture"
                        class="w-100 h-100"
                        style="object-fit: cover;">
                </div>
            </div>

            <div>
                <input id="profileName" type="text" class="form-control profile-input fw-semibold mb-2" value="Petra B. Parker" readonly>
                <input id="profileEmail"type="email" class="form-control profile-input fw-semibold mb-2" value="petrabparker@gmail.com" readonly>

                <div class="text-muted small">
                    Account created since: September 26, 2025
                </div>
            </div>

        </div>
        <button id="editBtn" class="btn btn-dark btn-sm px-4">
            Edit
        </button>
    </div>

    <hr>

    <h6 class="fw-semibold mb-3">History</h6>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>05, May 2025 11:18 AM</td>
                    <td>PHP 5,900</td>
                    <td>
                        <a href="#" class="text-primary text-decoration-none">
                            View Receipt
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
