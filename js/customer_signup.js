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

    if (!form || !birthdayInput || !passwordInput || !confirmPasswordInput) {
        return;
    }

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
