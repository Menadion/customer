document.addEventListener("DOMContentLoaded", function () {
    const bookAppointmentBtn = document.getElementById("bookAppointmentBtn");
    const bookAppointmentBtnSecondary = document.getElementById("bookAppointmentBtnSecondary");
    const appointmentCard = document.getElementById("upcomingAppointmentCard");
    const sidebarAppointmentLink = document.getElementById("sidebarAppointmentLink");

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

    if (bookAppointmentBtnSecondary) {
        bookAppointmentBtnSecondary.addEventListener("click", function () {
            if (hasExistingAppointment(bookAppointmentBtnSecondary)) {
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
});
