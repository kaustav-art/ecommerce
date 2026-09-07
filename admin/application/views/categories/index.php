<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Catalog /</span> Categories & Subcategories</h4>
      <p class="text-muted small m-0">Supports multi-level category hierarchy: Category &gt; Subcategory &gt; Sub-subcategory (a &gt; b &gt; c &gt; d)</p>
    </div>
    <a href="<?= base_url('../website/shop'); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
      <i class="fa-solid fa-shop me-1"></i> View Shop Catalog
    </a>
  </div>

  <div class="row">
    <!-- Add / Edit Form -->
    <div class="col-lg-4 col-md-5">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0" id="form-title">Add New Category</h5>
          <span class="badge bg-label-info">Multilevel Tree</span>
        </div>
        <div class="card-body">
          <form action="<?= site_url('categories'); ?>" method="POST">
            <input type="hidden" name="id" id="cat_id" value="" />

            <div class="mb-3">
              <label class="form-label" for="cat_parent">Parent Category</label>
              <select class="form-select" id="cat_parent" name="parent_id">
                <option value="0">None (Top-Level Main Category)</option>
                <?php if (!empty($parent_options)): ?>
                  <?php foreach ($parent_options as $p): ?>
                    <option value="<?= $p['id']; ?>"><?= html_escape($p['full_path']); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <small class="text-muted">Select a parent to create a subcategory or sub-subcategory (a &gt; b &gt; c).</small>
            </div>

            <div class="mb-3">
              <label class="form-label" for="cat_name">Category Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="cat_name" name="name" required placeholder="e.g. Dresses or Smartphones" />
            </div>

            <div class="mb-3">
              <label class="form-label" for="cat_desc">Description</label>
              <textarea class="form-control" id="cat_desc" name="description" rows="3" placeholder="Category summary..."></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label" for="cat_image">Image Path</label>
              <div class="d-flex align-items-center gap-2">
                <input type="text" class="form-control" id="cat_image" name="image" placeholder="e.g. collections/collection-circle/cls-circle1.jpg" oninput="updateCatPreview(this.value)" />
                <img id="cat_image_preview" src="" class="rounded-circle border shadow-sm flex-shrink-0" style="width: 40px; height: 40px; object-fit: cover; aspect-ratio: 1/1; display: none;" alt="Preview" onerror="this.style.display='none'" />
              </div>
              <small class="text-muted d-block mt-1">Image will always be displayed as a perfect circle on the website, regardless of upload dimensions.</small>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="cat_sort">Sort Order</label>
                <input type="number" class="form-control" id="cat_sort" name="sort_order" value="0" />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="cat_status">Status</label>
                <select class="form-select" id="cat_status" name="status">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="cat_featured" name="is_featured" value="1" />
              <label class="form-check-label" for="cat_featured">Feature on Home Page & Shop Top</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Save Category</button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetForm()">Reset Form</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Category List Table -->
    <div class="col-lg-8 col-md-7">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">All Categories & Hierarchy</h5>
          <span class="text-muted small">Tree representation</span>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Category / Hierarchy</th>
                <th>Slug</th>
                <th>Parent</th>
                <th>Products</th>
                <th>Featured</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <?php if (!empty($cat['image'])): ?>
                          <img src="<?= base_url('../website/assets/images/' . $cat['image']); ?>" class="rounded-circle me-2 border shadow-sm" style="width: 36px; height: 36px; object-fit: cover; aspect-ratio: 1/1;" onerror="this.style.display='none'" />
                        <?php endif; ?>
                        <div>
                          <strong><?= html_escape($cat['name']); ?></strong>
                          <?php if (!empty($cat['breadcrumb_path']) && $cat['breadcrumb_path'] !== $cat['name']): ?>
                            <div class="text-muted small"><i class="fa-solid fa-sitemap me-1"></i><?= html_escape($cat['breadcrumb_path']); ?></div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </td>
                    <td><code><?= html_escape($cat['slug']); ?></code></td>
                    <td>
                      <?php if ($cat['parent_id'] > 0): ?>
                        <span class="badge bg-label-info"><?= html_escape($cat['parent_name']); ?></span>
                      <?php else: ?>
                        <span class="badge bg-label-secondary">Root (Main)</span>
                      <?php endif; ?>
                    </td>
                    <td><span class="badge bg-label-primary"><?= (int)$cat['product_count']; ?> Items</span></td>
                    <td>
                      <?= ($cat['is_featured'] == 1) ? '<span class="badge bg-label-success">Yes</span>' : '<span class="badge bg-label-secondary">No</span>'; ?>
                    </td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-xs btn-outline-primary me-1"
                        onclick="editCategory(<?= htmlspecialchars(json_encode($cat), ENT_QUOTES, 'UTF-8'); ?>)"
                        title="Edit Category">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a
                        href="<?= site_url('categories/delete/' . $cat['id']); ?>"
                        class="btn btn-xs btn-outline-danger"
                        onclick="return confirm('Delete this category? Subcategories will be moved to root.');"
                        title="Delete Category">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No categories created yet.</td>
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
var imageBasePath = '<?= base_url("../website/assets/images/"); ?>/';

function updateCatPreview(val) {
  var preview = document.getElementById('cat_image_preview');
  if (val && val.trim() !== '') {
    var src = val.startsWith('http') ? val : imageBasePath + val.replace(/^\/+/, '');
    preview.src = src;
    preview.style.display = 'inline-block';
  } else {
    preview.style.display = 'none';
  }
}

function editCategory(cat) {
  document.getElementById('form-title').innerText = 'Edit Category: ' + cat.name;
  document.getElementById('cat_id').value = cat.id;
  document.getElementById('cat_name').value = cat.name;
  document.getElementById('cat_parent').value = cat.parent_id || 0;
  document.getElementById('cat_desc').value = cat.description || '';
  document.getElementById('cat_image').value = cat.image || '';
  updateCatPreview(cat.image || '');
  document.getElementById('cat_sort').value = cat.sort_order || 0;
  document.getElementById('cat_status').value = cat.status || 'active';
  document.getElementById('cat_featured').checked = (cat.is_featured == 1);
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
  document.getElementById('form-title').innerText = 'Add New Category';
  document.getElementById('cat_id').value = '';
  document.getElementById('cat_name').value = '';
  document.getElementById('cat_parent').value = '0';
  document.getElementById('cat_desc').value = '';
  document.getElementById('cat_image').value = '';
  updateCatPreview('');
  document.getElementById('cat_sort').value = 0;
  document.getElementById('cat_status').value = 'active';
  document.getElementById('cat_featured').checked = false;
}
</script>
