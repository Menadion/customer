<?php

if (!function_exists('dh_get_customer_profile_image')) {
    function dh_get_customer_profile_image(mysqli $conn, ?int $customerId, string $default = "../pictures/default_profile.png"): string
    {
        if (empty($customerId)) {
            return $default;
        }

        $stmt = $conn->prepare("SELECT profile_image FROM customer_tbl WHERE customer_id = ?");
        if (!$stmt) {
            return $default;
        }

        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result ? $result->fetch_assoc() : null;
        $stmt->close();

        if (!empty($user['profile_image'])) {
            return (string)$user['profile_image'];
        }

        return $default;
    }
}

if (!function_exists('dh_render_customer_sidebar')) {
    function dh_render_customer_sidebar(string $activePage, bool $hasExistingAppointment = false, string $menuClass = 'menu'): void
    {
        $links = [
            'home' => ['href' => 'homepage_customer.php', 'icon' => 'fa-solid fa-table-cells-large', 'label' => 'Homepage'],
            'appointment' => ['href' => 'appointment_customer.php', 'icon' => 'fa-regular fa-calendar-check', 'label' => 'Appointment'],
            'products' => ['href' => 'product_catalog.php', 'icon' => 'fa-solid fa-circle-notch', 'label' => 'Products'],
            'services' => ['href' => 'services_customer.php', 'icon' => 'fa-solid fa-gears', 'label' => 'Services'],
            'history' => ['href' => 'transaction_history.php', 'icon' => 'fa-regular fa-clock', 'label' => 'History'],
            'profile' => ['href' => 'profile_customer.php', 'icon' => 'fa-regular fa-user', 'label' => 'Profile'],
            'policies' => ['href' => 'policies_customer.php', 'icon' => 'fa-regular fa-file-lines', 'label' => 'Policies'],
        ];

        echo '<aside class="sidebar">';
        echo '<div class="' . htmlspecialchars($menuClass) . '">';

        foreach ($links as $key => $link) {
            if (!in_array($key, ['home', 'appointment', 'products', 'services', 'history'], true)) {
                continue;
            }

            $classes = 'nav-item';
            $attrs = '';

            if ($key === $activePage) {
                $classes .= ' active';
            }

            if ($key === 'appointment' && $activePage !== 'appointment') {
                $classes .= ' guard-appointment-link';
                $attrs .= ' id="sidebarAppointmentLink"';
                $attrs .= ' data-has-existing-appointment="' . ($hasExistingAppointment ? '1' : '0') . '"';
                $attrs .= ' data-allow-upcoming-view="0"';
            }

            echo '<a href="' . htmlspecialchars($link['href']) . '" class="' . $classes . '"' . $attrs . '>';
            echo '<i class="' . htmlspecialchars($link['icon']) . '"></i>';
            echo '<span>' . htmlspecialchars($link['label']) . '</span>';
            echo '</a>';
        }

        echo '</div>';
        echo '</aside>';
    }
}

if (!function_exists('dh_render_top_actions')) {
    function dh_render_top_actions(string $profileImagePath, string $notificationVariant = 'box', string $wrapperClass = 'top-icons'): void
    {
        echo '<div class="' . htmlspecialchars($wrapperClass) . '">';
        echo '<div class="notification-wrapper">';
        echo '<button class="icon-btn" type="button" id="notificationBtn">';
        echo '<i class="fa-solid fa-bell"></i>';
        echo '</button>';

        if ($notificationVariant === 'popup') {
            echo '<div class="notification-popup" id="notificationPopup">';
            echo '<p>No notification yet</p>';
            echo '</div>';
        } else {
            echo '<div class="notification-box hidden" id="notificationBox">';
            echo '<h4>Notifications</h4>';
            echo '<div class="notification-empty">No notification yet</div>';
            echo '</div>';
        }

        echo '</div>';

        echo '<div class="profile-dropdown">';
        echo '<button type="button" class="profile-btn" id="profileToggle">';
        echo '<img src="' . htmlspecialchars($profileImagePath) . '" class="top-profile-img" alt="Profile">';
        echo '</button>';
        echo '<div class="profile-menu hidden" id="profileMenu">';
        echo '<a href="profile_customer.php">Profile</a>';
        echo '<a href="policies_customer.php">Policies</a>';
        echo '<a href="logout.php">Logout</a>';
        echo '</div>';
        echo '</div>';

        echo '</div>';
    }
}
