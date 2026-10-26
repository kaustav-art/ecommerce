<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Catalog /</span> Product Attributes</h4>
  </div>

  <div class="row">
    <!-- Form: Add/Edit Attribute -->
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-header pb-2">
          <h5 class="card-title mb-0" id="attr-form-title">Add Attribute</h5>
          <small class="text-muted">Define generic attributes for any category (Fashion, Electronics, Grocery, etc.)</small>
        </div>
        <div class="card-body pt-3">
          <form action="<?= site_url('attributes'); ?>" method="POST">
            <input type="hidden" name="id" id="attr_id" value="">

            <div class="mb-3">
              <label class="form-label" for="attr_name">Attribute Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="attr_name" name="name" placeholder="e.g. Color, Size, RAM, Storage, Weight" required>
            </div>

            <div class="mb-3">
              <label class="form-label" for="attr_type">Display Type</label>
              <select class="form-select" id="attr_type" name="type">
                <option value="select">Dropdown Select</option>
                <option value="multiple_select">Multiple Select</option>
                <option value="button">Button / Swatch (Pill)</option>
                <option value="color">Color Swatch (Hex / Visual)</option>
                <option value="text">Custom Text</option>
              </select>
              <div id="attr_type_locked_alert" class="alert alert-warning py-2 px-3 mt-2 small" style="display: none;">
                <i class="fa-solid fa-lock me-1"></i>
                <span>Display Type is <strong>locked</strong> because this attribute is currently used in <strong id="attr_locked_product_count">0</strong> product(s).</span>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Save Attribute</button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetAttrForm()">Reset</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table: Attributes List -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Dynamic Attributes List</h5>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Attribute</th>
                <th>Slug</th>
                <th>Type</th>
                <th>Values</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($attributes)): ?>
                <?php foreach ($attributes as $a): ?>
                  <tr>
                    <td><strong><?= html_escape($a['name']); ?></strong></td>
                    <td><code><?= html_escape($a['slug']); ?></code></td>
                    <td>
                      <span class="badge bg-label-info"><?= ($a['type'] === 'multiselect') ? 'Multiple Select' : ucwords(str_replace('_', ' ', $a['type'])); ?></span>
                      <?php if (!empty($a['is_locked'])): ?>
                        <span class="badge bg-label-warning ms-1" title="In use by <?= $a['products_count']; ?> product(s) - Display type locked">
                          <i class="fa-solid fa-lock" style="font-size: 10px;"></i> <?= $a['products_count']; ?> Prod
                        </span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="<?= site_url('attributes/values/' . $a['id']); ?>" class="badge bg-primary text-white text-decoration-none">
                        <?= $a['values_count']; ?> Values &raquo;
                      </a>
                    </td>
                    <td>
                      <a href="<?= site_url('attributes/values/' . $a['id']); ?>" class="btn btn-xs btn-outline-info me-1" title="Manage Values">
                        <i class="fa-solid fa-list-check me-1"></i> Values
                      </a>
                      <button type="button" class="btn btn-xs btn-outline-primary me-1" onclick="editAttr(<?= htmlspecialchars(json_encode($a), ENT_QUOTES, 'UTF-8'); ?>)">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a href="<?= site_url('attributes/delete/' . $a['id']); ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Delete this attribute and all associated values?');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">No attributes created yet.</td>
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
function editAttr(a) {
  document.getElementById('attr-form-title').innerText = 'Edit Attribute: ' + a.name;
  document.getElementById('attr_id').value = a.id;
  document.getElementById('attr_name').value = a.name;
  var typeSelect = document.getElementById('attr_type');
  typeSelect.value = a.type;
  if (!typeSelect.value && (a.type === 'multiselect' || a.type === 'multiple')) {
    typeSelect.value = 'multiple_select';
  }

  // Lock Display Type if attribute is used in products
  var lockedAlert = document.getElementById('attr_type_locked_alert');
  var lockedCount = document.getElementById('attr_locked_product_count');
  if (a.is_locked || (a.products_count && parseInt(a.products_count, 10) > 0)) {
    typeSelect.disabled = true;
    typeSelect.title = "Display type cannot be changed because this attribute is used in products";
    if (lockedAlert) {
      lockedAlert.style.display = 'block';
      if (lockedCount) lockedCount.innerText = a.products_count;
    }
  } else {
    typeSelect.disabled = false;
    typeSelect.title = "";
    if (lockedAlert) lockedAlert.style.display = 'none';
  }

  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetAttrForm() {
  document.getElementById('attr-form-title').innerText = 'Add Attribute';
  document.getElementById('attr_id').value = '';
  document.getElementById('attr_name').value = '';
  var typeSelect = document.getElementById('attr_type');
  typeSelect.value = 'select';
  typeSelect.disabled = false;
  typeSelect.title = "";
  var lockedAlert = document.getElementById('attr_type_locked_alert');
  if (lockedAlert) lockedAlert.style.display = 'none';
}
</script>
