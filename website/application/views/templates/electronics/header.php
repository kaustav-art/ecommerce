<?php
$bazaro     = isset($tpl_assets) ? rtrim($tpl_assets, '/') . '/' : base_url('assets/templates/bazaro/');
$curr       = isset($currency_symbol) ? $currency_symbol : '$';
$cart_total = isset($cart_summary['subtotal']) ? (float)$cart_summary['subtotal'] : 0.00;
$cart_cnt   = isset($cart_count) ? (int)$cart_count : 0;
$wish_cnt   = isset($wishlist_count) ? (int)$wishlist_count : 0;

if (!function_exists('elt_resolve_img')) {
    function elt_resolve_img($img, $fallback_rel = 'img/electronics/arrival-product/product-1/product-1.jpg') {
        $bazaro_base = base_url('assets/templates/bazaro/');
        if (empty($img)) {
            return $bazaro_base . $fallback_rel;
        }
        if (strpos($img, 'http://') === 0 || strpos($img, 'https://') === 0) {
            return $img;
        }
        $clean = ltrim($img, '/');
        if (strpos($clean, 'assets/') === 0) {
            return base_url($clean);
        }
        if (file_exists(FCPATH . 'assets/images/products/' . $clean)) {
            return base_url('assets/images/products/' . $clean);
        }
        if (file_exists(FCPATH . 'assets/images/' . $clean)) {
            return base_url('assets/images/' . $clean);
        }
        if (file_exists(FCPATH . 'assets/templates/bazaro/img/' . $clean)) {
            return $bazaro_base . 'img/' . $clean;
        }
        return base_url('assets/images/products/' . $clean);
    }
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title><?= isset($page_title) ? html_escape($page_title) : html_escape($site_name ?? 'TechZone Electronics'); ?></title>
   <meta name="description" content="<?= html_escape($meta_description ?? ($store_settings['meta_description'] ?? 'Premium Electronics Store')); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <?php if (!empty($store_settings['site_favicon'])): ?>
   <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/images/logo/' . $store_settings['site_favicon']); ?>">
   <?php else: ?>
   <link rel="shortcut icon" type="image/x-icon" href="<?= $bazaro; ?>img/logo/favicon.png">
   <?php endif; ?>

   <!-- CSS here (Exact Bazaro Electronics stack) -->
   <link rel="stylesheet" href="<?= $bazaro; ?>css/bootstrap.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/animate.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/nice-select.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/custom-animation.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/swiper-bundle.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/magnific-popup.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/font-awesome-pro.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/spacing.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/main.css">

   <?php if (($active_page ?? 'home') !== 'home'): ?>
   <!-- Inner-page storefront styles for shared cart/checkout/account/product views -->
   <link rel="stylesheet" type="text/css" href="<?= base_url('assets/fonts/font-icons.css'); ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css'); ?>">
   <?php endif; ?>

   <style>
      /* Prevent preloader from blocking view */
      #loading { display: none !important; }
      .elt-toast-notify {
         position: fixed; bottom: 28px; right: 28px; z-index: 99999;
         background: #111827; color: #fff; padding: 13px 20px; border-radius: 10px;
         font-size: 14px; font-weight: 600; box-shadow: 0 10px 25px rgba(0,0,0,0.22);
         display: none; align-items: center; gap: 10px;
      }
      .elt-logo-text {
         font-size: 24px; font-weight: 800; color: #0B0D0E; text-decoration: none; letter-spacing: -0.5px;
      }
   </style>

   <script>
      window.BASE_URL = '<?= rtrim(site_url(), '/') . '/'; ?>';
      window.SITE_URL = '<?= rtrim(site_url(), '/'); ?>';
      window.ASSET_URL = '<?= rtrim(base_url(), '/') . '/'; ?>';
      window.CURRENCY_SYMBOL = '<?= addslashes($curr); ?>';
      window.IS_USER_LOGGED_IN = <?= !empty($is_logged_in) ? 'true' : 'false'; ?>;
   </script>
</head>

<body>

   <!-- back to top start -->
   <div class="progress-wrap">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
      </svg>
   </div>
   <!-- back to top end -->

   <!-- Toast Notification -->
   <div id="eltToast" class="elt-toast-notify">
      <i class="fa-solid fa-circle-check" style="color:#E1EEB7;"></i>
      <span id="eltToastText">Added to cart!</span>
   </div>

   <!-- Quick View Modal -->
   <div class="modal fade aq-product-modal" id="producQuickViewModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-body p-4 p-lg-5 position-relative">
               <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
               <div class="row align-items-center g-4">
                  <div class="col-md-6 text-center">
                     <img id="eltQvImage" src="<?= $bazaro; ?>img/electronics/arrival-product/product-1/product-1.jpg" alt="Product" class="img-fluid rounded-3" style="max-height:360px;object-fit:contain;">
                  </div>
                  <div class="col-md-6">
                     <span id="eltQvCat" class="badge bg-light text-dark mb-2">Electronics</span>
                     <h3 id="eltQvTitle" class="mb-2" style="font-size:22px;font-weight:700;">Product Title</h3>
                     <div class="mb-3">
                        <span id="eltQvPrice" style="font-size:24px;font-weight:700;color:#0B0D0E;"><?= $curr; ?>0.00</span>
                     </div>
                     <p id="eltQvDesc" class="text-muted mb-4" style="font-size:14px;line-height:1.6;"></p>
                     <div class="d-flex align-items-center gap-3 mb-3">
                        <input type="number" id="eltQvQty" value="1" min="1" class="form-control" style="width:85px;height:46px;text-align:center;font-weight:600;">
                        <button type="button" id="eltQvAddBtn" class="aq-btn-black radius-30 flex-grow-1" style="height:46px;border:none;">
                           Add To Cart
                        </button>
                     </div>
                     <div class="small text-muted">
                        SKU: <span id="eltQvSku" class="text-dark fw-semibold">N/A</span> &bull;
                        <a id="eltQvLink" href="#" class="text-decoration-underline text-dark fw-semibold">View Full Details</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- search area start -->
   <div class="aq-search-wrap aq-search-area">
      <div class="aq-search-close">
         <button class="aq-search-close-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
               <path d="M11 1L1 11M1 1L11 11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
         </button>
      </div>
      <div class="container container-1430">
         <div class="row">
            <div class="col-xl-12">
               <div class="aq-search-inner-wrap">
                  <div class="aq-search-input p-relative mb-60">
                     <form action="<?= site_url('search'); ?>" method="GET">
                        <input type="text" name="q" placeholder="Search for electronics, laptops, audio, accessories..." value="<?= html_escape($this->input->get('q') ?? ''); ?>">
                        <button class="aq-btn-search" type="submit">
                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                              <path d="M18.9999 19L14.6499 14.65M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                           </svg>
                        </button>
                     </form>
                  </div>
                  <?php if (!empty($nav_categories)): ?>
                  <div class="aq-search-Category d-flex align-items-center flex-wrap">
                     <span class="me-3 fw-semibold">Popular Categories:</span>
                     <?php $sc = 0; foreach ($nav_categories as $cat): if ($sc++ >= 6) break; ?>
                        <a href="<?= site_url('shop/' . $cat['slug']); ?>" class="me-3 text-decoration-underline"><?= html_escape($cat['name']); ?></a>
                     <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- search area end -->

   <!-- cartmini area start -->
   <div class="aq-cartmini-area aq-cartmini-active d-flex flex-column justify-content-between" id="eltCartMiniDrawer">
      <div class="aq-cartmini-top">
         <div class="aq-cartmini-header d-flex align-items-center justify-content-between">
            <h4 class="aq-cartmini-title">Shopping Cart</h4>
            <div class="aq-cartmini-close">
               <button class="aq-cartmini-close-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                     <path d="M11 1L1 11M1 1L11 11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </button>
            </div>
         </div>
         <div class="aq-cartmini-body">
            <div class="aq-cartmini-product-list" id="eltCartMiniBody">
               <?php if (!empty($cart_items)): ?>
                  <?php foreach ($cart_items as $c_key => $c_item):
                     $c_img = elt_resolve_img($c_item['image'] ?? ($c_item['main_image'] ?? ''));
                     $c_slug = !empty($c_item['slug']) ? site_url('product/' . $c_item['slug']) : site_url('product/' . ($c_item['product_id'] ?? ''));
                  ?>
                  <div class="aq-cartmini-product-item d-flex align-items-center justify-content-between">
                     <div class="aq-cartmini-product-info d-flex align-items-center">
                        <div class="aq-cartmini-product-img">
                           <a href="<?= $c_slug; ?>"><img src="<?= $c_img; ?>" alt="<?= html_escape($c_item['name'] ?? 'Product'); ?>"></a>
                        </div>
                        <div class="aq-cartmini-product-content">
                           <h4 class="aq-cartmini-product-title">
                              <a href="<?= $c_slug; ?>"><?= html_escape($c_item['name'] ?? 'Product'); ?></a>
                           </h4>
                           <span class="aq-cartmini-product-price"><?= (int)($c_item['quantity'] ?? 1); ?> &times; <?= $curr . number_format((float)($c_item['price'] ?? 0), 2); ?></span>
                        </div>
                     </div>
                     <div class="aq-cartmini-product-Action">
                        <button type="button" onclick="removeCartItemAjax('<?= html_escape($c_item['cart_key'] ?? $c_key); ?>')">
                           <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M9 1L1 9M1 1L9 9" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg>
                        </button>
                     </div>
                  </div>
                  <?php endforeach; ?>
               <?php else: ?>
                  <div class="text-center py-5">
                     <p class="mb-3 text-muted">Your Cart is empty</p>
                     <a class="aq-btn-black radius-30" href="<?= site_url('shop'); ?>">Go to Shop</a>
                  </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
      <div class="aq-cartmini-footer">
         <div class="aq-cartmini-total d-flex align-items-center justify-content-between mb-15">
            <h4>Subtotal</h4>
            <span id="eltCartMiniSubtotal"><?= $curr . number_format($cart_total, 2); ?></span>
         </div>
         <div class="aq-cartmini-btn d-flex justify-content-between">
            <a class="aq-btn-border" href="<?= site_url('cart'); ?>">View Cart</a>
            <a class="aq-btn-black" href="<?= site_url('checkout'); ?>">Checkout</a>
         </div>
      </div>
   </div>
   <!-- cartmini area end -->

   <!-- offcanvas area start -->
   <div class="aq-offcanvas-wrap">
      <div class="aq-offcanvas-top d-flex align-items-center justify-content-between mb-30">
         <div class="aq-offcanvas-logo">
            <a href="<?= site_url('home'); ?>">
               <?php if (!empty($store_settings['site_logo']) && file_exists(FCPATH . 'assets/images/logo/' . $store_settings['site_logo'])): ?>
                  <img data-width="120" src="<?= base_url('assets/images/logo/' . $store_settings['site_logo']); ?>" alt="<?= html_escape($site_name); ?>">
               <?php else: ?>
                  <img data-width="120" src="<?= $bazaro; ?>img/logo/logo.png" alt="<?= html_escape($site_name); ?>">
               <?php endif; ?>
            </a>
         </div>
         <div class="aq-offcanvas-close">
            <button class="aq-offcanvas-close-btn">
               <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                  <path d="M11 1L1 11M1 1L11 11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
            </button>
         </div>
      </div>
      <div class="aq-offcanvas-bar mb-30">
         <div class="aq-offcanvas-menu-wrap">
            <nav></nav>
         </div>
      </div>
      <div class="aq-offcanvas-bottom">
         <div class="aq-offcanvas-btn mb-30">
            <a class="aq-btn-black w-100 text-center" href="<?= !empty($is_logged_in) ? site_url('account') : site_url('auth/login'); ?>">
               <?= !empty($is_logged_in) ? 'My Account' : 'Login / Register'; ?>
            </a>
         </div>
         <div class="aq-offcanvas-info mb-30">
            <h4 class="aq-offcanvas-sm-title">Contact Us</h4>
            <span><a href="tel:<?= html_escape($store_settings['site_phone'] ?? '+18005550199'); ?>"><?= html_escape($store_settings['site_phone'] ?? '(+92) 413 90 762'); ?></a></span>
            <span><a href="mailto:<?= html_escape($store_settings['site_email'] ?? 'support@electronics.com'); ?>"><?= html_escape($store_settings['site_email'] ?? 'support@electronics.com'); ?></a></span>
         </div>
      </div>
   </div>
   <!-- offcanvas area end -->

   <!-- body overlay here -->
   <div class="body-overlay"></div>
   <!-- body overlay end -->

   <!-- bottom menu area start -->
   <div class="aq-bottom-menu d-md-none">
      <div class="aq-bottom-menu-wrap d-flex align-items-center justify-content-between">
         <div class="aq-bottom-menu-item">
            <a href="<?= site_url('home'); ?>">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                  <path d="M6.4 18V11.7H11.2V18M0.8 7.15L8.8 1L16.8 7.15V16.65C16.8 17.008 16.6314 17.3514 16.3314 17.6046C16.0313 17.8577 15.6243 18 15.2 18H2.4C1.97565 18 1.56869 17.8577 1.26863 17.6046C0.968571 17.3514 0.8 17.008 0.8 16.65V7.15Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
               <span>Home</span>
            </a>
         </div>
         <div class="aq-bottom-menu-item">
            <a href="<?= site_url('shop'); ?>">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M0.75 0.75H6.08333V6.08333H0.75V0.75ZM9.41667 0.75H14.75V6.08333H9.41667V0.75ZM9.41667 9.41667H14.75V14.75H9.41667V9.41667ZM0.75 9.41667H6.08333V14.75H0.75V9.41667Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
               <span>Shop</span>
            </a>
         </div>
         <div class="aq-bottom-menu-item">
            <button class="aq-search-toggle">
               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M18.7504 18.7499L14.4004 14.3999M16.75 8.75C16.75 13.1683 13.1683 16.75 8.75 16.75C4.33172 16.75 0.75 13.1683 0.75 8.75C0.75 4.33172 4.33172 0.75 8.75 0.75C13.1683 0.75 16.75 4.33172 16.75 8.75Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
               <span>Search</span>
            </button>
         </div>
         <div class="aq-bottom-menu-item">
            <a href="<?= site_url('wishlist'); ?>">
               <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                  <path d="M6.50726 4.80303C5.44195 5.14334 4.68503 6.09974 4.59044 7.22502M10.4856 18.6038C12.6562 17.2679 14.6755 15.6957 16.5073 13.9152C17.7951 12.633 18.7756 11.0698 19.3735 9.3454C20.4494 6.00032 19.1927 2.17084 15.6755 1.03753C13.827 0.442448 11.8081 0.782566 10.2505 1.95149C8.69225 0.783989 6.67412 0.443991 4.82552 1.03753C1.30833 2.17084 0.0425004 6.00032 1.11845 9.3454C1.71636 11.0698 2.69679 12.633 3.98465 13.9152C5.81647 15.6957 7.83575 17.2679 10.0064 18.6038L10.2414 18.75L10.4856 18.6038Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
               <span>Wishlist</span>
            </a>
         </div>
         <div class="aq-bottom-menu-item">
            <a href="<?= !empty($is_logged_in) ? site_url('account') : site_url('auth/login'); ?>">
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                  <path d="M16.212 18.75C16.212 15.267 12.747 12.45 8.481 12.45C4.215 12.45 0.75 15.267 0.75 18.75M12.9805 5.25C12.9805 7.73528 10.9657 9.75 8.48047 9.75C5.99519 9.75 3.98047 7.73528 3.98047 5.25C3.98047 2.76472 5.99519 0.75 8.48047 0.75C10.9657 0.75 12.9805 2.76472 12.9805 5.25Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
               <span>Account</span>
            </a>
         </div>
      </div>
   </div>
   <!-- bottom menu area end -->

   <header>

      <!-- header area start -->
      <div class="aq-header-area p-relative">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-4 d-xl-none">
                  <div class="aq-header-bar">
                     <button class="aq-offcanvas-toggle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M3 6H21" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                           <path d="M3 12H21" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                           <path d="M3 18H15" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                     </button>
                  </div>
               </div>
               <div class="col-xl-3 col-4">
                  <div class="aq-header-logo text-center text-xl-start">
                     <a href="<?= site_url('home'); ?>">
                        <?php if (!empty($store_settings['site_logo']) && file_exists(FCPATH . 'assets/images/logo/' . $store_settings['site_logo'])): ?>
                           <img data-width="120" src="<?= base_url('assets/images/logo/' . $store_settings['site_logo']); ?>" alt="<?= html_escape($site_name); ?>">
                        <?php else: ?>
                           <img data-width="120" src="<?= $bazaro; ?>img/logo/logo.png" alt="<?= html_escape($site_name); ?>">
                        <?php endif; ?>
                     </a>
                  </div>
               </div>
               <div class="col-xl-6 d-none d-xl-block">
                  <div class="aq-header-menu menu-height-62 aq-header-dropdown menu-black text-center">
                     <nav class="aq-mobile-menu-active">
                        <ul>
                           <li>
                              <a href="<?= site_url('home'); ?>">Home</a>
                           </li>
                           <li class="has-dropdown">
                              <a href="<?= site_url('shop'); ?>">Shop</a>
                              <?php if (!empty($nav_categories)): ?>
                              <ul class="aq-submenu submenu">
                                 <li><a href="<?= site_url('shop'); ?>">All Electronics</a></li>
                                 <?php foreach ($nav_categories as $cat): ?>
                                    <li><a href="<?= site_url('shop/' . $cat['slug']); ?>"><?= html_escape($cat['name']); ?></a></li>
                                 <?php endforeach; ?>
                              </ul>
                              <?php endif; ?>
                           </li>
                           <li class="has-dropdown">
                              <a href="<?= site_url('shop'); ?>">Categories</a>
                              <?php if (!empty($nav_categories)): ?>
                              <ul class="aq-submenu submenu">
                                 <?php foreach ($nav_categories as $cat): ?>
                                    <li><a href="<?= site_url('shop/' . $cat['slug']); ?>"><?= html_escape($cat['name']); ?></a></li>
                                 <?php endforeach; ?>
                              </ul>
                              <?php endif; ?>
                           </li>
                           <li>
                              <a href="<?= site_url('about'); ?>">About</a>
                           </li>
                           <li>
                              <a href="<?= site_url('contact'); ?>">Contact</a>
                           </li>
                        </ul>
                     </nav>
                  </div>
               </div>
               <div class="col-xl-3 col-4">
                  <div class="aq-header-right-options text-end">
                     <ul>
                        <li class="aq-header-top-search">
                           <button class="aq-search-toggle">
                              <i>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M18.7504 18.7499L14.4004 14.3999M16.75 8.75C16.75 13.1683 13.1683 16.75 8.75 16.75C4.33172 16.75 0.75 13.1683 0.75 8.75C0.75 4.33172 4.33172 0.75 8.75 0.75C13.1683 0.75 16.75 4.33172 16.75 8.75Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </i>
                           </button>
                        </li>
                        <li class="aq-header-top-account d-none d-md-inline-block">
                           <a href="<?= !empty($is_logged_in) ? site_url('account') : site_url('auth/login'); ?>">
                              <i>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                    <path d="M16.212 18.75C16.212 15.267 12.747 12.45 8.481 12.45C4.215 12.45 0.75 15.267 0.75 18.75M12.9805 5.25C12.9805 7.73528 10.9657 9.75 8.48047 9.75C5.99519 9.75 3.98047 7.73528 3.98047 5.25C3.98047 2.76472 5.99519 0.75 8.48047 0.75C10.9657 0.75 12.9805 2.76472 12.9805 5.25Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </i>
                           </a>
                        </li>
                        <li class="aq-header-top-wishlist d-none d-md-inline-block">
                           <a href="<?= site_url('wishlist'); ?>" class="aq-wishlist-btn">
                              <span class="count-box wishlist-count"><?= $wish_cnt; ?></span>
                              <i>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                                    <path d="M6.50726 4.80303C5.44195 5.14334 4.68503 6.09974 4.59044 7.22502M10.4856 18.6038C12.6562 17.2679 14.6755 15.6957 16.5073 13.9152C17.7951 12.633 18.7756 11.0698 19.3735 9.3454C20.4494 6.00032 19.1927 2.17084 15.6755 1.03753C13.827 0.442448 11.8081 0.782566 10.2505 1.95149C8.69225 0.783989 6.67412 0.443991 4.82552 1.03753C1.30833 2.17084 0.0425004 6.00032 1.11845 9.3454C1.71636 11.0698 2.69679 12.633 3.98465 13.9152C5.81647 15.6957 7.83575 17.2679 10.0064 18.6038L10.2414 18.75L10.4856 18.6038Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </i>
                           </a>
                        </li>
                        <li class="aq-header-top-cart aq-cart-btn">
                           <button type="button">
                              <span class="count-box cart-count"><?= $cart_cnt; ?></span>
                              <i>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                    <path d="M5.48681 5.07041C5.48681 2.68433 7.4211 0.750039 9.80717 0.750039C10.9562 0.74517 12.0598 1.1982 12.874 2.00895C13.6882 2.81971 14.1459 3.92139 14.1458 5.07041M6.84107 9.57384H6.88684M12.6721 9.57388H12.7179M5.62368 19.972H13.9715C17.0379 19.972 19.3903 18.8645 18.7221 14.4068L17.944 8.3656C17.5321 6.14134 16.1134 5.29008 14.8685 5.29008H4.69004C3.42688 5.29008 2.0905 6.20542 1.61453 8.3656L0.836493 14.4068C0.268988 18.361 2.55732 19.972 5.62368 19.972Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </i>
                           </button>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- header area end -->

   </header>
