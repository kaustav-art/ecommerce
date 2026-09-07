        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading">Order #<?= html_escape($order['order_number']); ?></h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li><a class="link" href="<?= site_url('account/orders'); ?>">Orders</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li>#<?= html_escape($order['order_number']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- my-account -->
        <section class="flat-spacing">
            <div class="container">
                <div class="my-account-wrap">
                    <?php $this->load->view('account/sidebar'); ?>

                    <div class="my-account-content">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                            <div>
                                <h5 class="fw-bold mb-1">Order Details #<?= html_escape($order['order_number']); ?></h5>
                                <div class="text-muted small">Placed on <?= date('F d, Y \a\t h:i A', strtotime($order['created_at'])); ?></div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="<?= site_url('account/invoice/' . $order['order_number']); ?>" target="_blank" class="btn btn-outline-dark btn-sm">
                                    <i class="fa-solid fa-print me-1"></i> Print Invoice
                                </a>
                                <a href="<?= site_url('account/orders'); ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Orders
                                </a>
                            </div>
                        </div>

                        <!-- Status Alert & Action Badges -->
                        <div class="alert alert-light border d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                            <div>
                                <span>Order Status: </span>
                                <span class="badge bg-primary fs-6"><?= ucfirst($order['order_status']); ?></span>
                            </div>
                            <div>
                                <span>Payment: </span>
                                <span class="badge bg-<?= ($order['payment_status'] === 'paid') ? 'success' : 'warning'; ?> fs-6">
                                    <?= ucfirst($order['payment_status']); ?> (<?= strtoupper($order['payment_method']); ?>)
                                </span>
                            </div>

                            <!-- Contextual actions -->
                            <div class="d-flex gap-2">
                                <?php if (in_array($order['order_status'], ['pending', 'on_hold'])): ?>
                                    <a href="<?= site_url('account/cancel_order/' . $order['order_number']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this order? It will be restocked automatically.');">
                                        <i class="fa-solid fa-ban me-1"></i> Cancel Order
                                    </a>
                                <?php elseif (in_array($order['order_status'], ['completed', 'delivered', 'processing'])): ?>
                                    <button type="button" class="btn btn-outline-warning text-dark btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal">
                                        <i class="fa-solid fa-rotate-left me-1"></i> Request Return / Refund
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="card border mb-4 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="m-0 fw-bold">Ordered Items</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($order['items'])): ?>
                                            <?php foreach ($order['items'] as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?= base_url('assets/images/' . $item['product_image']); ?>" class="rounded me-3 border" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                            <div>
                                                                <strong><?= html_escape($item['product_title']); ?></strong>
                                                                <?php if (!empty($item['variant_title'])): ?>
                                                                    <div><span class="badge bg-light text-dark border small"><?= html_escape($item['variant_title']); ?></span></div>
                                                                <?php endif; ?>
                                                                <div class="text-muted small">SKU: <code><?= html_escape($item['product_sku'] ?? 'N/A'); ?></code></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $currency_symbol . number_format($item['price'], 2); ?></td>
                                                    <td><?= (int)$item['quantity']; ?></td>
                                                    <td class="text-end fw-bold"><?= $currency_symbol . number_format($item['total'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="3" class="text-end">Subtotal:</td>
                                            <td class="text-end"><?= $currency_symbol . number_format($order['subtotal'], 2); ?></td>
                                        </tr>
                                        <?php if ($order['discount_amount'] > 0): ?>
                                            <tr>
                                                <td colspan="3" class="text-end text-danger">Discount:</td>
                                                <td class="text-end text-danger">-<?= $currency_symbol . number_format($order['discount_amount'], 2); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td colspan="3" class="text-end">Shipping Fee:</td>
                                            <td class="text-end"><?= ($order['shipping_fee'] == 0) ? 'FREE' : $currency_symbol . number_format($order['shipping_fee'], 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Tax:</td>
                                            <td class="text-end"><?= $currency_symbol . number_format($order['tax_amount'], 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold fs-6">Grand Total:</td>
                                            <td class="text-end fw-bold fs-6 text-primary"><?= $currency_symbol . number_format($order['total_amount'], 2); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Shipping & Payment Info -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border shadow-sm p-3">
                                    <h6 class="fw-bold mb-2"><i class="fa-solid fa-location-dot text-primary me-1"></i> Delivery Address</h6>
                                    <p class="text-muted small mb-1"><strong><?= html_escape($order['customer_name']); ?></strong></p>
                                    <p class="text-muted small mb-1"><?= nl2br(html_escape($order['shipping_address'])); ?></p>
                                    <p class="text-muted small mb-0"><i class="fa-solid fa-phone me-1"></i> <?= html_escape($order['customer_phone']); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <div class="card border shadow-sm p-3">
                                    <h6 class="fw-bold mb-2"><i class="fa-solid fa-credit-card text-primary me-1"></i> Payment Details</h6>
                                    <p class="text-muted small mb-1"><strong>Method:</strong> <?= strtoupper($order['payment_method']); ?></p>
                                    <p class="text-muted small mb-1"><strong>Status:</strong> <?= ucfirst($order['payment_status']); ?></p>
                                    <?php if (!empty($order['payment_transaction_id'])): ?>
                                        <p class="text-muted small mb-0"><strong>Transaction ID:</strong> <code><?= html_escape($order['payment_transaction_id']); ?></code></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Returns info if any -->
                        <?php if (!empty($order['returns'])): ?>
                            <div class="card border shadow-sm p-3 mt-4">
                                <h6 class="fw-bold mb-3"><i class="fa-solid fa-rotate-left text-warning me-1"></i>Return / Refund Requests on this Order</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Type</th>
                                                <th>Reason</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Submitted</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order['returns'] as $r): ?>
                                                <tr>
                                                    <td class="text-uppercase fw-bold small"><?= html_escape($r['type']); ?></td>
                                                    <td class="small"><?= html_escape($r['reason']); ?></td>
                                                    <td class="small fw-bold"><?= $currency_symbol . number_format($r['amount'], 2); ?></td>
                                                    <td><span class="badge bg-warning text-dark text-uppercase"><?= html_escape($r['status']); ?></span></td>
                                                    <td class="small text-muted"><?= date('M d, Y', strtotime($r['created_at'])); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->

        <!-- Return / Refund Request Modal -->
        <div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Request Return / Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= site_url('account/request_return/' . $order['order_number']); ?>" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Request Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="return">Return for Refund</option>
                                    <option value="replacement">Item Replacement</option>
                                    <option value="refund">Direct Refund</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Refund Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text"><?= $currency_symbol; ?></span>
                                    <input type="number" step="0.01" name="amount" class="form-control" value="<?= $order['total_amount']; ?>" max="<?= $order['total_amount']; ?>">
                                </div>
                                <small class="text-muted">Maximum refund amount: <?= $currency_symbol . number_format($order['total_amount'], 2); ?></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Reason for Request <span class="text-danger">*</span></label>
                                <textarea name="reason" class="form-control" rows="3" placeholder="Please describe the defect, incorrect size/color, or reason for return..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
