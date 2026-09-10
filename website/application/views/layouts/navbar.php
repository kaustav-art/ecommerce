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
                            <?php
                              $web_logo = !empty($store_settings['site_logo'])
                                ? base_url('assets/images/logo/' . $store_settings['site_logo'])
                                : base_url('assets/images/logo/logo.webp');
                            ?>
                            <img src="<?= $web_logo; ?>" alt="<?= html_escape($site_name ?? ($store_settings['site_name'] ?? 'Store')); ?>" class="logo" style="max-height: 44px; width: auto; object-fit: contain;" onerror="this.src='<?= base_url('assets/images/logo/logo.webp'); ?>'">
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
                                <li class="menu-item has-item category-mega-menu-item">
                                    <a href="<?= site_url('shop'); ?>" class="item-link">Categories <i class="fa-solid fa-chevron-down ms-1" style="font-size: 11px;"></i></a>
                                    
                                    <!-- Category Flyout Mega Menu Dropdown (Structured like category.PNG) -->
                                    <div class="category-flyout-wrapper shadow-lg">
                                        <!-- Left Sidebar: Main Categories (Top to Bottom) -->
                                        <ul class="cat-flyout-sidebar">
                                            <?php 
                                            $default_active_slug = 'phones-accessories';
                                            $slugs_present = !empty($category_tree) ? array_column($category_tree, 'slug') : [];
                                            if (!in_array($default_active_slug, $slugs_present) && !empty($slugs_present)) {
                                                $default_active_slug = $slugs_present[0];
                                            }

                                            if (!empty($category_tree)): 
                                                foreach ($category_tree as $root_c): 
                                                    $is_active = ($root_c['slug'] === $default_active_slug);
                                                    $cat_img = !empty($root_c['image']) 
                                                        ? base_url('assets/images/' . $root_c['image']) 
                                                        : base_url('assets/images/collections/collection-circle/cls-circle1.jpg');
                                            ?>
                                                <li class="cat-sidebar-item <?= $is_active ? 'active' : ''; ?>" data-cat-id="<?= $root_c['id']; ?>">
                                                    <a href="<?= site_url('shop/' . $root_c['slug']); ?>" class="cat-sidebar-link">
                                                        <span class="cat-thumb">
                                                            <img src="<?= $cat_img; ?>" alt="<?= html_escape($root_c['name']); ?>" class="cat-thumb-img" onerror="this.src='<?= base_url('assets/images/collections/collection-circle/cls-circle1.jpg'); ?>'">
                                                        </span>
                                                        <span class="cat-name"><?= html_escape($root_c['name']); ?></span>
                                                        <i class="fa-solid fa-chevron-right cat-arrow"></i>
                                                    </a>
                                                </li>
                                            <?php 
                                                endforeach; 
                                            endif; 
                                            ?>
                                        </ul>

                                        <!-- Right Content Area: Subcategories Grid for Active Category -->
                                        <div class="cat-flyout-content">
                                            <!-- Top Header Bar with Tags (as seen in category.PNG) -->
                                            <div class="cat-topbar-nav">
                                                <div class="ms-auto">
                                                    <a href="<?= site_url('shop'); ?>" class="text-decoration-none text-danger fw-bold small">
                                                        View All Categories <i class="fa-solid fa-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Subcategory Panels for each main category -->
                                            <div class="cat-sub-panels">
                                                <?php 
                                                if (!empty($category_tree)): 
                                                    foreach ($category_tree as $root_c): 
                                                        $is_active = ($root_c['slug'] === $default_active_slug);
                                                        $sub_children = $root_c['children'] ?? [];
                                                        $total_subs = count($sub_children);

                                                        // Organize into 3 columns
                                                        $cols = [[], [], []];
                                                        if ($total_subs > 0) {
                                                            if ($total_subs == 6) {
                                                                // Exact match to category.PNG: 2 groups per column
                                                                $cols[0] = [$sub_children[0], $sub_children[1]];
                                                                $cols[1] = [$sub_children[2], $sub_children[3]];
                                                                $cols[2] = [$sub_children[4], $sub_children[5]];
                                                            } else {
                                                                $per_col = (int) ceil($total_subs / 3);
                                                                $chunked = array_chunk($sub_children, $per_col);
                                                                $cols[0] = $chunked[0] ?? [];
                                                                $cols[1] = $chunked[1] ?? [];
                                                                $cols[2] = $chunked[2] ?? [];
                                                            }
                                                        }
                                                ?>
                                                    <div class="cat-panel <?= $is_active ? 'active' : ''; ?>" id="cat-panel-<?= $root_c['id']; ?>">
                                                        <?php if ($total_subs > 0): ?>
                                                            <div class="cat-grid-3col">
                                                                <?php foreach ($cols as $col_items): ?>
                                                                    <div class="cat-col">
                                                                        <?php foreach ($col_items as $sub): ?>
                                                                            <div class="cat-group">
                                                                                <a href="<?= site_url('shop/' . $sub['slug']); ?>" class="cat-group-heading">
                                                                                    <?= html_escape($sub['name']); ?>
                                                                                </a>
                                                                                <?php if (!empty($sub['children'])): ?>
                                                                                    <ul class="cat-children-list">
                                                                                        <?php foreach ($sub['children'] as $child): ?>
                                                                                            <li class="cat-child-item">
                                                                                                <a href="<?= site_url('shop/' . $child['slug']); ?>" class="cat-child-link">
                                                                                                    <?= html_escape($child['name']); ?>
                                                                                                </a>
                                                                                            </li>
                                                                                        <?php endforeach; ?>
                                                                                    </ul>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="text-center py-5 text-muted">
                                                                <div class="mb-3">
                                                                    <img src="<?= !empty($root_c['image']) ? base_url('assets/images/' . $root_c['image']) : base_url('assets/images/collections/collection-circle/cls-circle1.jpg'); ?>" alt="<?= html_escape($root_c['name']); ?>" style="width: 64px; height: 64px; object-fit: cover; border-radius: 50%; border: 2px solid #f05a5b;" onerror="this.src='<?= base_url('assets/images/collections/collection-circle/cls-circle1.jpg'); ?>'">
                                                                </div>
                                                                <h5 class="fw-bold text-dark mb-2"><?= html_escape($root_c['name']); ?></h5>
                                                                <p class="small text-muted mb-4">Discover the best products and latest collections in <?= html_escape($root_c['name']); ?>.</p>
                                                                <a href="<?= site_url('shop/' . $root_c['slug']); ?>" class="btn btn-sm btn-outline-danger px-4 rounded-pill">
                                                                    Explore Collection <i class="fa-solid fa-arrow-right ms-1"></i>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php 
                                                    endforeach; 
                                                endif; 
                                                ?>
                                            </div>
                                        </div>
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
                            <li class="nav-account dropdown position-relative">
                                <?php if ($this->is_logged_in()): 
                                    $u_name = trim(($current_user['first_name'] ?? '') . ' ' . ($current_user['last_name'] ?? ''));
                                    if (empty($u_name)) $u_name = 'My Account';
                                    $u_email = $current_user['email'] ?? '';
                                    $u_avatar = (!empty($current_user['avatar']) && $current_user['avatar'] !== 'default-user.png' && file_exists(FCPATH . $current_user['avatar'])) ? base_url($current_user['avatar']) : null;
                                ?>
                                    <a href="<?= site_url('account/profile'); ?>" class="nav-icon-item" data-bs-toggle="dropdown" aria-expanded="false" title="My Account">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-0 after-login-drawer-menu" style="min-width: 275px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.12) !important;">
                                        <!-- Profile Picture Icon on Side of Name and Email -->
                                        <li class="p-3 border-bottom rounded-top-2" style="background-color: #f8f9fa;">
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- Profile Picture Icon -->
                                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0 shadow-sm overflow-hidden" style="width: 46px; height: 46px; background: linear-gradient(135deg, #2874f0, #1b52b3); font-size: 20px;">
                                                    <?php if (!empty($u_avatar)): ?>
                                                        <img src="<?= $u_avatar; ?>" alt="<?= html_escape($u_name); ?>" class="w-100 h-100 object-fit-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                                        <i class="fa-solid fa-user d-none"></i>
                                                    <?php else: ?>
                                                        <i class="fa-solid fa-user"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="overflow-hidden" style="min-width: 0;">
                                                    <div class="text-muted text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; font-weight: 600;">Welcome</div>
                                                    <div class="fw-bold text-dark text-truncate" style="font-size: 15px;" title="<?= html_escape($u_name); ?>">
                                                        <?= html_escape($u_name); ?>
                                                    </div>
                                                    <div class="text-secondary small text-truncate" style="font-size: 12px;" title="<?= html_escape($u_email); ?>">
                                                        <?= html_escape($u_email); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <div class="py-2">
                                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center" href="<?= site_url('account/profile'); ?>"><i class="fa-regular fa-user text-primary me-3" style="width: 16px;"></i>My Profile</a></li>
                                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center" href="<?= site_url('account/orders'); ?>"><i class="fa-solid fa-box-archive text-primary me-3" style="width: 16px;"></i>Orders</a></li>
                                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center" href="<?= site_url('account/address'); ?>"><i class="fa-solid fa-location-dot text-primary me-3" style="width: 16px;"></i>Saved Address</a></li>
                                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center" href="<?= site_url('wishlist'); ?>"><i class="fa-regular fa-heart text-primary me-3" style="width: 16px;"></i>Wishlist</a></li>
                                            <li><a class="dropdown-item py-2 px-3 d-flex align-items-center" href="<?= site_url('account/notifications'); ?>"><i class="fa-regular fa-bell text-primary me-3" style="width: 16px;"></i>Notification</a></li>
                                            <li><hr class="dropdown-divider my-2" style="border-color: #f0f0f0;"></li>
                                            <li><a class="dropdown-item py-2 px-3 text-danger d-flex align-items-center" href="<?= site_url('logout'); ?>"><i class="fa-solid fa-arrow-right-from-bracket me-3" style="width: 16px;"></i>Logout</a></li>
                                        </div>
                                    </ul>
                                <?php else: ?>
                                    <a href="#loginModal" data-bs-toggle="modal" class="nav-icon-item" title="Login / Register">
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
                                <a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item position-relative" title="Cart">
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

        <!-- Flash Messages (Only on pages that do not have their own contextual message container) -->
        <?php if (!isset($active_page) || !in_array($active_page, ['account', 'cart', 'checkout'])): ?>
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
        <?php endif; ?>

        <style>
        /* Category Flyout Mega Menu Styles (Matching category.PNG) */
        #header .container {
            position: relative !important;
        }

        .box-nav-ul .category-mega-menu-item {
            position: static !important;
        }

        .category-flyout-wrapper {
            position: absolute;
            top: 100%;
            left: 15px;
            right: 15px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 16px 45px rgba(0, 0, 0, 0.14);
            border: 1px solid #e7e7e7;
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(10px);
            transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s;
            display: flex;
            min-height: 520px;
            max-height: 580px;
            overflow: hidden;
            text-align: left;
        }

        .category-mega-menu-item:hover .category-flyout-wrapper {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0);
        }

        /* Left Sidebar (Main categories top to bottom) */
        .cat-flyout-sidebar {
            width: 270px;
            min-width: 270px;
            background: #fdfdfd;
            border-right: 1px solid #eeeeee;
            overflow-y: auto;
            padding: 10px 0;
            margin: 0;
            list-style: none;
        }

        .cat-flyout-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .cat-flyout-sidebar::-webkit-scrollbar-thumb {
            background: #e2e2e2;
            border-radius: 4px;
        }

        .cat-sidebar-item {
            position: relative;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
        }

        .cat-sidebar-link {
            display: flex;
            align-items: center;
            padding: 10px 18px 10px 16px;
            color: #3b3b3b;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .cat-sidebar-link .cat-thumb {
            width: 24px;
            height: 24px;
            min-width: 24px;
            border-radius: 50%;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 11px;
            background: #f1f1f1;
            border: 1px solid #e9e9e9;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }

        .cat-sidebar-link .cat-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .cat-sidebar-link .cat-name {
            flex-grow: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cat-sidebar-link .cat-arrow {
            font-size: 10px;
            color: #c0c0c0;
            opacity: 0;
            transform: translateX(-4px);
            transition: all 0.15s ease;
        }

        /* Active & Hover state for sidebar item */
        .cat-sidebar-item:hover,
        .cat-sidebar-item.active {
            background: #ffffff;
            border-left-color: #f05a5b;
        }

        .cat-sidebar-item:hover .cat-sidebar-link,
        .cat-sidebar-item.active .cat-sidebar-link {
            color: #f05a5b;
            font-weight: 600;
        }

        .cat-sidebar-item:hover .cat-thumb,
        .cat-sidebar-item.active .cat-thumb {
            border-color: #f05a5b;
            box-shadow: 0 0 0 1px #f05a5b;
        }

        .cat-sidebar-item:hover .cat-arrow,
        .cat-sidebar-item.active .cat-arrow {
            opacity: 1;
            color: #f05a5b;
            transform: translateX(0);
        }

        /* Right Content Area */
        .cat-flyout-content {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top bar with quick links */
        .cat-topbar-nav {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 12px 30px;
            border-bottom: 1px solid #f0f0f0;
            background: #ffffff;
            font-size: 13.5px;
        }

        .cat-topbar-link {
            color: #333333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .cat-topbar-link:hover {
            color: #f05a5b;
        }

        /* Subcategory Panels Container */
        .cat-sub-panels {
            flex: 1;
            overflow-y: auto;
            padding: 24px 32px;
        }

        .cat-sub-panels::-webkit-scrollbar {
            width: 6px;
        }
        .cat-sub-panels::-webkit-scrollbar-thumb {
            background: #e2e2e2;
            border-radius: 4px;
        }

        .cat-panel {
            display: none;
        }

        .cat-panel.active {
            display: block;
            animation: fadeInCatPanel 0.18s ease-in-out;
        }

        @keyframes fadeInCatPanel {
            from { opacity: 0.6; transform: translateY(3px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* 3-Column Subcategory Grid */
        .cat-grid-3col {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px 34px;
        }

        .cat-col {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        /* Group Block */
        .cat-group {
            margin-bottom: 4px;
        }

        .cat-group-heading {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            text-decoration: none;
            padding-bottom: 6px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eeeeee;
            letter-spacing: 0.2px;
            transition: color 0.15s;
        }

        .cat-group-heading:hover {
            color: #f05a5b;
        }

        .cat-children-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cat-child-item {
            margin-bottom: 5px;
        }

        .cat-child-link {
            display: inline-block;
            color: #555555;
            text-decoration: none;
            font-size: 13px;
            line-height: 1.6;
            transition: color 0.15s ease, transform 0.15s ease;
        }

        .cat-child-link:hover {
            color: #f05a5b;
            transform: translateX(3px);
        }

        /* After-Login User Icon Hover Drawer / Dropdown */
        @media (min-width: 992px) {
            .nav-account.dropdown {
                position: relative;
            }
            .nav-account.dropdown > .after-login-drawer-menu {
                display: block;
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transform: translateY(8px);
                transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
                top: 100%;
                right: 0;
                left: auto;
                margin-top: 5px;
            }
            /* Invisible bridge to prevent mouse-leave gap between icon and drawer */
            .nav-account.dropdown::after {
                content: '';
                position: absolute;
                bottom: -15px;
                left: 0;
                width: 100%;
                height: 20px;
                display: none;
            }
            .nav-account.dropdown:hover::after {
                display: block;
            }
            .nav-account.dropdown:hover > .after-login-drawer-menu,
            .nav-account.dropdown > .after-login-drawer-menu:hover,
            .nav-account.dropdown.show > .after-login-drawer-menu {
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                transform: translateY(0) !important;
            }
        }
        .after-login-drawer-menu .dropdown-item {
            font-size: 13.5px;
            font-weight: 500;
            color: #333;
            transition: background-color 0.15s, color 0.15s, padding-left 0.15s;
        }
        .after-login-drawer-menu .dropdown-item:hover {
            background-color: #f4f8ff;
            color: #2874f0;
            padding-left: 1.25rem !important;
        }
        .after-login-drawer-menu .dropdown-item.text-danger:hover {
            background-color: #fff5f5;
            color: #dc3545 !important;
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebarItems = document.querySelectorAll('.cat-sidebar-item');
            sidebarItems.forEach(function(item) {
                item.addEventListener('mouseenter', function() {
                    var catId = this.getAttribute('data-cat-id');
                    sidebarItems.forEach(function(el) { el.classList.remove('active'); });
                    this.classList.add('active');

                    var panels = document.querySelectorAll('.cat-panel');
                    panels.forEach(function(panel) { panel.classList.remove('active'); });

                    var target = document.getElementById('cat-panel-' + catId);
                    if (target) {
                        target.classList.add('active');
                    }
                });
            });

            // After-login user icon hover handler for desktop
            var navAccount = document.querySelector('.nav-account.dropdown');
            if (navAccount) {
                var menu = navAccount.querySelector('.after-login-drawer-menu');
                if (menu) {
                    var closeTimer;
                    var showDrawer = function() {
                        if (window.innerWidth >= 992) {
                            clearTimeout(closeTimer);
                            menu.style.opacity = '1';
                            menu.style.visibility = 'visible';
                            menu.style.pointerEvents = 'auto';
                            menu.style.transform = 'translateY(0)';
                        }
                    };
                    var hideDrawer = function() {
                        if (window.innerWidth >= 992) {
                            closeTimer = setTimeout(function() {
                                if (!navAccount.classList.contains('show')) {
                                    menu.style.opacity = '0';
                                    menu.style.visibility = 'hidden';
                                    menu.style.pointerEvents = 'none';
                                    menu.style.transform = 'translateY(8px)';
                                }
                            }, 150);
                        }
                    };
                    navAccount.addEventListener('mouseenter', showDrawer);
                    navAccount.addEventListener('mouseleave', hideDrawer);
                    menu.addEventListener('mouseenter', showDrawer);
                    menu.addEventListener('mouseleave', hideDrawer);
                }
            }
        });
        </script>

