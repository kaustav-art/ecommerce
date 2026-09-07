        <!-- Breadcrumb -->
        <div class="bg-light py-3 border-bottom">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Order Tracking</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Order Tracking Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border shadow-sm p-4 p-md-5 bg-white mb-4">
                            <h3 class="fw-bold mb-2 text-center">Track Your Order</h3>
                            <p class="text-muted text-center small mb-4">Enter your Order ID (found in your receipt/confirmation) and Billing Email Address to track shipping and delivery status.</p>

                            <form action="<?= site_url('order/track'); ?>" method="GET" class="row g-3 justify-content-center mb-4">
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold">Order Number</label>
                                    <input type="text" name="order_number" class="form-control" placeholder="e.g. ORD-2026-1001" value="<?= html_escape($this->input->get('order_number') ?? ''); ?>" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold">Billing Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="john@example.com" value="<?= html_escape($this->input->get('email') ?? ''); ?>">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100 py-2">Track</button>
                                </div>
                            </form>

                            <?php if ($searched): ?>
                                <?php if ($order): ?>
                                    <div class="border rounded p-4 text-start bg-light mt-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                            <h5 class="fw-bold mb-0">Order #<?= html_escape($order['order_number']); ?></h5>
                                            <span class="badge bg-primary fs-6"><?= ucfirst($order['order_status']); ?></span>
                                        </div>

                                        <div class="row g-3 mb-4">
                                            <div class="col-sm-4">
                                                <small class="text-muted text-uppercase fw-bold">Placed On:</small>
                                                <div><?= date('M d, Y', strtotime($order['created_at'])); ?></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <small class="text-muted text-uppercase fw-bold">Payment Method:</small>
                                                <div><?= strtoupper($order['payment_method']); ?> (<?= ucfirst($order['payment_status']); ?>)</div>
                                            </div>
                                            <div class="col-sm-4">
                                                <small class="text-muted text-uppercase fw-bold">Grand Total:</small>
                                                <div class="fw-bold text-dark"><?= $currency_symbol . number_format($order['total_amount'], 2); ?></div>
                                            </div>
                                        </div>

                                        <!-- Progress Bar Steps -->
                                        <div class="py-3">
                                            <div class="progress mb-2" style="height: 8px;">
                                                <?php
                                                    $pct = 25;
                                                    if ($order['order_status'] === 'processing') $pct = 50;
                                                    elseif ($order['order_status'] === 'shipped') $pct = 75;
                                                    elseif ($order['order_status'] === 'delivered') $pct = 100;
                                                ?>
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $pct; ?>%"></div>
                                            </div>
                                            <div class="d-flex justify-content-between small text-muted">
                                                <span class="<?= ($pct >= 25) ? 'text-success fw-bold' : ''; ?>">Ordered</span>
                                                <span class="<?= ($pct >= 50) ? 'text-success fw-bold' : ''; ?>">Processing</span>
                                                <span class="<?= ($pct >= 75) ? 'text-success fw-bold' : ''; ?>">Shipped</span>
                                                <span class="<?= ($pct >= 100) ? 'text-success fw-bold' : ''; ?>">Delivered</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-3 border-top">
                                            <h6 class="fw-bold mb-2">Delivery Address:</h6>
                                            <p class="text-muted small mb-0"><?= nl2br(html_escape($order['shipping_address'])); ?></p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning text-center mt-4">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> No matching order was found with those details. Please double-check your Order Number and Email Address.
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
