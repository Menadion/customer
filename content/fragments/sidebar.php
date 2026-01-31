<div class="sidebar d-flex flex-column align-items-center pt-3">
    <a href="<?= ROOT_URL ?>content/pages/homePage.php" class="sidebar-link <?= $currentPage == 'homePage.php' ? 'active' : '' ?> text-decoration-none mb-1 text-center">
        <div class="sb-btn">
            <div class="sb-icon-cont">
                <img src="<?= ROOT_URL ?>/assets/whiteHome.svg" class="sb-icon sb-white">
                <img src="<?= ROOT_URL ?>/assets/darkHome.svg" class="sb-icon sb-dark">
            </div>
        </div>
        <div class="sidebar-label text-light mt-1">Home</div>
    </a>

    <a href="<?= ROOT_URL ?>content/pages/appointmentPage.php" class="sidebar-link <?= $currentPage == 'appointmentPage.php' ? 'active' : '' ?> text-decoration-none mb-1 text-center">
        <div class="sb-btn">
            <div class="sb-icon-cont">
                <img src="<?= ROOT_URL ?>/assets/whiteAppointment.svg" class="sb-icon sb-white">
                <img src="<?= ROOT_URL ?>/assets/darkAppointment.svg" class="sb-icon sb-dark">
            </div>
        </div>
        <div class="sidebar-label text-light mt-1" style="font-size: 0.66rem;">Appointment</div>
    </a>
    
    <a href="<?= ROOT_URL ?>content/pages/productPage.php" class="sidebar-link <?= $currentPage == 'productPage.php' ? 'active' : '' ?> text-decoration-none mb-1 text-center">
        <div class="sb-btn">
            <div class="sb-icon-cont">
                <img src="<?= ROOT_URL ?>/assets/whiteProduct.svg" class="sb-icon sb-white">
                <img src="<?= ROOT_URL ?>/assets/darkProduct.svg" class="sb-icon sb-dark">
            </div>
        </div>
        <div class="sidebar-label text-light mt-1">Product</div>
    </a>

    <a href="<?= ROOT_URL ?>content/pages/servicesPage.php" class="sidebar-link <?= $currentPage == 'servicesPage.php' ? 'active' : '' ?> text-decoration-none mb-1 text-center">
        <div class="sb-btn">
            <div class="sb-icon-cont">
                <img src="<?= ROOT_URL ?>/assets/whiteService.svg" class="sb-icon sb-white">
                <img src="<?= ROOT_URL ?>/assets/darkService.svg" class="sb-icon sb-dark">
            </div>
        </div>
        <div class="sidebar-label text-light mt-1">Services</div>
    </a>

    <a href="<?= ROOT_URL ?>content/pages/historyPage.php" class="sidebar-link <?= $currentPage == 'historyPage.php' ? 'active' : '' ?> text-decoration-none mb-1 text-center">
        <div class="sb-btn">
            <div class="sb-icon-cont">
                <img src="<?= ROOT_URL ?>/assets/whiteHistory.svg" class="sb-icon sb-white">
                <img src="<?= ROOT_URL ?>/assets/darkHistory.svg" class="sb-icon sb-dark">
            </div>
        </div>
        <div class="sidebar-label text-light mt-1">History</div>
    </a>
    <div class="mt-auto pb-3">
        <a href="<?= ROOT_URL ?>index.php" class="sidebar-link text-decoration-none text-center">
            <div class="sb-btn">
                <div class="sb-icon-cont">
                    <img src="<?= ROOT_URL ?>/assets/whiteLogout.svg" class="sb-icon sb-white">
                    <img src="<?= ROOT_URL ?>/assets/darkLogout.svg" class="sb-icon sb-dark">
                </div>
            </div>
            <div class="sidebar-label text-light mt-1">Logout</div>
        </a>
    </div>
</div>