        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading"><?= html_escape($page_heading); ?></h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center flex-wrap">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li><a class="link" href="<?= site_url('shop'); ?>">Shop</a></li>
                            <?php if (!empty($breadcrumbs)): ?>
                                <?php foreach ($breadcrumbs as $idx => $bc): ?>
                                    <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                                    <?php if ($idx === count($breadcrumbs) - 1): ?>
                                        <li class="active"><?= html_escape($bc['name']); ?></li>
                                    <?php else: ?>
                                        <li><a class="link" href="<?= site_url('shop/' . $bc['slug']); ?>"><?= html_escape($bc['name']); ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- Top Categories / Subcategories Slider (from shop-categories-top.html) -->
        <?php if (!empty($top_subcategories)): ?>
            <section class="flat-spacing py-4 bg-surface border-bottom">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold m-0">
                            <?= $selected_category ? 'Subcategories in ' . html_escape($selected_category['name']) : 'Explore Categories'; ?>
                        </h5>
                        <?php if ($selected_category): ?>
                            <a href="<?= site_url('shop'); ?>" class="text-primary text-decoration-none small">
                                <i class="fa-solid fa-chevron-left me-1"></i> View All Categories
                            </a>
                        <?php endif; ?>
                    </div>
                    <div dir="ltr" class="swiper tf-sw-categories" data-preview="6" data-tablet="4" data-mobile-sm="3" data-mobile="2" data-space-lg="20" data-space-md="20" data-space="15" data-pagination="2" data-pagination-md="2" data-pagination-lg="1">
                        <div class="swiper-wrapper">
                            <?php foreach ($top_subcategories as $sub): ?>
                                <?php $is_sub_active = ($selected_category && $selected_category['id'] == $sub['id']); ?>
                                <div class="swiper-slide">
                                    <div class="collection-circle hover-img <?= $is_sub_active ? 'is-active' : ''; ?>">
                                        <a href="<?= site_url('shop/' . $sub['slug']); ?>" class="img-style <?= $is_sub_active ? 'is-active' : ''; ?>">
                                            <img class="lazyload" data-src="<?= base_url('assets/images/' . ($sub['image'] ?: 'collections/collection-circle/cls-circle1.jpg')); ?>" src="<?= base_url('assets/images/' . ($sub['image'] ?: 'collections/collection-circle/cls-circle1.jpg')); ?>" alt="<?= html_escape($sub['name']); ?>" onerror="this.src='<?= base_url('assets/images/collections/collection-circle/cls-circle1.jpg'); ?>'">
                                        </a>
                                        <div class="collection-content text-center">
                                            <a href="<?= site_url('shop/' . $sub['slug']); ?>" class="cls-title">
                                                <h6 class="text text-truncate <?= $is_sub_active ? 'text-primary fw-bold' : ''; ?>"><?= html_escape($sub['name']); ?></h6>
                                            </a>
                                            <div class="count text-secondary small"><?= $sub['product_count'] ?? 0; ?> items</div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="sw-pagination-categories sw-dots type-circle justify-content-center mt-3"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <!-- /Categories -->

        <!-- Section product -->
        <section class="flat-spacing pt-4">
            <div class="container">
                <div class="tf-shop-control mb-4">
                    <div class="tf-control-filter">
                        <a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="filterShop" class="tf-btn-filter">
                            <i class="fa-solid fa-sliders me-2"></i>
                            <span class="text">Filters</span>
                        </a>
                        <div class="d-none d-lg-flex shop-sale-text align-items-center ms-3">
                            <a href="<?= site_url('shop?on_sale=1'); ?>" class="text-decoration-none <?= !empty($filters['on_sale']) ? 'fw-bold text-danger' : 'text-secondary'; ?>">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                <span class="text-caption-1">Shop sale items only</span>
                            </a>
                        </div>
                    </div>

                    <!-- Layout Switcher Buttons -->
                    <ul class="tf-control-layout d-none d-md-flex">
                        <li class="tf-view-layout-switch sw-layout-2" data-layout="tf-col-2" title="2 Columns">
                            <div class="item">
                                <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="6" cy="6" r="2.5" stroke="#181818"/><circle cx="14" cy="6" r="2.5" stroke="#181818"/><circle cx="6" cy="14" r="2.5" stroke="#181818"/><circle cx="14" cy="14" r="2.5" stroke="#181818"/></svg>
                            </div>
                        </li>
                        <li class="tf-view-layout-switch sw-layout-3" data-layout="tf-col-3" title="3 Columns">
                            <div class="item">
                                <svg class="icon" width="22" height="20" viewBox="0 0 22 20" fill="none"><circle cx="3" cy="6" r="2.5" stroke="#181818"/><circle cx="11" cy="6" r="2.5" stroke="#181818"/><circle cx="19" cy="6" r="2.5" stroke="#181818"/><circle cx="3" cy="14" r="2.5" stroke="#181818"/><circle cx="11" cy="14" r="2.5" stroke="#181818"/><circle cx="19" cy="14" r="2.5" stroke="#181818"/></svg>
                            </div>
                        </li>
                        <li class="tf-view-layout-switch sw-layout-4 active" data-layout="tf-col-4" title="4 Columns">
                            <div class="item">
                                <svg class="icon" width="30" height="20" viewBox="0 0 30 20" fill="none"><circle cx="3" cy="6" r="2.5" stroke="#181818"/><circle cx="11" cy="6" r="2.5" stroke="#181818"/><circle cx="19" cy="6" r="2.5" stroke="#181818"/><circle cx="27" cy="6" r="2.5" stroke="#181818"/><circle cx="3" cy="14" r="2.5" stroke="#181818"/><circle cx="11" cy="14" r="2.5" stroke="#181818"/><circle cx="19" cy="14" r="2.5" stroke="#181818"/><circle cx="27" cy="14" r="2.5" stroke="#181818"/></svg>
                            </div>
                        </li>
                    </ul>

                    <!-- Sorting Dropdown -->
                    <div class="tf-control-sorting">
                        <p class="d-none d-lg-block text-caption-1 me-2 mb-0">Sort by:</p>
                        <select class="form-select form-select-sm" style="width: auto;" onchange="updateSort(this.value)">
                            <option value="best-selling" <?= ($filters['sort'] === 'best-selling') ? 'selected' : ''; ?>>Best selling</option>
                            <option value="newest" <?= ($filters['sort'] === 'newest') ? 'selected' : ''; ?>>Newest Arrivals</option>
                            <option value="a-z" <?= ($filters['sort'] === 'a-z') ? 'selected' : ''; ?>>Alphabetically, A-Z</option>
                            <option value="z-a" <?= ($filters['sort'] === 'z-a') ? 'selected' : ''; ?>>Alphabetically, Z-A</option>
                            <option value="price-low-high" <?= ($filters['sort'] === 'price-low-high' || $filters['sort'] === 'price_low') ? 'selected' : ''; ?>>Price, low to high</option>
                            <option value="price-high-low" <?= ($filters['sort'] === 'price-high-low' || $filters['sort'] === 'price_high') ? 'selected' : ''; ?>>Price, high to low</option>
                        </select>
                    </div>
                </div>

                <!-- Applied filters meta bar -->
                <div class="wrapper-control-shop mb-3">
                    <div class="meta-filter-shop d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="count-text text-secondary small">
                            Showing <?= min($total_products, count($products)); ?> of <?= $total_products; ?> products
                            <?php if ($selected_category): ?>
                                in <strong><?= html_escape($selected_category['name']); ?></strong>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($filters['brand_slug']) || !empty($filters['min_price']) || !empty($filters['max_price']) || !empty($filters['search']) || !empty($filters['on_sale'])): ?>
                            <div>
                                <a href="<?= $selected_category ? site_url('shop/' . $selected_category['slug']) : site_url('shop'); ?>" class="remove-all-filters text-btn-uppercase btn btn-outline-secondary btn-xs">
                                    RESET FILTERS <i class="fa-solid fa-xmark ms-1"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="tf-grid-layout tf-col-4 wrapper-shop" id="productGridContainer">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                            <div class="card-product wow fadeInUp">
                                <div class="card-product-wrapper">
                                    <a href="<?= site_url('product/' . $p['slug']); ?>" class="product-img">
                                        <img class="lazyload img-product" data-src="<?= base_url('assets/images/' . $p['main_image']); ?>" src="<?= base_url('assets/images/' . $p['main_image']); ?>" alt="<?= html_escape($p['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                        <img class="lazyload img-hover" data-src="<?= base_url('assets/images/' . (!empty($p['gallery_images_decoded'][0]) ? $p['gallery_images_decoded'][0] : $p['main_image'])); ?>" src="<?= base_url('assets/images/' . (!empty($p['gallery_images_decoded'][0]) ? $p['gallery_images_decoded'][0] : $p['main_image'])); ?>" alt="<?= html_escape($p['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-2.jpg'); ?>'">
                                    </a>
                                    <?php if (!empty($p['sale_price'])): ?>
                                        <?php $pct = round((($p['price'] - $p['sale_price']) / $p['price']) * 100); ?>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-<?= $pct; ?>%</span></div>
                                    <?php elseif (!empty($p['is_new'])): ?>
                                        <span class="badge bg-primary position-absolute top-0 start-0 m-3">NEW</span>
                                    <?php endif; ?>
                                    <div class="list-product-btn">
                                        <a href="<?= site_url('wishlist/toggle/' . $p['id']); ?>" class="box-icon wishlist btn-icon-action" title="Add to Wishlist">
                                            <i class="fa-regular fa-heart"></i>
                                            <span class="tooltip">Wishlist</span>
                                        </a>
                                        <a href="<?= site_url('compare/add/' . $p['id']); ?>" class="box-icon compare btn-icon-action" title="Compare">
                                            <i class="fa-solid fa-code-compare"></i>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                        <a href="<?= site_url('product/' . $p['slug']); ?>" class="box-icon quickview tf-btn-loading" title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                            <span class="tooltip">View</span>
                                        </a>
                                    </div>
                                    <div class="list-btn-main">
                                        <form action="<?= site_url('cart/add'); ?>" method="POST" class="d-inline w-100">
                                            <input type="hidden" name="product_id" value="<?= $p['id']; ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn-main-product border-0 w-100">Add To cart</button>
                                        </form>
                                    </div> 
                                </div>
                                <div class="card-product-info">
                                    <div class="d-flex align-items-center gap-1 mb-1 small text-warning">
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <i class="fa-<?= ($s <= round($p['rating'])) ? 'solid' : 'regular'; ?> fa-star" style="font-size: 11px;"></i>
                                        <?php endfor; ?>
                                        <span class="text-muted ms-1" style="font-size: 11px;">(<?= $p['reviews_count']; ?>)</span>
                                    </div>
                                    <a href="<?= site_url('product/' . $p['slug']); ?>" class="title link"><?= html_escape($p['title']); ?></a>
                                    <div class="price">
                                        <?php if (!empty($p['sale_price'])): ?>
                                            <span class="text-danger fw-bold">$<?= number_format($p['sale_price'], 2); ?></span>
                                            <span class="text-muted text-decoration-line-through small ms-1">$<?= number_format($p['price'], 2); ?></span>
                                        <?php else: ?>
                                            <span class="fw-bold">$<?= number_format($p['price'], 2); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <div class="mb-3">
                                <i class="fa-solid fa-magnifying-glass fs-1 text-muted"></i>
                            </div>
                            <h5 class="fw-bold">No products found</h5>
                            <p class="text-muted">We couldn't find any products in this category matching your selected filters.</p>
                            <a href="<?= site_url('shop'); ?>" class="btn btn-outline-primary btn-sm">Clear Filters & Browse All</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="tf-pagination-wrap mt-5 text-center">
                        <ul class="tf-pagination-list d-flex justify-content-center align-items-center gap-2">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <?php
                                    $page_params = $_GET;
                                    $page_params['page'] = $i;
                                    $page_url = ($selected_category ? site_url('shop/' . $selected_category['slug']) : site_url('shop')) . '?' . http_build_query($page_params);
                                ?>
                                <li>
                                    <a href="<?= $page_url; ?>" class="pagination-link <?= ($current_page == $i) ? 'active' : ''; ?>">
                                        <?= $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <!-- /Section product -->

        <!-- Filter Offcanvas (matching shop-categories-top.html) -->
        <div class="offcanvas offcanvas-start canvas-filter" id="filterShop">
            <div class="canvas-wrapper">
                <div class="canvas-header d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="m-0 fw-bold">Filters</h5>
                    <span class="icon-close icon-close-popup cursor-pointer" data-bs-dismiss="offcanvas" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-5"></i>
                    </span>
                </div>
                <div class="canvas-body p-3">
                    <form action="<?= $selected_category ? site_url('shop/' . $selected_category['slug']) : site_url('shop'); ?>" method="GET" id="shopFilterForm">
                        <?php if (!empty($filters['sort'])): ?>
                            <input type="hidden" name="sort" value="<?= html_escape($filters['sort']); ?>">
                        <?php endif; ?>

                        <!-- Categories Hierarchy Facet -->
                        <div class="widget-facet facet-categories mb-4">
                            <h6 class="facet-title fw-bold text-uppercase small text-muted mb-2">Categories Tree</h6>
                            <ul class="facet-content list-unstyled">
                                <li class="py-1">
                                    <a href="<?= site_url('shop'); ?>" class="categories-item text-decoration-none <?= empty($selected_category) ? 'fw-bold text-primary' : 'text-dark'; ?>">
                                        All Products
                                    </a>
                                </li>
                                <?php foreach ($categories as $cat): ?>
                                    <?php $is_active = ($selected_category && $selected_category['slug'] === $cat['slug']); ?>
                                    <li class="py-1 d-flex justify-content-between align-items-center">
                                        <a href="<?= site_url('shop/' . $cat['slug']); ?>" class="categories-item text-decoration-none <?= $is_active ? 'fw-bold text-primary' : 'text-dark'; ?>">
                                            <?php if ($cat['parent_id'] > 0): ?>
                                                <span class="text-muted me-1">↳</span>
                                            <?php endif; ?>
                                            <?= html_escape($cat['name']); ?>
                                        </a>
                                        <span class="count-cate text-muted small">(<?= $cat['product_count'] ?? 0; ?>)</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Price Filter -->
                        <div class="widget-facet facet-price mb-4">
                            <h6 class="facet-title fw-bold text-uppercase small text-muted mb-2">Price Range ($)</h6>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="number" step="1" name="min_price" class="form-control form-control-sm" placeholder="Min" value="<?= html_escape($filters['min_price'] ?? ''); ?>">
                                </div>
                                <div class="col-6">
                                    <input type="number" step="1" name="max_price" class="form-control form-control-sm" placeholder="Max" value="<?= html_escape($filters['max_price'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="widget-facet mb-4">
                            <h6 class="facet-title fw-bold text-uppercase small text-muted mb-2">Brands</h6>
                            <select name="brand" class="form-select form-select-sm">
                                <option value="">All Brands</option>
                                <?php foreach ($brands as $b): ?>
                                    <option value="<?= $b['slug']; ?>" <?= ($filters['brand_slug'] === $b['slug']) ? 'selected' : ''; ?>>
                                        <?= html_escape($b['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Availability & Deals -->
                        <div class="widget-facet mb-4">
                            <h6 class="facet-title fw-bold text-uppercase small text-muted mb-2">Availability & Deals</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="in_stock" id="filter_in_stock" value="1" <?= !empty($filters['in_stock']) ? 'checked' : ''; ?>>
                                <label class="form-check-label small" for="filter_in_stock">In Stock Only</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="on_sale" id="filter_on_sale" value="1" <?= !empty($filters['on_sale']) ? 'checked' : ''; ?>>
                                <label class="form-check-label small text-danger fw-semibold" for="filter_on_sale">Discounted / On Sale</label>
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="widget-facet mb-4">
                            <h6 class="facet-title fw-bold text-uppercase small text-muted mb-2">Customer Rating</h6>
                            <select name="rating" class="form-select form-select-sm">
                                <option value="">All Ratings</option>
                                <option value="4" <?= (isset($filters['rating']) && $filters['rating'] == 4) ? 'selected' : ''; ?>>⭐⭐⭐⭐ & Up (4+ Stars)</option>
                                <option value="3" <?= (isset($filters['rating']) && $filters['rating'] == 3) ? 'selected' : ''; ?>>⭐⭐⭐ & Up (3+ Stars)</option>
                                <option value="2" <?= (isset($filters['rating']) && $filters['rating'] == 2) ? 'selected' : ''; ?>>⭐⭐ & Up (2+ Stars)</option>
                            </select>
                        </div>

                        <!-- Dynamic Attributes (Color, Size, RAM, Storage, etc.) -->
                        <?php if (!empty($filter_attributes)): ?>
                            <?php foreach ($filter_attributes as $fa): if (!empty($fa['values'])): ?>
                                <div class="widget-facet mb-4">
                                    <h6 class="facet-title fw-bold text-uppercase small text-muted mb-2"><?= html_escape($fa['name']); ?></h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($fa['values'] as $fav): ?>
                                            <?php $is_checked = in_array((int)$fav['id'], $filters['attr_value_ids'] ?? []); ?>
                                            <div class="form-check me-2 mb-1">
                                                <input class="form-check-input" type="checkbox" name="attrs[]" value="<?= $fav['id']; ?>" id="attr_val_<?= $fav['id']; ?>" <?= $is_checked ? 'checked' : ''; ?>>
                                                <label class="form-check-label small" for="attr_val_<?= $fav['id']; ?>">
                                                    <?php if ($fa['type'] === 'color' && !empty($fav['color_code'])): ?>
                                                        <span class="d-inline-block rounded-circle me-1 border" style="width: 12px; height: 12px; background-color: <?= html_escape($fav['color_code']); ?>; vertical-align: middle;"></span>
                                                    <?php endif; ?>
                                                    <?= html_escape($fav['value']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; endforeach; ?>
                        <?php endif; ?>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                            <a href="<?= $selected_category ? site_url('shop/' . $selected_category['slug']) : site_url('shop'); ?>" class="btn btn-outline-secondary btn-sm">Clear All</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function updateSort(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', val);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Layout switcher buttons
        document.querySelectorAll('.tf-view-layout-switch').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tf-view-layout-switch').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const layout = this.getAttribute('data-layout');
                const container = document.getElementById('productGridContainer');
                if (container && layout) {
                    container.classList.remove('tf-col-2', 'tf-col-3', 'tf-col-4');
                    container.classList.add(layout);
                }
            });
        });
        </script>
