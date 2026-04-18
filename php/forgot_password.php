<?php
include 'db_connect.php';
require_once 'mailer.php';
require_once 'flash.php';

$message = '';
$messageColor = '#1f4037';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $message = 'Please enter your email address.';
        $messageColor = 'red';
    } else {
        $stmt = $conn->prepare("SELECT customer_id FROM customer_tbl WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = 'If this email is registered, a password reset link has been sent.';
        } else {
            $user = $result->fetch_assoc();
            $token = bin2hex(random_bytes(32));
            $resetLink = getBaseUrl() . "/reset_password.php?token=" . urlencode($token);

            $update = $conn->prepare("
                UPDATE customer_tbl
                SET password_reset_token = ?, password_reset_expires_at = DATE_ADD(NOW(), INTERVAL 1 HOUR)
                WHERE customer_id = ?
            ");
            $update->bind_param("si", $token, $user['customer_id']);

            if ($update->execute()) {
                $mailError = '';
                $mailSent = sendPasswordResetEmail($email, $resetLink, $mailError);

                if ($mailSent) {
                    $message = 'Password reset link sent. Please check your email.';
                } else {
                    $message = 'Could not send reset email. Please try again. (' . $mailError . ')';
                    $messageColor = 'red';
                }
            } else {
                $message = 'Could not process your request right now.';
                $messageColor = 'red';
            }

            $update->close();
        }

        $stmt->close();
    }

    setFlashMessage($message, $messageColor);
    header("Location: forgot_password.php");
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
    <title>Forgot Password - D.H Azada Tire Supply</title>
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
                <h1>Forgot</h1>
                <p>Enter your email to receive a password reset link.</p>

                <?php if (!empty($message)): ?>
                    <p style="color:<?php echo htmlspecialchars($messageColor); ?>; font-weight:bold; margin-bottom:15px;">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                <?php endif; ?>

                <form action="" method="POST">
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

                    <button type="submit" class="login-btn">SEND RESET LINK</button>

                    <div class="bottom-text">
                        Remembered your password? <a href="customer_login.php">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
