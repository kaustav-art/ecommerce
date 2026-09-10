<?php
$current_tab = $active_account_tab ?? 'profile';
$display_name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
if (empty($display_name)) {
    $display_name = 'Valued Customer';
}
?>

<div class="fk-sidebar-wrapper">
    <!-- User Greeting Card -->
    <div class="card border rounded-1 p-3 mb-3 bg-white d-flex flex-row align-items-center gap-3 shadow-sm" style="border-color: #f0f0f0 !important;">
        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2874f0, #1b52b3); font-size: 20px; flex-shrink: 0;">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="overflow-hidden">
            <div class="text-muted" style="font-size: 12px;">Hello,</div>
            <div class="fw-bold text-dark text-truncate" style="font-size: 16px;" title="<?= html_escape($display_name); ?>">
                <?= html_escape($display_name); ?>
            </div>
        </div>
    </div>

    <!-- Navigation Menu Card -->
    <div class="card border rounded-1 bg-white overflow-hidden shadow-sm" style="border-color: #f0f0f0 !important;">
        <!-- MY ORDERS -->
        <a href="<?= site_url('account/orders'); ?>" class="fk-menu-group-header text-decoration-none d-flex align-items-center justify-content-between p-3 border-bottom <?= ($current_tab === 'orders') ? 'active' : ''; ?>">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-box-archive text-primary fs-5" style="width: 20px;"></i>
                <span class="fw-bold text-uppercase" style="font-size: 14px; letter-spacing: 0.3px;">MY ORDERS</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 12px;"></i>
        </a>

        <!-- ACCOUNT SETTINGS -->
        <div class="fk-nav-section border-bottom">
            <div class="fk-section-title d-flex align-items-center gap-3 px-3 pt-3 pb-2 text-muted fw-bold text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">
                <i class="fa-solid fa-user text-primary fs-6" style="width: 20px;"></i>
                <span>ACCOUNT SETTINGS</span>
            </div>
            <div class="fk-sub-links pb-2">
                <a href="<?= site_url('account/profile'); ?>" class="fk-sub-link <?= ($current_tab === 'profile') ? 'active' : ''; ?>">
                    Profile Information
                </a>
                <a href="<?= site_url('account/address'); ?>" class="fk-sub-link <?= ($current_tab === 'address') ? 'active' : ''; ?>">
                    Manage Addresses
                </a>
                <a href="<?= site_url('account/returns'); ?>" class="fk-sub-link <?= ($current_tab === 'returns') ? 'active' : ''; ?>">
                    Returns & Refunds
                </a>
            </div>
        </div>

        <!-- PAYMENTS -->
        <div class="fk-nav-section border-bottom">
            <div class="fk-section-title d-flex align-items-center gap-3 px-3 pt-3 pb-2 text-muted fw-bold text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">
                <i class="fa-solid fa-wallet text-primary fs-6" style="width: 20px;"></i>
                <span>PAYMENTS</span>
            </div>
            <div class="fk-sub-links pb-2">
                <a href="javascript:void(0);" class="fk-sub-link text-secondary" onclick="alert('Gift cards can be applied at checkout.');">
                    Gift Cards
                </a>
                <a href="javascript:void(0);" class="fk-sub-link text-secondary" onclick="alert('Saved payment options are securely tokenized at checkout.');">
                    Saved UPI
                </a>
                <a href="javascript:void(0);" class="fk-sub-link text-secondary" onclick="alert('Saved payment options are securely tokenized at checkout.');">
                    Saved Cards
                </a>
            </div>
        </div>

        <!-- MY STUFF -->
        <div class="fk-nav-section border-bottom">
            <div class="fk-section-title d-flex align-items-center gap-3 px-3 pt-3 pb-2 text-muted fw-bold text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">
                <i class="fa-solid fa-folder-open text-primary fs-6" style="width: 20px;"></i>
                <span>MY STUFF</span>
            </div>
            <div class="fk-sub-links pb-2">
                <a href="<?= site_url('account/notifications'); ?>" class="fk-sub-link <?= ($current_tab === 'notifications') ? 'active' : ''; ?>">
                    All Notifications
                </a>
                <a href="<?= site_url('wishlist'); ?>" class="fk-sub-link <?= ($current_tab === 'wishlist') ? 'active' : ''; ?>">
                    My Wishlist
                </a>
            </div>
        </div>

        <!-- LOGOUT -->
        <a href="<?= site_url('logout'); ?>" class="fk-menu-group-header text-decoration-none d-flex align-items-center gap-3 p-3 text-dark logout-link">
            <i class="fa-solid fa-power-off text-muted fs-5" style="width: 20px;"></i>
            <span class="fw-bold" style="font-size: 14px;">Logout</span>
        </a>
    </div>
</div>

<style>
.fk-menu-group-header {
    color: #212121;
    background-color: #fff;
    transition: all 0.15s ease-in-out;
}
.fk-menu-group-header:hover {
    background-color: #f9f9f9;
    color: #2874f0;
}
.fk-menu-group-header.active {
    background-color: #f5faff;
    color: #2874f0;
    border-left: 4px solid #2874f0;
}
.fk-sub-link {
    display: block;
    padding: 9px 20px 9px 52px;
    font-size: 14px;
    color: #212121;
    text-decoration: none;
    transition: all 0.15s ease-in-out;
}
.fk-sub-link:hover {
    color: #2874f0;
    background-color: #f9f9f9;
}
.fk-sub-link.active {
    color: #2874f0;
    font-weight: 600;
    background-color: #f5faff;
    border-left: 4px solid #2874f0;
    padding-left: 48px;
}
.logout-link:hover {
    color: #dc3545 !important;
    background-color: #fff5f5;
}
.logout-link:hover i {
    color: #dc3545 !important;
}
</style>
