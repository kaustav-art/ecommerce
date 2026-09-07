        <!-- Top Bar-->
        <div class="tf-topbar bg-main py-1">
            <div class="container">
                <div class="tf-topbar_wrap d-flex align-items-center justify-content-center justify-content-xl-between">
                    <ul class="topbar-left d-none d-md-flex align-items-center gap-3">
                        <li><a class="text-caption-1 text-white" href="tel:<?= html_escape($store_settings['site_phone'] ?? ''); ?>"><i class="fa-solid fa-phone me-1 small"></i> <?= html_escape($store_settings['site_phone'] ?? '+1 800 555-0199'); ?></a></li>
                        <li><a class="text-caption-1 text-white" href="mailto:<?= html_escape($store_settings['site_email'] ?? ''); ?>"><i class="fa-solid fa-envelope me-1 small"></i> <?= html_escape($store_settings['site_email'] ?? 'support@modave.com'); ?></a></li>
                        <li><a class="text-caption-1 text-white" href="<?= site_url('order/track'); ?>"><i class="fa-solid fa-truck-fast me-1 small"></i> Track Order</a></li>
                    </ul>
                    <div class="topbar-right d-flex align-items-center gap-3">
                        <span class="text-caption-1 text-white-50">Free shipping on orders over $150</span>
                        <a href="<?= base_url('../admin'); ?>" target="_blank" class="badge bg-warning text-dark py-1 px-2 text-decoration-none">
                            <i class="fa-solid fa-user-shield me-1"></i> Admin Portal
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Top Bar -->
