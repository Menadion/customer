document.addEventListener("DOMContentLoaded", function () {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");
    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    if (notificationBtn && notificationBox) {
        notificationBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            notificationBox.classList.toggle("hidden");
        });
    }

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener("click", function (event) {
            event.stopPropagation();
            profileMenu.classList.toggle("hidden");
        });
    }

    document.addEventListener("click", function (event) {
        if (notificationBtn && notificationBox && !notificationBtn.contains(event.target) && !notificationBox.contains(event.target)) {
            notificationBox.classList.add("hidden");
        }

        if (profileToggle && profileMenu && !profileToggle.contains(event.target) && !profileMenu.contains(event.target)) {
            profileMenu.classList.add("hidden");
        }
    });
});
