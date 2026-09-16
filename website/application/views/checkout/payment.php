        <!-- Breadcrumbs -->
        <section class="py-3 bg-light border-bottom">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?= site_url(); ?>" class="text-secondary text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('cart'); ?>" class="text-secondary text-decoration-none">Cart</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('checkout'); ?>" class="text-secondary text-decoration-none">Checkout</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Payment</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Main Payment View -->
        <section class="py-4 py-md-5 bg-light min-vh-100">
            <div class="container">
                <?php
                    $currency_symbol = $this->store_settings['currency_symbol'] ?? '₹';

                    $target_addr = $default_address;
                    $disp_name   = $target_addr ? trim(($target_addr['first_name'] ?? '') . ' ' . ($target_addr['last_name'] ?? '')) : '';
                    $disp_pin    = $target_addr['postcode'] ?? '';
                    $disp_tag    = !empty($target_addr['company']) ? strtoupper($target_addr['company']) : 'HOME';
                    $disp_addr   = $target_addr 
                        ? implode(', ', array_filter([$target_addr['address_1'] ?? '', $target_addr['address_2'] ?? '', $target_addr['city'] ?? '', ($target_addr['state'] ?? '') . ($disp_pin ? ' - ' . $disp_pin : '')]))
                        : '';
                    $disp_phone  = $target_addr['phone'] ?? '';

                    $item_count = $cart_summary['item_count'] ?? count($cart_items);
                ?>

                <!-- Top Horizontal Stepper (Black Color) -->
                <div class="card border rounded-2 shadow-sm bg-white mb-3 py-2 py-md-3 px-2 px-md-4">
                    <div class="d-flex align-items-center justify-content-center gap-1 gap-sm-3 gap-md-5">
                        <!-- Step 1: Address (Completed) -->
                        <div class="d-flex align-items-center gap-1 gap-sm-2">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center flex-shrink-0 text-white fw-bold" id="top-stepper-1" style="width: 24px; height: 24px; font-size: 12px; background-color: #000 !important;">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="small fw-semibold text-dark" id="top-stepper-text-1" style="font-size: 12px;">Address</span>
                        </div>
                        <div style="height: 2px; min-width: 12px; max-width: 45px; flex: 1; background-color: #000;"></div>

                        <!-- Step 2: Order Summary (Completed) -->
                        <div class="d-flex align-items-center gap-1 gap-sm-2">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center flex-shrink-0 text-white fw-bold" id="top-stepper-2" style="width: 24px; height: 24px; font-size: 12px; background-color: #000 !important;">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="small fw-bold text-dark" id="top-stepper-text-2" style="font-size: 12px;">Order Summary</span>
                        </div>
                        <div style="height: 2px; min-width: 12px; max-width: 45px; flex: 1; background-color: #000;"></div>

                        <!-- Step 3: Payment (Active) -->
                        <div class="d-flex align-items-center gap-1 gap-sm-2">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center flex-shrink-0 text-white fw-bold" id="top-stepper-3" style="width: 24px; height: 24px; font-size: 12px; background-color: #000 !important;">
                                3
                            </span>
                            <span class="small fw-bold text-dark" id="top-stepper-text-3" style="font-size: 12px;">Payment</span>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Left Column: Order Summary + Payment Options -->
                    <div class="col-lg-8">
                        <div class="d-flex flex-column gap-3">

                            <!-- Order Summary -->
                            <div class="card border rounded-2 shadow-sm bg-white">
                                <div class="card-header bg-white py-3 px-3 px-md-4 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2 gap-sm-3">
                                        <span class="badge rounded-1 bg-light text-dark border px-2 py-1 fw-bold">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                        <h6 class="mb-0 fw-bold text-uppercase text-secondary" style="font-size: 13px;">
                                            Order Summary (<?= $item_count; ?> <?= $item_count > 1 ? 'items' : 'item'; ?>)
                                        </h6>
                                    </div>
                                    <a href="<?= site_url('checkout'); ?>" class="btn btn-outline-secondary btn-sm px-3 py-1 fw-bold">
                                        Edit Items
                                    </a>
                                </div>
                                <div class="card-body px-4 py-3 pt-0">
                                    <div class="d-flex gap-3 flex-wrap align-items-center">
                                        <?php foreach (array_slice($cart_items, 0, 4) as $it): 
                                            $thumb = !empty($it['image']) 
                                                ? (strpos($it['image'], 'http') === 0 ? $it['image'] : base_url('assets/images/' . $it['image']))
                                                : base_url('assets/images/products/womens/women-1.jpg');
                                        ?>
                                            <div class="d-flex align-items-center gap-2 bg-light p-2 rounded border" style="max-width: 240px;">
                                                <img src="<?= $thumb; ?>" class="rounded border object-fit-cover" style="width: 44px; height: 44px;" alt="<?= html_escape($it['title']); ?>">
                                                <div class="small lh-sm text-truncate">
                                                    <div class="text-dark text-truncate fw-medium" title="<?= html_escape($it['title']); ?>"><?= html_escape($it['title']); ?></div>
                                                    <span class="text-muted" style="font-size: 11px;">Qty: <?= $it['quantity']; ?> &bull; <?= $currency_symbol . number_format($it['price'], 0); ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <?php if (count($cart_items) > 4): ?>
                                            <span class="small text-muted fw-semibold">+<?= count($cart_items) - 4; ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- PAYMENT OPTIONS -->
                            <div class="card border rounded-2 shadow-sm bg-white" id="step-card-payment">
                                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-uppercase text-dark" style="font-size: 13px; letter-spacing: 0.5px;">
                                        Payment Options
                                    </h6>
                                    <span class="badge bg-light text-muted border small"><i class="fa-solid fa-shield-halved text-success me-1"></i> 100% Safe & Secure</span>
                                </div>

                                <div class="card-body p-3 p-md-4" id="payment-options-body">
                                    <!-- Payment Methods List -->
                                    <div class="d-flex flex-column gap-2 mb-1">
                                        <?php
                                            $cod_allowed = isset($cod_eligible) ? $cod_eligible : true;
                                            $non_cod = !empty($non_cod_items) ? $non_cod_items : [];

                                            // Determine valid selectable gateways
                                            $valid_selectable_codes = [];
                                            foreach ($gateways as $gw) {
                                                if ($gw['gateway_code'] === 'cod' && !$cod_allowed) {
                                                    continue;
                                                }
                                                $valid_selectable_codes[] = $gw['gateway_code'];
                                            }

                                            $selected_gateway = (!empty($default_gateway) && in_array($default_gateway, $valid_selectable_codes))
                                                ? $default_gateway
                                                : (!empty($valid_selectable_codes) ? $valid_selectable_codes[0] : '');

                                            $gateway_meta = [
                                                'razorpay' => [
                                                    'name' => 'Razorpay (UPI, Google Pay, PhonePe, Cards, NetBanking)',
                                                    'desc' => 'Pay securely via UPI QR, Google Pay, PhonePe, Cards, or NetBanking',
                                                    'icon' => 'fa-credit-card text-info'
                                                ],
                                                'stripe' => [
                                                    'name' => 'Credit / Debit Card (Stripe Gateway)',
                                                    'desc' => 'Visa, MasterCard, American Express, Rupay',
                                                    'icon' => 'fa-shield-halved text-primary'
                                                ],
                                                'payu' => [
                                                    'name' => 'PayU (NetBanking & Wallets)',
                                                    'desc' => 'Pay via PayU Money/Biz NetBanking and Wallets',
                                                    'icon' => 'fa-money-bill-transfer text-warning'
                                                ],
                                                'cod' => [
                                                    'name' => 'Cash on Delivery (COD)',
                                                    'desc' => 'Pay with cash or UPI QR scanner when package arrives',
                                                    'icon' => 'fa-truck-ramp-box text-success'
                                                ]
                                            ];
                                        ?>

                                        <?php if (empty($gateways) || empty($valid_selectable_codes)): ?>
                                            <div class="alert alert-warning border rounded-2 p-3 mb-0">
                                                <i class="fa-solid fa-triangle-exclamation me-2"></i> 
                                                <?php if (!empty($gateways) && empty($valid_selectable_codes) && !$cod_allowed): ?>
                                                    Cash on Delivery is the only configured payment method, but your cart contains product(s) that do not support Cash on Delivery (<strong><?= html_escape(implode(', ', $non_cod)); ?></strong>). Please contact support.
                                                <?php else: ?>
                                                    No payment methods are currently active. Please contact customer support.
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($gateways as $gw):
                                                $code = $gw['gateway_code'];
                                                $meta = $gateway_meta[$code] ?? [
                                                    'name' => $gw['gateway_name'],
                                                    'desc' => 'Pay securely via ' . $gw['gateway_name'],
                                                    'icon' => 'fa-wallet text-secondary'
                                                ];
                                                $is_cod_disabled = ($code === 'cod' && !$cod_allowed);
                                                $is_checked = ($code === $selected_gateway && !$is_cod_disabled);
                                                $desc = (!empty($gw['credentials']['instructions'])) ? $gw['credentials']['instructions'] : $meta['desc'];
                                            ?>
                                                <label class="p-3 rounded-2 border d-flex align-items-start gap-3 <?= $is_checked ? 'active-payment-option' : ''; ?> <?= $is_cod_disabled ? 'bg-light text-muted border-secondary-subtle' : 'cursor-pointer'; ?>" 
                                                       id="payment-label-<?= $code; ?>" 
                                                       style="transition: all 0.15s ease; <?= $is_cod_disabled ? 'opacity: 0.75; cursor: not-allowed !important;' : ''; ?>">
                                                    <input class="form-check-input flex-shrink-0 mt-1" 
                                                           type="radio" 
                                                           name="payment_method_choice" 
                                                           value="<?= $code; ?>" 
                                                           <?= $is_checked ? 'checked' : ''; ?> 
                                                           <?= $is_cod_disabled ? 'disabled' : ''; ?> 
                                                           <?= !$is_cod_disabled ? 'onchange="handlePaymentSelection(\'' . $code . '\')"' : ''; ?>>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <div class="fw-semibold <?= $is_cod_disabled ? 'text-secondary' : 'text-dark'; ?>">
                                                                <i class="fa-solid <?= $meta['icon']; ?> me-1"></i>
                                                                <?= html_escape($meta['name']); ?>
                                                            </div>
                                                            <?php if ($is_cod_disabled): ?>
                                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle small px-2 py-1">
                                                                    <i class="fa-solid fa-ban me-1"></i>COD Unavailable
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-secondary small mt-1"><?= html_escape($desc); ?></div>
                                                        <?php if ($is_cod_disabled): ?>
                                                            <div class="alert alert-danger border-0 bg-danger-subtle text-danger py-2 px-3 small rounded-2 mt-2 mb-0">
                                                                <i class="fa-solid fa-circle-exclamation me-1"></i>
                                                                Cash on Delivery is disabled because item <strong><?= html_escape(implode(', ', $non_cod)); ?></strong> in your cart does not support COD. Please complete your payment using the online payment gateway.
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </label>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column: Price Details Sidebar -->
                    <div class="col-lg-4">
                        <div class="card border rounded-2 shadow-sm bg-white sticky-top position-relative" style="top: 100px;" id="price-details-card">
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
                                <button type="button" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-white text-uppercase shadow-sm rounded-2" id="btn-sidebar-pay" onclick="triggerSelectedPayment()" style="background-color: #fb641b; border-color: #fb641b; letter-spacing: 0.5px;" <?= (empty($gateways) || empty($valid_selectable_codes)) ? 'disabled' : ''; ?>>
                                    <?= (empty($gateways) || empty($valid_selectable_codes)) ? 'NO PAYMENT METHOD AVAILABLE' : 'PAY NOW'; ?>
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
            background-color: #f8f9fa !important;
            border-color: #000 !important;
            box-shadow: 0 0 0 1px #000;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        </style>

        <script>
        var SITE_NAME = <?= json_encode($site_name); ?>;
        var SITE_URL = <?= json_encode(site_url()); ?>;
        var CURRENCY = <?= json_encode($currency_symbol); ?>;

        function handlePaymentSelection(method) {
            document.querySelectorAll('label[id^="payment-label-"]').forEach(function(label) {
                var m = label.id.replace('payment-label-', '');
                var radio = label.querySelector('input[type="radio"]');
                if (radio && radio.disabled) return;
                if (m === method) {
                    label.classList.add('active-payment-option');
                    if (radio) radio.checked = true;
                } else {
                    label.classList.remove('active-payment-option');
                }
            });
        }

        function triggerSelectedPayment() {
            var checkedRadio = document.querySelector('input[name="payment_method_choice"]:checked:not(:disabled)');
            if (!checkedRadio) {
                showCheckoutToast('Please select an available payment method before proceeding.', 'warning');
                return;
            }
            var method = checkedRadio.value;
            initiateGatewayPayment(method);
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
            var activeBtn = document.getElementById('btn-sidebar-pay');
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
                            window.location.href = SITE_URL + 'cart?login=1';
                        }, 800);
                        if (activeBtn) {
                            activeBtn.disabled = false;
                            activeBtn.innerHTML = 'PAY NOW';
                        }
                        return;
                    }
                    showCheckoutToast(data.message || 'Unable to place order. Please check address details.', 'danger');
                    if (activeBtn) {
                        activeBtn.disabled = false;
                        activeBtn.innerHTML = 'PAY NOW';
                    }
                    return;
                }

                if (method === 'cod') {
                    window.location.href = data.redirect_url;
                } else if (method === 'razorpay') {
                    launchRazorpaySDK(data);
                } else if (method === 'stripe') {
                    launchStripePayment(data);
                } else if (method === 'payu') {
                    launchPayUGateway(data);
                }
            })
            .catch(function(err) {
                console.error('Error initiating payment:', err);
                showCheckoutToast('An error occurred. Please try again.', 'danger');
                if (activeBtn) {
                    activeBtn.disabled = false;
                    activeBtn.innerHTML = 'PAY NOW';
                }
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
                "currency": rzpData.currency || (order.currency || "<?= html_escape($currency_code ?? 'USD'); ?>"),
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
                        var btn = document.getElementById('btn-sidebar-pay');
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = 'PAY NOW';
                        }
                    }
                }
            };

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
            var btn = document.getElementById('btn-sidebar-pay');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = 'PAY NOW';
            }

            var container = document.getElementById('payment-options-body');
            if (container) {
                var oldBanner = document.getElementById('rzp-failure-banner');
                if (oldBanner) oldBanner.remove();

                var banner = document.createElement('div');
                banner.id = 'rzp-failure-banner';
                banner.className = 'alert alert-warning border rounded-2 p-3 mt-3 shadow-sm text-start';
                banner.innerHTML = 
                    '<div class="d-flex align-items-start gap-2 mb-2">' +
                        '<i class="fa-solid fa-triangle-exclamation text-warning fs-5 mt-1"></i>' +
                        '<div>' +
                            '<strong class="text-dark d-block">Razorpay Sandbox / Test Notice</strong>' +
                            '<span class="small text-secondary">' + (errDesc || 'Payment could not be completed with the current test keys.') + '</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="d-flex gap-2 flex-wrap mt-3">' +
                        '<button type="button" class="btn btn-sm btn-dark fw-bold" onclick="simulateSandboxPayment(\'' + data.order_number + '\')">' +
                            '<i class="fa-solid fa-circle-check me-1"></i> Complete in Sandbox Test Mode' +
                        '</button>' +
                        '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="triggerSelectedPayment()">' +
                            '<i class="fa-solid fa-rotate-right me-1"></i> Retry Razorpay' +
                        '</button>' +
                    '</div>';
                container.appendChild(banner);
            }
        }

        function simulateSandboxPayment(orderNumber) {
            var btn = document.getElementById('btn-sidebar-pay');
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
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = 'PAY NOW';
                }
            });
        }

        // ==========================================
        // 2. STRIPE GATEWAY REDIRECT (Official Stripe Checkout)
        // ==========================================
        function launchStripePayment(data) {
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                window.location.href = SITE_URL + 'payment/stripe/' + data.order_number;
            }
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
                '<input type="hidden" name="currency" value="' + (p.currency || (order.currency || '<?= html_escape($currency_code ?? 'USD'); ?>')) + '">' +
                '<input type="hidden" name="firstname" value="' + p.firstname + '">' +
                '<input type="hidden" name="email" value="' + p.email + '">' +
                '<input type="hidden" name="phone" value="' + p.phone + '">' +
                '<input type="hidden" name="productinfo" value="' + p.productinfo + '">' +
                '<input type="hidden" name="surl" value="' + p.surl + '">' +
                '<input type="hidden" name="furl" value="' + p.furl + '">' +
                '</form>';
            document.getElementById('payu-dynamic-form').submit();
        }
        </script>
