document.addEventListener("DOMContentLoaded", function () {
    const toggleFilterBtn = document.getElementById("toggleFilterBtn");
    const dateFilterBox = document.getElementById("dateFilterBox");
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");
    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    const receiptModal = document.getElementById("receiptModal");
    const closeReceiptBtn = document.getElementById("closeReceiptBtn");
    const openReceiptBtns = document.querySelectorAll(".openReceiptBtn");

    const receiptTransactionId = document.getElementById("receiptTransactionId");
    const receiptDate = document.getElementById("receiptDate");
    const receiptPayment = document.getElementById("receiptPayment");
    const receiptServices = document.getElementById("receiptServices");
    const receiptItems = document.getElementById("receiptItems");
    const receiptPrice = document.getElementById("receiptPrice");

    if (notificationBtn && notificationBox) {
        notificationBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            notificationBox.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!notificationBtn.contains(event.target) && !notificationBox.contains(event.target)) {
                notificationBox.classList.add("hidden");
            }
        });
    }

    if (toggleFilterBtn && dateFilterBox) {
        toggleFilterBtn.addEventListener("click", function () {
            dateFilterBox.classList.toggle("hidden");
        });
    }

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            profileMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (e) {
            if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.add("hidden");
            }
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