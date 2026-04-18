<?php
include 'db_connect.php';
require_once 'flash.php';

$message = "";
$messageColor = "red";

if (isset($_GET['verified']) && $_GET['verified'] === '1') {
    setFlashMessage("Account verified. You may now log in.", "#1f4037");
    header("Location: customer_login.php");
    exit();
} elseif (isset($_GET['verified']) && $_GET['verified'] === 'invalid') {
    setFlashMessage("Verification link is invalid or expired.");
    header("Location: customer_login.php");
    exit();
} elseif (isset($_GET['reset']) && $_GET['reset'] === 'success') {
    setFlashMessage("Password updated successfully. You may now log in.", "#1f4037");
    header("Location: customer_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT customer_id, email, password_hash, fname, lname, status FROM customer_tbl WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        setFlashMessage("Wrong email or password.");
    } else {
        $user = $result->fetch_assoc();

        if (!password_verify($password, $user['password_hash'])) {
            setFlashMessage("Wrong email or password.");
        } elseif ($user['status'] !== 'active') {
            setFlashMessage("Please verify your email before logging in.");
        } else {
            $_SESSION['customer_id'] = $user['customer_id'];
            $_SESSION['customer_email'] = $user['email'];
            $_SESSION['customer_name'] = trim($user['fname'] . ' ' . $user['lname']);

            $updateLogin = $conn->prepare("UPDATE customer_tbl SET last_login = NOW() WHERE customer_id = ?");
            $updateLogin->bind_param("i", $user['customer_id']);
            $updateLogin->execute();
            $updateLogin->close();

            header("Location: homepage_customer.php");
            exit();
        }
    }

    $stmt->close();
    header("Location: customer_login.php");
    exit();
}

$flash = popFlashMessage();
if ($flash !== null) {
    $message = $flash['message'];
    $messageColor = $flash['color'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.H Azada Tire Supply - Customer Login</title>
    <link rel="stylesheet" href="../css/customer_login.css">
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

                <?php if (!empty($message)): ?>
                    <p style="color:<?php echo htmlspecialchars($messageColor); ?>; font-weight:bold; margin-bottom:15px;">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                <?php endif; ?>

                <form id="loginForm" action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                placeholder="Enter your registered email"
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
                        <div class="forgot-row">
                            <a class="forgot-link" href="forgot_password.php">Forgot password?</a>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">LOGIN</button>

                    <div class="bottom-text">
                        Don’t have an account yet? <a href="customer_signup.php">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/customer_login.js"></script>
</body>
</html>
