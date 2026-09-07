        <!-- Success Confirmation Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm p-4 p-md-5 bg-white text-center mb-4">
                            <div class="mb-3 text-success">
                                <i class="fa-solid fa-circle-check fs-1"></i>
                            </div>
                            <h2 class="fw-bold mb-2">Thank You for Your Order!</h2>
                            <p class="lead text-muted mb-4">Your order has been received and is currently being processed.</p>

                            <div class="alert alert-success d-inline-block py-2 px-4 mb-4">
                                Order Reference: <strong class="fs-5">#<?= html_escape($order['order_number']); ?></strong>
                            </div>

                            <div class="row text-start g-4 mb-4 border-top pt-4">
                                <div class="col-sm-6">
                                    <h6 class="text-uppercase text-muted small fw-bold">Customer Details:</h6>
                                    <div><strong><?= html_escape($order['customer_name']); ?></strong></div>
                                    <div>Email: <?= html_escape($order['customer_email']); ?></div>
                                    <div>Phone: <?= html_escape($order['customer_phone']); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-uppercase text-muted small fw-bold">Payment & Status:</h6>
                                    <div>Method: <span class="badge bg-dark"><?= strtoupper($order['payment_method']); ?></span></div>
                                    <div>Payment: <span class="badge bg-success"><?= ucfirst($order['payment_status']); ?></span></div>
                                    <div>Fulfillment: <span class="badge bg-info text-dark"><?= ucfirst($order['order_status']); ?></span></div>
                                </div>
                            </div>

                            <div class="text-start border-top pt-4 mb-4">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Shipping Address:</h6>
                                <p class="text-muted mb-0"><?= nl2br(html_escape($order['shipping_address'])); ?></p>
                            </div>

                            <div class="table-responsive text-start border-top pt-4 mb-4">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Ordered Items:</h6>
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($order['items'])): ?>
                                            <?php foreach ($order['items'] as $item): ?>
                                                <tr>
                                                    <td><strong><?= html_escape($item['product_title']); ?></strong></td>
                                                    <td><?= $currency_symbol . number_format($item['price'], 2); ?></td>
                                                    <td><?= $item['quantity']; ?></td>
                                                    <td class="text-end"><?= $currency_symbol . number_format($item['total'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Grand Total Paid:</th>
                                            <th class="text-end text-primary fs-5"><?= $currency_symbol . number_format($order['total_amount'], 2); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <a href="<?= site_url('order/track?order_number=' . $order['order_number'] . '&email=' . urlencode($order['customer_email'])); ?>" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-truck-fast me-1"></i> Track This Order
                                </a>
                                <a href="<?= site_url('shop'); ?>" class="btn btn-primary">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
