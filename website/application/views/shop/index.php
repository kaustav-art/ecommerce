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


        <!-- Section product -->
        <section class="flat-spacing pt-4">
            <div class="container">
                <?php
                    $base_filter_url = $selected_category ? site_url('shop/' . $selected_category['slug']) : site_url('shop');
                    $has_active_filters = !empty($selected_brands) || !empty($filters['attr_value_ids']) || !empty($filters['min_price']) || !empty($filters['max_price']) || !empty($filters['on_sale']) || !empty($filters['search']);

                    $make_remove_url = function($param_to_remove, $val_to_remove = null) use ($base_filter_url) {
                        $params = $_GET;
                        if ($val_to_remove !== null && isset($params[$param_to_remove]) && is_array($params[$param_to_remove])) {
                            $params[$param_to_remove] = array_values(array_filter($params[$param_to_remove], function($v) use ($val_to_remove) {
                                return (string)$v !== (string)$val_to_remove;
                            }));
                            if (empty($params[$param_to_remove])) {
                                unset($params[$param_to_remove]);
                            }
                        } else {
                            unset($params[$param_to_remove]);
                        }
                        unset($params['page']);
                        $qs = http_build_query($params);
                        return $base_filter_url . ($qs ? '?' . $qs : '');
                    };

                    $brand_map = [];
                    foreach ($brands as $b) {
                        $brand_map[$b['slug']] = $b['name'];
                    }

                    $attr_val_map = [];
                    foreach ($filter_sizes as $s) {
                        $attr_val_map[$s['id']] = ['type' => 'size', 'name' => 'Size: ' . $s['value']];
                    }
                    foreach ($filter_colors as $c) {
                        $attr_val_map[$c['id']] = ['type' => 'color', 'name' => $c['value'], 'color_code' => $c['color_code'] ?? ''];
                    }
                    foreach ($other_variants as $ov) {
                        foreach ($ov['values'] as $val) {
                            $attr_val_map[$val['id']] = ['type' => 'other', 'name' => $ov['name'] . ': ' . $val['value']];
                        }
                    }

                    $sale_params = $_GET;
                    if (!empty($filters['on_sale'])) {
                        unset($sale_params['on_sale']);
                    } else {
                        $sale_params['on_sale'] = 1;
                    }
                    unset($sale_params['page']);
                    $sale_toggle_url = $base_filter_url . (!empty($sale_params) ? '?' . http_build_query($sale_params) : '');

                    $sort_labels = [
                        'a-z'            => 'Alphabetically, A-Z',
                        'z-a'            => 'Alphabetically, Z-A',
                        'price-low-high' => 'Price, low to high',
                        'price-high-low' => 'Price, high to low',
                    ];
                ?>

                <!-- Control Bar (Filter button on mobile + Sale toggle + 4-option Sort dropdown) -->
                <div class="tf-shop-control mb-4">
                    <div class="tf-control-filter">
                        <button type="button" id="filterShop" class="filterShop tf-btn-filter d-xl-none">
                            <i class="fa-solid fa-sliders me-2"></i>
                            <span class="text">Filters</span>
                        </button>
                        <div class="d-none d-lg-flex shop-sale-text align-items-center <?= empty($selected_category) ? '' : ''; ?>">
                            <a href="<?= $sale_toggle_url; ?>" class="text-decoration-none <?= !empty($filters['on_sale']) ? 'fw-bold text-danger' : 'text-secondary'; ?>">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                <span class="text-caption-1">Shop sale items only</span>
                            </a>
                        </div>
                    </div>

                    <!-- Layout switchers omitted as requested: not need the grid changing button or features -->

                    <!-- Sort By Dropdown (Strictly 4 options: A-Z, Z-A, price low to high, price high to low) -->
                    <div class="tf-control-sorting">
                        <p class="d-none d-lg-block text-caption-1 me-2 mb-0">Sort by:</p>
                        <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                            <div class="btn-select">
                                <span class="text-sort-value"><?= $sort_labels[$filters['sort']] ?? 'Alphabetically, A-Z'; ?></span>
                                <i class="fa-solid fa-chevron-down ms-2" style="font-size: 11px;"></i>
                            </div>
                            <div class="dropdown-menu">
                                <div class="select-item <?= ($filters['sort'] === 'a-z') ? 'active' : ''; ?>" onclick="updateSort('a-z')">
                                    <span class="text-value-item">Alphabetically, A-Z</span>
                                </div>
                                <div class="select-item <?= ($filters['sort'] === 'z-a') ? 'active' : ''; ?>" onclick="updateSort('z-a')">
                                    <span class="text-value-item">Alphabetically, Z-A</span>
                                </div>
                                <div class="select-item <?= ($filters['sort'] === 'price-low-high') ? 'active' : ''; ?>" onclick="updateSort('price-low-high')">
                                    <span class="text-value-item">Price, low to high</span>
                                </div>
                                <div class="select-item <?= ($filters['sort'] === 'price-high-low') ? 'active' : ''; ?>" onclick="updateSort('price-high-low')">
                                    <span class="text-value-item">Price, high to low</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applied filters meta bar -->
                <div class="wrapper-control-shop mb-4">
                    <div class="meta-filter-shop d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="count-text text-secondary small">
                                Showing <span class="count text-dark fw-bold"><?= min($total_products, count($products)); ?></span> of <span class="count text-dark fw-bold"><?= $total_products; ?></span> products
                                <?php if ($selected_category): ?>
                                    in <strong><?= html_escape($selected_category['name']); ?></strong>
                                <?php endif; ?>
                            </div>

                            <!-- Applied filter pills -->
                            <?php if ($has_active_filters): ?>
                                <div id="applied-filters" class="d-flex align-items-center flex-wrap gap-2 ms-lg-2">
                                    <?php if (!empty($selected_brands)): ?>
                                        <?php foreach ($selected_brands as $sb): ?>
                                            <a href="<?= $make_remove_url('brand', $sb); ?>" class="filter-tag text-decoration-none text-dark" title="Remove brand filter">
                                                <span>Brand: <?= html_escape($brand_map[$sb] ?? $sb); ?></span>
                                                <span class="remove-tag"><i class="fa-solid fa-xmark"></i></span>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($filters['attr_value_ids'])): ?>
                                        <?php foreach ($filters['attr_value_ids'] as $avid): ?>
                                            <?php $av_meta = $attr_val_map[$avid] ?? null; ?>
                                            <a href="<?= $make_remove_url('attrs', $avid); ?>" class="filter-tag text-decoration-none text-dark <?= (!empty($av_meta['type']) && $av_meta['type'] === 'color') ? 'color-tag' : ''; ?>" title="Remove filter">
                                                <?php if (!empty($av_meta['color_code'])): ?>
                                                    <span class="color border" style="background-color: <?= html_escape($av_meta['color_code']); ?>;"></span>
                                                <?php endif; ?>
                                                <span><?= html_escape($av_meta['name'] ?? ('Option #' . $avid)); ?></span>
                                                <span class="remove-tag"><i class="fa-solid fa-xmark"></i></span>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($filters['min_price']) || !empty($filters['max_price'])): ?>
                                        <?php
                                            $p_params = $_GET;
                                            unset($p_params['min_price'], $p_params['max_price'], $p_params['page']);
                                            $p_qs = http_build_query($p_params);
                                            $price_remove_url = $base_filter_url . ($p_qs ? '?' . $p_qs : '');
                                        ?>
                                        <a href="<?= $price_remove_url; ?>" class="filter-tag text-decoration-none text-dark" title="Remove price filter">
                                            <span>Price: $<?= html_escape($filters['min_price'] ?: $min_catalog_price); ?> - $<?= html_escape($filters['max_price'] ?: $max_catalog_price); ?></span>
                                            <span class="remove-tag"><i class="fa-solid fa-xmark"></i></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($filters['on_sale'])): ?>
                                        <a href="<?= $make_remove_url('on_sale'); ?>" class="filter-tag text-decoration-none text-dark" title="Remove sale filter">
                                            <span>On Sale</span>
                                            <span class="remove-tag"><i class="fa-solid fa-xmark"></i></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($filters['search'])): ?>
                                        <a href="<?= $make_remove_url('q'); ?>" class="filter-tag text-decoration-none text-dark" title="Remove search filter">
                                            <span>Search: "<?= html_escape($filters['search']); ?>"</span>
                                            <span class="remove-tag"><i class="fa-solid fa-xmark"></i></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($has_active_filters): ?>
                            <div>
                                <a href="<?= $base_filter_url . (!empty($filters['sort']) && $filters['sort'] !== 'a-z' ? '?sort=' . $filters['sort'] : ''); ?>" class="remove-all-filters text-btn-uppercase text-decoration-none btn-xs">
                                    REMOVE ALL <i class="fa-solid fa-xmark ms-1"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 2-Column Row: Left Sidebar (.col-xl-3) + Products Grid (.col-xl-9) -->
                <div class="row">
                    <!-- Left Sidebar Filter (Follows shop-left-sidebar.html) -->
                    <div class="col-xl-3">
                        <div class="sidebar-filter canvas-filter left" id="sidebarFilter">
                            <div class="canvas-wrapper">
                                <div class="canvas-header d-flex d-xl-none justify-content-between align-items-center p-3 border-bottom">
                                    <h5 class="m-0 fw-bold">Filters</h5>
                                    <span class="icon-close close-filter cursor-pointer" style="font-size: 20px;"><i class="fa-solid fa-xmark"></i></span>
                                </div>
                                <div class="canvas-body p-3 p-xl-0">
                                    <form action="<?= $base_filter_url; ?>" method="GET" id="shopFilterForm">
                                        <input type="hidden" name="sort" id="filter-sort-input" value="<?= html_escape($filters['sort']); ?>">
                                        <?php if (!empty($filters['search'])): ?>
                                            <input type="hidden" name="q" value="<?= html_escape($filters['search']); ?>">
                                        <?php endif; ?>

                                        <!-- Price Filter -->
                                        <div class="widget-facet facet-price">
                                            <h6 class="facet-title fw-bold">Price</h6>
                                            <div class="price-val-range" id="price-value-range"
                                                 data-min="<?= $min_catalog_price; ?>"
                                                 data-max="<?= $max_catalog_price; ?>"
                                                 data-current-min="<?= !empty($filters['min_price']) ? (int)$filters['min_price'] : $min_catalog_price; ?>"
                                                 data-current-max="<?= !empty($filters['max_price']) ? (int)$filters['max_price'] : $max_catalog_price; ?>"></div>
                                            <div class="box-price-product">
                                                <div class="box-price-item">
                                                    <span class="title-price">Min price</span>
                                                    <div class="price-val" id="price-min-value" data-currency="$"><?= !empty($filters['min_price']) ? (int)$filters['min_price'] : $min_catalog_price; ?></div>
                                                    <input type="hidden" name="min_price" id="input-min-price" value="<?= !empty($filters['min_price']) ? html_escape($filters['min_price']) : ''; ?>">
                                                </div>
                                                <div class="box-price-item">
                                                    <span class="title-price">Max price</span>
                                                    <div class="price-val" id="price-max-value" data-currency="$"><?= !empty($filters['max_price']) ? (int)$filters['max_price'] : $max_catalog_price; ?></div>
                                                    <input type="hidden" name="max_price" id="input-max-price" value="<?= !empty($filters['max_price']) ? html_escape($filters['max_price']) : ''; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Size Filter -->
                                        <?php if (!empty($filter_sizes)): ?>
                                            <div class="widget-facet facet-size">
                                                <h6 class="facet-title fw-bold">Size</h6>
                                                <div class="facet-size-box size-box">
                                                    <?php foreach ($filter_sizes as $sz): ?>
                                                        <?php $is_checked = in_array((int)$sz['id'], $filters['attr_value_ids'] ?? []); ?>
                                                        <span class="size-item size-check <?= strlen($sz['value']) > 3 ? 'free-size' : ''; ?> <?= $is_checked ? 'active' : ''; ?>" data-val-id="<?= $sz['id']; ?>">
                                                            <input type="checkbox" name="attrs[]" value="<?= $sz['id']; ?>" class="d-none attr-checkbox" id="attr_size_<?= $sz['id']; ?>" <?= $is_checked ? 'checked' : ''; ?>>
                                                            <?= html_escape($sz['value']); ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Color Filter -->
                                        <?php if (!empty($filter_colors)): ?>
                                            <div class="widget-facet facet-color">
                                                <h6 class="facet-title fw-bold">Colors</h6>
                                                <div class="facet-color-box">
                                                    <?php foreach ($filter_colors as $clr): ?>
                                                        <?php 
                                                            $is_checked = in_array((int)$clr['id'], $filters['attr_value_ids'] ?? []);
                                                            $color_code = !empty($clr['color_code']) ? $clr['color_code'] : '#cccccc';
                                                            $is_white = strtolower($color_code) === '#ffffff' || strtolower($clr['value']) === 'white';
                                                        ?>
                                                        <div class="color-item color-check <?= $is_checked ? 'active' : ''; ?>" data-val-id="<?= $clr['id']; ?>">
                                                            <input type="checkbox" name="attrs[]" value="<?= $clr['id']; ?>" class="d-none attr-checkbox" id="attr_color_<?= $clr['id']; ?>" <?= $is_checked ? 'checked' : ''; ?>>
                                                            <span class="color <?= $is_white ? 'line-black border' : ''; ?>" style="background-color: <?= html_escape($color_code); ?>;"></span>
                                                            <?= html_escape($clr['value']); ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Other Variants (e.g. Material, Storage, etc.) -->
                                        <?php if (!empty($other_variants)): ?>
                                            <?php foreach ($other_variants as $ov_attr): ?>
                                                <div class="widget-facet facet-fieldset">
                                                    <h6 class="facet-title fw-bold"><?= html_escape($ov_attr['name']); ?></h6>
                                                    <div class="box-fieldset-item" style="max-height: 200px; overflow-y: auto;">
                                                        <?php foreach ($ov_attr['values'] as $ov_val): ?>
                                                            <?php $is_checked = in_array((int)$ov_val['id'], $filters['attr_value_ids'] ?? []); ?>
                                                            <fieldset class="fieldset-item">
                                                                <input type="checkbox" name="attrs[]" value="<?= $ov_val['id']; ?>" class="tf-check attr-checkbox" id="attr_ov_<?= $ov_val['id']; ?>" <?= $is_checked ? 'checked' : ''; ?>>
                                                                <label for="attr_ov_<?= $ov_val['id']; ?>" class="cursor-pointer">
                                                                    <?= html_escape($ov_val['value']); ?>
                                                                    <?php if (isset($ov_val['product_count'])): ?>
                                                                        <span class="count-stock text-muted small">(<?= $ov_val['product_count']; ?>)</span>
                                                                    <?php endif; ?>
                                                                </label>
                                                            </fieldset>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!-- Brands Filter (Respect to the selected product category) -->
                                        <?php if (!empty($brands)): ?>
                                            <div class="widget-facet facet-fieldset">
                                                <h6 class="facet-title fw-bold">Brands</h6>
                                                <div class="box-fieldset-item" style="max-height: 240px; overflow-y: auto;">
                                                    <?php foreach ($brands as $b): ?>
                                                        <?php $is_checked = in_array($b['slug'], $selected_brands); ?>
                                                        <fieldset class="fieldset-item">
                                                            <input type="checkbox" name="brand[]" value="<?= html_escape($b['slug']); ?>" class="tf-check brand-checkbox" id="brand_<?= $b['id']; ?>" <?= $is_checked ? 'checked' : ''; ?>>
                                                            <label for="brand_<?= $b['id']; ?>" class="cursor-pointer">
                                                                <?= html_escape($b['name']); ?>
                                                                <span class="count-brand text-muted small">(<?= $b['product_count'] ?? 0; ?>)</span>
                                                            </label>
                                                        </fieldset>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Action Buttons in Sidebar -->
                                        <div class="d-flex gap-2 mt-4 pt-2">
                                            <button type="submit" class="tf-btn btn-fill animate-hover-btn flex-grow-1 justify-content-center py-2" style="font-size: 13px;">Apply Filters</button>
                                            <a href="<?= $base_filter_url; ?>" class="tf-btn btn-outline animate-hover-btn py-2 px-3 text-center" style="font-size: 13px;">Reset</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="canvas-bottom d-block d-xl-none p-3 border-top">
                                    <a href="<?= $base_filter_url; ?>" class="tf-btn btn-reset w-100 text-center">Reset Filters</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Products Grid (.col-xl-9) -->
                    <div class="col-xl-9">
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
                                    <p class="text-muted">We couldn't find any products matching your selected filters.</p>
                                    <a href="<?= $base_filter_url; ?>" class="btn btn-outline-primary btn-sm">Clear Filters & Browse All</a>
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
                                            $page_url = $base_filter_url . '?' . http_build_query($page_params);
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
                </div>
            </div>
        </section>
        <!-- /Section product -->

        <!-- Mobile Drawer Backdrop Overlay -->
        <div class="overlay-filter"></div>

        <!-- Custom Sidebar & Filter CSS -->
        <style>
            @media (min-width: 1200px) {
                .sidebar-filter.canvas-filter.left {
                    position: static !important;
                    transform: none !important;
                    max-width: 100% !important;
                    box-shadow: none !important;
                    z-index: auto !important;
                    width: 100% !important;
                }
                .sidebar-filter .canvas-wrapper {
                    display: block !important;
                }
                .sidebar-filter .canvas-body {
                    padding: 0 !important;
                    overflow: visible !important;
                }
            }
            .sidebar-filter .facet-price .price-val-range {
                padding-left: 10px;
                padding-right: 10px;
            }
            .size-item.size-check, .color-item.color-check {
                user-select: none;
            }
            .cursor-pointer {
                cursor: pointer;
            }
            .btn-xs {
                padding: 3px 8px;
                font-size: 11px;
            }
            .noUi-target {
                background: #e9ecef;
                border-radius: 4px;
                border: none;
                box-shadow: none;
                height: 6px;
            }
            .noUi-connect {
                background: #111111;
            }
            .noUi-handle {
                border: 2px solid #111111;
                border-radius: 50%;
                background: #ffffff;
                cursor: pointer;
                box-shadow: 0 1px 3px rgba(0,0,0,0.2);
                width: 16px !important;
                height: 16px !important;
                right: -8px !important;
                top: -5px !important;
            }
            .noUi-handle:before, .noUi-handle:after {
                display: none !important;
            }
        </style>

        <!-- Load noUiSlider JS -->
        <script src="<?= base_url('assets/js/nouislider.min.js'); ?>"></script>

        <script>
        function updateSort(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', val);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Mobile offcanvas filter toggle
            const filterShopBtn = document.getElementById('filterShop');
            const sidebarFilter = document.getElementById('sidebarFilter');
            const overlayFilter = document.querySelector('.overlay-filter');
            const closeFilterBtn = document.querySelector('.close-filter');

            function openMobileFilter() {
                if (sidebarFilter) sidebarFilter.classList.add('show');
                if (overlayFilter) overlayFilter.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileFilter() {
                if (sidebarFilter) sidebarFilter.classList.remove('show');
                if (overlayFilter) overlayFilter.classList.remove('show');
                document.body.style.overflow = '';
            }

            if (filterShopBtn) {
                filterShopBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openMobileFilter();
                });
            }

            if (closeFilterBtn) {
                closeFilterBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeMobileFilter();
                });
            }

            if (overlayFilter) {
                overlayFilter.addEventListener('click', function() {
                    closeMobileFilter();
                });
            }

            // Size items toggle
            document.querySelectorAll('.size-item.size-check').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    if (checkbox && !e.target.isSameNode(checkbox)) {
                        checkbox.checked = !checkbox.checked;
                    }
                    if (checkbox && checkbox.checked) {
                        this.classList.add('active');
                    } else {
                        this.classList.remove('active');
                    }
                });
            });

            // Color items toggle
            document.querySelectorAll('.color-item.color-check').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    if (checkbox && !e.target.isSameNode(checkbox)) {
                        checkbox.checked = !checkbox.checked;
                    }
                    if (checkbox && checkbox.checked) {
                        this.classList.add('active');
                    } else {
                        this.classList.remove('active');
                    }
                });
            });

            // Price range slider initialization with noUiSlider
            const rangeSlider = document.getElementById('price-value-range');
            if (rangeSlider && typeof noUiSlider !== 'undefined') {
                const minLimit = parseInt(rangeSlider.getAttribute('data-min')) || 0;
                const maxLimit = parseInt(rangeSlider.getAttribute('data-max')) || 500;
                const currentMin = parseInt(rangeSlider.getAttribute('data-current-min')) || minLimit;
                const currentMax = parseInt(rangeSlider.getAttribute('data-current-max')) || maxLimit;

                noUiSlider.create(rangeSlider, {
                    start: [currentMin, currentMax],
                    connect: true,
                    step: 1,
                    range: {
                        'min': minLimit,
                        'max': maxLimit
                    },
                    format: {
                        to: function(val) { return Math.round(val); },
                        from: function(val) { return Number(val); }
                    }
                });

                const minValDisplay = document.getElementById('price-min-value');
                const maxValDisplay = document.getElementById('price-max-value');
                const minValInput = document.getElementById('input-min-price');
                const maxValInput = document.getElementById('input-max-price');

                rangeSlider.noUiSlider.on('update', function(values, handle) {
                    if (handle === 0) {
                        if (minValDisplay) minValDisplay.innerText = values[0];
                        if (minValInput) minValInput.value = values[0];
                    } else {
                        if (maxValDisplay) maxValDisplay.innerText = values[1];
                        if (maxValInput) maxValInput.value = values[1];
                    }
                });
            }
        });
        </script>
