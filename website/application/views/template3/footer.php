<?php
$bazaro = isset($tpl_assets) ? rtrim($tpl_assets, '/') . '/' : base_url('assets/templates/bazaro/');
$curr   = isset($currency_symbol) ? $currency_symbol : '$';
?>
   <footer>

      <!-- footer area start -->
      <div class="aq-footer-area grc-footer-style pt-100" data-bg-color="#003D29" style="background-color:#003D29;">
         <div class="container container-1630">
            <div class="aq-footer-widget-wrap">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                     <div class="aq-footer-widget footer-col-6-1 mb-90">
                        <div class="aq-footer-logo mb-25">
                           <a href="<?= site_url('home'); ?>">
                              <img data-width="120" src="<?= base_url('assets/images/logo/logo.webp'); ?>" alt="<?= html_escape($site_name); ?>" style="max-height:42px;width:auto;object-fit:contain;">
                           </a>
                        </div>
                        <div class="aq-footer-contact-wrap">
                           <div class="aq-footer-contact-item d-flex align-items-start">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none">
                                    <path d="M0.75 4.75C0.75 1.95 2.35 0.75 4.75 0.75H12.75C15.15 0.75 16.75 1.95 16.75 4.75V10.35C16.75 13.15 15.15 14.35 12.75 14.35H4.75M12.75 5.15028L10.246 7.15003C9.422 7.80596 8.07 7.80596 7.246 7.15003L4.75 5.15028M0.75 11.1503H5.55M0.75 7.94945H3.15" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </span>
                              <a href="mailto:<?= html_escape($store_settings['site_email'] ?? 'fresh@grocery.com'); ?>"><?= html_escape($store_settings['site_email'] ?? 'fresh@grocery.com'); ?></a>
                           </div>
                           <div class="aq-footer-contact-item d-flex align-items-start">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="17" height="19" viewBox="0 0 17 19" fill="none">
                                    <path d="M8.25099 10.6922C9.74975 10.6922 10.9647 9.47717 10.9647 7.9784C10.9647 6.47964 9.74975 5.26465 8.25099 5.26465C6.75222 5.26465 5.53723 6.47964 5.53723 7.9784C5.53723 9.47717 6.75222 10.6922 8.25099 10.6922Z" stroke="currentcolor" stroke-width="1.5"/>
                                    <path d="M0.962124 6.39496C2.67562 -1.13745 13.8351 -1.12875 15.5399 6.40366C16.5401 10.8222 13.7916 14.5623 11.3822 16.876C9.63396 18.5634 6.86802 18.5634 5.11104 16.876C2.71041 14.5623 -0.0381381 10.8135 0.962124 6.39496Z" stroke="currentcolor" stroke-width="1.5"/>
                                 </svg>
                              </span>
                              <a href="<?= site_url('contact'); ?>">
                                 <?= html_escape($store_settings['site_address'] ?? '29 SE 2nd Ave, Miami Florida 44041, United States'); ?>
                              </a>
                           </div>
                           <div class="aq-footer-contact-item d-flex align-items-start">
                              <a class="fs-bold" href="tel:<?= html_escape($store_settings['site_phone'] ?? '40276328246'); ?>"><?= html_escape($store_settings['site_phone'] ?? '(+92) 413 90 762'); ?></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                     <div class="aq-footer-widget mb-90">
                        <h4 class="aq-footer-widget-title">Departments</h4>
                        <div class="aq-footer-widget-menu">
                           <ul>
                              <?php if (!empty($nav_categories)): ?>
                                 <?php $fc = 0; foreach ($nav_categories as $cat): if ($fc++ >= 5) break; ?>
                                    <li><a href="<?= site_url('shop/' . $cat['slug']); ?>"><?= html_escape($cat['name']); ?></a></li>
                                 <?php endforeach; ?>
                              <?php else: ?>
                                 <li><a href="<?= site_url('shop'); ?>">Fresh Produce</a></li>
                                 <li><a href="<?= site_url('shop'); ?>">Organic Dairy</a></li>
                                 <li><a href="<?= site_url('shop'); ?>">Artisan Bakery</a></li>
                              <?php endif; ?>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                     <div class="aq-footer-widget mb-90">
                        <h4 class="aq-footer-widget-title">Information</h4>
                        <div class="aq-footer-widget-menu">
                           <ul>
                              <li><a href="<?= site_url('order/track'); ?>">Track Order</a></li>
                              <li><a href="<?= site_url('returns-policy'); ?>">Delivery &amp; Returns</a></li>
                              <li><a href="<?= site_url('about'); ?>">About Our Farms</a></li>
                              <li><a href="<?= site_url('contact'); ?>">Help &amp; Support</a></li>
                              <li><a href="<?= site_url('privacy'); ?>">Privacy Policy</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                     <div class="aq-footer-widget mb-90">
                        <h4 class="aq-footer-widget-title">Account</h4>
                        <div class="aq-footer-widget-menu">
                           <ul>
                              <li><a href="<?= site_url('cart'); ?>">Grocery Bag</a></li>
                              <li><a href="<?= !empty($is_logged_in) ? site_url('account') : site_url('auth/login'); ?>">My Account</a></li>
                              <li><a href="<?= !empty($is_logged_in) ? site_url('account/orders') : site_url('order/track'); ?>">My Orders</a></li>
                              <li><a href="<?= site_url('wishlist'); ?>">Saved Items</a></li>
                              <li><a href="<?= site_url('checkout'); ?>">Express Checkout</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-md-7 col-sm-10">
                     <div class="aq-footer-widget mb-90">
                        <h4 class="aq-footer-widget-title">Subscribe.</h4>
                        <div class="aq-footer-widget-input-box mb-25">
                           <form action="<?= site_url('newsletter/subscribe'); ?>" method="POST">
                              <p class="mb-10">Get weekly organic harvest specials &amp; recipes</p>
                              <div class="aq-footer-widget-input p-relative">
                                 <input class="aq-form-control h-56 brr-0" type="email" name="email" placeholder="Enter Your Email" required>
                                 <button class="aq-btn-subscribe" type="submit">Subscribe</button>
                              </div>
                           </form>
                        </div>
                        <div class="aq-footer-widget-social-box">
                           <h4 class="aq-footer-widget-social-title mb-10">Follow Us On</h4>
                           <div class="aq-footer-widget-social">
                              <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                              <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                              <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                              <a href="#"><i class="fa-brands fa-instagram"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="aq-copyright-area">
            <div class="container container-1630">
               <div class="aq-copyright-border pt-15 pb-15">
                  <div class="row align-items-center">
                     <div class="col-xl-5 col-lg-5 col-md-6">
                        <div class="aq-copyright-text text-center text-md-start pb-20">
                           <p class="mb-0">All rights reserved — <?= date('Y'); ?> &copy; <a href="<?= site_url('home'); ?>"><?= html_escape($site_name); ?></a></p>
                        </div>
                     </div>
                     <div class="col-xl-7 col-lg-7 col-md-6">
                        <div class="aq-copyright-payment text-center text-md-end pb-20">
                           <a href="<?= site_url('checkout'); ?>"><img src="<?= $bazaro; ?>img/payment/payment.png" alt="Payment Methods"></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- footer area end -->

   </footer>

   <!-- Bazaro JS Core -->
   <script src="<?= $bazaro; ?>js/vendor/jquery.js"></script>
   <script src="<?= $bazaro; ?>js/bootstrap-bundle.js"></script>
   <script src="<?= $bazaro; ?>js/swiper-bundle.js"></script>
   <script src="<?= $bazaro; ?>js/magnific-popup.js"></script>
   <script src="<?= $bazaro; ?>js/nice-select.js"></script>
   <script src="<?= $bazaro; ?>js/purecounter.js"></script>
   <script src="<?= $bazaro; ?>js/isotope-pkgd.js"></script>
   <script src="<?= $bazaro; ?>js/lazysize.min.js"></script>
   <script src="<?= $bazaro; ?>js/slider-active.js"></script>
   <script src="<?= $bazaro; ?>js/imagesloaded-pkgd.js"></script>
   <script src="<?= $bazaro; ?>js/ajax-form.js"></script>
   <script src="<?= $bazaro; ?>js/main.js"></script>

   <?php if (($active_page ?? 'home') !== 'home'): ?>
   <script src="<?= base_url('assets/js/main.js'); ?>"></script>
   <?php endif; ?>

   <script>
   function showGrcToast(msg, isError) {
       var t = document.getElementById('grcToast');
       var txt = document.getElementById('grcToastText');
       if (!t || !txt) return;
       txt.textContent = msg;
       t.style.background = isError ? '#dc2626' : '#003D29';
       t.style.display = 'inline-flex';
       clearTimeout(window._grcToastTimer);
       window._grcToastTimer = setTimeout(function() {
           t.style.display = 'none';
       }, 3000);
   }

   function openGrcCartDrawer() {
       var d = document.getElementById('grcCartMiniDrawer');
       var ov = document.querySelector('.body-overlay');
       if (d) d.classList.add('cartmini-opened');
       if (ov) ov.classList.add('opened');
   }

   function closeGrcCartDrawer() {
       var d = document.getElementById('grcCartMiniDrawer');
       var ov = document.querySelector('.body-overlay');
       if (d) d.classList.remove('cartmini-opened');
       if (ov) ov.classList.remove('opened');
   }

   function renderGrcCartDrawer(data) {
       if (!data) return;
       var count = (data.cart_summary && typeof data.cart_summary.item_count !== 'undefined')
           ? data.cart_summary.item_count
           : (typeof data.cart_count !== 'undefined' ? data.cart_count : null);
       var subtotal = (data.cart_summary && typeof data.cart_summary.subtotal !== 'undefined')
           ? parseFloat(data.cart_summary.subtotal)
           : (typeof data.cart_total !== 'undefined' ? parseFloat(data.cart_total) : 0);

       if (count !== null) {
           document.querySelectorAll('.cart-count, .count-box.cart-count').forEach(function(el) {
               el.textContent = count;
           });
       }
       var subEl = document.getElementById('grcCartMiniSubtotal');
       if (subEl) {
           subEl.textContent = window.CURRENCY_SYMBOL + subtotal.toFixed(2);
       }

       var body = document.getElementById('grcCartMiniBody');
       if (body && Array.isArray(data.cart_items)) {
           if (data.cart_items.length === 0) {
               body.innerHTML = '<div class="cartmini-empty text-center py-5">' +
                   '<p class="text-muted">Your grocery bag is empty</p>' +
                   '<a href="' + window.SITE_URL + '/shop" class="aq-btn-black border-btn mt-2">Browse Fresh Aisles</a></div>';
           } else {
               var html = '';
               data.cart_items.forEach(function(item) {
                   var img = item.image
                       ? (item.image.indexOf('http') === 0 ? item.image : window.BASE_URL + 'assets/images/products/' + item.image.replace(/^\/+/, ''))
                       : '<?= $bazaro; ?>img/product/grocery-p-1.jpg';
                   var pUrl = window.SITE_URL + '/product/' + (item.slug || item.product_id);
                   var key = item.cart_key || item.product_id;
                   html += '<div class="aq-cartmini-product-item mb-15 item-delete d-flex align-items-center">' +
                       '<div class="aq-cartmini-product-thumbnail"><a href="' + pUrl + '"><img src="' + img + '" alt=""></a></div>' +
                       '<div class="aq-cartmini-product-summary">' +
                       '<h4 class="aq-product-title"><a href="' + pUrl + '">' + item.name + '</a></h4>' +
                       '<span class="aq-cartmini-product-price">' + window.CURRENCY_SYMBOL + parseFloat(item.price).toFixed(2) + ' &times; ' + item.quantity + '</span>' +
                       '<div class="aq-product-details-quantity d-flex align-items-center mt-1">' +
                       '<button type="button" onclick="grcRemoveCartItem(\'' + key + '\')" class="aq-line-anim aq-cartmini-remove">Remove</button>' +
                       '</div></div></div>';
               });
               body.innerHTML = html;
           }
       }
   }

   function grcAddToCart(productId, quantity) {
       quantity = quantity || 1;
       var fd = new FormData();
       fd.append('product_id', productId);
       fd.append('quantity', quantity);

       fetch('<?= site_url("cart/add"); ?>', {
           method: 'POST',
           headers: { 'X-Requested-With': 'XMLHttpRequest' },
           body: fd
       })
       .then(function(r) { return r.json(); })
       .then(function(res) {
           if (res.success) {
               renderGrcCartDrawer(res);
               showGrcToast(res.message || 'Added to grocery bag!');
               openGrcCartDrawer();
           } else {
               showGrcToast(res.message || 'Could not add item', true);
           }
       })
       .catch(function() {
           showGrcToast('Network error adding to bag', true);
       });
   }

   function grcRemoveCartItem(cartKey) {
       var fd = new FormData();
       fd.append('cart_key', cartKey);
       fetch('<?= site_url("cart/remove"); ?>', {
           method: 'POST',
           headers: { 'X-Requested-With': 'XMLHttpRequest' },
           body: fd
       })
       .then(function(r) { return r.json(); })
       .then(function(res) {
           if (res.success) {
               renderGrcCartDrawer(res);
               showGrcToast('Item removed from bag');
           }
       });
   }

   function grcToggleWishlist(productId) {
       if (!window.IS_USER_LOGGED_IN) {
           window.location.href = '<?= site_url("auth/login"); ?>';
           return;
       }
       var fd = new FormData();
       fd.append('product_id', productId);
       fetch('<?= site_url("wishlist/toggle"); ?>', {
           method: 'POST',
           headers: { 'X-Requested-With': 'XMLHttpRequest' },
           body: fd
       })
       .then(function(r) { return r.json(); })
       .then(function(res) {
           if (res.success) {
               showGrcToast(res.message || 'Wishlist updated!');
               if (typeof res.wishlist_count !== 'undefined') {
                   document.querySelectorAll('.wishlist-count').forEach(function(el) {
                       el.textContent = res.wishlist_count;
                   });
               }
           }
       });
   }

   // Countdown timer for Deal of the Week
   (function() {
       var dEl = document.getElementById('days');
       var hEl = document.getElementById('hours');
       var mEl = document.getElementById('minutes');
       var sEl = document.getElementById('seconds');
       if (!dEl || !sEl) return;
       var target = new Date().getTime() + (6 * 86400000) + (14 * 3600000) + (38 * 60000);
       setInterval(function() {
           var diff = Math.max(0, target - new Date().getTime());
           var d = Math.floor(diff / 86400000);
           var h = Math.floor((diff % 86400000) / 3600000);
           var m = Math.floor((diff % 3600000) / 60000);
           var s = Math.floor((diff % 60000) / 1000);
           dEl.textContent = d < 10 ? '0' + d : d;
           hEl.textContent = h < 10 ? '0' + h : h;
           mEl.textContent = m < 10 ? '0' + m : m;
           sEl.textContent = s < 10 ? '0' + s : s;
       }, 1000);
   })();

   // Propagate ?preview_tpl=grocery across all internal storefront links on Template 3
   document.addEventListener('DOMContentLoaded', function() {
       var siteBase = '<?= rtrim(base_url(), "/"); ?>';
       document.querySelectorAll('a[href]').forEach(function(a) {
           var href = a.getAttribute('href');
           if (!href || href.charAt(0) === '#' || href.indexOf('javascript:') === 0 || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return;
           if (href.indexOf(siteBase) === 0 && href.indexOf('preview_tpl=') === -1) {
               var sep = href.indexOf('?') === -1 ? '?' : '&';
               a.setAttribute('href', href + sep + 'preview_tpl=grocery');
           }
       });
   });
   </script>

</body>
</html>
