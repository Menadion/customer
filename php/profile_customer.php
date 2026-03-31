<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customerId = $_SESSION['customer_id'];
$defaultProfileImage = "../pictures/default_profile.png";

/*
    FLASH MESSAGE
*/
$message = $_SESSION['profile_message'] ?? "";
$messageType = $_SESSION['profile_message_type'] ?? "";

unset($_SESSION['profile_message'], $_SESSION['profile_message_type']);

/*
    UPDATE PROFILE
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === "update_profile") {
        $fname = trim($_POST['first_name'] ?? '');
        $mname = trim($_POST['middle_name'] ?? '');
        $lname = trim($_POST['last_name'] ?? '');
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($fname === '' || $lname === '') {
            $_SESSION['profile_message'] = "First name and last name are required.";
            $_SESSION['profile_message_type'] = "error";
            header("Location: profile_customer.php");
            exit();
        }

        if ($newPassword !== "" || $confirmPassword !== "") {
            if (strlen($newPassword) < 6) {
                $_SESSION['profile_message'] = "Password must be at least 6 characters.";
                $_SESSION['profile_message_type'] = "error";
                header("Location: profile_customer.php");
                exit();
            }

            if ($newPassword !== $confirmPassword) {
                $_SESSION['profile_message'] = "Passwords do not match.";
                $_SESSION['profile_message_type'] = "error";
                header("Location: profile_customer.php");
                exit();
            }

            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                UPDATE customer_tbl
                SET fname = ?, mname = ?, lname = ?, password_hash = ?
                WHERE customer_id = ?
            ");
            $stmt->bind_param("ssssi", $fname, $mname, $lname, $passwordHash, $customerId);

            if ($stmt->execute()) {
                $_SESSION['customer_name'] = trim($fname . ' ' . $lname);
                $_SESSION['profile_message'] = "Profile updated successfully.";
                $_SESSION['profile_message_type'] = "success";
            } else {
                $_SESSION['profile_message'] = "Failed to update profile.";
                $_SESSION['profile_message_type'] = "error";
            }

            $stmt->close();
            header("Location: profile_customer.php");
            exit();
        } else {
            $stmt = $conn->prepare("
                UPDATE customer_tbl
                SET fname = ?, mname = ?, lname = ?
                WHERE customer_id = ?
            ");
            $stmt->bind_param("sssi", $fname, $mname, $lname, $customerId);

            if ($stmt->execute()) {
                $_SESSION['customer_name'] = trim($fname . ' ' . $lname);
                $_SESSION['profile_message'] = "Profile updated successfully.";
                $_SESSION['profile_message_type'] = "success";
            } else {
                $_SESSION['profile_message'] = "Failed to update profile.";
                $_SESSION['profile_message_type'] = "error";
            }

            $stmt->close();
            header("Location: profile_customer.php");
            exit();
        }
    }

    /*
        UPLOAD PROFILE IMAGE
    */
    if ($action === "upload_image") {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
            $fileSize = $_FILES['profile_image']['size'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['profile_message'] = "Only JPG, JPEG, PNG, and WEBP images are allowed.";
                $_SESSION['profile_message_type'] = "error";
                header("Location: profile_customer.php");
                exit();
            }

            if ($fileSize > 2 * 1024 * 1024) {
                $_SESSION['profile_message'] = "Image must not exceed 2 MB.";
                $_SESSION['profile_message_type'] = "error";
                header("Location: profile_customer.php");
                exit();
            }

            $uploadDir = "../uploads/profile/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $newFileName = "customer_" . $customerId . "_" . time() . "." . strtolower($extension);
            $targetPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE customer_tbl SET profile_image = ? WHERE customer_id = ?");
                $stmt->bind_param("si", $targetPath, $customerId);

                if ($stmt->execute()) {
                    $_SESSION['profile_message'] = "Profile picture updated successfully.";
                    $_SESSION['profile_message_type'] = "success";
                } else {
                    $_SESSION['profile_message'] = "Image uploaded but database update failed.";
                    $_SESSION['profile_message_type'] = "error";
                }

                $stmt->close();
            } else {
                $_SESSION['profile_message'] = "Failed to upload image.";
                $_SESSION['profile_message_type'] = "error";
            }
        } else {
            $_SESSION['profile_message'] = "Please choose an image first.";
            $_SESSION['profile_message_type'] = "error";
        }

        header("Location: profile_customer.php");
        exit();
    }
}

/*
    GET CUSTOMER INFO
*/
$stmt = $conn->prepare("
    SELECT customer_id, fname, mname, lname, email, birthday, profile_image
    FROM customer_tbl
    WHERE customer_id = ?
");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$fullName = trim(($user['fname'] ?? '') . ' ' . ($user['mname'] ?? '') . ' ' . ($user['lname'] ?? ''));
$email = $user['email'] ?? '';
$birthday = $user['birthday'] ?? '';
$profileImage = !empty($user['profile_image']) ? $user['profile_image'] : $defaultProfileImage;

/*
    COMPUTE AGE FROM BIRTHDAY
*/
$age = "";
if (!empty($birthday)) {
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
}

/*
    HISTORY
    Leave empty if table is not available yet or no records yet
*/
$historyRows = [];
$historyTableExists = false;

$tableCheck = $conn->query("SHOW TABLES LIKE 'transaction_tbl'");
if ($tableCheck && $tableCheck->num_rows > 0) {
    $historyTableExists = true;

    $historyStmt = $conn->prepare("
        SELECT transaction_date, total_price, receipt_file
        FROM transaction_tbl
        WHERE customer_id = ?
        ORDER BY transaction_date DESC
    ");

    if ($historyStmt) {
        $historyStmt->bind_param("i", $customerId);
        $historyStmt->execute();
        $historyResult = $historyStmt->get_result();

        while ($row = $historyResult->fetch_assoc()) {
            $historyRows[] = $row;
        }

        $historyStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile_customer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <div class="menu">
            <a href="homepage_customer.php" class="nav-item">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Homepage</span>
            </a>

            <a href="appointment_customer.php" class="nav-item">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Appointment</span>
            </a>

            <a href="product_catalog.php" class="nav-item">
                <i class="fa-solid fa-circle-notch"></i>
                <span>Products</span>
            </a>

            <a href="services_customer.php" class="nav-item">
                <i class="fa-solid fa-gears"></i>
                <span>Services</span>
            </a>

            <a href="transaction_history.php" class="nav-item">
                <i class="fa-regular fa-clock"></i>
                <span>History</span>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <h2>Profile</h2>

            <div class="top-icons">
                <div class="notification-wrapper">
                    <button class="icon-btn" type="button" id="notificationBtn">
                        <i class="fa-solid fa-bell"></i>
                    </button>

                    <div class="notification-box hidden" id="notificationBox">
                        <h4>Notifications</h4>
                        <div class="notification-empty">No notification yet</div>
                    </div>
                </div>

                <div class="profile-dropdown">
                    <button type="button" class="profile-btn" id="profileToggle">
                        <img src="<?php echo htmlspecialchars($profileImage); ?>" class="top-profile-img" alt="Profile">
                    </button>

                    <div class="profile-menu hidden" id="profileMenu">
                        <a href="profile_customer.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <?php if (!empty($message)): ?>
            <div class="message-box <?php echo $messageType === 'success' ? 'success-message' : 'error-message'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-card-top">
                <button type="button" class="edit-btn" id="editProfileBtn">Edit</button>
            </div>

            <div class="profile-info-section">
                <div class="profile-image-box" id="openImageModal">
                    <img
                        src="<?php echo htmlspecialchars($profileImage); ?>"
                        alt="Profile Picture"
                        id="mainProfileImage"
                        class="main-profile-image"
                    >
                </div>

                <div class="profile-details">
                    <div class="view-mode" id="viewMode">
                        <h1 id="displayName"><?php echo htmlspecialchars($fullName); ?></h1>
                        <p class="profile-email"><?php echo htmlspecialchars($email); ?></p>
                        <p class="profile-age">
                            <strong>Age:</strong>
                            <span id="displayAge"><?php echo htmlspecialchars($age); ?></span>
                        </p>
                    </div>

                    <div class="edit-mode hidden" id="editMode">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="update_profile">

                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="first_name" value="<?php echo htmlspecialchars($user['fname'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" id="middleName" name="middle_name" value="<?php echo htmlspecialchars($user['mname'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="last_name" value="<?php echo htmlspecialchars($user['lname'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" id="newPassword" name="new_password" placeholder="Enter new password">
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm new password">
                            </div>

                            <div class="edit-actions">
                                <button type="submit" class="save-btn">Save</button>
                                <button type="button" class="cancel-btn" id="cancelEditBtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <div class="history-section">
            <h3>History</h3>

            <div class="history-card">
                <div class="history-header">
                    <div>Date</div>
                    <div>Price</div>
                    <div>Receipt</div>
                </div>

                <?php if (!empty($historyRows)): ?>
                    <?php foreach ($historyRows as $row): ?>
                        <div class="history-row">
                            <div>
                                <?php
                                echo htmlspecialchars(
                                    date("d, M Y h:i A", strtotime($row['transaction_date']))
                                );
                                ?>
                            </div>
                            <div>
                                PHP <?php echo htmlspecialchars(number_format((float)$row['total_price'], 2)); ?>
                            </div>
                            <div>
                                <?php if (!empty($row['receipt_file'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['receipt_file']); ?>" target="_blank" class="receipt-link">View Receipt</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if (!empty($historyRows)): ?>
                <div class="show-more-wrap">
                    <button type="button" class="show-more-btn">
                        Show more <i class="fa-solid fa-angle-down"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<div class="image-modal-overlay hidden" id="imageModal">
    <div class="image-modal">
        <button type="button" class="close-modal-btn" id="closeImageModal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="image-modal-content">
            <div class="modal-image-preview">
                <img
                    src="<?php echo htmlspecialchars($profileImage); ?>"
                    alt="Large Profile"
                    id="largeProfileImage"
                >
            </div>

            <form method="POST" action="" enctype="multipart/form-data" class="upload-box" id="uploadBox">
                <input type="hidden" name="action" value="upload_image">

                <div class="upload-content">
                    <h3>Drag and drop</h3>
                    <p>to upload photo (max 2 MB)</p>

                    <label for="profileUpload" class="upload-btn">
                        Choose an image to upload
                    </label>
                    <input type="file" id="profileUpload" name="profile_image" accept="image/*" hidden required>

                    <div class="selected-file" id="selectedFileName">No image selected</div>

                    <button type="submit" class="save-upload-btn">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/profile_customer.js"></script>
</body>
</html>