<?php
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/customer/');
    define('ROOT_URL', '/customer/');
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.H Azada Tire Supply</title>

    <link rel="icon" class="Icon" href="<?= ROOT_URL ?>assets\icon1.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Absolute file path inside array -->
    <?php
        $libs = [
            'libs/bootstrap/js/bootstrap.bundle.min.js',
            'libs/jquery/jquery-3.7.1.min.js'
        ];

        $styles = [
            'css/base.css',
            'css/pageSpecific/sidebar.css',
            'css/home.css',
            'css/pageSpecific/login.css',
            'css/pageSpecific/content.css',
            'css/pageSpecific/summary.css',
            'css/pageSpecific/profile.css',
            'css/pageSpecific/inventory.css',
            'css/pageSpecific/appointment.css',
            'css/pageSpecific/services.css',
            'css/pageSpecific/notification.css',
            'css/pageSpecific/history.css',
            'libs/bootstrap/css/bootstrap.min.css'
        ];

        include ROOT_PATH . "config.php";

        loadFiles($libs, 'lib');
        loadFiles($styles, 'css');
    ?>
</head>