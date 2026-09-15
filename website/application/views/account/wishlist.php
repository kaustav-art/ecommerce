        <!-- breadcrumb -->
        <div class="bg-light py-2 border-bottom">
            <div class="container" style="max-width: 1240px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 12px;">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('account/profile'); ?>" class="text-muted text-decoration-none">My Account</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">My Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- my-account -->
        <section class="py-4" style="background-color: #f1f3f6; min-height: 80vh;">
            <div class="container" style="max-width: 1240px;">
                <div class="row g-3">
                    <!-- Left Sidebar -->
                    <div class="col-lg-3 col-md-4">
                        <?php $this->load->view('account/sidebar'); ?>
                    </div>

                    <!-- Right Content -->
                    <div class="col-lg-9 col-md-8">
                        <div class="card border rounded-1 shadow-sm bg-white p-3 p-md-4" style="border-color: #f0f0f0 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold m-0 text-dark" style="font-size: 17px;">My Wishlist (<?= count($wishlist); ?>)</h5>
                                <?php if (!empty($wishlist)): ?>
                                    <a href="<?= site_url('shop'); ?>" class="btn btn-outline-primary btn-sm rounded-1 fw-semibold" style="font-size: 13px; border-color: #2874f0; color: #2874f0;">Continue Shopping</a>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($wishlist)): ?>
                                <div class="row g-3">
                                    <?php foreach ($wishlist as $item): ?>
                                        <div class="col-6 col-md-4">
                                            <div class="card border rounded-1 p-2 h-100 position-relative shadow-none" style="border-color: #e0e0e0 !important;">
                                                <a href="<?= site_url('wishlist/toggle/' . $item['id']); ?>" class="position-absolute top-0 end-0 m-1 m-sm-2 text-danger bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; z-index: 2;" title="Remove from wishlist">
                                                    <i class="fa-solid fa-heart text-danger small"></i>
                                                </a>
                                                <a href="<?= site_url('product/' . $item['slug']); ?>" class="text-center d-block mb-2 overflow-hidden" style="height: 150px;">
                                                    <img src="<?= base_url('assets/images/' . $item['main_image']); ?>" alt="<?= html_escape($item['title']); ?>" class="img-fluid rounded-1 w-100 h-100 object-fit-contain" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                </a>
                                                <div class="p-1 p-sm-2 d-flex flex-column flex-grow-1">
                                                    <a href="<?= site_url('product/' . $item['slug']); ?>" class="text-dark fw-bold text-decoration-none d-block mb-1 text-truncate" style="font-size: 13px;" title="<?= html_escape($item['title']); ?>">
                                                        <?= html_escape($item['title']); ?>
                                                    </a>
                                                    <div class="fw-bold text-dark mb-2" style="font-size: 14px;">
                                                        <?php if (!empty($item['sale_price'])): ?>
                                                            <span class="text-dark"><?= $currency_symbol . number_format($item['sale_price'], 2); ?></span>
                                                            <span class="text-muted text-decoration-line-through small ms-1" style="font-size: 11px;"><?= $currency_symbol . number_format($item['price'], 2); ?></span>
                                                        <?php else: ?>
                                                            <span><?= $currency_symbol . number_format($item['price'], 2); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <form action="<?= site_url('cart/add'); ?>" method="POST" class="mt-auto">
                                                        <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="btn btn-primary btn-sm w-100 rounded-1 fw-semibold py-1" style="background-color: #2874f0; border-color: #2874f0; min-height: 34px; font-size: 12px;">
                                                            Add To Cart
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3 text-muted">
                                        <i class="fa-regular fa-heart fs-1" style="color: #b0bec5;"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Your wishlist is currently empty</h6>
                                    <p class="text-muted small mb-3">Explore our catalog and click the heart icon on any product to save items here.</p>
                                    <a href="<?= site_url('shop'); ?>" class="btn btn-primary btn-sm rounded-1 px-3" style="background-color: #2874f0; border-color: #2874f0;">Explore Collection</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->
