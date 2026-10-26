<!doctype html>
<html class="no-js" lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title><?= isset($title) ? html_escape($title) : html_escape($site_name ?? 'Fresh Grocery Store'); ?></title>
   <meta name="description" content="<?= html_escape($site_name ?? 'Fresh Grocery Store'); ?> - Farm-Fresh Organic Groceries &amp; Daily Essentials">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <?php
   $bazaro = isset($tpl_assets) ? rtrim($tpl_assets, '/') . '/' : base_url('assets/templates/bazaro/');
   $curr   = isset($currency_symbol) ? $currency_symbol : '$';
   $is_home_page = (($active_page ?? 'home') === 'home');
   $raw_fav = trim((string)($store_settings['site_favicon'] ?? ''));
   if ($raw_fav !== '') {
       $web_favicon = (strpos($raw_fav, 'assets/') === 0) ? base_url($raw_fav) : base_url('assets/images/logo/' . $raw_fav);
   } else {
       $web_favicon = base_url('assets/images/logo/codeulas_logo_small.webp');
   }
   $raw_logo = trim((string)($store_settings['site_logo'] ?? ''));
   if ($raw_logo !== '') {
       $web_logo = (strpos($raw_logo, 'assets/') === 0) ? base_url($raw_logo) : base_url('assets/images/logo/' . $raw_logo);
   } else {
       $web_logo = base_url('assets/images/logo/logo.webp');
   }
   ?>
   <link rel="shortcut icon" href="<?= $web_favicon; ?>">
   <link rel="icon" href="<?= $web_favicon; ?>">

   <?php
   $is_grc_product_page = (($this->uri->segment(1) ?? '') === 'product');
   ?>
   <link rel="stylesheet" href="<?= base_url('assets/fonts/font-icons.css'); ?>">
   <link rel="stylesheet" href="<?= base_url('assets/fonts/fonts.css'); ?>">

   <!-- Bazaro Grocery Template CSS -->
   <link rel="stylesheet" href="<?= $bazaro; ?>css/bootstrap.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/animate.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/slick.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/nice-select.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/custom-animation.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/swiper-bundle.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/magnific-popup.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/font-awesome-pro.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/spacing.css">
   <link rel="stylesheet" href="<?= $bazaro; ?>css/main.css">

   <style>
      :root {
         --grc-primary: #003D29;
         --grc-accent: #108910;
         --grc-mint: #ecfdf5;
         --grc-mint-border: #bbf7d0;
         --grc-bg-soft: #f4f8f5;
         --bs-primary: #108910;
         --bs-primary-rgb: 16, 137, 16;
      }
      .grc-unit-pill {
         display: inline-block;
         background: #ecfdf5;
         color: #047857;
         border: 1px solid #a7f3d0;
         font-size: 11px;
         font-weight: 700;
         padding: 2px 8px;
         border-radius: 99px;
         margin-bottom: 5px;
      }
      .aq-product-thumb img.aq-product-img-hover {
         height: 210px;
         width: 100%;
         object-fit: cover;
         border-radius: 10px;
      }
      .grc-toast-msg {
         position: fixed;
         bottom: 24px;
         right: 24px;
         z-index: 99999;
         background: #003D29;
         color: #fff;
         padding: 12px 20px;
         border-radius: 10px;
         font-size: 14px;
         font-weight: 600;
         box-shadow: 0 10px 25px rgba(0,0,0,0.25);
         display: none;
         align-items: center;
         gap: 10px;
      }
      /* Ensure preloader never blocks interaction if JS is slow */
      #loading { display: none !important; }

      /* =====================================================================
       * Grocery Theme Overrides for Shared Inner Pages
       * (Account, Orders, Wishlist, Cart, Checkout, Track Order, Static Pages)
       * ===================================================================== */
      body {
         color: #1f2937;
      }
      section[style*="background: #f1f3f6"],
      section[style*="background:#f1f3f6"],
      .flat-spacing[style*="background: #f1f3f6"] {
         background: #f3f8f4 !important;
      }
      /* Primary colors -> Fresh Harvest Green / Deep Forest Green */
      .text-primary {
         color: #108910 !important;
      }
      .bg-primary {
         background-color: #003D29 !important;
      }
      .border-primary {
         border-color: #108910 !important;
      }
      .btn-primary {
         background-color: #108910 !important;
         border-color: #108910 !important;
         color: #ffffff !important;
         font-weight: 600;
         border-radius: 10px;
         transition: all 0.2s ease;
      }
      .btn-primary:hover,
      .btn-primary:focus {
         background-color: #003D29 !important;
         border-color: #003D29 !important;
         color: #ffffff !important;
      }
      .btn-outline-primary {
         color: #003D29 !important;
         border-color: #108910 !important;
         font-weight: 600;
         border-radius: 10px;
      }
      .btn-outline-primary:hover,
      .btn-outline-primary:focus {
         background-color: #108910 !important;
         border-color: #108910 !important;
         color: #ffffff !important;
      }
      /* Account Sidebar & Profile Cards */
      .fk-sidebar-wrap .card,
      section .card.border-0.shadow-sm {
         border: 1px solid #e2efe6 !important;
         border-radius: 14px !important;
         box-shadow: 0 6px 20px rgba(0, 61, 41, 0.04) !important;
      }
      .fk-menu-group-header {
         color: #003D29 !important;
      }
      .fk-menu-group-header i {
         color: #108910 !important;
      }
      .fk-sub-link:hover {
         color: #108910 !important;
         background-color: #f0fdf4 !important;
      }
      .fk-sub-link.active {
         color: #003D29 !important;
         background-color: #ecfdf5 !important;
         font-weight: 700 !important;
         border-left: 3px solid #108910;
      }
      .fk-Single-link:hover {
         color: #108910 !important;
         background-color: #f0fdf4 !important;
      }
      .fk-input-control:focus,
      .form-control:focus,
      .form-select:focus {
         border-color: #108910 !important;
         box-shadow: 0 0 0 3px rgba(16, 137, 16, 0.12) !important;
      }
      /* Reset Bazaro global input rules on checkboxes, radios, and range sliders */
      input[type="checkbox"],
      input[type="radio"],
      .form-check-input {
         width: 18px !important;
         height: 18px !important;
         min-width: 18px !important;
         min-height: 18px !important;
         padding: 0 !important;
         padding-inline-start: 0 !important;
         padding-inline-end: 0 !important;
         margin-top: 0 !important;
         line-height: 1 !important;
         flex-shrink: 0 !important;
         border: 1.5px solid #9ca3af !important;
         background-color: #ffffff !important;
         box-shadow: none !important;
         cursor: pointer;
         vertical-align: middle;
      }
      input[type="checkbox"],
      .form-check-input[type="checkbox"] {
         border-radius: 4px !important;
      }
      input[type="radio"],
      .form-check-input[type="radio"] {
         border-radius: 50% !important;
      }
      input[type="checkbox"]:checked,
      input[type="radio"]:checked,
      .form-check-input:checked {
         background-color: #108910 !important;
         border-color: #108910 !important;
         accent-color: #108910 !important;
      }
      input[type="checkbox"]:focus,
      input[type="radio"]:focus,
      .form-check-input:focus {
         border-color: #108910 !important;
         box-shadow: 0 0 0 3px rgba(16, 137, 16, 0.15) !important;
      }
      input[type="range"],
      .form-range {
         width: 100% !important;
         height: 6px !important;
         padding: 0 !important;
         padding-inline-start: 0 !important;
         padding-inline-end: 0 !important;
         border: none !important;
         box-shadow: none !important;
         accent-color: #108910 !important;
      }
      /* Cart & Checkout Grocery Theme Styling */
      .cart-address-card,
      .cart-items-card,
      .cart-summary-card,
      .fk-step-card {
         border: 1px solid #e2efe6 !important;
         border-radius: 14px !important;
         box-shadow: 0 6px 20px rgba(0, 61, 41, 0.04) !important;
      }
      .fk-step-header.active {
         background: #003D29 !important;
         color: #ffffff !important;
         border-radius: 14px 14px 0 0;
      }
      .fk-step-header.active .step-num {
         background: #108910 !important;
         color: #ffffff !important;
      }
      .step-num {
         color: #003D29 !important;
         background: #ecfdf5 !important;
      }
      .btn-deliver-here,
      .btn-proceed-buy,
      .tf-btn.btn-fill {
         background: #108910 !important;
         border-color: #108910 !important;
         color: #ffffff !important;
         border-radius: 10px !important;
         font-weight: 700 !important;
         box-shadow: 0 4px 14px rgba(16, 137, 16, 0.22) !important;
      }
      .btn-deliver-here:hover,
      .btn-proceed-buy:hover,
      .tf-btn.btn-fill:hover {
         background: #003D29 !important;
         border-color: #003D29 !important;
         color: #ffffff !important;
      }
      .btn-change-addr {
         color: #108910 !important;
         border-color: #bbf7d0 !important;
         background: #f0fdf4 !important;
         border-radius: 8px !important;
      }
      .btn-change-addr:hover {
         background: #108910 !important;
         color: #ffffff !important;
      }
      .address-type-badge {
         background: #ecfdf5 !important;
         color: #047857 !important;
         border: 1px solid #a7f3d0;
      }
      .fk-addr-item.selected,
      .fk-pay-item.selected {
         background: #f4fbf6 !important;
         border-color: #bbf7d0 !important;
      }
      .qty-circle-btn:hover:not(:disabled) {
         border-color: #108910 !important;
         color: #108910 !important;
      }
      .item-action-btn:hover {
         color: #108910 !important;
      }
      /* Inner page titles / breadcrumbs */
      .tf-page-title {
         background: linear-gradient(135deg, #003D29 0%, #07593e 100%) !important;
         padding: 36px 0 !important;
         color: #ffffff !important;
      }
      .tf-page-title .heading,
      .tf-page-title h1,
      .tf-page-title h2,
      .tf-page-title h3,
      .tf-page-title .breadcrumbs,
      .tf-page-title .breadcrumbs a,
      .tf-page-title .breadcrumbs li,
      .tf-page-title .text-secondary {
         color: #ffffff !important;
      }
      .tf-page-title .breadcrumbs a:hover {
         color: #86efac !important;
      }
      /* Order status timeline & order cards */
      .fk-order-card:hover {
         border-color: #108910 !important;
         box-shadow: 0 6px 18px rgba(0, 61, 41, 0.08) !important;
      }
      .fk-item-title:hover {
         color: #108910 !important;
      }
      .fk-step-item.completed .fk-step-circle,
      .fk-step-item.active .fk-step-circle {
         background: #108910 !important;
         border-color: #108910 !important;
      }
      .fk-step-item.completed:not(:last-child)::after {
         background: #108910 !important;
      }
   </style>

   <script>
      window.IS_USER_LOGGED_IN = <?= !empty($is_logged_in) ? 'true' : 'false'; ?>;
      window.BASE_URL = '<?= base_url(); ?>';
      window.SITE_URL = '<?= site_url(); ?>';
      window.STORE_NAME = '<?= html_escape($site_name ?? 'Fresh Grocery Store'); ?>';
      window.CURRENCY_SYMBOL = '<?= html_escape($curr); ?>';
   </script>
</head>

<body>

   <!-- Toast Notification -->
   <div id="grcToast" class="grc-toast-msg">
      <i class="fa-solid fa-basket-shopping text-warning"></i>
      <span id="grcToastText">Added to grocery bag!</span>
   </div>

   <!-- back to top start -->
   <div class="progress-wrap">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
      </svg>
   </div>
   <!-- back to top end -->

   <!-- Cartmini area -->
   <div class="aq-cartmini-area aq-cartmini-active d-flex flex-column justify-content-between" id="grcCartMiniDrawer">
      <div class="aq-cartmini-header">
         <i class="aq-cartmini-close aq-cartmini-close-icon fa-regular fa-xmark" onclick="closeGrcCartDrawer()"></i>
         <h4 class="aq-cartmini-title">Grocery Bag (<span class="cart-count"><?= (int)($cart_count ?? 0); ?></span>)</h4>
         <div class="aq-cartmini-shiping">
            <div class="aq-cartmini-shiping-message">
               <p>Enjoy <b>Free Same-Day Delivery</b> on orders over <b><?= html_escape($curr); ?>50.00</b></p>
            </div>
            <?php $grc_ship_pct = min(100, round(((float)($cart_total ?? 0) / 50) * 100)); ?>
            <div class="aq-progress-bar">
               <div style="width: <?= $grc_ship_pct ?: 50; ?>%;"></div>
            </div>
         </div>
      </div>
      <div class="aq-cartmini-body" id="grcCartMiniBody">
         <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $c_key => $c_item):
               $c_name = $c_item['name'] ?? ($c_item['title'] ?? ($c_item['product_title'] ?? 'Fresh Grocery Item'));
               $raw_img = !empty($c_item['image']) ? ltrim($c_item['image'], '/') : '';
               if (empty($raw_img)) {
                  $c_img = $bazaro . 'img/product/grocery-p-1.jpg';
               } elseif (strpos($raw_img, 'http') === 0) {
                  $c_img = $raw_img;
               } elseif (strpos($raw_img, 'assets/') === 0) {
                  $c_img = base_url($raw_img);
               } elseif (strpos($raw_img, 'products/') === 0) {
                  $c_img = base_url('assets/images/' . $raw_img);
               } else {
                  $c_img = base_url('assets/images/products/' . $raw_img);
               }
            ?>
            <div class="aq-cartmini-product-item mb-15 item-delete d-flex align-items-center">
               <div class="aq-cartmini-product-thumbnail">
                  <a href="<?= site_url('product/' . ($c_item['slug'] ?? $c_item['product_id'])); ?>">
                     <img src="<?= $c_img; ?>" alt="<?= html_escape($c_name); ?>" onerror="this.src='<?= $bazaro; ?>img/product/grocery-p-1.jpg'">
                  </a>
               </div>
               <div class="aq-cartmini-product-summary">
                  <h4 class="aq-product-title"><a href="<?= site_url('product/' . ($c_item['slug'] ?? $c_item['product_id'])); ?>"><?= html_escape($c_name); ?></a></h4>
                  <span class="aq-cartmini-product-price"><?= html_escape($curr) . number_format((float)$c_item['price'], 2); ?> &times; <?= (int)$c_item['quantity']; ?></span>
                  <div class="aq-product-details-quantity d-flex align-items-center mt-1">
                     <button type="button" onclick="grcRemoveCartItem('<?= html_escape($c_key); ?>')" class="aq-line-anim aq-cartmini-remove">Remove</button>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
         <?php else: ?>
            <div class="cartmini-empty text-center py-5">
               <p class="text-muted">Your grocery bag is empty</p>
               <a href="<?= site_url('shop'); ?>" class="aq-btn-black border-btn mt-2">Browse Fresh Aisles</a>
            </div>
         <?php endif; ?>
      </div>
      <div class="aq-cartmini-footer">
         <div class="aq-cartmini-total d-flex justify-content-between align-items-center">
            <span class="aq-cartmini-total-title">Subtotal</span>
            <span class="aq-cartmini-total-value" id="grcCartMiniSubtotal"><?= html_escape($curr) . number_format((float)($cart_total ?? 0), 2); ?></span>
         </div>
         <div class="aq-cartmini-main-btn d-flex justify-content-between gap-2">
            <a href="<?= site_url('cart'); ?>" class="aq-btn-black btn-red-bg text-center w-100">View Bag</a>
            <a href="<?= site_url('checkout'); ?>" class="aq-btn-black text-center border-btn w-100">Checkout</a>
         </div>
      </div>
   </div>
   <!-- Cartmini area end -->

   <!-- offcanvas area start -->
   <div class="aq-offcanvas-wrap">
      <div class="aq-offcanvas-top d-flex align-items-center justify-content-between">
         <div class="aq-offcanvas-logo">
            <a href="<?= site_url('home'); ?>"><img width="115" src="<?= $web_logo; ?>" alt="<?= html_escape($site_name); ?>" style="max-height:40px;width:auto;object-fit:contain;" onerror="this.src='<?= base_url('assets/images/logo/logo.webp'); ?>'"></a>
         </div>
         <div class="aq-offcanvas-close">
            <span>
               <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                  <path d="M10.75 0.75L0.75 10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M0.75 0.75L10.75 10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
            </span>
         </div>
      </div>
      <div class="aq-offcanvas-menu-wrap">
         <div class="aq-offcanvas-menu">
            <nav>
               <ul class="list-unstyled">
                  <li class="py-2 border-bottom"><a href="<?= site_url('home'); ?>" class="fw-bold text-dark">Home</a></li>
                  <li class="py-2 border-bottom"><a href="<?= site_url('shop'); ?>" class="fw-bold text-dark">Shop All Groceries</a></li>
                  <?php if (!empty($nav_categories)): ?>
                     <?php foreach ($nav_categories as $cat): ?>
                        <li class="py-2 border-bottom ps-2"><a href="<?= site_url('shop/' . $cat['slug']); ?>" class="text-secondary">&bull; <?= html_escape($cat['name']); ?></a></li>
                     <?php endforeach; ?>
                  <?php endif; ?>
                  <li class="py-2 border-bottom"><a href="<?= site_url('order/track'); ?>" class="fw-bold text-dark">Track Order</a></li>
                  <li class="py-2 border-bottom"><a href="<?= site_url('contact'); ?>" class="fw-bold text-dark">Contact Us</a></li>
               </ul>
            </nav>
         </div>
      </div>
      <div class="aq-offcanvas-bottom">
         <div class="aq-offcanvas-btn-wrap d-flex justify-content-between align-items-center">
            <?php if (!empty($is_logged_in)): ?>
            <a class="aq-offcanvas-btn" href="<?= site_url('account'); ?>">My Account</a>
            <?php else: ?>
            <a class="aq-offcanvas-btn" href="#exampleModalToggle" data-bs-toggle="modal">Login</a>
            <?php endif; ?>
            <a class="aq-offcanvas-btn btn-black-bg" href="<?= site_url('wishlist'); ?>">Wishlist (<?= (int)($wishlist_count ?? 0); ?>)</a>
         </div>
      </div>
   </div>
   <div class="body-overlay" onclick="closeGrcCartDrawer()"></div>
   <!-- offcanvas area end -->

   <!-- bottom-sticky header -->
   <div class="aq-bottom-menu d-md-none">
      <div class="container">
         <div class="row row-cols-5">
            <div class="col">
               <a href="<?= site_url('home'); ?>">
                  <div class="aq-bottom-menu-item">
                     <i><i class="fa-solid fa-house"></i></i>
                     <span>Home</span>
                  </div>
               </a>
            </div>
            <div class="col">
               <?php if (!empty($is_logged_in)): ?>
               <a href="<?= site_url('account'); ?>">
                  <div class="aq-bottom-menu-item">
                     <i><i class="fa-regular fa-user"></i></i>
                     <span>Account</span>
                  </div>
               </a>
               <?php else: ?>
               <a href="#exampleModalToggle" data-bs-toggle="modal">
                  <div class="aq-bottom-menu-item">
                     <i><i class="fa-regular fa-user"></i></i>
                     <span>Sign In</span>
                  </div>
               </a>
               <?php endif; ?>
            </div>
            <div class="col">
               <a href="<?= site_url('shop'); ?>">
                  <div class="aq-bottom-menu-item">
                     <i><i class="fa-solid fa-store"></i></i>
                     <span>Aisles</span>
                  </div>
               </a>
            </div>
            <div class="col">
               <a href="<?= site_url('wishlist'); ?>">
                  <div class="aq-bottom-menu-item">
                     <button class="p-relative">
                        <span class="count-box wishlist-count"><?= (int)($wishlist_count ?? 0); ?></span>
                        <i><i class="fa-regular fa-heart"></i></i>
                     </button>
                     <span>Wishlist</span>
                  </div>
               </a>
            </div>
            <div class="col">
               <div class="aq-bottom-menu-item aq-cart-btn" onclick="openGrcCartDrawer()">
                  <button class="p-relative">
                     <span class="count-box cart-count"><?= (int)($cart_count ?? 0); ?></span>
                     <i><i class="fa-solid fa-basket-shopping"></i></i>
                  </button>
                  <span>Bag</span>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- bottom-sticky header -->

   <header>

      <!-- header area start -->
      <div class="grc-header-ptb pt-25 pb-20" data-bg-color="#003D29" style="background-color:#003D29;">
         <div class="container container-1630">
            <div class="grc-header-main-wrap">
               <div class="row align-items-center">
                  <div class="col-lg-2 col-md-3 col-6">
                     <div class="aq-header-logo">
                        <a href="<?= site_url('home'); ?>" class="text-decoration-none d-inline-flex align-items-center gap-2">
                           <img data-width="140" src="<?= $web_logo; ?>" alt="<?= html_escape($site_name); ?>" style="max-height:42px;width:auto;object-fit:contain;" onerror="this.src='<?= base_url('assets/images/logo/logo.webp'); ?>'">
                        </a>
                     </div>
                  </div>
                  <div class="col-lg-7 col-md-5 d-none d-md-block">
                     <div class="grc-header-search-wrap">
                        <form action="<?= site_url('shop'); ?>" method="GET">
                           <div class="grc-header-search p-relative">
                              <input type="text" name="q" value="<?= html_escape($this->input->get('q') ?? ''); ?>" placeholder="Search for fresh groceries (e.g. avocados, milk, sourdough, berries)...">
                              <span class="grc-header-search-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M16.7495 16.75L12.8828 12.8833M14.9722 7.86111C14.9722 11.7885 11.7885 14.9722 7.86111 14.9722C3.93375 14.9722 0.75 11.7885 0.75 7.86111C0.75 3.93375 3.93375 0.75 7.86111 0.75C11.7885 0.75 14.9722 3.93375 14.9722 7.86111Z" stroke="#144110" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </span>
                              <button type="submit" class="grc-header-search-btn">
                                 Search
                              </button>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-6">
                     <div class="aq-header-right-options grc-header-right-option text-end">
                        <ul>
                           <li class="aq-header-top-account d-none d-md-inline-flex">
                              <?php if (!empty($is_logged_in)): ?>
                              <a href="<?= site_url('account'); ?>" class="text-decoration-none">
                                 <div class="aq-header-top-account-item">
                                    <span class="grc-option-style d-inline-flex align-items-center justify-content-center">
                                       <i>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                             <path d="M16.212 18.75C16.212 15.267 12.747 12.45 8.481 12.45C4.215 12.45 0.75 15.267 0.75 18.75M12.9805 5.25C12.9805 7.73528 10.9657 9.75 8.48047 9.75C5.99519 9.75 3.98047 7.73528 3.98047 5.25C3.98047 2.76472 5.99519 0.75 8.48047 0.75C10.9657 0.75 12.9805 2.76472 12.9805 5.25Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </i>
                                    </span>
                                    <div class="aq-header-top-account-content text-start">
                                       <span><?= html_escape($current_user['first_name'] ?? 'Member'); ?></span>
                                       <p>Account</p>
                                    </div>
                                 </div>
                              </a>
                              <?php else: ?>
                              <a href="#exampleModalToggle" data-bs-toggle="modal" class="text-decoration-none">
                                 <div class="aq-header-top-account-item">
                                    <span class="grc-option-style d-inline-flex align-items-center justify-content-center">
                                       <i>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                             <path d="M16.212 18.75C16.212 15.267 12.747 12.45 8.481 12.45C4.215 12.45 0.75 15.267 0.75 18.75M12.9805 5.25C12.9805 7.73528 10.9657 9.75 8.48047 9.75C5.99519 9.75 3.98047 7.73528 3.98047 5.25C3.98047 2.76472 5.99519 0.75 8.48047 0.75C10.9657 0.75 12.9805 2.76472 12.9805 5.25Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </i>
                                    </span>
                                    <div class="aq-header-top-account-content text-start">
                                       <span>Hello</span>
                                       <p>Sign In</p>
                                    </div>
                                 </div>
                              </a>
                              <?php endif; ?>
                           </li>
                           <li class="aq-header-top-wishlist d-none d-xl-inline-flex">
                              <a href="<?= site_url('wishlist'); ?>" class="grc-option-style aq-wishlist-btn d-inline-flex align-items-center justify-content-center position-relative">
                                 <span class="count-box wishlist-count"><?= (int)($wishlist_count ?? 0); ?></span>
                                 <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                                       <path d="M6.50726 4.80303C5.44195 5.14334 4.68503 6.09974 4.59044 7.22502M10.4856 18.6038C12.6562 17.2679 14.6755 15.6957 16.5073 13.9152C17.7951 12.633 18.7756 11.0698 19.3735 9.3454C20.4494 6.00032 19.1927 2.17084 15.6755 1.03753C13.827 0.442448 11.8081 0.782566 10.2505 1.95149C8.69225 0.783989 6.67412 0.443991 4.82552 1.03753C1.30833 2.17084 0.0425004 6.00032 1.11845 9.3454C1.71636 11.0698 2.69679 12.633 3.98465 13.9152C5.81647 15.6957 7.83575 17.2679 10.0064 18.6038L10.2414 18.75L10.4856 18.6038Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </i>
                              </a>
                           </li>
                           <li class="aq-header-top-cart aq-cart-btn">
                              <button type="button" class="grc-option-style" onclick="openGrcCartDrawer()">
                                 <span class="count-box cart-count"><?= (int)($cart_count ?? 0); ?></span>
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
      </div>

      <!-- Department Category Bar (Dark Green) -->
      <div class="grc-header-ptb pt-10 pb-20" data-bg-color="#003D29" style="background-color:#003D29;">
         <div class="container container-1630">
            <div class="grc-categories-wrap d-lg-flex d-none justify-content-between align-items-center flex-wrap">
               <div class="grc-categories-item text-center">
                  <a href="<?= site_url('shop?on_sale=1'); ?>">
                     <div class="grc-categories-icon">
                        <span><i class="fa-solid fa-tags text-warning fs-5"></i></span>
                     </div>
                     <span class="grc-categories-title">Deals &amp; Sale</span>
                  </a>
               </div>
               <?php
               $dept_icons = ['fa-apple-whole', 'fa-carrot', 'fa-cheese', 'fa-bread-slice', 'fa-mug-hot', 'fa-jar', 'fa-Seedling', 'fa-fish'];
               if (!empty($nav_categories)):
                  foreach ($nav_categories as $c_i => $cat):
                     $ic = $dept_icons[$c_i % count($dept_icons)];
               ?>
               <div class="grc-categories-item text-center">
                  <a href="<?= site_url('shop/' . $cat['slug']); ?>">
                     <div class="grc-categories-icon">
                        <span><i class="fa-solid <?= $ic; ?> text-white fs-5"></i></span>
                     </div>
                     <span class="grc-categories-title"><?= html_escape($cat['name']); ?></span>
                  </a>
               </div>
               <?php
                  endforeach;
               endif;
               ?>
               <div class="grc-categories-item text-center">
                  <a href="<?= site_url('shop'); ?>">
                     <div class="grc-categories-icon">
                        <span><i class="fa-solid fa-basket-shopping text-white fs-5"></i></span>
                     </div>
                     <span class="grc-categories-title">Shop All Aisles</span>
                  </a>
               </div>
            </div>
         </div>
      </div>
      <!-- header area end -->

   </header>

   <?php if ($this->session->flashdata('success')): ?>
      <div class="container container-1630 mt-3">
         <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i><?= html_escape($this->session->flashdata('success')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>
      </div>
   <?php endif; ?>
   <?php if ($this->session->flashdata('error')): ?>
      <div class="container container-1630 mt-3">
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i><?= html_escape($this->session->flashdata('error')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>
      </div>
   <?php endif; ?>
