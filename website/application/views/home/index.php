        <!-- Slider -->
        <section class="tf-slideshow slider-default slider-effect-fade">
            <div dir="ltr" class="swiper tf-sw-slideshow" data-effect="fade" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-space-mb="0" data-loop="true" data-auto-play="true">
                <div class="swiper-wrapper">
                    <?php if (!empty($banners)): ?>
                        <?php foreach ($banners as $b): ?>
                            <div class="swiper-slide">
                                <div class="wrap-slider">
                                    <img src="<?= base_url('assets/images/' . $b['image']); ?>" alt="<?= html_escape($b['title']); ?>" onerror="this.src='<?= base_url('assets/images/slider/slider-women1.jpg'); ?>'">
                                    <div class="box-content">
                                        <div class="content-slider">
                                            <div class="box-title-slider">
                                                <?php if (!empty($b['subtitle'])): ?>
                                                    <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white"><?= html_escape($b['subtitle']); ?></p>
                                                <?php endif; ?>
                                                <div class="fade-item fade-item-2 heading text-white title-display"><?= nl2br(html_escape($b['title'])); ?></div>
                                            </div>
                                            <div class="fade-item fade-item-3 box-btn-slider">
                                                <a href="<?= site_url($b['button_link'] ?: 'shop'); ?>" class="tf-btn btn-fill btn-white">
                                                    <span class="text"><?= html_escape($b['button_text'] ?: 'Explore Collection'); ?></span>
                                                    <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="swiper-slide">
                            <div class="wrap-slider">
                                <img src="<?= base_url('assets/images/slider/slider-women1.jpg'); ?>" alt="Default Slideshow">
                                <div class="box-content">
                                    <div class="content-slider">
                                        <div class="box-title-slider">
                                            <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white">SUMMER SALE</p>
                                            <div class="fade-item fade-item-2 heading text-white title-display">Flash Sale Madness</div>
                                        </div>
                                        <div class="fade-item fade-item-3 box-btn-slider">
                                            <a href="<?= site_url('shop'); ?>" class="tf-btn btn-fill btn-white">
                                                <span class="text">Explore Collection</span>
                                                <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="wrap-pagination">
                <div class="container">
                    <div class="sw-dots sw-pagination-slider type-circle white-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Slider -->

        <!-- Categories you might like -->
        <section class="flat-spacing-2 pb_0">
            <div class="container">
                <div class="heading-section-2 wow fadeInUp">
                    <h3>Categories you might like</h3>
                    <a href="<?= site_url('shop'); ?>" class="btn-line">View All Collection</a>
                </div>
                <div class="flat-collection-circle wow fadeInUp" data-wow-delay="0.1s">
                    <div dir="ltr" class="swiper tf-sw-collection" data-preview="5" data-tablet="3" data-mobile="2" data-space-lg="20" data-space-md="20" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                        <div class="swiper-wrapper">
                            <?php if (!empty($featured_cats)): ?>
                                <?php foreach ($featured_cats as $cat): ?>
                                    <div class="swiper-slide">
                                        <div class="collection-circle hover-img">
                                            <a href="<?= site_url('shop/' . $cat['slug']); ?>" class="img-style">
                                                <img class="lazyload" data-src="<?= base_url('assets/images/' . ($cat['image'] ?: 'collections/collection-circle/cls-circle1.jpg')); ?>" src="<?= base_url('assets/images/' . ($cat['image'] ?: 'collections/collection-circle/cls-circle1.jpg')); ?>" alt="<?= html_escape($cat['name']); ?>" onerror="this.src='<?= base_url('assets/images/collections/collection-circle/cls-circle1.jpg'); ?>'">
                                            </a>
                                            <div class="collection-content text-center">
                                                <div>
                                                    <a href="<?= site_url('shop/' . $cat['slug']); ?>" class="cls-title">
                                                        <h6 class="text"><?= html_escape($cat['name']); ?></h6>
                                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size: 13px;"></i>    
                                                    </a>
                                                </div>
                                                <div class="count text-secondary"><?= $cat['product_count'] ?? 0; ?> items</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex d-lg-none sw-pagination-collection sw-dots type-circle justify-content-center"></div>
                    </div>
                    <div class="nav-prev-collection d-none d-lg-flex nav-sw style-line nav-sw-left"><i class="fa-solid fa-chevron-left"></i></div>
                    <div class="nav-next-collection d-none d-lg-flex nav-sw style-line nav-sw-right"><i class="fa-solid fa-chevron-right"></i></div>
                </div>
            </div>
        </section>
        <!-- /Categories you might like -->

        <!-- Tabbed Products (New Arrivals, Best Seller, On Sale) -->
        <section class="flat-spacing-3">
            <div class="container">
                <div class="flat-animate-tab">
                    <ul class="tab-product justify-content-sm-center" role="tablist">
                        <li class="nav-tab-item" role="presentation">
                            <a href="#newArrivals" class="active" data-bs-toggle="tab">New Arrivals</a>
                        </li>
                        <li class="nav-tab-item" role="presentation">
                            <a href="#bestSeller" data-bs-toggle="tab">Best Seller</a>
                        </li>
                        <li class="nav-tab-item" role="presentation">
                            <a href="#onSale" data-bs-toggle="tab">On Sale</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- New Arrivals Tab -->
                        <div class="tab-pane active show" id="newArrivals" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4">
                                <?php if (!empty($new_arrivals)): ?>
                                    <?php foreach ($new_arrivals as $p): ?>
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
                                                    <a href="<?= site_url('wishlist/toggle/' . $p['id']); ?>" class="box-icon wishlist btn-icon-action" title="Wishlist">
                                                        <i class="fa-regular fa-heart"></i>
                                                        <span class="tooltip">Wishlist</span>
                                                    </a>
                                                    <a href="<?= site_url('product/' . $p['slug']); ?>" class="box-icon quickview tf-btn-loading" title="Quick View">
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
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Best Seller Tab -->
                        <div class="tab-pane" id="bestSeller" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4">
                                <?php if (!empty($best_sellers)): ?>
                                    <?php foreach ($best_sellers as $p): ?>
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
                                                    <a href="<?= site_url('wishlist/toggle/' . $p['id']); ?>" class="box-icon wishlist btn-icon-action" title="Wishlist">
                                                        <i class="fa-regular fa-heart"></i>
                                                        <span class="tooltip">Wishlist</span>
                                                    </a>
                                                    <a href="<?= site_url('product/' . $p['slug']); ?>" class="box-icon quickview tf-btn-loading">
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
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- On Sale Tab -->
                        <div class="tab-pane" id="onSale" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4">
                                <?php if (!empty($on_sale)): ?>
                                    <?php foreach ($on_sale as $p): ?>
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
                                                    <a href="<?= site_url('wishlist/toggle/' . $p['id']); ?>" class="box-icon wishlist btn-icon-action" title="Wishlist">
                                                        <i class="fa-regular fa-heart"></i>
                                                        <span class="tooltip">Wishlist</span>
                                                    </a>
                                                    <a href="<?= site_url('product/' . $p['slug']); ?>" class="box-icon quickview tf-btn-loading">
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
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Tabbed Products -->

        <!-- Banner Collection (Promo Grid from index.html) -->
        <section class="flat-spacing pt-0">
            <div class="container">
                <div class="tf-grid-layout md-col-2">
                    <div class="collection-default hover-img">
                        <a href="<?= site_url('shop'); ?>" class="img-style">
                            <img class="lazyload" data-src="<?= base_url('assets/images/collections/banner-collection/banner-cls1.jpg'); ?>" src="<?= base_url('assets/images/collections/banner-collection/banner-cls1.jpg'); ?>" alt="Crossbody Bags">
                        </a>
                        <div class="content">
                            <h3 class="title wow fadeInUp"><a href="<?= site_url('shop'); ?>" class="link">Crossbody Bag Collection</a></h3>
                            <p class="desc wow fadeInUp">From beach to party: Perfect styles crafted for every occasion.</p>
                            <div class="wow fadeInUp">
                                <a href="<?= site_url('shop'); ?>" class="btn-line">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="collection-position hover-img">
                        <a href="<?= site_url('shop'); ?>" class="img-style">
                            <img class="lazyload" data-src="<?= base_url('assets/images/collections/banner-collection/banner-cls2.jpg'); ?>" src="<?= base_url('assets/images/collections/banner-collection/banner-cls2.jpg'); ?>" alt="Capsule Collection">
                        </a>
                        <div class="content">
                            <h3 class="title"><a href="<?= site_url('shop'); ?>" class="link text-white wow fadeInUp">Capsule Collection</a></h3>
                            <p class="desc text-white wow fadeInUp">Reserved for special moments and elevated everyday fashion</p>
                            <div class="wow fadeInUp">
                                <a href="<?= site_url('shop'); ?>" class="btn-line style-white">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner Collection -->

        <!-- Banner Countdown / Limited Time -->
        <section class="bg-surface flat-spacing flat-countdown-banner">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="banner-left">
                            <div class="box-title">
                                <h3 class="wow fadeInUp">Limited-Time Deals On!</h3>
                                <p class="text-secondary wow fadeInUp">Up to 50% Off Selected Styles. Don't Miss Out.</p>
                            </div>
                            <div class="btn-banner wow fadeInUp">
                                <a href="<?= site_url('shop'); ?>" class="tf-btn btn-fill"><span class="text">Shop Now</span><i class="fa-solid fa-arrow-up-right-from-square ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 text-center my-3 my-lg-0">
                        <div class="banner-img">
                            <img class="lazyload img-fluid" data-src="<?= base_url('assets/images/banner/img-countdown1.png'); ?>" src="<?= base_url('assets/images/banner/img-countdown1.png'); ?>" alt="Countdown">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="banner-right">
                            <div class="tf-countdown-lg">
                                <div class="js-countdown" data-timer="1007500" data-labels="Days,Hours,Mins,Secs"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner Countdown -->

        <!-- Brand Showcase -->
        <?php if (!empty($brands)): ?>
            <section class="flat-spacing py-4 border-bottom">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-around gap-4">
                        <?php foreach ($brands as $brand): ?>
                            <div class="opacity-75 hover-opacity-100 transition text-center">
                                <a href="<?= site_url('shop?brand=' . $brand['slug']); ?>" class="text-decoration-none text-dark fw-bold fs-5">
                                    <?php if (!empty($brand['logo'])): ?>
                                        <img src="<?= base_url('assets/images/' . $brand['logo']); ?>" alt="<?= html_escape($brand['name']); ?>" style="max-height: 40px; filter: grayscale(100%);" class="hover-filter-none" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <?php endif; ?>
                                    <span style="<?= !empty($brand['logo']) ? 'display:none;' : ''; ?>"><?= html_escape($brand['name']); ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Features / Service Iconbox -->
        <section class="flat-spacing">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-iconbox" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><i class="fa-solid fa-rotate-left"></i></div>
                                <div class="content text-center">
                                    <h6>14-Day Returns</h6>
                                    <p class="text-secondary">Risk-free shopping with easy returns.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><i class="fa-solid fa-truck-fast"></i></div>
                                <div class="content text-center">
                                    <h6>Free Shipping</h6>
                                    <p class="text-secondary">Free standard shipping on all major orders.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><i class="fa-solid fa-headset"></i></div>
                                <div class="content text-center">
                                    <h6>24/7 Support</h6>
                                    <p class="text-secondary">Dedicated customer support team anytime.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><i class="fa-solid fa-shield-halved"></i></div>
                                <div class="content text-center">
                                    <h6>Secure Payments</h6>
                                    <p class="text-secondary">Encrypted transactions via Stripe, Razorpay & PayU.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-iconbox sw-dots type-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Features -->
