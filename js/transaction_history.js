document.addEventListener("DOMContentLoaded", function () {
    const toggleFilterBtn = document.getElementById("toggleFilterBtn");
    const dateFilterBox = document.getElementById("dateFilterBox");
    const applyDateBtn = document.getElementById("applyDateBtn");
    const fromDate = document.getElementById("fromDate");
    const toDate = document.getElementById("toDate");
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");

    notificationBtn.addEventListener("click", function (event) {
        event.stopPropagation();
        notificationBox.classList.toggle("hidden");
    });

    document.addEventListener("click", function (event) {
        if (!notificationBtn.contains(event.target) && !notificationBox.contains(event.target)) {
            notificationBox.classList.add("hidden");
        }
    });

    toggleFilterBtn.addEventListener("click", function () {
        dateFilterBox.classList.toggle("hidden");
    });

    applyDateBtn.addEventListener("click", function () {
        const from = fromDate.value;
        const to = toDate.value;

        if (from && to && from > to) {
            alert("The From date cannot be later than the To date.");
            return;
        }

        alert("No transaction data yet.");
    });
});