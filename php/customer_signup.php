<?php
include 'db_connect.php';
require_once 'mailer.php';

$message = "";
$maxBirthday = (new DateTime('today'))->modify('-17 years')->format('Y-m-d');

function getBaseUrl() {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);
    $scheme = $isHttps ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    $scriptDir = str_replace('\\', '/', dirname($_SERVER['PHP_SELF'] ?? '/'));
    $segments = array_filter(explode('/', trim($scriptDir, '/')), function ($segment) {
        return $segment !== '';
    });
    $encodedPath = '';

    if (!empty($segments)) {
        $encodedPath = '/' . implode('/', array_map('rawurlencode', $segments));
    }

    return $scheme . '://' . $host . $encodedPath;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = trim($_POST['first_name']);
    $mname = trim($_POST['middle_name']);
    $lname = trim($_POST['last_name']);
    $birthday = $_POST['birthday'];
    $mobile_number = trim($_POST['mobile_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $birthdayDate = DateTime::createFromFormat('!Y-m-d', $birthday);
    $isValidBirthday = $birthdayDate && $birthdayDate->format('Y-m-d') === $birthday;
    $maxBirthdayDate = DateTime::createFromFormat('!Y-m-d', $maxBirthday);
    $isAtLeast17 = $isValidBirthday && $maxBirthdayDate && $birthdayDate <= $maxBirthdayDate;

    $hasMinLength = strlen($password) >= 8;
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasNumber = preg_match('/[0-9]/', $password);
    $hasSpecial = preg_match('/[^a-zA-Z0-9]/', $password);

    if (!$isValidBirthday) {
        $message = "Please enter a valid birthday.";
    } elseif (!$isAtLeast17) {
        $message = "You must be at least 17 years old to create an account.";
    } elseif (!$hasMinLength || !$hasUppercase || !$hasNumber || !$hasSpecial) {
        $message = "Password must be at least 8 characters and include at least 1 uppercase letter, 1 number, and 1 special character.";
    } elseif ($password !== $confirm_password) {
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
            $status = "inactive";
            $verificationToken = bin2hex(random_bytes(32));
            $verificationLink = getBaseUrl() . "/verify_customer.php?token=" . urlencode($verificationToken);

            $stmt = $conn->prepare("
                INSERT INTO customer_tbl
                (email, password_hash, fname, mname, lname, birthday, mobile_number, status, email_verification_token, email_verified_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)
            ");

            $stmt->bind_param(
                "sssssssss",
                $email,
                $password_hash,
                $fname,
                $mname,
                $lname,
                $birthday,
                $mobile_number,
                $status,
                $verificationToken
            );

            if ($stmt->execute()) {
                $mailError = '';
                $mailSent = sendVerificationEmail($email, $verificationLink, $mailError);
                if ($mailSent) {
                    $message = "Account created. Please check your email and click the verification link before logging in.";
                } else {
                    $message = "Account created, but verification email could not be sent. Use this link to verify: " . $verificationLink;
                    if ($mailError !== '') {
                        $message .= " (" . $mailError . ")";
                    }
                }
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
                        max="<?php echo htmlspecialchars($maxBirthday); ?>"
                        title="You must be at least 17 years old to create an account."
                        onfocus="activateBirthday(this)"
                        onblur="restoreBirthday(this)"
                        required
                    >
                </div>

                <input type="text" name="mobile_number" placeholder="Enter your mobile number" required>
                <input type="email" name="email" placeholder="Enter your email" required>

                <div class="password-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$"
                        title="Password must be at least 8 characters and include at least 1 uppercase letter, 1 number, and 1 special character."
                        required
                    >
                    <span class="toggle-eye" onclick="togglePassword('password', this)">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>

                <div class="password-group">
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Confirm your password"
                        pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$"
                        title="Password must be at least 8 characters and include at least 1 uppercase letter, 1 number, and 1 special character."
                        required
                    >
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
