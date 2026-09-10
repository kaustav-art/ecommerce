        <!-- Checkout Section (Matches checkout_page.PNG) -->
        <section class="py-4 bg-light min-vh-100 tf-checkout-page">
            <div class="container">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('cart'); ?>" class="text-muted text-decoration-none">Cart</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold">Checkout</li>
                    </ol>
                </nav>

                <?php 
                    $curr_user_name = $this->is_logged_in() 
                        ? trim(($current_user['first_name'] ?? '') . ' ' . ($current_user['last_name'] ?? ''))
                        : 'Guest Shopper';
                    $curr_user_contact = $this->is_logged_in()
                        ? (!empty($current_user['phone']) ? '+91 ' . $current_user['phone'] : ($current_user['email'] ?? ''))
                        : 'Sign in for saved addresses';

                    $target_addr = !empty($active_address) ? $active_address : (!empty($default_address) ? $default_address : NULL);
                    $disp_name   = $target_addr ? trim(($target_addr['first_name'] ?? '') . ' ' . ($target_addr['last_name'] ?? '')) : '';
                    $disp_pin    = $target_addr['postcode'] ?? '';
                    $disp_tag    = !empty($target_addr['company']) ? strtoupper($target_addr['company']) : 'HOME';
                    $disp_addr   = $target_addr 
                        ? implode(', ', array_filter([$target_addr['address_1'] ?? '', $target_addr['address_2'] ?? '', $target_addr['city'] ?? '', ($target_addr['state'] ?? '') . ($disp_pin ? ' - ' . $disp_pin : '')]))
                        : '';
                    $disp_phone  = !empty($target_addr['phone']) ? $target_addr['phone'] : ($current_user['phone'] ?? '');

                    $item_count = $cart_summary['item_count'] ?? count($cart_items);
                ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-2 py-2 px-3 small mb-3" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-2 py-2 px-3 small mb-3" role="alert">
                        <i class="fa-solid fa-circle-check me-1"></i> <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Top Horizontal Stepper -->
                <div class="card border rounded-2 shadow-sm bg-white mb-3 py-3 px-4">
                    <div class="d-flex align-items-center justify-content-center gap-3 gap-md-5">
                        <!-- Step 1: Address -->
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center <?= !empty($target_addr) ? 'text-white' : 'bg-light text-muted border'; ?> fw-bold" id="top-stepper-1" style="width: 26px; height: 26px; font-size: 13px; <?= !empty($target_addr) ? 'background-color: #000 !important;' : ''; ?>">
                                <?= !empty($target_addr) ? '<i class="fa-solid fa-check"></i>' : '1'; ?>
                            </span>
                            <span class="small fw-semibold <?= !empty($target_addr) ? 'text-dark' : 'text-secondary'; ?>" id="top-stepper-text-1">Address</span>
                        </div>
                        <div style="height: 2px; width: 50px; <?= !empty($target_addr) ? 'background-color: #000;' : 'background-color: #e5e7eb;'; ?>" id="top-stepper-line-1"></div>

                        <!-- Step 2: Order Summary -->
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold" id="top-stepper-2" style="width: 26px; height: 26px; font-size: 13px; background-color: #000 !important;">
                                2
                            </span>
                            <span class="small fw-bold text-dark" id="top-stepper-text-2">Order Summary</span>
                        </div>
                        <div class="bg-secondary-subtle" style="height: 2px; width: 50px;"></div>

                        <!-- Step 3: Payment -->
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-muted bg-light border fw-semibold" id="top-stepper-3" style="width: 26px; height: 26px; font-size: 13px;">
                                3
                            </span>
                            <span class="small text-muted" id="top-stepper-text-3">Payment</span>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Left Column: Stepper Checkout Sections -->
                    <div class="col-lg-8">
                        <div class="d-flex flex-column gap-3">

                            <!-- Delivery Address Card (Matches cart page) -->
                            <div class="card border rounded-3 p-3 mb-1 bg-white shadow-sm tf-delivery-address-card checkout-step-card" id="step-card-address">
                                <!-- When Address is Selected / Saved -->
                                <div class="<?= !empty($target_addr) ? 'd-flex' : 'd-none'; ?> align-items-center justify-content-between flex-wrap gap-2" id="address-box-selected">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-light p-2 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-location-dot fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                <span class="text-muted small">Deliver to:</span>
                                                <strong class="text-dark" id="display-address-name"><?= html_escape($disp_name); ?><?= $disp_pin ? ', ' . html_escape($disp_pin) : ''; ?></strong>
                                                <span class="badge bg-light text-secondary border text-uppercase" id="display-address-tag" style="font-size: 11px;"><?= html_escape($disp_tag); ?></span>
                                            </div>
                                            <div class="text-secondary small text-line-clamp-1" id="display-address-full">
                                                <?= html_escape($disp_addr); ?>
                                            </div>
                                            <div class="text-secondary small mt-1" id="display-address-phone-wrap" style="<?= empty($disp_phone) ? 'display: none;' : ''; ?>">
                                                <span class="text-muted">Phone:</span> <strong class="text-dark fw-medium" id="display-address-phone"><?= html_escape($disp_phone); ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1 fw-bold" onclick="openAddressModal()">
                                            Change
                                        </button>
                                    </div>
                                </div>

                                <!-- When No Address is Selected / Saved -->
                                <div class="<?= empty($target_addr) ? 'd-flex' : 'd-none'; ?> align-items-center justify-content-between flex-wrap gap-2" id="address-box-empty">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-light p-2 text-muted d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-location-dot fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-1">Deliver to: <span class="text-muted fw-normal small">No address selected</span></div>
                                            <div class="text-secondary small">Please add or select a delivery address to proceed with your order.</div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1 fw-bold" onclick="openAddressModal()">
                                            <i class="fa-solid fa-plus me-1"></i> Add Address
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 2: ORDER SUMMARY (Matches checkout_page.PNG) -->
                            <div class="card border rounded-2 shadow-sm bg-white checkout-step-card" id="step-card-summary">
                                <div class="card-body p-0">
                                    <!-- Items List -->
                                    <div class="list-group list-group-flush" id="checkout-items-list">
                                        <?php foreach ($cart_items as $item): 
                                            $item_img = !empty($item['image']) 
                                                ? (strpos($item['image'], 'http') === 0 ? $item['image'] : base_url('assets/images/' . $item['image']))
                                                : base_url('assets/images/products/womens/women-1.jpg');
                                            $item_key = $item['cart_key'] ?? $item['id'];
                                            $item_price = (float) $item['price'];
                                            $item_reg = !empty($item['regular_price']) ? (float) $item['regular_price'] : round($item_price * 1.30, 2);
                                            if ($item_reg <= $item_price) {
                                                $item_reg = round($item_price * 1.30, 2);
                                            }
                                            $disc_pct = !empty($item['discount_percent']) ? $item['discount_percent'] : round((($item_reg - $item_price) / $item_reg) * 100);

                                            // Shipping delivery date calculation
                                            $delivery_days = ($shipping_method === 'express') ? 2 : 4;
                                            $delivery_date = date('M j, D', strtotime("+{$delivery_days} weekdays"));
                                        ?>
                                        <div class="list-group-item p-3 p-md-4 checkout-product-row" id="checkout-item-<?= html_escape($item_key); ?>">
                                            <div class="d-flex gap-3 gap-md-4 align-items-start">
                                                <!-- Product Thumbnail + Quantity Stepper (- 1 +) -->
                                                <div class="flex-shrink-0 text-center" style="width: 88px;">
                                                    <a href="<?= site_url('product/' . $item['slug']); ?>">
                                                        <img src="<?= $item_img; ?>" alt="<?= html_escape($item['title']); ?>" class="rounded border object-fit-cover w-100" style="height: 100px;" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                    </a>
                                                    <!-- Quantity Stepper (- 1 +) -->
                                                    <div class="d-flex align-items-center justify-content-center mt-2 border rounded-1 bg-white py-1" style="max-width: 88px;">
                                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 text-decoration-none fw-bold" onclick="updateCheckoutItemQty('<?= html_escape($item_key); ?>', -1)" style="font-size: 14px; line-height: 1;" title="Decrease quantity">−</button>
                                                        <input type="text" class="form-control form-control-sm text-center border-0 bg-transparent p-0 fw-bold" style="width: 28px; font-size: 13px;" value="<?= $item['quantity']; ?>" readonly id="checkout-qty-<?= html_escape($item_key); ?>">
                                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 text-decoration-none fw-bold" onclick="updateCheckoutItemQty('<?= html_escape($item_key); ?>', 1)" style="font-size: 14px; line-height: 1;" title="Increase quantity">+</button>
                                                    </div>
                                                </div>

                                                <!-- Product Details Column -->
                                                <div class="flex-grow-1">
                                                    <!-- Product Title -->
                                                    <h6 class="mb-1 fw-normal fs-6">
                                                        <a href="<?= site_url('product/' . $item['slug']); ?>" class="text-dark text-decoration-none hover-primary">
                                                            <?= html_escape($item['title']); ?>
                                                        </a>
                                                    </h6>

                                                    <!-- Size -->
                                                    <?php if (!empty($item['size'])): ?>
                                                        <div class="text-secondary small mb-1">
                                                            Size: <span class="text-dark fw-medium"><?= html_escape($item['size']); ?></span>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Color -->
                                                    <?php if (!empty($item['color'])): ?>
                                                        <div class="text-secondary small mb-1">
                                                            Color: <span class="text-dark fw-medium"><?= html_escape($item['color']); ?></span>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Price Row (matches checkout_page.PNG: ↓80% ₹1,799 ₹349) -->
                                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                        <?php if ($disc_pct > 0): ?>
                                                            <span class="text-success fw-bold"><i class="fa-solid fa-arrow-down small"></i><?= $disc_pct; ?>%</span>
                                                            <del class="text-muted small"><?= $currency_symbol . number_format($item_reg, 0); ?></del>
                                                        <?php endif; ?>
                                                        <span class="fs-5 fw-bold text-dark"><?= $currency_symbol . number_format($item_price, 0); ?></span>
                                                        <button type="button" class="btn btn-link text-danger btn-sm p-0 ms-3 text-decoration-none" onclick="removeCheckoutItem('<?= html_escape($item_key); ?>')">
                                                            <i class="fa-regular fa-trash-can me-1"></i> Remove
                                                        </button>
                                                    </div>

                                                    <!-- Delivery Date Row (driven by shipping method selected before cart) -->
                                                    <div class="text-dark small">
                                                        Delivery by <span class="fw-semibold"><?= $delivery_date; ?></span>
                                                        <?php if ($cart_summary['shipping'] == 0): ?>
                                                            <span class="text-success fw-bold ms-2">FREE</span> <del class="text-muted small"><?= $currency_symbol; ?>40</del>
                                                        <?php else: ?>
                                                            <span class="text-secondary small ms-2">(<?= ucfirst($shipping_method); ?> Delivery)</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Bottom Info Strip -->
                                    <div class="p-3 bg-light border-top">
                                        <div class="small text-muted">
                                            Order confirmation email will be sent to <strong><?= html_escape($current_user['email'] ?? 'your account email'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column: Price Details Sidebar (Matches checkout_page.PNG) -->
                    <div class="col-lg-4">
                        <div class="card border rounded-2 shadow-sm bg-white sticky-top position-relative" style="top: 100px;" id="price-details-card">
                            <!-- Loader Overlay for Realtime Updates -->
                            <div id="price-details-loader" class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-none align-items-center justify-content-center" style="z-index: 20; border-radius: inherit;">
                                <div class="text-center p-3">
                                    <div class="spinner-border text-primary mb-2" role="status" style="width: 2rem; height: 2rem;">
                                        <span class="visually-hidden">Updating...</span>
                                    </div>
                                    <div class="small fw-bold text-secondary">Updating prices...</div>
                                </div>
                            </div>

                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h6 class="mb-0 fw-bold text-uppercase text-muted letter-spacing-1" style="font-size: 13px;">
                                    Price Details
                                </h6>
                            </div>

                            <div class="card-body p-4">
                                <!-- Price breakdown items -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-dark" id="side-items-label">Price (<?= $item_count; ?> <?= $item_count > 1 ? 'items' : 'item'; ?>)</span>
                                    <span class="text-dark fw-medium" id="side-mrp-total"><?= $currency_symbol . number_format($mrp_total, 2); ?></span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-dark">Discount</span>
                                    <span class="text-success fw-bold" id="side-discount-total">− <?= $currency_symbol . number_format($discount_total, 2); ?></span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3 <?= (!empty($cart_summary['discount']) && $cart_summary['discount'] > 0) ? '' : 'd-none'; ?>" id="side-coupon-row">
                                    <span class="text-dark">Coupons for you</span>
                                    <span class="text-success fw-bold" id="side-coupon-val">− <?= $currency_symbol . number_format($cart_summary['discount'] ?? 0, 2); ?></span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-dark">Delivery Charges</span>
                                    <span id="side-delivery-charge">
                                        <?php if ($cart_summary['shipping'] == 0): ?>
                                            <span class="text-success fw-bold">FREE</span> <del class="text-muted small"><?= $currency_symbol; ?>40</del>
                                        <?php else: ?>
                                            <span class="text-dark fw-medium"><?= $currency_symbol . number_format($cart_summary['shipping'], 2); ?></span>
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-dark">Secured Packaging Fee</span>
                                    <span class="text-dark fw-medium" id="side-tax-fee"><?= $currency_symbol . number_format($cart_summary['tax'], 2); ?></span>
                                </div>

                                <hr class="my-3 border-secondary-subtle">

                                <!-- Total Payable -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-5 fw-bold text-dark">Total Payable</span>
                                    <span class="fs-5 fw-bold text-dark" id="side-total-payable"><?= $currency_symbol . number_format($cart_summary['total'], 2); ?></span>
                                </div>

                                <hr class="my-3 border-secondary-subtle">

                                <!-- Green Savings Banner -->
                                <div class="alert alert-success border-0 py-2 px-3 small rounded-2 mb-4 text-success fw-bold <?= ($total_savings > 0) ? '' : 'd-none'; ?>" id="side-savings-alert">
                                    <i class="fa-solid fa-circle-check me-1"></i> You will save <span id="side-savings-val"><?= $currency_symbol . number_format($total_savings, 2); ?></span> on this order
                                </div>

                                <!-- Big Action Button -->
                                <button type="button" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-white text-uppercase shadow-sm rounded-2" id="btn-sidebar-continue" onclick="proceedToPaymentPage()" style="background-color: #fb641b; border-color: #fb641b; letter-spacing: 0.5px;">
                                    Continue <i class="fa-solid fa-arrow-right ms-1"></i>
                                </button>

                                <!-- Trust & Safety Guarantee -->
                                <div class="d-flex align-items-center gap-3 mt-4 pt-3 border-top text-muted small">
                                    <div class="text-secondary fs-3">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div style="font-size: 12px; line-height: 1.4;">
                                        Safe and Secure Payments. Easy returns. 100% Authentic products.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
        .breadcrumb-item + .breadcrumb-item::before {
            content: var(--bs-breadcrumb-divider, "/") !important;
        }
        .checkout-step-card {
            border-color: #e5e7eb !important;
            transition: all 0.2s ease;
        }
        .letter-spacing-1 {
            letter-spacing: 0.5px;
        }
        .active-payment-option {
            background-color: #f8fafc !important;
            border-color: #0c2340 !important;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .checkout-qty-select {
            appearance: auto;
            -webkit-appearance: menulist;
        }
        </style>

        <script>
        var SITE_NAME = <?= json_encode($site_name); ?>;
        var SITE_URL = <?= json_encode(site_url()); ?>;
        var CURRENCY = <?= json_encode($currency_symbol); ?>;
        function hasDeliveryAddress() {
            var selectedBox = document.getElementById('address-box-selected');
            if (selectedBox && !selectedBox.classList.contains('d-none') && window.getComputedStyle(selectedBox).display !== 'none') {
                return true;
            }
            return false;
        }

        function proceedToPaymentPage() {
            var hasAddr = <?= !empty($target_addr) ? 'true' : 'false'; ?> || hasDeliveryAddress();

            if (!hasAddr) {
                showCheckoutToast('Please select or add a delivery address before proceeding to payment.', 'warning');
                var addrCard = document.getElementById('step-card-address');
                if (addrCard) {
                    addrCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    addrCard.classList.add('border-warning', 'shadow-sm');
                    setTimeout(function() {
                        addrCard.classList.remove('border-warning', 'shadow-sm');
                    }, 2500);
                }
                if (typeof window.openAddressModal === 'function') {
                    setTimeout(function() {
                        window.openAddressModal();
                    }, 300);
                }
                return;
            }

            var btnOrder = document.getElementById('btn-order-summary-continue');
            var btnSide = document.getElementById('btn-sidebar-continue');
            if (btnOrder) {
                btnOrder.disabled = true;
                btnOrder.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading Payment...';
            }
            if (btnSide) {
                btnSide.disabled = true;
                btnSide.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading Payment...';
            }

            window.location.href = SITE_URL + 'checkout/payment';
        }

        function showCheckoutToast(message, type) {
            type = type || 'danger';
            var existingToast = document.getElementById('checkout-toast-notice');
            if (existingToast) existingToast.remove();

            var toast = document.createElement('div');
            toast.id = 'checkout-toast-notice';
            var bgClass = (type === 'success') ? 'bg-success text-white' : ((type === 'warning') ? 'bg-warning text-dark' : 'bg-danger text-white');
            var icon = (type === 'success') ? 'fa-circle-check' : ((type === 'warning') ? 'fa-triangle-exclamation' : 'fa-circle-exclamation');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '99999';
            toast.innerHTML = 
                '<div class="toast show align-items-center ' + bgClass + ' border-0 shadow-lg" role="alert">' +
                    '<div class="d-flex">' +
                        '<div class="toast-body d-flex align-items-center gap-2">' +
                            '<i class="fa-solid ' + icon + ' fs-5"></i>' +
                            '<span>' + message + '</span>' +
                        '</div>' +
                        '<button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest(\'#checkout-toast-notice\').remove()"></button>' +
                    '</div>' +
                '</div>';
            document.body.appendChild(toast);
            setTimeout(function() {
                if (toast && toast.parentNode) toast.remove();
            }, 5000);
        }

        // ==========================================
        // Real-time Price Details & Quantity Handlers
        // ==========================================
        function showPriceDetailsLoader(show) {
            var loader = document.getElementById('price-details-loader');
            if (!loader) return;
            if (show) {
                loader.classList.remove('d-none');
                loader.classList.add('d-flex');
            } else {
                loader.classList.remove('d-flex');
                loader.classList.add('d-none');
            }
        }

        function formatPrice(val, cur) {
            cur = cur || CURRENCY || '₹';
            var num = parseFloat(val) || 0;
            return cur + num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function applyCartSummary(summary) {
            if (!summary) return;
            var cur = summary.currency_symbol || CURRENCY || '₹';
            var count = summary.item_count || 0;

            // Items count label
            var itemsLabel = document.getElementById('side-items-label');
            if (itemsLabel) {
                itemsLabel.textContent = 'Price (' + count + ' ' + (count > 1 ? 'items' : 'item') + ')';
            }

            // MRP Total
            var mrpEl = document.getElementById('side-mrp-total');
            if (mrpEl && summary.mrp_total !== undefined) {
                mrpEl.textContent = formatPrice(summary.mrp_total, cur);
            }

            // Discount Total
            var discEl = document.getElementById('side-discount-total');
            if (discEl && summary.mrp_discount !== undefined) {
                discEl.textContent = '− ' + formatPrice(summary.mrp_discount, cur);
            }

            // Coupon Row
            var couponRow = document.getElementById('side-coupon-row');
            var couponVal = document.getElementById('side-coupon-val');
            if (couponRow && couponVal) {
                var couponAmt = parseFloat(summary.discount) || 0;
                if (couponAmt > 0) {
                    couponVal.textContent = '− ' + formatPrice(couponAmt, cur);
                    couponRow.classList.remove('d-none');
                } else {
                    couponRow.classList.add('d-none');
                }
            }

            // Delivery charges
            var delivEl = document.getElementById('side-delivery-charge');
            if (delivEl) {
                if (parseFloat(summary.shipping) === 0) {
                    delivEl.innerHTML = '<span class="text-success fw-bold">FREE</span> <del class="text-muted small">' + cur + '40</del>';
                } else {
                    delivEl.innerHTML = '<span class="text-dark fw-medium">' + formatPrice(summary.shipping, cur) + '</span>';
                }
            }

            // Secured Packaging Fee
            var taxEl = document.getElementById('side-tax-fee');
            if (taxEl && summary.tax !== undefined) {
                taxEl.textContent = formatPrice(summary.tax, cur);
            }

            // Total Payable
            var totalEl = document.getElementById('side-total-payable');
            var formattedTotal = formatPrice(summary.total, cur);
            if (totalEl) {
                totalEl.textContent = formattedTotal;
            }

            // Green Savings Banner
            var savingsAlert = document.getElementById('side-savings-alert');
            var savingsVal = document.getElementById('side-savings-val');
            var savings = parseFloat(summary.total_savings) || 0;
            if (savingsVal) {
                savingsVal.textContent = formatPrice(savings, cur);
            }
            if (savingsAlert) {
                if (savings > 0) {
                    savingsAlert.classList.remove('d-none');
                } else {
                    savingsAlert.classList.add('d-none');
                }
            }
        }

        function updateCheckoutItemQty(cartKey, delta) {
            var qtyInput = document.getElementById('checkout-qty-' + cartKey);
            if (!qtyInput) return;
            var cur = parseInt(qtyInput.value) || 1;
            var next = cur + delta;
            if (next < 1) {
                if (confirm('Remove this product from your order?')) {
                    removeCheckoutItem(cartKey);
                }
                return;
            }

            // Show Price Details loader during calculation
            showPriceDetailsLoader(true);

            var formData = new FormData();
            formData.append('cart_key', cartKey);
            formData.append('quantity', next);

            fetch(SITE_URL + 'cart/update', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                showPriceDetailsLoader(false);
                if (data.success) {
                    // Update the qty input without page reload
                    var updatedItem = null;
                    if (data.cart_items && Array.isArray(data.cart_items)) {
                        updatedItem = data.cart_items.find(function(it) {
                            return (it.cart_key === cartKey || it.id == cartKey);
                        });
                    }
                    if (updatedItem) {
                        qtyInput.value = updatedItem.quantity;
                    } else {
                        qtyInput.value = next;
                    }

                    // Apply updated prices to Price Details sidebar
                    applyCartSummary(data.cart_summary);

                    // If max purchase quantity notice returned
                    if (data.message) {
                        showCheckoutToast(data.message, 'warning');
                    }

                    // Update header cart badge if present
                    var badges = document.querySelectorAll('.cart-count, .cart-badge');
                    badges.forEach(function(b) { b.textContent = data.cart_count || 0; });
                } else if (data.message) {
                    showCheckoutToast(data.message, 'warning');
                }
            })
            .catch(function(err) {
                showPriceDetailsLoader(false);
                console.error('Error updating quantity:', err);
                showCheckoutToast('Unable to update quantity. Please try again.', 'danger');
            });
        }

        function removeCheckoutItem(cartKey) {
            showPriceDetailsLoader(true);

            fetch(SITE_URL + 'cart/remove/' + encodeURIComponent(cartKey), {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                showPriceDetailsLoader(false);
                if (data.success) {
                    var row = document.getElementById('checkout-item-' + cartKey);
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'scale(0.97)';
                        setTimeout(function() {
                            row.remove();
                            // If no items left, reload to show empty cart
                            var remaining = document.querySelectorAll('.checkout-product-row');
                            if (remaining.length === 0) {
                                window.location.reload();
                            }
                        }, 300);
                    }

                    // Update Price Details sidebar
                    applyCartSummary(data.cart_summary);

                    // Update header cart badge
                    var badges = document.querySelectorAll('.cart-count, .cart-badge');
                    badges.forEach(function(b) { b.textContent = data.cart_count || 0; });

                    showCheckoutToast('Item removed from your order.', 'success');
                } else if (data.message) {
                    showCheckoutToast(data.message, 'danger');
                }
            })
            .catch(function(err) {
                showPriceDetailsLoader(false);
                console.error('Error removing item:', err);
                showCheckoutToast('Unable to remove item. Please try again.', 'danger');
            });
        }
        </script>
