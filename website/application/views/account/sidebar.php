                    <div class="wrap-sidebar-account">
                        <div class="sidebar-account">
                            <div class="account-avatar text-center">
                                <div class="image mb-2">
                                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 75px; height: 75px; font-size: 28px; font-weight: bold;">
                                        <?= strtoupper(substr($user['first_name'] ?? 'U', 0, 1) . substr($user['last_name'] ?? '', 0, 1)); ?>
                                    </div>
                                </div>
                                <h6 class="mb-1 fw-bold"><?= html_escape(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')); ?></h6>
                                <div class="body-text-1 text-muted small"><?= html_escape($user['email'] ?? ''); ?></div>
                            </div>
                            <ul class="my-account-nav list-unstyled mt-4">
                                <li>
                                    <a href="<?= site_url('account/profile'); ?>" class="my-account-nav-item <?= ($active_account_tab === 'profile') ? 'active' : ''; ?>">
                                        <i class="fa-solid fa-user me-2 fs-5"></i>
                                        <span>My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('account/orders'); ?>" class="my-account-nav-item <?= ($active_account_tab === 'orders') ? 'active' : ''; ?>">
                                        <i class="fa-solid fa-box-archive me-2 fs-5"></i>
                                        <span>Orders</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('account/returns'); ?>" class="my-account-nav-item <?= ($active_account_tab === 'returns') ? 'active' : ''; ?>">
                                        <i class="fa-solid fa-rotate-left me-2 fs-5"></i>
                                        <span>Returns & Refunds</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('account/address'); ?>" class="my-account-nav-item <?= ($active_account_tab === 'address') ? 'active' : ''; ?>">
                                        <i class="fa-solid fa-location-dot me-2 fs-5"></i>
                                        <span>Saved Address</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('wishlist'); ?>" class="my-account-nav-item <?= ($active_account_tab === 'wishlist') ? 'active' : ''; ?>">
                                        <i class="fa-solid fa-heart me-2 fs-5"></i>
                                        <span>Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('account/notifications'); ?>" class="my-account-nav-item <?= ($active_account_tab === 'notifications') ? 'active' : ''; ?>">
                                        <i class="fa-solid fa-bell me-2 fs-5"></i>
                                        <span>Notification</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url('logout'); ?>" class="my-account-nav-item text-danger">
                                        <i class="fa-solid fa-arrow-right-from-bracket me-2 fs-5 text-danger"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
