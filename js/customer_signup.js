function togglePassword(id, element) {
    const input = document.getElementById(id);
    const icon = element.querySelector("i");

    if (!input || !icon) {
        return;
    }

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}

function activateBirthday(input) {
    input.type = "date";

    if (input.showPicker) {
        input.showPicker();
    }
}

function restoreBirthday(input) {
    if (!input.value) {
        input.type = "text";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const birthdayInput = document.getElementById("birthday");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");
    const openTermsModalBtn = document.getElementById("openTermsModal");
    const closeTermsModalBtn = document.getElementById("closeTermsModal");
    const termsModalOverlay = document.getElementById("termsModalOverlay");
    const openPrivacyModalBtn = document.getElementById("openPrivacyModal");
    const closePrivacyModalBtn = document.getElementById("closePrivacyModal");
    const privacyModalOverlay = document.getElementById("privacyModalOverlay");

    if (!form || !birthdayInput || !passwordInput || !confirmPasswordInput) {
        return;
    }

    function openTermsModal() {
        if (!termsModalOverlay) return;
        termsModalOverlay.classList.add("show");
        document.body.style.overflow = "hidden";
    }

    function closeTermsModal() {
        if (!termsModalOverlay) return;
        termsModalOverlay.classList.remove("show");
        document.body.style.overflow = "";
    }

    function openPrivacyModal() {
        if (!privacyModalOverlay) return;
        privacyModalOverlay.classList.add("show");
        document.body.style.overflow = "hidden";
    }

    function closePrivacyModal() {
        if (!privacyModalOverlay) return;
        privacyModalOverlay.classList.remove("show");
        document.body.style.overflow = "";
    }

    if (openTermsModalBtn) {
        openTermsModalBtn.addEventListener("click", openTermsModal);
    }

    if (closeTermsModalBtn) {
        closeTermsModalBtn.addEventListener("click", closeTermsModal);
    }

    if (openPrivacyModalBtn) {
        openPrivacyModalBtn.addEventListener("click", openPrivacyModal);
    }

    if (closePrivacyModalBtn) {
        closePrivacyModalBtn.addEventListener("click", closePrivacyModal);
    }

    if (termsModalOverlay) {
        termsModalOverlay.addEventListener("click", function (event) {
            if (event.target === termsModalOverlay) {
                closeTermsModal();
            }
        });
    }

    if (privacyModalOverlay) {
        privacyModalOverlay.addEventListener("click", function (event) {
            if (event.target === privacyModalOverlay) {
                closePrivacyModal();
            }
        });
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            if (termsModalOverlay?.classList.contains("show")) {
                closeTermsModal();
            }
            if (privacyModalOverlay?.classList.contains("show")) {
                closePrivacyModal();
            }
        }
    });

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const day = String(date.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    }

    function getMaxBirthday() {
        const today = new Date();
        return new Date(today.getFullYear() - 17, today.getMonth(), today.getDate());
    }

    function validateBirthday() {
        const maxBirthday = formatDate(getMaxBirthday());
        birthdayInput.max = maxBirthday;

        if (!birthdayInput.value) {
            birthdayInput.setCustomValidity("");
            return;
        }

        if (birthdayInput.value > maxBirthday) {
            birthdayInput.setCustomValidity("You must be at least 17 years old to create an account.");
            return;
        }

        birthdayInput.setCustomValidity("");
    }

    function validateConfirmPassword() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (!confirmPassword) {
            confirmPasswordInput.setCustomValidity("");
            return;
        }

        if (!password) {
            confirmPasswordInput.setCustomValidity("Please enter your password first.");
            return;
        }

        if (confirmPassword !== password) {
            confirmPasswordInput.setCustomValidity("Please make sure the passwords match.");
            return;
        }

        confirmPasswordInput.setCustomValidity("");
    }

    validateBirthday();
    birthdayInput.addEventListener("input", validateBirthday);
    birthdayInput.addEventListener("change", validateBirthday);
    confirmPasswordInput.addEventListener("input", validateConfirmPassword);
    passwordInput.addEventListener("input", validateConfirmPassword);
    form.addEventListener("submit", function () {
        validateBirthday();
        validateConfirmPassword();
    });
});
