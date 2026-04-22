document.addEventListener("DOMContentLoaded", function () {
    const isUpcomingView = window.location.search.includes("view=upcoming");

    if (isUpcomingView) {
        return;
    }

    const step1 = document.getElementById("step1"); // Date + time + personal info
    const step2 = document.getElementById("step2"); // Service + product
    const step3 = document.getElementById("step3"); // Confirmation

    const step1BackBtn = document.getElementById("step1BackBtn");
    const step1NextBtn = document.getElementById("step1NextBtn");
    const step2BackBtn = document.getElementById("step2BackBtn");
    const step2NextBtn = document.getElementById("step2NextBtn");
    const step3BackBtn = document.getElementById("step3BackBtn");
    const appointmentDetailsEditBtn = document.getElementById("appointmentDetailsEditBtn");
    const finishBtn = document.getElementById("finishBtn");

    const selectedDateInput = document.getElementById("selectedDate");
    const selectedTimeInput = document.getElementById("selectedTime");
    const selectedTimeText = document.getElementById("selectedTimeText");

    const firstName = document.getElementById("firstName");
    const middleName = document.getElementById("middleName");
    const lastName = document.getElementById("lastName");
    const mobileNumber = document.getElementById("mobileNumber");
    const emailAddress = document.getElementById("emailAddress");
    const vehicleModel = document.getElementById("vehicleModel");

    const notes = document.getElementById("notes");
    const serviceItems = document.querySelectorAll(".service-item");

    const confirmNameText = document.getElementById("confirmNameText");
    const confirmMobileText = document.getElementById("confirmMobileText");
    const confirmEmailText = document.getElementById("confirmEmailText");
    const confirmVehicleText = document.getElementById("confirmVehicleText");
    const confirmDateText = document.getElementById("confirmDateText");
    const confirmTimeText = document.getElementById("confirmTimeText");
    const confirmDurationText = document.getElementById("confirmDurationText");
    const confirmPurposeText = document.getElementById("confirmPurposeText");
    const confirmProductText = document.getElementById("confirmProductText");
    const confirmNotesText = document.getElementById("confirmNotesText");
    const confirmTotalText = document.getElementById("confirmTotalText");

    const calendarGrid = document.getElementById("calendarGrid");
    const monthYear = document.getElementById("monthYear");
    const prevMonth = document.getElementById("prevMonth");
    const nextMonth = document.getElementById("nextMonth");

    const openTimePopup = document.getElementById("openTimePopup");
    const timePopupOverlay = document.getElementById("timePopupOverlay");
    const closeTimePopup = document.getElementById("closeTimePopup");
    const timeOptions = document.getElementById("timeOptions");

    const popupOverlay = document.getElementById("popupOverlay");
    const popupTitle = document.getElementById("popupTitle");
    const popupSearchInput = document.getElementById("popupSearchInput");
    const popupSortSelect = document.getElementById("popupSortSelect");
    const closePopup = document.getElementById("closePopup");
    const selectProductButtons = document.querySelectorAll(".select-product-btn");

    const paymentPopupOverlay = document.getElementById("paymentPopupOverlay");
    const closePaymentPopup = document.getElementById("closePaymentPopup");
    const cancelPaymentBtn = document.getElementById("cancelPaymentBtn");
    const donePaymentBtn = document.getElementById("donePaymentBtn");
    const paymentTotalText = document.getElementById("paymentTotalText");
    const reservationFeeText = document.getElementById("reservationFeeText");
    const paymentReferenceInput = document.getElementById("paymentReferenceInput");
    const paymentProofInput = document.getElementById("paymentProofInput");

    const successPopupOverlay = document.getElementById("successPopupOverlay");
    const closeSuccessPopup = document.getElementById("closeSuccessPopup");
    const closeSuccessBtn = document.getElementById("closeSuccessBtn");

    const selectedProductState = {
        tires: null,
        batteries: null,
        magwheels: null
    };

    let currentProductType = null;
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    function showStep(stepKey) {
        if (!step1 || !step2 || !step3) return;

        step1.classList.add("hidden-step");
        step2.classList.add("hidden-step");
        step3.classList.add("hidden-step");

        if (stepKey === "services") step2.classList.remove("hidden-step");
        if (stepKey === "datetime") step1.classList.remove("hidden-step");
        if (stepKey === "confirm") step3.classList.remove("hidden-step");
    }

    function formatDate(dateString) {
        if (!dateString) return "-";
        const date = new Date(dateString + "T00:00:00");
        return date.toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" });
    }

    function minutesTo12Hour(totalMinutes) {
        const hours24 = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;
        const suffix = hours24 >= 12 ? "PM" : "AM";
        const hours12 = hours24 % 12 === 0 ? 12 : hours24 % 12;
        return `${hours12}:${String(minutes).padStart(2, "0")} ${suffix}`;
    }

    function parseTimeToMinutes(timeStr) {
        if (!timeStr) return null;
        const normalized = timeStr.trim();

        if (normalized.includes("AM") || normalized.includes("PM")) {
            const parts = normalized.split(" ");
            if (parts.length !== 2) return null;
            const hm = parts[0].split(":");
            if (hm.length !== 2) return null;
            let h = parseInt(hm[0], 10);
            const m = parseInt(hm[1], 10);
            if (Number.isNaN(h) || Number.isNaN(m)) return null;
            if (parts[1] === "PM" && h !== 12) h += 12;
            if (parts[1] === "AM" && h === 12) h = 0;
            return h * 60 + m;
        }

        const hm = normalized.split(":");
        if (hm.length < 2) return null;
        const h = parseInt(hm[0], 10);
        const m = parseInt(hm[1], 10);
        if (Number.isNaN(h) || Number.isNaN(m)) return null;
        return h * 60 + m;
    }

    function getActiveServiceKeys() {
        return [...document.querySelectorAll(".service-item.active")].map(function (btn) {
            return (btn.textContent || "").trim().toUpperCase();
        });
    }

    function selectedUsesUnderchassisSlotPool() {
        return getActiveServiceKeys().includes("UNDERCHASSIS");
    }

    function appointmentUsesUnderchassisSlotPool(appointmentPurpose) {
        return String(appointmentPurpose || "").toUpperCase().includes("UNDERCHASSIS");
    }

    function getSlotLimitForSelection() {
        return selectedUsesUnderchassisSlotPool() ? 2 : 3;
    }

    function getEstimatedDurationMinutes() {
        let minutes = 0;
        const active = getActiveServiceKeys();

        if (active.includes("BATTERY CHANGE")) {
            minutes += 10;
        }

        if (active.includes("TIRE AND WHEEL CHANGE")) {
            const qty = parseInt(document.getElementById("tiresQtyInput")?.value || "1", 10);
            minutes += 15 * Math.max(1, qty);
        }

        if (active.includes("MAGWHEEL CHANGE")) {
            const qty = parseInt(document.getElementById("magwheelsQtyInput")?.value || "1", 10);
            minutes += 15 * Math.max(1, qty);
        }

        if (active.includes("UNDERCHASSIS")) {
            minutes += 60;
        }

        if (active.includes("VULCANIZE")) {
            minutes += 30;
        }

        return minutes;
    }

    function formatDurationText(totalMinutes) {
        if (!totalMinutes || totalMinutes < 1) return "-";
        const hours = Math.floor(totalMinutes / 60);
        const mins = totalMinutes % 60;
        if (hours > 0 && mins > 0) return `${hours}h ${mins}m`;
        if (hours > 0) return `${hours}h`;
        return `${mins}m`;
    }

    function getOverlapCount(dateYmd, startMin, endMin) {
        if (!Array.isArray(existingAppointmentSlots)) return 0;

        const selectedUnderchassis = selectedUsesUnderchassisSlotPool();
        let count = 0;

        existingAppointmentSlots.forEach(function (slot) {
            if (!slot || slot.appt_date !== dateYmd) return false;

            const existingStart = parseTimeToMinutes(String(slot.appt_time || ""));
            const existingDuration = parseInt(slot.estimated_duration_minutes || "60", 10);
            const existingUnderchassis = appointmentUsesUnderchassisSlotPool(slot.purpose || "");

            if (existingStart === null || Number.isNaN(existingDuration)) {
                return;
            }

            if (selectedUnderchassis !== existingUnderchassis) {
                return;
            }

            const existingEnd = existingStart + Math.max(1, existingDuration);
            const isOverlap = startMin < existingEnd && endMin > existingStart;
            if (isOverlap) {
                count += 1;
            }
        });

        return count;
    }

    function hasCapacity(dateYmd, startMin, endMin) {
        const overlapCount = getOverlapCount(dateYmd, startMin, endMin);
        return overlapCount < getSlotLimitForSelection();
    }

    function getSlotStats(dateYmd, startMin, endMin) {
        const used = getOverlapCount(dateYmd, startMin, endMin);
        const limit = getSlotLimitForSelection();
        const remaining = Math.max(0, limit - used);
        return { used, limit, remaining };
    }

    function hasAnyAvailableSlotForDate(dateYmd) {
        const duration = getEstimatedDurationMinutes();
        if (duration < 1) {
            return true;
        }

        const openMin = 8 * 60;
        const closeMin = 19 * 60;
        const step = 60;

        for (let start = openMin; start <= closeMin - step; start += step) {
            const end = start + duration;
            if (end > closeMin) continue;
            if (hasCapacity(dateYmd, start, end)) {
                return true;
            }
        }
        return false;
    }

    function clearSelectedTime() {
        if (selectedTimeInput) selectedTimeInput.value = "";
        if (selectedTimeText) selectedTimeText.textContent = "Choose Time";
    }

    function generateTimeOptions() {
        if (!timeOptions) return;

        timeOptions.innerHTML = "";

        const selectedDate = selectedDateInput?.value || "";
        if (!selectedDate) {
            const msg = document.createElement("div");
            msg.className = "product-picker-empty";
            msg.textContent = "Select a date first.";
            timeOptions.appendChild(msg);
            return;
        }

        const duration = getEstimatedDurationMinutes();
        if (duration < 1) {
            const msg = document.createElement("div");
            msg.className = "product-picker-empty";
            msg.textContent = "Select service and product first to generate time slots.";
            timeOptions.appendChild(msg);
            clearSelectedTime();
            return;
        }

        const openMin = 8 * 60;
        const closeMin = 19 * 60;
        const step = 60;
        const selectedCurrent = selectedTimeInput?.value || "";
        let availableCount = 0;

        for (let start = openMin; start <= closeMin - step; start += step) {
            const end = start + duration;
            const text = minutesTo12Hour(start);
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "time-option";

            const slotStats = getSlotStats(selectedDate, start, end);
            const metaText = slotStats.remaining > 0
                ? `Slots left: ${slotStats.remaining}/${slotStats.limit}`
                : `Full (${slotStats.used}/${slotStats.limit})`;
            btn.innerHTML = `
                <span class="time-option-main">${text}</span>
                <span class="time-option-meta">${metaText}</span>
            `;

            let canUse = true;
            if (end > closeMin) {
                canUse = false;
            } else if (slotStats.remaining <= 0) {
                canUse = false;
            }

            if (!canUse) {
                btn.classList.add("time-option-taken");
                btn.disabled = true;
            } else {
                availableCount += 1;

                if (selectedCurrent === text) {
                    btn.classList.add("selected");
                }

                btn.addEventListener("click", function () {
                    document.querySelectorAll(".time-option").forEach(function (option) {
                        option.classList.remove("selected");
                    });
                    btn.classList.add("selected");
                    if (selectedTimeInput) selectedTimeInput.value = text;
                    if (selectedTimeText) selectedTimeText.textContent = text;
                    if (timePopupOverlay) timePopupOverlay.classList.remove("show");
                    updateConfirmation();
                });
            }

            timeOptions.appendChild(btn);
        }

        const stillValid = [...timeOptions.querySelectorAll(".time-option")].some(function (el) {
            return el.textContent === selectedCurrent;
        });

        if (!stillValid) {
            clearSelectedTime();
        }

        if (availableCount === 0) {
            const msg = document.createElement("div");
            msg.className = "product-picker-empty";
            msg.textContent = "No available time slots for this date and service duration.";
            timeOptions.appendChild(msg);
        }
    }

    function buildPurposeText() {
        const activeServices = [...document.querySelectorAll(".service-item.active")]
            .map(function (item) { return item.textContent.trim(); });
        return activeServices.length ? activeServices.join(", ") : "-";
    }

    function buildProductText() {
        const lines = [];
        const tireItem = selectedProductState.tires;
        const batteryItem = selectedProductState.batteries;
        const magItem = selectedProductState.magwheels;
        const tireEnabled = document.querySelector('[data-product-group="tires"]')?.classList.contains("product-group-enabled");
        const batteryEnabled = document.querySelector('[data-product-group="batteries"]')?.classList.contains("product-group-enabled");
        const magEnabled = document.querySelector('[data-product-group="magwheels"]')?.classList.contains("product-group-enabled");

        if (tireEnabled && tireItem) {
            const qty = parseInt(document.getElementById("tiresQtyInput")?.value || "1", 10);
            lines.push(`${qty}x TIRES - ${tireItem.brand} ${tireItem.size}`);
        }

        if (batteryEnabled && batteryItem) {
            lines.push(`BATTERY - ${batteryItem.brand} ${batteryItem.size}`);
        }

        if (magEnabled && magItem) {
            const qty = parseInt(document.getElementById("magwheelsQtyInput")?.value || "1", 10);
            lines.push(`${qty}x MAGWHEELS - ${magItem.brand} ${magItem.size}`);
        }

        return lines.length ? lines.join(" | ") : "-";
    }

    function computeTotalCost() {
        let total = 0;

        const tireEnabled = document.querySelector('[data-product-group="tires"]')?.classList.contains("product-group-enabled");
        const batteryEnabled = document.querySelector('[data-product-group="batteries"]')?.classList.contains("product-group-enabled");
        const magEnabled = document.querySelector('[data-product-group="magwheels"]')?.classList.contains("product-group-enabled");

        if (tireEnabled && selectedProductState.tires) {
            const qty = parseInt(document.getElementById("tiresQtyInput")?.value || "1", 10);
            total += Number(selectedProductState.tires.price) * Math.max(1, qty);
        }

        if (batteryEnabled && selectedProductState.batteries) {
            total += Number(selectedProductState.batteries.price);
        }

        if (magEnabled && selectedProductState.magwheels) {
            const qty = parseInt(document.getElementById("magwheelsQtyInput")?.value || "1", 10);
            total += Number(selectedProductState.magwheels.price) * Math.max(1, qty);
        }

        return total;
    }

    function updatePaymentSummary() {
        const totalCost = computeTotalCost();
        const reservationFee = totalCost * 0.30;

        if (paymentTotalText) {
            paymentTotalText.textContent = "PHP " + totalCost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        if (reservationFeeText) {
            reservationFeeText.textContent = "PHP " + reservationFee.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }

    function updateConfirmation() {
        const fullName = [firstName?.value.trim(), middleName?.value.trim(), lastName?.value.trim()].filter(Boolean).join(" ");
        const duration = getEstimatedDurationMinutes();
        const totalCost = computeTotalCost();

        if (confirmNameText) confirmNameText.textContent = fullName || "-";
        if (confirmMobileText) confirmMobileText.textContent = mobileNumber?.value.trim() || "-";
        if (confirmEmailText) confirmEmailText.textContent = emailAddress?.value.trim() || "-";
        if (confirmVehicleText) confirmVehicleText.textContent = vehicleModel?.value.trim() || "-";
        if (confirmDateText) confirmDateText.textContent = formatDate(selectedDateInput?.value || "");
        if (confirmTimeText) confirmTimeText.textContent = selectedTimeInput?.value || "-";
        if (confirmDurationText) confirmDurationText.textContent = formatDurationText(duration);
        if (confirmPurposeText) confirmPurposeText.textContent = buildPurposeText();
        if (confirmProductText) confirmProductText.textContent = buildProductText();
        if (confirmNotesText) confirmNotesText.textContent = notes?.value.trim() ? `Notes: ${notes.value.trim()}` : "";

        if (confirmTotalText) {
            confirmTotalText.textContent = "PHP " + totalCost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }

    function renderCalendar(month, year) {
        if (!calendarGrid || !monthYear) return;

        calendarGrid.innerHTML = "";
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
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
            const formattedDate = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
            const hasAvailableOnDate = hasAnyAvailableSlotForDate(formattedDate);

            if (thisDate < todayOnly) {
                dayBtn.classList.add("past-day");
                dayBtn.disabled = true;
            } else if (!hasAvailableOnDate) {
                dayBtn.classList.add("fully-booked-day");
                dayBtn.disabled = true;
            } else if (thisDate.getTime() === todayOnly.getTime()) {
                dayBtn.classList.add("today", "future-day");
            } else {
                dayBtn.classList.add("future-day");
            }

            if (selectedDateInput?.value === formattedDate) {
                dayBtn.classList.add("selected");
            }

            dayBtn.addEventListener("click", function () {
                document.querySelectorAll(".day-cell").forEach(function (cell) {
                    cell.classList.remove("selected");
                });
                dayBtn.classList.add("selected");
                if (selectedDateInput) selectedDateInput.value = formattedDate;
                clearSelectedTime();
                generateTimeOptions();
                updateConfirmation();
            });

            calendarGrid.appendChild(dayBtn);
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

        const filtered = products.filter(function (item) {
            const text = `${item.brand} ${item.size} ${item.item_name}`.toLowerCase();
            return text.includes(searchKeyword);
        }).sort(function (a, b) {
            const priceA = Number(a.price) || 0;
            const priceB = Number(b.price) || 0;
            const brandA = (a.brand || "").toLowerCase();
            const brandB = (b.brand || "").toLowerCase();

            if (sortValue === "price_asc") return priceA - priceB;
            if (sortValue === "price_desc") return priceB - priceA;
            if (sortValue === "brand_asc") return brandA.localeCompare(brandB);
            if (sortValue === "brand_desc") return brandB.localeCompare(brandA);
            return 0;
        });

        if (filtered.length === 0) {
            popupList.innerHTML = `<div class="product-picker-empty">No matching products found.</div>`;
            return;
        }

        filtered.forEach(function (item) {
            const stock = parseInt(item.stock ?? 0, 10);
            const outOfStock = stock <= 0;
            const row = document.createElement("div");
            row.className = "product-picker-row";
            if (outOfStock) row.classList.add("out-of-stock-row");

            row.innerHTML = `
                <div>${item.brand ?? "-"}</div>
                <div>${item.size ?? "-"}</div>
                <div>PHP ${Number(item.price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                <div>${stock}</div>
                <div>${outOfStock ? "out of stock" : "available"}</div>
            `;

            if (!outOfStock) {
                row.addEventListener("click", function () {
                    selectedProductState[productType] = item;
                    applySelectedProduct(productType);
                    updateConfirmation();
                    generateTimeOptions();
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
        if (priceText) priceText.textContent = `PHP ${Number(item.price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        if (productIdInput) productIdInput.value = item.product_id;

        const qtyInput = document.getElementById(`${productType}QtyInput`);
        if (qtyInput) {
            const maxStock = Math.max(1, parseInt(item.stock || 1, 10));
            qtyInput.min = 1;
            qtyInput.max = maxStock;
            if (parseInt(qtyInput.value || "1", 10) > maxStock) {
                qtyInput.value = String(maxStock);
            }
        }
    }

    function updateProductGroupAvailability() {
        const groups = document.querySelectorAll(".product-group[data-product-group]");
        groups.forEach(function (group) {
            group.classList.remove("product-group-enabled");
            group.classList.add("product-group-disabled");
        });

        const activeServices = document.querySelectorAll(".service-item.active[data-enables]");
        activeServices.forEach(function (service) {
            const target = service.getAttribute("data-enables");
            const group = document.querySelector(`.product-group[data-product-group="${target}"]`);
            if (group) {
                group.classList.remove("product-group-disabled");
                group.classList.add("product-group-enabled");
            }
        });

        ["tires", "batteries", "magwheels"].forEach(function (productType) {
            const group = document.querySelector(`.product-group[data-product-group="${productType}"]`);
            const enabled = group?.classList.contains("product-group-enabled");
            if (enabled) return;

            selectedProductState[productType] = null;
            const button = document.querySelector(`.select-product-btn[data-product-type="${productType}"]`);
            const selectedText = document.getElementById(`${productType}SelectedText`);
            const priceText = document.getElementById(`${productType}PriceText`);
            const productIdInput = document.getElementById(`${productType}ProductId`);
            const qtyInput = document.getElementById(`${productType}QtyInput`);

            if (button) button.textContent = "Select Brand and Size";
            if (selectedText) selectedText.textContent = "None";
            if (priceText) priceText.textContent = "-";
            if (productIdInput) productIdInput.value = "";
            if (qtyInput) {
                qtyInput.value = "1";
                qtyInput.min = 1;
                qtyInput.max = 1;
            }
        });

        updateConfirmation();
        generateTimeOptions();
    }

    function validateServiceStep() {
        const selectedServices = [...document.querySelectorAll(".service-item.active")];
        if (selectedServices.length === 0) {
            alert("Please select at least one service.");
            return false;
        }

        const tireService = document.querySelector('.service-item[data-enables="tires"]')?.classList.contains("active");
        const batteryService = document.querySelector('.service-item[data-enables="batteries"]')?.classList.contains("active");
        const magService = document.querySelector('.service-item[data-enables="magwheels"]')?.classList.contains("active");

        const tireProduct = document.getElementById("tiresProductId")?.value.trim();
        const batteryProduct = document.getElementById("batteriesProductId")?.value.trim();
        const magProduct = document.getElementById("magwheelsProductId")?.value.trim();

        if (tireService && !tireProduct) {
            alert("Please select a tire product.");
            return false;
        }

        if (batteryService && !batteryProduct) {
            alert("Please select a battery product.");
            return false;
        }

        if (magService && !magProduct) {
            alert("Please select a magwheel product.");
            return false;
        }

        return true;
    }

    function validateDateTimeStep() {
        const selectedDate = selectedDateInput?.value.trim();
        const selectedTime = selectedTimeInput?.value.trim();
        const duration = getEstimatedDurationMinutes();

        if (!selectedDate) {
            alert("Please select a date.");
            return false;
        }

        if (!selectedTime) {
            alert("Please select a time.");
            return false;
        }

        if (!firstName?.value.trim() || !lastName?.value.trim() || !mobileNumber?.value.trim() || !emailAddress?.value.trim()) {
            alert("Please fill in first name, last name, mobile number, and email.");
            return false;
        }

        if (duration < 1) {
            alert("Please select services first.");
            return false;
        }

        const startMin = parseTimeToMinutes(selectedTime);
        if (startMin === null) {
            alert("Invalid selected time.");
            return false;
        }
        const endMin = startMin + duration;

        if (endMin > 19 * 60) {
            alert("Selected time exceeds business hours (until 7:00 PM).");
            return false;
        }

        if (!hasCapacity(selectedDate, startMin, endMin)) {
            alert("Selected time slot is already full. Please choose another time.");
            clearSelectedTime();
            generateTimeOptions();
            return false;
        }

        return true;
    }

    function resetPaymentInputs() {
        if (paymentReferenceInput) paymentReferenceInput.value = "";
        if (paymentProofInput) paymentProofInput.value = "";
    }

    function saveAppointment() {
        const referenceNumber = paymentReferenceInput?.value.trim() || "";
        const proofFile = paymentProofInput?.files?.[0] || null;
        const duration = getEstimatedDurationMinutes();
        const selectedTime = selectedTimeInput?.value || "";
        const startMin = parseTimeToMinutes(selectedTime);
        const endMin = startMin !== null ? startMin + duration : null;
        const totalCost = computeTotalCost();
        const reservationFee = totalCost * 0.30;

        if (!referenceNumber) {
            alert("Please enter the payment reference number.");
            return;
        }

        if (!proofFile) {
            alert("Please upload your payment proof screenshot.");
            return;
        }

        if (!proofFile.type.startsWith("image/")) {
            alert("Payment proof must be an image file.");
            return;
        }

        if (proofFile.size > 5 * 1024 * 1024) {
            alert("Payment proof must be 5MB or below.");
            return;
        }

        if (!validateServiceStep() || !validateDateTimeStep()) {
            return;
        }

        const activeServices = getActiveServiceKeys();
        const formData = new FormData();
        formData.append("appt_date", selectedDateInput?.value || "");
        formData.append("appt_time", selectedTime);
        formData.append("purpose", buildPurposeText());
        formData.append("notes", notes?.value || "");

        formData.append("tires_product_id", document.getElementById("tiresProductId")?.value || "");
        formData.append("tires_qty", document.getElementById("tiresQtyInput")?.value || "1");
        formData.append("batteries_product_id", document.getElementById("batteriesProductId")?.value || "");
        formData.append("magwheels_product_id", document.getElementById("magwheelsProductId")?.value || "");
        formData.append("magwheels_qty", document.getElementById("magwheelsQtyInput")?.value || "1");

        formData.append("service_tires", activeServices.includes("TIRE AND WHEEL CHANGE") ? "1" : "0");
        formData.append("service_batteries", activeServices.includes("BATTERY CHANGE") ? "1" : "0");
        formData.append("service_magwheels", activeServices.includes("MAGWHEEL CHANGE") ? "1" : "0");
        formData.append("service_underchassis", activeServices.includes("UNDERCHASSIS") ? "1" : "0");
        formData.append("service_vulcanize", activeServices.includes("VULCANIZE") ? "1" : "0");

        formData.append("estimated_duration_minutes", String(duration));
        formData.append("appt_end_time", endMin !== null ? minutesTo12Hour(endMin) : "");

        formData.append("reservation_reference", referenceNumber);
        formData.append("reservation_fee", reservationFee.toFixed(2));
        formData.append("payment_proof", proofFile);

        fetch("save_appointment.php", {
            method: "POST",
            body: formData
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (!data.success) {
                alert(data.message || "Failed to save appointment.");
                return;
            }

            if (paymentPopupOverlay) paymentPopupOverlay.classList.remove("show");
            if (successPopupOverlay) successPopupOverlay.classList.add("show");
            resetPaymentInputs();
        })
        .catch(function () {
            alert("Something went wrong while saving the appointment.");
        });
    }

    if (prevMonth) {
        prevMonth.addEventListener("click", function () {
            currentMonth -= 1;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear -= 1;
            }
            renderCalendar(currentMonth, currentYear);
        });
    }

    if (nextMonth) {
        nextMonth.addEventListener("click", function () {
            currentMonth += 1;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear += 1;
            }
            renderCalendar(currentMonth, currentYear);
        });
    }

    if (openTimePopup) {
        openTimePopup.addEventListener("click", function () {
            if (!selectedDateInput?.value) {
                alert("Please select a date first.");
                return;
            }
            generateTimeOptions();
            if (timePopupOverlay) timePopupOverlay.classList.add("show");
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

    serviceItems.forEach(function (item) {
        item.addEventListener("click", function () {
            item.classList.toggle("active");
            updateProductGroupAvailability();
        });
    });

    ["tires", "magwheels"].forEach(function (productType) {
        const qtyInput = document.getElementById(`${productType}QtyInput`);
        if (!qtyInput) return;

        qtyInput.addEventListener("input", function () {
            const item = selectedProductState[productType];
            const maxStock = item ? parseInt(item.stock || "1", 10) : 1;
            let value = parseInt(qtyInput.value || "1", 10);
            if (Number.isNaN(value) || value < 1) value = 1;
            if (value > maxStock) value = maxStock;
            qtyInput.value = String(value);
            updateConfirmation();
            generateTimeOptions();
        });
    });

    selectProductButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            currentProductType = button.getAttribute("data-product-type");
            if (popupSearchInput) popupSearchInput.value = "";
            if (popupSortSelect) popupSortSelect.value = "default";
            renderProductPopup(currentProductType);
            if (popupOverlay) popupOverlay.classList.add("show");
        });
    });

    if (popupSearchInput) {
        popupSearchInput.addEventListener("input", function () {
            if (currentProductType) {
                renderProductPopup(currentProductType, popupSearchInput.value);
            }
        });
    }

    if (popupSortSelect) {
        popupSortSelect.addEventListener("change", function () {
            if (currentProductType) {
                renderProductPopup(currentProductType, popupSearchInput?.value || "");
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

    if (step2BackBtn) {
        step2BackBtn.addEventListener("click", function () {
            goHome();
        });
    }

    if (step2NextBtn) {
        step2NextBtn.addEventListener("click", function () {
            if (!validateServiceStep()) return;
            showStep("datetime");
            updateConfirmation();
            generateTimeOptions();
        });
    }

    if (step1NextBtn) {
        step1NextBtn.addEventListener("click", function () {
            if (!validateDateTimeStep()) return;
            updateConfirmation();
            showStep("confirm");
        });
    }

    if (step1BackBtn) {
        step1BackBtn.addEventListener("click", function () {
            showStep("services");
        });
    }

    if (step3BackBtn) {
        step3BackBtn.addEventListener("click", function () {
            showStep("datetime");
        });
    }

    if (appointmentDetailsEditBtn) {
        appointmentDetailsEditBtn.addEventListener("click", function () {
            showStep("datetime");
        });
    }

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
            saveAppointment();
        });
    }

    if (closeSuccessPopup) {
        closeSuccessPopup.addEventListener("click", function () {
            if (successPopupOverlay) successPopupOverlay.classList.remove("show");
        });
    }

    if (closeSuccessBtn) {
        closeSuccessBtn.addEventListener("click", function () {
            window.location.href = "homepage_customer.php";
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

    if (notes) {
        notes.addEventListener("input", updateConfirmation);
    }

    [firstName, middleName, lastName, mobileNumber, emailAddress, vehicleModel].forEach(function (field) {
        if (field) field.addEventListener("input", updateConfirmation);
    });

    renderCalendar(currentMonth, currentYear);
    updateProductGroupAvailability();
    updateConfirmation();
    showStep("services");
});

function goHome() {
    window.location.href = "homepage_customer.php";
}
