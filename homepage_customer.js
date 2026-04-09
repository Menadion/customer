document.addEventListener("DOMContentLoaded", function () {

    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    togglePassword.addEventListener("click", function () {

        const icon = this.querySelector("i");

        if(passwordInput.type === "password"){
            passwordInput.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }else{
            passwordInput.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }

    });

});

const email = document.getElementById("email");

if(email){
    email.addEventListener("input", function () {
        this.setCustomValidity("");
    });
}