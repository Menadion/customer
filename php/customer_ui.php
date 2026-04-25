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

if (!function_exists('dh_get_table_columns')) {
    function dh_get_table_columns(mysqli $conn, string $table): array
    {
        static $cache = [];

        if (isset($cache[$table])) {
            return $cache[$table];
        }

        $columns = [];
        $result = $conn->query("SHOW COLUMNS FROM `" . $conn->real_escape_string($table) . "`");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row['Field'])) {
                    $columns[] = (string)$row['Field'];
                }
            }
            $result->free();
        }

        $cache[$table] = $columns;
        return $columns;
    }
}

if (!function_exists('dh_first_existing_column')) {
    function dh_first_existing_column(array $columns, array $candidates): ?string
    {
        foreach ($candidates as $candidate) {
            if (in_array($candidate, $columns, true)) {
                return $candidate;
            }
        }

        return null;
    }
}

if (!function_exists('dh_ensure_notification_event_table')) {
    function dh_ensure_notification_event_table(mysqli $conn): void
    {
        static $ensured = false;
        if ($ensured) {
            return;
        }

        $sql = "
            CREATE TABLE IF NOT EXISTS customer_notification_events (
                event_id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                appt_id INT NOT NULL,
                event_key VARCHAR(120) NOT NULL,
                event_kind VARCHAR(40) NOT NULL,
                title VARCHAR(150) NOT NULL,
                message TEXT NOT NULL,
                reason VARCHAR(255) DEFAULT NULL,
                action_label VARCHAR(80) DEFAULT NULL,
                action_url VARCHAR(255) DEFAULT NULL,
                event_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY uq_customer_appt_event (customer_id, appt_id, event_key),
                KEY idx_customer_event_time (customer_id, event_time)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ";

        $conn->query($sql);
        $ensured = true;
    }
}

if (!function_exists('dh_store_notification_event')) {
    function dh_store_notification_event(
        mysqli $conn,
        int $customerId,
        int $apptId,
        string $eventKey,
        string $eventKind,
        string $title,
        string $message,
        string $reason = '',
        string $actionLabel = '',
        string $actionUrl = '',
        ?string $eventTime = null
    ): void {
        $sql = "
            INSERT INTO customer_notification_events
                (customer_id, appt_id, event_key, event_kind, title, message, reason, action_label, action_url, event_time)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, COALESCE(?, NOW()))
            ON DUPLICATE KEY UPDATE
                event_kind = VALUES(event_kind),
                title = VALUES(title),
                message = VALUES(message),
                reason = VALUES(reason),
                action_label = VALUES(action_label),
                action_url = VALUES(action_url)
        ";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return;
        }

        $safeReason = $reason !== '' ? $reason : null;
        $safeActionLabel = $actionLabel !== '' ? $actionLabel : null;
        $safeActionUrl = $actionUrl !== '' ? $actionUrl : null;
        $safeEventTime = ($eventTime !== null && $eventTime !== '' && $eventTime !== '0000-00-00 00:00:00') ? $eventTime : null;

        $stmt->bind_param(
            'iissssssss',
            $customerId,
            $apptId,
            $eventKey,
            $eventKind,
            $title,
            $message,
            $safeReason,
            $safeActionLabel,
            $safeActionUrl,
            $safeEventTime
        );
        $stmt->execute();
        $stmt->close();
    }
}

if (!function_exists('dh_get_customer_notifications')) {
    function dh_get_customer_notifications(mysqli $conn, ?int $customerId, int $limit = 30): array
    {
        if (empty($customerId)) {
            return [];
        }

        dh_ensure_notification_event_table($conn);
        $conn->query("DELETE FROM customer_notification_events WHERE event_time < NOW() - INTERVAL 90 DAY");

        $apptColumns = dh_get_table_columns($conn, 'appointments_tbl');
        if (empty($apptColumns)) {
            return [];
        }

        $apptIdCol = dh_first_existing_column($apptColumns, ['appt_id', 'app_id']);
        $apptStatusCol = dh_first_existing_column($apptColumns, ['appt_status', 'status']);

        if ($apptIdCol === null || $apptStatusCol === null) {
            return [];
        }

        $apptCreatedCol = dh_first_existing_column($apptColumns, ['created_at', 'updated_at']);
        $apptDateCol = dh_first_existing_column($apptColumns, ['appt_date']);
        $apptTimeCol = dh_first_existing_column($apptColumns, ['appt_time']);
        $apptReasonCol = dh_first_existing_column(
            $apptColumns,
            ['decline_reason', 'declined_reason', 'rejection_reason', 'cancel_reason', 'cancellation_reason', 'cashier_reason', 'remarks']
        );

        $select = [
            "a.`{$apptIdCol}` AS appt_id",
            "a.`{$apptStatusCol}` AS appt_status",
        ];

        $select[] = $apptCreatedCol !== null
            ? "a.`{$apptCreatedCol}` AS appt_created_at"
            : 'NULL AS appt_created_at';

        $select[] = $apptDateCol !== null
            ? "a.`{$apptDateCol}` AS appt_date"
            : 'NULL AS appt_date';

        $select[] = $apptTimeCol !== null
            ? "a.`{$apptTimeCol}` AS appt_time"
            : 'NULL AS appt_time';

        $select[] = $apptReasonCol !== null
            ? "a.`{$apptReasonCol}` AS appt_reason"
            : 'NULL AS appt_reason';

        $sql = "SELECT " . implode(', ', $select) . "\n                FROM appointments_tbl a\n                WHERE a.customer_id = ?\n                ORDER BY " . ($apptCreatedCol !== null ? "a.`{$apptCreatedCol}` DESC" : "a.`{$apptIdCol}` DESC") . "\n                LIMIT " . max(1, (int)$limit * 3);

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        $stmt->close();

        if (empty($appointments)) {
            return [];
        }

        $txnColumns = dh_get_table_columns($conn, 'transaction_tbl');
        $txnIdCol = dh_first_existing_column($txnColumns, ['transaction_id']);
        $txnApptRefCol = dh_first_existing_column($txnColumns, ['appt_id', 'app_id']);
        $txnCreatedCol = dh_first_existing_column($txnColumns, ['created_at']);

        $txnByAppt = [];

        if ($txnIdCol !== null && $txnApptRefCol !== null) {
            $txnSelect = [
                "t.`{$txnIdCol}` AS transaction_id",
                "t.`{$txnApptRefCol}` AS appt_ref_id",
            ];

            if ($txnCreatedCol !== null) {
                $txnSelect[] = "t.`{$txnCreatedCol}` AS txn_created_at";
            } else {
                $txnSelect[] = 'NULL AS txn_created_at';
            }

            $txnSql = "SELECT " . implode(', ', $txnSelect) . "\n                      FROM transaction_tbl t\n                      WHERE t.customer_id = ?\n                      ORDER BY " . ($txnCreatedCol !== null ? "t.`{$txnCreatedCol}` DESC" : "t.`{$txnIdCol}` DESC");

            $txnStmt = $conn->prepare($txnSql);
            if ($txnStmt) {
                $txnStmt->bind_param('i', $customerId);
                $txnStmt->execute();
                $txnResult = $txnStmt->get_result();

                while ($txnRow = $txnResult->fetch_assoc()) {
                    $refId = (int)($txnRow['appt_ref_id'] ?? 0);
                    if ($refId <= 0 || isset($txnByAppt[$refId])) {
                        continue;
                    }

                    $txnByAppt[$refId] = [
                        'transaction_id' => (int)$txnRow['transaction_id'],
                        'created_at' => (string)($txnRow['txn_created_at'] ?? ''),
                    ];
                }

                $txnStmt->close();
            }
        }

        $notifications = [];

        foreach ($appointments as $row) {
            $apptId = (int)($row['appt_id'] ?? 0);
            if ($apptId <= 0) {
                continue;
            }

            $statusRaw = trim((string)($row['appt_status'] ?? ''));
            $status = strtolower($statusRaw);
            $reason = trim((string)($row['appt_reason'] ?? ''));
            $transaction = $txnByAppt[$apptId] ?? null;
            $transactionId = is_array($transaction) ? (int)($transaction['transaction_id'] ?? 0) : 0;
            $transactionCreatedAt = is_array($transaction) ? trim((string)($transaction['created_at'] ?? '')) : '';

            $createdAt = trim((string)($row['appt_created_at'] ?? ''));
            $dateText = '';
            if ($createdAt !== '' && $createdAt !== '0000-00-00 00:00:00') {
                $ts = strtotime($createdAt);
                if ($ts !== false) {
                    $dateText = date('M j, Y g:i A', $ts);
                }
            }

            $item = [
                'kind' => 'info',
                'title' => 'Appointment update',
                'message' => 'Your appointment has been updated.',
                'reason' => '',
                'date_text' => $dateText,
                'action_label' => '',
                'action_url' => '',
            ];

            $isCompleted = $transactionId > 0
                || str_contains($status, 'complete')
                || str_contains($status, 'done')
                || str_contains($status, 'finished');

            // Always keep the original "booking sent / waiting" notification as the first event.
            dh_store_notification_event(
                $conn,
                (int)$customerId,
                $apptId,
                'waiting',
                'waiting',
                'Booking Sent',
                'Your booking request was sent. Please wait for approval.',
                '',
                'View Appointment',
                'appointment_customer.php?view=upcoming',
                $createdAt !== '' ? $createdAt : null
            );

            if ($isCompleted) {
                $item['kind'] = 'completed';
                $item['title'] = 'Appointment Completed';
                $item['message'] = 'Your appointment has been completed.';
                $item['action_label'] = 'View Transaction';
                $item['action_url'] = $transactionId > 0
                    ? 'transaction_history.php?open_txn=' . urlencode((string)$transactionId)
                    : 'transaction_history.php';

                dh_store_notification_event(
                    $conn,
                    (int)$customerId,
                    $apptId,
                    $transactionId > 0 ? ('completed_txn_' . $transactionId) : 'completed',
                    'completed',
                    $item['title'],
                    $item['message'],
                    '',
                    $item['action_label'],
                    $item['action_url'],
                    $transactionCreatedAt !== '' ? $transactionCreatedAt : null
                );
            } elseif (str_contains($status, 'declin') || str_contains($status, 'reject') || str_contains($status, 'cancel')) {
                $item['kind'] = 'declined';
                $item['title'] = 'Appointment Declined';
                $item['message'] = 'Your appointment was declined.';
                $item['reason'] = $reason !== '' ? $reason : 'No reason provided by the cashier.';

                dh_store_notification_event(
                    $conn,
                    (int)$customerId,
                    $apptId,
                    'declined',
                    'declined',
                    $item['title'],
                    $item['message'],
                    $item['reason'],
                    '',
                    '',
                    null
                );
            } elseif (str_contains($status, 'wait') || str_contains($status, 'pend')) {
                $item['kind'] = 'waiting';
                $item['title'] = 'Booking Sent';
                $item['message'] = 'Your booking request was sent. Please wait for approval.';
                $item['action_label'] = 'View Appointment';
                $item['action_url'] = 'appointment_customer.php?view=upcoming';
            } elseif (str_contains($status, 'approv') || str_contains($status, 'accept') || str_contains($status, 'confirm')) {
                $item['kind'] = 'approved';
                $item['title'] = 'Appointment Approved';
                $item['message'] = 'Your appointment has been approved.';
                $item['action_label'] = 'View Appointment';
                $item['action_url'] = 'appointment_customer.php?view=upcoming';

                dh_store_notification_event(
                    $conn,
                    (int)$customerId,
                    $apptId,
                    'approved',
                    'approved',
                    $item['title'],
                    $item['message'],
                    '',
                    $item['action_label'],
                    $item['action_url'],
                    null
                );
            }
        }

        $readSql = "
            SELECT event_kind, title, message, reason, action_label, action_url, event_time
            FROM customer_notification_events
            WHERE customer_id = ?
            ORDER BY event_time DESC, event_id DESC
            LIMIT ?
        ";
        $readStmt = $conn->prepare($readSql);
        if (!$readStmt) {
            return [];
        }

        $safeLimit = max(1, (int)$limit);
        $readStmt->bind_param('ii', $customerId, $safeLimit);
        $readStmt->execute();
        $readResult = $readStmt->get_result();

        while ($eventRow = $readResult->fetch_assoc()) {
            $eventTime = trim((string)($eventRow['event_time'] ?? ''));
            $formattedTime = '';
            if ($eventTime !== '' && $eventTime !== '0000-00-00 00:00:00') {
                $ts = strtotime($eventTime);
                if ($ts !== false) {
                    $formattedTime = date('M j, Y g:i A', $ts);
                }
            }

            $notifications[] = [
                'kind' => (string)($eventRow['event_kind'] ?? 'info'),
                'title' => (string)($eventRow['title'] ?? 'Notification'),
                'message' => (string)($eventRow['message'] ?? ''),
                'reason' => (string)($eventRow['reason'] ?? ''),
                'date_text' => $formattedTime,
                'action_label' => (string)($eventRow['action_label'] ?? ''),
                'action_url' => (string)($eventRow['action_url'] ?? ''),
            ];
        }
        $readStmt->close();

        return $notifications;
    }
}

if (!function_exists('dh_render_customer_sidebar')) {
    function dh_render_customer_sidebar(
        string $activePage,
        bool $hasExistingAppointment = false,
        string $menuClass = 'menu',
        string $profileImagePath = '',
        array $notifications = []
    ): void
    {
        $links = [
            'home' => ['href' => 'homepage_customer.php', 'label' => 'Homepage'],
            'appointment' => ['href' => 'appointment_customer.php', 'label' => 'Appointment'],
            'products' => ['href' => 'product_catalog.php', 'label' => 'Products'],
            'services' => ['href' => 'services_customer.php', 'label' => 'Services'],
            'history' => ['href' => 'transaction_history.php', 'label' => 'History'],
            'profile' => ['href' => 'profile_customer.php', 'label' => 'Profile'],
            'policies' => ['href' => 'policies_customer.php', 'label' => 'Policies'],
        ];

        echo '<aside class="sidebar customer-top-nav">';
        echo '<div class="customer-top-nav-inner">';
        echo '<div class="customer-top-nav-brand">D.H AZADA TIRE SUPPLY</div>';
        echo '<div class="' . htmlspecialchars($menuClass) . ' customer-top-nav-links">';

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
                $attrs .= ' data-has-existing-appointment="' . ($hasExistingAppointment ? '1' : '0') . '"';
                $attrs .= ' data-allow-upcoming-view="0"';
                $attrs .= ' id="sidebarAppointmentLink"';
            }

            echo '<a href="' . htmlspecialchars($link['href']) . '" class="' . $classes . '"' . $attrs . '>';
            echo '<span>' . htmlspecialchars($link['label']) . '</span>';
            echo '</a>';
        }

        echo '</div>';

        if ($profileImagePath !== '') {
            echo '<div class="customer-top-nav-actions">';
            echo '<div class="notification-wrapper">';
            echo '<button class="icon-btn" type="button" id="notificationBtn">';
            echo '<i class="fa-solid fa-bell"></i>';
            echo '</button>';
            echo '<div class="notification-box hidden" id="notificationBox">';
            echo '<h4>Notifications</h4>';

            if (empty($notifications)) {
                echo '<div class="notification-empty">No notification yet</div>';
            } else {
                echo '<div class="notification-list">';
                foreach ($notifications as $notification) {
                    $kind = trim((string)($notification['kind'] ?? 'info'));
                    $title = trim((string)($notification['title'] ?? 'Notification'));
                    $message = trim((string)($notification['message'] ?? ''));
                    $reason = trim((string)($notification['reason'] ?? ''));
                    $dateText = trim((string)($notification['date_text'] ?? ''));
                    $actionLabel = trim((string)($notification['action_label'] ?? ''));
                    $actionUrl = trim((string)($notification['action_url'] ?? ''));

                    echo '<div class="notification-item notification-' . htmlspecialchars($kind) . '">';
                    echo '<div class="notification-item-header">';
                    echo '<div class="notification-item-title">' . htmlspecialchars($title) . '</div>';
                    echo '<button type="button" class="notification-toggle-btn" aria-expanded="false" aria-label="Expand notification">';
                    echo '<i class="fa-solid fa-chevron-down"></i>';
                    echo '</button>';
                    echo '</div>';

                    echo '<div class="notification-item-details">';
                    if ($message !== '') {
                        echo '<div class="notification-item-message">' . htmlspecialchars($message) . '</div>';
                    }
                    if ($reason !== '') {
                        echo '<div class="notification-item-reason">Reason: ' . htmlspecialchars($reason) . '</div>';
                    }
                    if ($dateText !== '') {
                        echo '<div class="notification-item-time">' . htmlspecialchars($dateText) . '</div>';
                    }
                    if ($actionLabel !== '' && $actionUrl !== '') {
                        echo '<a class="notification-action-btn" href="' . htmlspecialchars($actionUrl) . '">'
                            . htmlspecialchars($actionLabel) . '</a>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            }

            echo '</div>';
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

        echo '</div>';
        echo '</aside>';
    }
}

if (!function_exists('dh_render_top_actions')) {
    function dh_render_top_actions(
        string $profileImagePath,
        string $notificationVariant = 'box',
        string $wrapperClass = 'top-icons',
        array $notifications = []
    ): void {
        echo '<div class="' . htmlspecialchars($wrapperClass) . '">';
        echo '<div class="notification-wrapper">';
        echo '<button class="icon-btn" type="button" id="notificationBtn">';
        echo '<i class="fa-solid fa-bell"></i>';
        echo '</button>';

        if ($notificationVariant === 'popup') {
            echo '<div class="notification-popup hidden" id="notificationPopup">';
        } else {
            echo '<div class="notification-box hidden" id="notificationBox">';
        }

        echo '<h4>Notifications</h4>';

        if (empty($notifications)) {
            echo '<div class="notification-empty">No notification yet</div>';
        } else {
            echo '<div class="notification-list">';
            foreach ($notifications as $notification) {
                $kind = trim((string)($notification['kind'] ?? 'info'));
                $title = trim((string)($notification['title'] ?? 'Notification'));
                $message = trim((string)($notification['message'] ?? ''));
                $reason = trim((string)($notification['reason'] ?? ''));
                $dateText = trim((string)($notification['date_text'] ?? ''));
                $actionLabel = trim((string)($notification['action_label'] ?? ''));
                $actionUrl = trim((string)($notification['action_url'] ?? ''));

                echo '<div class="notification-item notification-' . htmlspecialchars($kind) . '">';
                echo '<div class="notification-item-header">';
                echo '<div class="notification-item-title">' . htmlspecialchars($title) . '</div>';
                echo '<button type="button" class="notification-toggle-btn" aria-expanded="false" aria-label="Expand notification">';
                echo '<i class="fa-solid fa-chevron-down"></i>';
                echo '</button>';
                echo '</div>';

                echo '<div class="notification-item-details">';
                if ($message !== '') {
                    echo '<div class="notification-item-message">' . htmlspecialchars($message) . '</div>';
                }

                if ($reason !== '') {
                    echo '<div class="notification-item-reason">Reason: ' . htmlspecialchars($reason) . '</div>';
                }

                if ($dateText !== '') {
                    echo '<div class="notification-item-time">' . htmlspecialchars($dateText) . '</div>';
                }

                if ($actionLabel !== '' && $actionUrl !== '') {
                    echo '<a class="notification-action-btn" href="' . htmlspecialchars($actionUrl) . '">'
                        . htmlspecialchars($actionLabel) . '</a>';
                }
                echo '</div>';

                echo '</div>';
            }
            echo '</div>';
        }

        echo '</div>';
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
