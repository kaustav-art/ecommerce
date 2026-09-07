<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Catalog /</span> Brands</h4>
  </div>

  <div class="row">
    <!-- Add / Edit Form -->
    <div class="col-md-4">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="card-title mb-0" id="brand-form-title">Add Brand</h5>
        </div>
        <div class="card-body">
          <form action="<?= site_url('brands'); ?>" method="POST">
            <input type="hidden" name="id" id="brand_id" value="" />
            <div class="mb-3">
              <label class="form-label" for="brand_name">Brand Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="brand_name" name="name" required placeholder="e.g. Nike" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="brand_logo">Logo Path</label>
              <input type="text" class="form-control" id="brand_logo" name="logo" placeholder="brand/brand-01.svg" />
              <small class="text-muted">Relative path in website/assets/images/</small>
            </div>
            <button type="submit" class="btn btn-primary w-100">Save Brand</button>
            <button type="button" class="btn btn-outline-secondary w-100 mt-2" onclick="resetBrandForm()">Reset</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Brands Table -->
    <div class="col-md-8">
      <div class="card">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Brand</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($brands)): ?>
                <?php foreach ($brands as $b): ?>
                  <tr>
                    <td><strong><?= html_escape($b['name']); ?></strong></td>
                    <td><code><?= html_escape($b['slug']); ?></code></td>
                    <td><span class="badge bg-label-info"><?= $b['product_count']; ?> Items</span></td>
                    <td><span class="badge bg-label-success"><?= ucfirst($b['status']); ?></span></td>
                    <td>
                      <button
                        class="btn btn-xs btn-outline-primary me-1"
                        onclick="editBrand(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8'); ?>)">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a
                        href="<?= site_url('brands/delete/' . $b['id']); ?>"
                        class="btn btn-xs btn-outline-danger"
                        onclick="return confirm('Delete this brand?');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">No brands registered yet.</td>
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
function editBrand(b) {
  document.getElementById('brand-form-title').innerText = 'Edit Brand: ' + b.name;
  document.getElementById('brand_id').value = b.id;
  document.getElementById('brand_name').value = b.name;
  document.getElementById('brand_logo').value = b.logo || '';
}

function resetBrandForm() {
  document.getElementById('brand-form-title').innerText = 'Add Brand';
  document.getElementById('brand_id').value = '';
  document.getElementById('brand_name').value = '';
  document.getElementById('brand_logo').value = '';
}
</script>
