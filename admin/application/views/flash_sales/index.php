<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Marketing /</span> Flash Sales & Campaigns</h4>
  </div>

  <div class="row">
    <!-- Form -->
    <div class="col-md-5 mb-4">
      <div class="card">
        <div class="card-header pb-2">
          <h5 class="card-title mb-0" id="fs-form-title">Create Flash Sale Event</h5>
          <small class="text-muted">Set up time-limited flash promotions with countdown timers.</small>
        </div>
        <div class="card-body pt-3">
          <form action="<?= site_url('flash_sales'); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="fs_id" value="">

            <div class="mb-3">
              <label class="form-label" for="fs_title">Campaign Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="fs_title" name="title" placeholder="e.g. Summer Weekend Flash Madness" required>
            </div>

            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label" for="fs_disc">Discount (%)</label>
                <input type="number" step="0.01" class="form-control" id="fs_disc" name="discount_percent" value="30.00">
              </div>
              <div class="col-6 mb-3">
                <label class="form-label" for="fs_status">Status</label>
                <select class="form-select" id="fs_status" name="status">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label" for="fs_start">Start Date/Time</label>
                <input type="datetime-local" class="form-control" id="fs_start" name="start_time" value="<?= date('Y-m-d\TH:i'); ?>" required>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label" for="fs_end">End Date/Time</label>
                <input type="datetime-local" class="form-control" id="fs_end" name="end_time" value="<?= date('Y-m-d\TH:i', strtotime('+7 days')); ?>" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="fs_banner">Campaign Banner Image</label>
              <input type="file" class="form-control" id="fs_banner" name="banner_file" accept="image/*" onchange="previewFsBanner(this)">
              <input type="hidden" name="current_banner" id="fs_current_banner" value="">
              <small class="text-muted">Recommended: Wide banner (e.g. 1200x400px).</small>
              <div class="mt-2" id="fs_preview_box" style="display: none;">
                <small class="text-muted d-block mb-1">Preview:</small>
                <img id="fs_preview_img" src="" alt="Campaign Banner" class="rounded border" style="max-width: 100%; max-height: 100px; object-fit: cover;">
              </div>
            </div>

            <!-- Products Multi-select -->
            <div class="mb-3">
              <label class="form-label fw-bold">Select Products for Flash Sale</label>
              <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                <?php if (!empty($products)): ?>
                  <?php foreach ($products as $p): ?>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $p['id']; ?>" id="p_check_<?= $p['id']; ?>">
                      <label class="form-check-label d-flex justify-content-between small" for="p_check_<?= $p['id']; ?>">
                        <span class="text-truncate" style="max-width: 220px;"><?= html_escape($p['title']); ?></span>
                        <strong>$<?= number_format($p['price'], 2); ?></strong>
                      </label>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Save Campaign</button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFsForm()">Reset</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="col-md-7">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Flash Sale Campaigns</h5>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Title</th>
                <th>Discount</th>
                <th>Period</th>
                <th>Products</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($flash_sales)): ?>
                <?php foreach ($flash_sales as $fs): ?>
                  <tr>
                    <td><strong><?= html_escape($fs['title']); ?></strong></td>
                    <td><span class="badge bg-label-danger"><?= (float)$fs['discount_percent']; ?>% OFF</span></td>
                    <td>
                      <small class="d-block text-muted">From: <?= date('M d, H:i', strtotime($fs['start_time'])); ?></small>
                      <small class="d-block text-muted">To: <?= date('M d, H:i', strtotime($fs['end_time'])); ?></small>
                    </td>
                    <td><span class="badge bg-label-primary"><?= $fs['products_count']; ?> Items</span></td>
                    <td>
                      <?php 
                        $now = time();
                        $end = strtotime($fs['end_time']);
                        if ($fs['status'] === 'active' && $end >= $now): 
                      ?>
                        <span class="badge bg-label-success">Running</span>
                      <?php elseif ($end < $now): ?>
                        <span class="badge bg-label-secondary">Expired</span>
                      <?php else: ?>
                        <span class="badge bg-label-warning">Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-xs btn-outline-primary me-1"
                        onclick="editFlashSale(<?= htmlspecialchars(json_encode($fs), ENT_QUOTES, 'UTF-8'); ?>)"
                        title="Edit Flash Sale">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a href="<?= site_url('flash_sales/delete/' . $fs['id']); ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Delete this campaign?');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No flash sales created yet.</td>
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
function previewFsBanner(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('fs_preview_img').src = e.target.result;
      document.getElementById('fs_preview_box').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function editFlashSale(fs) {
  document.getElementById('fs-form-title').innerText = 'Edit Campaign: ' + fs.title;
  document.getElementById('fs_id').value = fs.id;
  document.getElementById('fs_title').value = fs.title;
  document.getElementById('fs_disc').value = fs.discount_percent || '30.00';
  document.getElementById('fs_status').value = fs.status || 'active';
  if (fs.start_time) {
    document.getElementById('fs_start').value = fs.start_time.replace(' ', 'T').substring(0, 16);
  }
  if (fs.end_time) {
    document.getElementById('fs_end').value = fs.end_time.replace(' ', 'T').substring(0, 16);
  }
  document.getElementById('fs_current_banner').value = fs.banner || '';
  document.getElementById('fs_banner').value = '';

  const prevBox = document.getElementById('fs_preview_box');
  const prevImg = document.getElementById('fs_preview_img');
  if (fs.banner) {
    prevImg.src = '<?= base_url('../website/assets/images/'); ?>' + fs.banner;
    prevBox.style.display = 'block';
  } else {
    prevBox.style.display = 'none';
  }
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetFsForm() {
  document.getElementById('fs-form-title').innerText = 'Create Flash Sale Event';
  document.getElementById('fs_id').value = '';
  document.getElementById('fs_title').value = '';
  document.getElementById('fs_disc').value = '30.00';
  document.getElementById('fs_current_banner').value = '';
  document.getElementById('fs_banner').value = '';
  document.getElementById('fs_preview_box').style.display = 'none';
  document.getElementById('fs_preview_img').src = '';
  document.querySelectorAll('input[name="product_ids[]"]').forEach(function(c) { c.checked = false; });
}
</script>
