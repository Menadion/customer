document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");
    const pageTitle = document.getElementById("pageTitle");

    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");

    tabButtons.forEach(button => {
        button.addEventListener("click", function () {
            const tab = this.getAttribute("data-tab");

            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabContents.forEach(content => content.classList.remove("active"));

            this.classList.add("active");
            document.getElementById(`tab-${tab}`).classList.add("active");

            if (tab === "tires") {
                pageTitle.textContent = "Tires";
            } else if (tab === "battery") {
                pageTitle.textContent = "Battery";
            } else {
                pageTitle.textContent = "Rims";
            }
        });
    });

const profileToggle = document.getElementById("profileToggle");
const profileMenu = document.getElementById("profileMenu");

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
});