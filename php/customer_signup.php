<?php
$conn = new mysqli("localhost", "root", "", "dh_azada");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if (isset($_POST['signup'])) {

    // Get inputs
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $birthday = $_POST['birthday'] ?? null;
    $mobile = trim($_POST['mobile_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT customer_id FROM customer_tbl WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error_message = "Email is already registered.";
    }
    $check->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB
    $stmt = $conn->prepare("
        INSERT INTO customer_tbl 
        (fname, mname, lname, birthday, mobile_number, email, password_hash, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'active')
    ");

    $stmt->bind_param("sssssss", $fname, $mname, $lname, $birthday, $mobile, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
            alert('Signup successful!');
            window.location.href = 'customer_login.php';
        </script>";
        exit;
    } else {
        $error_message = "Something went wrong. Please try again.";
    }

    $stmt->close();
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

            <form method="POST" action="">
                <input type="text" name="fname" placeholder="Enter your first name"
                value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>">

                <input type="text" name="mname" placeholder="Enter your middle name"
                value="<?php echo isset($_POST['mname']) ? htmlspecialchars($_POST['mname']) : ''; ?>">

                <input type="text" name="lname" placeholder="Enter your last name" required
                value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>">

                <input type="date" name="birthday"
                value="<?php echo isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : ''; ?>">

                <input type="tel" name="mobile_number" placeholder="Enter your mobile number" required
                value="<?php echo isset($_POST['mobile_number']) ? htmlspecialchars($_POST['mobile_number']) : ''; ?>">

                <input type="email" name="email" placeholder="Enter your email" required
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
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

                <button type="submit" name="signup" class="signup-btn">Sign Up</button>

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