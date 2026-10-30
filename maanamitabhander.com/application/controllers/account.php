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
        $this->load->model('user_model');
    }

    /**
     * Resolve active user from session/DB when logged in, or fallback to demo user
     */
    protected function _get_account_user()
    {
        if ($this->is_logged_in() && !empty($this->current_user)) {
            if (!empty($this->current_user['id'])) {
                $db_user = $this->user_model->get_by_id((int) $this->current_user['id']);
                if ($db_user) {
                    return $db_user;
                }
            }
            return $this->current_user;
        }
        return Static_template_data::get('user');
    }

    public function index()
    {
        redirect('account/profile');
    }

    public function profile()
    {
        $user = $this->_get_account_user();

        if ($this->input->method() === 'post') {
            if ($this->is_logged_in() && !empty($user['id'])) {
                $update_data = [
                    'first_name' => trim((string) $this->input->post('first_name', TRUE)),
                    'last_name'  => trim((string) $this->input->post('last_name', TRUE)),
                    'email'      => trim((string) $this->input->post('email', TRUE)),
                    'phone'      => trim((string) $this->input->post('phone', TRUE)),
                    'gender'     => trim((string) $this->input->post('gender', TRUE)),
                ];
                $this->user_model->update((int) $user['id'], $update_data);
                $fresh_user = $this->user_model->get_by_id((int) $user['id']);
                if ($fresh_user) {
                    unset($fresh_user['password']);
                    $this->session->set_userdata('user_data', $fresh_user);
                }
                $this->session->set_flashdata('success', 'Profile details updated successfully.');
            } else {
                $this->session->set_flashdata('success', 'Profile details updated (Template Demo Mode).');
            }
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
        $user   = $this->_get_account_user();
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
        $user  = $this->_get_account_user();
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
        $user          = $this->_get_account_user();
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
        $user = $this->_get_account_user();

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
        $user      = $this->_get_account_user();
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
        if (!$this->is_logged_in() || empty($this->current_user['id'])) {
            $this->session->set_flashdata('error', 'Please login first to view your wishlist.');
            redirect('auth/login?redirect=' . urlencode('wishlist'));
            return;
        }

        $user     = $this->_get_account_user();
        $this->load->model('wishlist_model');
        $wishlist = $this->wishlist_model->get_by_user((int)$this->current_user['id']);

        $data = [
            'title'              => 'My Wishlist - ' . $this->site_name,
            'active_page'        => 'wishlist',
            'active_account_tab' => 'wishlist',
            'user'               => $user,
            'wishlist'           => $wishlist
        ];

        $this->render('account/wishlist', $data);
    }

    public function wishlist_toggle($product_id = null)
    {
        if ($product_id === null) {
            $product_id = $this->input->post('product_id') ?: $this->input->get('product_id');
        }
        $product_id = (int) $product_id;

        if ($product_id <= 0) {
            if ($this->input->is_ajax_request()) {
                $this->json_response(['success' => false, 'status' => 'error', 'message' => 'Invalid product.']);
                return;
            }
            redirect($_SERVER['HTTP_REFERER'] ?? 'wishlist');
            return;
        }

        // Support guest wishlist when not logged in
        if (!$this->is_logged_in() || empty($this->current_user['id'])) {
            $sess_key = 'guest_wishlist_t_' . $this->tenant_id;
            $guest_wl = $this->session->userdata($sess_key);
            if (!is_array($guest_wl)) {
                $guest_wl = [];
                if (isset($_COOKIE['guest_wishlist'])) {
                    $c_arr = json_decode($_COOKIE['guest_wishlist'], true);
                    if (is_array($c_arr)) $guest_wl = $c_arr;
                }
            }
            $guest_wl = array_values(array_map('intval', array_filter($guest_wl)));

            if (in_array($product_id, $guest_wl, true)) {
                $guest_wl = array_values(array_diff($guest_wl, [$product_id]));
                $status = 'removed';
                $is_wishlisted = false;
                $msg = 'Removed from your wishlist.';
            } else {
                $guest_wl[] = $product_id;
                $status = 'added';
                $is_wishlisted = true;
                $msg = 'Added to your wishlist!';
            }

            $this->session->set_userdata($sess_key, $guest_wl);
            setcookie('guest_wishlist', json_encode($guest_wl), time() + (86400 * 30), '/');
            $wishlist_count = count($guest_wl);

            if ($this->input->is_ajax_request()) {
                $this->json_response([
                    'success'        => true,
                    'status'         => 'success',
                    'action'         => $status,
                    'is_wishlisted'  => $is_wishlisted,
                    'wishlist_count' => $wishlist_count,
                    'product_id'     => $product_id,
                    'message'        => $msg
                ]);
                return;
            }

            $this->session->set_flashdata('success', $msg);
            redirect($_SERVER['HTTP_REFERER'] ?? 'home');
            return;
        }

        $user_id = (int) $this->current_user['id'];
        $this->load->model('wishlist_model');
        $status  = $this->wishlist_model->toggle($user_id, $product_id);

        $wishlist_count = (int) $this->db->where('tenant_id', $this->tenant_id)
                                         ->where('user_id', $user_id)
                                         ->count_all_results('wishlists');

        $is_wishlisted = ($status === 'added');
        $msg = $is_wishlisted ? 'Added to your wishlist!' : 'Removed from your wishlist.';

        if ($this->input->is_ajax_request()) {
            $this->json_response([
                'success'        => true,
                'status'         => 'success',
                'action'         => $status,
                'is_wishlisted'  => $is_wishlisted,
                'wishlist_count' => $wishlist_count,
                'product_id'     => $product_id,
                'message'        => $msg
            ]);
            return;
        }

        $this->session->set_flashdata('success', $msg);
        redirect($_SERVER['HTTP_REFERER'] ?? 'wishlist');
    }

    public function notifications()
    {
        $user          = $this->_get_account_user();
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
