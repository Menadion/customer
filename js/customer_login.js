document.addEventListener("DOMContentLoaded", function () {

    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const loginForm = document.getElementById("loginForm");

    // show/hide password
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

    // TEMP LOGIN (no database yet)
    loginForm.addEventListener("submit", function(e){

        e.preventDefault();

        // redirect to homepage
        window.location.href = "homepage_customer.php";

    });

});