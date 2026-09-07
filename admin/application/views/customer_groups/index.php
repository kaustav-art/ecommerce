<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Customers /</span> Customer Groups & Tiers</h4>
  </div>

  <div class="row">
    <!-- Form -->
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-header pb-2">
          <h5 class="card-title mb-0" id="group-form-title">Add Customer Group</h5>
          <small class="text-muted">Create membership tiers with automatic checkout discounts.</small>
        </div>
        <div class="card-body pt-3">
          <form action="<?= site_url('customer_groups'); ?>" method="POST">
            <input type="hidden" name="id" id="group_id" value="">

            <div class="mb-3">
              <label class="form-label" for="group_name">Group Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="group_name" name="name" placeholder="e.g. VIP Club, Wholesale B2B" required>
            </div>

            <div class="mb-3">
              <label class="form-label" for="group_disc">Discount Percentage (%) <span class="text-danger">*</span></label>
              <input type="number" step="0.01" class="form-control" id="group_disc" name="discount_percent" value="0.00" required>
              <small class="text-muted">Discount automatically deducted at checkout for members.</small>
            </div>

            <div class="mb-3">
              <label class="form-label" for="group_desc">Description</label>
              <textarea class="form-control" id="group_desc" name="description" rows="3" placeholder="Tier perks and eligibility..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Save Group</button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetGroupForm()">Reset</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Customer Tiers List</h5>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Group Name</th>
                <th>Discount</th>
                <th>Members</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($groups)): ?>
                <?php foreach ($groups as $g): ?>
                  <tr>
                    <td><strong><?= html_escape($g['name']); ?></strong></td>
                    <td><span class="badge bg-label-success fs-6"><?= number_format($g['discount_percent'], 1); ?>% OFF</span></td>
                    <td><span class="badge bg-label-primary"><?= $g['customers_count']; ?> Customers</span></td>
                    <td><span class="text-muted small"><?= html_escape($g['description']); ?></span></td>
                    <td>
                      <button type="button" class="btn btn-xs btn-outline-primary me-1" onclick="editGroup(<?= htmlspecialchars(json_encode($g), ENT_QUOTES, 'UTF-8'); ?>)">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a href="<?= site_url('customer_groups/delete/' . $g['id']); ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Delete this group? Member customers will be reset to default tier.');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">No customer groups created yet.</td>
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
function editGroup(g) {
  document.getElementById('group-form-title').innerText = 'Edit Group: ' + g.name;
  document.getElementById('group_id').value = g.id;
  document.getElementById('group_name').value = g.name;
  document.getElementById('group_disc').value = g.discount_percent;
  document.getElementById('group_desc').value = g.description || '';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetGroupForm() {
  document.getElementById('group-form-title').innerText = 'Add Customer Group';
  document.getElementById('group_id').value = '';
  document.getElementById('group_name').value = '';
  document.getElementById('group_disc').value = '0.00';
  document.getElementById('group_desc').value = '';
}
</script>
