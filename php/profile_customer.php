<?php
session_start();
include 'db_connect.php';
include 'appointment_guard.php';
include 'customer_ui.php';

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
        $mobileNumber = trim($_POST['mobile_number'] ?? '');
        $birthdayInput = trim($_POST['birthday'] ?? '');
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
                SET fname = ?, mname = ?, lname = ?, mobile_number = ?, birthday = ?, password_hash = ?
                WHERE customer_id = ?
            ");
            $stmt->bind_param("ssssssi", $fname, $mname, $lname, $mobileNumber, $birthdayInput, $passwordHash, $customerId);

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
                SET fname = ?, mname = ?, lname = ?, mobile_number = ?, birthday = ?
                WHERE customer_id = ?
            ");
            $stmt->bind_param("sssssi", $fname, $mname, $lname, $mobileNumber, $birthdayInput, $customerId);

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
    SELECT customer_id, fname, mname, lname, email, birthday, mobile_number, created_at, profile_image
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
$mobile = $user['mobile_number'] ?? '';
$createdAt = $user['created_at'] ?? '';
$profileImage = !empty($user['profile_image']) ? $user['profile_image'] : $defaultProfileImage;
$customerNotifications = dh_get_customer_notifications($conn, $_SESSION['customer_id'] ?? null);

/*
    COMPUTE AGE FROM BIRTHDAY
*/
$age = "";
if (!empty($birthday)) {
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
}

$memberSince = "";
if (!empty($createdAt)) {
    $memberSince = date("F j, Y", strtotime($createdAt));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile_customer.css">
    <link rel="stylesheet" href="../css/customer_ui_shared.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
    <?php dh_render_customer_sidebar('profile', $hasExistingAppointment, 'menu', $profileImage, $customerNotifications); ?>

    <main class="main-content">
        <div class="topbar">
            <h2>Profile</h2>
        </div>

        <hr>

        <?php if (!empty($message)): ?>
            <div class="message-box <?php echo $messageType === 'success' ? 'success-message' : 'error-message'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-banner"></div>

            <div class="profile-card-top">
                <button type="button" class="edit-btn" id="editProfileBtn">Edit</button>
            </div>

            <div class="profile-header">
                <div class="profile-image-box" id="openImageModal">
                    <img
                        src="<?php echo htmlspecialchars($profileImage); ?>"
                        alt="Profile Picture"
                        id="mainProfileImage"
                        class="main-profile-image"
                    >
                </div>

                <div class="profile-identity">
                    <h1 id="displayName"><?php echo htmlspecialchars($fullName); ?></h1>
                    <p class="profile-email"><?php echo htmlspecialchars($email); ?></p>
                </div>
            </div>

            <!-- VIEW MODE -->
            <div class="view-mode" id="viewMode">
                <div class="profile-form-grid" id="profileInfoGrid">
                    <div class="profile-info-field">
                        <label>Age</label>
                        <div class="profile-info-value"><?php echo htmlspecialchars($age ?: "-"); ?></div>
                    </div>

                    <div class="profile-info-field">
                        <label>Mobile Number</label>
                        <div class="profile-info-value"><?php echo htmlspecialchars($mobile ?: "-"); ?></div>
                    </div>

                    <div class="profile-info-field">
                        <label>Birthday</label>
                        <div class="profile-info-value">
                            <?php echo !empty($birthday) ? date("F j, Y", strtotime($birthday)) : "-"; ?>
                        </div>
                    </div>

                    <div class="profile-info-field">
                        <label>Member Since</label>
                        <div class="profile-info-value"><?php echo htmlspecialchars($memberSince ?: "-"); ?></div>
                    </div>
                </div>
            </div>

            <!-- EDIT MODE -->
            <div class="edit-mode hidden" id="editMode">
                <form method="POST" action="" class="profile-edit-form">
                    <input type="hidden" name="action" value="update_profile">

                    <div class="profile-form-grid">
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
                            <label for="mobileNumber">Mobile Number</label>
                            <input type="text" id="mobileNumber" name="mobile_number" value="<?php echo htmlspecialchars($mobile ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($birthday ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="memberSinceDisplay">Member Since</label>
                            <input type="text" id="memberSinceDisplay" value="<?php echo htmlspecialchars($memberSince ?: '-'); ?>" readonly>
                        </div>
                       <div class="password-toggle-row">
                            <label for="changePasswordToggle" class="password-toggle-label">
                                <input type="checkbox" id="changePasswordToggle">
                                Change Password
                            </label>
                        </div>

                        <div class="password-fields hidden" id="passwordFields">
                            <div class="password-grid">
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" id="newPassword" name="new_password" placeholder="Enter new password">
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>

                    <div class="edit-actions">
                        <button type="submit" class="save-btn">Save</button>
                        <button type="button" class="cancel-btn" id="cancelEditBtn">Cancel</button>
                    </div>
                </form>
            </div>
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

<script src="../js/customer_ui_shared.js"></script>
<script src="../js/profile_customer.js"></script>
<script src="../js/appointment_guard.js"></script>
</body>
</html>
