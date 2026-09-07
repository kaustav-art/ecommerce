<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Orders /</span> Order #<?= html_escape($order['order_number']); ?></h4>
      <small class="text-muted">Placed on <?= date('F d, Y \a\t h:i A', strtotime($order['created_at'])); ?></small>
    </div>
    <div>
      <a href="<?= site_url('orders/invoice/' . $order['id']); ?>" target="_blank" class="btn btn-outline-secondary me-2">
        <i class="fa-solid fa-print me-1"></i> Print Invoice
      </a>
      <a href="<?= site_url('orders'); ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Orders
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Left Column: Ordered Items and Order Summary -->
    <div class="col-12 col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Items</h5>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($order['items'])): ?>
                <?php foreach ($order['items'] as $item): ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <?php if (!empty($item['product_image'])): ?>
                          <img src="<?= base_url('../website/assets/images/' . $item['product_image']); ?>" class="rounded me-2" style="width: 42px; height: 42px; object-fit: cover;" onerror="this.src='<?= base_url('assets/img/elements/1.jpg'); ?>'" />
                        <?php endif; ?>
                        <div>
                          <strong><?= html_escape($item['product_title']); ?></strong>
                          <?php if (!empty($item['product_sku'])): ?>
                            <div class="small text-muted">SKU: <?= html_escape($item['product_sku']); ?></div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </td>
                    <td><?= $currency_symbol . number_format($item['price'], 2); ?></td>
                    <td><?= $item['quantity']; ?></td>
                    <td><strong><?= $currency_symbol . number_format($item['total'], 2); ?></strong></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="card-body border-top">
          <div class="row justify-content-end">
            <div class="col-md-5">
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span><?= $currency_symbol . number_format($order['subtotal'], 2); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Discount:</span>
                <span class="text-danger">-<?= $currency_symbol . number_format($order['discount_amount'], 2); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Shipping Fee:</span>
                <span><?= $currency_symbol . number_format($order['shipping_fee'], 2); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Tax:</span>
                <span><?= $currency_symbol . number_format($order['tax_amount'], 2); ?></span>
              </div>
              <div class="d-flex justify-content-between border-top pt-2">
                <strong class="fs-5">Grand Total:</strong>
                <strong class="fs-5 text-primary"><?= $currency_symbol . number_format($order['total_amount'], 2); ?></strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Customer Info & Status Updater -->
    <div class="col-12 col-lg-4">
      <!-- Status Management Form -->
      <?php if ($this->can('orders.manage')): ?>
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="card-title mb-0">Update Status</h5>
        </div>
        <div class="card-body">
          <form action="<?= site_url('orders/update_status/' . $order['id']); ?>" method="POST">
            <div class="mb-3">
              <label class="form-label" for="order_status">Fulfillment Status</label>
              <select name="order_status" id="order_status" class="form-select">
                <option value="pending" <?= ($order['order_status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="processing" <?= ($order['order_status'] === 'processing') ? 'selected' : ''; ?>>Processing</option>
                <option value="shipped" <?= ($order['order_status'] === 'shipped') ? 'selected' : ''; ?>>Shipped</option>
                <option value="delivered" <?= ($order['order_status'] === 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                <option value="cancelled" <?= ($order['order_status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="payment_status">Payment Status</label>
              <select name="payment_status" id="payment_status" class="form-select">
                <option value="pending" <?= ($order['payment_status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="paid" <?= ($order['payment_status'] === 'paid') ? 'selected' : ''; ?>>Paid</option>
                <option value="failed" <?= ($order['payment_status'] === 'failed') ? 'selected' : ''; ?>>Failed</option>
                <option value="refunded" <?= ($order['payment_status'] === 'refunded') ? 'selected' : ''; ?>>Refunded</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">
              <i class="fa-solid fa-check me-1"></i> Update Order
            </button>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <!-- Customer Details Card -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="card-title mb-0">Customer & Shipping</h5>
        </div>
        <div class="card-body">
          <h6 class="mb-1"><?= html_escape($order['customer_name']); ?></h6>
          <p class="mb-2 text-muted">
            <i class="fa-solid fa-envelope me-1"></i> <?= html_escape($order['customer_email']); ?><br>
            <i class="fa-solid fa-phone me-1"></i> <?= html_escape($order['customer_phone']); ?>
          </p>

          <h6 class="mt-3 mb-1">Shipping Address:</h6>
          <p class="text-muted mb-2 small"><?= nl2br(html_escape($order['shipping_address'])); ?></p>

          <h6 class="mt-3 mb-1">Payment Method:</h6>
          <span class="badge bg-label-dark"><?= strtoupper($order['payment_method']); ?></span>
          <?php if (!empty($order['payment_transaction_id'])): ?>
            <div class="small text-muted mt-1">Transaction: <code><?= html_escape($order['payment_transaction_id']); ?></code></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
