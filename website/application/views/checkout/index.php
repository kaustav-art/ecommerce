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
                    $disp_name   = $target_addr ? trim(($target_addr['first_name'] ?? '') . ' ' . ($target_addr['last_name'] ?? '')) : $curr_user_name;
                    $disp_pin    = $target_addr['postcode'] ?? '';
                    $disp_tag    = !empty($target_addr['company']) ? strtoupper($target_addr['company']) : 'HOME';
                    $disp_addr   = $target_addr 
                        ? implode(', ', array_filter([$target_addr['address_1'] ?? '', $target_addr['address_2'] ?? '', $target_addr['city'] ?? '', ($target_addr['state'] ?? '') . ($disp_pin ? ' - ' . $disp_pin : '')]))
                        : 'No delivery address selected yet.';
                    $disp_phone  = $target_addr['phone'] ?? ($current_user['phone'] ?? '');

                    $item_count = $cart_summary['item_count'] ?? count($cart_items);
                ?>

                <div class="row g-4">
                    <!-- Left Column: Flipkart-Style Stepper Checkout Sections -->
                    <div class="col-lg-8">
                        <div class="d-flex flex-column gap-3">

                            <!-- STEP 1: LOGIN -->
                            <div class="card border rounded-2 shadow-sm bg-white checkout-step-card" id="step-card-login">
                                <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="step-num badge rounded-1 bg-primary text-white px-2 py-1 fw-bold">1</span>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-uppercase step-title text-secondary">
                                                Login <i class="fa-solid fa-check text-primary ms-1" title="Completed"></i>
                                            </h6>
                                            <div class="small text-muted mt-1">
                                                <strong><?= html_escape($curr_user_name); ?></strong> <span class="mx-1">•</span> <?= html_escape($curr_user_contact); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <?php if ($this->is_logged_in()): ?>
                                            <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1 fw-bold" onclick="openLoginModal()">Change</button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-primary btn-sm px-3 py-1 fw-bold" onclick="openLoginModal()">Sign In</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 2: DELIVERY ADDRESS -->
                            <div class="card border rounded-2 shadow-sm bg-white checkout-step-card" id="step-card-address">
                                <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="step-num badge rounded-1 bg-primary text-white px-2 py-1 fw-bold mt-1">2</span>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-uppercase step-title text-secondary">
                                                Delivery Address <i class="fa-solid fa-check text-primary ms-1" title="Selected"></i>
                                            </h6>
                                            <div class="d-flex align-items-center gap-2 flex-wrap mt-2">
                                                <strong class="text-dark fs-6" id="checkout-step-address-name"><?= html_escape($disp_name ?: 'Select Address'); ?></strong>
                                                <span class="badge bg-secondary text-white text-uppercase" id="checkout-step-address-tag" style="font-size: 10px;"><?= html_escape($disp_tag); ?></span>
                                                <span class="fw-bold text-dark" id="checkout-step-address-pin"><?= html_escape($disp_pin); ?></span>
                                            </div>
                                            <div class="text-muted small mt-1" id="checkout-step-address-full">
                                                <?= html_escape($disp_addr); ?>
                                            </div>
                                            <?php if ($disp_phone): ?>
                                                <div class="small text-muted mt-1">
                                                    <span class="fw-semibold">Phone:</span> <span id="checkout-step-address-phone"><?= html_escape($disp_phone); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1 fw-bold" onclick="openAddressModal()">
                                            Change
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 3: ORDER SUMMARY -->
                            <div class="card border rounded-2 shadow-sm bg-white checkout-step-card" id="step-card-summary">
                                <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center rounded-top-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="step-num badge rounded-1 bg-white text-primary px-2 py-1 fw-bold">3</span>
                                        <h6 class="mb-0 fw-bold text-uppercase text-white letter-spacing-1">
                                            Order Summary <span class="badge bg-white text-primary rounded-pill ms-2"><?= $item_count; ?></span>
                                        </h6>
                                    </div>
                                </div>

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
                                            $disc_pct = !empty($item['discount_percent']) ? $item['discount_percent'] : round((($item_reg - $item_price) / $item_reg) * 100);
                                        ?>
                                        <div class="list-group-item p-4 checkout-product-row" id="checkout-item-<?= html_escape($item_key); ?>">
                                            <div class="d-flex gap-4">
                                                <!-- Product Thumbnail -->
                                                <div class="flex-shrink-0 text-center">
                                                    <a href="<?= site_url('product/' . $item['slug']); ?>">
                                                        <img src="<?= $item_img; ?>" alt="<?= html_escape($item['title']); ?>" class="rounded border object-fit-cover" style="width: 100px; height: 110px;" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                    </a>
                                                    <!-- Quantity Selector -->
                                                    <div class="d-flex align-items-center justify-content-center mt-3 border rounded-1 bg-light py-1" style="max-width: 110px;">
                                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 text-decoration-none fw-bold" onclick="updateCheckoutItemQty('<?= html_escape($item_key); ?>', -1)">−</button>
                                                        <input type="text" class="form-control form-control-sm text-center border-0 bg-transparent p-0 fw-bold" style="width: 32px;" value="<?= $item['quantity']; ?>" readonly id="checkout-qty-<?= html_escape($item_key); ?>">
                                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 text-decoration-none fw-bold" onclick="updateCheckoutItemQty('<?= html_escape($item_key); ?>', 1)">+</button>
                                                    </div>
                                                </div>

                                                <!-- Product Details -->
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">
                                                                <a href="<?= site_url('product/' . $item['slug']); ?>" class="text-dark text-decoration-none hover-primary">
                                                                    <?= html_escape($item['title']); ?>
                                                                </a>
                                                            </h6>
                                                            <?php if (!empty($item['variant_title'])): ?>
                                                                <div class="text-secondary small mb-1">
                                                                    Size / Option: <span class="fw-semibold text-dark"><?= html_escape($item['variant_title']); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <!-- Delivery Date Tag -->
                                                        <div class="text-end small">
                                                            <div class="text-dark fw-semibold">Delivery by <?= date('D, M j', strtotime('+3 days')); ?></div>
                                                            <span class="text-success fw-bold">FREE Delivery</span> <del class="text-muted small"><?= $currency_symbol; ?>40</del>
                                                        </div>
                                                    </div>

                                                    <!-- Price Row -->
                                                    <div class="d-flex align-items-baseline gap-2 mt-2">
                                                        <span class="fs-5 fw-bold text-dark" id="checkout-item-total-<?= html_escape($item_key); ?>"><?= $currency_symbol . number_format($item_price, 2); ?></span>
                                                        <del class="text-muted small"><?= $currency_symbol . number_format($item_reg, 2); ?></del>
                                                        <span class="text-success fw-bold small"><?= $disc_pct; ?>% Off</span>
                                                        <span class="badge bg-success-subtle text-success small ms-2"><i class="fa-solid fa-tag me-1"></i>Special Price</span>
                                                    </div>

                                                    <!-- Actions -->
                                                    <div class="mt-3 pt-2 border-top d-flex gap-4">
                                                        <a href="javascript:void(0);" onclick="removeCheckoutItem('<?= html_escape($item_key); ?>')" class="text-danger small fw-bold text-decoration-none text-uppercase">
                                                            <i class="fa-regular fa-trash-can me-1"></i> Remove
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Bottom Continue Strip -->
                                    <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div class="small text-muted">
                                            Order confirmation email will be sent to <strong><?= html_escape($current_user['email'] ?? 'your account email'); ?></strong>
                                        </div>
                                        <button type="button" class="btn btn-warning btn-lg fw-bold px-4 py-2 text-white text-uppercase shadow-sm" id="btn-order-summary-continue" onclick="openPaymentStep()" style="background-color: #fb641b; border-color: #fb641b;">
                                            Continue <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 4: PAYMENT OPTIONS -->
                            <div class="card border rounded-2 shadow-sm bg-white checkout-step-card" id="step-card-payment">
                                <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="step-num badge rounded-1 bg-secondary text-white px-2 py-1 fw-bold" id="step-4-num">4</span>
                                        <h6 class="mb-0 fw-bold text-uppercase step-title text-secondary">
                                            Payment Options
                                        </h6>
                                    </div>
                                    <span class="badge bg-light text-muted border small"><i class="fa-solid fa-shield-halved text-success me-1"></i> 100% Safe & Secure</span>
                                </div>

                                <div class="card-body p-4 pt-0" id="payment-options-body">
                                    <div class="alert alert-info py-2 px-3 small rounded-3 mb-3 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-circle-info fs-5 text-primary"></i>
                                        <span>Select your preferred payment method below to complete this order.</span>
                                    </div>

                                    <!-- Payment Methods List Group -->
                                    <div class="list-group mb-4">
                                        <!-- 1. Razorpay (UPI, Google Pay, PhonePe, Cards, NetBanking) -->
                                        <label class="list-group-item list-group-item-action p-3 cursor-pointer d-flex align-items-start gap-3 active-payment-option" id="payment-label-razorpay">
                                            <input class="form-check-input flex-shrink-0 mt-1" type="radio" name="payment_method_choice" value="razorpay" checked onchange="handlePaymentSelection('razorpay')">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="text-dark fs-6">Razorpay (UPI, Cards, NetBanking & Wallets)</strong>
                                                    <span class="badge bg-info text-dark px-2 py-1">Razorpay</span>
                                                </div>
                                                <div class="text-secondary small mb-2">
                                                    Pay using Google Pay, PhonePe, Paytm, BHIM UPI, Credit/Debit Cards, or NetBanking.
                                                </div>
                                                <div class="d-flex gap-2 flex-wrap align-items-center">
                                                    <span class="badge bg-light text-dark border"><i class="fa-brands fa-google-pay fs-6 me-1"></i>Google Pay</span>
                                                    <span class="badge bg-light text-dark border">PhonePe</span>
                                                    <span class="badge bg-light text-dark border">UPI QR</span>
                                                    <span class="badge bg-light text-dark border"><i class="fa-regular fa-credit-card me-1"></i>All Indian Cards</span>
                                                </div>

                                                <!-- Razorpay Expanded Section -->
                                                <div class="mt-3 pt-3 border-top" id="box-pay-razorpay">
                                                    <button type="button" class="btn btn-primary px-4 py-2 fw-bold" onclick="initiateGatewayPayment('razorpay')" id="btn-pay-rzp">
                                                        <i class="fa-solid fa-lock me-2"></i> Pay <?= $currency_symbol . number_format($cart_summary['total'], 2); ?> with Razorpay
                                                    </button>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- 2. Stripe (Credit / Debit Card) -->
                                        <label class="list-group-item list-group-item-action p-3 cursor-pointer d-flex align-items-start gap-3" id="payment-label-stripe">
                                            <input class="form-check-input flex-shrink-0 mt-1" type="radio" name="payment_method_choice" value="stripe" onchange="handlePaymentSelection('stripe')">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="text-dark fs-6">Credit / Debit / ATM Card (Stripe)</strong>
                                                    <span class="badge bg-primary px-2 py-1">Stripe</span>
                                                </div>
                                                <div class="text-secondary small mb-2">
                                                    Visa, MasterCard, American Express, Discover, Diners Club, or Maestro.
                                                </div>

                                                <!-- Stripe Card Form (Expanded) -->
                                                <div class="mt-3 pt-3 border-top d-none" id="box-pay-stripe">
                                                    <div class="row g-2 mb-2" style="max-width: 480px;">
                                                        <div class="col-12">
                                                            <label class="form-label small fw-semibold mb-1">Card Number</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" id="stripe-card-num" class="form-control font-monospace" placeholder="4242 •••• •••• 4242" value="4242 4242 4242 4242">
                                                                <span class="input-group-text"><i class="fa-solid fa-credit-card"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold mb-1">Valid Thru (MM/YY)</label>
                                                            <input type="text" id="stripe-card-exp" class="form-control form-control-sm font-monospace" placeholder="12/28" value="12/28">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold mb-1">CVV</label>
                                                            <input type="password" id="stripe-card-cvv" class="form-control form-control-sm font-monospace" placeholder="123" value="123" maxlength="4">
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary px-4 py-2 fw-bold mt-2" onclick="initiateGatewayPayment('stripe')" id="btn-pay-stripe">
                                                        <i class="fa-solid fa-lock me-2"></i> Pay <?= $currency_symbol . number_format($cart_summary['total'], 2); ?> via Stripe
                                                    </button>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- 3. PayU (PayU Money / Biz) -->
                                        <label class="list-group-item list-group-item-action p-3 cursor-pointer d-flex align-items-start gap-3" id="payment-label-payu">
                                            <input class="form-check-input flex-shrink-0 mt-1" type="radio" name="payment_method_choice" value="payu" onchange="handlePaymentSelection('payu')">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="text-dark fs-6">PayU (PayU Biz / Money)</strong>
                                                    <span class="badge bg-warning text-dark px-2 py-1">PayU</span>
                                                </div>
                                                <div class="text-secondary small mb-2">
                                                    Fast and trusted gateway redirect supporting NetBanking and Wallets.
                                                </div>

                                                <!-- PayU Action Section -->
                                                <div class="mt-3 pt-3 border-top d-none" id="box-pay-payu">
                                                    <button type="button" class="btn btn-warning px-4 py-2 fw-bold text-dark" onclick="initiateGatewayPayment('payu')" id="btn-pay-payu">
                                                        <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> Proceed to PayU Gateway
                                                    </button>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- 4. Cash on Delivery (COD) -->
                                        <label class="list-group-item list-group-item-action p-3 cursor-pointer d-flex align-items-start gap-3" id="payment-label-cod">
                                            <input class="form-check-input flex-shrink-0 mt-1" type="radio" name="payment_method_choice" value="cod" onchange="handlePaymentSelection('cod')">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="text-dark fs-6">Cash on Delivery (COD)</strong>
                                                    <span class="badge bg-success px-2 py-1">Cash</span>
                                                </div>
                                                <div class="text-secondary small mb-2">
                                                    Pay with cash or UPI QR scanner when the courier delivers your package to your doorstep.
                                                </div>

                                                <!-- COD Confirm Section -->
                                                <div class="mt-3 pt-3 border-top d-none" id="box-pay-cod">
                                                    <button type="button" class="btn btn-success px-4 py-2 fw-bold" onclick="initiateGatewayPayment('cod')" id="btn-pay-cod">
                                                        <i class="fa-solid fa-circle-check me-2"></i> Confirm Cash on Delivery Order
                                                    </button>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column: Price Details Sidebar (Matches checkout_page.PNG) -->
                    <div class="col-lg-4">
                        <div class="card border rounded-2 shadow-sm bg-white sticky-top" style="top: 100px;">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h6 class="mb-0 fw-bold text-uppercase text-muted letter-spacing-1" style="font-size: 13px;">
                                    Price Details
                                </h6>
                            </div>

                            <div class="card-body p-4">
                                <!-- Price breakdown items -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-dark">Price (<?= $item_count; ?> <?= $item_count > 1 ? 'items' : 'item'; ?>)</span>
                                    <span class="text-dark fw-medium" id="side-mrp-total"><?= $currency_symbol . number_format($mrp_total, 2); ?></span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-dark">Discount</span>
                                    <span class="text-success fw-bold" id="side-discount-total">− <?= $currency_symbol . number_format($discount_total, 2); ?></span>
                                </div>

                                <?php if (!empty($cart_summary['discount']) && $cart_summary['discount'] > 0): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-dark">Coupons for you</span>
                                        <span class="text-success fw-bold">− <?= $currency_symbol . number_format($cart_summary['discount'], 2); ?></span>
                                    </div>
                                <?php endif; ?>

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
                                <div class="alert alert-success border-0 py-2 px-3 small rounded-2 mb-4 text-success fw-bold" id="side-savings-alert">
                                    <i class="fa-solid fa-circle-check me-1"></i> You will save <span id="side-savings-val"><?= $currency_symbol . number_format($total_savings, 2); ?></span> on this order
                                </div>

                                <!-- Big Action Button -->
                                <button type="button" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-white text-uppercase shadow-sm rounded-2" id="btn-sidebar-continue" onclick="triggerMainCheckoutAction()" style="background-color: #fb641b; border-color: #fb641b; letter-spacing: 0.5px;">
                                    Continue
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

        <!-- Hidden PayU Auto-submit Form Container -->
        <div id="payu-dynamic-container" style="display: none;"></div>

        <!-- External SDK Scripts -->
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script src="https://js.stripe.com/v3/"></script>

        <style>
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
        </style>

        <script>
        var SITE_NAME = <?= json_encode($site_name); ?>;
        var SITE_URL = <?= json_encode(site_url()); ?>;
        var CURRENCY = <?= json_encode($currency_symbol); ?>;
        var CURRENT_STEP = 'summary'; // 'summary' or 'payment'

        function handlePaymentSelection(method) {
            ['razorpay', 'stripe', 'payu', 'cod'].forEach(function(m) {
                var box = document.getElementById('box-pay-' + m);
                var label = document.getElementById('payment-label-' + m);
                if (box) {
                    if (m === method) box.classList.remove('d-none');
                    else box.classList.add('d-none');
                }
                if (label) {
                    if (m === method) label.classList.add('active-payment-option');
                    else label.classList.remove('active-payment-option');
                }
            });
        }

        function openPaymentStep() {
            CURRENT_STEP = 'payment';
            var payCard = document.getElementById('step-card-payment');
            var payNum = document.getElementById('step-4-num');
            var sidebarBtn = document.getElementById('btn-sidebar-continue');

            if (payCard) {
                payCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            if (payNum) {
                payNum.className = 'step-num badge rounded-1 bg-primary text-white px-2 py-1 fw-bold';
            }
            if (sidebarBtn) {
                sidebarBtn.textContent = 'PAY NOW';
            }
        }

        function triggerMainCheckoutAction() {
            if (CURRENT_STEP === 'summary') {
                openPaymentStep();
            } else {
                var checkedRadio = document.querySelector('input[name="payment_method_choice"]:checked');
                var method = checkedRadio ? checkedRadio.value : 'razorpay';
                initiateGatewayPayment(method);
            }
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

        function initiateGatewayPayment(method) {
            var activeBtn = document.getElementById('btn-pay-' + method) || document.getElementById('btn-sidebar-continue');
            if (activeBtn) {
                activeBtn.disabled = true;
                activeBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            }

            var formData = new FormData();
            formData.append('payment_method', method);

            fetch(SITE_URL + 'checkout/create_order_ajax', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (!data.success) {
                    if (data.require_login) {
                        showCheckoutToast(data.message || 'Please sign in to complete your purchase.', 'warning');
                        setTimeout(function() {
                            if (typeof window.openLoginModal === 'function') {
                                window.openLoginModal(window.location.href, data.message);
                            } else {
                                window.location.href = SITE_URL + 'cart?login=1';
                            }
                        }, 800);
                        if (activeBtn) activeBtn.disabled = false;
                        return;
                    }
                    showCheckoutToast(data.message || 'Unable to place order. Please check address details.', 'danger');
                    if (activeBtn) activeBtn.disabled = false;
                    return;
                }

                if (method === 'cod') {
                    // Direct COD Success
                    window.location.href = data.redirect_url;
                } else if (method === 'razorpay') {
                    // Launch Razorpay Checkout JS SDK
                    launchRazorpaySDK(data);
                } else if (method === 'stripe') {
                    // Launch Stripe Verification
                    launchStripePayment(data);
                } else if (method === 'payu') {
                    // Submit to PayU Gateway
                    launchPayUGateway(data);
                }
            })
            .catch(function(err) {
                console.error('Error initiating payment:', err);
                showCheckoutToast('An error occurred. Please try again.', 'danger');
                if (activeBtn) activeBtn.disabled = false;
            });
        }

        // ==========================================
        // 1. RAZORPAY SDK LAUNCHER
        // ==========================================
        function launchRazorpaySDK(data) {
            var rzpData = data.razorpay;
            var order = data.order || {};

            var options = {
                "key": rzpData.key_id,
                "amount": rzpData.amount_subunit,
                "currency": rzpData.currency || "INR",
                "name": SITE_NAME,
                "description": "Payment for Order #" + data.order_number,
                "prefill": {
                    "name": order.customer_name || "",
                    "email": order.customer_email || "",
                    "contact": order.customer_phone || ""
                },
                "theme": {
                    "color": "#0c2340"
                },
                "handler": function(response) {
                    var verifyForm = new FormData();
                    verifyForm.append('order_number', data.order_number);
                    verifyForm.append('razorpay_payment_id', response.razorpay_payment_id);
                    verifyForm.append('razorpay_order_id', response.razorpay_order_id || (rzpData.razorpay_order_id || ''));
                    verifyForm.append('razorpay_signature', response.razorpay_signature || '');

                    fetch(SITE_URL + 'checkout/verify_razorpay_ajax', {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        body: verifyForm
                    })
                    .then(function(r) { return r.json(); })
                    .then(function(verifyRes) {
                        if (verifyRes.success && verifyRes.redirect_url) {
                            window.location.href = verifyRes.redirect_url;
                        } else {
                            handleRazorpayFailure(data, verifyRes.message || 'Payment verification failed.');
                        }
                    })
                    .catch(function(err) {
                        handleRazorpayFailure(data, 'Verification network error.');
                    });
                },
                "modal": {
                    "ondismiss": function() {
                        var btn = document.getElementById('btn-pay-rzp') || document.getElementById('btn-pay-razorpay') || document.getElementById('btn-sidebar-continue');
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Pay ' + CURRENCY + parseFloat(order.total_amount || 0).toFixed(2) + ' with Razorpay';
                        }
                    }
                }
            };

            // ONLY attach order_id if it's an authentic server-side order created on Razorpay's server
            if (rzpData.razorpay_order_id && rzpData.razorpay_order_id.indexOf('order_') === 0 && rzpData.razorpay_order_id.indexOf('order_test_') !== 0) {
                options.order_id = rzpData.razorpay_order_id;
            }

            try {
                var rzp = new Razorpay(options);
                rzp.on('payment.failed', function(response) {
                    var desc = (response && response.error && response.error.description) 
                        ? response.error.description 
                        : 'Razorpay payment was not completed.';
                    handleRazorpayFailure(data, desc);
                });
                rzp.open();
            } catch(e) {
                handleRazorpayFailure(data, e.message || 'Razorpay checkout could not be opened.');
            }
        }

        function handleRazorpayFailure(data, errDesc) {
            var btn = document.getElementById('btn-pay-rzp') || document.getElementById('btn-pay-razorpay') || document.getElementById('btn-sidebar-continue');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Retry Razorpay Payment';
            }

            var box = document.getElementById('box-pay-razorpay');
            if (box) {
                var oldBanner = document.getElementById('rzp-failure-banner');
                if (oldBanner) oldBanner.remove();

                var banner = document.createElement('div');
                banner.id = 'rzp-failure-banner';
                banner.className = 'alert alert-warning border rounded-3 p-3 mt-3 shadow-sm text-start';
                banner.innerHTML = 
                    '<div class="d-flex align-items-start gap-2 mb-2">' +
                        '<i class="fa-solid fa-triangle-exclamation text-warning fs-5 mt-1"></i>' +
                        '<div>' +
                            '<strong class="text-dark d-block">Razorpay Sandbox / Test Notice</strong>' +
                            '<span class="small text-secondary">' + (errDesc || 'Payment could not be completed with the current test keys.') + '</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="d-flex gap-2 flex-wrap mt-3">' +
                        '<button type="button" class="btn btn-sm btn-primary fw-bold" onclick="simulateSandboxPayment(\'' + data.order_number + '\')">' +
                            '<i class="fa-solid fa-circle-check me-1"></i> Complete in Sandbox Test Mode' +
                        '</button>' +
                        '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="initiateGatewayPayment(\'razorpay\')">' +
                            '<i class="fa-solid fa-rotate-right me-1"></i> Retry Razorpay' +
                        '</button>' +
                    '</div>';
                box.appendChild(banner);
            }
        }

        function simulateSandboxPayment(orderNumber) {
            var btn = document.getElementById('btn-pay-rzp') || document.getElementById('btn-sidebar-continue');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Confirming Test Payment...';
            }

            var simPaymentId = 'pay_sim_' + Math.random().toString(36).substring(2, 12);
            var verifyForm = new FormData();
            verifyForm.append('order_number', orderNumber);
            verifyForm.append('razorpay_payment_id', simPaymentId);
            verifyForm.append('razorpay_order_id', '');
            verifyForm.append('razorpay_signature', 'sig_sim');

            fetch(SITE_URL + 'checkout/verify_razorpay_ajax', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: verifyForm
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success && res.redirect_url) {
                    window.location.href = res.redirect_url;
                }
            })
            .catch(function(err) {
                console.error('Error in sandbox payment:', err);
                if (btn) btn.disabled = false;
            });
        }

        // ==========================================
        // 2. STRIPE SDK / PAYMENT CONFIRMATION
        // ==========================================
        function launchStripePayment(data) {
            var stripeData = data.stripe;
            var confirmForm = new FormData();
            confirmForm.append('order_number', data.order_number);
            confirmForm.append('payment_intent_id', stripeData.intent_id || ('pi_sim_' + Date.now()));

            fetch(SITE_URL + 'checkout/confirm_stripe_ajax', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: confirmForm
            })
            .then(function(res) { return res.json(); })
            .then(function(res) {
                if (res.success && res.redirect_url) {
                    window.location.href = res.redirect_url;
                } else {
                    showCheckoutToast(res.message || 'Stripe payment confirmation failed.', 'danger');
                }
            })
            .catch(function(err) {
                console.error('Error confirming stripe payment:', err);
                window.location.href = SITE_URL + 'payment/stripe/' + data.order_number;
            });
        }

        // ==========================================
        // 3. PAYU GATEWAY AUTO-SUBMISSION
        // ==========================================
        function launchPayUGateway(data) {
            var p = data.payu;
            var container = document.getElementById('payu-dynamic-container');
            container.innerHTML = 
                '<form action="' + p.action_url + '" method="POST" id="payu-dynamic-form">' +
                '<input type="hidden" name="key" value="' + p.key + '">' +
                '<input type="hidden" name="hash" value="' + p.hash + '">' +
                '<input type="hidden" name="txnid" value="' + p.txnid + '">' +
                '<input type="hidden" name="amount" value="' + p.amount + '">' +
                '<input type="hidden" name="firstname" value="' + p.firstname + '">' +
                '<input type="hidden" name="email" value="' + p.email + '">' +
                '<input type="hidden" name="phone" value="' + p.phone + '">' +
                '<input type="hidden" name="productinfo" value="' + p.productinfo + '">' +
                '<input type="hidden" name="surl" value="' + p.surl + '">' +
                '<input type="hidden" name="furl" value="' + p.furl + '">' +
                '</form>';
            document.getElementById('payu-dynamic-form').submit();
        }

        // ==========================================
        // Quantity & Item Handlers in Checkout
        // ==========================================
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
                if (data.success) {
                    qtyInput.value = next;
                    window.location.reload();
                }
            });
        }

        function removeCheckoutItem(cartKey) {
            fetch(SITE_URL + 'cart/remove/' + encodeURIComponent(cartKey), {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    var row = document.getElementById('checkout-item-' + cartKey);
                    if (row) row.remove();
                    window.location.reload();
                }
            });
        }
        </script>
