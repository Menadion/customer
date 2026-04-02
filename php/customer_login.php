<?php
// customer_login.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.H Azada Tire Supply - Customer Login</title>
    <link rel="stylesheet" href="../css/customer_login.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="background-blur blur-one"></div>
    <div class="background-blur blur-two"></div>
    <div class="background-blur blur-three"></div>

    <div class="page-wrapper">
        <div class="login-card">
            
            <div class="brand-pill">
                <div class="brand-icon">
                    <i class="fas fa-store"></i>
                </div>
                <span>D.H AZADA TIRE SUPPLY</span>
            </div>

            <div class="login-content">
                <h1>Log in to</h1>
                <p>D.H Azada Tire Supply Customer Portal</p>

                <form id="loginForm" action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                id="email" 
                                name="email" 
                                placeholder="Enter your registered username or email"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Enter your password"
                                required
                            >
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">LOGIN</button>

                    <div class="bottom-text">
                        Don’t have an account yet? <a href="customer_signup.php">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="floating-logo">
            <div class="brand-pill small-pill">
                <div class="brand-icon">
                    <i class="fas fa-store"></i>
                </div>
                <span>D.H AZADA TIRE SUPPLY</span>
            </div>
        </div>
    </div>

    <script src="../js/customer_login.js"></script>
</body>
</html>