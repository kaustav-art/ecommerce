        <!-- Breadcrumb -->
        <div class="bg-light py-3 border-bottom">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('shop'); ?>">Shop</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('shop/' . $product['category_slug']); ?>"><?= html_escape($product['category_name']); ?></a></li>
                        <li class="breadcrumb-item active text-truncate" style="max-width: 300px;"><?= html_escape($product['title']); ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Product Overview -->
        <section class="py-5">
            <div class="container">
                <div class="row gx-5">
                    <!-- Left: Gallery -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="border rounded p-2 bg-white text-center mb-3 shadow-sm position-relative">
                            <img
                                id="main-product-img"
                                src="<?= base_url('assets/images/' . $product['main_image']); ?>"
                                alt="<?= html_escape($product['title']); ?>"
                                class="img-fluid rounded"
                                style="max-height: 480px; object-fit: contain;"
                                onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                            
                            <?php if (!empty($product['sale_price'])): ?>
                                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 fs-6">SALE</span>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <div
                                class="border rounded p-1 cursor-pointer gallery-thumb active-thumb"
                                style="width: 70px; height: 70px; cursor: pointer;"
                                onclick="document.getElementById('main-product-img').src='<?= base_url('assets/images/' . $product['main_image']); ?>'">
                                <img src="<?= base_url('assets/images/' . $product['main_image']); ?>" class="w-100 h-100 object-fit-cover rounded" alt="Thumb">
                            </div>
                            <?php if (!empty($product['gallery_images_decoded'])): ?>
                                <?php foreach ($product['gallery_images_decoded'] as $g_img): ?>
                                    <div
                                        class="border rounded p-1 cursor-pointer gallery-thumb"
                                        style="width: 70px; height: 70px; cursor: pointer;"
                                        onclick="document.getElementById('main-product-img').src='<?= base_url('assets/images/' . $g_img); ?>'">
                                        <img src="<?= base_url('assets/images/' . $g_img); ?>" class="w-100 h-100 object-fit-cover rounded" alt="Thumb" onerror="this.parentElement.style.display='none'">
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (!empty($product['variants'])): ?>
                                <?php foreach ($product['variants'] as $v): if (!empty($v['image'])): ?>
                                    <div
                                        class="border rounded p-1 cursor-pointer gallery-thumb"
                                        style="width: 70px; height: 70px; cursor: pointer;"
                                        title="<?= html_escape($v['title']); ?>"
                                        onclick="document.getElementById('main-product-img').src='<?= base_url('assets/images/' . $v['image']); ?>'">
                                        <img src="<?= base_url('assets/images/' . $v['image']); ?>" class="w-100 h-100 object-fit-cover rounded" alt="<?= html_escape($v['title']); ?>" onerror="this.parentElement.style.display='none'">
                                    </div>
                                <?php endif; endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right: Product Info -->
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold"><?= html_escape($product['brand_name'] ?? 'Modave Collection'); ?></small>
                                <h2 class="fw-bold mt-1 mb-2"><?= html_escape($product['title']); ?></h2>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="<?= site_url('wishlist/toggle/' . $product['id']); ?>" class="btn btn-outline-danger btn-sm rounded-circle p-2" title="Add to Wishlist" style="width: 38px; height: 38px;">
                                    <i class="fa-<?= $is_in_wishlist ? 'solid text-danger' : 'regular'; ?> fa-heart"></i>
                                </a>
                                <a href="<?= site_url('compare/add/' . $product['id']); ?>" class="btn btn-outline-secondary btn-sm rounded-circle p-2 <?= $is_in_compare ? 'active bg-secondary text-white' : ''; ?>" title="Compare Product" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-code-compare"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Rating & SKU -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="text-warning">
                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                    <i class="fa-<?= ($s <= round($product['rating'])) ? 'solid' : 'regular'; ?> fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="small text-muted">(<?= $product['reviews_count']; ?> reviews)</span>
                            <span class="text-muted">•</span>
                            <span class="small text-muted">SKU: <code id="sku-display"><?= html_escape($product['sku']); ?></code></span>
                        </div>

                        <!-- Price Section -->
                        <div class="mb-3" id="price-container">
                            <?php if (!empty($product['sale_price'])): ?>
                                <span class="fs-2 fw-bold text-danger" id="current-price"><?= $currency_symbol . number_format($product['sale_price'], 2); ?></span>
                                <span class="fs-4 text-muted text-decoration-line-through ms-3" id="old-price"><?= $currency_symbol . number_format($product['price'], 2); ?></span>
                                <span class="badge bg-danger ms-2" id="save-badge">Save <?= round((($product['price'] - $product['sale_price']) / $product['price']) * 100); ?>%</span>
                            <?php else: ?>
                                <span class="fs-2 fw-bold text-dark" id="current-price"><?= $currency_symbol . number_format($product['price'], 2); ?></span>
                                <span class="fs-4 text-muted text-decoration-line-through ms-3 d-none" id="old-price"></span>
                                <span class="badge bg-danger ms-2 d-none" id="save-badge"></span>
                            <?php endif; ?>
                        </div>

                        <!-- Short Description -->
                        <p class="text-muted mb-4"><?= nl2br(html_escape($product['short_description'])); ?></p>

                        <!-- Variants Selector (If Variable Product) -->
                        <?php if (!empty($product['variants']) && !empty($product['attributes'])): ?>
                            <div class="p-3 bg-light border rounded mb-4" id="variant-selection-box">
                                <h6 class="fw-bold mb-3"><i class="fa-solid fa-sliders text-primary me-2"></i>Select Options</h6>

                                <?php foreach ($product['attributes'] as $attr_slug => $attr): ?>
                                    <div class="mb-3 attr-group" data-attr-id="<?= $attr['id']; ?>" data-attr-slug="<?= $attr_slug; ?>">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-semibold small text-uppercase"><?= html_escape($attr['name']); ?>:</span>
                                            <span class="small text-muted selected-attr-label" id="label-<?= $attr_slug; ?>"></span>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <?php foreach ($attr['values'] as $val): ?>
                                                <?php if ($attr['type'] === 'color' && !empty($val['color_code'])): ?>
                                                    <!-- Color Swatch Circle -->
                                                    <button
                                                        type="button"
                                                        class="variant-btn variant-color-circle"
                                                        data-attr-id="<?= $attr['id']; ?>"
                                                        data-val-id="<?= $val['id']; ?>"
                                                        data-val-name="<?= html_escape($val['value']); ?>"
                                                        title="<?= html_escape($val['value']); ?>"
                                                        style="background-color: <?= html_escape($val['color_code']); ?>; width: 34px; height: 34px; border-radius: 50%; border: 2px solid #ddd; outline: none; cursor: pointer; transition: all 0.2s;">
                                                    </button>
                                                <?php else: ?>
                                                    <!-- Button/Pill Chip -->
                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-dark btn-sm variant-btn variant-pill px-3 py-1"
                                                        data-attr-id="<?= $attr['id']; ?>"
                                                        data-val-id="<?= $val['id']; ?>"
                                                        data-val-name="<?= html_escape($val['value']); ?>">
                                                        <?= html_escape($val['value']); ?>
                                                    </button>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Stock Status -->
                        <div class="mb-4" id="stock-status-container">
                            <?php if ($product['stock_quantity'] > 0): ?>
                                <span class="badge bg-success-subtle text-success border border-success px-3 py-2" id="stock-badge">
                                    <i class="fa-solid fa-check me-1"></i> In Stock (<?= $product['stock_quantity']; ?> units available)
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger px-3 py-2" id="stock-badge">
                                    <i class="fa-solid fa-xmark me-1"></i> Out of Stock
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Add to Cart Form -->
                        <form action="<?= site_url('cart/add'); ?>" method="POST" class="mb-4" id="addToCartForm">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                            <input type="hidden" name="variant_id" id="selected-variant-id" value="">
                            
                            <div class="d-flex gap-3 align-items-center mb-3">
                                <div class="input-group" style="width: 130px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="var q = document.getElementById('qty'); if (q.value > 1) q.value--;">-</button>
                                    <input type="number" name="quantity" id="qty" class="form-control text-center" value="1" min="1" max="<?= $product['stock_quantity']; ?>">
                                    <button class="btn btn-outline-secondary" type="button" onclick="var q = document.getElementById('qty'); q.value++;">+</button>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg px-4 flex-grow-1" id="add-to-cart-btn" <?= ($product['stock_quantity'] <= 0) ? 'disabled' : ''; ?>>
                                    <i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart
                                </button>
                            </div>
                        </form>

                        <!-- Payment & Shipping Guarantees -->
                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex align-items-center gap-2 mb-2 small text-muted">
                                <i class="fa-solid fa-truck-fast text-primary fs-5"></i>
                                <span>Fast dispatch within 24 hours. Free standard shipping over $150.</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 small text-muted">
                                <i class="fa-solid fa-shield-halved text-success fs-5"></i>
                                <span>Secure encrypted checkout via <strong>Stripe, Razorpay, PayU & COD</strong>.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Frequently Bought Together Bundle -->
                <?php if (!empty($frequently_bought_together)): ?>
                    <div class="card border shadow-sm mt-5 p-4 bg-light">
                        <h4 class="fw-bold mb-3"><i class="fa-solid fa-layer-group text-primary me-2"></i>Frequently Bought Together</h4>
                        <form action="<?= site_url('cart/add_bundle'); ?>" method="POST">
                            <div class="row align-items-center gy-3">
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center flex-wrap gap-3">
                                        <!-- Main Product Thumb -->
                                        <div class="border rounded p-2 bg-white text-center" style="width: 110px;">
                                            <img src="<?= base_url('assets/images/' . $product['main_image']); ?>" class="img-fluid rounded mb-1" style="height: 70px; object-fit: contain;">
                                            <div class="small fw-bold text-truncate"><?= html_escape($product['title']); ?></div>
                                            <div class="small text-danger fw-bold"><?= $currency_symbol . number_format($product['sale_price'] ?: $product['price'], 2); ?></div>
                                        </div>

                                        <?php $bundle_total = (float) ($product['sale_price'] ?: $product['price']); ?>

                                        <?php foreach ($frequently_bought_together as $fbt): ?>
                                            <?php
                                                $fbt_price = (float) ($fbt['sale_price'] ?: $fbt['price']);
                                                $bundle_total += $fbt_price;
                                            ?>
                                            <div class="fs-4 text-muted fw-bold">+</div>
                                            <div class="border rounded p-2 bg-white text-center" style="width: 110px;">
                                                <img src="<?= base_url('assets/images/' . $fbt['main_image']); ?>" class="img-fluid rounded mb-1" style="height: 70px; object-fit: contain;">
                                                <div class="small fw-bold text-truncate"><?= html_escape($fbt['title']); ?></div>
                                                <div class="small text-danger fw-bold"><?= $currency_symbol . number_format($fbt_price, 2); ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Bundle Checkboxes -->
                                    <div class="mt-3">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $product['id']; ?>" checked disabled>
                                            <label class="form-check-label small">
                                                <strong>This item:</strong> <?= html_escape($product['title']); ?> (<?= $currency_symbol . number_format($product['sale_price'] ?: $product['price'], 2); ?>)
                                            </label>
                                            <input type="hidden" name="product_ids[]" value="<?= $product['id']; ?>">
                                        </div>
                                        <?php foreach ($frequently_bought_together as $fbt): ?>
                                            <div class="form-check mb-1">
                                                <input class="form-check-input bundle-check" type="checkbox" name="product_ids[]" value="<?= $fbt['id']; ?>" checked data-price="<?= $fbt['sale_price'] ?: $fbt['price']; ?>">
                                                <label class="form-check-label small">
                                                    <a href="<?= site_url('product/' . $fbt['slug']); ?>" class="text-dark text-decoration-none"><?= html_escape($fbt['title']); ?></a>
                                                    (<?= $currency_symbol . number_format($fbt['sale_price'] ?: $fbt['price'], 2); ?>)
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="col-lg-4 text-lg-end">
                                    <div class="text-muted small mb-1">Bundle Total:</div>
                                    <div class="fs-2 fw-bold text-primary mb-3" id="bundle-total-display"><?= $currency_symbol . number_format($bundle_total, 2); ?></div>
                                    <button type="submit" class="btn btn-dark btn-lg w-100">
                                        <i class="fa-solid fa-plus me-1"></i> Add Bundle to Cart
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Tabs: Description, Specifications & Reviews -->
                <div class="mt-5 pt-4 border-top">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">Full Description</button>
                        </li>
                        <?php if (!empty($product['specifications'])): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Specifications</button>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Customer Reviews (<?= count($product['reviews']); ?>)</button>
                        </li>
                    </ul>
                    <div class="tab-content border border-top-0 rounded-bottom p-4 bg-white" id="productTabsContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="desc" role="tabpanel">
                            <p><?= nl2br(html_escape($product['description'])); ?></p>
                        </div>

                        <!-- Specifications Tab -->
                        <?php if (!empty($product['specifications'])): ?>
                            <div class="tab-pane fade" id="specs" role="tabpanel">
                                <h5 class="fw-bold mb-3">Technical Specifications</h5>
                                <div class="table-responsive" style="max-width: 700px;">
                                    <table class="table table-striped table-bordered align-middle">
                                        <tbody>
                                            <?php foreach ($product['specifications'] as $spec): ?>
                                                <tr>
                                                    <th class="bg-light text-muted" style="width: 35%;"><?= html_escape($spec['spec_name']); ?></th>
                                                    <td><?= html_escape($spec['spec_value']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-7 mb-4 mb-lg-0">
                                    <h5 class="fw-bold mb-3">Customer Feedback</h5>
                                    <?php if (!empty($product['reviews'])): ?>
                                        <?php foreach ($product['reviews'] as $rev): ?>
                                            <div class="border-bottom pb-3 mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <strong><?= html_escape($rev['customer_name']); ?></strong>
                                                        <?php if (!empty($rev['is_verified_purchase'])): ?>
                                                            <span class="badge bg-success-subtle text-success ms-2 small"><i class="fa-solid fa-circle-check"></i> Verified Buyer</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <small class="text-muted"><?= date('M d, Y', strtotime($rev['created_at'])); ?></small>
                                                </div>
                                                <div class="text-warning small mb-2">
                                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                                        <i class="fa-<?= ($s <= $rev['rating']) ? 'solid' : 'regular'; ?> fa-star"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <p class="text-muted small mb-0"><?= nl2br(html_escape($rev['review'])); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No reviews yet for this product. Be the first to share your thoughts!</p>
                                    <?php endif; ?>
                                </div>

                                <div class="col-lg-5">
                                    <div class="card bg-light border p-3">
                                        <h5 class="fw-bold mb-3">Write a Review</h5>
                                        <form action="<?= site_url('product/review'); ?>" method="POST">
                                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                            <input type="hidden" name="product_slug" value="<?= $product['slug']; ?>">

                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Your Name</label>
                                                <input type="text" name="name" class="form-control form-control-sm" value="<?= html_escape($current_user['first_name'] ?? ''); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Email Address</label>
                                                <input type="email" name="email" class="form-control form-control-sm" value="<?= html_escape($current_user['email'] ?? ''); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Star Rating</label>
                                                <select name="rating" class="form-select form-select-sm" required>
                                                    <option value="5">⭐⭐⭐⭐⭐ (5 Stars - Excellent)</option>
                                                    <option value="4">⭐⭐⭐⭐ (4 Stars - Good)</option>
                                                    <option value="3">⭐⭐⭐ (3 Stars - Average)</option>
                                                    <option value="2">⭐⭐ (2 Stars - Fair)</option>
                                                    <option value="1">⭐ (1 Star - Poor)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Your Review</label>
                                                <textarea name="review" class="form-control form-control-sm" rows="3" placeholder="Tell us about the quality, sizing, and comfort..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Submit Review</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recently Viewed Products -->
                <?php if (!empty($recently_viewed_products)): ?>
                    <div class="mt-5 pt-4">
                        <h4 class="fw-bold mb-4"><i class="fa-regular fa-clock text-primary me-2"></i>Recently Viewed Products</h4>
                        <div class="row g-4">
                            <?php foreach ($recently_viewed_products as $rvp): ?>
                                <div class="col-lg-3 col-md-6 col-6">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden product-card">
                                        <div class="bg-white text-center" style="height: 200px;">
                                            <a href="<?= site_url('product/' . $rvp['slug']); ?>">
                                                <img src="<?= base_url('assets/images/' . $rvp['main_image']); ?>" class="w-100 h-100 object-fit-cover" alt="<?= html_escape($rvp['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title text-truncate mb-1">
                                                <a href="<?= site_url('product/' . $rvp['slug']); ?>" class="text-dark text-decoration-none">
                                                    <?= html_escape($rvp['title']); ?>
                                                </a>
                                            </h6>
                                            <div class="fw-bold text-dark mb-0"><?= $currency_symbol . number_format($rvp['sale_price'] ?: $rvp['price'], 2); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Related Products -->
                <?php if (!empty($related_products)): ?>
                    <div class="mt-5 pt-4">
                        <h4 class="fw-bold mb-4">Related Products You May Like</h4>
                        <div class="row g-4">
                            <?php foreach ($related_products as $rp): ?>
                                <div class="col-lg-3 col-md-6 col-6">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden product-card">
                                        <div class="bg-white text-center" style="height: 200px;">
                                            <a href="<?= site_url('product/' . $rp['slug']); ?>">
                                                <img src="<?= base_url('assets/images/' . $rp['main_image']); ?>" class="w-100 h-100 object-fit-cover" alt="<?= html_escape($rp['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title text-truncate mb-2">
                                                <a href="<?= site_url('product/' . $rp['slug']); ?>" class="text-dark text-decoration-none">
                                                    <?= html_escape($rp['title']); ?>
                                                </a>
                                            </h6>
                                            <div class="fw-bold text-dark mb-0"><?= $currency_symbol . number_format($rp['sale_price'] ?: $rp['price'], 2); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Variant Dynamic Selection JavaScript -->
        <?php if (!empty($product['variants'])): ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var variants = <?= json_encode($product['variants']); ?>;
                var currencySymbol = "<?= $currency_symbol; ?>";
                var selectedAttrs = {};

                var priceCurrent = document.getElementById('current-price');
                var priceOld = document.getElementById('old-price');
                var saveBadge = document.getElementById('save-badge');
                var skuDisplay = document.getElementById('sku-display');
                var stockBadge = document.getElementById('stock-badge');
                var variantIdInput = document.getElementById('selected-variant-id');
                var mainImg = document.getElementById('main-product-img');
                var addToCartBtn = document.getElementById('add-to-cart-btn');
                var qtyInput = document.getElementById('qty');

                // Helper to update active UI button state
                function highlightSelected(btn) {
                    var group = btn.closest('.attr-group');
                    group.querySelectorAll('.variant-btn').forEach(function(b) {
                        b.classList.remove('active', 'border-primary', 'shadow');
                        if (b.classList.contains('variant-pill')) {
                            b.classList.remove('btn-dark');
                            b.classList.add('btn-outline-dark');
                        } else if (b.classList.contains('variant-color-circle')) {
                            b.style.boxShadow = 'none';
                            b.style.borderColor = '#ddd';
                        }
                    });

                    btn.classList.add('active');
                    if (btn.classList.contains('variant-pill')) {
                        btn.classList.remove('btn-outline-dark');
                        btn.classList.add('btn-dark');
                    } else if (btn.classList.contains('variant-color-circle')) {
                        btn.style.boxShadow = '0 0 0 3px #0d6efd';
                        btn.style.borderColor = '#fff';
                    }

                    var slug = group.getAttribute('data-attr-slug');
                    var labelEl = document.getElementById('label-' + slug);
                    if (labelEl) {
                        labelEl.textContent = btn.getAttribute('data-val-name');
                    }
                }

                // Match variant
                function matchVariant() {
                    var matched = null;
                    for (var i = 0; i < variants.length; i++) {
                        var v = variants[i];
                        var allMatched = true;
                        for (var attrId in selectedAttrs) {
                            if (!v.attr_map || v.attr_map[attrId] != selectedAttrs[attrId]) {
                                allMatched = false;
                                break;
                            }
                        }
                        if (allMatched) {
                            matched = v;
                            break;
                        }
                    }

                    if (matched) {
                        // Update SKU
                        if (skuDisplay && matched.sku) {
                            skuDisplay.textContent = matched.sku;
                        }

                        // Update Variant ID
                        if (variantIdInput) {
                            variantIdInput.value = matched.id;
                        }

                        // Update Price
                        var price = parseFloat(matched.price);
                        var salePrice = matched.sale_price ? parseFloat(matched.sale_price) : null;

                        if (salePrice && salePrice > 0) {
                            priceCurrent.textContent = currencySymbol + salePrice.toFixed(2);
                            priceCurrent.className = 'fs-2 fw-bold text-danger';
                            priceOld.textContent = currencySymbol + price.toFixed(2);
                            priceOld.classList.remove('d-none');
                            var pct = Math.round(((price - salePrice) / price) * 100);
                            saveBadge.textContent = 'Save ' + pct + '%';
                            saveBadge.classList.remove('d-none');
                        } else {
                            priceCurrent.textContent = currencySymbol + price.toFixed(2);
                            priceCurrent.className = 'fs-2 fw-bold text-dark';
                            priceOld.classList.add('d-none');
                            saveBadge.classList.add('d-none');
                        }

                        // Update Stock
                        var stock = parseInt(matched.stock_quantity, 10);
                        if (stock > 0) {
                            stockBadge.className = 'badge bg-success-subtle text-success border border-success px-3 py-2';
                            stockBadge.innerHTML = '<i class="fa-solid fa-check me-1"></i> In Stock (' + stock + ' units available)';
                            if (addToCartBtn) addToCartBtn.disabled = false;
                            if (qtyInput) qtyInput.max = stock;
                        } else {
                            stockBadge.className = 'badge bg-danger px-3 py-2';
                            stockBadge.innerHTML = '<i class="fa-solid fa-xmark me-1"></i> Out of Stock';
                            if (addToCartBtn) addToCartBtn.disabled = true;
                        }

                        // Update Image if variant has image
                        if (matched.image && mainImg) {
                            mainImg.src = '<?= base_url("assets/images/"); ?>' + matched.image;
                        }
                    }
                }

                // Attach click listeners to all variant buttons
                document.querySelectorAll('.variant-btn').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        var attrId = this.getAttribute('data-attr-id');
                        var valId = this.getAttribute('data-val-id');
                        selectedAttrs[attrId] = parseInt(valId, 10);
                        highlightSelected(this);
                        matchVariant();
                    });
                });

                // Auto-select first variant's attributes on page load
                if (variants.length > 0 && variants[0].attr_map) {
                    var firstMap = variants[0].attr_map;
                    for (var aId in firstMap) {
                        var vId = firstMap[aId];
                        var targetBtn = document.querySelector('.variant-btn[data-attr-id="' + aId + '"][data-val-id="' + vId + '"]');
                        if (targetBtn) {
                            selectedAttrs[aId] = parseInt(vId, 10);
                            highlightSelected(targetBtn);
                        }
                    }
                    matchVariant();
                }
            });
            </script>
        <?php endif; ?>
