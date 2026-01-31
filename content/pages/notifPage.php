<!DOCTYPE html>
<html lang="en">
    <?php include "../head.php" ?>
    <body class="m-0 vh-100 overflow-hidden">
        <div class="d-flex h-100">
            <?php include "../fragments/sidebar.php" ?>
            <div class="flex-grow-1 d-flex flex-column">
                <?php $pageHeader = 'NOTIFICATIONS'; include "../fragments/header.php" ?>

                <?php include '../fragments/notification.php' ?>
            </div>
        </div>
    </body>
</html>