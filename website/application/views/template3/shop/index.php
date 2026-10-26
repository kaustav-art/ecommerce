<?php
/**
 * Template 3 — Bazaro Fresh Grocery Store Shop / Category Catalog Page
 * Matches Template 2 category hero & sidebar navigation structure with
 * Home Page Grocery product cards (.grc-product-style / .aq-product-item.aq-product-main).
 */
$bazaro = isset($tpl_assets) ? rtrim($tpl_assets, '/') . '/' : base_url('assets/templates/bazaro/');
$curr   = isset($currency_symbol) ? $currency_symbol : '₹';

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

$shop_products   = !empty($products) ? $products : [];
$cats_list       = !empty($all_categories) ? $all_categories : (!empty($nav_categories) ? $nav_categories : []);
$active_cat_slug = $filters['category_slug'] ?? ($selected_category['slug'] ?? '');
$heading_text    = !empty($page_heading) ? $page_heading : (!empty($selected_category['name']) ? $selected_category['name'] : 'Shop All Groceries');

$grc_brands = ['NatureFresh Organic', 'GreenValley Farms', 'HarvestGold Dairy', 'Artisan Bakehouse', 'EarthBounty Organics', 'PureOrchard Juices'];

if (!function_exists('grc_shop_unit_calc')) {
    function grc_shop_unit_calc($prod, $idx = 0) {
        $label  = trim((string)($prod['unit_label'] ?? ''));
        $u_type = isset($prod['unit_type']) ? $prod['unit_type'] : '';
        $u_qty  = isset($prod['unit_qty']) ? (float)$prod['unit_qty'] : 0;

        if (!$u_type || $u_qty <= 0) {
            $defaults = ['500g', '4 pcs', '400g', '1 kg', '500g', '1 pc', '12 pcs', '250g'];
            if ($label === '') {
                $label = $defaults[$idx % count($defaults)];
            }
            $lower = strtolower($label);
            if (preg_match('/(\d+(?:\.\d+)?)\s*(pc|pcs|piece|pieces|loaf|box|carton)/i', $lower, $m)) {
                $u_type = 'pc';
                $u_qty  = max(1, (float)$m[1]);
            } elseif (preg_match('/(\d+(?:\.\d+)?)\s*(g|gm|gram)/i', $lower, $m)) {
                $u_type = 'kg';
                $u_qty  = max(0.05, (float)$m[1] / 1000);
            } elseif (preg_match('/(\d+(?:\.\d+)?)\s*(kg|l|ltr|liter|litre)/i', $lower, $m)) {
                $u_type = 'kg';
                $u_qty  = max(0.1, (float)$m[1]);
            } else {
                $u_type = ($idx % 3 === 1) ? 'pc' : 'kg';
                $u_qty  = ($u_type === 'pc') ? 4 : 0.5;
            }
        }

        if (preg_match('/^(\d+(?:\.\d+)?)\s*(kg|g|gm|ml|l|ltr|liter|litre|liters|litres|pc|pcs|piece|pieces)\b/i', $label, $um)) {
            $u_word = $um[2];
            if (stripos($u_word, 'piece') === 0) {
                $u_word = ((float)$um[1] > 1) ? 'pcs' : 'pc';
            }
            $label = $um[1] . (in_array(strtolower($u_word), ['g', 'gm', 'ml'], true) ? strtolower($u_word) : ' ' . $u_word);
        } elseif (preg_match('/^(\d+)\b/', $label, $um)) {
            $label = $um[1] . (((int)$um[1] > 1) ? ' pcs' : ' pc');
        }

        $sale = (!empty($prod['sale_price']) && (float)$prod['sale_price'] > 0)
            ? (float)$prod['sale_price']
            : (float)($prod['price'] ?? 3.49);
        if ($sale <= 0) $sale = 3.49;

        $reg = (float)($prod['regular_price'] ?? ($prod['price'] ?? $sale));
        if ($reg < $sale) $reg = $sale;

        $unit_rate = $u_qty > 0 ? round($sale / $u_qty, 2) : $sale;
        return [
            'pack_label' => $label ?: ($u_type === 'pc' ? ((int)$u_qty . ' pcs') : ($u_qty < 1 ? (int)round($u_qty * 1000) . 'g' : $u_qty . ' kg')),
            'unit_type'  => $u_type,
            'unit_qty'   => $u_qty,
            'sale'       => $sale,
            'reg'        => $reg,
            'unit_rate'  => $unit_rate,
        ];
    }
}
?>

<style>
   /* ==========================================================================
      Template 3 (Bazaro Grocery) Dedicated Shop & Category Page Styles
      Theme: Deep Forest Green (#003D29) + Fresh Harvest Green (#108910)
      ========================================================================== */
   .grc-shop-hero {
      background: linear-gradient(135deg, #003D29 0%, #07593e 60%, #0b6b4b 100%);
      color: #ffffff;
      padding: 44px 0 34px;
      position: relative;
      overflow: hidden;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
   }
   .grc-shop-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(rgba(187, 247, 208, 0.12) 1px, transparent 1px);
      background-size: 24px 24px;
      pointer-events: none;
   }
   .grc-shop-hero-title {
      font-size: 40px;
      font-weight: 600;
      color: #ffffff;
      margin: 0 0 8px;
      letter-spacing: -0.6px;
   }
   .grc-shop-breadcrumbs {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
      list-style: none;
      margin: 0;
      padding: 0;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.7);
   }
   .grc-shop-breadcrumbs a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: color 0.15s ease;
   }
   .grc-shop-breadcrumbs a:hover {
      color: #bbf7d0;
   }
   .grc-shop-breadcrumbs .active {
      color: #bbf7d0;
      font-weight: 600;
   }

   /* Main Shop Layout */
   .grc-shop-section {
      background: #f4f8f5;
      padding: 40px 0 90px;
      min-height: 70vh;
   }

   /* Left Filter Sidebar */
   .grc-filter-card {
      background: #ffffff;
      border-radius: 16px;
      border: 1px solid #e2efe6;
      padding: 22px;
      box-shadow: 0 4px 18px rgba(0, 61, 41, 0.04);
   }
   .grc-filter-block {
      padding-bottom: 20px;
      margin-bottom: 20px;
      border-bottom: 1px solid #e8f2ec;
   }
   .grc-filter-block:last-child {
      padding-bottom: 0;
      margin-bottom: 0;
      border-bottom: none;
   }
   .grc-filter-heading {
      font-size: 13.5px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #003D29;
      margin: 0 0 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
   }
   .grc-dept-list {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      gap: 4px;
   }
   .grc-dept-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 11px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 500;
      color: #334155;
      text-decoration: none;
      transition: all 0.15s ease;
   }
   .grc-dept-link:hover {
      background: #ecfdf5;
      color: #003D29;
   }
   .grc-dept-link.is-active {
      background: #003D29;
      color: #ffffff;
      font-weight: 700;
   }
   .grc-dept-count {
      font-size: 11px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 20px;
      background: rgba(0, 61, 41, 0.07);
      color: #003D29;
   }
   .grc-dept-link.is-active .grc-dept-count {
      background: #108910;
      color: #ffffff;
   }

   /* Checkboxes & Price Brackets */
   .grc-check-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 5px 0;
      cursor: pointer;
      font-size: 13.5px;
      color: #334155;
   }
   .grc-price-brackets {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 7px;
      margin-top: 10px;
   }
   .grc-price-chip {
      border: 1px solid #d1e7dd;
      background: #f4fbf6;
      color: #003D29;
      font-size: 12px;
      font-weight: 600;
      padding: 6px 8px;
      border-radius: 8px;
      text-align: center;
      cursor: pointer;
      transition: all 0.15s ease;
   }
   .grc-price-chip:hover,
   .grc-price-chip.is-active {
      background: #003D29;
      color: #ffffff;
      border-color: #003D29;
   }

   /* Top Control Bar (Right-aligned like Electronics) */
   .grc-control-bar {
      padding: 12px 18px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      flex-wrap: wrap;
      gap: 12px;
      background: #ffffff;
      border-radius: 14px;
      border: 1px solid #e2efe6;
      box-shadow: 0 2px 10px rgba(0, 61, 41, 0.03);
   }
   .grc-view-btn {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      border: 1px solid #d1e7dd;
      background: #ffffff;
      color: #64748b;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.15s ease;
   }
   .grc-view-btn.is-active,
   .grc-view-btn:hover {
      background: #003D29;
      color: #ffffff;
      border-color: #003D29;
   }
   .grc-sort-select {
      height: 38px;
      border-radius: 8px;
      border: 1px solid #d1e7dd;
      background: #f4fbf6;
      padding: 0 12px;
      font-size: 13px;
      font-weight: 600;
      color: #003D29;
      outline: none;
      cursor: pointer;
   }

   /* Home Page Product Card Styling inside Shop Grid */
   #grcShopProductsGrid .aq-product-item.aq-product-main {
      background: #ffffff;
      border-radius: 14px;
      border: 1px solid #e2efe6;
      padding: 14px;
      margin-bottom: 0 !important;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.22s ease;
   }
   #grcShopProductsGrid .aq-product-item.aq-product-main:hover {
      border-color: #86efac;
      box-shadow: 0 10px 26px rgba(0, 61, 41, 0.08);
      transform: translateY(-3px);
   }
   #grcShopProductsGrid .aq-product-content {
      flex-grow: 1;
      margin-bottom: 10px;
   }

   /* List View Mode */
   #grcShopProductsGrid.is-list-view > .grc-aisle-col {
      width: 100% !important;
      flex: 0 0 100% !important;
   }
   #grcShopProductsGrid.is-list-view .aq-product-item.aq-product-main {
      flex-direction: row;
      align-items: center;
      gap: 24px;
      padding: 18px;
   }
   #grcShopProductsGrid.is-list-view .aq-product-thumb {
      width: 210px;
      flex-shrink: 0;
      margin-bottom: 0 !important;
   }
   #grcShopProductsGrid.is-list-view .grc-product-btn {
      width: 170px;
      flex-shrink: 0;
   }
   @media (max-width: 767.98px) {
      .grc-shop-hero-title {
         font-size: 26px;
      }
      #grcShopProductsGrid.is-list-view .aq-product-item.aq-product-main {
         flex-direction: column;
         align-items: stretch;
      }
      #grcShopProductsGrid.is-list-view .aq-product-thumb,
      #grcShopProductsGrid.is-list-view .grc-product-btn {
         width: 100%;
      }
   }
</style>

<main>
   <!-- 1. Forest Green Grocery Category Hero Banner -->
   <section class="grc-shop-hero">
      <div class="container position-relative" style="z-index:2;">
         <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
            <div>
               <h1 class="grc-shop-hero-title" id="grcShopPageHeading"><?= html_escape($heading_text); ?></h1>
               <ul class="grc-shop-breadcrumbs">
                  <li><a href="<?= site_url('home?preview_tpl=grocery'); ?>"><i class="fa-solid fa-house me-1"></i>Home</a></li>
                  <li><i class="fa-solid fa-angle-right" style="font-size:11px;"></i></li>
                  <li><a href="<?= site_url('shop?preview_tpl=grocery'); ?>">Grocery Catalog</a></li>
                  <?php if (!empty($selected_category['name'])): ?>
                     <li><i class="fa-solid fa-angle-right" style="font-size:11px;"></i></li>
                     <li class="active"><?= html_escape($selected_category['name']); ?></li>
                  <?php endif; ?>
               </ul>
            </div>
         </div>
      </div>
   </section>

   <!-- 2. Grocery Catalog & Sidebar Filters Section -->
   <section class="grc-shop-section">
      <div class="container">
         <div class="row g-4">

            <!-- Left Sidebar: Grocery Filters -->
            <div class="col-xl-3 col-lg-4">
               <div class="grc-filter-card">
                  <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                     <span class="fw-bold d-flex align-items-center gap-2" style="font-size:15px; color:#003D29;">
                        <i class="fa-solid fa-sliders text-success"></i> Grocery Filters
                     </span>
                     <button type="button" id="grcResetFiltersBtn" class="btn btn-sm p-0 border-0 text-danger fw-semibold" style="font-size:12.5px;" onclick="resetGrcAisleFilters()">
                        Reset All
                     </button>
                  </div>

                  <!-- Departments Filter (Dynamic Categories from Template 3) -->
                  <div class="grc-filter-block">
                     <h6 class="grc-filter-heading">Departments</h6>
                     <ul class="grc-dept-list">
                        <li>
                           <a href="<?= site_url('shop?preview_tpl=grocery'); ?>" class="grc-dept-link <?= empty($active_cat_slug) ? 'is-active' : ''; ?>">
                              <span>All Groceries</span>
                              <span class="grc-dept-count"><?= count($shop_products); ?></span>
                           </a>
                        </li>
                        <?php foreach ($cats_list as $cat):
                           $is_curr = (!empty($active_cat_slug) && strcasecmp($active_cat_slug, $cat['slug']) === 0);
                        ?>
                        <li>
                           <a href="<?= site_url('shop/' . $cat['slug'] . '?preview_tpl=grocery'); ?>" class="grc-dept-link <?= $is_curr ? 'is-active' : ''; ?>">
                              <span><?= html_escape($cat['name']); ?></span>
                              <span class="grc-dept-count"><?= (int)($cat['product_count'] ?? 12); ?></span>
                           </a>
                        </li>
                        <?php endforeach; ?>
                     </ul>
                  </div>

                  <!-- Selling Unit Type Filter (Per Kg vs Per Pc) -->
                  <div class="grc-filter-block">
                     <h6 class="grc-filter-heading">Selling Unit Type</h6>
                     <label class="grc-check-row">
                        <span class="d-flex align-items-center gap-2">
                           <input type="radio" name="grc_unit_filter" class="form-check-input" value="all" checked onchange="filterGrcAisleCards()">
                           <span>All Units (Kg &amp; Pc)</span>
                        </span>
                     </label>
                     <label class="grc-check-row">
                        <span class="d-flex align-items-center gap-2">
                           <input type="radio" name="grc_unit_filter" class="form-check-input" value="kg" onchange="filterGrcAisleCards()">
                           <span>By Weight (Per Kg Price)</span>
                        </span>
                     </label>
                     <label class="grc-check-row">
                        <span class="d-flex align-items-center gap-2">
                           <input type="radio" name="grc_unit_filter" class="form-check-input" value="pc" onchange="filterGrcAisleCards()">
                           <span>By Piece (Per Pc Price)</span>
                        </span>
                     </label>
                  </div>

                  <!-- Price Range Filter -->
                  <div class="grc-filter-block">
                     <h6 class="grc-filter-heading">
                        <span>Max Pack Price</span>
                        <span id="grcPriceRangeLabel" class="badge" style="background:#003D29; color:#fff;"><?= html_escape($curr); ?>25.00</span>
                     </h6>
                     <input type="range" id="grcMaxPriceSlider" class="form-range" min="2" max="25" step="0.5" value="25" oninput="filterGrcAisleCards()">
                     <div class="d-flex justify-content-between small text-muted mb-2">
                        <span><?= html_escape($curr); ?>2.00</span>
                        <span><?= html_escape($curr); ?>25.00+</span>
                     </div>
                     <div class="grc-price-brackets">
                        <button type="button" class="grc-price-chip" data-max-price="5" onclick="selectGrcPriceChip(this, 5)">Under <?= html_escape($curr); ?>5</button>
                        <button type="button" class="grc-price-chip" data-max-price="10" onclick="selectGrcPriceChip(this, 10)">Under <?= html_escape($curr); ?>10</button>
                        <button type="button" class="grc-price-chip" data-max-price="15" onclick="selectGrcPriceChip(this, 15)">Under <?= html_escape($curr); ?>15</button>
                        <button type="button" class="grc-price-chip is-active" data-max-price="25" onclick="selectGrcPriceChip(this, 25)">Any Price</button>
                     </div>
                  </div>

                  <!-- Organic Farm Brands -->
                  <div class="grc-filter-block">
                     <h6 class="grc-filter-heading">Organic Farms</h6>
                     <?php foreach ($grc_brands as $b_idx => $b_name): ?>
                        <label class="grc-check-row">
                           <span class="d-flex align-items-center gap-2">
                              <input type="checkbox" class="grc-brand-checkbox form-check-input" value="<?= html_escape($b_name); ?>" onchange="filterGrcAisleCards()">
                              <span><?= html_escape($b_name); ?></span>
                           </span>
                           <span class="text-muted small">(<?= (($b_idx * 2 + 3) % 7) + 2; ?>)</span>
                        </label>
                     <?php endforeach; ?>
                  </div>
               </div>
            </div>

            <!-- Right Content: Control Bar + Home Page Style Grocery Product Grid -->
            <div class="col-xl-9 col-lg-8">

               <!-- Top Control Bar -->
               <div class="grc-control-bar">
                  <div class="d-flex align-items-center gap-2 ms-auto">
                     <!-- Grid / List View Switcher -->
                     <div class="d-none d-md-flex align-items-center gap-1 me-1">
                        <button type="button" class="grc-view-btn is-active" data-view-mode="grid-3" title="3-Column Grid" onclick="switchGrcViewMode(this, 'grid-3')">
                           <i class="fa-solid fa-table-cells-large"></i>
                        </button>
                        <button type="button" class="grc-view-btn" data-view-mode="grid-4" title="Compact 4-Column Grid" onclick="switchGrcViewMode(this, 'grid-4')">
                           <i class="fa-solid fa-table-cells"></i>
                        </button>
                        <button type="button" class="grc-view-btn" data-view-mode="list" title="List View" onclick="switchGrcViewMode(this, 'list')">
                           <i class="fa-solid fa-list-ul"></i>
                        </button>
                     </div>

                     <!-- Sort Select -->
                     <select id="grcSortSelect" class="grc-sort-select" aria-label="Sort products" onchange="sortGrcAisleCards()">
                        <option value="featured">Sort: Featured Harvest</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="unit_asc">Unit Rate: Low to High</option>
                        <option value="a_z">Name: A to Z</option>
                     </select>
                  </div>
               </div>

               <!-- Products Grid (Exact Home Page Product Card Structure) -->
               <div class="grc-product-style">
                  <div class="row g-3 row-cols-xl-3 row-cols-md-2 row-cols-sm-2 row-cols-1" id="grcShopProductsGrid">
                     <?php foreach ($shop_products as $p_idx => $p):
                        $u_calc  = grc_shop_unit_calc($p, $p_idx);
                        $p_id    = (int)($p['id'] ?? ($p_idx + 1));
                        $p_name  = $p['name'] ?? ($p['title'] ?? 'Organic Grocery Item');
                        $p_slug  = $p['slug'] ?? 'sweet-red-strawberries-box';
                        $p_img   = grc_product_img($p['primary_image'] ?? ($p['main_image'] ?? ($p['image'] ?? '')), $bazaro, $p_idx + 1);
                        $p_reg   = (float)($p['regular_price'] ?? $p['price'] ?? 0);
                        $p_sal   = (!empty($p['sale_price']) && (float)$p['sale_price'] > 0 && (float)$p['sale_price'] < $p_reg) ? (float)$p['sale_price'] : $p_reg;
                        $p_pct   = ($p_sal < $p_reg && $p_reg > 0) ? round((($p_reg - $p_sal) / $p_reg) * 100) : 0;
                        $p_url   = site_url('product/' . $p_slug . '?preview_tpl=grocery');
                        $p_unit  = !empty($p['unit_label']) ? $p['unit_label'] : $u_calc['pack_label'];
                        $p_cat   = !empty($selected_category['name']) ? $selected_category['name'] : ($p['category_name'] ?? 'Organic Food');
                        $p_brand = $p['brand_name'] ?? $grc_brands[$p_idx % count($grc_brands)];
                     ?>
                     <div class="col grc-aisle-col"
                          data-title="<?= html_escape(strtolower($p_name)); ?>"
                          data-brand="<?= html_escape(strtolower($p_brand)); ?>"
                          data-unit="<?= html_escape($u_calc['unit_type']); ?>"
                          data-price="<?= $p_sal; ?>"
                          data-unitrate="<?= $u_calc['unit_rate']; ?>"
                          data-index="<?= $p_idx; ?>">
                        <div class="aq-product-item aq-product-main mb-40">
                           <div class="aq-product-thumb p-relative mb-10">
                              <?php if ($p_pct > 0): ?>
                              <div class="aq-product-badge">
                                 <span class="clr-sale">-<?= $p_pct; ?>%</span>
                              </div>
                              <?php endif; ?>
                              <a href="<?= $p_url; ?>">
                                 <img class="aq-product-img-hover" src="<?= $p_img; ?>" alt="<?= html_escape($p_name); ?>" onerror="this.src='<?= $bazaro; ?>img/product/grocery-p-<?= (($p_idx % 12) + 1); ?>.jpg'">
                              </a>
                              <div class="aq-product-action-2 d-flex flex-column">
                                 <button type="button" onclick="grcToggleWishlist(<?= $p_id; ?>)" class="aq-product-action-btn-2 aq-wishlist-btn aq-tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16" viewBox="0 0 19 16" fill="none">
                                       <path d="M5.83058 3.81134C4.89058 4.07825 4.22269 4.82839 4.13922 5.71098M9.34149 14.6355C11.2568 13.5878 13.0385 12.3546 14.6549 10.9581C15.7913 9.95244 16.6564 8.72639 17.184 7.37389C18.1334 4.75023 17.0244 1.74665 13.9209 0.857757C12.2899 0.391012 10.5085 1.54015 9.13406 2.45698C7.7591 1.54127 5.97836 0.392222 4.3472 0.857757C1.24372 1.74665 0.126783 4.75023 1.07618 7.37389C1.60376 8.72639 2.46886 9.95244 3.60523 10.9581C5.22159 12.3546 7.00335 13.5878 8.91865 14.6355L9.12608 14.7502L9.34149 14.6355Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="aq-tooltip-item">Wishlist</span>
                                 </button>
                              </div>
                           </div>
                           <div class="aq-product-content">
                              <div class="d-flex align-items-center justify-content-between mb-1">
                                 <span class="aqf-product-3-category"><?= html_escape($p_cat); ?></span>
                                 <span class="grc-unit-pill"><?= html_escape($p_unit); ?></span>
                              </div>
                              <h4 class="aq-product-title"><a href="<?= $p_url; ?>"><?= html_escape($p_name); ?></a></h4>
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
                              <button type="button" onclick="grcAddToCart(<?= $p_id; ?>, 1)" class="product-btn-green w-100">Add to bag</button>
                           </div>
                        </div>
                     </div>
                     <?php endforeach; ?>
                  </div>
               </div>

               <!-- Empty Filter State -->
               <div id="grcAisleEmptyState" class="text-center bg-white rounded-4 p-5 border mt-3" style="display:none;">
                  <i class="fa-solid fa-seedling fs-1 text-success mb-3"></i>
                  <h5 class="fw-bold" style="color:#003D29;">No matching grocery items found</h5>
                  <p class="text-muted small mb-3">Try adjusting your unit type, farm brand, or price range filter.</p>
                  <button type="button" class="btn btn-primary btn-sm px-4" onclick="resetGrcAisleFilters()">Reset Grocery Filters</button>
               </div>

            </div>

         </div>
      </div>
   </section>
</main>

<script>
(function() {
    window.selectGrcPriceChip = function(btn, maxP) {
        document.querySelectorAll('.grc-price-chip').forEach(function(c) {
            c.classList.remove('is-active');
        });
        btn.classList.add('is-active');
        var slider = document.getElementById('grcMaxPriceSlider');
        if (slider) slider.value = maxP;
        filterGrcAisleCards();
    };

    window.filterGrcAisleCards = function() {
        var unitRadio = document.querySelector('input[name="grc_unit_filter"]:checked');
        var unitVal = unitRadio ? unitRadio.value : 'all';
        var maxPrice = parseFloat(document.getElementById('grcMaxPriceSlider')?.value || '25');
        var priceLbl = document.getElementById('grcPriceRangeLabel');
        if (priceLbl) priceLbl.textContent = (window.CURRENCY_SYMBOL || '₹') + maxPrice.toFixed(2);

        var selectedBrands = [];
        document.querySelectorAll('.grc-brand-checkbox:checked').forEach(function(cb) {
            selectedBrands.push(cb.value.toLowerCase());
        });

        var cols = document.querySelectorAll('#grcShopProductsGrid .grc-aisle-col');
        var visible = 0;
        cols.forEach(function(col) {
            var unit  = col.getAttribute('data-unit') || 'kg';
            var price = parseFloat(col.getAttribute('data-price') || '0');
            var brand = col.getAttribute('data-brand') || '';

            var matchU = (unitVal === 'all') || (unit === unitVal);
            var matchP = price <= maxPrice;
            var matchB = (selectedBrands.length === 0) || (selectedBrands.indexOf(brand) !== -1);

            if (matchU && matchP && matchB) {
                col.style.display = '';
                visible++;
            } else {
                col.style.display = 'none';
            }
        });

        var emptyEl = document.getElementById('grcAisleEmptyState');
        if (emptyEl) emptyEl.style.display = visible === 0 ? 'block' : 'none';
    };

    window.sortGrcAisleCards = function() {
        var sortBy = document.getElementById('grcSortSelect')?.value || 'featured';
        var grid = document.getElementById('grcShopProductsGrid');
        if (!grid) return;
        var cols = Array.prototype.slice.call(grid.querySelectorAll('.grc-aisle-col'));
        cols.sort(function(a, b) {
            if (sortBy === 'price_asc') {
                return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
            }
            if (sortBy === 'price_desc') {
                return parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price'));
            }
            if (sortBy === 'unit_asc') {
                return parseFloat(a.getAttribute('data-unitrate')) - parseFloat(b.getAttribute('data-unitrate'));
            }
            if (sortBy === 'a_z') {
                return (a.getAttribute('data-title') || '').localeCompare(b.getAttribute('data-title') || '');
            }
            return parseInt(a.getAttribute('data-index'), 10) - parseInt(b.getAttribute('data-index'), 10);
        });
        cols.forEach(function(c) { grid.appendChild(c); });
    };

    window.switchGrcViewMode = function(btn, mode) {
        document.querySelectorAll('.grc-view-btn').forEach(function(b) {
            b.classList.remove('is-active');
        });
        btn.classList.add('is-active');
        var grid = document.getElementById('grcShopProductsGrid');
        if (!grid) return;
        grid.classList.remove('row-cols-xl-3', 'row-cols-xl-4', 'is-list-view');
        if (mode === 'grid-4') {
            grid.classList.add('row-cols-xl-4');
        } else if (mode === 'list') {
            grid.classList.add('row-cols-xl-3', 'is-list-view');
        } else {
            grid.classList.add('row-cols-xl-3');
        }
    };

    window.resetGrcAisleFilters = function() {
        var allUnit = document.querySelector('input[name="grc_unit_filter"][value="all"]');
        if (allUnit) allUnit.checked = true;
        var slider = document.getElementById('grcMaxPriceSlider');
        if (slider) slider.value = 25;
        document.querySelectorAll('.grc-price-chip').forEach(function(c) { c.classList.remove('is-active'); });
        var lastChip = document.querySelector('.grc-price-chip[data-max-price="25"]');
        if (lastChip) lastChip.classList.add('is-active');
        document.querySelectorAll('.grc-brand-checkbox').forEach(function(cb) { cb.checked = false; });
        var sortEl = document.getElementById('grcSortSelect');
        if (sortEl) sortEl.value = 'featured';
        sortGrcAisleCards();
        filterGrcAisleCards();
    };
})();
</script>
