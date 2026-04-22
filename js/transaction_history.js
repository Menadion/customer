document.addEventListener("DOMContentLoaded", function () {
    const toggleFilterBtn = document.getElementById("toggleFilterBtn");
    const dateFilterBox = document.getElementById("dateFilterBox");

    const receiptModal = document.getElementById("receiptModal");
    const closeReceiptBtn = document.getElementById("closeReceiptBtn");
    const openReceiptBtns = document.querySelectorAll(".openReceiptBtn");

    const receiptTransactionId = document.getElementById("receiptTransactionId");
    const receiptDate = document.getElementById("receiptDate");
    const receiptPayment = document.getElementById("receiptPayment");
    const receiptServices = document.getElementById("receiptServices");
    const receiptItems = document.getElementById("receiptItems");
    const receiptPrice = document.getElementById("receiptPrice");

    if (toggleFilterBtn && dateFilterBox) {
        toggleFilterBtn.addEventListener("click", function () {
            dateFilterBox.classList.toggle("hidden");
        });
    }

    openReceiptBtns.forEach(button => {
        button.addEventListener("click", function () {
            if (receiptTransactionId) receiptTransactionId.textContent = this.dataset.transactionId || "-";
            if (receiptDate) receiptDate.textContent = this.dataset.date || "-";
            if (receiptPayment) receiptPayment.textContent = this.dataset.payment || "-";
            if (receiptServices) receiptServices.textContent = this.dataset.services || "-";
            if (receiptItems) receiptItems.textContent = this.dataset.items || "-";
            if (receiptPrice) receiptPrice.textContent = "PHP " + (this.dataset.price || "0.00");

            if (receiptModal) {
                receiptModal.classList.remove("hidden");
            }
        });
    });

    if (closeReceiptBtn && receiptModal) {
        closeReceiptBtn.addEventListener("click", function () {
            receiptModal.classList.add("hidden");
        });
    }

    if (receiptModal) {
        receiptModal.addEventListener("click", function (e) {
            if (e.target === receiptModal) {
                receiptModal.classList.add("hidden");
            }
        });
    }
});
