document.addEventListener("DOMContentLoaded", function () {

const isUpcomingView = window.location.search.includes("view=upcoming");
if (isUpcomingView) {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");
    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

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

    return;
}
    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const step3 = document.getElementById("step3");

    const step1NextBtn = document.getElementById("step1NextBtn");
    const step2BackBtn = document.getElementById("step2BackBtn");
    const step2NextBtn = document.getElementById("step2NextBtn");
    const step3BackBtn = document.getElementById("step3BackBtn");
    const appointmentDetailsEditBtn = document.getElementById("appointmentDetailsEditBtn");
    const finishBtn = document.getElementById("finishBtn");

    const firstName = document.getElementById("firstName");
    const middleName = document.getElementById("middleName");
    const lastName = document.getElementById("lastName");
    const mobileNumber = document.getElementById("mobileNumber");
    const emailAddress = document.getElementById("emailAddress");
    const vehicleModel = document.getElementById("vehicleModel");

    const selectedDateInput = document.getElementById("selectedDate");
    const selectedTimeInput = document.getElementById("selectedTime");

    const confirmNameText = document.getElementById("confirmNameText");
    const confirmMobileText = document.getElementById("confirmMobileText");
    const confirmEmailText = document.getElementById("confirmEmailText");
    const confirmDateText = document.getElementById("confirmDateText");
    const confirmTimeText = document.getElementById("confirmTimeText");
    const confirmPurposeText = document.getElementById("confirmPurposeText");
    const confirmProductText = document.getElementById("confirmProductText");
    const confirmNotesText = document.getElementById("confirmNotesText");

    const editButtons = document.querySelectorAll(".edit-btn[data-edit]");
    const nameEditGroup = document.getElementById("nameEditGroup");
    const mobileEditGroup = document.getElementById("mobileEditGroup");
    const emailEditGroup = document.getElementById("emailEditGroup");

    const editFirstName = document.getElementById("editFirstName");
    const editMiddleName = document.getElementById("editMiddleName");
    const editLastName = document.getElementById("editLastName");
    const editMobileNumber = document.getElementById("editMobileNumber");
    const editEmailAddress = document.getElementById("editEmailAddress");

    const calendarGrid = document.getElementById("calendarGrid");
    const monthYear = document.getElementById("monthYear");
    const prevMonth = document.getElementById("prevMonth");
    const nextMonth = document.getElementById("nextMonth");
    const openTimePopup = document.getElementById("openTimePopup");
    const timePopupOverlay = document.getElementById("timePopupOverlay");
    const closeTimePopup = document.getElementById("closeTimePopup");
    const timeOptions = document.getElementById("timeOptions");
    const selectedTimeText = document.getElementById("selectedTimeText");

    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");

    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    const serviceItems = document.querySelectorAll(".service-item");
    const productTitles = document.querySelectorAll(".selectable-product");
    const qtyButtons = document.querySelectorAll(".qty-btn");
    const fakeDropdowns = document.querySelectorAll(".fake-dropdown");
    const notes = document.getElementById("notes");

    const popupOverlay = document.getElementById("popupOverlay");
    const popupTitle = document.getElementById("popupTitle");
    const popupContent = document.getElementById("popupContent");
    const closePopup = document.getElementById("closePopup");

    const paymentPopupOverlay = document.getElementById("paymentPopupOverlay");
    const closePaymentPopup = document.getElementById("closePaymentPopup");
    const cancelPaymentBtn = document.getElementById("cancelPaymentBtn");
    const donePaymentBtn = document.getElementById("donePaymentBtn");

    const successPopupOverlay = document.getElementById("successPopupOverlay");
    const closeSuccessPopup = document.getElementById("closeSuccessPopup");
    const closeSuccessBtn = document.getElementById("closeSuccessBtn");

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

    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    function renderCalendar(month, year) {
        calendarGrid.innerHTML = "";

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        monthYear.textContent = `${monthNames[month]} ${year}`;

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement("button");
            emptyCell.className = "day-cell empty";
            calendarGrid.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayBtn = document.createElement("button");
            dayBtn.className = "day-cell";
            dayBtn.textContent = day;

            const thisDate = new Date(year, month, day);
            const todayOnly = new Date(today.getFullYear(), today.getMonth(), today.getDate());

            if (thisDate < todayOnly) {
                dayBtn.classList.add("past-day");
                dayBtn.disabled = true;
            } else if (
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                dayBtn.classList.add("today", "future-day");
            } else {
                dayBtn.classList.add("future-day");
            }

            const formattedDate = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

            dayBtn.addEventListener("click", function () {
                document.querySelectorAll(".day-cell").forEach(cell => cell.classList.remove("selected"));
                this.classList.add("selected");
                selectedDateInput.value = formattedDate;
            });

            calendarGrid.appendChild(dayBtn);
        }
    }

    function generateTimeOptions() {
        timeOptions.innerHTML = "";

        const hours = [
            "8:00 AM", "9:00 AM", "10:00 AM", "11:00 AM",
            "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM",
            "4:00 PM", "5:00 PM", "6:00 PM", "7:00 PM"
        ];

        hours.forEach(time => {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "time-option";
            btn.textContent = time;

            btn.addEventListener("click", function () {
                document.querySelectorAll(".time-option").forEach(option => option.classList.remove("selected"));
                this.classList.add("selected");
                selectedTimeInput.value = time;
                selectedTimeText.textContent = time;
                timePopupOverlay.classList.remove("show");
            });

            timeOptions.appendChild(btn);
        });
    }

    function formatDate(dateString) {
        if (!dateString) return "-";
        const date = new Date(dateString);
        return date.toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });
    }

    function buildPurposeText() {
        const activeServices = [...document.querySelectorAll(".service-item.active")]
            .map(item => item.textContent.trim());

        return activeServices.length ? activeServices.join(", ") : "-";
    }

    function buildProductText() {
        const productLines = [];

        const tireSelected = document.querySelector('.product-group:nth-of-type(1) .product-title.active');
        const tireQty = document.querySelector('.qty-btn[data-group="tires"].active');

        if (tireSelected) {
            const qty = tireQty ? tireQty.textContent.trim() + "x " : "";
            productLines.push(`${qty}TIRES`);
        }

        const batterySelected = document.querySelector('.product-group:nth-of-type(2) .product-title.active');
        if (batterySelected) {
            productLines.push(`BATTERIES`);
        }

        const magSelected = document.querySelector('.product-group:nth-of-type(3) .product-title.active');
        const magQty = document.querySelector('.qty-btn[data-group="magwheels"].active');

        if (magSelected) {
            const qty = magQty ? magQty.textContent.trim() + "x " : "";
            productLines.push(`${qty}MAGWHEELS`);
        }

        return productLines.length ? productLines.join(" | ") : "-";
    }

    function updateConfirmation() {
        const fullName = [
            firstName.value.trim(),
            middleName.value.trim(),
            lastName.value.trim()
        ].filter(Boolean).join(" ");

        confirmNameText.textContent = fullName || "-";
        confirmMobileText.textContent = mobileNumber.value.trim() || "-";
        confirmEmailText.textContent = emailAddress.value.trim() || "-";
        confirmDateText.textContent = formatDate(selectedDateInput.value);
        confirmTimeText.textContent = selectedTimeInput.value || "-";
        confirmPurposeText.textContent = buildPurposeText();
        confirmProductText.textContent = buildProductText();
        confirmNotesText.textContent = notes.value.trim() ? `Notes: ${notes.value.trim()}` : "";
    }

    prevMonth.addEventListener("click", function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    });

    nextMonth.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentMonth, currentYear);
    });

    openTimePopup.addEventListener("click", function () {
        timePopupOverlay.classList.add("show");
        generateTimeOptions();
    });

    closeTimePopup.addEventListener("click", function () {
        timePopupOverlay.classList.remove("show");
    });

    timePopupOverlay.addEventListener("click", function (e) {
        if (e.target === timePopupOverlay) {
            timePopupOverlay.classList.remove("show");
        }
    });

    serviceItems.forEach(item => {
        item.addEventListener("click", function () {
            this.classList.toggle("active");
        });
    });

    productTitles.forEach(item => {
        item.addEventListener("click", function () {
            this.classList.toggle("active");
        });
    });

    qtyButtons.forEach(button => {
        button.addEventListener("click", function () {
            const group = this.getAttribute("data-group");
            const sameGroupButtons = document.querySelectorAll(`.qty-btn[data-group="${group}"]`);
            const isAlreadyActive = this.classList.contains("active");

            sameGroupButtons.forEach(btn => btn.classList.remove("active"));

            if (!isAlreadyActive) {
                this.classList.add("active");
            }
        });
    });

    fakeDropdowns.forEach(dropdown => {
        dropdown.addEventListener("click", function () {
            const type = this.getAttribute("data-type");

            if (type === "size") {
                popupTitle.textContent = "Size";
                popupContent.innerHTML = "<p>No size yet</p>";
            } else {
                popupTitle.textContent = "Brand";
                popupContent.innerHTML = "<p>No brands yet</p>";
            }

            popupOverlay.classList.add("show");
        });
    });

    closePopup.addEventListener("click", function () {
        popupOverlay.classList.remove("show");
    });

    popupOverlay.addEventListener("click", function (e) {
        if (e.target === popupOverlay) {
            popupOverlay.classList.remove("show");
        }
    });

    step1NextBtn.addEventListener("click", function () {
        step1.classList.add("hidden-step");
        step2.classList.remove("hidden-step");
    });

    step2BackBtn.addEventListener("click", function () {
        step2.classList.add("hidden-step");
        step1.classList.remove("hidden-step");
    });

    step2NextBtn.addEventListener("click", function () {
        updateConfirmation();

        editFirstName.value = firstName.value;
        editMiddleName.value = middleName.value;
        editLastName.value = lastName.value;
        editMobileNumber.value = mobileNumber.value;
        editEmailAddress.value = emailAddress.value;

        step2.classList.add("hidden-step");
        step3.classList.remove("hidden-step");
    });

    step3BackBtn.addEventListener("click", function () {
        step3.classList.add("hidden-step");
        step2.classList.remove("hidden-step");
    });

    appointmentDetailsEditBtn.addEventListener("click", function () {
        step3.classList.add("hidden-step");
        step2.classList.remove("hidden-step");
    });

    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            const target = this.getAttribute("data-edit");

            if (target === "name") {
                nameEditGroup.classList.toggle("hidden-edit");
                if (nameEditGroup.classList.contains("hidden-edit")) {
                    firstName.value = editFirstName.value;
                    middleName.value = editMiddleName.value;
                    lastName.value = editLastName.value;
                    updateConfirmation();
                }
            }

            if (target === "mobile") {
                mobileEditGroup.classList.toggle("hidden-edit");
                if (mobileEditGroup.classList.contains("hidden-edit")) {
                    mobileNumber.value = editMobileNumber.value;
                    updateConfirmation();
                }
            }

            if (target === "email") {
                emailEditGroup.classList.toggle("hidden-edit");
                if (emailEditGroup.classList.contains("hidden-edit")) {
                    emailAddress.value = editEmailAddress.value;
                    updateConfirmation();
                }
            }
        });
    });

    finishBtn.addEventListener("click", function () {
        paymentPopupOverlay.classList.add("show");
    });

    closePaymentPopup.addEventListener("click", function () {
        paymentPopupOverlay.classList.remove("show");
    });

    cancelPaymentBtn.addEventListener("click", function () {
        paymentPopupOverlay.classList.remove("show");
    });

    donePaymentBtn.addEventListener("click", function () {
        paymentPopupOverlay.classList.remove("show");
        successPopupOverlay.classList.add("show");
    });

    closeSuccessPopup.addEventListener("click", function () {
        successPopupOverlay.classList.remove("show");
    });

    closeSuccessBtn.addEventListener("click", function () {
        const formData = new FormData();
        formData.append("appt_date", selectedDateInput.value);
        formData.append("appt_time", selectedTimeInput.value);
        formData.append("purpose", buildPurposeText());

        fetch("save_appointment.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "homepage_customer.php";
            } else {
                alert(data.message || "Failed to save appointment.");
            }
        })
        .catch(() => {
            alert("Something went wrong while saving the appointment.");
        });
    });

    paymentPopupOverlay.addEventListener("click", function (e) {
        if (e.target === paymentPopupOverlay) {
            paymentPopupOverlay.classList.remove("show");
        }
    });

    successPopupOverlay.addEventListener("click", function (e) {
        if (e.target === successPopupOverlay) {
            successPopupOverlay.classList.remove("show");
        }
    });

    renderCalendar(currentMonth, currentYear);
    generateTimeOptions();
});

function goHome() {
    window.location.href = "homepage_customer.php";
}
