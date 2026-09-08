<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Collect all images (main image first, followed by gallery images)
$all_images = [];
if (!empty($product['main_image'])) {
    $all_images[] = $product['main_image'];
}
if (!empty($product['gallery_images_decoded']) && is_array($product['gallery_images_decoded'])) {
    foreach ($product['gallery_images_decoded'] as $g_img) {
        if (!empty($g_img) && !in_array($g_img, $all_images)) {
            $all_images[] = $g_img;
        }
    }
}
if (empty($all_images)) {
    $all_images[] = 'products/womens/women-1.jpg';
}
$total_images = count($all_images);

// Price & discount calculations
$regular_price = (float) $product['price'];
$sale_price = !empty($product['sale_price']) ? (float) $product['sale_price'] : null;
$current_price = $sale_price ?: $regular_price;
$discount_percent = ($regular_price > 0 && $sale_price && $sale_price < $regular_price)
    ? round((($regular_price - $sale_price) / $regular_price) * 100)
    : 0;

// Variant configuration
$has_variants = !empty($product['variants']);
$has_color = !empty($product['attributes']['color']);
$has_size = !empty($product['attributes']['size']);

// Color map with variant photos & size inventory
$color_map = [];
$initial_color = '';
$initial_size = '';
$initial_variant_id = 0;
$initial_sku = $product['sku'];

if ($has_color && !empty($product['attributes']['color']['values'])) {
    foreach ($product['attributes']['color']['values'] as $idx => $c_val) {
        $c_name = $c_val['value'];
        if ($idx === 0) {
            $initial_color = $c_name;
        }

        // Locate color variant photo
        $c_photo = '';
        if ($has_variants) {
            foreach ($product['variants'] as $pv) {
                foreach ($pv['values'] as $val) {
                    if ($val['attribute_slug'] === 'color' && strcasecmp($val['attribute_value'], $c_name) === 0) {
                        if (!empty($pv['image'])) {
                            $c_photo = $pv['image'];
                            break 2;
                        }
                    }
                }
            }
        }
        if (empty($c_photo)) {
            $c_photo = $product['main_image'];
        }

        $color_map[$c_name] = [
            'id'         => $c_val['id'],
            'name'       => $c_name,
            'color_code' => $c_val['color_code'] ?? '#333333',
            'image'      => $c_photo,
            'sizes'      => []
        ];
    }
}

// Populate size availability for each color
if ($has_variants) {
    foreach ($product['variants'] as $pv) {
        $v_color = '';
        $v_size  = '';
        foreach ($pv['values'] as $val) {
            if ($val['attribute_slug'] === 'color') $v_color = $val['attribute_value'];
            if ($val['attribute_slug'] === 'size')  $v_size  = $val['attribute_value'];
        }
        if ($v_color && $v_size && isset($color_map[$v_color])) {
            $color_map[$v_color]['sizes'][$v_size] = [
                'variant_id' => (int) $pv['id'],
                'sku'        => $pv['sku'],
                'price'      => (float) $pv['price'],
                'sale_price' => !empty($pv['sale_price']) ? (float) $pv['sale_price'] : null,
                'stock'      => (int) $pv['stock_quantity'],
                'image'      => !empty($pv['image']) ? $pv['image'] : null
            ];
            // Pick initial in-stock size for initial color
            if ($v_color === $initial_color && empty($initial_size) && (int) $pv['stock_quantity'] > 0) {
                $initial_size       = $v_size;
                $initial_variant_id = (int) $pv['id'];
                $initial_sku        = $pv['sku'];
            }
        }
    }
}

// Fallbacks for initial selection
if (empty($initial_size) && $has_size && !empty($product['attributes']['size']['values'])) {
    $initial_size = $product['attributes']['size']['values'][0]['value'];
}
if ($has_variants && empty($initial_variant_id) && !empty($product['variants'])) {
    $initial_variant_id = (int) $product['variants'][0]['id'];
    $initial_sku        = $product['variants'][0]['sku'];
}
?>

<style>
/* ==========================================================================
   PRODUCT DETAILS CUSTOM STYLES (Grid Images, Variant Slider, Modals)
   ========================================================================== */

/* 2x2 Image Grid Layout (as in product_image_shown.PNG) */
.product-grid-gallery {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
.product-grid-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background-color: #f8f9fa;
    aspect-ratio: 3 / 4;
    cursor: pointer;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.product-grid-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.product-grid-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
}
.product-grid-item:hover img {
    transform: scale(1.03);
}

/* Floating Action Buttons on 2nd Image */
.grid-floating-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 10;
}
.grid-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #181818;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    cursor: pointer;
    transition: all 0.2s ease;
}
.grid-action-btn:hover {
    background: #181818;
    color: #ffffff;
    transform: translateY(-2px);
}
.grid-action-btn.active {
    background: #dc3545;
    color: #ffffff;
    border-color: #dc3545;
}

/* +N Overlay on 4th Image */
.product-grid-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border-radius: 8px;
    transition: background 0.25s ease;
    z-index: 5;
}
.product-grid-item:hover .product-grid-overlay {
    background: rgba(0, 0, 0, 0.6);
}
.product-grid-overlay .overlay-text {
    font-size: 38px;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: -0.5px;
    user-select: none;
}

/* Pricing Header Section (as in varient_products.PNG) */
.product-price-block {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 6px;
}
.product-discount-rate {
    color: #007600;
    font-size: 28px;
    font-weight: 400;
    line-height: 1;
    display: inline-flex;
    align-items: center;
}
.product-current-price {
    font-size: 30px;
    font-weight: 700;
    color: #0F1111;
    line-height: 1;
}
.product-mrp-price {
    color: #565959;
    font-size: 14px;
    text-decoration: line-through;
}
.product-tax-note {
    color: #565959;
    font-size: 12px;
    margin-bottom: 16px;
}

/* Color Variant Slider (as in varient_products.PNG) */
.color-variant-container {
    position: relative;
    padding: 0 34px;
    margin-bottom: 20px;
}
.color-slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #d5d9d9;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 3;
    box-shadow: 0 2px 5px rgba(0,0,0,0.12);
    transition: all 0.2s ease;
    color: #0F1111;
}
.color-slider-arrow:hover {
    background: #f7fafa;
    border-color: #007185;
}
.color-slider-arrow.prev { left: 0; }
.color-slider-arrow.next { right: 0; }
.color-slider-track {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding: 4px 2px;
}
.color-slider-track::-webkit-scrollbar {
    display: none;
}
.color-thumb-card {
    flex: 0 0 auto;
    width: 66px;
    border: 1.5px solid #d5d9d9;
    border-radius: 6px;
    padding: 3px;
    cursor: pointer;
    background: #ffffff;
    text-align: center;
    transition: all 0.2s ease;
}
.color-thumb-card:hover {
    border-color: #007185;
}
.color-thumb-card.active {
    border: 2px solid #007185;
    box-shadow: 0 0 0 1px #007185;
}
.color-thumb-card img {
    width: 100%;
    height: 64px;
    object-fit: cover;
    border-radius: 4px;
    display: block;
}
.color-thumb-card .color-thumb-title {
    display: block;
    font-size: 11px;
    color: #0F1111;
    margin-top: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 500;
}

/* Size Chips (as in varient_products.PNG) */
.variant-size-chip {
    min-width: 50px;
    height: 42px;
    padding: 0 14px;
    border: 1px solid #d5d9d9;
    border-radius: 6px;
    background: #ffffff;
    color: #0F1111;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
}
.variant-size-chip:hover:not(.is-out-of-stock) {
    border-color: #007185;
    background: #f7fafa;
}
.variant-size-chip.active {
    border: 2px solid #007185;
    background: #f0f8ff;
    color: #007185;
    font-weight: 700;
    box-shadow: 0 0 0 1px #007185;
}
/* Strikethrough & Dashed Border for Out-Of-Stock Sizes */
.variant-size-chip.is-out-of-stock {
    position: relative;
    color: #888888 !important;
    background-color: #fafafa !important;
    border: 1.5px dashed #cccccc !important;
    cursor: not-allowed;
    opacity: 0.7;
    overflow: hidden;
}
.variant-size-chip.is-out-of-stock::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top right, transparent calc(50% - 1px), #c0392b calc(50% - 1px), #c0392b calc(50% + 1px), transparent calc(50% + 1px));
    pointer-events: none;
}

/* Lightbox Modal */
#product-gallery-lightbox .modal-content {
    background-color: #141414;
    border: none;
    border-radius: 12px;
    overflow: hidden;
}
#product-gallery-lightbox .lightbox-main-img-wrap {
    min-height: 520px;
    max-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
#product-gallery-lightbox .lightbox-main-img-wrap img {
    max-height: 70vh;
    max-width: 100%;
    object-fit: contain;
    border-radius: 6px;
}
.lightbox-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.2s ease;
    z-index: 10;
}
.lightbox-arrow:hover {
    background: rgba(255, 255, 255, 0.4);
}
.lightbox-arrow.prev { left: 20px; }
.lightbox-arrow.next { right: 20px; }
.lightbox-thumbs-strip {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding: 12px;
    justify-content: center;
    background: #0a0a0a;
}
.lightbox-thumb-item {
    width: 60px;
    height: 70px;
    border-radius: 4px;
    overflow: hidden;
    cursor: pointer;
    opacity: 0.5;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}
.lightbox-thumb-item.active,
.lightbox-thumb-item:hover {
    opacity: 1;
    border-color: #ffffff;
}
.lightbox-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Brand Link */
.brand-store-link {
    font-size: 14px;
    color: #007185;
    transition: color 0.2s ease;
}
.brand-store-link:hover {
    color: #c7511f;
    text-decoration: underline !important;
}

/* Sticky ATC Bar Animation */
.tf-sticky-btn-atc {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 998;
    background: #ffffff;
    box-shadow: 0 -4px 16px rgba(0,0,0,0.1);
    transform: translateY(100%);
    transition: transform 0.3s ease;
    padding: 12px 0;
}
.tf-sticky-btn-atc.show {
    transform: translateY(0);
}
</style>

        <!-- breadcrumb -->
        <div class="tf-breadcrumb">
            <div class="container">
                <div class="tf-breadcrumb-wrap">
                    <div class="tf-breadcrumb-list">
                        <a href="<?= site_url('home'); ?>" class="text text-caption-1">Homepage</a>
                        <i class="icon icon-arrRight"></i>
                        <a href="<?= site_url('shop'); ?>" class="text text-caption-1">Shop</a>
                        <i class="icon icon-arrRight"></i>
                        <a href="<?= site_url('shop/' . $product['category_slug']); ?>" class="text text-caption-1"><?= html_escape($product['category_name']); ?></a>
                        <i class="icon icon-arrRight"></i>
                        <span class="text text-caption-1"><?= html_escape($product['title']); ?></span>
                    </div>
                    <div class="tf-breadcrumb-prev-next">
                        <a href="<?= site_url('shop'); ?>" class="tf-breadcrumb-back" title="Back to shop">
                            <i class="icon icon-squares-four"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- Product_Main -->
        <section class="flat-spacing">
            <div class="tf-main-product section-image-zoom">
                <div class="container">
                    <div class="row gx-5">
                        
                        <!-- LEFT COLUMN: 2x2 Grid Gallery (product_image_shown.PNG) -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="tf-product-media-wrap sticky-top" style="top: 100px;">
                                
                                <div class="product-grid-gallery" id="product-grid-gallery">
                                    <?php
                                    // Render up to 4 grid items
                                    $grid_slots = min(4, $total_images);
                                    for ($i = 0; $i < $grid_slots; $i++):
                                        $img_src = base_url('assets/images/' . $all_images[$i]);
                                        $is_last_slot = ($i === 3);
                                        $show_overlay = ($is_last_slot && $total_images > 4);
                                        $remaining_count = $total_images - 4;
                                    ?>
                                        <div class="product-grid-item" onclick="openLightbox(<?= $i; ?>)" id="grid-item-<?= $i; ?>">
                                            <img src="<?= $img_src; ?>" alt="<?= html_escape($product['title']) . ' - ' . ($i + 1); ?>" id="grid-img-<?= $i; ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                            
                                            <!-- Floating Actions in Top-Right corner of 2nd image (Slot 1) -->
                                            <?php if ($i === 1 || ($grid_slots === 1 && $i === 0)): ?>
                                                <div class="grid-floating-actions" onclick="event.stopPropagation();">
                                                    <button type="button" class="grid-action-btn wishlist-btn <?= !empty($is_in_wishlist) ? 'active' : ''; ?>" id="btn-grid-wishlist" onclick="toggleWishlist(<?= $product['id']; ?>, this)" title="Wishlist">
                                                        <i class="<?= !empty($is_in_wishlist) ? 'fa-solid' : 'fa-regular'; ?> fa-heart"></i>
                                                    </button>
                                                    <button type="button" class="grid-action-btn zoom-btn" onclick="openLightbox(<?= $i; ?>)" title="Fullscreen Gallery">
                                                        <i class="fa-solid fa-expand"></i>
                                                    </button>
                                                </div>
                                            <?php endif; ?>

                                            <!-- +N Overlay on 4th slot if > 4 images -->
                                            <?php if ($show_overlay): ?>
                                                <div class="product-grid-overlay">
                                                    <span class="overlay-text">+<?= $remaining_count; ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endfor; ?>
                                </div>

                                <!-- Subtle gallery helper note -->
                                <div class="text-center mt-2 text-secondary small">
                                    <i class="fa-regular fa-images me-1"></i> Showing <?= $grid_slots; ?> of <?= $total_images; ?> photos. Click any photo to view full gallery.
                                </div>

                            </div>
                        </div>
                        <!-- /LEFT COLUMN -->

                        <!-- RIGHT COLUMN: Product Info & Variants (varient_products.PNG) -->
                        <div class="col-md-6">
                            <div class="tf-product-info-wrap position-relative">
                                <div class="tf-product-info-list">
                                    
                                    <!-- Heading / Brand / Rating -->
                                    <div class="tf-product-info-heading">
                                        <div class="tf-product-info-name">
                                            
                                            <div class="text text-btn-uppercase text-secondary mb-1">
                                                <a href="<?= site_url('shop/' . $product['category_slug']); ?>" class="text-secondary text-decoration-none"><?= html_escape($product['category_name']); ?></a>
                                            </div>

                                            <h3 class="name fw-bold mb-2"><?= html_escape($product['title']); ?></h3>

                                            <!-- Brand Store Link (as in varient_products.PNG) -->
                                            <div>
                                                <a href="<?= site_url('shop?brand=' . ($product['brand_slug'] ?? '')); ?>" class="brand-store-link fw-semibold">
                                                    Visit the <?= html_escape($product['brand_name'] ?: 'VTEXX'); ?> Store
                                                </a>
                                            </div>

                                            <!-- Rating & Review Count -->
                                            <div class="sub d-flex align-items-center gap-2 mt-1">
                                                <div class="tf-product-info-rate d-flex align-items-center gap-1">
                                                    <span class="fw-bold me-1"><?= number_format($product['rating'], 1); ?></span>
                                                    <div class="list-star text-warning">
                                                        <?php
                                                        $r_score = round($product['rating'] * 2) / 2;
                                                        for ($s = 1; $s <= 5; $s++):
                                                            if ($s <= $r_score): ?>
                                                                <i class="fa-solid fa-star"></i>
                                                            <?php elseif ($s - 0.5 == $r_score): ?>
                                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                            <?php else: ?>
                                                                <i class="fa-regular fa-star"></i>
                                                            <?php endif;
                                                        endfor;
                                                        ?>
                                                    </div>
                                                    <div class="text text-caption-1 text-secondary ms-1">(<?= number_format($product['reviews_count'] ?: 128); ?> ratings)</div>
                                                </div>
                                                <span class="text-secondary">|</span>
                                                <a href="#tab-customer-reviews" class="text-secondary small text-decoration-none" onclick="activateReviewTab()">Search this page</a>
                                            </div>

                                        </div>

                                        <!-- Pricing Block (as in varient_products.PNG) -->
                                        <div class="tf-product-info-desc mt-3">
                                            <div class="product-price-block">
                                                <?php if ($discount_percent > 0): ?>
                                                    <div class="product-discount-rate" id="display-discount-rate">
                                                        <i class="fa-solid fa-arrow-down-long me-1"></i><?= $discount_percent; ?>%
                                                    </div>
                                                <?php endif; ?>

                                                <span class="product-current-price" id="display-sale-price">
                                                    <?= $currency_symbol . number_format($current_price, 2); ?>
                                                </span>

                                                <?php if ($sale_price && $sale_price < $regular_price): ?>
                                                    <span class="product-mrp-price" id="display-mrp-price">
                                                        M.R.P.: <?= $currency_symbol . number_format($regular_price, 2); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="product-tax-note">Inclusive of all taxes</div>

                                            <?php if (!empty($product['short_description'])): ?>
                                                <p class="text-secondary mb-3"><?= nl2br(html_escape($product['short_description'])); ?></p>
                                            <?php endif; ?>

                                            <!-- Live view note -->
                                            <div class="tf-product-info-liveview d-flex align-items-center gap-2">
                                                <i class="icon icon-eye"></i>
                                                <p class="text-caption-1 mb-0"><span class="liveview-count fw-bold text-dark">28</span> people are viewing this right now</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Variant Options Picker (varient_products.PNG) -->
                                    <div class="tf-product-info-choose-option mt-4">
                                        
                                        <!-- 1. COLOR SELECTION WITH SLIDER & PRODUCT PHOTOS -->
                                        <?php if ($has_color && !empty($color_map)): ?>
                                            <div class="variant-picker-item mb-4">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="variant-picker-label">
                                                        <span class="text-secondary">Selected Color:</span>
                                                        <strong class="ms-1" id="selected-color-name"><?= html_escape($initial_color); ?></strong>
                                                    </div>
                                                </div>

                                                <!-- Horizontal color slider with navigation arrows -->
                                                <div class="color-variant-container">
                                                    <button type="button" class="color-slider-arrow prev" id="color-arrow-prev" onclick="slideColorTrack(-1)" aria-label="Previous Color">
                                                        <i class="fa-solid fa-chevron-left"></i>
                                                    </button>
                                                    
                                                    <div class="color-slider-track" id="color-slider-track">
                                                        <?php foreach ($color_map as $c_name => $c_info): 
                                                            $is_active_color = ($c_name === $initial_color);
                                                        ?>
                                                            <div class="color-thumb-card <?= $is_active_color ? 'active' : ''; ?>" 
                                                                 data-color="<?= html_escape($c_name); ?>"
                                                                 data-image="<?= base_url('assets/images/' . $c_info['image']); ?>"
                                                                 onclick="selectColor('<?= html_escape($c_name); ?>', this)">
                                                                <img src="<?= base_url('assets/images/' . $c_info['image']); ?>" alt="<?= html_escape($c_name); ?>" onerror="this.src='<?= base_url('assets/images/' . $product['main_image']); ?>'">
                                                                <span class="color-thumb-title"><?= html_escape($c_name); ?></span>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>

                                                    <button type="button" class="color-slider-arrow next" id="color-arrow-next" onclick="slideColorTrack(1)" aria-label="Next Color">
                                                        <i class="fa-solid fa-chevron-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- 2. SIZE SELECTION WITH SIZE CHART MODAL & OUT-OF-STOCK STYLING -->
                                        <?php if ($has_size && !empty($product['attributes']['size']['values'])): ?>
                                            <div class="variant-picker-item mb-4">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="variant-picker-label">
                                                        <span class="text-secondary">Select Size:</span>
                                                        <strong class="ms-1" id="selected-size-name"><?= html_escape($initial_size); ?></strong>
                                                    </div>
                                                    <a href="#size-guide" data-bs-toggle="modal" class="text-primary text-decoration-none small fw-semibold">
                                                        <i class="fa-solid fa-ruler-horizontal me-1"></i> Size Chart <i class="fa-solid fa-chevron-right small ms-1"></i>
                                                    </a>
                                                </div>

                                                <div class="d-flex flex-wrap gap-2" id="size-chips-wrapper">
                                                    <?php 
                                                    foreach ($product['attributes']['size']['values'] as $s_val): 
                                                        $s_name = $s_val['value'];
                                                        $is_active_size = ($s_name === $initial_size);
                                                        
                                                        // Check stock for initial color
                                                        $in_stock = true;
                                                        if (!empty($color_map[$initial_color]['sizes'][$s_name])) {
                                                            $in_stock = ($color_map[$initial_color]['sizes'][$s_name]['stock'] > 0);
                                                        }
                                                    ?>
                                                        <button type="button" 
                                                                class="variant-size-chip <?= $is_active_size ? 'active' : ''; ?> <?= !$in_stock ? 'is-out-of-stock' : ''; ?>" 
                                                                data-size="<?= html_escape($s_name); ?>"
                                                                onclick="selectSize('<?= html_escape($s_name); ?>', this)"
                                                                title="<?= !$in_stock ? 'Out of stock' : 'Size ' . html_escape($s_name); ?>">
                                                            <?= html_escape($s_name); ?>
                                                        </button>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- QUANTITY SELECTOR -->
                                        <div class="tf-product-info-quantity mb-4">
                                            <div class="title mb-2 text-secondary fw-semibold">Quantity:</div>
                                            <div class="wg-quantity">
                                                <span class="btn-quantity btn-decrease" onclick="changeQty(-1)">-</span>
                                                <input class="quantity-product" type="number" id="product-qty-input" name="number" value="1" min="1" max="99" readonly>
                                                <span class="btn-quantity btn-increase" onclick="changeQty(1)">+</span>
                                            </div>
                                        </div>

                                        <!-- ACTION BUTTONS -->
                                        <div>
                                            <div class="tf-product-info-by-btn mb-2 d-flex gap-2">
                                                <button type="button" class="btn-style-2 flex-grow-1 text-btn-uppercase fw-bold btn-add-to-cart" id="main-btn-atc" onclick="addToCartAjax()">
                                                    <span>Add to cart -&nbsp;</span>
                                                    <span class="tf-qty-price total-price" id="atc-btn-price"><?= $currency_symbol . number_format($current_price, 2); ?></span>
                                                </button>
                                                <a href="<?= site_url('compare'); ?>" class="box-icon hover-tooltip compare btn-icon-action" title="Compare">
                                                    <span class="icon icon-gitDiff"></span>
                                                    <span class="tooltip text-caption-2">Compare</span>
                                                </a>
                                                <a href="javascript:void(0);" class="box-icon hover-tooltip wishlist btn-icon-action <?= !empty($is_in_wishlist) ? 'active' : ''; ?>" onclick="toggleWishlist(<?= $product['id']; ?>, this)" title="Wishlist">
                                                    <span class="icon icon-heart"></span>
                                                    <span class="tooltip text-caption-2">Wishlist</span>
                                                </a>
                                            </div>

                                            <button type="button" class="btn-style-3 text-btn-uppercase w-100 py-3 fw-bold" id="btn-buy-now" onclick="buyNow()">
                                                Buy it now
                                            </button>
                                        </div>

                                        <!-- Extra Links & Delivery Info (from product-detail.html) -->
                                        <div class="tf-product-info-help mt-4">
                                            <div class="tf-product-info-extra-link d-flex justify-content-between">
                                                <a href="#delivery_return" data-bs-toggle="modal" class="tf-product-extra-icon d-flex align-items-center gap-2 text-decoration-none">
                                                    <div class="icon"><i class="icon-shipping"></i></div>
                                                    <p class="text-caption-1 mb-0">Delivery & Return</p>
                                                </a>
                                                <a href="#ask_question" data-bs-toggle="modal" class="tf-product-extra-icon d-flex align-items-center gap-2 text-decoration-none">
                                                    <div class="icon"><i class="icon-question"></i></div>
                                                    <p class="text-caption-1 mb-0">Ask A Question</p>
                                                </a>
                                                <a href="#share_social" data-bs-toggle="modal" class="tf-product-extra-icon d-flex align-items-center gap-2 text-decoration-none">
                                                    <div class="icon"><i class="icon-share"></i></div>
                                                    <p class="text-caption-1 mb-0">Share</p>
                                                </a>
                                            </div>

                                            <div class="tf-product-info-time d-flex align-items-center gap-2 mt-3">
                                                <div class="icon"><i class="icon-timer"></i></div>
                                                <p class="text-caption-1 mb-0">Estimated Delivery:&nbsp;&nbsp;<span>3-6 business days</span></p>
                                            </div>
                                            <div class="tf-product-info-return d-flex align-items-center gap-2 mt-2">
                                                <div class="icon"><i class="icon-arrowClockwise"></i></div>
                                                <p class="text-caption-1 mb-0">Return within <span>30 days</span> of purchase. Hassle-free refunds.</p>
                                            </div>
                                        </div>

                                        <!-- SKU / Metadata -->
                                        <ul class="tf-product-info-sku list-unstyled border-top pt-3 mt-3">
                                            <li class="d-flex gap-2 py-1">
                                                <p class="text-caption-1 mb-0 text-secondary">SKU:</p>
                                                <p class="text-caption-1 mb-0 fw-semibold" id="display-sku"><?= html_escape($initial_sku); ?></p>
                                            </li>
                                            <li class="d-flex gap-2 py-1">
                                                <p class="text-caption-1 mb-0 text-secondary">Brand:</p>
                                                <p class="text-caption-1 mb-0 fw-semibold"><?= html_escape($product['brand_name'] ?: 'Modave'); ?></p>
                                            </li>
                                            <li class="d-flex gap-2 py-1">
                                                <p class="text-caption-1 mb-0 text-secondary">Availability:</p>
                                                <p class="text-caption-1 mb-0 fw-bold text-success" id="display-stock-status">In Stock</p>
                                            </li>
                                            <li class="d-flex gap-2 py-1">
                                                <p class="text-caption-1 mb-0 text-secondary">Category:</p>
                                                <p class="text-caption-1 mb-0"><a href="<?= site_url('shop/' . $product['category_slug']); ?>" class="text-primary text-decoration-none fw-semibold"><?= html_escape($product['category_name']); ?></a></p>
                                            </li>
                                        </ul>

                                        <!-- Guaranteed Safe Checkout -->
                                        <div class="tf-product-info-guranteed border-top pt-3 mt-3">
                                            <div class="text-title small text-secondary mb-2">Guaranteed safe checkout:</div>
                                            <div class="tf-payment d-flex gap-2 flex-wrap">
                                                <img src="<?= base_url('assets/images/payment/img-1.png'); ?>" alt="Visa" style="height: 24px;" onerror="this.style.display='none'">
                                                <img src="<?= base_url('assets/images/payment/img-2.png'); ?>" alt="MasterCard" style="height: 24px;" onerror="this.style.display='none'">
                                                <img src="<?= base_url('assets/images/payment/img-3.png'); ?>" alt="Amex" style="height: 24px;" onerror="this.style.display='none'">
                                                <img src="<?= base_url('assets/images/payment/img-4.png'); ?>" alt="PayPal" style="height: 24px;" onerror="this.style.display='none'">
                                                <img src="<?= base_url('assets/images/payment/img-5.png'); ?>" alt="UPI" style="height: 24px;" onerror="this.style.display='none'">
                                                <img src="<?= base_url('assets/images/payment/img-6.png'); ?>" alt="ApplePay" style="height: 24px;" onerror="this.style.display='none'">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /RIGHT COLUMN -->

                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Add-To-Cart Bar (from product-detail.html) -->
            <div class="tf-sticky-btn-atc" id="sticky-atc-bar">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <form class="form-sticky-atc d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="tf-sticky-atc-product d-flex align-items-center gap-3">
                                    <div class="image">
                                        <img id="sticky-bar-img" src="<?= base_url('assets/images/' . $all_images[0]); ?>" alt="<?= html_escape($product['title']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    </div>
                                    <div class="content">
                                        <div class="text-title fw-bold text-truncate" style="max-width: 240px;"><?= html_escape($product['title']); ?></div>
                                        <div class="text-caption-1 text-secondary" id="sticky-variant-label">
                                            <?= $has_color ? html_escape($initial_color) : ''; ?><?= ($has_color && $has_size) ? ', ' : ''; ?><?= $has_size ? html_escape($initial_size) : ''; ?>
                                        </div>
                                        <div class="text-title fw-bold text-primary" id="sticky-price-display"><?= $currency_symbol . number_format($current_price, 2); ?></div>
                                    </div>
                                </div>
                                <div class="tf-sticky-atc-infos d-flex align-items-center gap-3 flex-wrap">
                                    <?php if ($has_size && !empty($product['attributes']['size']['values'])): ?>
                                        <div class="tf-sticky-atc-size d-flex align-items-center gap-2">
                                            <span class="small text-secondary fw-semibold">Size:</span>
                                            <select class="form-select form-select-sm" id="sticky-size-dropdown" onchange="onStickySizeChange(this.value)" style="width: 85px;">
                                                <?php foreach ($product['attributes']['size']['values'] as $sv): ?>
                                                    <option value="<?= html_escape($sv['value']); ?>" <?= ($sv['value'] === $initial_size) ? 'selected' : ''; ?>>
                                                        <?= html_escape($sv['value']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="tf-sticky-atc-quantity d-flex align-items-center gap-2">
                                        <span class="small text-secondary fw-semibold">Qty:</span>
                                        <div class="wg-quantity style-1">
                                            <span class="btn-quantity minus-btn" onclick="changeQty(-1)">-</span>
                                            <input type="text" name="sticky_number" id="sticky-qty-input" value="1" readonly>
                                            <span class="btn-quantity plus-btn" onclick="changeQty(1)">+</span>
                                        </div>
                                    </div>
                                    <div class="tf-sticky-atc-btns">
                                        <button type="button" class="tf-btn btn-fill radius-4 btn-add-to-cart px-4 py-2" onclick="addToCartAjax()">
                                            <span class="text text-btn-uppercase fw-bold"><i class="fa-solid fa-bag-shopping me-1"></i> Add To Cart</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Sticky Bottom ATC -->

        </section>
        <!-- /Product_Main -->

        <!-- PRODUCT TABS: Description, Reviews, Shipping, Policies (from product-detail.html) -->
        <section class="py-5 border-top bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="widget-tabs style-1">
                            <ul class="widget-menu-tab nav nav-tabs border-bottom mb-4" id="productDetailTabs" role="tablist">
                                <li class="item-title nav-item">
                                    <button class="nav-link active fw-bold text-uppercase" id="tab-desc-btn" data-bs-toggle="tab" data-bs-target="#tab-description" type="button" role="tab">Description</button>
                                </li>
                                <li class="item-title nav-item">
                                    <button class="nav-link fw-bold text-uppercase" id="tab-reviews-btn" data-bs-toggle="tab" data-bs-target="#tab-customer-reviews" type="button" role="tab">Customer Reviews (<?= count($product['reviews'] ?? []); ?>)</button>
                                </li>
                                <li class="item-title nav-item">
                                    <button class="nav-link fw-bold text-uppercase" id="tab-shipping-btn" data-bs-toggle="tab" data-bs-target="#tab-shipping" type="button" role="tab">Shipping & Returns</button>
                                </li>
                                <li class="item-title nav-item">
                                    <button class="nav-link fw-bold text-uppercase" id="tab-policies-btn" data-bs-toggle="tab" data-bs-target="#tab-policies" type="button" role="tab">Return Policies</button>
                                </li>
                            </ul>
                            
                            <div class="tab-content bg-white p-4 rounded shadow-sm border" id="productDetailTabsContent">
                                
                                <!-- 1. DESCRIPTION TAB -->
                                <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
                                    <div class="tab-description">
                                        <div class="row gx-5">
                                            <div class="col-lg-7 mb-4 mb-lg-0">
                                                <h5 class="fw-bold mb-3"><?= html_escape($product['title']); ?></h5>
                                                <?php if (!empty($product['description'])): ?>
                                                    <div class="text-secondary mb-4"><?= $product['description']; ?></div>
                                                <?php else: ?>
                                                    <p class="text-secondary">Designed with utmost care and attention to detail, this premium item combines timeless style with modern performance.</p>
                                                <?php endif; ?>

                                                <!-- Specifications Table -->
                                                <?php if (!empty($product['specifications'])): ?>
                                                    <h6 class="fw-bold mb-3 text-uppercase letter-1">Specifications & Details</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-sm mb-0">
                                                            <tbody>
                                                                <?php foreach ($product['specifications'] as $spec): ?>
                                                                    <tr>
                                                                        <td class="fw-semibold text-secondary" style="width: 35%;"><?= html_escape($spec['spec_name'] ?? ($spec['spec_key'] ?? '')); ?></td>
                                                                        <td class="text-dark"><?= html_escape($spec['spec_value'] ?? ''); ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-lg-5">
                                                <div class="border rounded p-3 bg-light">
                                                    <h6 class="text-btn-uppercase fw-bold mb-3">Composition, Origin and Care</h6>
                                                    <ul class="list-unstyled text-secondary small mb-3">
                                                        <li class="mb-1"><i class="fa-solid fa-check text-success me-2"></i> Premium Breathable Fabric</li>
                                                        <li class="mb-1"><i class="fa-solid fa-check text-success me-2"></i> Colorfast & Pre-shrunk Materials</li>
                                                        <li class="mb-1"><i class="fa-solid fa-check text-success me-2"></i> Designed for daily and formal wear</li>
                                                        <li class="mb-1"><i class="fa-solid fa-check text-success me-2"></i> Country of Origin: India / Imported</li>
                                                    </ul>
                                                    <div class="d-flex gap-3 mb-2">
                                                        <span class="badge bg-secondary px-3 py-2"><i class="fa-solid fa-shirt me-1"></i> Regular Fit</span>
                                                        <span class="badge bg-secondary px-3 py-2"><i class="fa-solid fa-water me-1"></i> Machine Wash</span>
                                                    </div>
                                                    <div class="text-muted small mt-2">MACHINE WASHING MAX 30°C / 85°F SHORT SPIN DRY. DO NOT BLEACH.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. CUSTOMER REVIEWS TAB -->
                                <div class="tab-pane fade" id="tab-customer-reviews" role="tabpanel">
                                    <div class="tab-reviews">
                                        <div class="row gx-4 mb-4 pb-4 border-bottom">
                                            <div class="col-md-4 text-center border-end mb-3 mb-md-0">
                                                <div class="display-3 fw-bold text-dark"><?= number_format($product['rating'], 1); ?></div>
                                                <div class="list-star text-warning fs-5 mb-1">
                                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                                        <i class="fa-solid fa-star"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <p class="text-secondary small mb-0">(<?= number_format($product['reviews_count'] ?: 128); ?> verified customer reviews)</p>
                                            </div>
                                            <div class="col-md-5 mb-3 mb-md-0">
                                                <div class="d-flex align-items-center gap-2 mb-1 small">
                                                    <span style="width: 15px;">5★</span>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-success" style="width: 82%;"></div>
                                                    </div>
                                                    <span class="text-muted" style="width: 35px;">82%</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 mb-1 small">
                                                    <span style="width: 15px;">4★</span>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-info" style="width: 12%;"></div>
                                                    </div>
                                                    <span class="text-muted" style="width: 35px;">12%</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 mb-1 small">
                                                    <span style="width: 15px;">3★</span>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-warning" style="width: 4%;"></div>
                                                    </div>
                                                    <span class="text-muted" style="width: 35px;">4%</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 mb-1 small">
                                                    <span style="width: 15px;">2★</span>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-secondary" style="width: 1%;"></div>
                                                    </div>
                                                    <span class="text-muted" style="width: 35px;">1%</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 small">
                                                    <span style="width: 15px;">1★</span>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-danger" style="width: 1%;"></div>
                                                    </div>
                                                    <span class="text-muted" style="width: 35px;">1%</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                                                <button type="button" class="btn btn-outline-dark fw-bold px-4 py-2" data-bs-toggle="collapse" data-bs-target="#writeReviewCollapse">
                                                    <i class="fa-solid fa-pen-to-square me-1"></i> Write a review
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Review Form (Collapsed) -->
                                        <div class="collapse mb-4" id="writeReviewCollapse">
                                            <div class="card card-body bg-light border p-4">
                                                <h5 class="fw-bold mb-3">Write Your Review</h5>
                                                <form action="<?= site_url('product/review'); ?>" method="POST">
                                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                                    <input type="hidden" name="product_slug" value="<?= $product['slug']; ?>">

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold">Your Name *</label>
                                                            <input type="text" name="name" class="form-control" required value="<?= $this->session->userdata('user_name') ?? ''; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold">Your Email *</label>
                                                            <input type="email" name="email" class="form-control" required value="<?= $this->session->userdata('user_email') ?? ''; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Rating *</label>
                                                        <select name="rating" class="form-select" style="max-width: 200px;" required>
                                                            <option value="5" selected>5 Stars - Excellent</option>
                                                            <option value="4">4 Stars - Very Good</option>
                                                            <option value="3">3 Stars - Average</option>
                                                            <option value="2">2 Stars - Below Average</option>
                                                            <option value="1">1 Star - Poor</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Review *</label>
                                                        <textarea name="review" class="form-control" rows="4" placeholder="Share what you liked or disliked about this product..." required minlength="5"></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary fw-bold px-4">Submit Review</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Existing Reviews List -->
                                        <div class="review-items-list">
                                            <?php if (!empty($product['reviews'])): ?>
                                                <?php foreach ($product['reviews'] as $rev): ?>
                                                    <div class="border-bottom pb-3 mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <div class="fw-bold text-dark"><?= html_escape($rev['customer_name']); ?></div>
                                                            <div class="text-warning small">
                                                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                                                    <i class="<?= ($s <= $rev['rating']) ? 'fa-solid' : 'fa-regular'; ?> fa-star"></i>
                                                                <?php endfor; ?>
                                                            </div>
                                                        </div>
                                                        <div class="text-secondary small mb-2"><?= date('M d, Y', strtotime($rev['created_at'])); ?> • Verified Buyer</div>
                                                        <p class="mb-0 text-dark"><?= nl2br(html_escape($rev['review'])); ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="text-center py-4 text-secondary">
                                                    <i class="fa-regular fa-comment-dots fs-3 mb-2 d-block text-muted"></i>
                                                    <p class="mb-0">No reviews yet. Be the first to review this product!</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. SHIPPING & RETURNS TAB -->
                                <div class="tab-pane fade" id="tab-shipping" role="tabpanel">
                                    <div class="tab-shipping">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-uppercase mb-2"><i class="fa-solid fa-truck-fast text-primary me-2"></i> Shipping Information</h6>
                                                <p class="text-secondary small mb-2">We offer fast and reliable shipping across all major pin codes. Orders are processed within 24 business hours.</p>
                                                <ul class="list-unstyled text-secondary small">
                                                    <li>• Standard Delivery: 3 to 6 business days.</li>
                                                    <li>• Express Delivery: 1 to 3 business days available at checkout.</li>
                                                    <li>• Free standard delivery on orders above <?= $currency_symbol; ?>500.</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-uppercase mb-2"><i class="fa-solid fa-rotate-left text-primary me-2"></i> Hassle-Free Returns</h6>
                                                <p class="text-secondary small mb-2">If you are not completely satisfied with your purchase, you can return or exchange the item within 30 days of delivery.</p>
                                                <ul class="list-unstyled text-secondary small">
                                                    <li>• Items must be unused, unwashed, and in original packaging with tags.</li>
                                                    <li>• Instant refund or replacement initiated once picked up.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. RETURN POLICIES TAB -->
                                <div class="tab-pane fade" id="tab-policies" role="tabpanel">
                                    <div class="tab-policies">
                                        <h6 class="fw-bold text-uppercase mb-2">30-Day Guarantee</h6>
                                        <p class="text-secondary small mb-3">At Modave, our priority is your complete satisfaction. If for any reason your product does not meet expectations, our customer care team is ready to help with instant exchange or full refund.</p>
                                        <div class="row g-3 text-secondary small">
                                            <div class="col-md-4">
                                                <div class="p-3 border rounded bg-light text-center">
                                                    <i class="fa-solid fa-box-open fs-4 text-primary mb-2"></i>
                                                    <div class="fw-bold text-dark">1. Pack Item</div>
                                                    <div>Keep all tags and original packaging intact.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 border rounded bg-light text-center">
                                                    <i class="fa-solid fa-truck-ramp-box fs-4 text-primary mb-2"></i>
                                                    <div class="fw-bold text-dark">2. Free Pickup</div>
                                                    <div>Our courier partner picks up from your doorstep.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 border rounded bg-light text-center">
                                                    <i class="fa-solid fa-money-bill-transfer fs-4 text-primary mb-2"></i>
                                                    <div class="fw-bold text-dark">3. Fast Refund</div>
                                                    <div>Refund processed to original payment method.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /PRODUCT TABS -->

        <!-- FREQUENTLY BOUGHT TOGETHER -->
        <?php if (!empty($frequently_bought_together)): ?>
            <section class="py-5 border-top">
                <div class="container">
                    <h4 class="fw-bold mb-4">Frequently Bought Together</h4>
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <!-- Main Item -->
                                <div class="card border rounded p-2 text-center" style="width: 140px;">
                                    <img src="<?= base_url('assets/images/' . $all_images[0]); ?>" class="card-img-top rounded mb-2" style="height: 120px; object-fit: cover;" alt="<?= html_escape($product['title']); ?>">
                                    <div class="small fw-bold text-truncate"><?= html_escape($product['title']); ?></div>
                                    <div class="small text-danger fw-bold"><?= $currency_symbol . number_format($current_price, 2); ?></div>
                                </div>

                                <?php foreach ($frequently_bought_together as $idx => $fbt): 
                                    $fbt_price = !empty($fbt['sale_price']) ? (float) $fbt['sale_price'] : (float) $fbt['price'];
                                ?>
                                    <div class="fs-4 text-muted fw-bold">+</div>
                                    <div class="card border rounded p-2 text-center" style="width: 140px;">
                                        <a href="<?= site_url('product/' . $fbt['slug']); ?>">
                                            <img src="<?= base_url('assets/images/' . $fbt['main_image']); ?>" class="card-img-top rounded mb-2" style="height: 120px; object-fit: cover;" alt="<?= html_escape($fbt['title']); ?>" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                        </a>
                                        <div class="small fw-bold text-truncate"><?= html_escape($fbt['title']); ?></div>
                                        <div class="small text-danger fw-bold"><?= $currency_symbol . number_format($fbt_price, 2); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-3">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" checked disabled id="fbt-main-check">
                                    <label class="form-check-label small" for="fbt-main-check">
                                        <strong>This item:</strong> <?= html_escape($product['title']); ?> (<?= $currency_symbol . number_format($current_price, 2); ?>)
                                    </label>
                                </div>
                                <?php 
                                $bundle_sum = $current_price;
                                foreach ($frequently_bought_together as $idx => $fbt): 
                                    $f_price = !empty($fbt['sale_price']) ? (float) $fbt['sale_price'] : (float) $fbt['price'];
                                    $bundle_sum += $f_price;
                                ?>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input fbt-checkbox" type="checkbox" checked id="fbt-item-<?= $fbt['id']; ?>" data-id="<?= $fbt['id']; ?>" data-price="<?= $f_price; ?>" onchange="updateBundleTotal()">
                                        <label class="form-check-label small" for="fbt-item-<?= $fbt['id']; ?>">
                                            <?= html_escape($fbt['title']); ?> (<?= $currency_symbol . number_format($f_price, 2); ?>)
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card p-4 border bg-light text-center">
                                <div class="text-secondary small mb-1">Total price for selected items:</div>
                                <div class="fs-2 fw-bold text-primary mb-3" id="bundle-total-price"><?= $currency_symbol . number_format($bundle_sum, 2); ?></div>
                                <button type="button" class="btn btn-primary fw-bold py-2 w-100" onclick="addBundleToCart()">
                                    <i class="fa-solid fa-cart-plus me-1"></i> Add Selected to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- RELATED PRODUCTS & RECENTLY VIEWED TABS -->
        <?php if (!empty($related_products) || !empty($recently_viewed_products)): ?>
            <section class="flat-spacing border-top">
                <div class="container flat-animate-tab">
                    <ul class="tab-product justify-content-sm-center nav nav-tabs border-0 mb-4" role="tablist">
                        <?php if (!empty($related_products)): ?>
                            <li class="nav-tab-item" role="presentation">
                                <a href="#relatedProductsTab" class="active fw-bold text-uppercase fs-5" data-bs-toggle="tab">Related Products</a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($recently_viewed_products)): ?>
                            <li class="nav-tab-item" role="presentation">
                                <a href="#recentlyViewedTab" class="<?= empty($related_products) ? 'active' : ''; ?> fw-bold text-uppercase fs-5" data-bs-toggle="tab">Recently Viewed</a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <div class="tab-content">
                        <?php if (!empty($related_products)): ?>
                            <div class="tab-pane active show" id="relatedProductsTab" role="tabpanel">
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                                    <?php foreach ($related_products as $rp): 
                                        $rp_price = !empty($rp['sale_price']) ? (float) $rp['sale_price'] : (float) $rp['price'];
                                    ?>
                                        <div class="col">
                                            <div class="card-product h-100 border rounded p-2">
                                                <div class="card-product-wrapper position-relative overflow-hidden rounded mb-2">
                                                    <a href="<?= site_url('product/' . $rp['slug']); ?>" class="product-img d-block" style="aspect-ratio: 3/4;">
                                                        <img src="<?= base_url('assets/images/' . $rp['main_image']); ?>" alt="<?= html_escape($rp['title']); ?>" class="w-100 h-100 object-fit-cover" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                    </a>
                                                    <div class="list-product-btn position-absolute top-0 end-0 m-2 d-flex flex-column gap-2">
                                                        <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action" onclick="toggleWishlist(<?= $rp['id']; ?>, this)">
                                                            <span class="icon icon-heart"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="<?= site_url('product/' . $rp['slug']); ?>" class="title link fw-semibold text-truncate d-block mb-1"><?= html_escape($rp['title']); ?></a>
                                                    <div class="price fw-bold text-primary"><?= $currency_symbol . number_format($rp_price, 2); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($recently_viewed_products)): ?>
                            <div class="tab-pane <?= empty($related_products) ? 'active show' : ''; ?>" id="recentlyViewedTab" role="tabpanel">
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                                    <?php foreach ($recently_viewed_products as $rvp): 
                                        $rvp_price = !empty($rvp['sale_price']) ? (float) $rvp['sale_price'] : (float) $rvp['price'];
                                    ?>
                                        <div class="col">
                                            <div class="card-product h-100 border rounded p-2">
                                                <div class="card-product-wrapper position-relative overflow-hidden rounded mb-2">
                                                    <a href="<?= site_url('product/' . $rvp['slug']); ?>" class="product-img d-block" style="aspect-ratio: 3/4;">
                                                        <img src="<?= base_url('assets/images/' . $rvp['main_image']); ?>" alt="<?= html_escape($rvp['title']); ?>" class="w-100 h-100 object-fit-cover" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                                    </a>
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="<?= site_url('product/' . $rvp['slug']); ?>" class="title link fw-semibold text-truncate d-block mb-1"><?= html_escape($rvp['title']); ?></a>
                                                    <div class="price fw-bold text-primary"><?= $currency_symbol . number_format($rvp_price, 2); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- ==========================================================================
             MODALS: Lightbox, Size Guide, Delivery & Return, Ask Question, Share
             ========================================================================== -->

        <!-- 1. FULL PHOTO GALLERY LIGHTBOX MODAL -->
        <div class="modal fade" id="product-gallery-lightbox" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0 text-white d-flex justify-content-between align-items-center px-4 pt-3">
                        <span class="text-secondary small" id="lightbox-counter">Image 1 of <?= $total_images; ?></span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="lightbox-main-img-wrap">
                            <button type="button" class="lightbox-arrow prev" onclick="lightboxNav(-1)" aria-label="Previous">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <img id="lightbox-active-img" src="<?= base_url('assets/images/' . $all_images[0]); ?>" alt="Full Gallery Image">
                            <button type="button" class="lightbox-arrow next" onclick="lightboxNav(1)" aria-label="Next">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                        <div class="lightbox-thumbs-strip" id="lightbox-thumbs-strip">
                            <?php foreach ($all_images as $l_idx => $l_img): ?>
                                <div class="lightbox-thumb-item <?= ($l_idx === 0) ? 'active' : ''; ?>" onclick="lightboxGoTo(<?= $l_idx; ?>)" id="lb-thumb-<?= $l_idx; ?>">
                                    <img src="<?= base_url('assets/images/' . $l_img); ?>" alt="Thumb <?= $l_idx + 1; ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. SIZE GUIDE MODAL (from product-detail.html) -->
        <div class="modal fade modal-size-guide" id="size-guide" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content p-4 border-0 shadow">
                    <div class="modal-header border-0 pb-2">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-ruler-combined me-2 text-primary"></i> Size Guide & Recommendation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Interactive Height / Weight Calculator -->
                        <div class="card p-3 bg-light border-0 mb-4 rounded-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label small fw-bold mb-0">Your Height:</label>
                                        <span class="fw-bold text-primary" id="calc-height-val">175 cm</span>
                                    </div>
                                    <input type="range" class="form-range" id="calc-height-range" min="140" max="210" value="175" oninput="updateSizeCalc()">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label small fw-bold mb-0">Your Weight:</label>
                                        <span class="fw-bold text-primary" id="calc-weight-val">70 kg</span>
                                    </div>
                                    <input type="range" class="form-range" id="calc-weight-range" min="40" max="130" value="70" oninput="updateSizeCalc()">
                                </div>
                            </div>
                            <div class="alert alert-primary mb-0 mt-3 py-2 px-3 small d-flex align-items-center justify-content-between">
                                <span>Based on your measurements, your best fit is:</span>
                                <strong class="fs-5 text-primary" id="calc-recommended-size">L</strong>
                            </div>
                        </div>

                        <!-- Standard Size Measurements Table -->
                        <h6 class="fw-bold text-uppercase small text-secondary mb-2">Size Chart (Inches)</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle small mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Size</th>
                                        <th>Chest</th>
                                        <th>Waist</th>
                                        <th>Length</th>
                                        <th>Shoulder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td class="fw-bold">S</td><td>36 - 38</td><td>30 - 32</td><td>27.5</td><td>17.0</td></tr>
                                    <tr><td class="fw-bold">M</td><td>38 - 40</td><td>32 - 34</td><td>28.5</td><td>17.5</td></tr>
                                    <tr class="table-info"><td class="fw-bold">L</td><td>40 - 42</td><td>34 - 36</td><td>29.5</td><td>18.5</td></tr>
                                    <tr><td class="fw-bold">XL</td><td>42 - 44</td><td>36 - 38</td><td>30.5</td><td>19.5</td></tr>
                                    <tr><td class="fw-bold">XXL</td><td>44 - 46</td><td>38 - 40</td><td>31.5</td><td>20.5</td></tr>
                                    <tr><td class="fw-bold">3XL</td><td>46 - 48</td><td>40 - 42</td><td>32.0</td><td>21.5</td></tr>
                                    <tr><td class="fw-bold">4XL</td><td>48 - 50</td><td>42 - 44</td><td>32.5</td><td>22.5</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. DELIVERY & RETURN MODAL (from product-detail.html) -->
        <div class="modal fade" id="delivery_return" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4 border-0 shadow">
                    <div class="modal-header border-0 pb-2">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-truck-ramp-box me-2 text-primary"></i> Shipping & Delivery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark">Delivery Schedule</h6>
                            <p class="text-secondary small mb-1">Orders dispatched within 24 hours of placement.</p>
                            <p class="text-secondary small mb-0">Free standard shipping on all prepaid orders or orders above <?= $currency_symbol; ?>500.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark">Returns & Replacements</h6>
                            <p class="text-secondary small mb-0">Items in unworn condition with tags may be returned within 30 days for an instant exchange or 100% refund.</p>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark">Customer Support</h6>
                            <p class="text-secondary small mb-0">Need help? Reach out at <a href="mailto:support@modave.com" class="text-primary">support@modave.com</a> or call +1 800-123-4567.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. ASK A QUESTION MODAL (from product-detail.html) -->
        <div class="modal fade" id="ask_question" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4 border-0 shadow">
                    <div class="modal-header border-0 pb-2">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-circle-question me-2 text-primary"></i> Have a Question?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="event.preventDefault(); alert('Thank you! Your query has been submitted.'); bootstrap.Modal.getInstance(document.getElementById('ask_question')).hide();">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Name *</label>
                                <input type="text" class="form-control" required value="<?= $this->session->userdata('user_name') ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Email *</label>
                                <input type="email" class="form-control" required value="<?= $this->session->userdata('user_email') ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Your Question *</label>
                                <textarea class="form-control" rows="3" required placeholder="Ask anything about sizing, fabric or delivery..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Send Question</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. SHARE MODAL (from product-detail.html) -->
        <div class="modal fade" id="share_social" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4 border-0 shadow">
                    <div class="modal-header border-0 pb-2">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-share-nodes me-2 text-primary"></i> Share This Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()); ?>" target="_blank" class="btn btn-outline-primary rounded-circle" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()); ?>" target="_blank" class="btn btn-outline-dark rounded-circle" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="https://api.whatsapp.com/send?text=<?= urlencode($product['title'] . ' ' . current_url()); ?>" target="_blank" class="btn btn-outline-success rounded-circle" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="https://pinterest.com/pin/create/button/?url=<?= urlencode(current_url()); ?>" target="_blank" class="btn btn-outline-danger rounded-circle" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-pinterest-p"></i></a>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" id="share-link-input" value="<?= current_url(); ?>" readonly>
                            <button class="btn btn-dark fw-bold" type="button" onclick="navigator.clipboard.writeText(document.getElementById('share-link-input').value); alert('Product link copied to clipboard!');">Copy Link</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- ==========================================================================
     JAVASCRIPT: State Management, Lightbox, Variants, Cart & Sticky Bar
     ========================================================================== -->
<script>
(function() {
    'use strict';

    // Global variables passed from PHP
    var productId        = <?= (int) $product['id']; ?>;
    var currencySymbol   = "<?= $currency_symbol; ?>";
    var galleryImages    = <?= json_encode(array_map(function($img) { return base_url('assets/images/' . $img); }, $all_images)); ?>;
    var totalGallery     = galleryImages.length;
    var colorMap         = <?= json_encode($color_map); ?>;
    var hasVariants      = <?= $has_variants ? 'true' : 'false'; ?>;
    var hasColor         = <?= $has_color ? 'true' : 'false'; ?>;
    var hasSize          = <?= $has_size ? 'true' : 'false'; ?>;

    // Active state
    var selectedColor    = "<?= addslashes($initial_color); ?>";
    var selectedSize     = "<?= addslashes($initial_size); ?>";
    var selectedVariantId = <?= (int) $initial_variant_id; ?>;
    var currentPrice     = <?= (float) $current_price; ?>;
    var regularPrice     = <?= (float) $regular_price; ?>;
    var activeLightboxIdx = 0;

    // 1. LIGHTBOX CONTROLLER
    window.openLightbox = function(index) {
        if (index < 0) index = 0;
        if (index >= totalGallery) index = totalGallery - 1;
        activeLightboxIdx = index;
        updateLightboxView();
        var lbModal = new bootstrap.Modal(document.getElementById('product-gallery-lightbox'));
        lbModal.show();
    };

    window.lightboxNav = function(delta) {
        activeLightboxIdx = (activeLightboxIdx + delta + totalGallery) % totalGallery;
        updateLightboxView();
    };

    window.lightboxGoTo = function(idx) {
        activeLightboxIdx = idx;
        updateLightboxView();
    };

    function updateLightboxView() {
        var imgEl = document.getElementById('lightbox-active-img');
        var counterEl = document.getElementById('lightbox-counter');
        if (imgEl && galleryImages[activeLightboxIdx]) {
            imgEl.src = galleryImages[activeLightboxIdx];
        }
        if (counterEl) {
            counterEl.textContent = 'Image ' + (activeLightboxIdx + 1) + ' of ' + totalGallery;
        }
        // Update thumbs
        for (var i = 0; i < totalGallery; i++) {
            var th = document.getElementById('lb-thumb-' + i);
            if (th) {
                if (i === activeLightboxIdx) {
                    th.classList.add('active');
                    th.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                } else {
                    th.classList.remove('active');
                }
            }
        }
    }

    // Keyboard support for Lightbox
    document.addEventListener('keydown', function(e) {
        var lbEl = document.getElementById('product-gallery-lightbox');
        if (lbEl && lbEl.classList.contains('show')) {
            if (e.key === 'ArrowLeft') lightboxNav(-1);
            if (e.key === 'ArrowRight') lightboxNav(1);
        }
    });

    // 2. COLOR SLIDER HORIZONTAL SCROLL
    window.slideColorTrack = function(direction) {
        var track = document.getElementById('color-slider-track');
        if (track) {
            track.scrollBy({ left: direction * 140, behavior: 'smooth' });
        }
    };

    // 3. COLOR SELECTION
    window.selectColor = function(colorName, cardEl) {
        selectedColor = colorName;

        // Update label
        var label = document.getElementById('selected-color-name');
        if (label) label.textContent = colorName;

        // Update active class on cards
        var cards = document.querySelectorAll('.color-thumb-card');
        cards.forEach(function(c) { c.classList.remove('active'); });
        if (cardEl) cardEl.classList.add('active');

        // Swap primary image in 2x2 grid to this color image if available
        if (colorMap[colorName] && colorMap[colorName].image) {
            var newImgSrc = "<?= base_url('assets/images/'); ?>" + colorMap[colorName].image;
            var gridImg0 = document.getElementById('grid-img-0');
            if (gridImg0) {
                gridImg0.src = newImgSrc;
            }
            var stickyImg = document.getElementById('sticky-bar-img');
            if (stickyImg) {
                stickyImg.src = newImgSrc;
            }
            // Also update lightbox 0 image
            galleryImages[0] = newImgSrc;
        }

        // Re-evaluate size chips for this color
        updateSizeAvailability();

        // Update variant details
        syncCurrentVariant();
    };

    // 4. SIZE SELECTION
    window.selectSize = function(sizeName, chipEl) {
        // If out of stock, warn user or prompt
        if (chipEl && chipEl.classList.contains('is-out-of-stock')) {
            alert('Size ' + sizeName + ' is currently out of stock for color ' + selectedColor + '. You can select another size or color.');
            return;
        }

        selectedSize = sizeName;

        var label = document.getElementById('selected-size-name');
        if (label) label.textContent = sizeName;

        var chips = document.querySelectorAll('.variant-size-chip');
        chips.forEach(function(ch) { ch.classList.remove('active'); });
        if (chipEl) chipEl.classList.add('active');

        // Sync sticky dropdown
        var stickySelect = document.getElementById('sticky-size-dropdown');
        if (stickySelect) {
            stickySelect.value = sizeName;
        }

        syncCurrentVariant();
    };

    window.onStickySizeChange = function(val) {
        var chips = document.querySelectorAll('.variant-size-chip');
        chips.forEach(function(ch) {
            if (ch.getAttribute('data-size') === val) {
                ch.click();
            }
        });
    };

    // 5. UPDATE SIZE AVAILABILITY BASED ON SELECTED COLOR
    function updateSizeAvailability() {
        if (!hasSize) return;

        var chips = document.querySelectorAll('.variant-size-chip');
        var colorSizes = (colorMap[selectedColor] && colorMap[selectedColor].sizes) ? colorMap[selectedColor].sizes : {};

        var firstInStockSize = '';

        chips.forEach(function(ch) {
            var s = ch.getAttribute('data-size');
            var sizeData = colorSizes[s];
            var inStock = sizeData ? (sizeData.stock > 0) : true;

            if (!inStock) {
                ch.classList.add('is-out-of-stock');
                ch.title = 'Out of stock';
            } else {
                ch.classList.remove('is-out-of-stock');
                ch.title = 'Size ' + s;
                if (!firstInStockSize) firstInStockSize = s;
            }
        });

        // If currently selected size is out of stock for new color, auto-switch to first in-stock size
        var currentSizeData = colorSizes[selectedSize];
        if (currentSizeData && currentSizeData.stock <= 0 && firstInStockSize) {
            chips.forEach(function(ch) {
                if (ch.getAttribute('data-size') === firstInStockSize) {
                    selectSize(firstInStockSize, ch);
                }
            });
        }
    }

    // 6. SYNC VARIANT DETAILS (Price, SKU, Stock Status, Sticky Bar)
    function syncCurrentVariant() {
        var variantData = null;
        if (hasVariants && colorMap[selectedColor] && colorMap[selectedColor].sizes && colorMap[selectedColor].sizes[selectedSize]) {
            variantData = colorMap[selectedColor].sizes[selectedSize];
        }

        if (variantData) {
            selectedVariantId = variantData.variant_id;
            var price = variantData.sale_price ? variantData.sale_price : variantData.price;
            currentPrice = price;

            // Price display
            var salePriceEl = document.getElementById('display-sale-price');
            if (salePriceEl) salePriceEl.textContent = currencySymbol + price.toFixed(2);

            var atcPriceEl = document.getElementById('atc-btn-price');
            if (atcPriceEl) atcPriceEl.textContent = currencySymbol + price.toFixed(2);

            var stickyPriceEl = document.getElementById('sticky-price-display');
            if (stickyPriceEl) stickyPriceEl.textContent = currencySymbol + price.toFixed(2);

            // SKU
            var skuEl = document.getElementById('display-sku');
            if (skuEl) skuEl.textContent = variantData.sku;

            // Stock status
            var stockEl = document.getElementById('display-stock-status');
            var atcBtn = document.getElementById('main-btn-atc');
            if (stockEl) {
                if (variantData.stock > 0) {
                    stockEl.textContent = 'In Stock (' + variantData.stock + ' available)';
                    stockEl.className = 'text-caption-1 mb-0 fw-bold text-success';
                    if (atcBtn) atcBtn.disabled = false;
                } else {
                    stockEl.textContent = 'Out of Stock';
                    stockEl.className = 'text-caption-1 mb-0 fw-bold text-danger';
                    if (atcBtn) atcBtn.disabled = true;
                }
            }
        }

        // Update sticky bar summary text
        var stickySummary = document.getElementById('sticky-variant-label');
        if (stickySummary) {
            var parts = [];
            if (hasColor && selectedColor) parts.push(selectedColor);
            if (hasSize && selectedSize) parts.push(selectedSize);
            stickySummary.textContent = parts.join(', ');
        }
    }

    // 7. QUANTITY CONTROLLER
    window.changeQty = function(delta) {
        var input = document.getElementById('product-qty-input');
        var stickyInput = document.getElementById('sticky-qty-input');
        if (input) {
            var val = parseInt(input.value) || 1;
            val = Math.max(1, Math.min(99, val + delta));
            input.value = val;
            if (stickyInput) stickyInput.value = val;

            // Update ATC button dynamic price
            var atcPriceEl = document.getElementById('atc-btn-price');
            if (atcPriceEl) {
                atcPriceEl.textContent = currencySymbol + (currentPrice * val).toFixed(2);
            }
        }
    };

    // 8. AJAX ADD TO CART
    window.addToCartAjax = function() {
        var qty = parseInt(document.getElementById('product-qty-input').value) || 1;
        var btn = document.getElementById('main-btn-atc');
        var originalHtml = btn ? btn.innerHTML : '';

        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Adding...';
        }

        var payload = new URLSearchParams();
        payload.append('product_id', productId);
        payload.append('quantity', qty);
        if (selectedVariantId) {
            payload.append('variant_id', selectedVariantId);
        }

        fetch('<?= site_url("cart/add"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: payload.toString()
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }

            if (data.status === 'success' || data.success) {
                // Update cart count badges
                var countBadges = document.querySelectorAll('.count-box, #header-cart-count');
                countBadges.forEach(function(b) {
                    if (data.cart_count !== undefined) b.textContent = data.cart_count;
                });

                // Show feedback alert / toast
                alert(data.message || 'Product successfully added to cart!');
            } else {
                alert(data.message || 'Could not add product to cart.');
            }
        })
        .catch(function() {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
            alert('Product added to cart!');
            window.location.reload();
        });
    };

    // 9. BUY IT NOW DIRECT CHECKOUT
    window.buyNow = function() {
        var qty = parseInt(document.getElementById('product-qty-input').value) || 1;
        var payload = new URLSearchParams();
        payload.append('product_id', productId);
        payload.append('quantity', qty);
        if (selectedVariantId) {
            payload.append('variant_id', selectedVariantId);
        }

        fetch('<?= site_url("cart/add"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: payload.toString()
        })
        .then(function() {
            window.location.href = '<?= site_url("checkout"); ?>';
        })
        .catch(function() {
            window.location.href = '<?= site_url("checkout"); ?>';
        });
    };

    // 10. WISHLIST TOGGLE AJAX
    window.toggleWishlist = function(pId, btnEl) {
        fetch('<?= site_url("wishlist/toggle"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'product_id=' + pId
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success' || data.success) {
                if (btnEl) {
                    btnEl.classList.toggle('active');
                    var icon = btnEl.querySelector('i');
                    if (icon) {
                        if (icon.classList.contains('fa-regular')) {
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid');
                        } else {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                        }
                    }
                }
            } else if (data.redirect) {
                window.location.href = data.redirect;
            }
        })
        .catch(function() {
            if (btnEl) btnEl.classList.toggle('active');
        });
    };

    // 11. BUNDLE TOTAL CALCULATOR
    window.updateBundleTotal = function() {
        var total = currentPrice;
        var checkboxes = document.querySelectorAll('.fbt-checkbox:checked');
        checkboxes.forEach(function(cb) {
            total += parseFloat(cb.getAttribute('data-price')) || 0;
        });
        var display = document.getElementById('bundle-total-price');
        if (display) {
            display.textContent = currencySymbol + total.toFixed(2);
        }
    };

    window.addBundleToCart = function() {
        var ids = [productId];
        var checkboxes = document.querySelectorAll('.fbt-checkbox:checked');
        checkboxes.forEach(function(cb) {
            ids.push(cb.getAttribute('data-id'));
        });

        // Add sequentially
        var promises = ids.map(function(id) {
            var p = new URLSearchParams();
            p.append('product_id', id);
            p.append('quantity', 1);
            return fetch('<?= site_url("cart/add"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: p.toString()
            });
        });

        Promise.all(promises).then(function() {
            window.location.href = '<?= site_url("cart"); ?>';
        });
    };

    // 12. SIZE CALCULATOR RANGE INPUTS (Modal)
    window.updateSizeCalc = function() {
        var h = parseInt(document.getElementById('calc-height-range').value);
        var w = parseInt(document.getElementById('calc-weight-range').value);
        document.getElementById('calc-height-val').textContent = h + ' cm';
        document.getElementById('calc-weight-val').textContent = w + ' kg';

        // Estimation logic
        var size = 'L';
        var bmi = w / ((h / 100) * (h / 100));
        if (bmi < 20) {
            size = (h < 165) ? 'S' : 'M';
        } else if (bmi < 24) {
            size = (h < 175) ? 'M' : 'L';
        } else if (bmi < 28) {
            size = (h < 180) ? 'XL' : 'XXL';
        } else {
            size = '3XL';
        }
        document.getElementById('calc-recommended-size').textContent = size;
    };

    window.activateReviewTab = function() {
        var btn = document.getElementById('tab-reviews-btn');
        if (btn) {
            btn.click();
            btn.scrollIntoView({ behavior: 'smooth' });
        }
    };

    // 13. STICKY ATC BAR ON SCROLL
    window.addEventListener('scroll', function() {
        var stickyBar = document.getElementById('sticky-atc-bar');
        var mainBtn = document.getElementById('main-btn-atc');
        if (!stickyBar || !mainBtn) return;

        var rect = mainBtn.getBoundingClientRect();
        if (rect.bottom < 0) {
            stickyBar.classList.add('show');
        } else {
            stickyBar.classList.remove('show');
        }
    });

    // Initial setup
    updateSizeAvailability();
    syncCurrentVariant();

})();
</script>
