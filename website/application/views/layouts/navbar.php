        <!-- Header -->
        <header id="header" class="header-default border-bottom">
            <div class="container">
                <div class="row wrapper-header align-items-center">
                    <div class="col-md-4 col-3 d-xl-none">
                        <a href="#mobileMenu" class="mobile-menu" data-bs-toggle="offcanvas" aria-controls="mobileMenu">
                            <i class="fa-solid fa-bars fs-4"></i>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="<?= site_url('home'); ?>" class="logo-header">
                            <img src="<?= base_url('assets/images/logo/logo.svg'); ?>" alt="Modave" class="logo" style="max-height: 40px;">
                        </a>
                    </div>
                    <div class="col-xl-6 d-none d-xl-block">
                        <nav class="box-navigation text-center">
                            <ul class="box-nav-ul d-flex align-items-center justify-content-center">
                                <li class="menu-item <?= ($active_page === 'home') ? 'active' : ''; ?>">
                                    <a href="<?= site_url('home'); ?>" class="item-link">Home</a>
                                </li>
                                <li class="menu-item <?= ($active_page === 'shop') ? 'active' : ''; ?>">
                                    <a href="<?= site_url('shop'); ?>" class="item-link">Shop</a>
                                </li>
                                <li class="menu-item has-item">
                                    <a href="javascript:void(0);" class="item-link">Categories <i class="fa-solid fa-chevron-down ms-1" style="font-size: 11px;"></i></a>
                                    <div class="sub-menu">
                                        <ul class="menu-list">
                                            <?php if (!empty($category_tree)): ?>
                                                <?php foreach ($category_tree as $root_c): ?>
                                                    <li class="mb-2">
                                                        <a href="<?= site_url('shop/' . $root_c['slug']); ?>" class="menu-link-text fw-bold">
                                                            <?= html_escape($root_c['name']); ?>
                                                        </a>
                                                        <?php if (!empty($root_c['children'])): ?>
                                                            <ul class="list-unstyled ms-3 my-1">
                                                                <?php foreach ($root_c['children'] as $ch1): ?>
                                                                    <li>
                                                                        <a href="<?= site_url('shop/' . $ch1['slug']); ?>" class="text-secondary text-decoration-none small py-1 d-block">
                                                                            &bull; <?= html_escape($ch1['name']); ?>
                                                                        </a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php elseif (!empty($nav_categories)): ?>
                                                <?php foreach ($nav_categories as $cat): ?>
                                                    <li>
                                                        <a href="<?= site_url('shop/' . $cat['slug']); ?>" class="menu-link-text">
                                                            <?= html_escape($cat['name']); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-item <?= ($active_page === 'about') ? 'active' : ''; ?>">
                                    <a href="<?= site_url('about'); ?>" class="item-link">About Us</a>
                                </li>
                                <li class="menu-item <?= ($active_page === 'contact') ? 'active' : ''; ?>">
                                    <a href="<?= site_url('contact'); ?>" class="item-link">Contact</a>
                                </li>
                                <li class="menu-item <?= ($active_page === 'faq') ? 'active' : ''; ?>">
                                    <a href="<?= site_url('faq'); ?>" class="item-link">FAQs</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-xl-3 col-md-4 col-3">
                        <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
                            <!-- Search Icon -->
                            <li class="nav-search">
                                <a href="#search" data-bs-toggle="modal" class="nav-icon-item" title="Search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>
                            </li>

                            <!-- Account / User Icon -->
                            <li class="nav-account dropdown">
                                <?php if ($this->is_logged_in()): ?>
                                    <a href="javascript:void(0);" class="nav-icon-item" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li class="px-3 py-2 border-bottom">
                                            <strong><?= html_escape($current_user['first_name'] . ' ' . $current_user['last_name']); ?></strong><br>
                                            <small class="text-muted"><?= html_escape($current_user['email']); ?></small>
                                        </li>
                                        <li><a class="dropdown-item py-2" href="<?= site_url('account/profile'); ?>"><i class="fa-solid fa-user me-2"></i>My Profile</a></li>
                                        <li><a class="dropdown-item py-2" href="<?= site_url('account/orders'); ?>"><i class="fa-solid fa-box-archive me-2"></i>Orders</a></li>
                                        <li><a class="dropdown-item py-2" href="<?= site_url('account/address'); ?>"><i class="fa-solid fa-location-dot me-2"></i>Saved Address</a></li>
                                        <li><a class="dropdown-item py-2" href="<?= site_url('wishlist'); ?>"><i class="fa-solid fa-heart me-2"></i>Wishlist</a></li>
                                        <li><a class="dropdown-item py-2" href="<?= site_url('account/notifications'); ?>"><i class="fa-solid fa-bell me-2"></i>Notification</a></li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li><a class="dropdown-item py-2 text-danger" href="<?= site_url('logout'); ?>"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</a></li>
                                    </ul>
                                <?php else: ?>
                                    <a href="<?= site_url('login'); ?>" class="nav-icon-item" title="Login / Register">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                <?php endif; ?>
                            </li>

                            <!-- Compare Icon -->
                            <li class="nav-compare">
                                <a href="<?= site_url('compare'); ?>" class="nav-icon-item" title="Compare Products">
                                    <i class="fa-solid fa-code-compare"></i>
                                </a>
                            </li>

                            <!-- Wishlist Icon -->
                            <li class="nav-wishlist">
                                <a href="<?= site_url('wishlist'); ?>" class="nav-icon-item" title="Wishlist">
                                    <i class="fa-solid fa-heart"></i>
                                </a>
                            </li>

                            <!-- Shopping Cart Icon -->
                            <li class="nav-cart">
                                <a href="<?= site_url('cart'); ?>" class="nav-icon-item position-relative" title="Cart">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    <span class="count-box count-cart bg-danger" id="cart-counter"><?= $cart_count; ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- /Header -->

        <!-- Flash Messages -->
        <div class="container mt-3">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check me-2"></i> <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-xmark me-2"></i> <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
