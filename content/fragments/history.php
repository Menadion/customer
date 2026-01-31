<div class="container-fluid px-4 mt-3">
    <div class="history-card">
        <div class="history-header">
            <div>Date</div>
            <div>Price</div>
            <div>Receipt</div>
        </div>

        <div class="history-row">
            <div>21, May 2025 1:18 PM</div>
            <div>PHP 5,900</div>
            <div>
                <a href="historyModal.php"  class="receipt-link" data-bs-toggle="modal" data-bs-target="#receiptModal">
                    View Receipt
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'historyModal.php' ?>