document.addEventListener("DOMContentLoaded", function () {
    const isUpcomingView = window.location.search.includes("view=upcoming");

    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");
    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    const categoryMap = {
    tire: "tires",
    battery: "batteries",
    magwheel: "magwheels",
    underchassis: null,
    vulcanize: null
    };

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

    if (isUpcomingView) {
        return;
    }

    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const step3 = document.getElementById("step3");

    if (step1 && step2 && step3) {
        step1.classList.remove("hidden-step");
        step2.classList.add("hidden-step");
        step3.classList.add("hidden-step");
    }

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
    const confirmVehicleText = document.getElementById("confirmVehicleText");
    const confirmDateText = document.getElementById("confirmDateText");
    const confirmTimeText = document.getElementById("confirmTimeText");
    const confirmPurposeText = document.getElementById("confirmPurposeText");
    const confirmProductText = document.getElementById("confirmProductText");
    const confirmNotesText = document.getElementById("confirmNotesText");
    const confirmTotalText = document.getElementById("confirmTotalText");

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

    const serviceItems = document.querySelectorAll(".service-item");
    const notes = document.getElementById("notes");

    const selectProductButtons = document.querySelectorAll(".select-product-btn");
    const popupSearchInput = document.getElementById("popupSearchInput");
    const popupSortSelect = document.getElementById("popupSortSelect");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupTitle = document.getElementById("popupTitle");
    const closePopup = document.getElementById("closePopup");

    const paymentPopupOverlay = document.getElementById("paymentPopupOverlay");
    const closePaymentPopup = document.getElementById("closePaymentPopup");
    const cancelPaymentBtn = document.getElementById("cancelPaymentBtn");
    const donePaymentBtn = document.getElementById("donePaymentBtn");
    const paymentTotalText = document.getElementById("paymentTotalText");
    const reservationFeeText = document.getElementById("reservationFeeText");

    const successPopupOverlay = document.getElementById("successPopupOverlay");
    const closeSuccessPopup = document.getElementById("closeSuccessPopup");
    const closeSuccessBtn = document.getElementById("closeSuccessBtn");

    let currentProductType = null;

    const selectedProductState = {
        tires: null,
        batteries: null,
        magwheels: null
    };

    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    function renderCalendar(month, year) {
        if (!calendarGrid || !monthYear) return;

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
                if (selectedDateInput) {
                    selectedDateInput.value = formattedDate;
                }
            });

            calendarGrid.appendChild(dayBtn);
        }
    }

    function generateTimeOptions() {
        if (!timeOptions) return;

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
                if (selectedTimeInput) selectedTimeInput.value = time;
                if (selectedTimeText) selectedTimeText.textContent = time;
                if (timePopupOverlay) timePopupOverlay.classList.remove("show");
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

    function buildServiceText() {
        const activeServices = [...document.querySelectorAll(".service-item.active")]
            .map(item => item.textContent.trim());

        return activeServices.length ? activeServices.join(", ") : "-";
    }

    function buildProductText() {
        const productLines = [];

        const tiresGroupEnabled = document.querySelector('.product-group[data-product-group="tires"]')?.classList.contains("product-group-enabled");
        const batteriesGroupEnabled = document.querySelector('.product-group[data-product-group="batteries"]')?.classList.contains("product-group-enabled");
        const magwheelsGroupEnabled = document.querySelector('.product-group[data-product-group="magwheels"]')?.classList.contains("product-group-enabled");

        const tireItem = selectedProductState.tires;
        const tireQty = document.getElementById("tiresQtyInput")?.value || "1";

        if (tiresGroupEnabled && tireItem) {
            productLines.push(
                `${tireQty}x TIRES - ${tireItem.brand} ${tireItem.size} - PHP ${Number(tireItem.price).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`
            );
        }

        const batteryItem = selectedProductState.batteries;
        if (batteriesGroupEnabled && batteryItem) {
            productLines.push(
                `BATTERIES - ${batteryItem.brand} ${batteryItem.size} - PHP ${Number(batteryItem.price).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`
            );
        }

        const magItem = selectedProductState.magwheels;
        const magQty = document.getElementById("magwheelsQtyInput")?.value || "1";

        if (magwheelsGroupEnabled && magItem) {
            productLines.push(
                `${magQty}x MAGWHEELS - ${magItem.brand} ${magItem.size} - PHP ${Number(magItem.price).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`
            );
        }

        return productLines.length ? productLines.join(" | ") : "-";
    }

    function computeTotalCost() {
        let total = 0;

        const tireEnabled = document.querySelector('[data-product-group="tires"]')?.classList.contains("product-group-enabled");
        const batteryEnabled = document.querySelector('[data-product-group="batteries"]')?.classList.contains("product-group-enabled");
        const magEnabled = document.querySelector('[data-product-group="magwheels"]')?.classList.contains("product-group-enabled");

        if (tireEnabled && selectedProductState.tires) {
            const qty = parseInt(document.getElementById("tiresQtyInput")?.value || "1", 10);
            total += Number(selectedProductState.tires.price) * qty;
        }

        if (batteryEnabled && selectedProductState.batteries) {
            total += Number(selectedProductState.batteries.price);
        }

        if (magEnabled && selectedProductState.magwheels) {
            const qty = parseInt(document.getElementById("magwheelsQtyInput")?.value || "1", 10);
            total += Number(selectedProductState.magwheels.price) * qty;
        }

        return total;
    }


        function updatePaymentSummary() {
        const totalCost = computeTotalCost();
        const reservationFee = totalCost * 0.30;

        if (paymentTotalText) {
            paymentTotalText.textContent = "PHP " + totalCost.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        if (reservationFeeText) {
            reservationFeeText.textContent = "PHP " + reservationFee.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    }

    function renderProductPopup(productType, keyword = "") {
    if (typeof appointmentProductData === "undefined") return;

    const products = appointmentProductData[productType] || [];
    const searchKeyword = keyword.trim().toLowerCase();
    const popupList = document.getElementById("popupProductList");
    const sortValue = popupSortSelect ? popupSortSelect.value : "default";

    if (!popupList || !popupTitle) return;

    popupTitle.textContent = "Select Brand and Size";
    popupList.innerHTML = "";

    let filteredProducts = products.filter(item => {
        const searchableText = `${item.brand} ${item.size} ${item.item_name}`.toLowerCase();
        return searchableText.includes(searchKeyword);
    });

    filteredProducts.sort((a, b) => {
        const priceA = Number(a.price) || 0;
        const priceB = Number(b.price) || 0;
        const brandA = (a.brand || "").toLowerCase();
        const brandB = (b.brand || "").toLowerCase();

        switch (sortValue) {
            case "price_asc":
                return priceA - priceB;
            case "price_desc":
                return priceB - priceA;
            case "brand_asc":
                return brandA.localeCompare(brandB);
            case "brand_desc":
                return brandB.localeCompare(brandA);
            default:
                return 0;
        }
    });

    if (filteredProducts.length === 0) {
        popupList.innerHTML = `<div class="product-picker-empty">No matching products found.</div>`;
        return;
    }

    filteredProducts.forEach(item => {

        const stock = parseInt(item.stock ?? 0, 10);
        const isOutOfStock = stock <= 0;

        const row = document.createElement("div");
        row.className = "product-picker-row";

        if (isOutOfStock) {
            row.classList.add("out-of-stock-row");
        }

        row.innerHTML = `
            <div>${item.brand ?? "-"}</div>
            <div>${item.size ?? "-"}</div>
            <div>PHP ${Number(item.price).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}</div>
            <div>${stock}</div>
            <div>${isOutOfStock ? "out of stock" : "available"}</div>
        `;

        if (!isOutOfStock) {
            row.addEventListener("click", function () {
                selectedProductState[productType] = item;
                applySelectedProduct(productType);
                updateConfirmation();
                if (popupOverlay) popupOverlay.classList.remove("show");
            });
        }

        popupList.appendChild(row);
    });
}

    function applySelectedProduct(productType) {
        const item = selectedProductState[productType];
        if (!item) return;

        const button = document.querySelector(`.select-product-btn[data-product-type="${productType}"]`);
        const selectedText = document.getElementById(`${productType}SelectedText`);
        const priceText = document.getElementById(`${productType}PriceText`);
        const productIdInput = document.getElementById(`${productType}ProductId`);

        const displayText = `${item.brand} - ${item.size}`;

        if (button) button.textContent = displayText;
        if (selectedText) selectedText.textContent = displayText;
        if (priceText) {
            priceText.textContent = `PHP ${Number(item.price).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        }
        if (productIdInput) productIdInput.value = item.product_id;

        updateQuantityLimit(productType);
    }

    function updateQuantityLimit(productType) {
        const item = selectedProductState[productType];
        const qtyInput = document.getElementById(`${productType}QtyInput`);

        if (!qtyInput) return;

        if (!item) {
            qtyInput.min = 1;
            qtyInput.max = 1;
            qtyInput.value = 1;
            return;
        }

        const stock = Math.max(1, parseInt(item.stock || 0, 10));

        qtyInput.min = 1;
        qtyInput.max = stock;

        let currentValue = parseInt(qtyInput.value || "1", 10);

        if (isNaN(currentValue) || currentValue < 1) {
            currentValue = 1;
        }

        if (currentValue > stock) {
            currentValue = stock;
        }

        qtyInput.value = currentValue;
    }

    function updateConfirmation() {
        const fullName = [
            firstName?.value.trim(),
            middleName?.value.trim(),
            lastName?.value.trim()
        ].filter(Boolean).join(" ");

        if (confirmNameText) confirmNameText.textContent = fullName || "-";
        if (confirmMobileText) confirmMobileText.textContent = mobileNumber?.value.trim() || "-";
        if (confirmEmailText) confirmEmailText.textContent = emailAddress?.value.trim() || "-";
        if (confirmVehicleText) confirmVehicleText.textContent = vehicleModel?.value.trim() || "-";
        if (confirmDateText) confirmDateText.textContent = formatDate(selectedDateInput?.value);
        if (confirmTimeText) confirmTimeText.textContent = selectedTimeInput?.value || "-";
        if (confirmPurposeText) confirmPurposeText.textContent = buildServiceText();
        if (confirmProductText) confirmProductText.textContent = buildProductText();
        if (confirmNotesText) confirmNotesText.textContent = notes?.value.trim() ? `Notes: ${notes.value.trim()}` : "";

        const totalCost = computeTotalCost();
        if (confirmTotalText) {
            confirmTotalText.textContent = "PHP " + totalCost.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    }

    if (prevMonth) {
        prevMonth.addEventListener("click", function () {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });
    }

    if (nextMonth) {
        nextMonth.addEventListener("click", function () {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });
    }

    if (openTimePopup) {
        openTimePopup.addEventListener("click", function () {
            if (timePopupOverlay) timePopupOverlay.classList.add("show");
            generateTimeOptions();
        });
    }

    if (closeTimePopup) {
        closeTimePopup.addEventListener("click", function () {
            if (timePopupOverlay) timePopupOverlay.classList.remove("show");
        });
    }

    if (timePopupOverlay) {
        timePopupOverlay.addEventListener("click", function (e) {
            if (e.target === timePopupOverlay) {
                timePopupOverlay.classList.remove("show");
            }
        });
    }

    function updateProductGroupAvailability() {
        const allGroups = document.querySelectorAll(".product-group[data-product-group]");

        allGroups.forEach(group => {
            group.classList.remove("product-group-enabled");
            group.classList.add("product-group-disabled");
        });

        const activeServices = document.querySelectorAll(".service-item.active");

        activeServices.forEach(service => {
            const category = service.getAttribute("data-category");

            const mapped = categoryMap[category];

            if (!mapped) return;

            const matchingGroup = document.querySelector(
                `.product-group[data-product-group="${mapped}"]`
            );

            if (matchingGroup) {
                matchingGroup.classList.remove("product-group-disabled");
                matchingGroup.classList.add("product-group-enabled");
            }
        });

        updateConfirmation();
    }

    serviceItems.forEach(item => {
        item.addEventListener("click", function () {
            this.classList.toggle("active");
            updateProductGroupAvailability();
        });
    });

    updateProductGroupAvailability();

    ["tires", "magwheels"].forEach(productType => {
        const qtyInput = document.getElementById(`${productType}QtyInput`);

        if (qtyInput) {
            qtyInput.addEventListener("input", function () {
                const item = selectedProductState[productType];
                const maxStock = item ? parseInt(item.stock || 1, 10) : 1;
                let value = parseInt(this.value || "1", 10);

                if (isNaN(value) || value < 1) value = 1;
                if (value > maxStock) value = maxStock;

                this.value = value;
                updateConfirmation();
            });

            qtyInput.addEventListener("change", function () {
                const item = selectedProductState[productType];
                const maxStock = item ? parseInt(item.stock || 1, 10) : 1;
                let value = parseInt(this.value || "1", 10);

                if (isNaN(value) || value < 1) value = 1;
                if (value > maxStock) value = maxStock;

                this.value = value;
                updateConfirmation();
            });
        }
    });
    selectProductButtons.forEach(button => {
        button.addEventListener("click", function () {
            currentProductType = this.getAttribute("data-product-type");

            if (popupSearchInput) popupSearchInput.value = "";
            if (popupSortSelect) popupSortSelect.value = "default";

            if (popupOverlay) popupOverlay.classList.add("show");
            renderProductPopup(currentProductType);
        });
    });

    if (popupSearchInput) {
        popupSearchInput.addEventListener("input", function () {
            if (currentProductType) {
                renderProductPopup(currentProductType, this.value);
            }
        });
    }

    if (popupSortSelect) {
        popupSortSelect.addEventListener("change", function () {
            if (currentProductType) {
                renderProductPopup(currentProductType, popupSearchInput ? popupSearchInput.value : "");
            }
        });
    }

    if (closePopup) {
        closePopup.addEventListener("click", function () {
            if (popupOverlay) popupOverlay.classList.remove("show");
        });
    }

    if (popupOverlay) {
        popupOverlay.addEventListener("click", function (e) {
            if (e.target === popupOverlay) {
                popupOverlay.classList.remove("show");
            }
        });
    }

    if (step1NextBtn) {
        step1NextBtn.addEventListener("click", function () {
            if (step1) step1.classList.add("hidden-step");
            if (step2) step2.classList.remove("hidden-step");
        });
    }

    if (step2BackBtn) {
        step2BackBtn.addEventListener("click", function () {
            if (step2) step2.classList.add("hidden-step");
            if (step1) step1.classList.remove("hidden-step");
        });
    }

    if (step2NextBtn) {
        step2NextBtn.addEventListener("click", function () {
            updateConfirmation();

            if (editFirstName && firstName) editFirstName.value = firstName.value;
            if (editMiddleName && middleName) editMiddleName.value = middleName.value;
            if (editLastName && lastName) editLastName.value = lastName.value;
            if (editMobileNumber && mobileNumber) editMobileNumber.value = mobileNumber.value;
            if (editEmailAddress && emailAddress) editEmailAddress.value = emailAddress.value;

            if (step2) step2.classList.add("hidden-step");
            if (step3) step3.classList.remove("hidden-step");
        });
    }

    if (step3BackBtn) {
        step3BackBtn.addEventListener("click", function () {
            if (step3) step3.classList.add("hidden-step");
            if (step2) step2.classList.remove("hidden-step");
        });
    }

    if (appointmentDetailsEditBtn) {
        appointmentDetailsEditBtn.addEventListener("click", function () {
            if (step3) step3.classList.add("hidden-step");
            if (step2) step2.classList.remove("hidden-step");
        });
    }

    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            const target = this.getAttribute("data-edit");

            if (target === "name" && nameEditGroup) {
                nameEditGroup.classList.toggle("hidden-edit");
                if (nameEditGroup.classList.contains("hidden-edit")) {
                    if (firstName && editFirstName) firstName.value = editFirstName.value;
                    if (middleName && editMiddleName) middleName.value = editMiddleName.value;
                    if (lastName && editLastName) lastName.value = editLastName.value;
                    updateConfirmation();
                }
            }

            if (target === "mobile" && mobileEditGroup) {
                mobileEditGroup.classList.toggle("hidden-edit");
                if (mobileEditGroup.classList.contains("hidden-edit")) {
                    if (mobileNumber && editMobileNumber) mobileNumber.value = editMobileNumber.value;
                    updateConfirmation();
                }
            }

            if (target === "email" && emailEditGroup) {
                emailEditGroup.classList.toggle("hidden-edit");
                if (emailEditGroup.classList.contains("hidden-edit")) {
                    if (emailAddress && editEmailAddress) emailAddress.value = editEmailAddress.value;
                    updateConfirmation();
                }
            }
        });
    });

    if (finishBtn) {
        finishBtn.addEventListener("click", function () {
            updateConfirmation();
            updatePaymentSummary();
            if (paymentPopupOverlay) paymentPopupOverlay.classList.add("show");
        });
    }

    if (closePaymentPopup) {
        closePaymentPopup.addEventListener("click", function () {
            if (paymentPopupOverlay) paymentPopupOverlay.classList.remove("show");
        });
    }

    if (cancelPaymentBtn) {
        cancelPaymentBtn.addEventListener("click", function () {
            if (paymentPopupOverlay) paymentPopupOverlay.classList.remove("show");
        });
    }

    if (donePaymentBtn) {
        donePaymentBtn.addEventListener("click", function () {
            if (paymentPopupOverlay) paymentPopupOverlay.classList.remove("show");
            if (successPopupOverlay) successPopupOverlay.classList.add("show");
        });
    }

    if (closeSuccessPopup) {
        closeSuccessPopup.addEventListener("click", function () {
            if (successPopupOverlay) successPopupOverlay.classList.remove("show");
        });
    }

    if (closeSuccessBtn) {
        closeSuccessBtn.addEventListener("click", function () {
            const formData = new FormData();
            const selectedServices = document.querySelectorAll(".service-item.active");

            if (!selectedDateInput?.value || !selectedTimeInput?.value) {
                alert("Please select date and time.");
                return;
            }

            if (selectedServices.length === 0) {
                alert("Please select at least one service.");
                return;
            }

            closeSuccessBtn.disabled = true;
            formData.append("appt_date", selectedDateInput.value);
            formData.append("appt_time", selectedTimeInput.value);

            selectedServices.forEach(service => {
                const id = service.dataset.serviceId;
                if (id) {
                    formData.append("services[]", id);
                }
            });

            formData.append("notes", notes?.value || "");

            console.log("Submitting:", {
                date: selectedDateInput.value,
                time: selectedTimeInput.value,
                services: [...selectedServices]
                    .map(s => s.dataset.serviceId)
                    .filter(Boolean),
                notes: notes?.value
            });

            fetch("save_appointment.php", {
                method: "POST",
                body: formData
            })

            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = "homepage_customer.php";
                } else {
                    alert(data.message || "Failed to save appointment.");
                    closeSuccessBtn.disabled = false;
                }
            })
            .catch((err) => {
                console.error(err);
                alert("Something went wrong while saving the appointment.");
                closeSuccessBtn.disabled = false;
            });
        });
    }

    if (paymentPopupOverlay) {
        paymentPopupOverlay.addEventListener("click", function (e) {
            if (e.target === paymentPopupOverlay) {
                paymentPopupOverlay.classList.remove("show");
            }
        });
    }

    if (successPopupOverlay) {
        successPopupOverlay.addEventListener("click", function (e) {
            if (e.target === successPopupOverlay) {
                successPopupOverlay.classList.remove("show");
            }
        });
    }

    renderCalendar(currentMonth, currentYear);
    generateTimeOptions();
});

function goHome() {
    window.location.href = "homepage_customer.php";
}