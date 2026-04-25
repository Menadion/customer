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

    function openReceipt(button) {
        if (!button) return;

        if (receiptTransactionId) receiptTransactionId.textContent = button.dataset.transactionId || "-";
        if (receiptDate) receiptDate.textContent = button.dataset.date || "-";
        if (receiptPayment) receiptPayment.textContent = button.dataset.payment || "-";
        if (receiptServices) receiptServices.textContent = button.dataset.services || "-";
        if (receiptItems) receiptItems.textContent = button.dataset.items || "-";
        if (receiptPrice) receiptPrice.textContent = "PHP " + (button.dataset.price || "0.00");

        if (receiptModal) {
            receiptModal.classList.remove("hidden");
        }
    }

    if (toggleFilterBtn && dateFilterBox) {
        toggleFilterBtn.addEventListener("click", function () {
            dateFilterBox.classList.toggle("hidden");
        });
    }

    openReceiptBtns.forEach(button => {
        button.addEventListener("click", function () {
            openReceipt(this);
        });
    });

    const params = new URLSearchParams(window.location.search);
    const openTxnId = (params.get("open_txn") || "").trim();
    if (openTxnId !== "") {
        let targetButton = null;
        openReceiptBtns.forEach(button => {
            if (!targetButton && (button.dataset.transactionId || "") === openTxnId) {
                targetButton = button;
            }
        });
        if (targetButton) {
            openReceipt(targetButton);
            targetButton.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    }

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
