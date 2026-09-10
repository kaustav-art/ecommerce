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
        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) {
            return [];
        }
        foreach ($cart as $k => &$item) {
            if (empty($item['regular_price']) || $item['regular_price'] <= $item['price']) {
                $item['regular_price'] = round($item['price'] * 1.30, 2);
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

            // Ensure brand_name and max_purchase_quantity
            if (!empty($item['id'])) {
                $p_info = $this->db->select('b.name as brand_name, p.max_purchase_quantity, p.stock_quantity')
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
            }
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
            $price = !empty($variant['sale_price']) ? (float) $variant['sale_price'] : (float) $variant['price'];
            $regular_price = !empty($variant['price']) ? (float) $variant['price'] : round($price * 1.30, 2);
            $image = !empty($variant['image']) ? $variant['image'] : $product['main_image'];
            $sku   = !empty($variant['sku']) ? $variant['sku'] : $product['sku'];
        } else {
            $price = !empty($product['sale_price']) ? (float) $product['sale_price'] : (float) $product['price'];
            $regular_price = !empty($product['price']) ? (float) $product['price'] : round($price * 1.30, 2);
            $image = $product['main_image'];
            $sku   = $product['sku'];
        }
        if ($regular_price <= $price) {
            $regular_price = round($price * 1.30, 2);
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
            'cart_key'         => $cart_key,
            'id'               => (int) $product['id'],
            'variant_id'       => $variant ? (int) $variant['id'] : NULL,
            'variant_title'    => $variant ? $variant['title'] : NULL,
            'size'             => $item_size,
            'color'            => $item_color,
            'brand_name'       => !empty($product['brand_name']) ? $product['brand_name'] : 'VTEXX',
            'title'            => $product['title'],
            'slug'             => $product['slug'],
            'sku'              => $sku,
            'image'            => $image,
            'price'            => (float) $price,
            'regular_price'    => (float) $regular_price,
            'discount_percent' => $disc_pct,
            'quantity'         => $target_qty,
            'total'            => (float) ($price * $target_qty),
            'stock_max'        => $available_stock
        ];

        $this->session->set_userdata('cart', $cart);
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
            unset($cart[$cart_key]);
            $this->session->set_userdata('cart', $cart);
        }
        $summary = $this->get_cart_summary();
        return ['success' => true, 'cart_count' => $summary['item_count'], 'cart_summary' => $summary];
    }

    public function clear_cart()
    {
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

        // Settings
        $flat_shipping    = (float) $this->setting_model->get('shipping_flat_rate', 15.00);
        $free_threshold   = (float) ($this->setting_model->get('free_shipping_min') ?: $this->setting_model->get('shipping_free_threshold', 150.00));
        $express_shipping = (float) $this->setting_model->get('shipping_express_rate', 25.00);
        $tax_rate_percent = (float) ($this->setting_model->get('tax_rate_percent') ?: $this->setting_model->get('tax_rate', 5.00));

        // Shipping fee calculation
        if ($subtotal == 0) {
            $shipping = 0.00;
        } elseif ($shipping_method === 'express') {
            $shipping = $express_shipping;
        } else {
            $shipping = ($subtotal >= $free_threshold) ? 0.00 : $flat_shipping;
        }

        // Tax calculation
        $taxable = max(0, $subtotal - $discount);
        $tax = round(($taxable * $tax_rate_percent) / 100, 2);

        // Total
        $total = $taxable + $shipping + $tax;

        $mrp_discount = max(0, $mrp_total - $subtotal);
        $total_savings = $mrp_discount + $discount;

        return [
            'item_count'          => $item_count,
            'subtotal'            => $subtotal,
            'mrp_total'           => $mrp_total,
            'mrp_discount'        => $mrp_discount,
            'total_savings'       => $total_savings,
            'discount'            => $discount,
            'coupon'              => $coupon,
            'shipping'            => $shipping,
            'shipping_method'     => $shipping_method,
            'shipping_flat'       => $flat_shipping,
            'shipping_free_min'   => $free_threshold,
            'shipping_express'    => $express_shipping,
            'tax'                 => $tax,
            'tax_rate_percent'    => $tax_rate_percent,
            'total'               => $total,
            'currency_symbol'     => $this->setting_model->get('currency_symbol', '$')
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
        return $this->db->get()->result_array();
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
}
