        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="<?= site_url('dashboard'); ?>" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span class="text-primary">
                  <svg width="32" height="18" viewBox="0 0 38 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30.0944 2.22569C29.0511 0.444187 26.7508 -0.172113 24.9566 0.849138C23.1623 1.87039 22.5536 4.14247 23.5969 5.92397L30.5368 17.7743C31.5801 19.5558 33.8804 20.1721 35.6746 19.1509C37.4689 18.1296 38.0776 15.8575 37.0343 14.076L30.0944 2.22569Z" fill="currentColor" />
                    <path d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z" fill="currentColor" />
                  </svg>
                </span>
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2 fs-4">Modave Admin</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="icon-base ri ri-close-line d-block d-xl-none"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <?php if ($this->can('dashboard.view')): ?>
            <li class="menu-item <?= ($active_menu === 'dashboard') ? 'active' : ''; ?>">
              <a href="<?= site_url('dashboard'); ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-dashboard-line"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>
            <?php endif; ?>

            <!-- Catalog -->
            <?php if ($this->can('products.view') || $this->can('categories.manage') || $this->can('brands.manage')): ?>
            <li class="menu-header mt-3">
              <span class="menu-header-text">Catalog</span>
            </li>

            <li class="menu-item <?= ($active_menu === 'products') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-shopping-bag-3-line"></i>
                <div data-i18n="Catalog">Catalog</div>
              </a>
              <ul class="menu-sub">
                <?php if ($this->can('products.view')): ?>
                <li class="menu-item <?= ($active_submenu === 'products_list') ? 'active' : ''; ?>">
                  <a href="<?= site_url('products'); ?>" class="menu-link">
                    <div data-i18n="All Products">All Products</div>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ($this->can('products.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'products_add') ? 'active' : ''; ?>">
                  <a href="<?= site_url('products/add'); ?>" class="menu-link">
                    <div data-i18n="Add Product">Add Product</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'attributes') ? 'active' : ''; ?>">
                  <a href="<?= site_url('attributes'); ?>" class="menu-link">
                    <div data-i18n="Attributes & Values">Attributes & Values</div>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ($this->can('categories.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'categories') ? 'active' : ''; ?>">
                  <a href="<?= site_url('categories'); ?>" class="menu-link">
                    <div data-i18n="Categories">Categories</div>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ($this->can('brands.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'brands') ? 'active' : ''; ?>">
                  <a href="<?= site_url('brands'); ?>" class="menu-link">
                    <div data-i18n="Brands">Brands</div>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ($this->can('products.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'reviews') ? 'active' : ''; ?>">
                  <a href="<?= site_url('reviews'); ?>" class="menu-link">
                    <div data-i18n="Product Reviews">Product Reviews</div>
                  </a>
                </li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>

            <!-- Sales & Orders -->
            <?php if ($this->can('orders.view')): ?>
            <li class="menu-header mt-3">
              <span class="menu-header-text">Sales</span>
            </li>

            <li class="menu-item <?= ($active_menu === 'orders' || $active_menu === 'sales') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
                <div data-i18n="Sales">Sales & Orders</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($active_submenu === 'all_orders' || empty($active_submenu) && $active_menu === 'orders') ? 'active' : ''; ?>">
                  <a href="<?= site_url('orders'); ?>" class="menu-link">
                    <div data-i18n="All Orders">All Orders</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?= site_url('orders?status=pending'); ?>" class="menu-link">
                    <div data-i18n="Pending Orders">Pending Orders</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?= site_url('orders?status=processing'); ?>" class="menu-link">
                    <div data-i18n="Processing Orders">Processing Orders</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?= site_url('orders?status=shipped'); ?>" class="menu-link">
                    <div data-i18n="Shipped Orders">Shipped Orders</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?= site_url('orders?status=delivered'); ?>" class="menu-link">
                    <div data-i18n="Delivered Orders">Delivered Orders</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'returns') ? 'active' : ''; ?>">
                  <a href="<?= site_url('returns'); ?>" class="menu-link">
                    <div data-i18n="Returns & Refunds">Returns & Refunds</div>
                  </a>
                </li>
              </ul>
            </li>
            <?php endif; ?>

            <!-- Customers -->
            <?php if ($this->can('customers.view')): ?>
            <li class="menu-header mt-3">
              <span class="menu-header-text">Customers</span>
            </li>

            <li class="menu-item <?= ($active_menu === 'customers') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-user-line"></i>
                <div data-i18n="Customers">Customers</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($active_submenu === 'customers_list' || empty($active_submenu)) ? 'active' : ''; ?>">
                  <a href="<?= site_url('customers'); ?>" class="menu-link">
                    <div data-i18n="Customer List">Customer List</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'customer_groups') ? 'active' : ''; ?>">
                  <a href="<?= site_url('customer_groups'); ?>" class="menu-link">
                    <div data-i18n="Customer Groups">Customer Groups</div>
                  </a>
                </li>
              </ul>
            </li>
            <?php endif; ?>

            <!-- Marketing -->
            <li class="menu-header mt-3">
              <span class="menu-header-text">Marketing</span>
            </li>
            <li class="menu-item <?= ($active_menu === 'marketing') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-megaphone-line"></i>
                <div data-i18n="Marketing">Marketing</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($active_submenu === 'coupons') ? 'active' : ''; ?>">
                  <a href="<?= site_url('coupons'); ?>" class="menu-link">
                    <div data-i18n="Coupons & Discounts">Coupons & Discounts</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'flash_sales') ? 'active' : ''; ?>">
                  <a href="<?= site_url('flash_sales'); ?>" class="menu-link">
                    <div data-i18n="Flash Sales">Flash Sales</div>
                  </a>
                </li>
                <?php if ($this->can('banners.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'banners') ? 'active' : ''; ?>">
                  <a href="<?= site_url('banners'); ?>" class="menu-link">
                    <div data-i18n="Banners & Sliders">Banners & Sliders</div>
                  </a>
                </li>
                <?php endif; ?>
                <li class="menu-item <?= ($active_submenu === 'newsletter') ? 'active' : ''; ?>">
                  <a href="<?= site_url('marketing/newsletter'); ?>" class="menu-link">
                    <div data-i18n="Newsletter">Newsletter Subscribers</div>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Inventory -->
            <li class="menu-header mt-3">
              <span class="menu-header-text">Inventory</span>
            </li>
            <li class="menu-item <?= ($active_menu === 'inventory') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-archive-line"></i>
                <div data-i18n="Inventory">Inventory</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($active_submenu === 'stock_list') ? 'active' : ''; ?>">
                  <a href="<?= site_url('inventory'); ?>" class="menu-link">
                    <div data-i18n="Current Stock">Current Stock</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'low_stock') ? 'active' : ''; ?>">
                  <a href="<?= site_url('inventory/low_stock'); ?>" class="menu-link">
                    <div data-i18n="Low Stock">Low Stock Alerts</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'stock_adjust') ? 'active' : ''; ?>">
                  <a href="<?= site_url('inventory/adjust'); ?>" class="menu-link">
                    <div data-i18n="Stock Adjustments">Stock Adjustments</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'stock_history') ? 'active' : ''; ?>">
                  <a href="<?= site_url('inventory/history'); ?>" class="menu-link">
                    <div data-i18n="Stock History">Stock History</div>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Reports -->
            <li class="menu-header mt-3">
              <span class="menu-header-text">Reports</span>
            </li>
            <li class="menu-item <?= ($active_menu === 'reports') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-bar-chart-box-line"></i>
                <div data-i18n="Reports">Reports & Analytics</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($active_submenu === 'sales_report') ? 'active' : ''; ?>">
                  <a href="<?= site_url('reports/sales'); ?>" class="menu-link">
                    <div data-i18n="Sales Report">Sales Report</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'order_report') ? 'active' : ''; ?>">
                  <a href="<?= site_url('reports/orders'); ?>" class="menu-link">
                    <div data-i18n="Order Report">Order Report</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'product_report') ? 'active' : ''; ?>">
                  <a href="<?= site_url('reports/products'); ?>" class="menu-link">
                    <div data-i18n="Product Report">Product Report</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'customer_report') ? 'active' : ''; ?>">
                  <a href="<?= site_url('reports/customers'); ?>" class="menu-link">
                    <div data-i18n="Customer Report">Customer Report</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'tax_report') ? 'active' : ''; ?>">
                  <a href="<?= site_url('reports/tax'); ?>" class="menu-link">
                    <div data-i18n="Tax Report">Tax Report</div>
                  </a>
                </li>
                <li class="menu-item <?= ($active_submenu === 'inventory_report') ? 'active' : ''; ?>">
                  <a href="<?= site_url('reports/inventory'); ?>" class="menu-link">
                    <div data-i18n="Inventory Report">Inventory Report</div>
                  </a>
                </li>
              </ul>
            </li>

            <!-- RBAC & Staff Administration -->
            <?php if ($this->can('admins.manage') || $this->can('roles.manage')): ?>
            <li class="menu-header mt-3">
              <span class="menu-header-text">Staff & Access Control</span>
            </li>

            <li class="menu-item <?= ($active_menu === 'users_management') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-shield-user-line"></i>
                <div data-i18n="Operators & Roles">Operators & Roles</div>
              </a>
              <ul class="menu-sub">
                <?php if ($this->can('admins.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'admins_list') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admins'); ?>" class="menu-link">
                    <div data-i18n="Admin Operators">Admin Staff</div>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ($this->can('roles.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'roles') ? 'active' : ''; ?>">
                  <a href="<?= site_url('roles'); ?>" class="menu-link">
                    <div data-i18n="Roles & Permissions">Roles & Permissions</div>
                  </a>
                </li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>

            <!-- Settings -->
            <?php if ($this->can('settings.manage') || $this->can('gateways.manage')): ?>
            <li class="menu-header mt-3">
              <span class="menu-header-text">Settings</span>
            </li>

            <li class="menu-item <?= ($active_menu === 'settings') ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-settings-3-line"></i>
                <div data-i18n="Settings">Settings</div>
              </a>
              <ul class="menu-sub">
                <?php if ($this->can('settings.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'store_settings') ? 'active' : ''; ?>">
                  <a href="<?= site_url('settings'); ?>" class="menu-link">
                    <div data-i18n="Store Settings">System & Store Settings</div>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ($this->can('gateways.manage')): ?>
                <li class="menu-item <?= ($active_submenu === 'payment_gateways') ? 'active' : ''; ?>">
                  <a href="<?= site_url('settings/payment'); ?>" class="menu-link">
                    <div data-i18n="Payment Gateways">Payment Gateways</div>
                  </a>
                </li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>

            <!-- Website Shortcut -->
            <li class="menu-header mt-3">
              <span class="menu-header-text">Storefront</span>
            </li>
            <li class="menu-item">
              <a href="<?= base_url('../website'); ?>" target="_blank" class="menu-link">
                <i class="menu-icon icon-base ri ri-external-link-line"></i>
                <div data-i18n="View Website">View Live Storefront</div>
              </a>
            </li>
          </ul>
        </aside>
