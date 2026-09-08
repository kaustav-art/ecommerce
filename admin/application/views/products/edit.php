<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Products /</span> Edit Product</h4>
    <a href="<?= site_url('products'); ?>" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
    </a>
  </div>

  <form action="<?= site_url('products/edit/' . $product['id']); ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Product Details</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label" for="title">Product Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="title" name="title" value="<?= html_escape($product['title']); ?>" required />
            </div>
            <div class="mb-3">
              <label class="form-label" for="short_description">Short Description</label>
              <textarea class="form-control" id="short_description" name="short_description" rows="2"><?= html_escape($product['short_description']); ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label" for="description">Full Description</label>
              <textarea class="form-control" id="description" name="description" rows="5"><?= html_escape($product['description']); ?></textarea>
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
                  <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price']; ?>" required />
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="sale_price">Sale Price (Optional)</label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" value="<?= $product['sale_price']; ?>" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">SKU (Read-only)</label>
                <input type="text" class="form-control bg-light" value="<?= html_escape($product['sku']); ?>" readonly />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="stock_quantity">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= $product['stock_quantity']; ?>" required />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-4">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Organization & Image</h5>
          </div>
          <div class="card-body">
            <?php $existing_gallery = json_decode($product['gallery_images'], true) ?: []; ?>
            <!-- Main Product Image -->
            <div class="mb-3">
              <label class="form-label fw-semibold" for="main_image_file">Main Product Image</label>
              <div class="border rounded p-2 mb-2 bg-light text-center">
                <img
                  id="main_product_preview"
                  src="<?= base_url('../website/assets/images/' . $product['main_image']); ?>"
                  alt="Product Preview"
                  class="rounded img-fluid"
                  style="max-height: 150px; object-fit: contain;"
                  onerror="this.src='<?= base_url('assets/img/elements/1.jpg'); ?>'" />
              </div>
              <input
                type="file"
                class="form-control form-control-sm"
                id="main_image_file"
                name="main_image_file"
                accept="image/*"
                onchange="previewProductMainImage(this)" />
              <input type="hidden" name="current_main_image" value="<?= html_escape($product['main_image']); ?>" />
              <small class="text-muted d-block mt-1" style="font-size: 11px;">Upload a new image to replace the current main image.</small>
            </div>

            <!-- Additional Gallery Images -->
            <div class="mb-3">
              <label class="form-label fw-semibold" for="gallery_files">Upload Gallery Images</label>
              <input
                type="file"
                class="form-control form-control-sm"
                id="gallery_files"
                name="gallery_files[]"
                accept="image/*"
                multiple
                onchange="previewGalleryFiles(this)" />
              <small class="text-muted d-block mt-1" style="font-size: 11px;">Select additional images for product gallery.</small>
              <div id="gallery_preview_container" class="d-flex flex-wrap gap-2 mt-2"></div>

              <?php if (!empty($existing_gallery)): ?>
                <label class="form-label small fw-semibold text-secondary mt-3 mb-1">Existing Gallery (<?= count($existing_gallery); ?>):</label>
                <div class="d-flex flex-wrap gap-2">
                  <?php foreach ($existing_gallery as $g_idx => $g_file): ?>
                    <div class="position-relative border rounded p-1 bg-white shadow-sm" id="gal_item_<?= $g_idx; ?>" style="width: 50px; height: 50px;">
                      <img src="<?= base_url('../website/assets/images/' . $g_file); ?>" class="w-100 h-100 object-fit-cover rounded" alt="Gallery" onerror="this.src='<?= base_url('assets/img/elements/1.jpg'); ?>'">
                      <input type="hidden" name="existing_gallery[]" value="<?= html_escape($g_file); ?>" id="gal_input_<?= $g_idx; ?>">
                      <button type="button" class="btn btn-danger btn-xs position-absolute top-0 end-0 p-0 rounded-circle" style="width: 16px; height: 16px; line-height: 1; transform: translate(30%, -30%);" onclick="removeExistingGallery(<?= $g_idx; ?>)" title="Remove from gallery">&times;</button>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label" for="category_id">Category</label>
              <select class="form-select" id="category_id" name="category_id" required>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id']; ?>" <?= ($product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                    <?= html_escape($cat['breadcrumb_path'] ?? $cat['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="brand_id">Brand</label>
              <select class="form-select" id="brand_id" name="brand_id">
                <option value="">None</option>
                <?php foreach ($brands as $b): ?>
                  <option value="<?= $b['id']; ?>" <?= ($product['brand_id'] == $b['id']) ? 'selected' : ''; ?>>
                    <?= html_escape($b['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="status">Publication Status</label>
              <select class="form-select" id="status" name="status">
                <option value="published" <?= ($product['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
                <option value="draft" <?= ($product['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
              </select>
            </div>

            <div class="border-top pt-3">
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= ($product['is_featured'] == 1) ? 'checked' : ''; ?> />
                <label class="form-check-label" for="is_featured">Featured Product</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="is_trending" name="is_trending" value="1" <?= ($product['is_trending'] == 1) ? 'checked' : ''; ?> />
                <label class="form-check-label" for="is_trending">Trending Badge</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_new" name="is_new" value="1" <?= ($product['is_new'] == 1) ? 'checked' : ''; ?> />
                <label class="form-check-label" for="is_new">New Arrival Badge</label>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fa-solid fa-floppy-disk me-1"></i> Update Product
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
function previewProductMainImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('main_product_preview').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function previewGalleryFiles(input) {
  var container = document.getElementById('gallery_preview_container');
  container.innerHTML = '';
  if (input.files) {
    Array.from(input.files).forEach(function(file) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var thumb = document.createElement('div');
        thumb.className = 'border rounded p-1 bg-white shadow-sm';
        thumb.style.width = '48px';
        thumb.style.height = '48px';
        thumb.innerHTML = '<img src="' + e.target.result + '" class="w-100 h-100 object-fit-cover rounded" alt="Gallery Preview">';
        container.appendChild(thumb);
      };
      reader.readAsDataURL(file);
    });
  }
}

function removeExistingGallery(idx) {
  var item = document.getElementById('gal_item_' + idx);
  var input = document.getElementById('gal_input_' + idx);
  if (item) item.remove();
  if (input) input.remove();
}
</script>
