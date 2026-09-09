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

            <div class="mb-3">
              <label class="form-label" for="var_stock">Stock Quantity (per variant) <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="var_stock" name="stock_quantity" value="10" required>
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
                          <span class="text-muted small fst-italic" style="font-size: 10px;">Creates 1 variant per size</span>
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
                        <div class="position-relative me-2" style="width: 38px; height: 38px; flex-shrink: 0;">
                          <img src="<?= base_url('../website/assets/images/' . ($v['image'] ?: $product['main_image'])); ?>" class="rounded w-100 h-100 object-fit-cover" onerror="this.src='<?= base_url('../website/assets/images/products/womens/women-1.jpg'); ?>'">
                          <?php 
                            $v_gal = !empty($v['gallery_images']) ? (json_decode($v['gallery_images'], true) ?: []) : []; 
                            if (!empty($v_gal)):
                          ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info" style="font-size: 8px; padding: 2px 4px;" title="<?= count($v_gal); ?> gallery photos">+<?= count($v_gal); ?></span>
                          <?php endif; ?>
                        </div>
                        <div>
                          <strong><?= html_escape($v['title']); ?></strong>
                          <?php if (!empty($v_gal)): ?>
                            <small class="text-muted d-block" style="font-size: 11px;"><i class="fa-solid fa-images me-1"></i><?= count($v_gal); ?> gallery photos</small>
                          <?php endif; ?>
                        </div>
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

// SIZE CHIP SELECTION
function toggleSizeChip(valId) {
  var cb = document.getElementById('size_input_' + valId);
  var label = document.getElementById('size_chip_label_' + valId);
  if (!cb || !label) return;

  var isEdit = !!document.getElementById('var_id').value;
  if (isEdit) {
    // In edit mode: single selection
    document.querySelectorAll('.size-chip-checkbox').forEach(function(otherCb) {
      if (otherCb !== cb) {
        otherCb.checked = false;
        var otherLabel = document.getElementById('size_chip_label_' + otherCb.value);
        if (otherLabel) {
          otherLabel.style.background = '#fff';
          otherLabel.style.borderColor = '#d4d5d9';
          otherLabel.style.color = '#515569';
        }
      }
    });
    cb.checked = !cb.checked;
  } else {
    cb.checked = !cb.checked;
  }

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
}

function selectAllSizes(enable) {
  var isEdit = !!document.getElementById('var_id').value;
  if (isEdit) return; // Disallowed in single edit mode

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
        // Only auto-fill if in Add mode
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
  var isEdit = !!document.getElementById('var_id').value;
  var helper = document.getElementById('sku-preview-helper');
  if (!helper) return;

  if (isEdit) {
    helper.style.display = 'none';
    return;
  }

  var baseSku = document.getElementById('var_sku').value.trim();
  var checked = document.querySelectorAll('.size-chip-checkbox:checked');

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
  helper.innerHTML = '<i class="fa-solid fa-layer-group me-1"></i>Will create ' + checked.length + ' variants: <code class="text-dark">' + skus.join(', ') + '</code>';
}

function editVar(v) {
  document.getElementById('variant-form-title').innerText = 'Edit Variant: ' + v.title;
  document.getElementById('var_id').value = v.id;
  document.getElementById('var_title').value = v.title;
  document.getElementById('var_sku').value = v.sku;
  document.getElementById('var_price').value = v.price;
  document.getElementById('var_sale_price').value = v.sale_price || '';
  document.getElementById('var_stock').value = v.stock_quantity;
  document.getElementById('var_current_image').value = v.image || '<?= html_escape($product['main_image']); ?>';
  
  var btnSave = document.getElementById('btn-save-var');
  if (btnSave) {
    btnSave.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Update Variant';
  }

  var imgSrc = v.image ? ('<?= base_url('../website/assets/images/'); ?>' + v.image) : ('<?= base_url('../website/assets/images/' . $product['main_image']); ?>');
  document.getElementById('var_preview_img').src = imgSrc;
  document.getElementById('var_image_file').value = '';

  // Clear new gallery upload
  clearAllVarGalleryFiles();

  // Load existing variant gallery
  var galList = document.getElementById('var_existing_gallery_list');
  var galWrapper = document.getElementById('var_existing_gallery_wrapper');
  if (galList && galWrapper) {
    galList.innerHTML = '';
    var existingGal = [];
    if (v.gallery_images) {
      try {
        existingGal = typeof v.gallery_images === 'string' ? JSON.parse(v.gallery_images) : v.gallery_images;
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

  // Set attribute values
  // Reset size chips first
  selectAllSizes(false);
  var sizeQuickActions = document.getElementById('size-quick-actions');
  if (sizeQuickActions) sizeQuickActions.style.display = 'none';

  if (v.values && v.values.length > 0) {
    v.values.forEach(function(val) {
      var sel = document.getElementById('attr_val_' + val.attribute_id);
      if (sel) {
        sel.value = val.attribute_value_id;
      }
      // If this is a size attribute
      var sizeCb = document.getElementById('size_input_' + val.attribute_value_id);
      var sizeLabel = document.getElementById('size_chip_label_' + val.attribute_value_id);
      if (sizeCb && sizeLabel) {
        sizeCb.checked = true;
        sizeLabel.style.background = '#666cff';
        sizeLabel.style.borderColor = '#666cff';
        sizeLabel.style.color = '#fff';
      }
    });
  }

  updateSizeSelectionInfo();
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

  // Show quick actions in Add mode
  var sizeQuickActions = document.getElementById('size-quick-actions');
  if (sizeQuickActions) sizeQuickActions.style.display = 'flex';

  selectAllSizes(false);
  updateSkuPreview();
}
</script>
