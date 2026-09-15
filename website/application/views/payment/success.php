        <!-- Success Confirmation Section (Flipkart / Modern Style) -->
        <section class="py-4 py-md-5 bg-light min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border rounded-3 shadow-sm p-3 p-md-5 bg-white mb-4">
                            <!-- Success Header -->
                            <div class="text-center mb-4">
                                <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 64px; height: 64px;">
                                    <i class="fa-solid fa-check fs-2"></i>
                                </div>
                                <h3 class="fw-bold mb-1 text-dark fs-4 fs-md-3">Order Placed Successfully!</h3>
                                <p class="text-muted small mb-3">Confirmation has been sent to <strong><?= html_escape($order['customer_email']); ?></strong></p>
                                <div class="badge bg-light text-dark border px-3 py-2 fs-6">
                                    Order ID: <strong class="text-primary">#<?= html_escape($order['order_number']); ?></strong>
                                </div>
                            </div>

                            <!-- Delivery Status Card -->
                            <div class="card bg-light border rounded-3 p-3 mb-4">
                                <div class="d-flex align-items-sm-center justify-content-between flex-column flex-sm-row gap-2">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle bg-white p-2 text-success shadow-sm flex-shrink-0">
                                            <i class="fa-solid fa-truck-fast fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">Estimated Delivery: <?= date('l, M j', strtotime('+3 days')); ?></div>
                                            <div class="small text-muted">Your package is being prepared for dispatch with priority courier.</div>
                                        </div>
                                    </div>
                                    <span class="badge bg-success px-3 py-2 align-self-start align-self-sm-center">Confirmed</span>
                                </div>
                            </div>

                            <!-- Order Overview Details -->
                            <div class="row g-4 mb-4 border-top pt-4">
                                <div class="col-md-6">
                                    <h6 class="text-uppercase text-muted small fw-bold mb-2">Delivery Address</h6>
                                    <div class="fw-bold text-dark"><?= html_escape($order['customer_name']); ?></div>
                                    <div class="text-secondary small mt-1"><?= nl2br(html_escape($order['shipping_address'])); ?></div>
                                    <?php if (!empty($order['customer_phone'])): ?>
                                        <div class="text-muted small mt-1"><span class="fw-semibold">Phone:</span> <?= html_escape($order['customer_phone']); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-uppercase text-muted small fw-bold mb-2">Payment Details</h6>
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">Payment Mode:</span>
                                        <span class="badge bg-dark text-uppercase"><?= strtoupper($order['payment_method']); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">Payment Status:</span>
                                        <span class="badge bg-success text-uppercase"><?= ucfirst($order['payment_status']); ?></span>
                                    </div>
                                    <?php if (!empty($order['payment_transaction_id'])): ?>
                                        <div class="d-flex justify-content-between mb-1 small">
                                            <span class="text-muted">Transaction ID:</span>
                                            <span class="font-monospace small"><?= html_escape(substr($order['payment_transaction_id'], 0, 18)); ?>...</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                                        <span class="fw-bold">Total Paid:</span>
                                        <span class="fw-bold text-primary fs-5"><?= $currency_symbol . number_format($order['total_amount'], 2); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Ordered Items Breakdown -->
                            <div class="border-top pt-4 mb-4">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Items in this Order</h6>
                                <div class="list-group list-group-flush border rounded-3">
                                    <?php if (!empty($order['items'])): ?>
                                        <?php foreach ($order['items'] as $item): 
                                            $item_img = !empty($item['product_image'])
                                                ? (strpos($item['product_image'], 'http') === 0 ? $item['product_image'] : base_url('assets/images/' . $item['product_image']))
                                                : base_url('assets/images/products/womens/women-1.jpg');
                                        ?>
                                            <div class="list-group-item p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="<?= $item_img; ?>" alt="<?= html_escape($item['product_title']); ?>" class="rounded border object-fit-cover flex-shrink-0" style="width: 56px; height: 56px;" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                    <div>
                                                        <div class="fw-bold text-dark mb-1 small"><?= html_escape($item['product_title']); ?></div>
                                                        <div class="small text-muted">
                                                            Qty: <?= $item['quantity']; ?> <span class="mx-1">•</span> <?= $currency_symbol . number_format($item['price'], 2); ?> each
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-dark fs-6">
                                                    <?= $currency_symbol . number_format($item['total'], 2); ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Bottom Action Buttons -->
                            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 gap-sm-3 pt-2">
                                <a href="<?= site_url('order/track?order_number=' . $order['order_number'] . '&email=' . urlencode($order['customer_email'])); ?>" class="btn btn-outline-primary px-4 py-2 fw-semibold w-100 w-sm-auto text-center">
                                    <i class="fa-solid fa-truck-fast me-1"></i> Track Order
                                </a>
                                <a href="<?= site_url('shop'); ?>" class="btn btn-primary px-4 py-2 fw-semibold w-100 w-sm-auto text-center">
                                    Continue Shopping <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
