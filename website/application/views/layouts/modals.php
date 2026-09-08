    <!-- Search Modal with Real-Time Autocomplete -->
    <div class="modal fade" id="search" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-magnifying-glass me-2 text-primary"></i>Search Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('shop'); ?>" method="GET" id="autocompleteSearchForm">
                        <div class="input-group input-group-lg mb-3">
                            <input
                                type="text"
                                name="q"
                                id="autocompleteInput"
                                class="form-control"
                                placeholder="Search by product name, SKU, or keywords..."
                                autocomplete="off"
                                required
                                autofocus>
                            <button class="btn btn-primary px-4" type="submit">Search</button>
                        </div>
                    </form>

                    <!-- Autocomplete Dropdown List Container -->
                    <div id="autocompleteResults" class="border rounded p-2 bg-white shadow-sm" style="display: none; max-height: 380px; overflow-y: auto;">
                        <!-- Injected by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    (function() {
        var input = document.getElementById('autocompleteInput');
        var resultsBox = document.getElementById('autocompleteResults');
        var timer = null;

        if (input && resultsBox) {
            input.addEventListener('input', function() {
                clearTimeout(timer);
                var q = this.value.trim();
                if (q.length < 2) {
                    resultsBox.style.display = 'none';
                    resultsBox.innerHTML = '';
                    return;
                }

                timer = setTimeout(function() {
                    fetch('<?= site_url("shop/autocomplete"); ?>?q=' + encodeURIComponent(q))
                        .then(function(res) { return res.json(); })
                        .then(function(data) {
                            if (data.results && data.results.length > 0) {
                                var html = '<div class="list-group list-group-flush">';
                                data.results.forEach(function(item) {
                                    html += '<a href="' + item.url + '" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2 px-2">';
                                    html += '<img src="' + item.image + '" class="rounded border" style="width: 46px; height: 46px; object-fit: cover;" onerror="this.src=\'<?= base_url("assets/images/products/womens/women-1.jpg"); ?>\'">';
                                    html += '<div class="flex-grow-1 text-truncate">';
                                    html += '<div class="fw-semibold text-dark text-truncate">' + item.title + '</div>';
                                    html += '<small class="text-muted">' + (item.category_name ? item.category_name + ' • ' : '') + 'SKU: ' + (item.sku || 'N/A') + '</small>';
                                    html += '</div>';
                                    html += '<span class="fw-bold text-primary">' + item.price_html + '</span>';
                                    html += '</a>';
                                });
                                html += '</div>';
                                html += '<div class="text-center pt-2 border-top mt-2"><a href="<?= site_url("shop"); ?>?q=' + encodeURIComponent(q) + '" class="small text-decoration-none fw-bold">View all matching products <i class="fa-solid fa-arrow-right ms-1"></i></a></div>';
                                resultsBox.innerHTML = html;
                                resultsBox.style.display = 'block';
                            } else {
                                resultsBox.innerHTML = '<div class="p-3 text-center text-muted small"><i class="fa-solid fa-circle-question me-1"></i> No matching products found for "<strong>' + q + '</strong>".</div>';
                                resultsBox.style.display = 'block';
                            }
                        })
                        .catch(function() {
                            resultsBox.style.display = 'none';
                        });
                }, 250);
            });
        }
    })();
    </script>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled">
                <li class="py-2 border-bottom"><a href="<?= site_url('home'); ?>" class="text-dark text-decoration-none fw-bold">Home</a></li>
                <li class="py-2 border-bottom"><a href="<?= site_url('shop'); ?>" class="text-dark text-decoration-none fw-bold">Shop All</a></li>
                <li class="py-2 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= site_url('shop'); ?>" class="text-dark text-decoration-none fw-bold">Categories</a>
                        <button class="btn btn-sm btn-link text-secondary p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileCatCollapse" aria-expanded="false">
                            <i class="fa-solid fa-chevron-down small"></i>
                        </button>
                    </div>
                    <div class="collapse mt-2 ps-2 border-start" id="mobileCatCollapse">
                        <?php if (!empty($category_tree)): ?>
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($category_tree as $m_cat): ?>
                                    <li class="py-1">
                                        <a href="<?= site_url('shop/' . $m_cat['slug']); ?>" class="text-dark text-decoration-none small fw-semibold">
                                            <?= html_escape($m_cat['name']); ?>
                                        </a>
                                        <?php if (!empty($m_cat['children'])): ?>
                                            <ul class="list-unstyled ps-3 my-1">
                                                <?php foreach ($m_cat['children'] as $m_sub): ?>
                                                    <li class="py-1">
                                                        <a href="<?= site_url('shop/' . $m_sub['slug']); ?>" class="text-muted text-decoration-none small">
                                                            &bull; <?= html_escape($m_sub['name']); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </li>
                <li class="py-2 border-bottom"><a href="<?= site_url('cart'); ?>" class="text-dark text-decoration-none fw-bold">Shopping Cart (<?= $cart_count; ?>)</a></li>
                <?php if ($this->is_logged_in()): ?>
                    <li class="py-2 border-bottom text-muted small fw-bold text-uppercase">Account</li>
                    <li class="py-2 border-bottom"><a href="<?= site_url('account/profile'); ?>" class="text-dark text-decoration-none"><i class="fa-solid fa-user me-2"></i>My Profile</a></li>
                    <li class="py-2 border-bottom"><a href="<?= site_url('account/orders'); ?>" class="text-dark text-decoration-none"><i class="fa-solid fa-box-archive me-2"></i>Orders</a></li>
                    <li class="py-2 border-bottom"><a href="<?= site_url('account/address'); ?>" class="text-dark text-decoration-none"><i class="fa-solid fa-location-dot me-2"></i>Saved Address</a></li>
                    <li class="py-2 border-bottom"><a href="<?= site_url('wishlist'); ?>" class="text-dark text-decoration-none"><i class="fa-solid fa-heart me-2"></i>Wishlist</a></li>
                    <li class="py-2 border-bottom"><a href="<?= site_url('account/notifications'); ?>" class="text-dark text-decoration-none"><i class="fa-solid fa-bell me-2"></i>Notification</a></li>
                    <li class="py-2 border-bottom"><a href="<?= site_url('logout'); ?>" class="text-danger text-decoration-none fw-bold"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</a></li>
                <?php else: ?>
                    <li class="py-2 border-bottom"><a href="<?= site_url('login'); ?>" class="text-dark text-decoration-none fw-bold">Sign In / Register</a></li>
                <?php endif; ?>
                <li class="py-2 border-bottom"><a href="<?= site_url('order/track'); ?>" class="text-dark text-decoration-none fw-bold">Order Tracking</a></li>
                <li class="py-2 border-bottom"><a href="<?= site_url('about'); ?>" class="text-dark text-decoration-none">About Us</a></li>
                <li class="py-2"><a href="<?= site_url('contact'); ?>" class="text-dark text-decoration-none">Contact</a></li>
            </ul>
        </div>
    </div>
