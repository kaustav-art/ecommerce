<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('setting_model');
    }

    public function get_items()
    {
        $user_id = $this->session->userdata('user_id');
        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) {
            $cart = [];
        }

        if ($user_id) {
            $cart = $this->sync_db_with_session($user_id, $cart);
        }

        if (empty($cart)) {
            return [];
        }

        $tax_mult = $this->product_model->get_tax_multiplier();
        $cart_changed = false;

        foreach ($cart as $k => &$item) {
            // Ensure base prices exist
            if (!isset($item['base_price']) || !is_numeric($item['base_price'])) {
                if (!empty($item['variant_id'])) {
                    $v_row = $this->db->where('id', (int) $item['variant_id'])->get('product_variants')->row_array();
                    if ($v_row) {
                        $item['base_price'] = (!empty($v_row['sale_price']) && (float)$v_row['sale_price'] > 0) ? (float) $v_row['sale_price'] : (float) $v_row['price'];
                        $item['base_regular_price'] = (float) $v_row['price'];
                    }
                }
                if (!isset($item['base_price']) && !empty($item['id'])) {
                    $p_row = $this->db->where('id', (int) $item['id'])->get('products')->row_array();
                    if ($p_row) {
                        $item['base_price'] = (!empty($p_row['sale_price']) && (float)$p_row['sale_price'] > 0) ? (float) $p_row['sale_price'] : (float) $p_row['price'];
                        $item['base_regular_price'] = (float) $p_row['price'];
                    }
                }
                if (!isset($item['base_price'])) {
                    $item['base_price'] = (float) $item['price'];
                    $item['base_regular_price'] = !empty($item['regular_price']) ? (float) $item['regular_price'] : round($item['price'] * 1.30, 2);
                }
                $cart_changed = true;
            }

            if (!isset($item['base_regular_price']) || !is_numeric($item['base_regular_price']) || $item['base_regular_price'] <= 0) {
                $item['base_regular_price'] = round($item['base_price'] * 1.30, 2);
                $cart_changed = true;
            }

            // Dynamically compute current price and regular price based on active tax mode
            if ($tax_mult > 1.0) {
                $new_price = round($item['base_price'] * $tax_mult, 2);
                $new_reg   = round($item['base_regular_price'] * $tax_mult, 2);
            } else {
                $new_price = (float) $item['base_price'];
                $new_reg   = (float) $item['base_regular_price'];
            }

            if ($new_reg <= $new_price) {
                $new_reg = round($new_price * 1.30, 2);
            }

            if (!isset($item['price']) || abs((float)$item['price'] - $new_price) > 0.001) {
                $item['price'] = $new_price;
                $cart_changed = true;
            }
            if (!isset($item['regular_price']) || abs((float)$item['regular_price'] - $new_reg) > 0.001) {
                $item['regular_price'] = $new_reg;
                $cart_changed = true;
            }

            $new_total = round($item['price'] * (int) $item['quantity'], 2);
            if (!isset($item['total']) || abs((float)$item['total'] - $new_total) > 0.001) {
                $item['total'] = $new_total;
                $cart_changed = true;
            }

            if (!empty($item['regular_price']) && $item['regular_price'] > $item['price']) {
                $item['discount_percent'] = round((($item['regular_price'] - $item['price']) / $item['regular_price']) * 100);
            } else {
                $item['discount_percent'] = 0;
            }

            // Extract variant attributes (size, color) if not already set
            if (empty($item['size']) || empty($item['color'])) {
                if (!empty($item['variant_id'])) {
                    $attr_rows = $this->db->select('a.slug as attr_slug, a.name as attr_name, av.value as attr_val')
                                          ->from('product_variant_values pvv')
                                          ->join('attributes a', 'a.id = pvv.attribute_id')
                                          ->join('attribute_values av', 'av.id = pvv.attribute_value_id')
                                          ->where('pvv.variant_id', (int) $item['variant_id'])
                                          ->get()
                                          ->result_array();
                    foreach ($attr_rows as $ar) {
                        $slug = strtolower($ar['attr_slug'] ?: $ar['attr_name']);
                        if ($slug === 'size' && empty($item['size'])) {
                            $item['size'] = $ar['attr_val'];
                        } elseif ($slug === 'color' && empty($item['color'])) {
                            $item['color'] = $ar['attr_val'];
                        }
                    }
                }

                // Fallback parsing from variant_title if size or color still empty
                if ((empty($item['size']) || empty($item['color'])) && !empty($item['variant_title'])) {
                    $opt_str = $item['variant_title'];
                    if (strpos($opt_str, '-') !== false) {
                        $dash_parts = explode('-', $opt_str);
                        $opt_str = trim(end($dash_parts));
                    }
                    if (strpos($opt_str, '/') !== false) {
                        $parts = array_map('trim', explode('/', $opt_str));
                        $sizes_known = ['xs', 's', 'm', 'l', 'xl', 'xxl', 'xxxl', '28', '30', '32', '34', '36', '38', '40', '42'];
                        foreach ($parts as $p) {
                            if (in_array(strtolower($p), $sizes_known)) {
                                if (empty($item['size'])) $item['size'] = $p;
                            } else {
                                if (empty($item['color'])) $item['color'] = $p;
                            }
                        }
                    } else {
                        if (empty($item['size'])) $item['size'] = $opt_str;
                    }
                }
            }

            // Ensure brand_name, max_purchase_quantity, is_cod_allowed, rating, reviews_count, short_description
            if (!empty($item['id'])) {
                $p_info = $this->db->select('b.name as brand_name, p.max_purchase_quantity, p.stock_quantity, p.is_cod_allowed, p.rating, p.reviews_count, p.short_description')
                                   ->from('products p')
                                   ->join('brands b', 'b.id = p.brand_id', 'left')
                                   ->where('p.id', (int) $item['id'])
                                   ->get()
                                   ->row_array();
                if (empty($item['brand_name'])) {
                    $item['brand_name'] = !empty($p_info['brand_name']) ? $p_info['brand_name'] : 'VTEXX';
                }
                $max_p = !empty($p_info['max_purchase_quantity']) ? (int) $p_info['max_purchase_quantity'] : 5;
                $item['stock_max'] = isset($item['stock_max']) ? min((int)$item['stock_max'], $max_p) : $max_p;
                $item['is_cod_allowed'] = isset($p_info['is_cod_allowed']) ? (int) $p_info['is_cod_allowed'] : 1;
                $item['rating'] = !empty($p_info['rating']) ? (float) $p_info['rating'] : 4.2;
                $item['reviews_count'] = !empty($p_info['reviews_count']) ? (int) $p_info['reviews_count'] : 240;
                $item['short_description'] = !empty($p_info['short_description']) ? $p_info['short_description'] : '';
            }
        }

        if ($cart_changed) {
            $this->session->set_userdata('cart', $cart);
        }

        return $cart;
    }

    public function add_item($product_id, $quantity = 1, $variant_id = NULL)
    {
        $product = $this->product_model->get_by_id($product_id);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        $variant = NULL;
        if (!empty($variant_id)) {
            $variant = $this->product_model->get_variant_by_id($variant_id);
            if (!$variant || $variant['product_id'] != $product_id) {
                return ['success' => false, 'message' => 'Selected product variant was not found.'];
            }
        }

        // Cart item unique key
        $cart_key = $product_id . ($variant ? '_' . $variant['id'] : '');
        $cart = $this->get_items();

        $available_stock = $variant ? (int) $variant['stock_quantity'] : (int) $product['stock_quantity'];
        $max_limit = !empty($product['max_purchase_quantity']) ? (int) $product['max_purchase_quantity'] : 999;
        if ($max_limit > 0) {
            $available_stock = min($available_stock, $max_limit);
        }
        $existing_qty = isset($cart[$cart_key]) ? (int) $cart[$cart_key]['quantity'] : 0;
        $target_qty = $existing_qty + $quantity;

        if ($target_qty > $available_stock) {
            if ($available_stock <= 0) {
                return ['success' => false, 'message' => 'This item is currently out of stock.'];
            }
            if ($max_limit > 0 && $target_qty > $max_limit) {
                return ['success' => false, 'message' => "You can only purchase a maximum of {$max_limit} units of this product per order."];
            }
            return ['success' => false, 'message' => "Only {$available_stock} units available in stock."];
        }

        // Price calculation
        if ($variant) {
            $base_p = (!empty($variant['base_sale_price']) && (float)$variant['base_sale_price'] > 0) ? (float)$variant['base_sale_price'] : ((isset($variant['base_price']) && is_numeric($variant['base_price'])) ? (float)$variant['base_price'] : (!empty($variant['sale_price']) ? (float)$variant['sale_price'] : (float)$variant['price']));
            $base_reg = (isset($variant['base_price']) && is_numeric($variant['base_price'])) ? (float)$variant['base_price'] : (!empty($variant['price']) ? (float)$variant['price'] : round($base_p * 1.30, 2));
            $price = !empty($variant['sale_price']) ? (float) $variant['sale_price'] : (float) $variant['price'];
            $regular_price = !empty($variant['price']) ? (float) $variant['price'] : round($price * 1.30, 2);
            $image = !empty($variant['image']) ? $variant['image'] : $product['main_image'];
            $sku   = !empty($variant['sku']) ? $variant['sku'] : $product['sku'];
        } else {
            $base_p = (!empty($product['base_sale_price']) && (float)$product['base_sale_price'] > 0) ? (float)$product['base_sale_price'] : ((isset($product['base_price']) && is_numeric($product['base_price'])) ? (float)$product['base_price'] : (!empty($product['sale_price']) ? (float)$product['sale_price'] : (float)$product['price']));
            $base_reg = (isset($product['base_price']) && is_numeric($product['base_price'])) ? (float)$product['base_price'] : (!empty($product['price']) ? (float)$product['price'] : round($base_p * 1.30, 2));
            $price = !empty($product['sale_price']) ? (float) $product['sale_price'] : (float) $product['price'];
            $regular_price = !empty($product['price']) ? (float) $product['price'] : round($price * 1.30, 2);
            $image = $product['main_image'];
            $sku   = $product['sku'];
        }
        if ($regular_price <= $price) {
            $regular_price = round($price * 1.30, 2);
        }
        if ($base_reg <= $base_p) {
            $base_reg = round($base_p * 1.30, 2);
        }
        $disc_pct = ($regular_price > $price) ? round((($regular_price - $price) / $regular_price) * 100) : 0;

        $item_size = '';
        $item_color = '';
        if ($variant && !empty($variant['values'])) {
            foreach ($variant['values'] as $vval) {
                $aslug = strtolower($vval['attribute_slug'] ?? ($vval['attribute_name'] ?? ''));
                if ($aslug === 'size' && empty($item_size)) {
                    $item_size = $vval['attribute_value'];
                } elseif ($aslug === 'color' && empty($item_color)) {
                    $item_color = $vval['attribute_value'];
                }
            }
        }

        $cart[$cart_key] = [
            'cart_key'           => $cart_key,
            'id'                 => (int) $product['id'],
            'variant_id'         => $variant ? (int) $variant['id'] : NULL,
            'variant_title'      => $variant ? $variant['title'] : NULL,
            'size'               => $item_size,
            'color'              => $item_color,
            'brand_name'         => !empty($product['brand_name']) ? $product['brand_name'] : 'VTEXX',
            'title'              => $product['title'],
            'slug'               => $product['slug'],
            'sku'                => $sku,
            'image'              => $image,
            'base_price'         => (float) $base_p,
            'base_regular_price' => (float) $base_reg,
            'price'              => (float) $price,
            'regular_price'      => (float) $regular_price,
            'discount_percent'   => $disc_pct,
            'quantity'           => $target_qty,
            'total'              => (float) ($price * $target_qty),
            'stock_max'          => $available_stock,
            'is_cod_allowed'     => isset($product['is_cod_allowed']) ? (int) $product['is_cod_allowed'] : 1,
            'short_description'  => !empty($product['short_description']) ? $product['short_description'] : ''
        ];

        $this->session->set_userdata('cart', $cart);

        // Synchronize with database for logged-in user
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $vid = !empty($variant_id) ? (int)$variant_id : 0;
            $existing = $this->db->where('user_id', (int)$user_id)
                                 ->where('product_id', (int)$product_id)
                                 ->where('variant_id', $vid)
                                 ->get('cart_items')
                                 ->row_array();
            if ($existing) {
                $this->db->where('id', $existing['id'])->update('cart_items', [
                    'quantity'   => $target_qty,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->db->insert('cart_items', [
                    'user_id'    => (int)$user_id,
                    'product_id' => (int)$product_id,
                    'variant_id' => $vid,
                    'quantity'   => $target_qty,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        $summary = $this->get_cart_summary();
        return [
            'success'      => true,
            'message'      => 'Item added to your shopping cart.',
            'cart_count'   => $summary['item_count'],
            'cart_summary' => $summary,
            'item'         => $cart[$cart_key]
        ];
    }

    public function update_item($cart_key, $quantity)
    {
        $cart = $this->get_items();
        $quantity = (int) $quantity;
        $limit_msg = '';

        if ($quantity <= 0) {
            unset($cart[$cart_key]);
        } elseif (isset($cart[$cart_key])) {
            $item = $cart[$cart_key];
            $stock_max = (!empty($item['stock_max']) && (int) $item['stock_max'] > 0) ? (int) $item['stock_max'] : 0;
            if ($stock_max <= 0) {
                // Fetch fresh stock and limit from database if missing from old session
                $prod = $this->product_model->get_by_id($item['id']);
                if ($prod) {
                    $stock_max = (int) $prod['stock_quantity'];
                    if (!empty($prod['max_purchase_quantity']) && (int) $prod['max_purchase_quantity'] > 0) {
                        $stock_max = min($stock_max, (int) $prod['max_purchase_quantity']);
                    }
                }
                if ($stock_max <= 0) $stock_max = 999;
                $cart[$cart_key]['stock_max'] = $stock_max;
            }

            if ($quantity > $stock_max) {
                $limit_msg = "Maximum purchase limit of {$stock_max} units reached for this item.";
                $quantity = $stock_max;
            }
            $cart[$cart_key]['quantity'] = $quantity;
            $cart[$cart_key]['total']    = round($cart[$cart_key]['price'] * $quantity, 2);
        }

        $this->session->set_userdata('cart', $cart);

        // Synchronize with database for logged-in user
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $parts = explode('_', (string)$cart_key);
            $pid = (int) $parts[0];
            $vid = isset($parts[1]) ? (int)$parts[1] : 0;

            if ($quantity <= 0) {
                $this->db->where('user_id', (int)$user_id)
                         ->where('product_id', $pid)
                         ->where('variant_id', $vid)
                         ->delete('cart_items');
            } else {
                $this->db->where('user_id', (int)$user_id)
                         ->where('product_id', $pid)
                         ->where('variant_id', $vid)
                         ->update('cart_items', [
                             'quantity'   => $quantity,
                             'updated_at' => date('Y-m-d H:i:s')
                         ]);
            }
        }

        $summary = $this->get_cart_summary();
        return [
            'success'      => true,
            'message'      => $limit_msg,
            'cart_count'   => $summary['item_count'],
            'cart_summary' => $summary
        ];
    }

    public function remove_item($cart_key)
    {
        $cart = $this->get_items();
        if (isset($cart[$cart_key])) {
            $item = $cart[$cart_key];
            unset($cart[$cart_key]);
            $this->session->set_userdata('cart', $cart);

            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                $pid = (int) $item['id'];
                $vid = !empty($item['variant_id']) ? (int)$item['variant_id'] : 0;
                $this->db->where('user_id', (int) $user_id)
                         ->where('product_id', $pid)
                         ->where('variant_id', $vid)
                         ->delete('cart_items');
            }
        }
        $summary = $this->get_cart_summary();
        return ['success' => true, 'cart_count' => $summary['item_count'], 'cart_summary' => $summary];
    }

    public function clear_cart()
    {
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->db->where('user_id', (int) $user_id)->delete('cart_items');
        }
        $this->session->unset_userdata('cart');
        $this->session->unset_userdata('applied_coupon');
    }

    public function apply_coupon($code)
    {
        $code = strtoupper(trim($code));
        $coupon = $this->db->where('code', $code)
                           ->where('status', 'active')
                           ->get('coupons')
                           ->row_array();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid discount coupon code.'];
        }

        if (!empty($coupon['expires_at']) && strtotime($coupon['expires_at']) < time()) {
            return ['success' => false, 'message' => 'This coupon has expired.'];
        }

        $summary = $this->get_cart_summary();
        if ($summary['subtotal'] < $coupon['min_spend']) {
            return ['success' => false, 'message' => 'Minimum spend of $' . number_format($coupon['min_spend'], 2) . ' required for this coupon.'];
        }

        $discount_amount = 0.00;
        if ($coupon['discount_type'] === 'percent') {
            $discount_amount = ($summary['subtotal'] * $coupon['discount_value']) / 100;
        } else {
            $discount_amount = (float) $coupon['discount_value'];
        }

        $this->session->set_userdata('applied_coupon', [
            'id'       => $coupon['id'],
            'code'     => $coupon['code'],
            'discount' => $discount_amount
        ]);

        return ['success' => true, 'message' => 'Coupon ' . $coupon['code'] . ' applied successfully!'];
    }

    public function remove_coupon()
    {
        $this->session->unset_userdata('applied_coupon');
        return ['success' => true];
    }

    public function get_cart_summary($shipping_method = 'standard')
    {
        $items = $this->get_items();
        $subtotal = 0.00;
        $item_count = 0;
        $mrp_total = 0.00;

        foreach ($items as $item) {
            $subtotal += (float) $item['total'];
            $item_count += (int) $item['quantity'];
            $reg = !empty($item['regular_price']) ? (float)$item['regular_price'] : round(((float)$item['price'] * 1.30), 2);
            if ($reg <= (float)$item['price']) {
                $reg = round((float)$item['price'] * 1.30, 2);
            }
            $mrp_total += $reg * (int)$item['quantity'];
        }

        // Applied coupon
        $coupon = $this->session->userdata('applied_coupon');
        $discount = 0.00;
        if ($coupon && !empty($coupon['discount'])) {
            $discount = min($subtotal, (float) $coupon['discount']);
        }

        // Settings - Dynamic Shipping Charges
        $shipping_charges_raw = $this->setting_model->get('shipping_charges');
        $configured_charges = [];
        if (!empty($shipping_charges_raw)) {
            $decoded = json_decode($shipping_charges_raw, true);
            if (is_array($decoded)) {
                $configured_charges = $decoded;
            }
        }

        $flat_shipping = (float) $this->setting_model->get('shipping_flat_rate', 50.00);
        if (empty($configured_charges)) {
            $configured_charges = [
                ['name' => 'Courier Charges', 'value' => $flat_shipping]
            ];
        }

        $shipping_charges = [];
        $shipping = 0.00;
        if ($subtotal > 0) {
            foreach ($configured_charges as $c_item) {
                $c_name = trim($c_item['name'] ?? '');
                $c_val  = (float) ($c_item['value'] ?? 0);
                if ($c_name !== '') {
                    $shipping_charges[] = [
                        'name'  => $c_name,
                        'value' => $c_val
                    ];
                    $shipping += $c_val;
                }
            }
        }

        $shipping_dispatch_note = $this->setting_model->get('shipping_dispatch_note', 'Dispatched within 24-48 hours with courier tracking.');

        // Tax settings
        $tax_enabled      = (int) $this->setting_model->get('tax_enabled', 0);
        $tax_rate_percent = (float) ($this->setting_model->get('tax_rate') ?: $this->setting_model->get('tax_rate_percent', 0.00));
        $tax_inclusive    = (int) $this->setting_model->get('tax_inclusive', 0);

        // Tax calculation
        $taxable = max(0, $subtotal - $discount);
        $tax = 0.00;

        if ($tax_enabled && $tax_rate_percent > 0 && $taxable > 0) {
            if ($tax_inclusive == 1) {
                // Prices are Inclusive of Tax: tax is already included in product price
                $tax = round($taxable - ($taxable / (1 + ($tax_rate_percent / 100))), 2);
                $total = $taxable + $shipping;
            } else {
                // Prices are Exclusive of Tax: tax is calculated & added at checkout
                $tax = round(($taxable * $tax_rate_percent) / 100, 2);
                $total = $taxable + $shipping + $tax;
            }
        } else {
            $total = $taxable + $shipping;
        }

        $mrp_discount = max(0, $mrp_total - $subtotal);
        $total_savings = $mrp_discount + $discount;

        return [
            'item_count'             => $item_count,
            'subtotal'               => $subtotal,
            'mrp_total'              => $mrp_total,
            'mrp_discount'           => $mrp_discount,
            'total_savings'          => $total_savings,
            'discount'               => $discount,
            'coupon'                 => $coupon,
            'shipping'               => $shipping,
            'shipping_charges'       => $shipping_charges,
            'shipping_dispatch_note' => $shipping_dispatch_note,
            'shipping_method'        => $shipping_method,
            'shipping_flat'          => $flat_shipping,
            'tax'                    => $tax,
            'tax_enabled'            => $tax_enabled,
            'tax_inclusive'          => $tax_inclusive,
            'tax_rate_percent'       => $tax_rate_percent,
            'total'                  => $total,
            'currency_symbol'        => $this->setting_model->get('currency_symbol', '$')
        ];
    }

    // Save for Later
    public function save_for_later($cart_key)
    {
        $cart = $this->get_items();
        if (!isset($cart[$cart_key])) {
            return false;
        }

        $item = $cart[$cart_key];
        $user_id = $this->session->userdata('user_id') ?: NULL;
        $session_id = $this->session->session_id ?: session_id();

        // Insert into cart_saved_items
        $this->db->insert('cart_saved_items', [
            'user_id'    => $user_id,
            'session_id' => $session_id,
            'product_id' => $item['id'],
            'variant_id' => $item['variant_id'] ?? NULL,
            'quantity'   => $item['quantity']
        ]);

        // Remove from current cart
        unset($cart[$cart_key]);
        $this->session->set_userdata('cart', $cart);

        // Also remove from cart_items table in database if user is logged in
        if ($user_id) {
            $pid = (int) $item['id'];
            $vid = !empty($item['variant_id']) ? (int)$item['variant_id'] : 0;
            $this->db->where('user_id', (int) $user_id)
                     ->where('product_id', $pid)
                     ->where('variant_id', $vid)
                     ->delete('cart_items');
        }

        return true;
    }

    public function get_saved_items()
    {
        $user_id = $this->session->userdata('user_id') ?: NULL;
        $session_id = $this->session->session_id ?: session_id();

        $this->db->select('csi.*, p.title as product_title, p.slug as product_slug, p.main_image as product_image, p.price as product_price, p.sale_price as product_sale_price, pv.title as variant_title, pv.price as variant_price, pv.sale_price as variant_sale_price, pv.image as variant_image')
                 ->from('cart_saved_items csi')
                 ->join('products p', 'p.id = csi.product_id')
                 ->join('product_variants pv', 'pv.id = csi.variant_id', 'left');

        if ($user_id) {
            $this->db->group_start()
                     ->where('csi.user_id', $user_id)
                     ->or_where('csi.session_id', $session_id)
                     ->group_end();
        } else {
            $this->db->where('csi.session_id', $session_id);
        }

        $this->db->order_by('csi.id', 'DESC');
        $rows = $this->db->get()->result_array();
        $tax_mult = $this->product_model->get_tax_multiplier();
        if ($tax_mult > 1.0) {
            foreach ($rows as &$r) {
                if (isset($r['product_price'])) $r['product_price'] = round($r['product_price'] * $tax_mult, 2);
                if (!empty($r['product_sale_price'])) $r['product_sale_price'] = round($r['product_sale_price'] * $tax_mult, 2);
                if (isset($r['variant_price'])) $r['variant_price'] = round($r['variant_price'] * $tax_mult, 2);
                if (!empty($r['variant_sale_price'])) $r['variant_sale_price'] = round($r['variant_sale_price'] * $tax_mult, 2);
            }
        }
        return $rows;
    }

    public function move_to_cart($saved_id)
    {
        $saved = $this->db->where('id', (int) $saved_id)->get('cart_saved_items')->row_array();
        if (!$saved) {
            return false;
        }

        $res = $this->add_item($saved['product_id'], $saved['quantity'], $saved['variant_id']);
        if ($res['success']) {
            $this->db->where('id', (int) $saved_id)->delete('cart_saved_items');
            return true;
        }
        return false;
    }

    public function remove_saved_item($saved_id)
    {
        return $this->db->where('id', (int) $saved_id)->delete('cart_saved_items');
    }

    /**
     * Check if Cash on Delivery is allowed for all items in the cart.
     * If even one item has is_cod_allowed == 0, COD is disabled for the whole order.
     */
    public function check_cod_eligibility()
    {
        $items = $this->get_items();
        if (empty($items)) {
            return [
                'eligible'      => false,
                'non_cod_items' => []
            ];
        }

        $non_cod_items = [];
        foreach ($items as $item) {
            if (isset($item['is_cod_allowed']) && (int) $item['is_cod_allowed'] === 0) {
                $non_cod_items[] = $item['title'];
            }
        }

        return [
            'eligible'      => empty($non_cod_items),
            'non_cod_items' => array_values(array_unique($non_cod_items))
        ];
    }

    /**
     * Synchronize database cart_items table with session cart for a logged-in user.
     * Ensures cross-device synchronization (Mobile <-> PC).
     */
    public function sync_db_with_session($user_id, $cart)
    {
        if (empty($user_id)) {
            return $cart;
        }

        $db_rows = $this->db->where('user_id', (int) $user_id)->get('cart_items')->result_array();
        $db_map = [];
        foreach ($db_rows as $row) {
            $vid = !empty($row['variant_id']) ? (int)$row['variant_id'] : null;
            $ckey = (string) $row['product_id'] . ($vid ? '_' . $vid : '');
            $db_map[$ckey] = [
                'product_id' => (int) $row['product_id'],
                'variant_id' => $vid,
                'quantity'   => (int) $row['quantity']
            ];
        }

        $is_synced = true;
        if (count($db_map) !== count($cart)) {
            $is_synced = false;
        } else {
            foreach ($db_map as $ckey => $info) {
                if (!isset($cart[$ckey]) || (int)$cart[$ckey]['quantity'] !== (int)$info['quantity']) {
                    $is_synced = false;
                    break;
                }
            }
        }

        if (!$is_synced) {
            $new_cart = [];
            foreach ($db_map as $ckey => $info) {
                if (isset($cart[$ckey])) {
                    $item = $cart[$ckey];
                    $item['quantity'] = $info['quantity'];
                    $item['total'] = round((float)$item['price'] * $info['quantity'], 2);
                    $new_cart[$ckey] = $item;
                } else {
                    $built = $this->build_item_data($info['product_id'], $info['quantity'], $info['variant_id']);
                    if ($built) {
                        $new_cart[$ckey] = $built;
                    } else {
                        $this->db->where('user_id', (int)$user_id)
                                 ->where('product_id', (int)$info['product_id'])
                                 ->where('variant_id', !empty($info['variant_id']) ? (int)$info['variant_id'] : 0)
                                 ->delete('cart_items');
                    }
                }
            }
            $cart = $new_cart;
            $this->session->set_userdata('cart', $cart);
        }

        return $cart;
    }

    /**
     * Merge guest session cart into database when user logs in or registers.
     */
    public function sync_session_to_db($user_id)
    {
        if (empty($user_id)) {
            return;
        }

        $session_cart = $this->session->userdata('cart');
        if (!empty($session_cart) && is_array($session_cart)) {
            foreach ($session_cart as $ckey => $item) {
                $pid = (int) $item['id'];
                $vid = !empty($item['variant_id']) ? (int) $item['variant_id'] : 0;
                $qty = max(1, (int) $item['quantity']);

                $existing = $this->db->where('user_id', (int) $user_id)
                                     ->where('product_id', $pid)
                                     ->where('variant_id', $vid)
                                     ->get('cart_items')
                                     ->row_array();
                if ($existing) {
                    $max_limit = !empty($item['stock_max']) ? (int)$item['stock_max'] : 999;
                    $merged_qty = min($max_limit, (int)$existing['quantity'] + $qty);
                    $this->db->where('id', $existing['id'])->update('cart_items', [
                        'quantity'   => $merged_qty,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    $this->db->insert('cart_items', [
                        'user_id'    => (int) $user_id,
                        'product_id' => $pid,
                        'variant_id' => $vid,
                        'quantity'   => $qty,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Also associate any saved_for_later items from session_id to user_id
        $sess_id = $this->session->session_id ?: session_id();
        if ($sess_id) {
            $this->db->where('session_id', $sess_id)
                     ->where('user_id IS NULL', null, false)
                     ->update('cart_saved_items', ['user_id' => (int) $user_id]);
        }

        // Refresh session from database
        $this->get_items();
    }

    /**
     * Build standard cart item structure from product and variant IDs.
     */
    public function build_item_data($product_id, $quantity = 1, $variant_id = NULL)
    {
        $product = $this->product_model->get_by_id($product_id);
        if (!$product) {
            return NULL;
        }

        $variant = NULL;
        if (!empty($variant_id)) {
            $variant = $this->product_model->get_variant_by_id($variant_id);
            if (!$variant || $variant['product_id'] != $product_id) {
                $variant = NULL;
                $variant_id = NULL;
            }
        }

        $cart_key = $product_id . ($variant ? '_' . $variant['id'] : '');

        $available_stock = $variant ? (int) $variant['stock_quantity'] : (int) $product['stock_quantity'];
        $max_limit = !empty($product['max_purchase_quantity']) ? (int) $product['max_purchase_quantity'] : 999;
        if ($max_limit > 0) {
            $available_stock = min($available_stock, $max_limit);
        }
        $target_qty = min($quantity, max(1, $available_stock));

        if ($variant) {
            $base_p = (!empty($variant['base_sale_price']) && (float)$variant['base_sale_price'] > 0) ? (float)$variant['base_sale_price'] : ((isset($variant['base_price']) && is_numeric($variant['base_price'])) ? (float)$variant['base_price'] : (!empty($variant['sale_price']) ? (float)$variant['sale_price'] : (float)$variant['price']));
            $base_reg = (isset($variant['base_price']) && is_numeric($variant['base_price'])) ? (float)$variant['base_price'] : (!empty($variant['price']) ? (float)$variant['price'] : round($base_p * 1.30, 2));
            $price = !empty($variant['sale_price']) ? (float) $variant['sale_price'] : (float) $variant['price'];
            $regular_price = !empty($variant['price']) ? (float) $variant['price'] : round($price * 1.30, 2);
            $image = !empty($variant['image']) ? $variant['image'] : $product['main_image'];
            $sku   = !empty($variant['sku']) ? $variant['sku'] : $product['sku'];
        } else {
            $base_p = (!empty($product['base_sale_price']) && (float)$product['base_sale_price'] > 0) ? (float)$product['base_sale_price'] : ((isset($product['base_price']) && is_numeric($product['base_price'])) ? (float)$product['base_price'] : (!empty($product['sale_price']) ? (float)$product['sale_price'] : (float)$product['price']));
            $base_reg = (isset($product['base_price']) && is_numeric($product['base_price'])) ? (float)$product['base_price'] : (!empty($product['price']) ? (float)$product['price'] : round($base_p * 1.30, 2));
            $price = !empty($product['sale_price']) ? (float) $product['sale_price'] : (float) $product['price'];
            $regular_price = !empty($product['price']) ? (float) $product['price'] : round($price * 1.30, 2);
            $image = $product['main_image'];
            $sku   = $product['sku'];
        }
        if ($regular_price <= $price) {
            $regular_price = round($price * 1.30, 2);
        }
        if ($base_reg <= $base_p) {
            $base_reg = round($base_p * 1.30, 2);
        }
        $disc_pct = ($regular_price > $price) ? round((($regular_price - $price) / $regular_price) * 100) : 0;

        $item_size = '';
        $item_color = '';
        if ($variant && !empty($variant['values'])) {
            foreach ($variant['values'] as $vval) {
                $aslug = strtolower($vval['attribute_slug'] ?? ($vval['attribute_name'] ?? ''));
                if ($aslug === 'size' && empty($item_size)) {
                    $item_size = $vval['attribute_value'];
                } elseif ($aslug === 'color' && empty($item_color)) {
                    $item_color = $vval['attribute_value'];
                }
            }
        }

        if ($variant && (empty($item_size) || empty($item_color)) && !empty($variant['title'])) {
            $opt_str = $variant['title'];
            if (strpos($opt_str, '-') !== false) {
                $dash_parts = explode('-', $opt_str);
                $opt_str = trim(end($dash_parts));
            }
            if (strpos($opt_str, '/') !== false) {
                $parts = array_map('trim', explode('/', $opt_str));
                $sizes_known = ['xs', 's', 'm', 'l', 'xl', 'xxl', 'xxxl', '28', '30', '32', '34', '36', '38', '40', '42'];
                foreach ($parts as $p) {
                    if (in_array(strtolower($p), $sizes_known)) {
                        if (empty($item_size)) $item_size = $p;
                    } else {
                        if (empty($item_color)) $item_color = $p;
                    }
                }
            } else {
                if (empty($item_size)) $item_size = $opt_str;
            }
        }

        $p_info = $this->db->select('b.name as brand_name, p.max_purchase_quantity, p.stock_quantity, p.is_cod_allowed, p.rating, p.reviews_count, p.short_description')
                           ->from('products p')
                           ->join('brands b', 'b.id = p.brand_id', 'left')
                           ->where('p.id', (int) $product['id'])
                           ->get()
                           ->row_array();

        return [
            'cart_key'           => $cart_key,
            'id'                 => (int) $product['id'],
            'variant_id'         => $variant ? (int) $variant['id'] : NULL,
            'variant_title'      => $variant ? $variant['title'] : NULL,
            'size'               => $item_size,
            'color'              => $item_color,
            'brand_name'         => !empty($p_info['brand_name']) ? $p_info['brand_name'] : (!empty($product['brand_name']) ? $product['brand_name'] : 'VTEXX'),
            'title'              => $product['title'],
            'slug'               => $product['slug'],
            'sku'                => $sku,
            'image'              => $image,
            'base_price'         => (float) $base_p,
            'base_regular_price' => (float) $base_reg,
            'price'              => (float) $price,
            'regular_price'      => (float) $regular_price,
            'discount_percent'   => $disc_pct,
            'quantity'           => $target_qty,
            'total'              => (float) ($price * $target_qty),
            'stock_max'          => $available_stock,
            'is_cod_allowed'     => isset($p_info['is_cod_allowed']) ? (int) $p_info['is_cod_allowed'] : 1,
            'short_description'  => !empty($p_info['short_description']) ? $p_info['short_description'] : ''
        ];
    }
}
