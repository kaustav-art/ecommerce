        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading">My Wishlist</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li><a class="link" href="<?= site_url('shop'); ?>">Shop</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li>Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- my-account -->
        <section class="flat-spacing">
            <div class="container">
                <div class="my-account-wrap">
                    <?php $this->load->view('account/sidebar'); ?>

                    <div class="my-account-content">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0">Saved Wishlist Items (<?= count($wishlist); ?>)</h5>
                            <?php if (!empty($wishlist)): ?>
                                <a href="<?= site_url('shop'); ?>" class="btn btn-outline-primary btn-sm">Continue Shopping</a>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($wishlist)): ?>
                            <div class="tf-grid-layout tf-col-2 lg-col-3">
                                <?php foreach ($wishlist as $item): ?>
                                    <div class="card-product wow fadeInUp">
                                        <div class="card-product-wrapper">
                                            <a href="<?= site_url('product/' . $item['slug']); ?>" class="product-img">
                                                <img class="lazyload img-product" data-src="<?= base_url('assets/images/' . $item['main_image']); ?>" src="<?= base_url('assets/images/' . $item['main_image']); ?>" alt="<?= html_escape($item['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                            </a>
                                            <?php if (!empty($item['sale_price'])): ?>
                                                <div class="on-sale-wrap"><span class="on-sale-item">SALE</span></div>
                                            <?php endif; ?>
                                            <div class="list-product-btn">
                                                <a href="<?= site_url('wishlist/toggle/' . $item['id']); ?>" class="box-icon wishlist active btn-icon-action text-danger" title="Remove from wishlist">
                                                    <i class="fa-solid fa-heart text-danger"></i>
                                                    <span class="tooltip">Remove</span>
                                                </a>
                                                <a href="<?= site_url('product/' . $item['slug']); ?>" class="box-icon quickview tf-btn-loading" title="View details">
                                                    <i class="fa-regular fa-eye"></i>
                                                    <span class="tooltip">View</span>
                                                </a>
                                            </div>
                                            <div class="list-btn-main">
                                                <form action="<?= site_url('cart/add'); ?>" method="POST" class="d-inline w-100">
                                                    <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn-main-product border-0 w-100">Add To cart</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-product-info">
                                            <a href="<?= site_url('product/' . $item['slug']); ?>" class="title link"><?= html_escape($item['title']); ?></a>
                                            <div class="price">
                                                <?php if (!empty($item['sale_price'])): ?>
                                                    <span class="text-danger fw-bold">$<?= number_format($item['sale_price'], 2); ?></span>
                                                    <span class="text-muted text-decoration-line-through small ms-1">$<?= number_format($item['price'], 2); ?></span>
                                                <?php else: ?>
                                                    <span class="fw-bold">$<?= number_format($item['price'], 2); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fa-regular fa-heart fs-1 text-muted"></i>
                                </div>
                                <h5 class="fw-bold">Your wishlist is currently empty</h5>
                                <p class="text-muted">Explore our catalog and click the heart icon on any product to save your favorite items here.</p>
                                <a href="<?= site_url('shop'); ?>" class="btn btn-primary btn-sm">Explore Collection</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->
