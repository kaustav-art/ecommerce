        <!-- Breadcrumb -->
        <div class="bg-light py-3 border-bottom">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('shop'); ?>">Shop</a></li>
                        <li class="breadcrumb-item active">Shopping Cart</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Cart Section -->
        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold mb-0">Your Shopping Cart</h3>
                    <?php if (!empty($cart_items)): ?>
                        <span class="text-muted small"><?= count($cart_items); ?> unique item(s)</span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($cart_items)): ?>
                    <div class="row">
                        <!-- Left: Cart Items Table -->
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <div class="card border shadow-sm">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="min-width: 280px;">Product</th>
                                                <th>Price</th>
                                                <th style="width: 130px;">Quantity</th>
                                                <th>Total</th>
                                                <th class="text-end pe-3">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cart_items as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img
                                                                src="<?= base_url('assets/images/' . $item['image']); ?>"
                                                                alt="<?= html_escape($item['title']); ?>"
                                                                class="rounded me-3 border"
                                                                style="width: 64px; height: 64px; object-fit: cover;"
                                                                onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                            <div>
                                                                <h6 class="mb-1">
                                                                    <a href="<?= site_url('product/' . $item['slug']); ?>" class="text-dark text-decoration-none fw-semibold">
                                                                        <?= html_escape($item['title']); ?>
                                                                    </a>
                                                                </h6>
                                                                <?php if (!empty($item['variant_title'])): ?>
                                                                    <span class="badge bg-light text-dark border me-1 mb-1">
                                                                        <i class="fa-solid fa-sliders me-1 text-muted"></i> <?= html_escape($item['variant_title']); ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                                <div>
                                                                    <small class="text-muted">SKU: <code><?= html_escape($item['sku'] ?? 'N/A'); ?></code></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $currency_symbol . number_format($item['price'], 2); ?></td>
                                                    <td>
                                                        <form action="<?= site_url('cart/update'); ?>" method="POST" class="d-flex align-items-center gap-1">
                                                            <input type="hidden" name="cart_key" value="<?= html_escape($item['cart_key'] ?? $item['id']); ?>">
                                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                                <button class="btn btn-outline-secondary" type="button" onclick="var q = this.nextElementSibling; if (q.value > 1) { q.value--; this.form.submit(); }">-</button>
                                                                <input
                                                                    type="number"
                                                                    name="quantity"
                                                                    value="<?= $item['quantity']; ?>"
                                                                    min="1"
                                                                    max="<?= $item['stock_max'] ?? 99; ?>"
                                                                    class="form-control text-center px-1"
                                                                    onchange="this.form.submit()">
                                                                <button class="btn btn-outline-secondary" type="button" onclick="var q = this.previousElementSibling; if (q.value < <?= $item['stock_max'] ?? 99; ?>) { q.value++; this.form.submit(); }">+</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td><strong><?= $currency_symbol . number_format($item['total'], 2); ?></strong></td>
                                                    <td class="text-end pe-3">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= site_url('cart/save_for_later/' . urlencode($item['cart_key'] ?? $item['id'])); ?>" class="btn btn-outline-secondary btn-sm" title="Save for Later">
                                                                <i class="fa-regular fa-bookmark me-1"></i> Save
                                                            </a>
                                                            <a href="<?= site_url('cart/remove/' . urlencode($item['cart_key'] ?? $item['id'])); ?>" class="btn btn-outline-danger btn-sm" title="Remove Item" onclick="return confirm('Remove this item from cart?');">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
                                    <a href="<?= site_url('shop'); ?>" class="btn btn-outline-dark btn-sm">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
                                    </a>
                                    <a href="<?= site_url('cart/clear'); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Clear entire cart?');">
                                        <i class="fa-solid fa-broom me-1"></i> Clear Cart
                                    </a>
                                </div>
                            </div>

                            <!-- Coupon Box -->
                            <div class="card border shadow-sm mt-4 p-3">
                                <h6 class="fw-bold mb-2"><i class="fa-solid fa-ticket text-primary me-2"></i>Have a Discount Coupon?</h6>
                                <form action="<?= site_url('cart/apply_coupon'); ?>" method="POST" class="d-flex gap-2">
                                    <input
                                        type="text"
                                        name="coupon_code"
                                        class="form-control text-uppercase"
                                        placeholder="Try WELCOME10, SAVE20..."
                                        value="<?= html_escape($cart_summary['coupon']['code'] ?? ''); ?>"
                                        style="max-width: 280px;"
                                        required>
                                    <button type="submit" class="btn btn-dark">Apply Coupon</button>
                                    <?php if (!empty($cart_summary['coupon'])): ?>
                                        <a href="<?= site_url('cart/remove_coupon'); ?>" class="btn btn-outline-danger">Remove</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>

                        <!-- Right: Cart Summary -->
                        <div class="col-lg-4">
                            <div class="card border shadow-sm p-4">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">Order Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal (<?= $cart_summary['item_count']; ?> items):</span>
                                    <span><?= $currency_symbol . number_format($cart_summary['subtotal'], 2); ?></span>
                                </div>

                                <?php if ($cart_summary['discount'] > 0): ?>
                                    <div class="d-flex justify-content-between mb-2 text-danger">
                                        <span>Coupon Discount (<?= html_escape($cart_summary['coupon']['code']); ?>):</span>
                                        <span>-<?= $currency_symbol . number_format($cart_summary['discount'], 2); ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Shipping Selection -->
                                <div class="my-3 border-top border-bottom py-3">
                                    <label class="form-label fw-bold small mb-2"><i class="fa-solid fa-truck-fast text-primary me-1"></i> Delivery Method</label>
                                    <form action="<?= site_url('cart/set_shipping_method'); ?>" method="POST" id="shippingMethodForm">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="shipping_method" id="ship_standard" value="standard" <?= ($cart_summary['shipping_method'] === 'standard') ? 'checked' : ''; ?> onchange="this.form.submit()">
                                            <label class="form-check-label small d-flex justify-content-between" for="ship_standard">
                                                <span>Standard Delivery (3-5 Days)</span>
                                                <strong><?= ($cart_summary['subtotal'] >= $cart_summary['shipping_free_min']) ? '<span class="text-success">FREE</span>' : $currency_symbol . number_format($cart_summary['shipping_flat'], 2); ?></strong>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="shipping_method" id="ship_express" value="express" <?= ($cart_summary['shipping_method'] === 'express') ? 'checked' : ''; ?> onchange="this.form.submit()">
                                            <label class="form-check-label small d-flex justify-content-between" for="ship_express">
                                                <span>Express Priority (1-2 Days)</span>
                                                <strong><?= $currency_symbol . number_format($cart_summary['shipping_express'], 2); ?></strong>
                                            </label>
                                        </div>
                                    </form>
                                    <?php if ($cart_summary['subtotal'] < $cart_summary['shipping_free_min']): ?>
                                        <div class="small text-muted mt-2">
                                            <i class="fa-solid fa-circle-info text-info me-1"></i> Add <strong><?= $currency_symbol . number_format($cart_summary['shipping_free_min'] - $cart_summary['subtotal'], 2); ?></strong> more for FREE Standard Shipping!
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Estimated Tax (<?= $cart_summary['tax_rate_percent']; ?>%):</span>
                                    <span><?= $currency_symbol . number_format($cart_summary['tax'], 2); ?></span>
                                </div>

                                <div class="border-top pt-3 d-flex justify-content-between mb-4">
                                    <strong class="fs-5">Grand Total:</strong>
                                    <strong class="fs-5 text-primary"><?= $currency_symbol . number_format($cart_summary['total'], 2); ?></strong>
                                </div>

                                <a href="<?= site_url('checkout'); ?>" class="btn btn-primary btn-lg w-100 mb-3">
                                    Proceed to Checkout <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>

                                <div class="text-center text-muted small">
                                    <i class="fa-solid fa-shield-halved text-success me-1"></i> Safe & Secure 256-Bit SSL Checkout
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card border p-5 text-center my-4 shadow-sm">
                        <div class="fs-1 text-muted mb-3"><i class="fa-solid fa-cart-shopping"></i></div>
                        <h4>Your shopping cart is currently empty!</h4>
                        <p class="text-muted mb-4">Looks like you haven't added any items to your shopping cart yet.</p>
                        <a href="<?= site_url('shop'); ?>" class="btn btn-primary btn-lg px-4 d-inline-block" style="max-width: 220px; margin: 0 auto;">
                            <i class="fa-solid fa-bag-shopping me-1"></i> Start Shopping
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Saved For Later Section -->
                <?php if (!empty($saved_items)): ?>
                    <div class="mt-5 pt-4 border-top">
                        <h4 class="fw-bold mb-3"><i class="fa-regular fa-bookmark text-primary me-2"></i>Saved for Later (<?= count($saved_items); ?>)</h4>
                        <div class="row g-3">
                            <?php foreach ($saved_items as $s_item): ?>
                                <?php
                                    $s_price = !empty($s_item['variant_sale_price']) ? $s_item['variant_sale_price'] : (!empty($s_item['variant_price']) ? $s_item['variant_price'] : (!empty($s_item['product_sale_price']) ? $s_item['product_sale_price'] : $s_item['product_price']));
                                    $s_img = !empty($s_item['variant_image']) ? $s_item['variant_image'] : $s_item['product_image'];
                                ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card h-100 border shadow-sm">
                                        <div class="bg-white text-center p-2" style="height: 180px;">
                                            <a href="<?= site_url('product/' . $s_item['product_slug']); ?>">
                                                <img src="<?= base_url('assets/images/' . $s_img); ?>" class="w-100 h-100 object-fit-cover rounded" alt="<?= html_escape($s_item['product_title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                            </a>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title text-truncate mb-1">
                                                <a href="<?= site_url('product/' . $s_item['product_slug']); ?>" class="text-dark text-decoration-none">
                                                    <?= html_escape($s_item['product_title']); ?>
                                                </a>
                                            </h6>
                                            <?php if (!empty($s_item['variant_title'])): ?>
                                                <span class="badge bg-light text-muted border align-self-start mb-2"><?= html_escape($s_item['variant_title']); ?></span>
                                            <?php endif; ?>
                                            <div class="fw-bold text-dark mb-3"><?= $currency_symbol . number_format($s_price, 2); ?></div>
                                            <div class="mt-auto d-flex gap-2">
                                                <a href="<?= site_url('cart/move_to_cart/' . $s_item['id']); ?>" class="btn btn-sm btn-primary flex-grow-1">
                                                    <i class="fa-solid fa-cart-arrow-down me-1"></i> Move to Cart
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
                <?php endif; ?>
            </div>
        </section>
