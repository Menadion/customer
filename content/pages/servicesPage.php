<!DOCTYPE html>
<html lang="en">
    <?php include "../head.php" ?>
    <body class="m-0 vh-100 overflow-hidden">
        <div class="d-flex h-100">
            <?php $currentPage = "servicesPage.php";  include "../fragments/sidebar.php" ?>
            <div class="flex-grow-1 d-flex flex-column">
                <?php $icon = 1; $pageHeader = 'Service Catalogue'; include "../fragments/header.php" ?>
                
                <?php include '../fragments/services.php' ?>
            </div>
        </div>

        <script src="<?= ROOT_URL ?>javascript/services.js" defer></script>
    </body>
</html>