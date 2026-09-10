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
          <form action="<?= site_url('variants/product/' . $product['id']); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="var_id" value="">
            <input type="hidden" name="group_variant_ids" id="var_group_variant_ids" value="">
            <input type="hidden" name="gallery_submitted" value="1">

            <div class="mb-3">
              <label class="form-label" for="var_title">Variant Title / Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="var_title" name="title" placeholder="e.g. VTEXX Men Shirt - Coffee" required>
              <small class="text-muted d-block" style="font-size: 11px;">Base title. When creating multiple sizes, the size will automatically append (e.g. / S, / M).</small>
            </div>

            <div class="mb-3">
              <label class="form-label" for="var_sku">Variant Base SKU <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="var_sku" name="sku" placeholder="e.g. <?= html_escape($product['sku']); ?>-COF" required oninput="updateSkuPreview()">
              <small class="text-muted d-block" style="font-size: 11px;">Base SKU. When creating multiple sizes, the size will automatically append (e.g. -S, -M).</small>
              <div id="sku-preview-helper" class="text-primary small mt-1" style="font-size: 11px; display: none;"></div>
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

            <div class="mb-3" id="var_stock_wrapper">
              <label class="form-label" for="var_stock">Stock Quantity (per variant) <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="var_stock" name="stock_quantity" value="10" required>
              <small class="text-muted d-block" id="var_stock_helper" style="font-size: 11px;">When sizes are selected below, manage stock for each size in the section below.</small>
            </div>

            <!-- Main Variant Image -->
            <div class="mb-3">
              <label class="form-label fw-semibold" for="var_image_file">Variant Main Image</label>
              <div class="d-flex align-items-center gap-3">
                <div class="border rounded p-1 bg-white shadow-sm" style="width: 58px; height: 58px; flex-shrink: 0;">
                  <img
                    id="var_preview_img"
                    src="<?= base_url('../website/assets/images/' . ($product['main_image'] ?: 'products/womens/women-1.jpg')); ?>"
                    class="w-100 h-100 rounded object-fit-cover"
                    alt="Preview"
                    onerror="this.src='<?= base_url('../website/assets/images/products/womens/women-1.jpg'); ?>'"
                  />
                </div>
                <div class="flex-grow-1">
                  <input
                    type="file"
                    class="form-control form-control-sm"
                    id="var_image_file"
                    name="image_file"
                    accept="image/*"
                    onchange="previewVarImage(this)"
                  />
                  <input type="hidden" name="current_image" id="var_current_image" value="<?= html_escape($product['main_image']); ?>">
                  <small class="text-muted d-block" style="font-size: 11px;">Primary photo for this variant color (Max 10MB)</small>
                </div>
              </div>
            </div>

            <!-- Upload Gallery Images for Variant -->
            <div class="mb-3">
              <label class="form-label fw-semibold" for="var_gallery_files">Upload Gallery Images</label>
              <input
                type="file"
                class="form-control form-control-sm"
                id="var_gallery_files"
                name="gallery_files[]"
                accept="image/*"
                multiple
                onchange="handleVarGalleryFiles(this)"
              />
              <small class="text-muted d-block mt-1" style="font-size: 11px;">Select multiple gallery photos for this variant color (Max 10MB each).</small>

              <!-- New Uploads Preview Container with individual remove buttons -->
              <div id="var_new_gallery_container" class="mt-2" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="small fw-semibold text-primary" id="var_new_gallery_count_label">New Selected (0):</span>
                  <button type="button" class="btn btn-link text-danger p-0 small text-decoration-none" style="font-size: 11px;" onclick="clearAllVarGalleryFiles()">
                    <i class="fa-solid fa-trash-can me-1"></i>Clear All New
                  </button>
                </div>
                <div id="var_new_gallery_preview_list" class="d-flex flex-wrap gap-2"></div>
              </div>

              <!-- Existing Variant Gallery Section (When editing variant) -->
              <div class="mt-2" id="var_existing_gallery_wrapper" style="display: none;">
                <label class="form-label small fw-semibold text-secondary mb-1" id="var_existing_gallery_label">
                  Existing Variant Gallery (0):
                </label>
                <div class="d-flex flex-wrap gap-2" id="var_existing_gallery_list"></div>
              </div>
            </div>

            <!-- Dynamic Attributes selector -->
            <?php if (!empty($attributes)): ?>
              <div class="border rounded p-3 bg-light mb-3">
                <label class="form-label fw-bold mb-2">Assign Attributes</label>
                <?php foreach ($attributes as $attr): 
                  $is_size = (strcasecmp($attr['slug'], 'size') === 0 || strcasecmp($attr['name'], 'size') === 0);
                ?>
                  <?php if (!empty($attr['values'])): ?>
                    <?php if ($is_size): ?>
                      <!-- Size Multiple Selector -->
                      <div class="mb-3 p-2 bg-white rounded border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <label class="form-label small fw-bold text-dark mb-0">
                            <?= html_escape($attr['name']); ?> <span class="badge bg-label-info ms-1" style="font-size: 10px;">Multiple Selection</span>
                          </label>
                          <div id="size-quick-actions" class="d-flex gap-2">
                            <a href="javascript:void(0);" class="small text-primary text-decoration-none" style="font-size: 11px;" onclick="selectAllSizes(true)">Select All</a>
                            <span class="text-muted small" style="font-size: 11px;">|</span>
                            <a href="javascript:void(0);" class="small text-secondary text-decoration-none" style="font-size: 11px;" onclick="selectAllSizes(false)">Clear</a>
                          </div>
                        </div>

                        <div class="d-flex flex-wrap gap-1 mb-1" id="size-chips-wrapper">
                          <?php foreach ($attr['values'] as $v): ?>
                            <div class="size-chip-btn border rounded px-2 py-1 text-center" id="size_chip_label_<?= $v['id']; ?>" style="cursor: pointer; min-width: 36px; font-size: 12px; font-weight: 500; user-select: none; transition: all 0.15s ease;" onclick="toggleSizeChip(<?= $v['id']; ?>)">
                              <input type="checkbox" name="size_vals[]" value="<?= $v['id']; ?>" data-val="<?= html_escape($v['value']); ?>" id="size_input_<?= $v['id']; ?>" class="d-none size-chip-checkbox">
                              <span><?= html_escape($v['value']); ?></span>
                            </div>
                          <?php endforeach; ?>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                          <span class="text-muted small" id="selected-sizes-count" style="font-size: 11px;">0 sizes selected</span>
                          <span class="text-muted small fst-italic" style="font-size: 10px;">Manage stock per size</span>
                        </div>

                        <!-- Manage Stock by Size Dynamic Container -->
                        <div id="var_size_stock_manager" class="mt-2 p-2 bg-light rounded border" style="display: none;">
                          <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom flex-wrap gap-1">
                            <span class="small fw-bold text-dark">
                              <i class="fa-solid fa-boxes-stacked text-primary me-1"></i> Stock by Size:
                            </span>
                            <div class="d-flex align-items-center gap-1">
                              <input type="number" min="0" class="form-control form-control-sm text-end p-1" id="quick_var_stock_val" placeholder="10" value="10" style="width: 60px; font-size: 11px;">
                              <button type="button" class="btn btn-outline-primary btn-xs py-0" onclick="applyVarStockToAll()">Set All</button>
                            </div>
                          </div>
                          <div id="var_size_stock_inputs_list" class="d-flex flex-column gap-1">
                            <!-- Populated dynamically -->
                          </div>
                          <div class="d-flex justify-content-between align-items-center mt-2 pt-1 border-top">
                            <small class="text-muted" style="font-size: 11px;">Total Variant Stock:</small>
                            <strong class="text-primary small" id="var_total_sizes_stock">0 units</strong>
                          </div>
                        </div>

                      </div>
                    <?php else: ?>
                      <!-- Standard Attribute (Color, Material, etc.) -->
                      <div class="mb-2">
                        <label class="form-label small text-muted mb-1"><?= html_escape($attr['name']); ?>:</label>
                        <select class="form-select form-select-sm" name="attr_vals[<?= $attr['id']; ?>]" id="attr_val_<?= $attr['id']; ?>" onchange="onNonSizeAttrChange(this, '<?= html_escape($attr['slug']); ?>')">
                          <option value="">-- None / N/A --</option>
                          <?php foreach ($attr['values'] as $v): ?>
                            <option value="<?= $v['id']; ?>" data-name="<?= html_escape($v['value']); ?>"><?= html_escape($v['value']); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100 mb-2" id="btn-save-var">
              <i class="fa-solid fa-floppy-disk me-1"></i> Save Variant
            </button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetVarForm()">
              <i class="fa-solid fa-rotate-left me-1"></i> Reset Form
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table: Variants List (Grouped by Color / Base Variant with Group Size) -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-0">Existing Variants (<?= count($variant_groups); ?> Groups)</h5>
            <small class="text-muted"><?= count($variants); ?> individual size variations total</small>
          </div>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Variant</th>
                <th>Base SKU</th>
                <th>Attributes & Grouped Sizes</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($variant_groups)): ?>
                <?php foreach ($variant_groups as $grp): ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="position-relative me-2" style="width: 44px; height: 44px; flex-shrink: 0;">
                          <img src="<?= base_url('../website/assets/images/' . ($grp['image'] ?: $product['main_image'])); ?>" class="rounded w-100 h-100 object-fit-cover" onerror="this.src='<?= base_url('../website/assets/images/products/womens/women-1.jpg'); ?>'">
                          <?php 
                            $grp_gal = !empty($grp['gallery_images']) ? (is_array($grp['gallery_images']) ? $grp['gallery_images'] : (json_decode($grp['gallery_images'], true) ?: [])) : []; 
                            if (!empty($grp_gal)):
                          ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info" style="font-size: 8px; padding: 2px 4px;" title="<?= count($grp_gal); ?> gallery photos">+<?= count($grp_gal); ?></span>
                          <?php endif; ?>
                        </div>
                        <div>
                          <strong class="d-block text-truncate" style="max-width: 170px;" title="<?= html_escape($grp['title']); ?>"><?= html_escape($grp['title']); ?></strong>
                          <?php if (!empty($grp['non_size_attrs'])): ?>
                            <?php foreach ($grp['non_size_attrs'] as $nsa): ?>
                              <span class="badge bg-label-secondary d-inline-flex align-items-center mt-1" style="font-size: 10px;">
                                <?php if (!empty($nsa['color_code'])): ?>
                                  <span class="rounded-circle me-1" style="width: 8px; height: 8px; background: <?= html_escape($nsa['color_code']); ?>; display: inline-block; border: 1px solid rgba(0,0,0,0.2);"></span>
                                <?php endif; ?>
                                <?= html_escape($nsa['attribute_name']); ?>: <?= html_escape($nsa['attribute_value']); ?>
                              </span>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </div>
                      </div>
                    </td>
                    <td>
                      <code><?= html_escape($grp['base_sku']); ?></code>
                      <?php if ($grp['has_sizes']): ?>
                        <small class="text-muted d-block" style="font-size: 10px;"><?= count($grp['sizes']); ?> size SKUs</small>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($grp['has_sizes'] && !empty($grp['sizes'])): ?>
                        <!-- Grouped Sizes with Individual Stock Badges -->
                        <div class="d-flex flex-wrap gap-1 align-items-center" style="max-width: 260px;">
                          <?php foreach ($grp['sizes'] as $sz): ?>
                            <?php if ($sz['stock'] > 0): ?>
                              <span class="badge bg-label-primary px-2 py-1" style="font-size: 11px;" title="SKU: <?= html_escape($sz['sku']); ?> | Stock: <?= $sz['stock']; ?>">
                                <strong><?= html_escape($sz['size_name']); ?>:</strong> <?= $sz['stock']; ?>
                              </span>
                            <?php else: ?>
                              <span class="badge bg-label-danger text-decoration-line-through px-2 py-1" style="font-size: 11px;" title="SKU: <?= html_escape($sz['sku']); ?> | Out of stock">
                                <strong><?= html_escape($sz['size_name']); ?>:</strong> 0
                              </span>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-link btn-xs p-0 text-primary mt-1 text-decoration-none fw-semibold" style="font-size: 11px;" onclick="openQuickStockModal(<?= htmlspecialchars(json_encode($grp), ENT_QUOTES, 'UTF-8'); ?>)">
                          <i class="fa-solid fa-boxes-stacked me-1"></i>Manage Stock by Size
                        </button>
                      <?php else: ?>
                        <span class="text-muted small">Standard (No sizes)</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if (!empty($grp['sale_price'])): ?>
                        <strong class="text-danger">$<?= number_format($grp['sale_price'], 2); ?></strong>
                        <small class="text-muted text-decoration-line-through d-block">$<?= number_format($grp['price'], 2); ?></small>
                      <?php else: ?>
                        <strong>$<?= number_format($grp['price'], 2); ?></strong>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="d-flex flex-column">
                        <strong class="<?= ($grp['total_stock'] > 0) ? 'text-success' : 'text-danger'; ?>">
                          <?= $grp['total_stock']; ?> in stock
                        </strong>
                        <?php if ($grp['has_sizes']): ?>
                          <small class="text-muted" style="font-size: 10px;">
                            <?= $grp['in_stock_count']; ?> in stock, <?= $grp['out_of_stock_count']; ?> out
                          </small>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td>
                      <button type="button" class="btn btn-xs btn-outline-primary me-1" title="Edit Variant Group" onclick="editVarGroup(<?= htmlspecialchars(json_encode($grp), ENT_QUOTES, 'UTF-8'); ?>)">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <?php if ($grp['has_sizes']): ?>
                        <button type="button" class="btn btn-xs btn-outline-info me-1" title="Manage Stock by Size" onclick="openQuickStockModal(<?= htmlspecialchars(json_encode($grp), ENT_QUOTES, 'UTF-8'); ?>)">
                          <i class="fa-solid fa-boxes-stacked"></i>
                        </button>
                      <?php endif; ?>
                      <form action="<?= site_url('variants/delete_group/' . $product['id']); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this variant group (<?= count($grp['variant_ids']); ?> sizes)?');">
                        <input type="hidden" name="variant_ids" value="<?= implode(',', $grp['variant_ids']); ?>">
                        <button type="submit" class="btn btn-xs btn-outline-danger" title="Delete Variant Group">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                      </form>
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

<!-- Quick Manage Stock Modal -->
<div class="modal fade" id="quickStockModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header pb-2 border-bottom">
        <div>
          <h5 class="modal-title mb-0" id="quickStockModalTitle">
            <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Manage Stock by Size
          </h5>
          <small class="text-muted" id="quickStockModalSubtitle"></small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="quickStockForm">
          <input type="hidden" id="qs_product_id" value="<?= $product['id']; ?>">
          
          <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <span class="small fw-semibold text-secondary">Adjust quantities for each size:</span>
            <div class="d-flex align-items-center gap-1">
              <input type="number" min="0" class="form-control form-control-sm text-end" id="qs_quick_set_all" placeholder="Qty" value="10" style="width: 65px;">
              <button type="button" class="btn btn-outline-primary btn-xs" onclick="applyQsStockToAll()">Set All</button>
            </div>
          </div>

          <div id="quickStockList" class="d-flex flex-column gap-2">
            <!-- Populated dynamically -->
          </div>

          <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
            <span class="text-muted small">Total Updated Stock:</span>
            <strong class="text-primary fs-6" id="qs_total_stock_display">0 units</strong>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSaveQuickStock" onclick="submitQuickStock()">
          <i class="fa-solid fa-check me-1"></i> Save Stock Changes
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// DataTransfer container for new variant gallery uploads
var newVarGalleryDT = new DataTransfer();

function previewVarImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('var_preview_img').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function handleVarGalleryFiles(input) {
  if (input.files && input.files.length > 0) {
    for (var i = 0; i < input.files.length; i++) {
      newVarGalleryDT.items.add(input.files[i]);
    }
    input.files = newVarGalleryDT.files;
    renderVarNewGalleryPreviews();
  }
}

function removeNewVarGalleryFile(idx) {
  newVarGalleryDT.items.remove(idx);
  var input = document.getElementById('var_gallery_files');
  if (input) {
    input.files = newVarGalleryDT.files;
  }
  renderVarNewGalleryPreviews();
}

function clearAllVarGalleryFiles() {
  newVarGalleryDT = new DataTransfer();
  var input = document.getElementById('var_gallery_files');
  if (input) {
    input.files = newVarGalleryDT.files;
    input.value = '';
  }
  renderVarNewGalleryPreviews();
}

function renderVarNewGalleryPreviews() {
  var container = document.getElementById('var_new_gallery_container');
  var list = document.getElementById('var_new_gallery_preview_list');
  var countLabel = document.getElementById('var_new_gallery_count_label');
  if (!container || !list) return;

  list.innerHTML = '';
  var count = newVarGalleryDT.files.length;

  if (count === 0) {
    container.style.display = 'none';
    return;
  }

  container.style.display = 'block';
  if (countLabel) {
    countLabel.textContent = 'New Selected (' + count + '):';
  }

  Array.from(newVarGalleryDT.files).forEach(function(file, idx) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var thumb = document.createElement('div');
      thumb.className = 'position-relative border rounded p-1 bg-white shadow-sm';
      thumb.style.width = '52px';
      thumb.style.height = '52px';
      thumb.innerHTML = 
        '<img src="' + e.target.result + '" class="w-100 h-100 object-fit-cover rounded" alt="Gallery Preview">' +
        '<span class="badge bg-primary position-absolute bottom-0 start-0 p-0 text-center" style="font-size: 8px; width: 100%; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; opacity: 0.9;">NEW</span>' +
        '<button type="button" class="position-absolute d-flex align-items-center justify-content-center" ' +
        'style="top: -6px; right: -6px; width: 18px; height: 18px; border-radius: 50%; background: #ff4d49; color: #fff; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.25); z-index: 10; cursor: pointer; padding: 0;" ' +
        'onclick="removeNewVarGalleryFile(' + idx + ')" title="Remove this file">' +
        '<i class="fa-solid fa-xmark" style="font-size: 9px; line-height: 1;"></i>' +
        '</button>';
      list.appendChild(thumb);
    };
    reader.readAsDataURL(file);
  });
}

function removeExistingVarGallery(idx, imagePath) {
  var item = document.getElementById('var_gal_item_' + idx);
  if (!item) return;

  var varId = document.getElementById('var_id').value;

  if (varId) {
    if (!confirm('Are you sure you want to remove this gallery image from the variant?')) {
      return;
    }
    item.style.opacity = '0.3';
    item.style.pointerEvents = 'none';

    var payload = new URLSearchParams();
    payload.append('variant_id', varId);
    payload.append('image_path', imagePath);

    fetch('<?= site_url("variants/delete_gallery_image"); ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: payload.toString()
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
      if (data.status === 'success') {
        item.remove();
        updateVarExistingGalleryUI();
      } else {
        alert(data.message || 'Error removing image');
        item.style.opacity = '1';
        item.style.pointerEvents = 'auto';
      }
    })
    .catch(function() {
      item.remove();
      updateVarExistingGalleryUI();
    });
  } else {
    item.remove();
    updateVarExistingGalleryUI();
  }
}

function updateVarExistingGalleryUI() {
  var list = document.getElementById('var_existing_gallery_list');
  var wrapper = document.getElementById('var_existing_gallery_wrapper');
  var label = document.getElementById('var_existing_gallery_label');
  if (!list || !wrapper) return;

  var items = list.querySelectorAll('[id^="var_gal_item_"]');
  if (items.length === 0) {
    wrapper.style.display = 'none';
  } else {
    wrapper.style.display = 'block';
    if (label) label.textContent = 'Existing Variant Gallery (' + items.length + '):';
  }
}

// SIZE CHIP SELECTION & STOCK BY SIZE
function toggleSizeChip(valId) {
  var cb = document.getElementById('size_input_' + valId);
  var label = document.getElementById('size_chip_label_' + valId);
  if (!cb || !label) return;

  cb.checked = !cb.checked;

  if (cb.checked) {
    label.style.background = '#666cff';
    label.style.borderColor = '#666cff';
    label.style.color = '#fff';
  } else {
    label.style.background = '#fff';
    label.style.borderColor = '#d4d5d9';
    label.style.color = '#515569';
  }

  updateSizeSelectionInfo();
  renderVarSizeStockInputs();
}

function selectAllSizes(enable) {
  document.querySelectorAll('.size-chip-checkbox').forEach(function(cb) {
    cb.checked = enable;
    var label = document.getElementById('size_chip_label_' + cb.value);
    if (label) {
      if (enable) {
        label.style.background = '#666cff';
        label.style.borderColor = '#666cff';
        label.style.color = '#fff';
      } else {
        label.style.background = '#fff';
        label.style.borderColor = '#d4d5d9';
        label.style.color = '#515569';
      }
    }
  });

  updateSizeSelectionInfo();
  renderVarSizeStockInputs();
}

function updateSizeSelectionInfo() {
  var checked = document.querySelectorAll('.size-chip-checkbox:checked');
  var infoEl = document.getElementById('selected-sizes-count');
  var names = [];
  checked.forEach(function(c) {
    names.push(c.getAttribute('data-val'));
  });

  if (infoEl) {
    if (checked.length === 0) {
      infoEl.textContent = '0 sizes selected';
    } else if (checked.length === 1) {
      infoEl.textContent = '1 size selected: ' + names[0];
    } else {
      infoEl.innerHTML = '<strong class="text-primary">' + checked.length + ' sizes selected:</strong> ' + names.join(', ');
    }
  }

  updateSkuPreview();
}

// Render dynamic Stock by Size inputs in the form
function renderVarSizeStockInputs(presetStocks) {
  var checkedCbs = document.querySelectorAll('.size-chip-checkbox:checked');
  var container = document.getElementById('var_size_stock_manager');
  var list = document.getElementById('var_size_stock_inputs_list');
  var stockWrapper = document.getElementById('var_stock_wrapper');
  if (!container || !list) return;

  var baseSku = (document.getElementById('var_sku') ? document.getElementById('var_sku').value.trim() : '') || 'SKU';

  if (checkedCbs.length === 0) {
    container.style.display = 'none';
    if (stockWrapper) stockWrapper.style.display = 'block';
    return;
  }

  container.style.display = 'block';
  if (stockWrapper) stockWrapper.style.display = 'none';

  // Read existing input values unless presetStocks provided
  var existingVals = presetStocks || {};
  if (!presetStocks) {
    document.querySelectorAll('.var-size-qty-input').forEach(function(inp) {
      existingVals[inp.getAttribute('data-size-id')] = inp.value;
    });
  }

  list.innerHTML = '';
  checkedCbs.forEach(function(cb) {
    var sizeId = cb.value;
    var sizeName = cb.getAttribute('data-val') || '';
    var existingQty = (existingVals[sizeId] !== undefined && existingVals[sizeId] !== '') ? existingVals[sizeId] : '10';
    var isOut = parseInt(existingQty, 10) === 0;
    var vSku = baseSku;
    if (!new RegExp('-' + sizeName + '$', 'i').test(vSku)) {
      vSku += '-' + sizeName.toUpperCase();
    }

    var row = document.createElement('div');
    row.className = 'd-flex align-items-center justify-content-between p-1 px-2 border rounded bg-white';
    row.id = 'var_size_row_' + sizeId;
    row.innerHTML = 
      '<div class="d-flex align-items-center gap-2">' +
        '<span class="badge bg-primary fw-bold" style="min-width: 32px;">' + sizeName + '</span>' +
        '<code class="small text-muted var-size-sku-preview" style="font-size: 11px;">' + vSku + '</code>' +
      '</div>' +
      '<div class="d-flex align-items-center gap-1">' +
        '<div class="input-group input-group-sm" style="width: 115px;">' +
          '<span class="input-group-text p-1 text-muted" style="font-size: 10px;">Qty</span>' +
          '<input type="number" min="0" class="form-control form-control-sm text-end var-size-qty-input p-1" name="size_stock[' + sizeId + ']" data-size-id="' + sizeId + '" value="' + existingQty + '" oninput="recalcVarTotalStock()">' +
        '</div>' +
        '<span class="badge ' + (isOut ? 'bg-label-danger' : 'bg-label-success') + ' var-size-status-pill" style="font-size: 9px; min-width: 48px;">' + (isOut ? 'Out' : 'In') + '</span>' +
      '</div>';
    list.appendChild(row);
  });

  recalcVarTotalStock();
}

function applyVarStockToAll() {
  var val = document.getElementById('quick_var_stock_val') ? document.getElementById('quick_var_stock_val').value : '10';
  document.querySelectorAll('.var-size-qty-input').forEach(function(inp) {
    inp.value = val;
  });
  recalcVarTotalStock();
}

function recalcVarTotalStock() {
  var total = 0;
  document.querySelectorAll('.var-size-qty-input').forEach(function(inp) {
    var qty = parseInt(inp.value, 10) || 0;
    total += qty;
    var row = inp.closest('#var_size_row_' + inp.getAttribute('data-size-id'));
    if (row) {
      var pill = row.querySelector('.var-size-status-pill');
      if (pill) {
        if (qty <= 0) {
          pill.className = 'badge bg-label-danger var-size-status-pill';
          pill.textContent = 'Out';
        } else {
          pill.className = 'badge bg-label-success var-size-status-pill';
          pill.textContent = 'In';
        }
      }
    }
  });

  var totalEl = document.getElementById('var_total_sizes_stock');
  if (totalEl) totalEl.textContent = total + ' units';

  var stockInp = document.getElementById('var_stock');
  if (stockInp) stockInp.value = total;
}

function onNonSizeAttrChange(selectEl, slug) {
  if (slug === 'color') {
    var opt = selectEl.options[selectEl.selectedIndex];
    var colorName = opt ? opt.getAttribute('data-name') : '';
    if (colorName) {
      var baseTitleInput = document.getElementById('var_title');
      var baseSkuInput = document.getElementById('var_sku');
      var prodTitle = '<?= html_escape($product["title"]); ?>';
      var prodSku = '<?= html_escape($product["sku"]); ?>';

      if (!document.getElementById('var_id').value) {
        // Auto-fill in Add mode
        if (baseTitleInput && (!baseTitleInput.value || baseTitleInput.value.indexOf(prodTitle) === 0)) {
          baseTitleInput.value = prodTitle + ' - ' + colorName;
        }
        if (baseSkuInput && (!baseSkuInput.value || baseSkuInput.value.indexOf(prodSku) === 0)) {
          var code = colorName.toUpperCase().replace(/[^A-Z0-9]/g, '').substr(0, 3);
          baseSkuInput.value = prodSku + '-' + code;
        }
      }
    }
  }
  updateSkuPreview();
}

function updateSkuPreview() {
  var helper = document.getElementById('sku-preview-helper');
  if (!helper) return;

  var baseSku = document.getElementById('var_sku').value.trim();
  var checked = document.querySelectorAll('.size-chip-checkbox:checked');

  // Update dynamic size previews
  document.querySelectorAll('#var_size_stock_inputs_list .var-size-sku-preview').forEach(function(el) {
    var row = el.closest('[id^="var_size_row_"]');
    var badge = row ? row.querySelector('.badge.bg-primary') : null;
    if (badge && baseSku) {
      el.textContent = baseSku + '-' + badge.textContent.trim().toUpperCase();
    }
  });

  if (!baseSku || checked.length <= 1) {
    helper.style.display = 'none';
    return;
  }

  var skus = [];
  checked.forEach(function(cb) {
    var sVal = cb.getAttribute('data-val');
    var sSku = baseSku;
    if (!new RegExp('-' + sVal + '$', 'i').test(sSku)) {
      sSku += '-' + sVal.toUpperCase();
    }
    skus.push(sSku);
  });

  helper.style.display = 'block';
  helper.innerHTML = '<i class="fa-solid fa-layer-group me-1"></i>Group of ' + checked.length + ' sizes: <code class="text-dark">' + skus.join(', ') + '</code>';
}

// Edit Variant Group
function editVarGroup(grp) {
  document.getElementById('variant-form-title').innerText = 'Edit Variant: ' + grp.title;
  document.getElementById('var_id').value = grp.primary_id;
  document.getElementById('var_group_variant_ids').value = grp.variant_ids.join(',');
  document.getElementById('var_title').value = grp.title;
  document.getElementById('var_sku').value = grp.base_sku;
  document.getElementById('var_price').value = grp.price;
  document.getElementById('var_sale_price').value = grp.sale_price || '';
  document.getElementById('var_stock').value = grp.total_stock;
  document.getElementById('var_current_image').value = grp.image || '<?= html_escape($product['main_image']); ?>';

  var btnSave = document.getElementById('btn-save-var');
  if (btnSave) {
    btnSave.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Update Variant Group';
  }

  var imgSrc = grp.image ? ('<?= base_url('../website/assets/images/'); ?>' + grp.image) : ('<?= base_url('../website/assets/images/' . $product['main_image']); ?>');
  document.getElementById('var_preview_img').src = imgSrc;
  document.getElementById('var_image_file').value = '';

  // Clear new gallery upload
  clearAllVarGalleryFiles();

  // Load existing gallery
  var galList = document.getElementById('var_existing_gallery_list');
  var galWrapper = document.getElementById('var_existing_gallery_wrapper');
  if (galList && galWrapper) {
    galList.innerHTML = '';
    var existingGal = [];
    if (grp.gallery_images) {
      try {
        existingGal = typeof grp.gallery_images === 'string' ? JSON.parse(grp.gallery_images) : grp.gallery_images;
      } catch(e) { existingGal = []; }
    }

    if (existingGal && existingGal.length > 0) {
      galWrapper.style.display = 'block';
      document.getElementById('var_existing_gallery_label').textContent = 'Existing Variant Gallery (' + existingGal.length + '):';
      existingGal.forEach(function(gFile, gIdx) {
        var gThumb = document.createElement('div');
        gThumb.className = 'position-relative border rounded p-1 bg-white shadow-sm';
        gThumb.id = 'var_gal_item_' + gIdx;
        gThumb.style.width = '52px';
        gThumb.style.height = '52px';
        gThumb.innerHTML = 
          '<img src="<?= base_url('../website/assets/images/'); ?>' + gFile + '" class="w-100 h-100 object-fit-cover rounded" alt="Gallery">' +
          '<input type="hidden" name="existing_gallery[]" value="' + gFile + '">' +
          '<button type="button" class="position-absolute d-flex align-items-center justify-content-center" ' +
          'style="top: -6px; right: -6px; width: 18px; height: 18px; border-radius: 50%; background: #ff4d49; color: #fff; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.25); z-index: 10; cursor: pointer; padding: 0;" ' +
          'onclick="removeExistingVarGallery(' + gIdx + ', \'' + gFile + '\')" title="Remove from variant gallery">' +
          '<i class="fa-solid fa-xmark" style="font-size: 9px; line-height: 1;"></i>' +
          '</button>';
        galList.appendChild(gThumb);
      });
    } else {
      galWrapper.style.display = 'none';
    }
  }

  // Set non-size attributes (e.g. Color)
  var selects = document.querySelectorAll('select[id^="attr_val_"]');
  selects.forEach(function(s) { s.value = ''; });
  if (grp.non_size_attrs && grp.non_size_attrs.length > 0) {
    grp.non_size_attrs.forEach(function(nsa) {
      var sel = document.getElementById('attr_val_' + nsa.attribute_id);
      if (sel) {
        sel.value = nsa.attribute_value_id;
      }
    });
  }

  // Clear all size chips first
  selectAllSizes(false);

  // Check chips for each size in grp.sizes and build preset stocks map
  var presetStocks = {};
  if (grp.sizes && grp.sizes.length > 0) {
    grp.sizes.forEach(function(sz) {
      var sizeCb = document.getElementById('size_input_' + sz.size_id);
      var sizeLabel = document.getElementById('size_chip_label_' + sz.size_id);
      if (sizeCb && sizeLabel) {
        sizeCb.checked = true;
        sizeLabel.style.background = '#666cff';
        sizeLabel.style.borderColor = '#666cff';
        sizeLabel.style.color = '#fff';
      }
      presetStocks[sz.size_id] = sz.stock;
    });
  }

  updateSizeSelectionInfo();
  renderVarSizeStockInputs(presetStocks);

  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetVarForm() {
  document.getElementById('variant-form-title').innerText = 'Add Product Variant';
  document.getElementById('var_id').value = '';
  document.getElementById('var_group_variant_ids').value = '';
  document.getElementById('var_title').value = '';
  document.getElementById('var_sku').value = '';
  document.getElementById('var_price').value = '<?= $product['price']; ?>';
  document.getElementById('var_sale_price').value = '<?= $product['sale_price'] ?: ''; ?>';
  document.getElementById('var_stock').value = '10';
  document.getElementById('var_current_image').value = '<?= html_escape($product['main_image']); ?>';
  document.getElementById('var_preview_img').src = '<?= base_url('../website/assets/images/' . ($product['main_image'] ?: 'products/womens/women-1.jpg')); ?>';
  document.getElementById('var_image_file').value = '';

  var btnSave = document.getElementById('btn-save-var');
  if (btnSave) {
    btnSave.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Save Variant';
  }

  // Reset gallery
  clearAllVarGalleryFiles();
  var galWrapper = document.getElementById('var_existing_gallery_wrapper');
  var galList = document.getElementById('var_existing_gallery_list');
  if (galWrapper) galWrapper.style.display = 'none';
  if (galList) galList.innerHTML = '';

  var selects = document.querySelectorAll('select[id^="attr_val_"]');
  selects.forEach(function(s) { s.value = ''; });

  selectAllSizes(false);
  renderVarSizeStockInputs();
  updateSkuPreview();
}

// Quick Stock Management Modal
var activeQsGroup = null;
var qsModalInstance = null;

function openQuickStockModal(grp) {
  activeQsGroup = grp;
  document.getElementById('quickStockModalSubtitle').textContent = grp.title + ' (' + grp.base_sku + ')';
  var list = document.getElementById('quickStockList');
  list.innerHTML = '';

  if (!grp.sizes || grp.sizes.length === 0) {
    list.innerHTML = '<div class="text-muted small py-2">No sizes configured for this variant.</div>';
    return;
  }

  grp.sizes.forEach(function(sz) {
    var isOut = sz.stock <= 0;
    var row = document.createElement('div');
    row.className = 'd-flex align-items-center justify-content-between p-2 border rounded bg-white shadow-sm';
    row.id = 'qs_size_row_' + sz.variant_id;
    row.innerHTML = 
      '<div class="d-flex align-items-center gap-2">' +
        '<span class="badge bg-primary fs-6 fw-bold" style="min-width: 40px;">' + sz.size_name + '</span>' +
        '<div>' +
          '<code class="d-block" style="font-size: 11px;">' + sz.sku + '</code>' +
          '<span class="badge ' + (isOut ? 'bg-label-danger' : 'bg-label-success') + ' qs-status-badge" style="font-size: 9px;">' +
            (isOut ? 'Out of stock' : 'In stock') +
          '</span>' +
        '</div>' +
      '</div>' +
      '<div class="d-flex align-items-center gap-2">' +
        '<div class="input-group input-group-sm" style="width: 120px;">' +
          '<span class="input-group-text">Qty</span>' +
          '<input type="number" min="0" class="form-control text-end qs-stock-input" data-var-id="' + sz.variant_id + '" value="' + sz.stock + '" oninput="recalcQsTotal()">' +
        '</div>' +
      '</div>';
    list.appendChild(row);
  });

  recalcQsTotal();

  var modalEl = document.getElementById('quickStockModal');
  qsModalInstance = new bootstrap.Modal(modalEl);
  qsModalInstance.show();
}

function applyQsStockToAll() {
  var val = document.getElementById('qs_quick_set_all') ? document.getElementById('qs_quick_set_all').value : '10';
  document.querySelectorAll('.qs-stock-input').forEach(function(inp) {
    inp.value = val;
  });
  recalcQsTotal();
}

function recalcQsTotal() {
  var total = 0;
  document.querySelectorAll('.qs-stock-input').forEach(function(inp) {
    var qty = parseInt(inp.value, 10) || 0;
    total += qty;
    var row = inp.closest('#qs_size_row_' + inp.getAttribute('data-var-id'));
    if (row) {
      var badge = row.querySelector('.qs-status-badge');
      if (badge) {
        if (qty <= 0) {
          badge.className = 'badge bg-label-danger qs-status-badge';
          badge.textContent = 'Out of stock';
        } else {
          badge.className = 'badge bg-label-success qs-status-badge';
          badge.textContent = 'In stock';
        }
      }
    }
  });

  var totalEl = document.getElementById('qs_total_stock_display');
  if (totalEl) totalEl.textContent = total + ' units';
}

function submitQuickStock() {
  if (!activeQsGroup) return;

  var btn = document.getElementById('btnSaveQuickStock');
  var origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

  var payload = new URLSearchParams();
  payload.append('product_id', '<?= $product["id"]; ?>');

  document.querySelectorAll('.qs-stock-input').forEach(function(inp) {
    var vId = inp.getAttribute('data-var-id');
    var qty = inp.value;
    payload.append('stocks[' + vId + ']', qty);
  });

  fetch('<?= site_url("variants/update_size_stocks"); ?>', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: payload.toString()
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    btn.disabled = false;
    btn.innerHTML = origText;
    if (data.status === 'success') {
      if (qsModalInstance) qsModalInstance.hide();
      window.location.reload();
    } else {
      alert(data.message || 'Error updating stocks');
    }
  })
  .catch(function(err) {
    btn.disabled = false;
    btn.innerHTML = origText;
    alert('Request failed');
  });
}
</script>
