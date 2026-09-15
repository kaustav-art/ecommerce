        <!-- Page Title & Breadcrumbs -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container">
                <h3 class="heading text-center">Shopping Cart</h3>
                <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                    <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                    <li><i class="icon-arrRight"></i></li>
                    <li><a class="link" href="<?= site_url('shop'); ?>">Shop</a></li>
                    <li><i class="icon-arrRight"></i></li>
                    <li>Shopping Cart</li>
                </ul>
            </div>
        </div>
        <!-- /Page Title -->

        <?php 
            $free_shipping_min = (float) ($cart_summary['shipping_free_min'] ?? 150.00);
            $subtotal = (float) ($cart_summary['subtotal'] ?? 0.00);
            $away_amount = max(0, $free_shipping_min - $subtotal);
            $progress_pct = ($free_shipping_min > 0) ? min(100, round(($subtotal / $free_shipping_min) * 100)) : 100;
        ?>

        <!-- Flash messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i><?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i><?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Section cart -->
        <section class="flat-spacing">
            <div class="container">
                <!-- Cart Content Container -->
                <div class="row <?= empty($cart_items) ? 'd-none' : ''; ?>" id="cart-content-wrapper">
                    <div class="col-xl-8">
                        <!-- Notification threshold & countdown -->
                        <div class="tf-cart-sold">
                            <div class="notification-sold bg-surface">
                                <img class="icon" src="<?= base_url('assets/images/logo/icon-fire.png'); ?>" alt="img" onerror="this.style.display='none'">
                                <div class="count-text">Your cart will expire in <div class="js-countdown time-count" data-timer="600" data-labels=":,:,:,"></div> minutes! Please checkout now before your items sell out!</div>  
                            </div>
                            <div class="notification-progress">
                                <div class="text" id="cart-page-threshold-text">
                                    <?php if ($away_amount <= 0): ?>
                                        <i class="fa-solid fa-circle-check text-success me-1"></i> Congratulations! You've got <span class="fw-semibold text-primary">Free Shipping</span>!
                                    <?php else: ?>
                                        Buy <span class="fw-semibold text-primary" id="cart-page-away-val"><?= $currency_symbol . number_format($away_amount, 2); ?></span> more to get <span class="fw-semibold">Freeship</span>
                                    <?php endif; ?>
                                </div>
                                <div class="progress-cart">
                                    <div class="value" id="cart-page-progress-bar" style="width: <?= $progress_pct; ?>%;" data-progress="<?= $progress_pct; ?>">
                                        <span class="round"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Address Card (Matches Cart.PNG) -->
                        <?php 
                            $disp_name = trim(($active_address['first_name'] ?? '') . ' ' . ($active_address['last_name'] ?? ''));
                            $disp_pin  = $active_address['postcode'] ?? '';
                            $disp_tag  = !empty($active_address['company']) ? strtoupper($active_address['company']) : 'HOME';
                            $disp_addr = implode(', ', array_filter([$active_address['address_1'] ?? '', $active_address['address_2'] ?? '', $active_address['city'] ?? '', $active_address['state'] ?? '']));
                            $disp_phone = !empty($active_address['phone']) ? $active_address['phone'] : ($current_user['phone'] ?? '');
                        ?>
                        <div class="card border rounded-3 p-3 mb-4 bg-white shadow-sm tf-delivery-address-card">
                            <div class="d-flex align-items-sm-center justify-content-between flex-column flex-sm-row gap-3">
                                <div class="d-flex align-items-start gap-3 flex-grow-1 min-w-0">
                                    <div class="rounded-circle bg-light p-2 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                        <i class="fa-solid fa-location-dot fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                            <span class="text-muted small">Deliver to:</span>
                                            <?php if (!empty($is_logged_in)): ?>
                                                <strong class="text-dark text-truncate" id="display-address-name"><?= html_escape($disp_name ?: 'Select Address'); ?><?= $disp_pin ? ', ' . html_escape($disp_pin) : ''; ?></strong>
                                                <?php if ($disp_name): ?>
                                                    <span class="badge bg-light text-secondary border text-uppercase" id="display-address-tag" style="font-size: 11px;"><?= html_escape($disp_tag); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-light text-secondary border text-uppercase d-none" id="display-address-tag" style="font-size: 11px;">HOME</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <strong class="text-dark" id="display-address-name">Sign In to Select Address</strong>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-secondary small text-truncate" id="display-address-full">
                                            <?= !empty($is_logged_in) ? html_escape($disp_addr ?: 'Choose or add your shipping address') : 'Please sign in or register to set your delivery address'; ?>
                                        </div>
                                        <div class="text-secondary small mt-1" id="display-address-phone-wrap" style="<?= empty($disp_phone) ? 'display: none;' : ''; ?>">
                                            <span class="text-muted">Phone:</span> <strong class="text-dark fw-medium" id="display-address-phone"><?= html_escape($disp_phone); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end text-sm-start flex-shrink-0">
                                    <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1 fw-bold w-100 w-sm-auto" onclick="openAddressModal()">
                                        <?= !empty($is_logged_in) ? 'Change' : 'Sign In'; ?>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Table Form -->
                        <div class="table-responsive-md">
                            <table class="tf-table-page-cart">
                                <thead>
                                    <tr>
                                        <th>Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="cart-table-body">
                                    <?php if (!empty($cart_items)): ?>
                                        <?php foreach ($cart_items as $item): 
                                            $item_img = !empty($item['image']) 
                                                ? (strpos($item['image'], 'http') === 0 ? $item['image'] : base_url('assets/images/' . $item['image']))
                                                : base_url('assets/images/products/womens/women-1.jpg');
                                            $item_key = $item['cart_key'] ?? $item['id'];
                                        ?>
                                        <tr class="tf-cart-item file-delete" id="cart-row-<?= html_escape($item_key); ?>">
                                            <td class="tf-cart-item_product">
                                                <a href="<?= site_url('product/' . $item['slug']); ?>" class="img-box">
                                                    <img src="<?= $item_img; ?>" alt="<?= html_escape($item['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                </a>
                                                <div class="cart-info">
                                                    <a href="<?= site_url('product/' . $item['slug']); ?>" class="cart-title link text-line-clamp-1 fw-semibold text-dark text-decoration-none">
                                                        <?= html_escape($item['title']); ?>
                                                    </a>
                                                    <?php if (!empty($item['variant_title'])): ?>
                                                        <div class="text-secondary-2 small"><?= html_escape($item['variant_title']); ?></div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($item['sku'])): ?>
                                                        <div class="text-muted small">SKU: <?= html_escape($item['sku']); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td data-cart-title="Price" class="tf-cart-item_price text-center">
                                                <div class="cart-price text-button price-on-sale" id="cart-item-unit-<?= html_escape($item_key); ?>" data-price="<?= (float) $item['price']; ?>">
                                                    <?= $currency_symbol . number_format($item['price'], 2); ?>
                                                </div>
                                            </td>
                                            <td data-cart-title="Quantity" class="tf-cart-item_quantity">
                                                <div class="wg-quantity mx-md-auto">
                                                    <span class="btn-quantity btn-decrease user-select-none cursor-pointer" onclick="updateCartPageQty('<?= html_escape($item_key); ?>', -1, event)">-</span>
                                                    <input type="text" class="quantity-product text-center" id="cart-page-qty-<?= html_escape($item_key); ?>" name="quantity" value="<?= $item['quantity']; ?>" data-max="<?= !empty($item['stock_max']) ? (int) $item['stock_max'] : 999; ?>" readonly>
                                                    <span class="btn-quantity btn-increase user-select-none cursor-pointer" onclick="updateCartPageQty('<?= html_escape($item_key); ?>', 1, event)">+</span>
                                                </div>
                                            </td>
                                            <td data-cart-title="Total" class="tf-cart-item_total text-center">
                                                <div class="cart-total text-button total-price" id="cart-page-total-<?= html_escape($item_key); ?>">
                                                    <?= $currency_symbol . number_format($item['total'], 2); ?>
                                                </div>
                                            </td>
                                            <td data-cart-title="Remove" class="remove-cart">
                                                <span class="cart-remove-item icon icon-close cursor-pointer" onclick="removeCartPageItem('<?= html_escape($item_key); ?>', event)" title="Remove Item"></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Coupon Code Form -->
                        <form action="<?= site_url('cart/apply_coupon'); ?>" method="POST" class="ip-discount-code" id="cartCouponForm">
                            <input type="text" name="coupon_code" id="cartCouponInput" placeholder="Add voucher discount" value="<?= html_escape($cart_summary['coupon']['code'] ?? ''); ?>" required>
                            <button type="submit" class="tf-btn"><span class="text">Apply Code</span></button>
                        </form>

                        <!-- Available Voucher Discounts -->
                        <div class="group-discount">
                            <div class="box-discount <?= (!empty($cart_summary['coupon']['code']) && $cart_summary['coupon']['code'] === 'WELCOME10') ? 'active' : ''; ?>">
                                <div class="discount-top">
                                    <div class="discount-off">
                                        <div class="text-caption-1">Discount</div>
                                        <span class="sale-off text-btn-uppercase">10% OFF</span>
                                    </div>
                                    <div class="discount-from">
                                        <p class="text-caption-1">For all orders <br> from $100</p>
                                    </div>
                                </div>
                                <div class="discount-bot">
                                    <span class="text-btn-uppercase">WELCOME10</span>
                                    <button type="button" class="tf-btn" onclick="applyQuickCoupon('WELCOME10')"><span class="text"><?= (!empty($cart_summary['coupon']['code']) && $cart_summary['coupon']['code'] === 'WELCOME10') ? 'Applied' : 'Apply Code'; ?></span></button>
                                </div>
                            </div>
                            <div class="box-discount <?= (!empty($cart_summary['coupon']['code']) && $cart_summary['coupon']['code'] === 'SAVE20') ? 'active' : ''; ?>">
                                <div class="discount-top">
                                    <div class="discount-off">
                                        <div class="text-caption-1">Discount</div>
                                        <span class="sale-off text-btn-uppercase">20% OFF</span>
                                    </div>
                                    <div class="discount-from">
                                        <p class="text-caption-1">For all orders <br> from $200</p>
                                    </div>
                                </div>
                                <div class="discount-bot">
                                    <span class="text-btn-uppercase">SAVE20</span>
                                    <button type="button" class="tf-btn" onclick="applyQuickCoupon('SAVE20')"><span class="text"><?= (!empty($cart_summary['coupon']['code']) && $cart_summary['coupon']['code'] === 'SAVE20') ? 'Applied' : 'Apply Code'; ?></span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Order Summary Sidebar -->
                    <div class="col-xl-4 mt-4 mt-xl-0">
                        <div class="fl-sidebar-cart">
                            <div class="box-order bg-surface">
                                <h5 class="title">Order Summary</h5>
                                <div class="subtotal text-button d-flex justify-content-between align-items-center">
                                    <span>Subtotal</span>
                                    <span class="total" id="order-summary-subtotal"><?= $currency_symbol . number_format($cart_summary['subtotal'], 2); ?></span>
                                </div>
                                
                                <div class="discount text-button d-flex justify-content-between align-items-center text-danger <?= (empty($cart_summary['discount']) || $cart_summary['discount'] <= 0) ? 'd-none' : ''; ?>" id="order-summary-discount-row">
                                    <span>Discount (<span id="applied-coupon-code"><?= html_escape($cart_summary['coupon']['code'] ?? ''); ?></span>) <a href="<?= site_url('cart/remove_coupon'); ?>" class="small text-danger text-decoration-underline ms-1">Remove</a></span>
                                    <span class="total" id="order-summary-discount">-<?= $currency_symbol . number_format($cart_summary['discount'] ?? 0, 2); ?></span>
                                </div>

                                <div class="ship">
                                    <span class="text-button">Shipping</span>
                                    <div class="flex-grow-1">
                                        <fieldset class="ship-item">
                                            <input type="radio" name="shipping_method_choice" class="tf-check-rounded" id="ship-standard" value="standard" <?= ($cart_summary['shipping_method'] === 'standard') ? 'checked' : ''; ?> onchange="changeShippingMethod('standard')">
                                            <label for="ship-standard" class="cursor-pointer">
                                                <span>Standard Shipping:</span>
                                                <span class="price" id="standard-shipping-price">
                                                    <?= ($cart_summary['subtotal'] >= $cart_summary['shipping_free_min']) ? 'FREE' : $currency_symbol . number_format($cart_summary['shipping_flat'], 2); ?>
                                                </span>
                                            </label>
                                        </fieldset>
                                        <fieldset class="ship-item">
                                            <input type="radio" name="shipping_method_choice" class="tf-check-rounded" id="ship-express" value="express" <?= ($cart_summary['shipping_method'] === 'express') ? 'checked' : ''; ?> onchange="changeShippingMethod('express')">
                                            <label for="ship-express" class="cursor-pointer">
                                                <span>Express Delivery:</span>
                                                <span class="price"><?= $currency_symbol . number_format($cart_summary['shipping_express'], 2); ?></span>
                                            </label>
                                        </fieldset>
                                    </div>
                                </div>

                                <h5 class="total-order d-flex justify-content-between align-items-center">
                                    <span>Total</span>
                                    <span class="total" id="order-summary-grandtotal"><?= $currency_symbol . number_format($cart_summary['total'], 2); ?></span>
                                </h5>

                                <div class="box-progress-checkout">
                                    <fieldset class="check-agree">
                                        <input type="checkbox" id="check-agree" class="tf-check-rounded" checked>
                                        <label for="check-agree">
                                            I agree with the <a href="<?= site_url('terms'); ?>">terms and conditions</a>
                                        </label>
                                    </fieldset>
                                    <div id="agree-warning" class="text-danger small mb-2 d-none">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> Please agree with the terms and conditions to proceed.
                                    </div>
                                    <a href="<?= site_url('checkout'); ?>" class="tf-btn btn-reset" id="btn-process-checkout" onclick="return handleCartCheckout(event)">Process To Checkout</a>
                                    <p class="text-button text-center mb-0">
                                        <a href="<?= site_url('shop'); ?>" class="text-dark text-decoration-none">Or continue shopping</a>
                                    </p>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty Cart State -->
                <div class="<?= !empty($cart_items) ? 'd-none' : ''; ?> text-center py-5" id="cart-empty-wrapper">
                    <div class="tf-cart-sold p-5 bg-surface rounded-4 d-inline-block w-100" style="max-width: 650px;">
                        <div class="mb-4 text-muted" style="font-size: 64px;">
                            <i class="fa-solid fa-basket-shopping text-secondary"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Your shopping cart is currently empty!</h4>
                        <p class="text-secondary-2 mb-4">Discover our top-rated collections and start adding items to your cart.</p>
                        <a href="<?= site_url('shop'); ?>" class="tf-btn btn-reset px-5 py-3 d-inline-block">
                            <span class="text">Explore Products</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Section cart -->

        <!-- Saved for Later (if any) -->
        <?php if (!empty($saved_items)): ?>
        <section class="flat-spacing pt-0">
            <div class="container">
                <div class="heading-section text-start mb-4">
                    <h5 class="heading fw-bold"><i class="fa-regular fa-bookmark me-2 text-primary"></i>Saved for Later (<?= count($saved_items); ?>)</h5>
                </div>
                <div class="row g-3">
                    <?php foreach ($saved_items as $s_item): 
                        $s_price = !empty($s_item['variant_sale_price']) ? $s_item['variant_sale_price'] : (!empty($s_item['variant_price']) ? $s_item['variant_price'] : (!empty($s_item['product_sale_price']) ? $s_item['product_sale_price'] : $s_item['product_price']));
                        $s_img = !empty($s_item['variant_image']) ? $s_item['variant_image'] : $s_item['product_image'];
                    ?>
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm p-3 bg-surface rounded-3">
                            <a href="<?= site_url('product/' . $s_item['product_slug']); ?>" class="img-box d-block mb-2 rounded overflow-hidden" style="height: 180px;">
                                <img src="<?= base_url('assets/images/' . $s_img); ?>" class="w-100 h-100 object-fit-cover" alt="<?= html_escape($s_item['product_title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                            </a>
                            <div class="d-flex flex-column flex-grow-1">
                                <a href="<?= site_url('product/' . $s_item['product_slug']); ?>" class="text-dark fw-semibold text-truncate text-decoration-none mb-1">
                                    <?= html_escape($s_item['product_title']); ?>
                                </a>
                                <?php if (!empty($s_item['variant_title'])): ?>
                                    <span class="badge bg-light text-dark border align-self-start mb-2"><?= html_escape($s_item['variant_title']); ?></span>
                                <?php endif; ?>
                                <div class="fw-bold text-primary mb-3"><?= $currency_symbol . number_format($s_price, 2); ?></div>
                                <div class="mt-auto d-flex gap-2">
                                    <a href="<?= site_url('cart/move_to_cart/' . $s_item['id']); ?>" class="tf-btn btn-sm btn-fill flex-grow-1 py-1 text-decoration-none">
                                        <span class="text small">Move to Cart</span>
                                    </a>
                                    <a href="<?= site_url('cart/remove_saved/' . $s_item['id']); ?>" class="btn btn-sm btn-outline-danger" title="Remove">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Recent / Recommended products ("You may also like") -->
        <?php if (!empty($cart_recommendations)): ?>
        <section class="flat-spacing pt-0"> 
            <div class="container">
                <div class="heading-section text-center wow fadeInUp">
                    <h4 class="heading">You may also like</h4>
                </div>
                <div dir="ltr" class="swiper tf-sw-recent" data-preview="4" data-tablet="3" data-mobile="2" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <?php foreach ($cart_recommendations as $rec): 
                            $rec_price = !empty($rec['sale_price']) ? $rec['sale_price'] : $rec['price'];
                            $rec_img = !empty($rec['main_image']) 
                                ? (strpos($rec['main_image'], 'http') === 0 ? $rec['main_image'] : base_url('assets/images/' . $rec['main_image']))
                                : base_url('assets/images/products/womens/women-1.jpg');
                        ?>
                        <div class="swiper-slide">
                            <div class="card-product wow fadeInUp" data-wow-delay="0s">
                                <div class="card-product-wrapper">
                                    <a href="<?= site_url('product/' . $rec['slug']); ?>" class="product-img">
                                        <img class="lazyload img-product" data-src="<?= $rec_img; ?>" src="<?= $rec_img; ?>" alt="<?= html_escape($rec['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                        <img class="lazyload img-hover" data-src="<?= $rec_img; ?>" src="<?= $rec_img; ?>" alt="<?= html_escape($rec['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="<?= site_url('product/' . $rec['slug']); ?>" class="box-icon quickview tf-btn-loading">
                                            <span class="icon icon-eye"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="list-btn-main">
                                        <a href="<?= site_url('product/' . $rec['slug']); ?>" class="btn-main-product">View Product</a>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="<?= site_url('product/' . $rec['slug']); ?>" class="title link"><?= html_escape($rec['title']); ?></a>
                                    <span class="price"><?= $currency_symbol . number_format($rec_price, 2); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="sw-pagination-recent sw-dots type-circle justify-content-center mt-4"></div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- /Recent product -->

        <script>
        var CURRENCY = '<?= $currency_symbol; ?>';
        var FREE_SHIPPING_MIN = <?= (float) $free_shipping_min; ?>;

        function showCartToast(message, type) {
            type = type || 'warning';
            var existingToast = document.getElementById('cart-toast-notice');
            if (existingToast) existingToast.remove();

            var toast = document.createElement('div');
            toast.id = 'cart-toast-notice';
            var bgClass = (type === 'success') ? 'bg-success text-white' : ((type === 'danger') ? 'bg-danger text-white' : 'bg-dark text-white');
            var icon = (type === 'success') ? 'fa-circle-check' : 'fa-circle-info';
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '99999';
            toast.innerHTML = 
                '<div class="toast show align-items-center ' + bgClass + ' border-0 shadow-lg" role="alert">' +
                    '<div class="d-flex">' +
                        '<div class="toast-body d-flex align-items-center gap-2">' +
                            '<i class="fa-solid ' + icon + ' fs-5 text-warning"></i>' +
                            '<span>' + message + '</span>' +
                        '</div>' +
                        '<button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest(\'#cart-toast-notice\').remove()"></button>' +
                    '</div>' +
                '</div>';
            document.body.appendChild(toast);
            setTimeout(function() {
                if (toast && toast.parentNode) toast.remove();
            }, 4000);
        }

        function updateCartPageQty(cartKey, delta, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            var qtyInput = document.getElementById('cart-page-qty-' + cartKey);
            if (!qtyInput) return;

            if (qtyInput.dataset.busy === '1') {
                return;
            }

            var currentVal = parseInt(qtyInput.value) || 1;
            var maxVal = parseInt(qtyInput.getAttribute('data-max')) || 999;
            var newVal = currentVal + delta;

            if (newVal < 1) {
                if (confirm('Remove this item from your cart?')) {
                    removeCartPageItem(cartKey, event);
                }
                return;
            }
            if (newVal > maxVal) {
                showCartToast('Maximum purchase limit of ' + maxVal + ' units reached for this item.', 'warning');
                return;
            }

            // Lock to prevent race condition during request
            qtyInput.dataset.busy = '1';
            qtyInput.value = newVal;

            var formData = new FormData();
            formData.append('cart_key', cartKey);
            formData.append('quantity', newVal);

            fetch('<?= site_url("cart/update"); ?>', {
                method: 'POST',
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                qtyInput.dataset.busy = '0';

                if (data.success) {
                    // Sync quantity directly from server cart items
                    var updatedItem = null;
                    if (data.cart_items && Array.isArray(data.cart_items)) {
                        updatedItem = data.cart_items.find(function(it) {
                            return (it.cart_key === cartKey || String(it.id) === String(cartKey));
                        });
                    }

                    if (updatedItem) {
                        qtyInput.value = updatedItem.quantity;
                        var itemTotalEl = document.getElementById('cart-page-total-' + cartKey);
                        if (itemTotalEl && updatedItem.total !== undefined) {
                            itemTotalEl.textContent = CURRENCY + parseFloat(updatedItem.total).toFixed(2);
                        }
                    } else if (data.item_total !== undefined) {
                        var itemTotalEl = document.getElementById('cart-page-total-' + cartKey);
                        if (itemTotalEl) {
                            itemTotalEl.textContent = CURRENCY + parseFloat(data.item_total).toFixed(2);
                        }
                    }

                    if (data.message) {
                        showCartToast(data.message, 'warning');
                    }

                    // Update order summary
                    applySummaryUpdate(data.cart_summary, data.cart_count);

                    // Update header cart badges
                    var badges = document.querySelectorAll('.cart-count, .cart-badge');
                    badges.forEach(function(b) { b.textContent = data.cart_count || 0; });

                    // Sync side cart if open
                    if (window.renderSideCart) {
                        window.renderSideCart(data.cart_items, data.cart_summary);
                    }
                } else {
                    qtyInput.value = currentVal;
                    if (data.message) {
                        showCartToast(data.message, 'warning');
                    }
                }
            })
            .catch(function(err) {
                qtyInput.dataset.busy = '0';
                qtyInput.value = currentVal;
                console.error('Error updating cart:', err);
                showCartToast('Unable to update quantity. Please try again.', 'danger');
            });
        }

        function removeCartPageItem(cartKey, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            var row = document.getElementById('cart-row-' + cartKey);
            if (row) {
                row.style.opacity = '0.4';
                row.style.pointerEvents = 'none';
            }

            var formData = new FormData();
            formData.append('cart_key', cartKey);

            fetch('<?= site_url("cart/remove"); ?>', {
                method: 'POST',
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    if (row) {
                        row.remove();
                    }

                    // Update order summary
                    applySummaryUpdate(data.cart_summary, data.cart_count);

                    // Update header badges
                    var badges = document.querySelectorAll('.cart-count, .cart-badge');
                    badges.forEach(function(b) { b.textContent = data.cart_count || 0; });

                    // If cart count is 0, toggle to empty wrapper
                    if (!data.cart_count || data.cart_count === 0) {
                        var cartWrapper = document.getElementById('cart-content-wrapper');
                        var emptyWrapper = document.getElementById('cart-empty-wrapper');
                        if (cartWrapper) cartWrapper.classList.add('d-none');
                        if (emptyWrapper) emptyWrapper.classList.remove('d-none');
                    }

                    // Sync side cart
                    if (window.renderSideCart) {
                        window.renderSideCart(data.cart_items, data.cart_summary);
                    }
                }
            })
            .catch(function(err) {
                console.error('Error removing cart item:', err);
                if (row) {
                    row.style.opacity = '1';
                    row.style.pointerEvents = 'auto';
                }
            });
        }

        function applySummaryUpdate(summary, count) {
            if (!summary) return;

            // Subtotal
            var subtotalEl = document.getElementById('order-summary-subtotal');
            if (subtotalEl) {
                subtotalEl.textContent = CURRENCY + parseFloat(summary.subtotal || 0).toFixed(2);
            }

            // Discount
            var discountRow = document.getElementById('order-summary-discount-row');
            var discountVal = document.getElementById('order-summary-discount');
            var discountCode = document.getElementById('applied-coupon-code');
            if (summary.discount && summary.discount > 0) {
                if (discountRow) discountRow.classList.remove('d-none');
                if (discountVal) discountVal.textContent = '-' + CURRENCY + parseFloat(summary.discount).toFixed(2);
                if (discountCode && summary.coupon) discountCode.textContent = summary.coupon.code;
            } else {
                if (discountRow) discountRow.classList.add('d-none');
            }

            // Shipping
            var standardPriceEl = document.getElementById('standard-shipping-price');
            if (standardPriceEl) {
                if (summary.subtotal >= summary.shipping_free_min) {
                    standardPriceEl.textContent = 'FREE';
                } else {
                    standardPriceEl.textContent = CURRENCY + parseFloat(summary.shipping_flat || 0).toFixed(2);
                }
            }

            // Grand Total
            var grandTotalEl = document.getElementById('order-summary-grandtotal');
            if (grandTotalEl) {
                grandTotalEl.textContent = CURRENCY + parseFloat(summary.total || 0).toFixed(2);
            }

            // Free Shipping Progress
            var thresholdText = document.getElementById('cart-page-threshold-text');
            var progressBar = document.getElementById('cart-page-progress-bar');
            var sub = parseFloat(summary.subtotal || 0);
            var minFree = parseFloat(summary.shipping_free_min || FREE_SHIPPING_MIN);
            var away = Math.max(0, minFree - sub);
            var pct = (minFree > 0) ? Math.min(100, Math.round((sub / minFree) * 100)) : 100;

            if (thresholdText) {
                if (away <= 0) {
                    thresholdText.innerHTML = '<i class="fa-solid fa-circle-check text-success me-1"></i> Congratulations! You\'ve got <span class="fw-semibold text-primary">Free Shipping</span>!';
                } else {
                    thresholdText.innerHTML = 'Buy <span class="fw-semibold text-primary">' + CURRENCY + away.toFixed(2) + '</span> more to get <span class="fw-semibold">Freeship</span>';
                }
            }
            if (progressBar) {
                progressBar.style.width = pct + '%';
                progressBar.setAttribute('data-progress', pct);
            }

            // Badges
            document.querySelectorAll('#cart-counter, .count-box, .count-cart, .side-cart-count').forEach(function(badge) {
                badge.textContent = count !== undefined ? count : (summary.item_count || 0);
            });
        }

        function changeShippingMethod(method) {
            var formData = new FormData();
            formData.append('shipping_method', method);

            fetch('<?= site_url("cart/set_shipping_method"); ?>', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success && data.cart_summary) {
                    applySummaryUpdate(data.cart_summary);
                    if (window.renderSideCart) {
                        window.renderSideCart(null, data.cart_summary);
                    }
                }
            });
        }

        function applyQuickCoupon(code) {
            var input = document.getElementById('cartCouponInput');
            if (input) {
                input.value = code;
                document.getElementById('cartCouponForm').submit();
            }
        }

        function handleCartCheckout(e) {
            var agreeCheck = document.getElementById('check-agree');
            var agreeWarning = document.getElementById('agree-warning');
            if (agreeCheck && !agreeCheck.checked) {
                if (e && e.preventDefault) e.preventDefault();
                if (agreeWarning) agreeWarning.classList.remove('d-none');
                agreeCheck.focus();
                return false;
            }
            if (agreeWarning) agreeWarning.classList.add('d-none');

            if (!window.IS_USER_LOGGED_IN) {
                if (e && e.preventDefault) e.preventDefault();
                if (typeof window.openLoginModal === 'function') {
                    window.openLoginModal('<?= site_url("checkout"); ?>', 'Please sign in or enter your mobile/email to proceed to checkout.');
                } else {
                    window.location.href = '<?= site_url("login"); ?>';
                }
                return false;
            }
            return true;
        }

        var agreeCheck = document.getElementById('check-agree');
        if (agreeCheck) {
            agreeCheck.addEventListener('change', function() {
                var agreeWarning = document.getElementById('agree-warning');
                if (agreeWarning && this.checked) {
                    agreeWarning.classList.add('d-none');
                }
            });
        }

        // Auto-open login modal if user was redirected from checkout
        if (window.location.search.indexOf('login=1') !== -1 || window.location.search.indexOf('auth=required') !== -1) {
            window.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    if (typeof window.openLoginModal === 'function') {
                        window.openLoginModal('<?= site_url("checkout"); ?>', 'Please sign in or enter your mobile/email to complete your purchase.');
                    }
                }, 350);
            });
        }
        </script>
