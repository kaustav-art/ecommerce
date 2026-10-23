<?php
$bazaro = isset($tpl_assets) ? rtrim($tpl_assets, '/') . '/' : base_url('assets/templates/bazaro/');
$curr   = isset($currency_symbol) ? $currency_symbol : '$';

if (!function_exists('grc_product_img')) {
    function grc_product_img($img, $bazaro_url, $fallback_idx = 1) {
        if (!empty($img)) {
            if (strpos($img, 'http') === 0) return $img;
            if (strpos($img, 'assets/') === 0) return base_url($img);
            $clean = ltrim($img, '/');
            if (file_exists(FCPATH . 'assets/images/' . $clean)) {
                return base_url('assets/images/' . $clean);
            }
            if (file_exists(FCPATH . 'assets/templates/bazaro/img/' . $clean)) {
                return base_url('assets/templates/bazaro/img/' . $clean);
            }
            return base_url('assets/images/products/' . $clean);
        }
        $idx = (($fallback_idx - 1) % 16) + 1;
        return $bazaro_url . 'img/product/grocery-p-' . $idx . '.jpg';
    }
}
?>

   <main>

      <!-- grc hero area start -->
      <div class="grc-hero-ptb">
         <div class="swiper grc-hero-slider-active p-relative">
            <div class="swiper-wrapper">
               <?php
               $hero_bgs = ['#E1EEB7', '#E5F0E7', '#F4E3C5'];
               if (!empty($banners)):
                  foreach ($banners as $b_idx => $banner):
                     $bg_col = $hero_bgs[$b_idx % count($hero_bgs)];
                     $b_img  = !empty($banner['image'])
                        ? (strpos($banner['image'], 'http') === 0 ? $banner['image'] : (strpos($banner['image'], 'assets/') === 0 ? base_url($banner['image']) : base_url('assets/images/banners/' . ltrim($banner['image'], '/'))))
                        : $bazaro . 'img/grocery/grocery-hero-thumb-' . (($b_idx % 3) + 1) . '.png';
                     $b_link = !empty($banner['button_link']) ? (strpos($banner['button_link'], 'http') === 0 ? $banner['button_link'] : site_url($banner['button_link'])) : site_url('shop');
               ?>
               <div class="swiper-slide" data-bg-color="<?= $bg_col; ?>" style="background-color:<?= $bg_col; ?>;">
                  <div class="grc-hero-slider-item p-relative">
                     <div class="grc-hero-shapes">
                        <div class="shape-1"><img src="<?= $bazaro; ?>img/grocery/grocery-hero-shape-1.png" alt=""></div>
                        <div class="shape-2"><img src="<?= $bazaro; ?>img/grocery/grocery-hero-shape-2.png" alt=""></div>
                        <div class="shape-3"><img src="<?= $bazaro; ?>img/grocery/grocery-hero-shape-3.png" alt=""></div>
                     </div>
                     <div class="container container-1630">
                        <div class="row align-items-end">
                           <div class="col-lg-6">
                              <div class="grc-hero-content pt-120 pb-120">
                                 <span class="grc-hero-subtitle"><?= html_escape($banner['subtitle'] ?? '100% Farm Fresh & Organic'); ?></span>
                                 <h4 class="grc-hero-title"><?= html_escape($banner['title'] ?? 'Healthy Living Starts With Fresh Food'); ?></h4>
                                 <div class="grc-hero-text">
                                    <p>Save up to 30% on Farm-Direct Organic Produce &amp; Daily Essentials</p>
                                 </div>
                                 <div class="grc-hero-btn">
                                    <a class="aq-btn-white btn-green-bg radius-30" href="<?= $b_link; ?>">
                                       <?= html_escape(!empty($banner['button_text']) ? $banner['button_text'] : 'Shop Now'); ?>
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                             <path d="M0.75 5.75H10.75M10.75 5.75L5.75 0.75M10.75 5.75L5.75 10.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </span>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="grc-hero-thumb-wrap pt-10 text-center">
                                 <img src="<?= $b_img; ?>" alt="<?= html_escape($banner['title'] ?? 'Fresh Grocery'); ?>" onerror="this.src='<?= $bazaro; ?>img/grocery/grocery-hero-thumb-2.png'">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php
                  endforeach;
               else:
                  $default_grc_slides = [
                     ['bg' => '#E1EEB7', 'sub' => '100% Organic Harvest', 'title' => 'Fresh Organic Produce Delivered Daily', 'img' => $bazaro . 'img/grocery/grocery-hero-thumb-1.png'],
                     ['bg' => '#E5F0E7', 'sub' => 'All Natural', 'title' => 'Healthy Living Starts With Food', 'img' => $bazaro . 'img/grocery/grocery-hero-thumb-2.png'],
                     ['bg' => '#F4E3C5', 'sub' => 'Artisan Bakery & Dairy', 'title' => 'Clean Organic Everyday Essentials', 'img' => $bazaro . 'img/grocery/grocery-hero-thumb-3.png'],
                  ];
                  foreach ($default_grc_slides as $ds):
               ?>
               <div class="swiper-slide" data-bg-color="<?= $ds['bg']; ?>" style="background-color:<?= $ds['bg']; ?>;">
                  <div class="grc-hero-slider-item p-relative">
                     <div class="container container-1630">
                        <div class="row align-items-end">
                           <div class="col-lg-6">
                              <div class="grc-hero-content pt-120 pb-120">
                                 <span class="grc-hero-subtitle"><?= html_escape($ds['sub']); ?></span>
                                 <h4 class="grc-hero-title"><?= html_escape($ds['title']); ?></h4>
                                 <div class="grc-hero-text">
                                    <p>Save up to 30% This Offer Only This Week</p>
                                 </div>
                                 <div class="grc-hero-btn">
                                    <a class="aq-btn-white btn-green-bg radius-30" href="<?= site_url('shop'); ?>">
                                       shop now
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                             <path d="M0.75 5.75H10.75M10.75 5.75L5.75 0.75M10.75 5.75L5.75 10.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </span>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="grc-hero-thumb-wrap pt-10">
                                 <img src="<?= $ds['img']; ?>" alt="">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php
                  endforeach;
               endif;
               ?>
            </div>
            <div class="elt-slider-arrow grc-slider-arrow">
               <button class="aqf-slider-prev">
                  <span>
                     <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none">
                        <path d="M5.75 10.75L0.75 5.75L5.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </span>
               </button>
               <button class="aqf-slider-next">
                  <span>
                     <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none">
                        <path d="M0.75 10.75L5.75 5.75L0.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </span>
               </button>
            </div>
         </div>
      </div>
      <!-- grc hero area end -->

      <!-- feature area start -->
      <div class="aqf-shop-feature-ptb grc-feature-style bdr-radius pt-40 pb-50">
         <div class="container container-1630">
            <div class="aqf-shop-feature-wrap d-flex flex-wrap justify-content-between align-items-center" data-bg-color="#FAFAFA" style="background-color:#FAFAFA;">
               <div class="aqf-shop-feature-item d-flex align-items-center mb-30">
                  <div class="aqf-shop-feature-icon">
                     <span><i class="fa-solid fa-truck-fast fs-3 text-success"></i></span>
                  </div>
                  <div class="aqf-shop-feature-content">
                     <h4>Free Same-Day Delivery</h4>
                     <p>Free delivery on grocery orders over <?= html_escape($curr); ?>50</p>
                  </div>
               </div>
               <div class="aqf-shop-feature-item d-flex align-items-center mb-30">
                  <div class="aqf-shop-feature-icon">
                     <span><i class="fa-solid fa-leaf fs-3 text-success"></i></span>
                  </div>
                  <div class="aqf-shop-feature-content">
                     <h4>100% Freshness Guarantee</h4>
                     <p>Farm-to-table organic quality assured</p>
                  </div>
               </div>
               <div class="aqf-shop-feature-item d-flex align-items-center mb-30">
                  <div class="aqf-shop-feature-icon">
                     <span><i class="fa-solid fa-credit-card fs-3 text-success"></i></span>
                  </div>
                  <div class="aqf-shop-feature-content">
                     <h4>Flexible Payment</h4>
                     <p>Pay with Cards, Wallets &amp; Cash on Delivery</p>
                  </div>
               </div>
               <div class="aqf-shop-feature-item d-flex align-items-center mb-30">
                  <div class="aqf-shop-feature-icon">
                     <span><i class="fa-solid fa-headset fs-3 text-success"></i></span>
                  </div>
                  <div class="aqf-shop-feature-content">
                     <h4>Support Online</h4>
                     <p>24 hours a day, 7 days a week</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- feature area end -->

      <!-- banner area start -->
      <div class="grc-banner-ptb grc-banner-style pb-50">
         <div class="container container-1630">
            <div class="row">
               <div class="col-lg-4 col-md-6">
                  <div class="aqf-banner-2-box p-relative mb-30">
                     <div class="aqf-banner-2-thumb">
                        <img class="w-100" src="<?= $bazaro; ?>img/grocery/grocery-banner-1.jpg" alt="Hyper Bar">
                     </div>
                     <div class="aqf-banner-2-content">
                        <span class="aq-section-subtitle aq-uppercase mb-15">18G Protein</span>
                        <h4 class="aq-section-title ff-satoshi-bold fs-40 mb-20">Hyper Bar</h4>
                        <a class="aq-btn-white btn-h-36 radius-30" href="<?= site_url('shop'); ?>">
                           shop now
                           <span>
                              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="10" viewBox="0 0 13 10" fill="none">
                                 <path d="M0.599609 4.59998H10.5996M7.59961 0.599976L11.5996 4.59998L7.59961 8.59998" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="aqf-banner-2-box p-relative mb-30">
                     <div class="aqf-banner-2-thumb">
                        <img class="w-100" src="<?= $bazaro; ?>img/grocery/grocery-banner-2.jpg" alt="Pretzel Twists">
                     </div>
                     <div class="aqf-banner-2-content">
                        <span class="aq-section-subtitle aq-uppercase aq-text-white mb-15">Grain Free</span>
                        <h4 class="aq-section-title ff-satoshi-bold aq-text-white fs-40 mb-20">Pretzel Twists</h4>
                        <a class="aq-btn-white btn-h-36 radius-30" href="<?= site_url('shop'); ?>">
                           shop now
                           <span>
                              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="10" viewBox="0 0 13 10" fill="none">
                                 <path d="M0.599609 4.59998H10.5996M7.59961 0.599976L11.5996 4.59998L7.59961 8.59998" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="aqf-banner-2-box p-relative mb-30">
                     <div class="aqf-banner-2-thumb">
                        <img class="w-100" src="<?= $bazaro; ?>img/grocery/grocery-banner-3.jpg" alt="Chobani Oat">
                     </div>
                     <div class="aqf-banner-2-content">
                        <span class="aq-section-subtitle aq-uppercase mb-15">Organic Oats</span>
                        <h4 class="aq-section-title ff-satoshi-bold fs-40 mb-20">Chobani Oat</h4>
                        <a class="aq-btn-white btn-h-36 radius-30" href="<?= site_url('shop'); ?>">
                           shop now
                           <span>
                              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="10" viewBox="0 0 13 10" fill="none">
                                 <path d="M0.599609 4.59998H10.5996M7.59961 0.599976L11.5996 4.59998L7.59961 8.59998" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- banner area end -->

      <!-- Popular Products Tabbed Department Grid start -->
      <?php
      $all_prods = !empty($products) ? $products : [];
      $tab_cats  = !empty($categories) ? array_slice($categories, 0, 4) : (!empty($nav_categories) ? array_slice($nav_categories, 0, 4) : []);
      ?>
      <div class="grc-product-ptb pb-50">
         <div class="container container-1630">
            <div class="grc-product-top pb-20">
               <div class="row align-items-center">
                  <div class="col-xl-5 col-lg-4">
                     <div class="grc-product-heading mb-20">
                        <h4 class="aq-section-title ff-satoshi-bold fs-30 mb-0">Popular Products</h4>
                     </div>
                  </div>
                  <div class="col-xl-7 col-lg-8">
                     <div class="grc-product-tab-btn text-lg-end">
                        <div class="aq-product-tab-btn">
                           <ul class="nav nav-tab d-inline-flex flex-wrap" id="grcDeptTab" role="tablist">
                              <li class="nav-item" role="presentation">
                                 <button class="nav-links active" id="grc-tab-all" data-bs-toggle="tab" data-bs-target="#grc-pane-all" type="button" role="tab" aria-selected="true">All</button>
                              </li>
                              <?php foreach ($tab_cats as $tc_idx => $tcat): ?>
                              <li class="nav-item" role="presentation">
                                 <button class="nav-links" id="grc-tab-<?= (int)$tcat['id']; ?>" data-bs-toggle="tab" data-bs-target="#grc-pane-<?= (int)$tcat['id']; ?>" type="button" role="tab" aria-selected="false">
                                    <?= html_escape($tcat['name']); ?>
                                 </button>
                              </li>
                              <?php endforeach; ?>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="tab-content grc-product-style" id="grcDeptTabContent">
               <!-- Tab Pane: All -->
               <div class="tab-pane fade show active" id="grc-pane-all" role="tabpanel">
                  <div class="row">
                     <?php foreach (array_slice($all_prods, 0, 12) as $p_idx => $p):
                        $p_img  = grc_product_img($p['primary_image'] ?? ($p['image'] ?? ''), $bazaro, $p_idx + 1);
                        $p_reg  = (float)($p['regular_price'] ?? $p['price'] ?? 0);
                        $p_sal  = (!empty($p['sale_price']) && (float)$p['sale_price'] > 0 && (float)$p['sale_price'] < $p_reg) ? (float)$p['sale_price'] : $p_reg;
                        $p_pct  = ($p_sal < $p_reg && $p_reg > 0) ? round((($p_reg - $p_sal) / $p_reg) * 100) : 0;
                        $p_url  = site_url('product/' . $p['slug']);
                        $p_unit = !empty($p['unit_label']) ? $p['unit_label'] : '1 Pack';
                     ?>
                     <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6">
                        <div class="aq-product-item aq-product-main mb-40">
                           <div class="aq-product-thumb p-relative mb-10">
                              <?php if ($p_pct > 0): ?>
                              <div class="aq-product-badge">
                                 <span class="clr-sale">-<?= $p_pct; ?>%</span>
                              </div>
                              <?php endif; ?>
                              <a href="<?= $p_url; ?>">
                                 <img class="aq-product-img-hover" src="<?= $p_img; ?>" alt="<?= html_escape($p['name']); ?>" onerror="this.src='<?= $bazaro; ?>img/product/grocery-p-<?= (($p_idx % 12) + 1); ?>.jpg'">
                              </a>
                              <div class="aq-product-action-2 d-flex flex-column">
                                 <button type="button" onclick="grcToggleWishlist(<?= (int)$p['id']; ?>)" class="aq-product-action-btn-2 aq-wishlist-btn aq-tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16" viewBox="0 0 19 16" fill="none">
                                       <path d="M5.83058 3.81134C4.89058 4.07825 4.22269 4.82839 4.13922 5.71098M9.34149 14.6355C11.2568 13.5878 13.0385 12.3546 14.6549 10.9581C15.7913 9.95244 16.6564 8.72639 17.184 7.37389C18.1334 4.75023 17.0244 1.74665 13.9209 0.857757C12.2899 0.391012 10.5085 1.54015 9.13406 2.45698C7.7591 1.54127 5.97836 0.392222 4.3472 0.857757C1.24372 1.74665 0.126783 4.75023 1.07618 7.37389C1.60376 8.72639 2.46886 9.95244 3.60523 10.9581C5.22159 12.3546 7.00335 13.5878 8.91865 14.6355L9.12608 14.7502L9.34149 14.6355Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="aq-tooltip-item">Wishlist</span>
                                 </button>
                              </div>
                           </div>
                           <div class="aq-product-content">
                              <div class="d-flex align-items-center justify-content-between mb-1">
                                 <span class="aqf-product-3-category"><?= html_escape($p['category_name'] ?? 'Organic Food'); ?></span>
                                 <span class="grc-unit-pill"><?= html_escape($p_unit); ?></span>
                              </div>
                              <h4 class="aq-product-title"><a href="<?= $p_url; ?>"><?= html_escape($p['name']); ?></a></h4>
                              <div class="aq-product-ratting text-warning small mb-1">
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                              </div>
                              <div class="aq-product-price">
                                 <ins><span class="aq-product-new-price"><?= html_escape($curr) . number_format($p_sal, 2); ?></span></ins>
                                 <?php if ($p_sal < $p_reg): ?>
                                    <del><span class="aq-product-old-price"><?= html_escape($curr) . number_format($p_reg, 2); ?></span></del>
                                 <?php endif; ?>
                              </div>
                           </div>
                           <div class="grc-product-btn">
                              <button type="button" onclick="grcAddToCart(<?= (int)$p['id']; ?>, 1)" class="product-btn-green w-100">Add to bag</button>
                           </div>
                        </div>
                     </div>
                     <?php endforeach; ?>
                  </div>
               </div>

               <!-- Category-Filtered Tab Panes -->
               <?php foreach ($tab_cats as $tcat):
                  $cat_prods = array_values(array_filter($all_prods, function($item) use ($tcat) {
                     return (int)($item['category_id'] ?? 0) === (int)$tcat['id'];
                  }));
                  if (empty($cat_prods)) {
                     $cat_prods = array_slice($all_prods, 0, 6);
                  }
               ?>
               <div class="tab-pane fade" id="grc-pane-<?= (int)$tcat['id']; ?>" role="tabpanel">
                  <div class="row">
                     <?php foreach (array_slice($cat_prods, 0, 6) as $cp_idx => $cp):
                        $cp_img  = grc_product_img($cp['primary_image'] ?? ($cp['image'] ?? ''), $bazaro, $cp_idx + 1);
                        $cp_reg  = (float)($cp['regular_price'] ?? $cp['price'] ?? 0);
                        $cp_sal  = (!empty($cp['sale_price']) && (float)$cp['sale_price'] > 0 && (float)$cp['sale_price'] < $cp_reg) ? (float)$cp['sale_price'] : $cp_reg;
                        $cp_url  = site_url('product/' . $cp['slug']);
                        $cp_unit = !empty($cp['unit_label']) ? $cp['unit_label'] : '1 Pack';
                     ?>
                     <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6">
                        <div class="aq-product-item aq-product-main mb-40">
                           <div class="aq-product-thumb p-relative mb-10">
                              <a href="<?= $cp_url; ?>">
                                 <img class="aq-product-img-hover" src="<?= $cp_img; ?>" alt="<?= html_escape($cp['name']); ?>" onerror="this.src='<?= $bazaro; ?>img/product/grocery-p-<?= (($cp_idx % 12) + 1); ?>.jpg'">
                              </a>
                           </div>
                           <div class="aq-product-content">
                              <div class="d-flex align-items-center justify-content-between mb-1">
                                 <span class="aqf-product-3-category"><?= html_escape($cp['category_name'] ?? $tcat['name']); ?></span>
                                 <span class="grc-unit-pill"><?= html_escape($cp_unit); ?></span>
                              </div>
                              <h4 class="aq-product-title"><a href="<?= $cp_url; ?>"><?= html_escape($cp['name']); ?></a></h4>
                              <div class="aq-product-price">
                                 <ins><span class="aq-product-new-price"><?= html_escape($curr) . number_format($cp_sal, 2); ?></span></ins>
                              </div>
                           </div>
                           <div class="grc-product-btn">
                              <button type="button" onclick="grcAddToCart(<?= (int)$cp['id']; ?>, 1)" class="product-btn-green w-100">Add to bag</button>
                           </div>
                        </div>
                     </div>
                     <?php endforeach; ?>
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
      <!-- Popular Products Tabbed Department Grid end -->

      <!-- Deal of the Week area start -->
      <div class="aqf-deals-area grc-product-style pb-80">
         <div class="container container-1630">
            <div class="aqf-deals-wrap grc-deals-style" data-bg-color="#F5F5F0" style="background-color:#F5F5F0;">
               <div class="row gx-50">
                  <div class="col-lg-3">
                     <div class="grc-banner-style h-100">
                        <div class="aqf-banner-2-box p-relative h-100">
                           <div class="aqf-banner-2-thumb h-100">
                              <img class="w-100 h-100" src="<?= $bazaro; ?>img/grocery/grocery-banner-4.jpg" alt="Special Savings" style="object-fit:cover;">
                           </div>
                           <div class="aqf-banner-2-content">
                              <span class="aq-section-subtitle aq-uppercase aq-text-white mb-15">Special</span>
                              <h4 class="aq-section-title ff-satoshi-bold aq-text-white fs-40 mb-20">Savings!</h4>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-9">
                     <div class="grc-deals-wrapper mt-60 pe-lg-4">
                        <div class="aqf-deals-slider-top mb-20">
                           <div class="row align-items-center">
                              <div class="col-lg-4 col-md-6">
                                 <div class="grc-deals-heading mb-20">
                                    <h4 class="aq-section-title ff-satoshi-bold fs-30 mb-0">Deal of the Week</h4>
                                 </div>
                              </div>
                              <div class="col-lg-8 col-md-6">
                                 <div class="aq-product-3-top-right d-flex justify-content-md-end align-items-center flex-wrap">
                                    <div class="aqf-deals-countbox d-flex align-items-center justify-content-end">
                                       <div class="aq-countdown-text mr-20"><span>Ends in</span></div>
                                       <div id="grcCountdown" class="aq-countdown-style-2 d-inline-flex align-items-center">
                                          <div class="count-box"><span id="days">06</span><i>:</i></div>
                                          <div class="count-box"><span id="hours">14</span><i>:</i></div>
                                          <div class="count-box"><span id="minutes">38</span><i>:</i></div>
                                          <div class="count-box"><span id="seconds">22</span></div>
                                       </div>
                                    </div>
                                    <div class="aq-product-3-top-btn ms-3">
                                       <a class="aq-btn-link aq-btn-underline" href="<?= site_url('shop'); ?>">
                                          See all
                                          <span>
                                             <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                <path d="M0.75 5.75H10.75M10.75 5.75L5.75 0.75M10.75 5.75L5.75 10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>
                                          </span>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="aqf-deals-slider-main">
                           <div class="aqf-deals-slider-wrap mb-10">
                              <div class="swiper grc-deals-slider-active">
                                 <div class="swiper-wrapper">
                                    <?php
                                    $grc_deals = !empty($deal_products) ? $deal_products : array_slice($all_prods, 0, 8);
                                    foreach ($grc_deals as $d_idx => $dp):
                                       $d_img  = grc_product_img($dp['primary_image'] ?? ($dp['image'] ?? ''), $bazaro, $d_idx + 5);
                                       $d_reg  = (float)($dp['regular_price'] ?? $dp['price'] ?? 0);
                                       $d_sal  = (!empty($dp['sale_price']) && (float)$dp['sale_price'] > 0 && (float)$dp['sale_price'] < $d_reg) ? (float)$dp['sale_price'] : $d_reg;
                                       $d_pct  = ($d_sal < $d_reg && $d_reg > 0) ? round((($d_reg - $d_sal) / $d_reg) * 100) : 15;
                                       $d_url  = site_url('product/' . $dp['slug']);
                                       $d_unit = !empty($dp['unit_label']) ? $dp['unit_label'] : 'Fresh Pack';
                                    ?>
                                    <div class="swiper-slide">
                                       <div class="aq-product-item aq-product-main mb-40">
                                          <div class="aq-product-thumb p-relative mb-10">
                                             <div class="aq-product-badge">
                                                <span class="clr-sale">-<?= $d_pct; ?>%</span>
                                             </div>
                                             <a href="<?= $d_url; ?>">
                                                <img class="aq-product-img-hover" src="<?= $d_img; ?>" alt="<?= html_escape($dp['name']); ?>" onerror="this.src='<?= $bazaro; ?>img/product/grocery-p-<?= (($d_idx % 12) + 1); ?>.jpg'">
                                             </a>
                                             <div class="aq-product-action-2 d-flex flex-column">
                                                <button type="button" onclick="grcToggleWishlist(<?= (int)$dp['id']; ?>)" class="aq-product-action-btn-2 aq-wishlist-btn aq-tooltip">
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16" viewBox="0 0 19 16" fill="none">
                                                      <path d="M5.83058 3.81134C4.89058 4.07825 4.22269 4.82839 4.13922 5.71098M9.34149 14.6355C11.2568 13.5878 13.0385 12.3546 14.6549 10.9581C15.7913 9.95244 16.6564 8.72639 17.184 7.37389C18.1334 4.75023 17.0244 1.74665 13.9209 0.857757C12.2899 0.391012 10.5085 1.54015 9.13406 2.45698C7.7591 1.54127 5.97836 0.392222 4.3472 0.857757C1.24372 1.74665 0.126783 4.75023 1.07618 7.37389C1.60376 8.72639 2.46886 9.95244 3.60523 10.9581C5.22159 12.3546 7.00335 13.5878 8.91865 14.6355L9.12608 14.7502L9.34149 14.6355Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                   </svg>
                                                   <span class="aq-tooltip-item">Wishlist</span>
                                                </button>
                                             </div>
                                          </div>
                                          <div class="aq-product-content">
                                             <div class="d-flex align-items-center justify-content-between mb-1">
                                                <span class="aqf-product-3-category"><?= html_escape($dp['category_name'] ?? 'Organic'); ?></span>
                                                <span class="grc-unit-pill"><?= html_escape($d_unit); ?></span>
                                             </div>
                                             <h4 class="aq-product-title"><a href="<?= $d_url; ?>"><?= html_escape($dp['name']); ?></a></h4>
                                             <div class="aq-product-ratting text-warning small mb-1">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                             </div>
                                             <div class="aq-product-price">
                                                <ins><span class="aq-product-new-price"><?= html_escape($curr) . number_format($d_sal, 2); ?></span></ins>
                                                <?php if ($d_sal < $d_reg): ?>
                                                   <del><span class="aq-product-old-price"><?= html_escape($curr) . number_format($d_reg, 2); ?></span></del>
                                                <?php endif; ?>
                                             </div>
                                          </div>
                                          <div class="grc-product-btn">
                                             <button type="button" onclick="grcAddToCart(<?= (int)$dp['id']; ?>, 1)" class="product-btn-green w-100">Add to bag</button>
                                          </div>
                                       </div>
                                    </div>
                                    <?php endforeach; ?>
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
      <!-- Deal of the Week area end -->

      <!-- Fresh Arrivals Carousel start -->
      <div class="grc-product-ptb pb-50">
         <div class="container container-1630">
            <div class="grc-product-top pb-20">
               <div class="row align-items-center">
                  <div class="col-sm-6">
                     <div class="grc-product-heading mb-20">
                        <h4 class="aq-section-title ff-satoshi-bold fs-30 mb-0">Farm-Fresh Daily Picks</h4>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="grc-product-btn text-sm-end">
                        <a class="aq-btn-link aq-btn-underline" href="<?= site_url('shop'); ?>">
                           See all
                           <span>
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                 <path d="M0.75 5.75H10.75M10.75 5.75L5.75 0.75M10.75 5.75L5.75 10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="grc-product-style">
               <div class="row">
                  <div class="grc-product-slider-wrap">
                     <div class="swiper grc-slider-active">
                        <div class="swiper-wrapper">
                           <?php
                           $carousel_prods = !empty($new_products) ? $new_products : $all_prods;
                           foreach ($carousel_prods as $c_idx => $cp):
                              $c_img  = grc_product_img($cp['primary_image'] ?? ($cp['image'] ?? ''), $bazaro, $c_idx + 1);
                              $c_reg  = (float)($cp['regular_price'] ?? $cp['price'] ?? 0);
                              $c_sal  = (!empty($cp['sale_price']) && (float)$cp['sale_price'] > 0 && (float)$cp['sale_price'] < $c_reg) ? (float)$cp['sale_price'] : $c_reg;
                              $c_url  = site_url('product/' . $cp['slug']);
                              $c_unit = !empty($cp['unit_label']) ? $cp['unit_label'] : '1 Pack';
                           ?>
                           <div class="swiper-slide">
                              <div class="aq-product-item aq-product-main mb-40">
                                 <div class="aq-product-thumb p-relative mb-10">
                                    <a href="<?= $c_url; ?>">
                                       <img class="aq-product-img-hover" src="<?= $c_img; ?>" alt="<?= html_escape($cp['name']); ?>" onerror="this.src='<?= $bazaro; ?>img/product/grocery-p-<?= (($c_idx % 12) + 1); ?>.jpg'">
                                    </a>
                                 </div>
                                 <div class="aq-product-content">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                       <span class="aqf-product-3-category"><?= html_escape($cp['category_name'] ?? 'Organic Food'); ?></span>
                                       <span class="grc-unit-pill"><?= html_escape($c_unit); ?></span>
                                    </div>
                                    <h4 class="aq-product-title"><a href="<?= $c_url; ?>"><?= html_escape($cp['name']); ?></a></h4>
                                    <div class="aq-product-price">
                                       <ins><span class="aq-product-new-price"><?= html_escape($curr) . number_format($c_sal, 2); ?></span></ins>
                                    </div>
                                 </div>
                                 <div class="grc-product-btn">
                                    <button type="button" onclick="grcAddToCart(<?= (int)$cp['id']; ?>, 1)" class="product-btn-green w-100">Add to bag</button>
                                 </div>
                              </div>
                           </div>
                           <?php endforeach; ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Fresh Arrivals Carousel end -->

      <!-- text slide area start -->
      <div class="aqf-text-slide-area grc-text-slider-style fix" data-bg-color="#003D29" style="background-color:#003D29;">
         <div class="aqf-text-slide-wrap pt-20 pb-20">
            <?php for ($m = 0; $m < 4; $m++): ?>
            <div class="aqf-text-slide-item">
               <p>100% Certified Organic Harvest — Farm Direct</p>
               <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                     <path d="M8.88889 0L0 10.8H8L7.11111 18L16 7.2H8L8.88889 0Z" fill="white"/>
                  </svg>
               </span>
            </div>
            <div class="aqf-text-slide-item">
               <p>Free Same-Day Grocery Delivery on Orders Over <?= html_escape($curr); ?>50.00</p>
               <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                     <path d="M8.88889 0L0 10.8H8L7.11111 18L16 7.2H8L8.88889 0Z" fill="white"/>
                  </svg>
               </span>
            </div>
            <?php endfor; ?>
         </div>
      </div>
      <!-- text slide area end -->

      <!-- brand area start -->
      <div class="aq-brand-ptb py-5">
         <div class="grc-brand-wrapper">
            <div class="swiper grc-brand-active">
               <div class="swiper-wrapper">
                  <?php for ($b = 1; $b <= 6; $b++): ?>
                  <div class="swiper-slide">
                     <div class="aq-brand-item text-center">
                        <img src="<?= $bazaro; ?>img/grocery/grocery-brand-<?= $b; ?>.png" alt="Brand <?= $b; ?>">
                     </div>
                  </div>
                  <?php endfor; ?>
               </div>
            </div>
         </div>
      </div>
      <!-- brand area end -->

   </main>
