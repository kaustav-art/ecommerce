<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cart_model');
    }

    public function index()
    {
        $shipping_method = $this->session->userdata('shipping_method') ?: 'standard';

        $data = [
            'title'        => 'Shopping Cart - Modave',
            'active_page'  => 'cart',
            'cart_items'   => $this->cart_model->get_items(),
            'saved_items'  => $this->cart_model->get_saved_items(),
            'cart_summary' => $this->cart_model->get_cart_summary($shipping_method)
        ];

        $this->render('cart/index', $data);
    }

    public function add()
    {
        $product_id = (int) $this->input->post('product_id');
        $quantity   = max(1, (int) $this->input->post('quantity'));
        $variant_id = $this->input->post('variant_id') ? (int) $this->input->post('variant_id') : NULL;

        $result = $this->cart_model->add_item($product_id, $quantity, $variant_id);

        if ($this->input->is_ajax_request()) {
            $this->json_response($result);
        } else {
            if ($result['success']) {
                $this->session->set_flashdata('success', $result['message']);
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            redirect('cart');
        }
    }

    public function add_bundle()
    {
        $product_ids = $this->input->post('product_ids');
        if (empty($product_ids) || !is_array($product_ids)) {
            $this->session->set_flashdata('error', 'No bundle products selected.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'shop');
        }

        $added_count = 0;
        foreach ($product_ids as $pid) {
            $int_pid = (int) $pid;
            if ($int_pid > 0) {
                $res = $this->cart_model->add_item($int_pid, 1);
                if ($res['success']) {
                    $added_count++;
                }
            }
        }

        if ($added_count > 0) {
            $this->session->set_flashdata('success', "Added {$added_count} bundle items to your shopping cart!");
        } else {
            $this->session->set_flashdata('error', 'Could not add selected items.');
        }

        redirect('cart');
    }

    public function update()
    {
        $cart_key = $this->input->post('cart_key', TRUE) ?: (string) $this->input->post('product_id');
        $quantity = (int) $this->input->post('quantity');

        $result = $this->cart_model->update_item($cart_key, $quantity);

        if ($this->input->is_ajax_request()) {
            $this->json_response($result);
        } else {
            redirect('cart');
        }
    }

    public function remove($cart_key)
    {
        $cart_key = urldecode($cart_key);
        $this->cart_model->remove_item($cart_key);
        $this->session->set_flashdata('success', 'Item removed from shopping cart.');
        redirect('cart');
    }

    public function save_for_later($cart_key)
    {
        $cart_key = urldecode($cart_key);
        $success = $this->cart_model->save_for_later($cart_key);

        if ($success) {
            $this->session->set_flashdata('success', 'Item moved to Saved for Later.');
        } else {
            $this->session->set_flashdata('error', 'Item could not be saved.');
        }
        redirect('cart');
    }

    public function move_to_cart($saved_id)
    {
        $success = $this->cart_model->move_to_cart($saved_id);

        if ($success) {
            $this->session->set_flashdata('success', 'Item moved back to your cart.');
        } else {
            $this->session->set_flashdata('error', 'Item could not be moved back to cart (check stock availability).');
        }
        redirect('cart');
    }

    public function remove_saved($saved_id)
    {
        $this->cart_model->remove_saved_item($saved_id);
        $this->session->set_flashdata('success', 'Saved item removed.');
        redirect('cart');
    }

    public function clear()
    {
        $this->cart_model->clear_cart();
        redirect('cart');
    }

    public function set_shipping_method()
    {
        $method = $this->input->post('shipping_method', TRUE);
        if (in_array($method, ['standard', 'express'])) {
            $this->session->set_userdata('shipping_method', $method);
        }

        if ($this->input->is_ajax_request()) {
            $summary = $this->cart_model->get_cart_summary($method);
            $this->json_response(['success' => true, 'cart_summary' => $summary]);
        } else {
            redirect($_SERVER['HTTP_REFERER'] ?? 'cart');
        }
    }

    public function apply_coupon()
    {
        $code = $this->input->post('coupon_code', TRUE);
        $res  = $this->cart_model->apply_coupon($code);

        if ($res['success']) {
            $this->session->set_flashdata('success', $res['message']);
        } else {
            $this->session->set_flashdata('error', $res['message']);
        }
        redirect('cart');
    }

    public function remove_coupon()
    {
        $this->cart_model->remove_coupon();
        $this->session->set_flashdata('success', 'Coupon removed.');
        redirect('cart');
    }
}
