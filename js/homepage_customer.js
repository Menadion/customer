document.addEventListener("DOMContentLoaded", function () {
    const bookAppointmentBtn = document.getElementById("bookAppointmentBtn");
    const appointmentCard = document.getElementById("upcomingAppointmentCard");
    const sidebarAppointmentLink = document.getElementById("sidebarAppointmentLink");

    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    let currentSlide = 0;
    let slideInterval;

    function showExistingAppointmentMessage() {
        alert("You can't create more appointments because you already have an existing appointment.");
    }

    function hasExistingAppointment(element) {
        return element && element.dataset.hasExistingAppointment === "1";
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
            if (hasExistingAppointment(bookAppointmentBtn)) {
                showExistingAppointmentMessage();
                return;
            }

            window.location.href = "appointment_customer.php";
        });
    }

    if (sidebarAppointmentLink) {
        sidebarAppointmentLink.addEventListener("click", function (e) {
            if (hasExistingAppointment(sidebarAppointmentLink)) {
                e.preventDefault();
                showExistingAppointmentMessage();
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
