document.addEventListener("DOMContentLoaded", function () {
    const guardedAppointmentLinks = document.querySelectorAll(".guard-appointment-link");

    function showExistingAppointmentMessage() {
        alert("You can't create more appointments because you already have an existing appointment.");
    }

    guardedAppointmentLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            const hasExistingAppointment = this.dataset.hasExistingAppointment === "1";
            const allowUpcomingView = this.dataset.allowUpcomingView === "1";

            if (hasExistingAppointment && !allowUpcomingView) {
                e.preventDefault();
                showExistingAppointmentMessage();
            }
        });
    });
});