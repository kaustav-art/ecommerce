<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Users /</span> Customers</h4>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Customer</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Orders</th>
            <th>Total Spent</th>
            <th>Status</th>
            <th>Registered</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $c): ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <span class="avatar-initial rounded-circle bg-label-primary">
                        <?= strtoupper(substr($c['first_name'], 0, 1)); ?>
                      </span>
                    </div>
                    <strong><?= html_escape($c['first_name'] . ' ' . $c['last_name']); ?></strong>
                  </div>
                </td>
                <td><?= html_escape($c['email']); ?></td>
                <td><?= html_escape($c['phone'] ?? 'N/A'); ?></td>
                <td><span class="badge bg-label-info"><?= $c['orders_count']; ?> Orders</span></td>
                <td><strong><?= $currency_symbol . number_format($c['total_spent'], 2); ?></strong></td>
                <td>
                  <span class="badge bg-label-<?= ($c['status'] === 'active') ? 'success' : 'danger'; ?>">
                    <?= ucfirst($c['status']); ?>
                  </span>
                </td>
                <td><small class="text-muted"><?= date('M d, Y', strtotime($c['created_at'])); ?></small></td>
                <td>
                  <a href="<?= site_url('customers/view/' . $c['id']); ?>" class="btn btn-xs btn-outline-primary me-1">
                    <i class="fa-solid fa-eye me-1"></i> View
                  </a>
                  <?php if ($this->can('customers.manage')): ?>
                    <a
                      href="<?= site_url('customers/toggle_status/' . $c['id']); ?>"
                      class="btn btn-xs btn-outline-<?= ($c['status'] === 'active') ? 'danger' : 'success'; ?>">
                      <?= ($c['status'] === 'active') ? 'Ban' : 'Activate'; ?>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center text-muted py-4">No customers registered yet.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
