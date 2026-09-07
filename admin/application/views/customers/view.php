<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Customers /</span> <?= html_escape($customer['first_name'] . ' ' . $customer['last_name']); ?></h4>
    <a href="<?= site_url('customers'); ?>" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Back to Customers
    </a>
  </div>

  <div class="row">
    <!-- Customer Profile card -->
    <div class="col-md-4">
      <div class="card mb-4">
        <div class="card-body text-center">
          <div class="avatar avatar-xl mx-auto mb-3">
            <span class="avatar-initial rounded-circle bg-label-primary fs-2">
              <?= strtoupper(substr($customer['first_name'], 0, 1)); ?>
            </span>
          </div>
          <h5 class="mb-1"><?= html_escape($customer['first_name'] . ' ' . $customer['last_name']); ?></h5>
          <p class="text-muted mb-2"><?= html_escape($customer['email']); ?></p>
          <span class="badge bg-label-<?= ($customer['status'] === 'active') ? 'success' : 'danger'; ?>">
            <?= ucfirst($customer['status']); ?>
          </span>

          <div class="d-flex justify-content-around my-4 py-2 border-top border-bottom">
            <div>
              <h5 class="mb-0"><?= count($customer['orders'] ?? []); ?></h5>
              <small class="text-muted">Total Orders</small>
            </div>
            <div>
              <h5 class="mb-0"><?= date('M Y', strtotime($customer['created_at'])); ?></h5>
              <small class="text-muted">Member Since</small>
            </div>
          </div>

          <?php if (!empty($customer['addresses'])): ?>
            <div class="text-start">
              <h6 class="fw-bold mb-2">Saved Addresses:</h6>
              <?php foreach ($customer['addresses'] as $addr): ?>
                <div class="border rounded p-2 mb-2 small text-muted">
                  <strong><?= ucfirst($addr['type']); ?> Address:</strong><br>
                  <?= html_escape($addr['first_name'] . ' ' . $addr['last_name']); ?><br>
                  <?= html_escape($addr['address_1']); ?><br>
                  <?= html_escape($addr['city'] . ', ' . $addr['state'] . ' ' . $addr['postcode']); ?><br>
                  <?= html_escape($addr['country']); ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Orders History -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Customer Order History</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($customer['orders'])): ?>
                <?php foreach ($customer['orders'] as $ord): ?>
                  <tr>
                    <td><strong>#<?= html_escape($ord['order_number']); ?></strong></td>
                    <td><?= date('M d, Y', strtotime($ord['created_at'])); ?></td>
                    <td><?= $currency_symbol . number_format($ord['total_amount'], 2); ?></td>
                    <td><span class="badge bg-label-info"><?= ucfirst($ord['order_status']); ?></span></td>
                    <td><span class="badge bg-label-success"><?= ucfirst($ord['payment_status']); ?></span></td>
                    <td>
                      <a href="<?= site_url('orders/view/' . $ord['id']); ?>" class="btn btn-xs btn-outline-primary">
                        View
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No orders placed by this customer yet.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
