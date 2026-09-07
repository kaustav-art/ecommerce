<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class account extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->model('user_model');
        $this->load->model('order_model');
        $this->load->model('wishlist_model');
        $this->load->model('notification_model');
    }

    public function index()
    {
        // "there is no dashboard after user login" -> redirect to profile
        redirect('account/profile');
    }

    public function profile()
    {
        $user_id = $this->current_user['id'];
        $user    = $this->user_model->get_by_id($user_id);

        if ($this->input->method() === 'post') {
            $action = $this->input->post('action');

            if ($action === 'change_password') {
                $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
                $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]|trim');
                $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]|trim');

                if ($this->form_validation->run() === TRUE) {
                    $cur_pass = $this->input->post('current_password');
                    $new_pass = $this->input->post('new_password');

                    if (password_verify($cur_pass, $user['password'])) {
                        $this->user_model->update($user_id, [
                            'password' => password_hash($new_pass, PASSWORD_BCRYPT)
                        ]);
                        $this->session->set_flashdata('success', 'Your password has been changed successfully.');
                    } else {
                        $this->session->set_flashdata('error', 'The current password you entered is incorrect.');
                    }
                    redirect('account/profile');
                } else {
                    $this->session->set_flashdata('error', validation_errors());
                    redirect('account/profile');
                }
            } else {
                // Update profile info
                $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
                $this->form_validation->set_rules('phone', 'Phone', 'trim');

                if ($this->form_validation->run() === TRUE) {
                    $update_data = [
                        'first_name' => $this->input->post('first_name', TRUE),
                        'last_name'  => $this->input->post('last_name', TRUE),
                        'phone'      => $this->input->post('phone', TRUE)
                    ];

                    $this->user_model->update($user_id, $update_data);

                    $this->session->set_userdata([
                        'user_first_name' => $update_data['first_name'],
                        'user_last_name'  => $update_data['last_name'],
                        'user_phone'      => $update_data['phone']
                    ]);

                    $this->session->set_flashdata('success', 'Profile details updated successfully.');
                    redirect('account/profile');
                } else {
                    $this->session->set_flashdata('error', validation_errors());
                    redirect('account/profile');
                }
            }
        }

        $data = [
            'title'               => 'My Profile - ' . ($this->store_settings['site_name'] ?? 'Modave'),
            'active_page'         => 'account',
            'active_account_tab'  => 'profile',
            'user'                => $user
        ];

        $this->render('account/profile', $data);
    }

    public function orders()
    {
        $user_id = $this->current_user['id'];
        $orders  = $this->order_model->get_by_user_id($user_id);

        $data = [
            'title'              => 'My Orders - ' . ($this->store_settings['site_name'] ?? 'Modave'),
            'active_page'        => 'account',
            'active_account_tab' => 'orders',
            'user'               => $this->user_model->get_by_id($user_id),
            'orders'             => $orders
        ];

        $this->render('account/orders', $data);
    }

    public function order_detail($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order || $order['user_id'] != $this->current_user['id']) {
            show_404();
        }

        $data = [
            'title'              => 'Order Details #' . $order_number . ' - ' . ($this->store_settings['site_name'] ?? 'Modave'),
            'active_page'        => 'account',
            'active_account_tab' => 'orders',
            'user'               => $this->user_model->get_by_id($this->current_user['id']),
            'order'              => $order
        ];

        $this->render('account/order_detail', $data);
    }

    public function cancel_order($order_number)
    {
        $res = $this->order_model->cancel_order($order_number, $this->current_user['id']);
        if ($res['success']) {
            $this->session->set_flashdata('success', $res['message']);
        } else {
            $this->session->set_flashdata('error', $res['message']);
        }
        redirect('account/order/' . $order_number);
    }

    public function invoice($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order || ($order['user_id'] && $order['user_id'] != $this->current_user['id'])) {
            show_404();
        }

        $data = [
            'title'          => 'Invoice #' . $order_number,
            'order'          => $order,
            'store_settings' => $this->store_settings
        ];
        $this->load->view('order/invoice', $data);
    }

    public function returns()
    {
        $user_id = $this->current_user['id'];
        $returns = $this->order_model->get_returns_by_user($user_id);

        $data = [
            'title'              => 'Return & Refund Requests - ' . ($this->store_settings['site_name'] ?? 'Modave'),
            'active_page'        => 'account',
            'active_account_tab' => 'returns',
            'user'               => $this->user_model->get_by_id($user_id),
            'returns'            => $returns
        ];

        $this->render('account/returns', $data);
    }

    public function request_return($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order || $order['user_id'] != $this->current_user['id']) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('type', 'Request Type', 'required|in_list[return,replacement,refund]');
            $this->form_validation->set_rules('reason', 'Reason', 'required|min_length[5]|trim');

            if ($this->form_validation->run() === TRUE) {
                $this->order_model->create_return([
                    'order_id' => $order['id'],
                    'user_id'  => $this->current_user['id'],
                    'type'     => $this->input->post('type', TRUE),
                    'reason'   => $this->input->post('reason', TRUE),
                    'amount'   => (float) $this->input->post('amount') ?: (float) $order['total_amount'],
                    'status'   => 'pending'
                ]);

                $this->session->set_flashdata('success', 'Your return / refund request has been submitted and is under review.');
                redirect('account/returns');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        redirect('account/order/' . $order_number);
    }

    public function address()
    {
        $user_id = $this->current_user['id'];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('address_1', 'Street Address', 'required|trim');
            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('state', 'State', 'required|trim');
            $this->form_validation->set_rules('postcode', 'Postal Code', 'required|trim');
            $this->form_validation->set_rules('country', 'Country', 'required|trim');
            $this->form_validation->set_rules('phone', 'Phone', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $addr_id = $this->input->post('id');
                $save = [
                    'user_id'    => $user_id,
                    'type'       => $this->input->post('type', TRUE) ?: 'shipping',
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name'  => $this->input->post('last_name', TRUE),
                    'company'    => $this->input->post('company', TRUE),
                    'address_1'  => $this->input->post('address_1', TRUE),
                    'address_2'  => $this->input->post('address_2', TRUE),
                    'city'       => $this->input->post('city', TRUE),
                    'state'      => $this->input->post('state', TRUE),
                    'postcode'   => $this->input->post('postcode', TRUE),
                    'country'    => $this->input->post('country', TRUE),
                    'phone'      => $this->input->post('phone', TRUE),
                    'is_default' => 1
                ];

                if (!empty($addr_id)) {
                    $save['id'] = (int) $addr_id;
                }

                $this->user_model->save_address($save);
                $this->session->set_flashdata('success', 'Address saved successfully.');
                redirect('account/address');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        $addresses = $this->user_model->get_addresses($user_id);

        $data = [
            'title'              => 'Saved Addresses - ' . ($this->store_settings['site_name'] ?? 'Modave'),
            'active_page'        => 'account',
            'active_account_tab' => 'address',
            'user'               => $this->user_model->get_by_id($user_id),
            'addresses'          => $addresses
        ];

        $this->render('account/address', $data);
    }

    public function delete_address($id)
    {
        $user_id = $this->current_user['id'];
        $this->user_model->delete_address($id, $user_id);
        $this->session->set_flashdata('success', 'Address removed.');
        redirect('account/address');
    }

    public function wishlist()
    {
        $user_id   = $this->current_user['id'];
        $wishlist  = $this->wishlist_model->get_by_user($user_id);

        $data = [
            'title'              => 'My Wishlist - ' . ($this->store_settings['site_name'] ?? 'Modave'),
            'active_page'        => 'account',
            'active_account_tab' => 'wishlist',
            'user'               => $this->user_model->get_by_id($user_id),
            'wishlist'           => $wishlist
        ];

        $this->render('account/wishlist', $data);
    }

    public function wishlist_toggle($product_id)
    {
        $user_id = $this->current_user['id'];
        $status  = $this->wishlist_model->toggle($user_id, $product_id);

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'action' => $status]);
            return;
        }

        $msg = ($status === 'added') ? 'Product added to your wishlist.' : 'Product removed from your wishlist.';
        $this->session->set_flashdata('success', $msg);
        redirect($_SERVER['HTTP_REFERER'] ?? 'account/wishlist');
    }

    public function notifications()
    {
        $user_id       = $this->current_user['id'];
        $notifications = $this->notification_model->get_by_user($user_id);

        // Mark all as read
        $this->notification_model->mark_all_read($user_id);

        $data = [
            'title'              => 'Notifications - ' . ($this->store_settings['site_name'] ?? 'Modave'),
            'active_page'        => 'account',
            'active_account_tab' => 'notifications',
            'user'               => $this->user_model->get_by_id($user_id),
            'notifications'      => $notifications
        ];

        $this->render('account/notifications', $data);
    }
}
