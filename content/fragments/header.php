<div class="px-4 py-3 border-bottom bg-white d-flex align-items-center justify-content-between">
    <span class="fw-semibold fs-5 text-uppercase h5"><?= htmlspecialchars($pageHeader ?? 'Welcome') ?></span>

    <div class="d-flex align-items-center gap-3">
        <a href="<?= ROOT_URL ?>content/pages/notifPage.php"
        class="icon-btn d-inline-flex align-items-center justify-content-center position-relative">
            <img src="<?= ROOT_URL ?>assets/notifIcon.svg"
                alt="Notifications"
                class="icon-img">
        </a>

        <a href="<?= ROOT_URL ?>content/pages/profilePage.php"
        class="icon-btn d-inline-flex align-items-center justify-content-center">
            <img src="<?= ROOT_URL ?>assets/profPic.svg"
                alt="Profile"
                class="rounded-circle border icon-img"
                width="36"
                height="36"
                style="object-fit: cover;">
        </a>
    </div>
</div>
