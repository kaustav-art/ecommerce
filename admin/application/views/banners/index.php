<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Catalog /</span> Home Page Banners & Sliders</h4>
    <a href="<?= base_url('../website'); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
      <i class="fa-solid fa-eye me-1"></i> Preview Homepage
    </a>
  </div>

  <div class="row">
    <!-- Add / Edit Form -->
    <div class="col-lg-4 col-md-5">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0" id="form-title">Add New Slider Banner</h5>
          <span class="badge bg-label-primary">Dynamic Homepage</span>
        </div>
        <div class="card-body">
          <form action="<?= site_url('banners'); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="banner_id" value="" />

            <div class="mb-3">
              <label class="form-label" for="banner_title">Main Heading / Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="banner_title" name="title" required placeholder="e.g. Flash Sale Madness" />
            </div>

            <div class="mb-3">
              <label class="form-label" for="banner_subtitle">Subheading / Badge Text</label>
              <input type="text" class="form-control" id="banner_subtitle" name="subtitle" placeholder="e.g. BIKINIS & SWIMSUITS" />
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="banner_btn_text">Button Label</label>
                <input type="text" class="form-control" id="banner_btn_text" name="button_text" value="Explore Collection" />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="banner_btn_link">Button Link</label>
                <input type="text" class="form-control" id="banner_btn_link" name="button_link" value="shop" placeholder="shop or shop/category-slug" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="banner_file">Upload New Banner Image</label>
              <input type="file" class="form-control" id="banner_file" name="image_file" accept="image/*" />
              <small class="text-muted">Recommended: 1920x800px or similar slider aspect ratio.</small>
            </div>

            <div class="mb-3">
              <label class="form-label" for="banner_image_path">Or Existing Image Path</label>
              <input type="text" class="form-control" id="banner_image_path" name="image_path" placeholder="e.g. slider/slider-women1.jpg" />
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="banner_sort">Sort Order</label>
                <input type="number" class="form-control" id="banner_sort" name="sort_order" value="0" />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="banner_status">Status</label>
                <select class="form-select" id="banner_status" name="status">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Save Banner</button>
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetForm()">Reset</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Banner List Table -->
    <div class="col-lg-8 col-md-7">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Active Sliders & Banners</h5>
          <span class="text-muted small">Controls the main slideshow on the homepage</span>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th style="width: 120px;">Preview</th>
                <th>Content</th>
                <th>Button</th>
                <th>Sort</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($banners)): ?>
                <?php foreach ($banners as $b): ?>
                  <tr>
                    <td>
                      <div class="rounded overflow-hidden border" style="width: 100px; height: 55px; background: #f8f9fa;">
                        <img
                          src="<?= base_url('../website/assets/images/' . $b['image']); ?>"
                          alt="<?= html_escape($b['title']); ?>"
                          class="w-100 h-100"
                          style="object-fit: cover;"
                          onerror="this.src='<?= base_url('../website/assets/images/slider/slider-women1.jpg'); ?>'" />
                      </div>
                    </td>
                    <td>
                      <?php if (!empty($b['subtitle'])): ?>
                        <span class="badge bg-label-secondary small mb-1"><?= html_escape($b['subtitle']); ?></span><br>
                      <?php endif; ?>
                      <strong><?= html_escape($b['title']); ?></strong>
                    </td>
                    <td>
                      <span class="badge bg-label-info"><?= html_escape($b['button_text']); ?></span>
                      <div class="text-muted small"><code><?= html_escape($b['button_link']); ?></code></div>
                    </td>
                    <td><span class="badge bg-label-dark"><?= (int)$b['sort_order']; ?></span></td>
                    <td>
                      <a href="<?= site_url('banners/toggle/' . $b['id']); ?>" class="text-decoration-none">
                        <?= ($b['status'] === 'active')
                            ? '<span class="badge bg-label-success">Active</span>'
                            : '<span class="badge bg-label-danger">Inactive</span>'; ?>
                      </a>
                    </td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-xs btn-outline-primary me-1"
                        onclick="editBanner(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8'); ?>)"
                        title="Edit Banner">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <a
                        href="<?= site_url('banners/delete/' . $b['id']); ?>"
                        class="btn btn-xs btn-outline-danger"
                        onclick="return confirm('Delete this banner from homepage?');"
                        title="Delete Banner">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No banners found. Add a banner to display on the homepage slider.</td>
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
function editBanner(b) {
  document.getElementById('form-title').innerText = 'Edit Slider: ' + b.title;
  document.getElementById('banner_id').value = b.id;
  document.getElementById('banner_title').value = b.title;
  document.getElementById('banner_subtitle').value = b.subtitle || '';
  document.getElementById('banner_btn_text').value = b.button_text || 'Explore Collection';
  document.getElementById('banner_btn_link').value = b.button_link || 'shop';
  document.getElementById('banner_image_path').value = b.image || '';
  document.getElementById('banner_sort').value = b.sort_order || 0;
  document.getElementById('banner_status').value = b.status || 'active';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
  document.getElementById('form-title').innerText = 'Add New Slider Banner';
  document.getElementById('banner_id').value = '';
  document.getElementById('banner_title').value = '';
  document.getElementById('banner_subtitle').value = '';
  document.getElementById('banner_btn_text').value = 'Explore Collection';
  document.getElementById('banner_btn_link').value = 'shop';
  document.getElementById('banner_image_path').value = '';
  document.getElementById('banner_sort').value = 0;
  document.getElementById('banner_status').value = 'active';
}
</script>
