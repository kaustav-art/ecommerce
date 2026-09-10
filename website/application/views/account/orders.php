        <!-- breadcrumb -->
        <div class="py-2 border-bottom" style="background-color: #f1f3f6;">
            <div class="fk-orders-container px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 12px;">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('account/profile'); ?>" class="text-muted text-decoration-none">My Account</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">My Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- orders-section -->
        <section class="py-3" style="background-color: #f1f3f6; min-height: 85vh;">
            <div class="fk-orders-container px-3">
                <div class="row g-3">
                    <!-- Left Filters Sidebar (Matching new_order_page.PNG) -->
                    <div class="col-lg-3 col-md-3 col-12" style="max-width: 270px;">
                        <div class="card border rounded-1 shadow-sm bg-white p-3" style="border-color: #e0e0e0 !important;">
                            <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;">Filters</h5>

                            <!-- ORDER STATUS -->
                            <div class="filter-section mb-3">
                                <div class="fw-bold text-uppercase text-dark mb-2" style="font-size: 12px; letter-spacing: 0.3px;">
                                    ORDER STATUS
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-status form-check-input mt-0 rounded-0" value="on_the_way" onchange="filterOrders()">
                                        <span>On the way</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-status form-check-input mt-0 rounded-0" value="delivered" onchange="filterOrders()">
                                        <span>Delivered</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-status form-check-input mt-0 rounded-0" value="cancelled" onchange="filterOrders()">
                                        <span>Cancelled</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-status form-check-input mt-0 rounded-0" value="returned" onchange="filterOrders()">
                                        <span>Returned</span>
                                    </label>
                                </div>
                            </div>

                            <hr class="my-3" style="border-color: #f0f0f0;">

                            <!-- ORDER TIME -->
                            <div class="filter-section">
                                <div class="fw-bold text-uppercase text-dark mb-2" style="font-size: 12px; letter-spacing: 0.3px;">
                                    ORDER TIME
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-time form-check-input mt-0 rounded-0" value="last_30" onchange="filterOrders()">
                                        <span>Last 30 days</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-time form-check-input mt-0 rounded-0" value="2026" onchange="filterOrders()">
                                        <span>2026</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-time form-check-input mt-0 rounded-0" value="2025" onchange="filterOrders()">
                                        <span>2025</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-time form-check-input mt-0 rounded-0" value="2024" onchange="filterOrders()">
                                        <span>2024</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 mb-0" style="cursor: pointer; font-size: 13px;">
                                        <input type="checkbox" class="fk-filter-time form-check-input mt-0 rounded-0" value="older" onchange="filterOrders()">
                                        <span>Older</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Orders Content (Matching new_order_page.PNG) -->
                    <div class="col-lg-9 col-md-9 col-12" style="flex: 1;">
                        <!-- Search Bar matching new_order_page.PNG -->
                        <div class="card border rounded-1 shadow-none p-0 mb-3 bg-white" style="border-color: #e0e0e0 !important;">
                            <div class="d-flex align-items-center">
                                <input type="text" id="order-search-input" class="form-control border-0 shadow-none px-3" placeholder="Search your orders here" style="font-size: 14px; height: 44px;">
                                <button type="button" class="btn btn-primary px-4 fw-semibold rounded-0 rounded-end d-flex align-items-center gap-2 flex-shrink-0" onclick="filterOrders()" style="background-color: #2874f0; border-color: #2874f0; height: 44px; font-size: 14px;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <span>Search Orders</span>
                                </button>
                            </div>
                        </div>

                        <!-- Orders Items List -->
                        <div class="order-items-list" id="order-items-container">
                            <?php
                            $has_orders = false;
                            if (!empty($orders)):
                                foreach ($orders as $ord):
                                    $has_orders = true;
                                    $status = strtolower($ord['order_status']);
                                    $items = $ord['items'] ?? [];
                                    if (empty($items)) {
                                        $items = [[
                                            'product_id'    => 0,
                                            'product_title' => 'Order #' . $ord['order_number'],
                                            'product_image' => 'products/womens/women-1.jpg',
                                            'variant_title' => '',
                                            'price'         => $ord['total_amount'],
                                            'quantity'      => 1,
                                            'total'         => $ord['total_amount']
                                        ]];
                                    }

                                    // Determine status category for filter
                                    $status_group = 'on_the_way';
                                    if ($status === 'cancelled') {
                                        $status_group = 'cancelled';
                                    } elseif (in_array($status, ['delivered', 'completed'])) {
                                        $status_group = 'delivered';
                                    } elseif ($status === 'returned') {
                                        $status_group = 'returned';
                                    }

                                    $order_year = date('Y', strtotime($ord['created_at']));
                                    $order_ts = strtotime($ord['created_at']);
                                    $order_url = site_url('account/order/' . $ord['order_number']);

                                    // Status display dates (shared for the entire shipment)
                                    $date_cancelled = date('M d', strtotime($ord['updated_at'] ?? $ord['created_at']));
                                    $date_delivered = date('M d', strtotime($ord['updated_at'] ?? $ord['created_at']));
                                    $date_expected  = date('M d', strtotime($ord['created_at'] . ' + 4 days'));

                                    // Build searchable keywords of all products in this order
                                    $order_search_keywords = $ord['order_number'];
                                    foreach ($items as $it) {
                                        $order_search_keywords .= ' ' . ($it['product_title'] ?? '') . ' ' . ($it['variant_title'] ?? '');
                                    }
                                    $order_search_keywords = strtolower(trim($order_search_keywords));
                            ?>
                                    <!-- Single-Vendor Unified Order Card (Items shipped together) -->
                                    <div class="card border rounded-1 mb-3 bg-white shadow-none fk-order-card" 
                                         style="border-color: #e0e0e0 !important; overflow: hidden; transition: box-shadow 0.2s, border-color 0.2s;" 
                                         data-search-text="<?= html_escape($order_search_keywords); ?>"
                                         data-status-group="<?= $status_group; ?>"
                                         data-year="<?= $order_year; ?>"
                                         data-created-ts="<?= $order_ts; ?>">

                                        <!-- Order Top Bar -->
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-3 py-2 border-bottom" style="background-color: #fafafa; font-size: 13px;">
                                            <div class="d-flex align-items-center gap-2 gap-md-3 flex-wrap">
                                                <span class="fw-bold text-dark">
                                                    Order <a href="<?= $order_url; ?>" class="text-decoration-none" style="color: #2874f0;">#<?= html_escape($ord['order_number']); ?></a>
                                                </span>
                                                <span class="text-muted d-none d-sm-inline">|</span>
                                                <span class="text-secondary small">
                                                    Placed on <?= date('d M, Y', strtotime($ord['created_at'])); ?>
                                                </span>
                                                <span class="text-muted d-none d-sm-inline">|</span>
                                                <span class="fw-bold text-dark small">
                                                    Total: <?= $currency_symbol . number_format($ord['total_amount'], 0); ?>
                                                </span>
                                                <?php if (count($items) > 1): ?>
                                                    <span class="badge bg-white text-secondary border fw-normal py-1 px-2" style="font-size: 11px;">
                                                        <i class="fa-solid fa-boxes-packing me-1 text-primary"></i> <?= count($items); ?> items shipped together
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <div>
                                                <a href="<?= $order_url; ?>" class="fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="color: #2874f0; font-size: 13px;">
                                                    <i class="fa-solid fa-location-dot" style="font-size: 11px;"></i> Track Order
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Items List inside this Shipment -->
                                        <div class="p-3">
                                            <?php
                                            foreach ($items as $idx => $item):
                                                $img_src = !empty($item['product_image']) ? base_url('assets/images/' . $item['product_image']) : base_url('assets/images/products/womens/women-1.jpg');
                                                $pid = (int) ($item['product_id'] ?? 0);

                                                // Format color & size variant line nicely like new_order_page.PNG
                                                $variant_str = '';
                                                if (!empty($item['variant_title'])) {
                                                    $vt = trim($item['variant_title']);
                                                    if (stripos($vt, 'color') === false && stripos($vt, 'size') === false && strpos($vt, '/') !== false) {
                                                        $parts = explode('/', $vt);
                                                        $variant_str = 'Color: ' . trim($parts[0]) . '  Size: ' . trim($parts[1] ?? '');
                                                    } else {
                                                        $variant_str = $vt;
                                                    }
                                                }
                                            ?>
                                                <?php if ($idx > 0): ?>
                                                    <hr class="my-3" style="border-color: #f0f0f0;">
                                                <?php endif; ?>

                                                <div class="row align-items-center g-3">
                                                    <!-- Product Thumbnail (Col 1) -->
                                                    <div class="col-auto">
                                                        <a href="<?= $order_url; ?>">
                                                            <img src="<?= $img_src; ?>" alt="<?= html_escape($item['product_title']); ?>" class="border rounded-1" style="width: 75px; height: 75px; object-fit: contain; background-color: #fafafa;" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                        </a>
                                                    </div>

                                                    <!-- Product Name & Color/Size (Col 2) -->
                                                    <div class="col-md-5 col-12">
                                                        <a href="<?= $order_url; ?>" class="text-decoration-none text-dark fw-bold d-block mb-1 fk-item-title" style="font-size: 14px; line-height: 1.4;">
                                                            <?= html_escape($item['product_title']); ?>
                                                        </a>
                                                        <?php if (!empty($variant_str)): ?>
                                                            <div class="text-muted" style="font-size: 12px; color: #878787 !important;"><?= html_escape($variant_str); ?></div>
                                                        <?php endif; ?>
                                                        <?php if ((int)($item['quantity'] ?? 1) > 1): ?>
                                                            <div class="text-muted small">Qty: <?= (int)$item['quantity']; ?></div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Price (Col 3) -->
                                                    <div class="col-md-2 col-4 text-start text-md-center">
                                                        <div class="fw-bold text-dark" style="font-size: 14px;">
                                                            <?= $currency_symbol . number_format($item['price'], 0); ?>
                                                        </div>
                                                    </div>

                                                    <!-- Shared Shipment Delivery Status & Per-Product Review (Col 4) -->
                                                    <div class="col-md-4 col-8 text-md-start text-start">
                                                        <?php if ($status === 'cancelled'): ?>
                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                <span class="rounded-circle d-inline-block flex-shrink-0" style="width: 10px; height: 10px; background-color: #e53935;"></span>
                                                                <span class="fw-bold text-dark" style="font-size: 14px;">
                                                                    Cancelled on <?= $date_cancelled; ?>
                                                                </span>
                                                            </div>
                                                            <div class="text-muted" style="font-size: 12px;">
                                                                Your order was cancelled as per your request.
                                                            </div>
                                                        <?php elseif ($status_group === 'delivered'): ?>
                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                <span class="rounded-circle d-inline-block flex-shrink-0" style="width: 10px; height: 10px; background-color: #26a541;"></span>
                                                                <span class="fw-bold text-dark" style="font-size: 14px;">
                                                                    Delivered on <?= $date_delivered; ?>
                                                                </span>
                                                            </div>
                                                            <div class="text-muted" style="font-size: 12px;">
                                                                Your item has been delivered
                                                            </div>
                                                            <div class="mt-2">
                                                                <a href="<?= site_url('account/rate_review/' . $ord['order_number'] . '/' . $pid); ?>" class="fw-semibold small text-decoration-none" style="color: #2874f0 !important; font-size: 13px;">
                                                                    <i class="fa-solid fa-star me-1" style="color: #2874f0;"></i> Rate & Review Product
                                                                </a>
                                                            </div>
                                                        <?php elseif ($status === 'returned'): ?>
                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                <span class="rounded-circle d-inline-block flex-shrink-0" style="width: 10px; height: 10px; background-color: #ff9f00;"></span>
                                                                <span class="fw-bold text-dark" style="font-size: 14px;">
                                                                    Returned
                                                                </span>
                                                            </div>
                                                            <div class="text-muted" style="font-size: 12px;">
                                                                Refund processed
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                <span class="rounded-circle d-inline-block flex-shrink-0" style="width: 10px; height: 10px; background-color: #26a541;"></span>
                                                                <span class="fw-bold text-dark" style="font-size: 14px;">
                                                                    Delivery expected by <?= $date_expected; ?>
                                                                </span>
                                                            </div>
                                                            <div class="text-muted" style="font-size: 12px;">
                                                                Your package is on the way
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                            <?php
                                endforeach;
                            endif;

                            if (!$has_orders):
                            ?>
                                <div class="card border rounded-1 p-5 bg-white text-center shadow-none" style="border-color: #e0e0e0 !important;">
                                    <div class="mb-3 text-muted">
                                        <i class="fa-solid fa-box-open" style="font-size: 48px; color: #b0bec5;"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">No orders found</h5>
                                    <p class="text-muted small mb-4">You haven't placed any orders yet. Discover items and place your first order.</p>
                                    <div>
                                        <a href="<?= site_url('shop'); ?>" class="btn btn-primary px-4 py-2 rounded-1 fw-semibold" style="background-color: #2874f0; border-color: #2874f0;">
                                            Shop Now
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- No Search Results Container -->
                        <div id="no-search-results" class="card border rounded-1 p-5 bg-white text-center shadow-none d-none" style="border-color: #e0e0e0 !important;">
                            <div class="mb-2 text-muted">
                                <i class="fa-solid fa-magnifying-glass fs-1 text-muted"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">No matching orders found</h6>
                            <p class="text-muted small mb-3">Try searching with a different product name or adjusting your filters.</p>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-1" onclick="resetSearch()">Clear All Filters</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /orders-section -->

        <style>
        .fk-orders-container {
            max-width: 1680px;
            min-width: 978px;
            margin: 0 auto;
        }
        @media (max-width: 991px) {
            .fk-orders-container {
                min-width: 100% !important;
                max-width: 100% !important;
            }
        }
        .fk-order-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            border-color: #2874f0 !important;
        }
        .fk-item-title:hover {
            color: #2874f0 !important;
        }
        </style>

        <script>
        function filterOrders() {
            var query = document.getElementById('order-search-input').value.trim().toLowerCase();

            // Checked status filters
            var checkedStatuses = [];
            document.querySelectorAll('.fk-filter-status:checked').forEach(function(el) {
                checkedStatuses.push(el.value);
            });

            // Checked time filters
            var checkedTimes = [];
            document.querySelectorAll('.fk-filter-time:checked').forEach(function(el) {
                checkedTimes.push(el.value);
            });

            var now = Math.floor(Date.now() / 1000);
            var thirtyDaysAgo = now - (30 * 86400);

            var cards = document.querySelectorAll('.fk-order-card');
            var visibleCount = 0;

            cards.forEach(function(card) {
                var cardText = card.getAttribute('data-search-text') || '';
                var cardStatus = card.getAttribute('data-status-group') || '';
                var cardYear = card.getAttribute('data-year') || '';
                var cardTs = parseInt(card.getAttribute('data-created-ts'), 10) || 0;

                // Check query
                var matchQuery = (!query || cardText.indexOf(query) !== -1);

                // Check status
                var matchStatus = (checkedStatuses.length === 0 || checkedStatuses.indexOf(cardStatus) !== -1);

                // Check time
                var matchTime = true;
                if (checkedTimes.length > 0) {
                    matchTime = false;
                    for (var i = 0; i < checkedTimes.length; i++) {
                        var t = checkedTimes[i];
                        if (t === 'last_30' && cardTs >= thirtyDaysAgo) {
                            matchTime = true;
                            break;
                        } else if (t === cardYear) {
                            matchTime = true;
                            break;
                        } else if (t === 'older' && parseInt(cardYear, 10) < 2024) {
                            matchTime = true;
                            break;
                        }
                    }
                }

                if (matchQuery && matchStatus && matchTime) {
                    card.classList.remove('d-none');
                    visibleCount++;
                } else {
                    card.classList.add('d-none');
                }
            });

            var noRes = document.getElementById('no-search-results');
            if (noRes) {
                if (visibleCount === 0 && cards.length > 0) {
                    noRes.classList.remove('d-none');
                } else {
                    noRes.classList.add('d-none');
                }
            }
        }

        document.getElementById('order-search-input').addEventListener('keyup', function(e) {
            filterOrders();
        });

        function resetSearch() {
            document.getElementById('order-search-input').value = '';
            document.querySelectorAll('.fk-filter-status:checked, .fk-filter-time:checked').forEach(function(el) {
                el.checked = false;
            });
            filterOrders();
        }
        </script>


