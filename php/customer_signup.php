<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/customer_signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="signup-container">
        <div class="signup-card">

            <div class="logo">
                <i class="fa-solid fa-store"></i>
                <span>D.H AZADA TIRE SUPPLY</span>
            </div>

            <h1>Sign up to</h1>
            <p>D.H Azada Tire Supply Customer Portal</p>

            <form>
                <input type="text" placeholder="Enter your first name">
                <input type="text" placeholder="Enter your middle name">
                <input type="text" placeholder="Enter your last name">
                <input type="date" placeholder="Enter your birthday">
                <input type="text" placeholder="Enter your mobile number">
                <input type="email" placeholder="Enter your email">

                <div class="password-group">
                    <input type="password" id="password" placeholder="Enter your password">
                    <span class="toggle-eye" onclick="togglePassword('password', this)">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>

                <div class="password-group">
                    <input type="password" id="confirm_password" placeholder="Confirm your password">
                    <span class="toggle-eye" onclick="togglePassword('confirm_password', this)">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>

                <button type="submit" class="signup-btn">Sign Up</button>

                <p class="login-link">
                    Already have an account?
                    <a href="customer_login.php">Log in</a>
                </p>
            </form>

        </div>
    </div>

    <script src="../js/customer_signup.js"></script>
</body>
</html>