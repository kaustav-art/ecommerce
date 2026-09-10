<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Sales /</span> Orders</h4>
  </div>

  <!-- Filter tabs -->
  <div class="card mb-4">
    <div class="card-body py-2">
      <div class="d-flex flex-wrap gap-2">
        <a href="<?= site_url('orders'); ?>" class="btn btn-sm <?= empty($selected_status) ? 'btn-primary' : 'btn-outline-secondary'; ?>">All Orders</a>
        <a href="<?= site_url('orders?status=pending'); ?>" class="btn btn-sm <?= ($selected_status === 'pending') ? 'btn-warning' : 'btn-outline-secondary'; ?>">Pending</a>
        <a href="<?= site_url('orders?status=processing'); ?>" class="btn btn-sm <?= ($selected_status === 'processing') ? 'btn-info' : 'btn-outline-secondary'; ?>">Processing</a>
        <a href="<?= site_url('orders?status=shipped'); ?>" class="btn btn-sm <?= ($selected_status === 'shipped') ? 'btn-primary' : 'btn-outline-secondary'; ?>">Shipped</a>
        <a href="<?= site_url('orders?status=delivered'); ?>" class="btn btn-sm <?= ($selected_status === 'delivered') ? 'btn-success' : 'btn-outline-secondary'; ?>">Delivered</a>
        <a href="<?= site_url('orders?status=cancelled'); ?>" class="btn btn-sm <?= ($selected_status === 'cancelled') ? 'btn-danger' : 'btn-outline-secondary'; ?>">Cancelled</a>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Gateway</th>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $ord): ?>
              <tr>
                <td><strong>#<?= html_escape($ord['order_number']); ?></strong></td>
                <td><small class="text-muted"><?= date('M d, Y h:i A', strtotime($ord['created_at'])); ?></small></td>
                <td>
                  <div><?= html_escape($ord['customer_name']); ?></div>
                  <small class="text-muted"><?= html_escape($ord['customer_email']); ?></small>
                </td>
                <td><strong><?= $currency_symbol . number_format($ord['total_amount'], 2); ?></strong></td>
                <td><span class="badge bg-label-dark"><?= strtoupper($ord['payment_method']); ?></span></td>
                <td>
                  <span class="badge bg-label-<?= ($ord['payment_status'] === 'paid') ? 'success' : 'warning'; ?>">
                    <?= ucfirst($ord['payment_status']); ?>
                  </span>
                </td>
                <td>
                  <?php
                    $cls = 'secondary';
                    if ($ord['order_status'] === 'delivered') $cls = 'success';
                    elseif ($ord['order_status'] === 'shipped') $cls = 'primary';
                    elseif ($ord['order_status'] === 'processing') $cls = 'info';
                    elseif ($ord['order_status'] === 'pending') $cls = 'warning';
                    elseif ($ord['order_status'] === 'cancelled') $cls = 'danger';
                  ?>
                  <span class="badge bg-<?= $cls; ?>"><?= ucfirst($ord['order_status']); ?></span>
                </td>
                <td>
                  <a href="<?= site_url('orders/view/' . $ord['id']); ?>" class="btn btn-xs btn-outline-primary me-1" title="View Order">
                    <i class="fa-solid fa-eye me-1"></i> Details
                  </a>
                  <?php $is_confirmed = in_array(strtolower($ord['order_status']), ['processing', 'shipped', 'delivered', 'completed']); ?>
                  <?php if ($is_confirmed): ?>
                    <a href="<?= site_url('orders/invoice/' . $ord['id']); ?>" target="_blank" class="btn btn-xs btn-outline-secondary" title="Download Invoice">
                      <i class="fa-solid fa-file-invoice"></i>
                    </a>
                  <?php else: ?>
                    <span class="btn btn-xs btn-outline-secondary disabled opacity-50" title="Invoice available after order confirmed" style="cursor: not-allowed;">
                      <i class="fa-solid fa-file-invoice"></i>
                    </span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center text-muted py-4">No orders found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
