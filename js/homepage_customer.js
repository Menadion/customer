document.addEventListener("DOMContentLoaded", function () {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationPopup = document.getElementById("notificationPopup");
    const profileBtn = document.getElementById("profileBtn");
    const bookAppointmentBtn = document.getElementById("bookAppointmentBtn");

    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    let currentSlide = 0;
    let slideInterval;

    // Notification popup
    notificationBtn.addEventListener("click", function (e) {
        e.stopPropagation();

        if (notificationPopup.style.display === "block") {
            notificationPopup.style.display = "none";
        } else {
            notificationPopup.style.display = "block";
        }
    });

    // Close popup when clicking outside
    document.addEventListener("click", function (e) {
        if (!notificationBtn.contains(e.target) && !notificationPopup.contains(e.target)) {
            notificationPopup.style.display = "none";
        }
    });

    // Upcomming Appoinment

    document.querySelector(".appointment-card").onclick = function(){

        window.location.href = "appointment_customer.php";

        };


    // Book appointment button
    bookAppointmentBtn.addEventListener("click", function () {
        window.location.href = "appointment_customer.php";
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

    function showSlide(index) {
        slides.forEach((slide) => slide.classList.remove("active"));
        dots.forEach((dot) => dot.classList.remove("active"));

        slides[index].classList.add("active");
        dots[index].classList.add("active");

        currentSlide = index;
    }

    function nextSlide() {
        let nextIndex = currentSlide + 1;
        if (nextIndex >= slides.length) {
            nextIndex = 0;
        }
        showSlide(nextIndex);
    }

    function startSlider() {
        slideInterval = setInterval(nextSlide, 10000);
    }

    function resetSlider() {
        clearInterval(slideInterval);
        startSlider();
    }

    dots.forEach((dot) => {
        dot.addEventListener("click", function () {
            const slideIndex = parseInt(this.getAttribute("data-slide"));
            showSlide(slideIndex);
            resetSlider();
        });
    });

    showSlide(0);
    startSlider();
});