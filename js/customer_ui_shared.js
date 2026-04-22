document.addEventListener("DOMContentLoaded", function () {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationPanel = document.getElementById("notificationBox") || document.getElementById("notificationPopup");

    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    if (notificationBtn && notificationPanel) {
        notificationBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            notificationPanel.classList.toggle("hidden");
            if (notificationPanel.id === "notificationPopup") {
                notificationPanel.style.display = notificationPanel.classList.contains("hidden") ? "none" : "block";
            }
        });

        if (notificationPanel.id === "notificationPopup" && !notificationPanel.classList.contains("hidden")) {
            notificationPanel.classList.add("hidden");
            notificationPanel.style.display = "none";
        }
    }

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener("click", function (event) {
            event.stopPropagation();
            profileMenu.classList.toggle("hidden");
        });
    }

    document.addEventListener("click", function (event) {
        if (notificationBtn && notificationPanel && !notificationBtn.contains(event.target) && !notificationPanel.contains(event.target)) {
            notificationPanel.classList.add("hidden");
            if (notificationPanel.id === "notificationPopup") {
                notificationPanel.style.display = "none";
            }
        }

        if (profileToggle && profileMenu && !profileToggle.contains(event.target) && !profileMenu.contains(event.target)) {
            profileMenu.classList.add("hidden");
        }
    });
});
