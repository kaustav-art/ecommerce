<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Orders /</span> Order #<?= html_escape($order['order_number']); ?></h4>
      <small class="text-muted">Placed on <?= date('F d, Y \a\t h:i A', strtotime($order['created_at'])); ?></small>
    </div>
    <div>
      <?php $is_confirmed = in_array(strtolower($order['order_status']), ['processing', 'shipped', 'delivered', 'completed']); ?>
      <?php if ($is_confirmed): ?>
        <a href="<?= site_url('orders/invoice/' . $order['id']); ?>" target="_blank" class="btn btn-primary me-2">
          <i class="fa-solid fa-file-invoice me-1"></i> Download Invoice
        </a>
      <?php else: ?>
        <button type="button" class="btn btn-outline-secondary me-2" disabled title="Invoice is available any time after order is confirmed">
          <i class="fa-solid fa-file-invoice me-1"></i> Invoice (Confirm Order First)
        </button>
      <?php endif; ?>
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
          <h5 class="card-title mb-0">Update Status & Courier</h5>
        </div>
        <div class="card-body">
          <form action="<?= site_url('orders/update_status/' . $order['id']); ?>" method="POST">
            <div class="mb-3">
              <label class="form-label fw-semibold" for="order_status">Fulfillment Status</label>
              <select name="order_status" id="order_status" class="form-select" onchange="toggleCourierFields()">
                <option value="pending" <?= ($order['order_status'] === 'pending') ? 'selected' : ''; ?>>Pending (Order Placed)</option>
                <option value="processing" <?= ($order['order_status'] === 'processing') ? 'selected' : ''; ?>>Processing (Order Confirmed by Admin)</option>
                <option value="shipped" <?= ($order['order_status'] === 'shipped') ? 'selected' : ''; ?>>Shipped (Dispatched via Courier)</option>
                <option value="delivered" <?= ($order['order_status'] === 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                <option value="cancelled" <?= ($order['order_status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold" for="payment_status">Payment Status</label>
              <select name="payment_status" id="payment_status" class="form-select">
                <option value="pending" <?= ($order['payment_status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="paid" <?= ($order['payment_status'] === 'paid') ? 'selected' : ''; ?>>Paid</option>
                <option value="failed" <?= ($order['payment_status'] === 'failed') ? 'selected' : ''; ?>>Failed</option>
                <option value="refunded" <?= ($order['payment_status'] === 'refunded') ? 'selected' : ''; ?>>Refunded</option>
              </select>
            </div>

            <!-- Third-Party Courier Details (DTDC, Xpressbees, etc.) -->
            <div class="border rounded p-3 mb-3 bg-light" id="courier-details-box">
              <h6 class="fw-bold mb-2 text-dark" style="font-size: 13px;">
                <i class="fa-solid fa-truck-fast text-primary me-1"></i> Third-Party Courier Dispatch
              </h6>

              <div class="mb-2">
                <label class="form-label small fw-semibold" for="courier_select">Courier Partner</label>
                <select id="courier_select" class="form-select form-select-sm" onchange="onCourierChange(this.value)">
                  <?php $curr_c = $order['courier_name'] ?? ''; ?>
                  <option value="">-- Select Courier Partner --</option>
                  <option value="DTDC" <?= ($curr_c === 'DTDC') ? 'selected' : ''; ?>>DTDC Express</option>
                  <option value="Xpressbees" <?= ($curr_c === 'Xpressbees') ? 'selected' : ''; ?>>Xpressbees</option>
                  <option value="Delhivery" <?= ($curr_c === 'Delhivery') ? 'selected' : ''; ?>>Delhivery</option>
                  <option value="Blue Dart" <?= ($curr_c === 'Blue Dart') ? 'selected' : ''; ?>>Blue Dart</option>
                  <option value="Ekart Logistics" <?= ($curr_c === 'Ekart Logistics') ? 'selected' : ''; ?>>Ekart Logistics</option>
                  <option value="India Post / Speed Post" <?= ($curr_c === 'India Post / Speed Post') ? 'selected' : ''; ?>>India Post / Speed Post</option>
                  <option value="Shadowfax" <?= ($curr_c === 'Shadowfax') ? 'selected' : ''; ?>>Shadowfax</option>
                  <option value="custom" <?= (!empty($curr_c) && !in_array($curr_c, ['DTDC', 'Xpressbees', 'Delhivery', 'Blue Dart', 'Ekart Logistics', 'India Post / Speed Post', 'Shadowfax'])) ? 'selected' : ''; ?>>Other / Custom</option>
                </select>
                <input type="text" name="courier_name" id="courier_name" class="form-control form-control-sm mt-1 <?= (in_array($curr_c, ['DTDC', 'Xpressbees', 'Delhivery', 'Blue Dart', 'Ekart Logistics', 'India Post / Speed Post', 'Shadowfax'])) ? 'd-none' : ''; ?>" placeholder="Courier Company Name" value="<?= html_escape($curr_c); ?>">
              </div>

              <div class="mb-2">
                <label class="form-label small fw-semibold" for="tracking_number">AWB / Tracking Number</label>
                <input type="text" name="tracking_number" id="tracking_number" class="form-control form-control-sm" placeholder="e.g. DTDC123456789 or 14324234" value="<?= html_escape($order['tracking_number'] ?? ''); ?>" oninput="onAwbInput(this.value)">
              </div>

              <div class="mb-0">
                <label class="form-label small fw-semibold" for="tracking_url">Website Tracking Link</label>
                <input type="url" name="tracking_url" id="tracking_url" class="form-control form-control-sm" placeholder="https://www.dtdc.in/tracking.asp" value="<?= html_escape($order['tracking_url'] ?? ''); ?>">
                <small class="text-muted" style="font-size: 11px;">Customer can track directly using this link with their AWB number.</small>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
              <i class="fa-solid fa-check me-1"></i> Update Order
            </button>
          </form>

          <script>
          function onCourierChange(val) {
            var nameInput = document.getElementById('courier_name');
            var urlInput = document.getElementById('tracking_url');
            var awb = document.getElementById('tracking_number').value.trim();

            if (val === 'custom') {
              nameInput.classList.remove('d-none');
              nameInput.focus();
            } else if (val) {
              nameInput.value = val;
              nameInput.classList.add('d-none');
              updateCourierUrl(val, awb);
            }
          }

          function onAwbInput(awb) {
            var courier = document.getElementById('courier_name').value.trim();
            if (courier && !document.getElementById('tracking_url').value.includes('http')) {
              updateCourierUrl(courier, awb);
            }
          }

          function updateCourierUrl(courier, awb) {
            var urlInput = document.getElementById('tracking_url');
            var c = courier.toLowerCase();
            if (c.indexOf('xpress') !== -1) {
              urlInput.value = awb ? 'https://www.xpressbees.com/shipment/tracking?awbNo=' + encodeURIComponent(awb) : 'https://www.xpressbees.com/';
            } else if (c.indexOf('delhivery') !== -1) {
              urlInput.value = awb ? 'https://www.delhivery.com/track/package/' + encodeURIComponent(awb) : 'https://www.delhivery.com/';
            } else if (c.indexOf('dtdc') !== -1) {
              urlInput.value = 'https://www.dtdc.in/tracking.asp';
            } else if (c.indexOf('blue') !== -1) {
              urlInput.value = 'https://www.bluedart.com/tracking';
            } else if (c.indexOf('ekart') !== -1) {
              urlInput.value = awb ? 'https://ekartlogistics.com/shipmenttrack/' + encodeURIComponent(awb) : 'https://ekartlogistics.com/';
            } else if (c.indexOf('shadowfax') !== -1) {
              urlInput.value = awb ? 'https://tracker.shadowfax.in/#/track?awb=' + encodeURIComponent(awb) : 'https://tracker.shadowfax.in/';
            } else if (c.indexOf('speed') !== -1 || c.indexOf('post') !== -1) {
              urlInput.value = 'https://www.indiapost.gov.in/_layouts/15/dpt.cept.tracking/trackconsignment.aspx';
            }
          }
          </script>
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
