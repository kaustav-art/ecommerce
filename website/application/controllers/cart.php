<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $all_products = Static_template_data::get('products');
        $cart_items   = Static_template_data::get('cart_items');
        $cart_summary = Static_template_data::get('cart_summary');

        $data = [
            'title'                    => 'Shopping Cart - ' . $this->site_name,
            'active_page'              => 'cart',
            'cart_items'               => $cart_items,
            'saved_items'              => [],
            'cart_summary'             => $cart_summary,
            'cart_recommendations'     => array_slice($all_products, 0, 8),
            'recently_viewed_products' => array_slice($all_products, 0, 6),
            'wishlist_items'           => array_slice($all_products, 2, 4)
        ];

        $this->render('cart/index', $data);
    }

    public function add()
    {
        $cart_items   = Static_template_data::get('cart_items');
        $cart_summary = Static_template_data::get('cart_summary');
        $result = [
            'success'      => true,
            'message'      => 'Item added to cart (Template Demo Mode).',
            'cart_count'   => $cart_summary['item_count'],
            'cart_summary' => $cart_summary,
            'cart_items'   => array_values($cart_items)
        ];

        if ($this->input->is_ajax_request()) {
            $this->json_response($result);
        } else {
            $this->session->set_flashdata('success', $result['message']);
            redirect('cart');
        }
    }

    public function data()
    {
        $cart_items   = Static_template_data::get('cart_items');
        $cart_summary = Static_template_data::get('cart_summary');
        $this->json_response([
            'success'      => true,
            'cart_count'   => $cart_summary['item_count'],
            'cart_summary' => $cart_summary,
            'cart_items'   => array_values($cart_items)
        ]);
    }

    public function add_bundle()
    {
        $this->session->set_flashdata('success', 'Bundle items added to your shopping cart (Template Demo Mode)!');
        redirect('cart');
    }

    public function update()
    {
        $cart_key     = $this->input->post('cart_key', TRUE) ?: (string) $this->input->post('product_id');
        $cart_items   = Static_template_data::get('cart_items');
        $cart_summary = Static_template_data::get('cart_summary');
        $item         = $cart_items[$cart_key] ?? reset($cart_items);

        $result = [
            'success'            => true,
            'message'            => 'Cart updated.',
            'cart_count'         => $cart_summary['item_count'],
            'cart_summary'       => $cart_summary,
            'cart_items'         => array_values($cart_items),
            'item_total'         => (float) ($item['total'] ?? 0.00),
            'item_price'         => (float) ($item['price'] ?? 0.00),
            'item_regular_price' => (float) ($item['regular_price'] ?? 0.00),
            'item_quantity'      => (int) ($item['quantity'] ?? 1)
        ];

        $is_ajax = $this->input->is_ajax_request()
            || !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            || strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;

        if ($is_ajax) {
            $this->json_response($result);
        } else {
            redirect('cart');
        }
    }

    public function remove($cart_key = '')
    {
        $cart_items   = Static_template_data::get('cart_items');
        $cart_summary = Static_template_data::get('cart_summary');
        if ($this->input->is_ajax_request()) {
            $this->json_response([
                'success'      => true,
                'message'      => 'Item removed from shopping cart (Template Demo Mode).',
                'cart_count'   => $cart_summary['item_count'],
                'cart_summary' => $cart_summary,
                'cart_items'   => array_values($cart_items)
            ]);
        } else {
            $this->session->set_flashdata('success', 'Item removed from shopping cart (Template Demo Mode).');
            redirect('cart');
        }
    }

    public function move_to_wishlist()
    {
        $cart_items   = Static_template_data::get('cart_items');
        $cart_summary = Static_template_data::get('cart_summary');
        if ($this->input->is_ajax_request()) {
            $this->json_response([
                'success'      => true,
                'message'      => 'Item moved to your wishlist (Template Demo Mode).',
                'cart_count'   => $cart_summary['item_count'],
                'cart_summary' => $cart_summary,
                'cart_items'   => array_values($cart_items)
            ]);
        } else {
            $this->session->set_flashdata('success', 'Item moved to your wishlist (Template Demo Mode).');
            redirect('cart');
        }
    }

    public function save_for_later($cart_key = '')
    {
        $this->session->set_flashdata('success', 'Item moved to Saved for Later (Template Demo Mode).');
        redirect('cart');
    }

    public function move_to_cart($saved_id = '')
    {
        $this->session->set_flashdata('success', 'Item moved back to your cart.');
        redirect('cart');
    }

    public function remove_saved($saved_id = '')
    {
        $this->session->set_flashdata('success', 'Saved item removed.');
        redirect('cart');
    }

    public function clear()
    {
        redirect('cart');
    }

    public function set_shipping_method()
    {
        $cart_summary = Static_template_data::get('cart_summary');
        if ($this->input->is_ajax_request()) {
            $this->json_response(['success' => true, 'cart_summary' => $cart_summary]);
        } else {
            redirect($_SERVER['HTTP_REFERER'] ?? 'cart');
        }
    }

    public function apply_coupon()
    {
        $this->session->set_flashdata('success', 'Coupon applied (Template Demo Mode).');
        redirect('cart');
    }

    public function remove_coupon()
    {
        $this->session->set_flashdata('success', 'Coupon removed.');
        redirect('cart');
    }
}
