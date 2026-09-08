<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Products /</span> Add Product</h4>
    <a href="<?= site_url('products'); ?>" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
    </a>
  </div>

  <form action="<?= site_url('products/add'); ?>" method="POST" enctype="multipart/form-data">
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
              <div class="col-md-6 mb-3">
                <label class="form-label" for="sale_price">Sale Price (Optional)</label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" placeholder="79.00" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="sku">SKU Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="sku" name="sku" placeholder="e.g. MOD-W-109" required />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="stock_quantity">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="50" required />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Organize, Category, Image -->
      <div class="col-12 col-lg-4">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Organization</h5>
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
                  style="max-height: 150px; object-fit: contain;"
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
              <label class="form-label fw-semibold" for="gallery_files">Additional Gallery Images</label>
              <input
                type="file"
                class="form-control form-control-sm"
                id="gallery_files"
                name="gallery_files[]"
                accept="image/*"
                multiple
                onchange="previewGalleryFiles(this)"
              />
              <small class="text-muted d-block mt-1" style="font-size: 11px;">Select multiple images for the product gallery</small>
              <div id="gallery_preview_container" class="d-flex flex-wrap gap-2 mt-2"></div>
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
          <div class="card-footer">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fa-solid fa-floppy-disk me-1"></i> Save Product
            </button>
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
</script>
