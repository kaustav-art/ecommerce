<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Marketing /</span> Coupons & Discounts</h4>
  </div>

  <div class="row">
    <!-- Form -->
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-header pb-2">
          <h5 class="card-title mb-0" id="coupon-form-title">Create Coupon</h5>
          <small class="text-muted">Generate promotional promo codes for cart checkout.</small>
        </div>
        <div class="card-body pt-3">
          <form action="<?= site_url('coupons'); ?>" method="POST">
            <input type="hidden" name="id" id="coupon_id" value="">

            <div class="mb-3">
              <label class="form-label" for="c_code">Coupon Code <span class="text-danger">*</span></label>
              <input type="text" class="form-control text-uppercase" id="c_code" name="code" placeholder="e.g. FLASH30, SAVE50" required>
            </div>

            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label" for="c_type">Discount Type</label>
                <select class="form-select" id="c_type" name="discount_type">
                  <option value="percent">Percentage (%)</option>
                  <option value="fixed">Fixed Amount ($)</option>
                </select>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label" for="c_val">Value <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control" id="c_val" name="discount_value" required placeholder="e.g. 20">
              </div>
            </div>

            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label" for="c_min">Min Spend ($)</label>
                <input type="number" step="0.01" class="form-control" id="c_min" name="min_spend" value="0.00">
              </div>
              <div class="col-6 mb-3">
                <label class="form-label" for="c_limit">Usage Limit</label>
                <input type="number" class="form-control" id="c_limit" name="usage_limit" value="100">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="c_exp">Expiration Date</label>
              <input type="date" class="form-control" id="c_exp" name="expires_at">
            </div>

            <div class="mb-3">
              <label class="form-label" for="c_status">Status</label>
              <select class="form-select" id="c_status" name="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Save Coupon</button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetCouponForm()">Reset</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Active Promotional Coupons</h5>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Code</th>
                <th>Discount</th>
                <th>Min Spend</th>
                <th>Redeemed</th>
                <th>Expires</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($coupons)): ?>
                <?php foreach ($coupons as $c): ?>
                  <tr>
                    <td><code><?= html_escape($c['code']); ?></code></td>
                    <td>
                      <strong><?= ($c['discount_type'] === 'percent') ? (float)$c['discount_value'] . '%' : '$' . number_format($c['discount_value'], 2); ?> OFF</strong>
                    </td>
                    <td>$<?= number_format($c['min_spend'], 2); ?></td>
                    <td><span class="badge bg-label-secondary"><?= $c['used_count']; ?> / <?= $c['usage_limit']; ?></span></td>
                    <td>
                      <?php if (!empty($c['expires_at'])): ?>
                        <small class="<?= (strtotime($c['expires_at']) < time()) ? 'text-danger fw-bold' : 'text-muted'; ?>">
                          <?= date('M d, Y', strtotime($c['expires_at'])); ?>
                        </small>
                      <?php else: ?>
                        <span class="text-muted small">No Expiry</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?= ($c['status'] === 'active') ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-secondary">Inactive</span>'; ?>
                    </td>
                    <td>
                      <button type="button" class="btn btn-xs btn-outline-primary me-1" onclick="editCoupon(<?= htmlspecialchars(json_encode($c), ENT_QUOTES, 'UTF-8'); ?>)">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a href="<?= site_url('coupons/delete/' . $c['id']); ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Delete this coupon?');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">No coupons created yet.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function editCoupon(c) {
  document.getElementById('coupon-form-title').innerText = 'Edit Coupon: ' + c.code;
  document.getElementById('coupon_id').value = c.id;
  document.getElementById('c_code').value = c.code;
  document.getElementById('c_type').value = c.discount_type;
  document.getElementById('c_val').value = c.discount_value;
  document.getElementById('c_min').value = c.min_spend;
  document.getElementById('c_limit').value = c.usage_limit;
  document.getElementById('c_exp').value = c.expires_at || '';
  document.getElementById('c_status').value = c.status;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetCouponForm() {
  document.getElementById('coupon-form-title').innerText = 'Create Coupon';
  document.getElementById('coupon_id').value = '';
  document.getElementById('c_code').value = '';
  document.getElementById('c_type').value = 'percent';
  document.getElementById('c_val').value = '';
  document.getElementById('c_min').value = '0.00';
  document.getElementById('c_limit').value = '100';
  document.getElementById('c_exp').value = '';
  document.getElementById('c_status').value = 'active';
}
</script>
