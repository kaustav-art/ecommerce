<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Account Controller
 * Operates 100% statically using Static_template_data.
 * Provides a single common Order Details page (`account/order/<any>`) and all after-login dropdown pages.
 */
class account extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('account/profile');
    }

    public function profile()
    {
        $user = Static_template_data::get('user');

        if ($this->input->method() === 'post') {
            $this->session->set_flashdata('success', 'Profile details updated (Template Demo Mode).');
            redirect('account/profile');
            return;
        }

        $data = [
            'title'              => 'My Profile - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'profile',
            'user'               => $user
        ];

        $this->render('account/profile', $data);
    }

    public function orders()
    {
        $user   = Static_template_data::get('user');
        $orders = Static_template_data::get('orders');

        $data = [
            'title'              => 'My Orders - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'orders',
            'user'               => $user,
            'orders'             => $orders
        ];

        $this->render('account/orders', $data);
    }

    public function order_detail($order_number = 'ORD-2026-88412')
    {
        // Always render the single Common Order Details page regardless of order_number
        $user  = Static_template_data::get('user');
        $order = Static_template_data::get('common_order');

        $data = [
            'title'              => 'Order Details #' . $order['order_number'] . ' - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'orders',
            'user'               => $user,
            'order'              => $order,
            'user_reviews'       => []
        ];

        $this->render('account/order_detail', $data);
    }

    public function rate_review($order_number = 'ORD-2026-88412', $product_id = null)
    {
        $user          = Static_template_data::get('user');
        $order         = Static_template_data::get('common_order');
        $items         = $order['items'] ?? [];
        $selected_item = $items[0] ?? [];
        $product       = Static_template_data::get('common_product');

        if ($this->input->method() === 'post') {
            $this->session->set_flashdata('success', 'Thank you! Your rating and review have been submitted (Template Demo Mode).');
            redirect('account/order/' . $order['order_number']);
            return;
        }

        $data = [
            'title'           => 'Rate & Review - ' . ($selected_item['product_title'] ?? $product['title']) . ' - ' . $this->site_name,
            'active_page'     => 'account',
            'order'           => $order,
            'item'            => $selected_item,
            'product'         => $product,
            'existing_review' => NULL,
            'prefill_rating'  => (int) ($this->input->get('rating') ?: 5),
            'user'            => $user
        ];

        $this->render('account/rate_review', $data);
    }

    public function quick_rate()
    {
        $rating = (int) ($this->input->post('rating') ?: 5);
        echo json_encode([
            'success' => true,
            'message' => 'Rating saved (Template Demo Mode)!',
            'rating'  => $rating
        ]);
    }

    public function cancel_order($order_number = 'ORD-2026-88412')
    {
        $this->session->set_flashdata('success', 'Order cancellation requested (Template Demo Mode).');
        redirect('account/order/' . $order_number);
    }

    public function invoice($order_number = 'ORD-2026-88412')
    {
        $order = Static_template_data::get('common_order');
        $data = [
            'title'          => 'Invoice #' . $order['order_number'],
            'order'          => $order,
            'store_settings' => $this->store_settings
        ];
        $this->load->view('template1/order/invoice', $data);
    }

    public function returns()
    {
        $user = Static_template_data::get('user');

        $data = [
            'title'              => 'Return & Refund Requests - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'returns',
            'user'               => $user,
            'returns'            => []
        ];

        $this->render('account/returns', $data);
    }

    public function request_return($order_number = 'ORD-2026-88412')
    {
        $this->session->set_flashdata('success', 'Your return / refund request has been submitted (Template Demo Mode).');
        redirect('account/returns');
    }

    public function address()
    {
        $user      = Static_template_data::get('user');
        $addresses = Static_template_data::get('addresses');

        if ($this->input->method() === 'post') {
            if ($this->input->is_ajax_request()) {
                $this->json_response(['status' => 'success', 'message' => 'Address saved (Template Demo Mode).', 'id' => 1]);
                return;
            }
            $this->session->set_flashdata('success', 'Address saved (Template Demo Mode).');
            redirect('account/address');
            return;
        }

        $data = [
            'title'              => 'Manage Addresses - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'address',
            'user'               => $user,
            'addresses'          => $addresses
        ];

        $this->render('account/address', $data);
    }

    public function get_address_ajax($id = 1)
    {
        $addresses = Static_template_data::get('addresses');
        $matched   = $addresses[0] ?? NULL;
        foreach ($addresses as $addr) {
            if ((int)$addr['id'] === (int)$id) {
                $matched = $addr;
                break;
            }
        }
        $this->json_response(['status' => 'success', 'address' => $matched]);
    }

    public function delete_address($id = 1)
    {
        $this->session->set_flashdata('success', 'Address removed (Template Demo Mode).');
        redirect('account/address');
    }

    public function wishlist()
    {
        $user     = Static_template_data::get('user');
        $products = Static_template_data::get('products');
        $wishlist = array_slice($products, 0, 4);

        $data = [
            'title'              => 'My Wishlist - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'wishlist',
            'user'               => $user,
            'wishlist'           => $wishlist
        ];

        $this->render('account/wishlist', $data);
    }

    public function wishlist_toggle($product_id = 1)
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'action' => 'added']);
            return;
        }
        $this->session->set_flashdata('success', 'Product added to your wishlist (Template Demo Mode).');
        redirect($_SERVER['HTTP_REFERER'] ?? 'account/wishlist');
    }

    public function notifications()
    {
        $user          = Static_template_data::get('user');
        $notifications = Static_template_data::get('notifications');

        $data = [
            'title'              => 'Notifications - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'notifications',
            'user'               => $user,
            'notifications'      => $notifications
        ];

        $this->render('account/notifications', $data);
    }
}
