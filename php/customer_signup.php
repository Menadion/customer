<?php
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = trim($_POST['first_name']);
    $mname = trim($_POST['middle_name']);
    $lname = trim($_POST['last_name']);
    $birthday = $_POST['birthday'];
    $mobile_number = trim($_POST['mobile_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $checkStmt = $conn->prepare("SELECT customer_id FROM customer_tbl WHERE email = ? OR mobile_number = ?");
        $checkStmt->bind_param("ss", $email, $mobile_number);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        $emailExists = false;
        $mobileExists = false;

        while ($row = $result->fetch_assoc()) {
            $checkEmailStmt = $conn->prepare("SELECT customer_id FROM customer_tbl WHERE email = ?");
            $checkEmailStmt->bind_param("s", $email);
            $checkEmailStmt->execute();
            $checkEmailStmt->store_result();
            if ($checkEmailStmt->num_rows > 0) {
                $emailExists = true;
            }
            $checkEmailStmt->close();

            $checkMobileStmt = $conn->prepare("SELECT customer_id FROM customer_tbl WHERE mobile_number = ?");
            $checkMobileStmt->bind_param("s", $mobile_number);
            $checkMobileStmt->execute();
            $checkMobileStmt->store_result();
            if ($checkMobileStmt->num_rows > 0) {
                $mobileExists = true;
            }
            $checkMobileStmt->close();

            break;
        }

        if ($emailExists) {
            $message = "Email is already registered.";
        } elseif ($mobileExists) {
            $message = "Mobile number is already registered.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $status = "active";

            $stmt = $conn->prepare("
                INSERT INTO customer_tbl
                (email, password_hash, fname, mname, lname, birthday, mobile_number, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "ssssssss",
                $email,
                $password_hash,
                $fname,
                $mname,
                $lname,
                $birthday,
                $mobile_number,
                $status
            );

            if ($stmt->execute()) {
                $message = "Account created successfully. You may now log in.";
            } else {
                $message = "Error creating account.";
            }

            $stmt->close();
        }

        $checkStmt->close();
    }
}
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

            <?php if (!empty($message)): ?>
                <p style="color:#1f4037; font-weight:bold; margin-bottom:15px;">
                    <?php echo htmlspecialchars($message); ?>
                </p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="text" name="first_name" placeholder="Enter your first name" required>
                <input type="text" name="middle_name" placeholder="Enter your middle name">
                <input type="text" name="last_name" placeholder="Enter your last name" required>

                <div class="date-wrapper">
                    <input
                        type="text"
                        id="birthday"
                        name="birthday"
                        placeholder="Enter your birthday"
                        onfocus="activateBirthday(this)"
                        onblur="restoreBirthday(this)"
                        required
                    >
                </div>

                <input type="text" name="mobile_number" placeholder="Enter your mobile number" required>
                <input type="email" name="email" placeholder="Enter your email" required>

                <div class="password-group">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="toggle-eye" onclick="togglePassword('password', this)">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>

                <div class="password-group">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
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