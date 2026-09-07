<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Catalog / Attributes /</span> <?= html_escape($attribute['name']); ?></h4>
      <small class="text-muted">Type: <span class="badge bg-label-info"><?= ucfirst($attribute['type']); ?></span></small>
    </div>
    <a href="<?= site_url('attributes'); ?>" class="btn btn-outline-secondary btn-sm">
      <i class="fa-solid fa-arrow-left me-1"></i> Back to Attributes
    </a>
  </div>

  <div class="row">
    <!-- Form: Add Value -->
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-header pb-2">
          <h5 class="card-title mb-0">Add New Value</h5>
        </div>
        <div class="card-body pt-3">
          <form action="<?= site_url('attributes/values/' . $attribute['id']); ?>" method="POST">
            <div class="mb-3">
              <label class="form-label" for="val_title">Value / Label <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="val_title" name="value" placeholder="e.g. Red, XL, 16GB, 500g" required>
            </div>

            <?php if ($attribute['type'] === 'color'): ?>
              <div class="mb-3">
                <label class="form-label" for="val_color">Color Hex Code</label>
                <div class="input-group">
                  <input type="color" class="form-control form-control-color" id="val_color_picker" value="#0d6efd" onchange="document.getElementById('val_color').value=this.value;">
                  <input type="text" class="form-control" id="val_color" name="color_code" placeholder="#0d6efd" value="#0d6efd">
                </div>
              </div>
            <?php endif; ?>

            <div class="mb-3">
              <label class="form-label" for="val_sort">Sort Order</label>
              <input type="number" class="form-control" id="val_sort" name="sort_order" value="0">
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Value</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table: Values List -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Values for <?= html_escape($attribute['name']); ?></h5>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Value</th>
                <?php if ($attribute['type'] === 'color'): ?>
                  <th>Preview Swatch</th>
                  <th>Color Code</th>
                <?php endif; ?>
                <th>Sort Order</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($attribute['values'])): ?>
                <?php foreach ($attribute['values'] as $v): ?>
                  <tr>
                    <td><strong><?= html_escape($v['value']); ?></strong></td>
                    <?php if ($attribute['type'] === 'color'): ?>
                      <td>
                        <span class="d-inline-block rounded-circle border shadow-sm" style="width: 24px; height: 24px; background-color: <?= html_escape($v['color_code'] ?: '#ccc'); ?>;"></span>
                      </td>
                      <td><code><?= html_escape($v['color_code']); ?></code></td>
                    <?php endif; ?>
                    <td><?= $v['sort_order']; ?></td>
                    <td>
                      <a href="<?= site_url('attributes/delete_value/' . $attribute['id'] . '/' . $v['id']); ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Remove this value?');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">No values added yet for this attribute.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
