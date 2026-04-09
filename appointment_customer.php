document.addEventListener("DOMContentLoaded", function () {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");

    if (notificationBtn && notificationBox) {
        notificationBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            notificationBox.classList.toggle("hidden");
        });

        document.addEventListener("click", function (e) {
            if (!notificationBtn.contains(e.target) && !notificationBox.contains(e.target)) {
                notificationBox.classList.add("hidden");
            }
        });
    }
});

const profileToggle = document.getElementById("profileToggle");
const profileMenu = document.getElementById("profileMenu");

if (profileToggle) {
    profileToggle.addEventListener("click", function () {
        profileMenu.classList.toggle("hidden");
    });
}

document.addEventListener("click", function (e) {
    if (!profileToggle.contains(e.target)) {
        profileMenu.classList.add("hidden");
    }
});