document.addEventListener("DOMContentLoaded", function () {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationPopup = document.getElementById("notificationPopup");
    const bookAppointmentBtn = document.getElementById("bookAppointmentBtn");
    const appointmentCard = document.getElementById("upcomingAppointmentCard");
    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    let currentSlide = 0;
    let slideInterval;

    if (notificationBtn && notificationPopup) {
        notificationBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            notificationPopup.style.display =
                notificationPopup.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function (e) {
            if (!notificationBtn.contains(e.target) && !notificationPopup.contains(e.target)) {
                notificationPopup.style.display = "none";
            }
        });
    }

    if (appointmentCard) {
        appointmentCard.addEventListener("click", function () {
            const link = this.getAttribute("data-link");
            if (link) {
                window.location.href = link;
            }
        });
    }

    if (bookAppointmentBtn) {
        bookAppointmentBtn.addEventListener("click", function () {
            window.location.href = "appointment_customer.php";
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

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove("active"));
        dots.forEach(dot => dot.classList.remove("active"));

        if (slides[index]) slides[index].classList.add("active");
        if (dots[index]) dots[index].classList.add("active");

        currentSlide = index;
    }

    function nextSlide() {
        if (slides.length === 0) return;
        let nextIndex = currentSlide + 1;
        if (nextIndex >= slides.length) nextIndex = 0;
        showSlide(nextIndex);
    }

    function startSlider() {
        if (slides.length > 0) {
            slideInterval = setInterval(nextSlide, 10000);
        }
    }

    function resetSlider() {
        clearInterval(slideInterval);
        startSlider();
    }

    dots.forEach(dot => {
        dot.addEventListener("click", function () {
            const slideIndex = parseInt(this.getAttribute("data-slide"), 10);
            showSlide(slideIndex);
            resetSlider();
        });
    });

    if (slides.length > 0) {
        showSlide(0);
        startSlider();
    }
});