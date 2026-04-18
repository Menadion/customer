<?php
include 'db_connect.php';
require_once 'flash.php';

$message = '';
$messageColor = 'red';

$token = trim($_GET['token'] ?? $_POST['token'] ?? '');
$userId = null;

function isStrongPassword($password) {
    return strlen($password) >= 8
        && preg_match('/[A-Z]/', $password)
        && preg_match('/[0-9]/', $password)
        && preg_match('/[^a-zA-Z0-9]/', $password);
}

if ($token === '') {
    setFlashMessage('Reset link is invalid.');
    header("Location: forgot_password.php");
    exit();
} else {
    $find = $conn->prepare("
        SELECT customer_id
        FROM customer_tbl
        WHERE password_reset_token = ?
          AND password_reset_expires_at IS NOT NULL
          AND password_reset_expires_at > NOW()
        LIMIT 1
    ");
    $find->bind_param("s", $token);
    $find->execute();
    $result = $find->get_result();

    if ($result->num_rows === 0) {
        $find->close();
        setFlashMessage('Reset link is invalid or expired.');
        header("Location: forgot_password.php");
        exit();
    } else {
        $user = $result->fetch_assoc();
        $userId = (int)$user['customer_id'];
    }

    $find->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userId !== null) {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (!isStrongPassword($newPassword)) {
        $message = 'Password must be at least 8 characters and include at least 1 uppercase letter, 1 number, and 1 special character.';
    } elseif ($newPassword !== $confirmPassword) {
        $message = 'Please make sure the passwords match.';
    } else {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $update = $conn->prepare("
            UPDATE customer_tbl
            SET password_hash = ?,
                password_reset_token = NULL,
                password_reset_expires_at = NULL
            WHERE customer_id = ?
        ");
        $update->bind_param("si", $passwordHash, $userId);

        if ($update->execute()) {
            $update->close();
            setFlashMessage("Password updated successfully. You may now log in.", "#1f4037");
            header("Location: customer_login.php");
            exit();
        }

        $update->close();
        $message = 'Could not reset password. Please try again.';
    }

    if ($message !== '') {
        setFlashMessage($message, $messageColor);
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }
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
    <title>Reset Password - D.H Azada Tire Supply</title>
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
                <h1>Reset</h1>
                <p>Create your new password.</p>

                <?php if (!empty($message)): ?>
                    <p style="color:<?php echo htmlspecialchars($messageColor); ?>; font-weight:bold; margin-bottom:15px;">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                <?php endif; ?>

                <?php if ($userId !== null): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-wrapper">
                                <input
                                    type="password"
                                    id="new_password"
                                    name="new_password"
                                    placeholder="Enter your new password"
                                    pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$"
                                    title="Password must be at least 8 characters and include at least 1 uppercase letter, 1 number, and 1 special character."
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <div class="input-wrapper">
                                <input
                                    type="password"
                                    id="confirm_password"
                                    name="confirm_password"
                                    placeholder="Confirm your new password"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="login-btn">CONFIRM</button>
                    </form>
                <?php else: ?>
                    <div class="bottom-text" style="margin-top: 8px;">
                        <a href="forgot_password.php">Request a new reset link</a>
                    </div>
                <?php endif; ?>

                <div class="bottom-text">
                    <a href="customer_login.php">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            const newPassword = document.getElementById("new_password");
            const confirmPassword = document.getElementById("confirm_password");

            if (!form || !newPassword || !confirmPassword) {
                return;
            }

            function validateConfirmPassword() {
                if (!confirmPassword.value) {
                    confirmPassword.setCustomValidity("");
                    return;
                }

                if (!newPassword.value) {
                    confirmPassword.setCustomValidity("Please enter your new password first.");
                    return;
                }

                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity("Please make sure the passwords match.");
                    return;
                }

                confirmPassword.setCustomValidity("");
            }

            confirmPassword.addEventListener("input", validateConfirmPassword);
            newPassword.addEventListener("input", validateConfirmPassword);
            form.addEventListener("submit", validateConfirmPassword);
        });
    </script>
</body>
</html>
