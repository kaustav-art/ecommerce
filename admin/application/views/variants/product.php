<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Catalog / Products /</span> Variants for <?= html_escape($product['title']); ?></h4>
      <small class="text-muted">SKU: <code><?= html_escape($product['sku']); ?></code> | Base Price: $<?= number_format($product['price'], 2); ?></small>
    </div>
    <div>
      <a href="<?= site_url('products/edit/' . $product['id']); ?>" class="btn btn-outline-secondary btn-sm me-2">
        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Product
      </a>
      <a href="<?= site_url('products'); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Form: Add/Edit Variant -->
    <div class="col-lg-4 mb-4">
      <div class="card">
        <div class="card-header pb-2">
          <h5 class="card-title mb-0" id="variant-form-title">Add Product Variant</h5>
          <small class="text-muted">Configure variant-specific title, SKU, price, stock, and attributes.</small>
        </div>
        <div class="card-body pt-3">
          <form action="<?= site_url('variants/product/' . $product['id']); ?>" method="POST">
            <input type="hidden" name="id" id="var_id" value="">

            <div class="mb-3">
              <label class="form-label" for="var_title">Variant Title / Name</label>
              <input type="text" class="form-control" id="var_title" name="title" placeholder="e.g. Red / XL or 16GB / 512GB" required>
            </div>

            <div class="mb-3">
              <label class="form-label" for="var_sku">Variant SKU <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="var_sku" name="sku" placeholder="e.g. <?= html_escape($product['sku']); ?>-RED-XL" required>
            </div>

            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label" for="var_price">Regular Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control" id="var_price" name="price" value="<?= $product['price']; ?>" required>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label" for="var_sale_price">Sale Price</label>
                <input type="number" step="0.01" class="form-control" id="var_sale_price" name="sale_price" value="<?= $product['sale_price']; ?>">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="var_stock">Stock Quantity <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="var_stock" name="stock_quantity" value="10" required>
            </div>

            <div class="mb-3">
              <label class="form-label" for="var_image">Variant Image Path</label>
              <input type="text" class="form-control" id="var_image" name="image" value="<?= html_escape($product['main_image']); ?>" placeholder="products/womens/women-1.jpg">
            </div>

            <!-- Dynamic Attributes selector -->
            <?php if (!empty($attributes)): ?>
              <div class="border rounded p-3 bg-light mb-3">
                <label class="form-label fw-bold mb-2">Assign Attributes</label>
                <?php foreach ($attributes as $attr): ?>
                  <?php if (!empty($attr['values'])): ?>
                    <div class="mb-2">
                      <label class="form-label small text-muted mb-1"><?= html_escape($attr['name']); ?>:</label>
                      <select class="form-select form-select-sm" name="attr_vals[<?= $attr['id']; ?>]" id="attr_val_<?= $attr['id']; ?>">
                        <option value="">-- None / N/A --</option>
                        <?php foreach ($attr['values'] as $v): ?>
                          <option value="<?= $v['id']; ?>"><?= html_escape($v['value']); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100 mb-2">Save Variant</button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetVarForm()">Reset Form</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table: Variants List -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Existing Variants (<?= count($variants); ?>)</h5>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Variant</th>
                <th>SKU</th>
                <th>Attributes</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($variants)): ?>
                <?php foreach ($variants as $v): ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <img src="<?= base_url('../website/assets/images/' . ($v['image'] ?: $product['main_image'])); ?>" class="rounded me-2" style="width: 38px; height: 38px; object-fit: cover;" onerror="this.src='<?= base_url('../website/assets/images/products/womens/women-1.jpg'); ?>'">
                        <strong><?= html_escape($v['title']); ?></strong>
                      </div>
                    </td>
                    <td><code><?= html_escape($v['sku']); ?></code></td>
                    <td>
                      <?php if (!empty($v['values'])): ?>
                        <?php foreach ($v['values'] as $val): ?>
                          <span class="badge bg-label-primary me-1">
                            <?= html_escape($val['attribute_name']); ?>: <?= html_escape($val['attribute_value']); ?>
                          </span>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span class="text-muted small">Standard</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if (!empty($v['sale_price'])): ?>
                        <strong class="text-danger">$<?= number_format($v['sale_price'], 2); ?></strong>
                        <small class="text-muted text-decoration-line-through d-block">$<?= number_format($v['price'], 2); ?></small>
                      <?php else: ?>
                        <strong>$<?= number_format($v['price'], 2); ?></strong>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($v['stock_quantity'] > 0): ?>
                        <span class="badge bg-label-success"><?= $v['stock_quantity']; ?> in stock</span>
                      <?php else: ?>
                        <span class="badge bg-label-danger">Out of stock</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <button type="button" class="btn btn-xs btn-outline-primary me-1" onclick="editVar(<?= htmlspecialchars(json_encode($v), ENT_QUOTES, 'UTF-8'); ?>)">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a href="<?= site_url('variants/delete/' . $product['id'] . '/' . $v['id']); ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Delete this variant?');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No variants defined yet. This product uses its default price and stock.</td>
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
function editVar(v) {
  document.getElementById('variant-form-title').innerText = 'Edit Variant: ' + v.title;
  document.getElementById('var_id').value = v.id;
  document.getElementById('var_title').value = v.title;
  document.getElementById('var_sku').value = v.sku;
  document.getElementById('var_price').value = v.price;
  document.getElementById('var_sale_price').value = v.sale_price || '';
  document.getElementById('var_stock').value = v.stock_quantity;
  document.getElementById('var_image').value = v.image || '';

  // Set attribute values
  if (v.values && v.values.length > 0) {
    v.values.forEach(function(val) {
      var sel = document.getElementById('attr_val_' + val.attribute_id);
      if (sel) {
        sel.value = val.attribute_value_id;
      }
    });
  }
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetVarForm() {
  document.getElementById('variant-form-title').innerText = 'Add Product Variant';
  document.getElementById('var_id').value = '';
  document.getElementById('var_title').value = '';
  document.getElementById('var_sku').value = '';
  document.getElementById('var_price').value = '<?= $product['price']; ?>';
  document.getElementById('var_sale_price').value = '<?= $product['sale_price'] ?: ''; ?>';
  document.getElementById('var_stock').value = '10';
  document.getElementById('var_image').value = '<?= html_escape($product['main_image']); ?>';
  var selects = document.querySelectorAll('select[id^="attr_val_"]');
  selects.forEach(function(s) { s.value = ''; });
}
</script>
