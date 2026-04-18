<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function setFlashMessage($message, $color = 'red') {
    $_SESSION['flash_message'] = (string)$message;
    $_SESSION['flash_color'] = (string)$color;
}

function popFlashMessage() {
    if (!isset($_SESSION['flash_message'])) {
        return null;
    }

    $flash = [
        'message' => $_SESSION['flash_message'],
        'color' => $_SESSION['flash_color'] ?? 'red'
    ];

    unset($_SESSION['flash_message'], $_SESSION['flash_color']);
    return $flash;
}

?>
