        <!-- Breadcrumb -->
        <div class="bg-light py-3 border-bottom">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('cart'); ?>">Cart</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Checkout Form Section -->
        <section class="py-5">
            <div class="container">
                <?php if (!$this->is_logged_in()): ?>
                    <div class="alert alert-info d-flex justify-content-between align-items-center mb-4 shadow-sm">
                        <span><i class="fa-solid fa-user me-2 text-primary"></i> <strong>Guest Checkout Enabled!</strong> Already have an account? Sign in to access your saved addresses.</span>
                        <a href="<?= site_url('login'); ?>" class="btn btn-outline-primary btn-sm">Sign In</a>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('checkout/process'); ?>" method="POST" id="checkoutForm">
                    <div class="row">
                        <!-- Left Column: Address and Payment Method -->
                        <div class="col-lg-7 mb-4 mb-lg-0">
                            <!-- 1. Customer & Shipping Details -->
                            <div class="card border shadow-sm p-4 mb-4">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">1. Shipping & Customer Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="first_name"
                                            class="form-control"
                                            value="<?= html_escape($default_address['first_name'] ?? ($current_user['first_name'] ?? '')); ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="last_name"
                                            class="form-control"
                                            value="<?= html_escape($default_address['last_name'] ?? ($current_user['last_name'] ?? '')); ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control"
                                            value="<?= html_escape($current_user['email'] ?? ''); ?>"
                                            placeholder="order-receipt@example.com"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Phone Number <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control"
                                            value="<?= html_escape($default_address['phone'] ?? ($current_user['phone'] ?? '')); ?>"
                                            placeholder="+1 555 0199"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Street Address <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="address_1"
                                            class="form-control"
                                            placeholder="House number and street name"
                                            value="<?= html_escape($default_address['address_1'] ?? ''); ?>"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <input
                                            type="text"
                                            name="address_2"
                                            class="form-control"
                                            placeholder="Apartment, suite, unit, etc. (optional)"
                                            value="<?= html_escape($default_address['address_2'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Town / City <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="city"
                                            class="form-control"
                                            value="<?= html_escape($default_address['city'] ?? ''); ?>"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">State / Province <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="state"
                                            class="form-control"
                                            value="<?= html_escape($default_address['state'] ?? ''); ?>"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Postal Code <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="postcode"
                                            class="form-control"
                                            value="<?= html_escape($default_address['postcode'] ?? ''); ?>"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Country <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="country"
                                            class="form-control"
                                            value="<?= html_escape($default_address['country'] ?? 'United States'); ?>"
                                            required>
                                    </div>

                                    <?php if ($this->is_logged_in()): ?>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="save_address" id="save_address" value="1" checked>
                                                <label class="form-check-label small" for="save_address">
                                                    Save this address to my profile for future orders
                                                </label>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <!-- Guest Checkout: Inline Account Creation Option -->
                                        <div class="col-12 border-top pt-3">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="create_account" id="create_account" value="1" onchange="document.getElementById('pwd-box').style.display = this.checked ? 'block' : 'none';">
                                                <label class="form-check-label small fw-bold" for="create_account">
                                                    Create an account with these details for faster checkout next time?
                                                </label>
                                            </div>
                                            <div id="pwd-box" style="display: none;" class="mt-2">
                                                <label class="form-label small fw-bold">Choose a Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password" class="form-control form-control-sm" placeholder="At least 6 characters" style="max-width: 320px;">
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Order Notes (Optional)</label>
                                        <textarea name="order_notes" class="form-control" rows="2" placeholder="Special delivery instructions, gate code, or delivery notes..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Shipping Delivery Method -->
                            <div class="card border shadow-sm p-4 mb-4">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">2. Shipping Method</h5>
                                <div class="list-group">
                                    <label class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                                        <input class="form-check-input flex-shrink-0 mt-0" type="radio" name="shipping_method" value="standard" <?= ($cart_summary['shipping_method'] === 'standard') ? 'checked' : ''; ?> onchange="updateCheckoutShipping('standard')">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>Standard Delivery (3-5 Business Days)</strong>
                                                <span class="badge bg-light text-dark border">
                                                    <?= ($cart_summary['subtotal'] >= $cart_summary['shipping_free_min']) ? '<span class="text-success fw-bold">FREE</span>' : $currency_symbol . number_format($cart_summary['shipping_flat'], 2); ?>
                                                </span>
                                            </div>
                                            <small class="text-muted">Standard reliable ground courier.</small>
                                        </div>
                                    </label>
                                    <label class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                                        <input class="form-check-input flex-shrink-0 mt-0" type="radio" name="shipping_method" value="express" <?= ($cart_summary['shipping_method'] === 'express') ? 'checked' : ''; ?> onchange="updateCheckoutShipping('express')">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>Express Priority Delivery (1-2 Business Days)</strong>
                                                <span class="badge bg-light text-dark border"><?= $currency_symbol . number_format($cart_summary['shipping_express'], 2); ?></span>
                                            </div>
                                            <small class="text-muted">High priority air express dispatch with real-time tracking.</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- 3. Payment Method Selection -->
                            <div class="card border shadow-sm p-4">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">3. Payment Method</h5>
                                <p class="text-muted small mb-3">All transactions are encrypted and processed safely through certified payment gateways.</p>

                                <div class="list-group">
                                    <!-- Stripe -->
                                    <label class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                                        <input class="form-check-input flex-shrink-0 mt-0" type="radio" name="payment_method" value="stripe" checked>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>Stripe (Credit / Debit Card)</strong>
                                                <span class="badge bg-primary">Stripe</span>
                                            </div>
                                            <small class="text-muted">Pay securely with Visa, MasterCard, American Express, or Discover.</small>
                                        </div>
                                    </label>

                                    <!-- Razorpay -->
                                    <label class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                                        <input class="form-check-input flex-shrink-0 mt-0" type="radio" name="payment_method" value="razorpay">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>Razorpay (UPI, Cards, NetBanking)</strong>
                                                <span class="badge bg-info text-dark">Razorpay</span>
                                            </div>
                                            <small class="text-muted">Pay with Google Pay, PhonePe, UPI, NetBanking, or Indian Cards.</small>
                                        </div>
                                    </label>

                                    <!-- PayU -->
                                    <label class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                                        <input class="form-check-input flex-shrink-0 mt-0" type="radio" name="payment_method" value="payu">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>PayU (PayU Money / Biz)</strong>
                                                <span class="badge bg-warning text-dark">PayU</span>
                                            </div>
                                            <small class="text-muted">Fast and trusted PayU payment gateway redirect.</small>
                                        </div>
                                    </label>

                                    <!-- COD -->
                                    <label class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                                        <input class="form-check-input flex-shrink-0 mt-0" type="radio" name="payment_method" value="cod">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>Cash on Delivery (COD)</strong>
                                                <span class="badge bg-success">Cash</span>
                                            </div>
                                            <small class="text-muted">Pay cash at the time of delivery to your doorstep.</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Order Summary and Button -->
                        <div class="col-lg-5">
                            <div class="card border shadow-sm p-4 sticky-top" style="top: 100px;">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">Your Order Summary</h5>

                                <!-- Cart items breakdown -->
                                <div class="mb-4" style="max-height: 280px; overflow-y: auto;">
                                    <?php foreach ($cart_items as $item): ?>
                                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('assets/images/' . $item['image']); ?>" class="rounded me-2 border" style="width: 44px; height: 44px; object-fit: cover;" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                <div class="small">
                                                    <div class="text-truncate fw-semibold" style="max-width: 170px;"><?= html_escape($item['title']); ?></div>
                                                    <?php if (!empty($item['variant_title'])): ?>
                                                        <span class="badge bg-light text-muted border"><?= html_escape($item['variant_title']); ?></span>
                                                    <?php endif; ?>
                                                    <div class="text-muted">Qty: <?= $item['quantity']; ?></div>
                                                </div>
                                            </div>
                                            <span class="small fw-bold"><?= $currency_symbol . number_format($item['total'], 2); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal (<?= $cart_summary['item_count']; ?> items):</span>
                                        <span><?= $currency_symbol . number_format($cart_summary['subtotal'], 2); ?></span>
                                    </div>
                                    <?php if ($cart_summary['discount'] > 0): ?>
                                        <div class="d-flex justify-content-between mb-2 text-danger">
                                            <span>Coupon Discount (<?= html_escape($cart_summary['coupon']['code']); ?>):</span>
                                            <span>-<?= $currency_symbol . number_format($cart_summary['discount'], 2); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Estimated Shipping:</span>
                                        <span id="summary-shipping">
                                            <?= ($cart_summary['shipping'] == 0) ? '<span class="text-success fw-bold">FREE</span>' : $currency_symbol . number_format($cart_summary['shipping'], 2); ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Estimated Tax (<?= $cart_summary['tax_rate_percent']; ?>%):</span>
                                        <span id="summary-tax"><?= $currency_symbol . number_format($cart_summary['tax'], 2); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between border-top pt-3 mb-4">
                                        <strong class="fs-5">Grand Total:</strong>
                                        <strong class="fs-5 text-primary" id="summary-total"><?= $currency_symbol . number_format($cart_summary['total'], 2); ?></strong>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                        Place Order Now <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <script>
        function updateCheckoutShipping(method) {
            fetch('<?= site_url("cart/set_shipping_method"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'shipping_method=' + encodeURIComponent(method)
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success && data.cart_summary) {
                    var s = data.cart_summary;
                    var shipEl = document.getElementById('summary-shipping');
                    if (shipEl) {
                        shipEl.innerHTML = (s.shipping == 0) ? '<span class="text-success fw-bold">FREE</span>' : s.currency_symbol + s.shipping.toFixed(2);
                    }
                    var taxEl = document.getElementById('summary-tax');
                    if (taxEl) {
                        taxEl.textContent = s.currency_symbol + s.tax.toFixed(2);
                    }
                    var totEl = document.getElementById('summary-total');
                    if (totEl) {
                        totEl.textContent = s.currency_symbol + s.total.toFixed(2);
                    }
                }
            });
        }
        </script>
