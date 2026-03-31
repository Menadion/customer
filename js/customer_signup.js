function togglePassword(id, element) {
    const input = document.getElementById(id);
    const icon = element.querySelector("i");

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
    input.showPicker?.();
}

function togglePassword(id, element) {
    const input = document.getElementById(id);
    const icon = element.querySelector("i");

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

function togglePassword(id, element) {
    const input = document.getElementById(id);
    const icon = element.querySelector("i");

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