<style>
@media (min-width: 992px) {
  .sticky-organization-wrapper {
    position: sticky;
    top: 80px;
    z-index: 10;
  }
  .sticky-organization-card {
    max-height: calc(100vh - 100px);
    display: flex;
    flex-direction: column;
  }
  .sticky-organization-card .card-header {
    flex-shrink: 0;
  }
  .sticky-organization-card .card-body {
    flex: 1 1 auto;
    overflow-y: auto;
    overflow-x: hidden;
  }
  .sticky-organization-card .card-footer {
    flex-shrink: 0;
  }
}

/* Elegant slim scrollbar for sticky organization card */
.sticky-organization-card .card-body::-webkit-scrollbar {
  width: 5px;
}
.sticky-organization-card .card-body::-webkit-scrollbar-track {
  background: transparent;
}
.sticky-organization-card .card-body::-webkit-scrollbar-thumb {
  background: #d4d7dc;
  border-radius: 4px;
}
.sticky-organization-card .card-body::-webkit-scrollbar-thumb:hover {
  background: #b5b9c0;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Products /</span> Add Product</h4>
    <div class="d-flex gap-2">
      <a href="<?= site_url('products'); ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
      </a>
      <button type="submit" form="productAddForm" class="btn btn-primary d-none d-sm-inline-flex align-items-center">
        <i class="fa-solid fa-floppy-disk me-1"></i> Save Product
      </button>
    </div>
  </div>

  <form action="<?= site_url('products/add'); ?>" method="POST" enctype="multipart/form-data" id="productAddForm">
    <div class="row">
      <!-- Left Column: Main info -->
      <div class="col-12 col-lg-8">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Product Information</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label" for="title">Product Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Linen Summer Dress" required />
            </div>
            <div class="mb-3">
              <label class="form-label" for="short_description">Short Description</label>
              <textarea class="form-control" id="short_description" name="short_description" rows="2" placeholder="Brief summary displayed on listings..."></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label" for="description">Full Description</label>
              <textarea class="form-control" id="description" name="description" rows="5" placeholder="Detailed product specifications, materials, care instructions..."></textarea>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Pricing & Inventory</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="price">Regular Price <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="99.00" required />
                </div>
              </div>
              <div class="col-md-6 mb-3" id="add_sale_price_wrapper">
                <label class="form-label" for="sale_price">Sale Price (Optional)</label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" placeholder="79.00" />
                </div>
                <small class="text-muted d-block mt-1" style="font-size: 11px;">Active when no size attributes are selected.</small>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="sku">SKU Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="sku" name="sku" placeholder="e.g. MOD-W-109" required oninput="syncAddSkuWithVariants()" />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="stock_quantity">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="50" required />
                <small class="text-muted d-block" id="stock_qty_helper" style="font-size: 11px;">Default product inventory. When sizes are selected below, this auto-sums all size stocks.</small>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold" for="max_purchase_quantity">Max Purchase Quantity (Per Order)</label>
                <input type="number" min="1" class="form-control" id="max_purchase_quantity" name="max_purchase_quantity" value="5" placeholder="e.g. 5" />
                <small class="text-muted d-block" style="font-size: 11px;">How many products user can purchase together in one order (e.g. 5).</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Assign Attributes & Product Variants Card -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0 d-flex align-items-center text-dark">
              <i class="fa-solid fa-tags text-primary me-2"></i> Assign Attributes & Variants
            </h5>
            <small class="text-muted">Assign attributes (Color, Size, etc.) and manage stock by size to create product variants automatically.</small>
          </div>
          <div class="card-body" id="variants_config_panel">
            <?php if (!empty($attributes)): ?>
              <div class="row">
                <?php 
                  $size_attribute = null;
                  $other_attributes = [];
                  foreach ($attributes as $attr) {
                    if (strcasecmp($attr['slug'], 'size') === 0 || strcasecmp($attr['name'], 'size') === 0) {
                      $size_attribute = $attr;
                    } else {
                      $other_attributes[] = $attr;
                    }
                  }
                ?>

                <!-- Non-Size Attributes (Color, Material, etc.) -->
                <?php if (!empty($other_attributes)): ?>
                  <div class="col-12 mb-3">
                    <label class="form-label fw-semibold text-dark">Assign Non-Size Attributes (e.g. Color, Material):</label>
                    <div class="row g-3">
                      <?php foreach ($other_attributes as $attr): ?>
                        <div class="col-md-6">
                          <div class="p-2 border rounded bg-light">
                            <label class="form-label small fw-bold mb-1" for="add_attr_val_<?= $attr['id']; ?>">
                              <?= html_escape($attr['name']); ?>
                            </label>
                            <select class="form-select form-select-sm" name="attr_vals[<?= $attr['id']; ?>]" id="add_attr_val_<?= $attr['id']; ?>" onchange="updateVariantNameAndSkuPreview()">
                              <option value="">-- None / Select <?= html_escape($attr['name']); ?> --</option>
                              <?php if (!empty($attr['values'])): ?>
                                <?php foreach ($attr['values'] as $v): ?>
                                  <option value="<?= $v['id']; ?>" data-name="<?= html_escape($v['value']); ?>" data-color="<?= html_escape($v['color_code'] ?? ''); ?>">
                                    <?= html_escape($v['value']); ?>
                                  </option>
                                <?php endforeach; ?>
                              <?php endif; ?>
                            </select>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php endif; ?>

                <!-- Size Multiple Selector & Stock by Size Management -->
                <?php if ($size_attribute && !empty($size_attribute['values'])): ?>
                  <div class="col-12 mb-3">
                    <div class="p-3 border rounded bg-light">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                          <label class="form-label fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-ruler-combined text-info me-1"></i> Assign Sizes <span class="badge bg-label-info ms-1" style="font-size: 10px;">Multiple Selection</span>
                          </label>
                          <small class="text-muted d-block" style="font-size: 11px;">Select all sizes available for this product/variant.</small>
                        </div>
                        <div class="d-flex gap-2">
                          <a href="javascript:void(0);" class="small text-primary text-decoration-none fw-semibold" onclick="selectAllAddSizes(true)">Select All</a>
                          <span class="text-muted small">|</span>
                          <a href="javascript:void(0);" class="small text-secondary text-decoration-none" onclick="selectAllAddSizes(false)">Clear</a>
                        </div>
                      </div>

                      <!-- Size Chips -->
                      <div class="d-flex flex-wrap gap-2 mb-2" id="add-size-chips-wrapper">
                        <?php foreach ($size_attribute['values'] as $v): ?>
                          <div 
                            class="border rounded px-3 py-1 text-center add-size-chip" 
                            id="add_size_chip_<?= $v['id']; ?>" 
                            style="cursor: pointer; min-width: 44px; font-size: 13px; font-weight: 600; user-select: none; background: #fff; border-color: #d4d5d9; color: #515569; transition: all 0.15s ease;"
                            onclick="toggleAddSizeChip(<?= $v['id']; ?>, '<?= html_escape($v['value']); ?>')"
                          >
                            <input 
                              type="checkbox" 
                              name="size_vals[]" 
                              value="<?= $v['id']; ?>" 
                              data-val="<?= html_escape($v['value']); ?>" 
                              id="add_size_input_<?= $v['id']; ?>" 
                              class="d-none add-size-checkbox"
                            />
                            <span><?= html_escape($v['value']); ?></span>
                          </div>
                        <?php endforeach; ?>
                      </div>

                      <!-- Manage Stock by Size Dynamic Container -->
                      <div id="add-size-stock-manager" class="mt-3 p-3 bg-white rounded border" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom flex-wrap gap-2">
                          <div>
                            <span class="fw-bold text-dark fs-6">
                              <i class="fa-solid fa-boxes-stacked text-primary me-1"></i> Manage Stock by Size
                            </span>
                            <small class="text-muted d-block" style="font-size: 11px;">Specify individual inventory quantity for each selected size.</small>
                          </div>

                        </div>

                        <!-- Table of Selected Sizes for Stock -->
                        <div class="table-responsive">
                          <table class="table table-sm table-bordered align-middle mb-0">
                            <thead class="table-light">
                              <tr>
                                <th style="width: 80px;" class="text-center">Size</th>
                                <th>Variant SKU</th>
                                <th style="width: 160px;">Stock Quantity</th>
                                <th style="width: 160px;">Sale Price ($)</th>
                                <th style="width: 110px;" class="text-center">Status</th>
                              </tr>
                            </thead>
                            <tbody id="add-size-stock-tbody">
                              <!-- dynamically populated by JS -->
                            </tbody>
                          </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top flex-wrap gap-2">
                          <span class="text-muted small" id="add-selected-sizes-count">0 sizes selected</span>
                          <div class="text-end">
                            <small class="text-muted">Total Stock for this product: </small>
                            <strong class="text-primary fs-6" id="add-total-sizes-stock">0 units</strong>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                <?php endif; ?>

              </div>
            <?php else: ?>
              <p class="text-muted mb-0">No attributes found. Create attributes in Catalog > Attributes first.</p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Product Highlights Card -->
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title mb-0 d-flex align-items-center text-dark">
                <i class="fa-solid fa-highlighter text-primary me-2"></i> Product Highlights
              </h5>
              <small class="text-muted">Highlight key attributes prominently on the product page (e.g. Sleeve: Full Sleeve, Fabric: Cotton Blend).</small>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" id="enable_highlights" name="enable_highlights" value="1" onchange="toggleHighlightsPanel(this.checked)" style="width: 2.5em; height: 1.3em; cursor: pointer;">
            </div>
          </div>
          <div class="card-body" id="highlights_panel" style="display: none;">
            <div class="table-responsive">
              <table class="table table-bordered table-sm align-middle" id="highlights_table">
                <thead class="table-light">
                  <tr>
                    <th style="width: 45%;">Highlight Key / Label</th>
                    <th style="width: 45%;">Value</th>
                    <th style="width: 10%;" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody id="highlights_body">
                </tbody>
              </table>
            </div>
            <div class="mt-2">
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="addHighlightRow()">
                <i class="fa-solid fa-plus me-1"></i> Add More Highlight
              </button>
            </div>
          </div>
        </div>

        <!-- Product Specifications Card -->
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title mb-0 d-flex align-items-center text-dark">
                <i class="fa-solid fa-list-check text-primary me-2"></i> Product Specifications
              </h5>
              <small class="text-muted">Detailed specifications (Brand, Category, Size, and Color are automatically included on the product page).</small>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" id="enable_specifications" name="enable_specifications" value="1" onchange="toggleSpecificationsPanel(this.checked)" style="width: 2.5em; height: 1.3em; cursor: pointer;">
            </div>
          </div>
          <div class="card-body" id="specifications_panel" style="display: none;">
            <div class="table-responsive">
              <table class="table table-bordered table-sm align-middle" id="specifications_table">
                <thead class="table-light">
                  <tr>
                    <th style="width: 45%;">Specification Name</th>
                    <th style="width: 45%;">Value</th>
                    <th style="width: 10%;" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody id="specifications_body">
                </tbody>
              </table>
            </div>
            <div class="mt-2">
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSpecificationRow()">
                <i class="fa-solid fa-plus me-1"></i> Add Specification
              </button>
            </div>
          </div>
        </div>

      </div>

      <!-- Right Column: Organize, Category, Image (Sticky so only left side scrolls) -->
      <div class="col-12 col-lg-4">
        <div class="sticky-organization-wrapper">
          <div class="card mb-4 sticky-organization-card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
              <h5 class="card-title mb-0">Organization</h5>
              <span class="badge bg-label-primary small">Media & Badges</span>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
                <select class="form-select" id="category_id" name="category_id" required>
                  <option value="">Select Category</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id']; ?>"><?= html_escape($cat['breadcrumb_path'] ?? $cat['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label" for="brand_id">Brand</label>
                <select class="form-select" id="brand_id" name="brand_id">
                  <option value="">Select Brand</option>
                  <?php foreach ($brands as $b): ?>
                    <option value="<?= $b['id']; ?>"><?= html_escape($b['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label" for="status">Publication Status</label>
                <select class="form-select" id="status" name="status">
                  <option value="published" selected>Published</option>
                  <option value="draft">Draft</option>
                </select>
              </div>

              <!-- Main Product Image File Upload -->
              <div class="mb-3">
                <label class="form-label fw-semibold" for="main_image_file">Main Product Image</label>
                <div class="border rounded p-2 mb-2 bg-light text-center">
                  <img
                    id="main_product_preview"
                    src="<?= base_url('../website/assets/images/products/womens/women-1.jpg'); ?>"
                    class="rounded img-fluid"
                    style="max-height: 140px; object-fit: contain;"
                    alt="Product Image Preview"
                  />
                </div>
                <input
                  type="file"
                  class="form-control form-control-sm"
                  id="main_image_file"
                  name="main_image_file"
                  accept="image/*"
                  onchange="previewMainProductFile(this)"
                />
                <input type="hidden" name="default_main_image" value="products/womens/women-1.jpg" />
                <small class="text-muted d-block mt-1" style="font-size: 11px;">Recommended: 800x1000px, JPG, PNG, WEBP (Max 10MB)</small>
              </div>

              <!-- Additional Gallery Images File Upload -->
              <div class="mb-3">
                <label class="form-label fw-semibold" for="gallery_files">Upload Gallery Images</label>
                <input
                  type="file"
                  class="form-control form-control-sm"
                  id="gallery_files"
                  name="gallery_files[]"
                  accept="image/*"
                  multiple
                  onchange="handleNewGalleryFiles(this)"
                />
                <small class="text-muted d-block mt-1" style="font-size: 11px;">Select multiple images for the product gallery.</small>
                <div id="new_gallery_container" class="mt-2" style="display: none;">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold text-primary" id="new_gallery_count_label">New Selected (0):</span>
                    <button type="button" class="btn btn-link text-danger p-0 small text-decoration-none" style="font-size: 11px;" onclick="clearAllNewGalleryFiles()">
                      <i class="fa-solid fa-trash-can me-1"></i>Clear All
                    </button>
                  </div>
                  <div id="new_gallery_preview_list" class="d-flex flex-wrap gap-2"></div>
                </div>
              </div>

              <div class="border-top pt-3">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" />
                  <label class="form-check-label" for="is_featured">Featured Product</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="is_trending" name="is_trending" value="1" checked />
                  <label class="form-check-label" for="is_trending">Trending Badge</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="is_new" name="is_new" value="1" checked />
                  <label class="form-check-label" for="is_new">New Arrival Badge</label>
                </div>
              </div>
            </div>
            <div class="card-footer bg-white border-top py-3">
              <button type="submit" form="productAddForm" class="btn btn-primary w-100 shadow-sm py-2">
                <i class="fa-solid fa-floppy-disk me-1"></i> Save Product
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
function previewMainProductFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('main_product_preview').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

var newGalleryDT = new DataTransfer();

function handleNewGalleryFiles(input) {
  if (input.files && input.files.length > 0) {
    for (var i = 0; i < input.files.length; i++) {
      newGalleryDT.items.add(input.files[i]);
    }
    input.files = newGalleryDT.files;
    renderNewGalleryPreviews();
  }
}

function removeNewGalleryFile(idx) {
  newGalleryDT.items.remove(idx);
  var input = document.getElementById('gallery_files');
  if (input) {
    input.files = newGalleryDT.files;
  }
  renderNewGalleryPreviews();
}

function clearAllNewGalleryFiles() {
  newGalleryDT = new DataTransfer();
  var input = document.getElementById('gallery_files');
  if (input) {
    input.files = newGalleryDT.files;
    input.value = '';
  }
  renderNewGalleryPreviews();
}

function renderNewGalleryPreviews() {
  var container = document.getElementById('new_gallery_container');
  var list = document.getElementById('new_gallery_preview_list');
  var countLabel = document.getElementById('new_gallery_count_label');
  if (!container || !list) return;

  list.innerHTML = '';
  var count = newGalleryDT.files.length;

  if (count === 0) {
    container.style.display = 'none';
    return;
  }

  container.style.display = 'block';
  if (countLabel) {
    countLabel.textContent = 'New Selected (' + count + '):';
  }

  Array.from(newGalleryDT.files).forEach(function(file, idx) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var thumb = document.createElement('div');
      thumb.className = 'position-relative border rounded p-1 bg-white shadow-sm';
      thumb.style.width = '58px';
      thumb.style.height = '58px';
      thumb.innerHTML = 
        '<img src="' + e.target.result + '" class="w-100 h-100 object-fit-cover rounded" alt="New Gallery Image">' +
        '<span class="badge bg-primary position-absolute bottom-0 start-0 p-0 text-center" style="font-size: 8px; width: 100%; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; opacity: 0.9;">NEW</span>' +
        '<button type="button" class="position-absolute d-flex align-items-center justify-content-center" ' +
        'style="top: -6px; right: -6px; width: 20px; height: 20px; border-radius: 50%; background: #ff4d49; color: #fff; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.25); z-index: 10; cursor: pointer; padding: 0;" ' +
        'onclick="removeNewGalleryFile(' + idx + ')" title="Remove this file">' +
        '<i class="fa-solid fa-xmark" style="font-size: 10px; line-height: 1;"></i>' +
        '</button>';
      list.appendChild(thumb);
    };
    reader.readAsDataURL(file);
  });
}

// Size Chip Toggle
function toggleAddSizeChip(valId, valName) {
  var cb = document.getElementById('add_size_input_' + valId);
  var chip = document.getElementById('add_size_chip_' + valId);
  if (!cb || !chip) return;

  cb.checked = !cb.checked;
  if (cb.checked) {
    chip.style.background = '#666cff';
    chip.style.borderColor = '#666cff';
    chip.style.color = '#fff';
  } else {
    chip.style.background = '#fff';
    chip.style.borderColor = '#d4d5d9';
    chip.style.color = '#515569';
  }

  renderAddSizeStockTable();
}

function selectAllAddSizes(enable) {
  document.querySelectorAll('.add-size-checkbox').forEach(function(cb) {
    cb.checked = enable;
    var chip = document.getElementById('add_size_chip_' + cb.value);
    if (chip) {
      if (enable) {
        chip.style.background = '#666cff';
        chip.style.borderColor = '#666cff';
        chip.style.color = '#fff';
      } else {
        chip.style.background = '#fff';
        chip.style.borderColor = '#d4d5d9';
        chip.style.color = '#515569';
      }
    }
  });

  renderAddSizeStockTable();
}

// Render dynamic stock-by-size table
function renderAddSizeStockTable() {
  var checkedCbs = document.querySelectorAll('.add-size-checkbox:checked');
  var container = document.getElementById('add-size-stock-manager');
  var tbody = document.getElementById('add-size-stock-tbody');
  var countEl = document.getElementById('add-selected-sizes-count');
  var salePriceWrapper = document.getElementById('add_sale_price_wrapper');
  if (!container || !tbody) return;

  var baseSku = (document.getElementById('sku') ? document.getElementById('sku').value.trim() : '') || 'SKU';
  var defaultSalePrice = (document.getElementById('sale_price') ? document.getElementById('sale_price').value.trim() : '') || '';

  if (checkedCbs.length === 0) {
    container.style.display = 'none';
    if (salePriceWrapper) salePriceWrapper.style.display = 'block';
    if (countEl) countEl.textContent = '0 sizes selected';
    return;
  }

  container.style.display = 'block';
  if (salePriceWrapper) salePriceWrapper.style.display = 'none';
  if (countEl) countEl.textContent = checkedCbs.length + ' size(s) selected';

  // Save current values if already entered
  var currentVals = {};
  document.querySelectorAll('.add-size-qty-input').forEach(function(inp) {
    var sid = inp.getAttribute('data-size-id');
    currentVals[sid] = currentVals[sid] || {};
    currentVals[sid].stock = inp.value;
  });
  document.querySelectorAll('.add-size-sale-price-input').forEach(function(inp) {
    var sid = inp.getAttribute('data-size-id');
    currentVals[sid] = currentVals[sid] || {};
    currentVals[sid].sale_price = inp.value;
  });

  tbody.innerHTML = '';
  checkedCbs.forEach(function(cb) {
    var sizeId = cb.value;
    var sizeName = cb.getAttribute('data-val') || '';
    var existingQty = (currentVals[sizeId] && currentVals[sizeId].stock !== undefined && currentVals[sizeId].stock !== '') ? currentVals[sizeId].stock : '0';
    var existingSalePrice = (currentVals[sizeId] && currentVals[sizeId].sale_price !== undefined && currentVals[sizeId].sale_price !== '') ? currentVals[sizeId].sale_price : defaultSalePrice;
    var vSku = baseSku + '-' + sizeName.toUpperCase();
    var isOutOfStock = parseInt(existingQty, 10) === 0;

    var tr = document.createElement('tr');
    tr.id = 'add_size_row_' + sizeId;
    tr.innerHTML = 
      '<td class="text-center"><span class="badge bg-primary fw-bold fs-6">' + sizeName + '</span></td>' +
      '<td><code class="add-size-sku-preview">' + vSku + '</code></td>' +
      '<td>' +
        '<div class="input-group input-group-sm">' +
          '<span class="input-group-text"><i class="fa-solid fa-boxes-stacked" style="font-size: 10px;"></i></span>' +
          '<input type="number" min="0" class="form-control text-end add-size-qty-input" name="size_stock[' + sizeId + ']" data-size-id="' + sizeId + '" value="' + escapeHtml(existingQty) + '" placeholder="0" oninput="recalcAddTotalStock()" onblur="if(this.value.trim()===\'\') { this.value=\'0\'; recalcAddTotalStock(); }">' +
        '</div>' +
      '</td>' +
      '<td>' +
        '<div class="input-group input-group-sm">' +
          '<span class="input-group-text">$</span>' +
          '<input type="number" step="0.01" min="0" class="form-control text-end add-size-sale-price-input" name="size_sale_price[' + sizeId + ']" data-size-id="' + sizeId + '" value="' + escapeHtml(existingSalePrice) + '" placeholder="' + escapeHtml(defaultSalePrice || '0.00') + '">' +
        '</div>' +
      '</td>' +
      '<td class="text-center">' +
        '<span class="badge ' + (isOutOfStock ? 'bg-label-danger' : 'bg-label-success') + ' add-size-status-badge">' +
          (isOutOfStock ? 'Out of stock' : 'In stock') +
        '</span>' +
      '</td>';
    tbody.appendChild(tr);
  });

  recalcAddTotalStock();
}

function applyAddStockToAll() {
  var val = document.getElementById('add_quick_stock_val') ? document.getElementById('add_quick_stock_val').value : '10';
  document.querySelectorAll('.add-size-qty-input').forEach(function(inp) {
    inp.value = val;
  });
  recalcAddTotalStock();
}

function applyAddSalePriceToAll() {
  var val = document.getElementById('add_quick_sale_price_val') ? document.getElementById('add_quick_sale_price_val').value : '';
  document.querySelectorAll('.add-size-sale-price-input').forEach(function(inp) {
    inp.value = val;
  });
}

function recalcAddTotalStock() {
  var total = 0;
  document.querySelectorAll('.add-size-qty-input').forEach(function(inp) {
    var qty = parseInt(inp.value, 10) || 0;
    total += qty;
    var row = inp.closest('tr');
    if (row) {
      var badge = row.querySelector('.add-size-status-badge');
      if (badge) {
        if (qty <= 0) {
          badge.className = 'badge bg-label-danger add-size-status-badge';
          badge.textContent = 'Out of stock';
        } else {
          badge.className = 'badge bg-label-success add-size-status-badge';
          badge.textContent = 'In stock';
        }
      }
    }
  });

  var totalEl = document.getElementById('add-total-sizes-stock');
  if (totalEl) {
    totalEl.textContent = total + ' units';
  }

  // Sync with main stock_quantity input
  var mainStockInp = document.getElementById('stock_quantity');
  if (mainStockInp) {
    mainStockInp.value = total;
  }
}

function syncAddSkuWithVariants() {
  var baseSku = (document.getElementById('sku') ? document.getElementById('sku').value.trim() : '') || 'SKU';
  document.querySelectorAll('#add-size-stock-tbody tr').forEach(function(row) {
    var sizeBadge = row.querySelector('span.badge.bg-primary');
    var skuCode = row.querySelector('.add-size-sku-preview');
    if (sizeBadge && skuCode) {
      skuCode.textContent = baseSku + '-' + sizeBadge.textContent.trim().toUpperCase();
    }
  });
}

function updateVariantNameAndSkuPreview() {
  syncAddSkuWithVariants();
}

// Highlights & Specifications dynamic management
function toggleHighlightsPanel(checked) {
  var panel = document.getElementById('highlights_panel');
  if (!panel) return;
  panel.style.display = checked ? 'block' : 'none';
  if (checked) {
    var tbody = document.getElementById('highlights_body');
    if (tbody && tbody.children.length === 0) {
      addHighlightRow('Sleeve', 'Full Sleeve');
    }
  }
}

function addHighlightRow(key = '', val = '') {
  var tbody = document.getElementById('highlights_body');
  if (!tbody) return;
  var tr = document.createElement('tr');
  tr.innerHTML = `
    <td>
      <input type="text" name="highlight_keys[]" class="form-control form-control-sm" placeholder="e.g. Sleeve" value="${escapeHtml(key)}" required>
    </td>
    <td>
      <input type="text" name="highlight_values[]" class="form-control form-control-sm" placeholder="e.g. Full Sleeve" value="${escapeHtml(val)}" required>
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeHighlightRow(this)" title="Delete row">
        <i class="fa-solid fa-trash-can"></i>
      </button>
    </td>
  `;
  tbody.appendChild(tr);
}

function removeHighlightRow(btn) {
  var tr = btn.closest('tr');
  if (tr) tr.remove();
}

function toggleSpecificationsPanel(checked) {
  var panel = document.getElementById('specifications_panel');
  if (!panel) return;
  panel.style.display = checked ? 'block' : 'none';
  if (checked) {
    var tbody = document.getElementById('specifications_body');
    if (tbody && tbody.children.length === 0) {
      addSpecificationRow('Fabric', 'Cotton Blend');
    }
  }
}

function addSpecificationRow(name = '', val = '') {
  var tbody = document.getElementById('specifications_body');
  if (!tbody) return;
  var tr = document.createElement('tr');
  tr.innerHTML = `
    <td>
      <input type="text" name="spec_names[]" class="form-control form-control-sm" placeholder="e.g. Fabric" value="${escapeHtml(name)}" required>
    </td>
    <td>
      <input type="text" name="spec_values[]" class="form-control form-control-sm" placeholder="e.g. Cotton Blend" value="${escapeHtml(val)}" required>
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecificationRow(this)" title="Delete row">
        <i class="fa-solid fa-trash-can"></i>
      </button>
    </td>
  `;
  tbody.appendChild(tr);
}

function removeSpecificationRow(btn) {
  var tr = btn.closest('tr');
  if (tr) tr.remove();
}

function escapeHtml(text) {
  if (!text) return '';
  return text
    .toString()
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
</script>
