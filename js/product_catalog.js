document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");
    const pageTitle = document.getElementById("pageTitle");
    const searchInput = document.getElementById("searchInput");
    const sortSelect = document.getElementById("sortSelect");

    const notificationBtn = document.getElementById("notificationBtn");
    const notificationBox = document.getElementById("notificationBox");

    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    function getActiveTab() {
        return document.querySelector(".tab-content.active");
    }

    function sortProducts() {
        const activeTab = getActiveTab();
        if (!activeTab || !sortSelect) return;

        const rows = Array.from(activeTab.querySelectorAll(".product-row"));
        const sortValue = sortSelect.value;

        rows.sort((a, b) => {
            const brandA = (a.dataset.brand || "").toLowerCase();
            const brandB = (b.dataset.brand || "").toLowerCase();
            const priceA = parseFloat(a.dataset.price || "0");
            const priceB = parseFloat(b.dataset.price || "0");

            if (sortValue === "price-low-high") {
                return priceA - priceB;
            }

            if (sortValue === "price-high-low") {
                return priceB - priceA;
            }

            if (sortValue === "brand-a-z") {
                return brandA.localeCompare(brandB);
            }

            if (sortValue === "brand-z-a") {
                return brandB.localeCompare(brandA);
            }

            return 0;
        });

        rows.forEach(row => activeTab.appendChild(row));
    }

    function filterProducts() {
        const activeTab = getActiveTab();
        if (!activeTab) return;

        const keyword = (searchInput?.value || "").trim().toLowerCase();
        const rows = activeTab.querySelectorAll(".product-row");
        const emptyState = activeTab.querySelector(".empty-state");
        let visibleCount = 0;

        rows.forEach(row => {
            const brand = row.dataset.brand || "";
            const size = row.dataset.size || "";
            const price = row.dataset.price || "";
            const status = row.dataset.status || "";

            const searchableText = `${brand} ${size} ${price} ${status}`;

            if (keyword === "" || searchableText.includes(keyword)) {
                row.style.display = "grid";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? "flex" : "none";
        }
    }

    function applyFiltersAndSort() {
        sortProducts();
        filterProducts();
    }

    tabButtons.forEach(button => {
        button.addEventListener("click", function () {
            const tab = this.getAttribute("data-tab");

            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabContents.forEach(content => content.classList.remove("active"));

            this.classList.add("active");
            document.getElementById(`tab-${tab}`).classList.add("active");

            if (tab === "tires") {
                pageTitle.textContent = "Tires";
            } else if (tab === "battery") {
                pageTitle.textContent = "Battery";
            } else {
                pageTitle.textContent = "Rims";
            }

            applyFiltersAndSort();
        });
    });

    if (searchInput) {
        searchInput.addEventListener("input", filterProducts);
    }

    if (sortSelect) {
        sortSelect.addEventListener("change", applyFiltersAndSort);
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

    if (notificationBtn && notificationBox) {
        notificationBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            notificationBox.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!notificationBtn.contains(event.target) && !notificationBox.contains(event.target)) {
                notificationBox.classList.add("hidden");
            }
        });
    }

    applyFiltersAndSort();
});