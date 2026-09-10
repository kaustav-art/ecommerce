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
            'title'               => 'My Profile - ' . $this->site_name,
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
            'title'              => 'My Orders - ' . $this->site_name,
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

        // Fetch existing reviews for products in this order by current user
        $user_reviews = [];
        if (!empty($order['items'])) {
            $pids = array_filter(array_column($order['items'], 'product_id'));
            if (!empty($pids)) {
                $revs = $this->db->where('user_id', (int)$this->current_user['id'])
                                 ->where_in('product_id', $pids)
                                 ->get('reviews')
                                 ->result_array();
                foreach ($revs as $r) {
                    $user_reviews[$r['product_id']] = $r;
                }
            }
        }

        $data = [
            'title'              => 'Order Details #' . $order_number . ' - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'orders',
            'user'               => $this->user_model->get_by_id($this->current_user['id']),
            'order'              => $order,
            'user_reviews'       => $user_reviews
        ];

        $this->render('account/order_detail', $data);
    }

    public function rate_review($order_number = '', $product_id = null)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order || $order['user_id'] != $this->current_user['id']) {
            show_404();
        }

        $status = strtolower($order['order_status']);
        if (!in_array($status, ['delivered', 'completed'])) {
            $this->session->set_flashdata('error', 'You can only rate and review a product after it has been delivered.');
            redirect('account/order/' . $order_number);
            return;
        }

        // Find matching item
        $items = $order['items'] ?? [];
        if (empty($items)) {
            show_404();
        }

        $selected_item = null;
        if ($product_id) {
            foreach ($items as $it) {
                if ($it['product_id'] == $product_id) {
                    $selected_item = $it;
                    break;
                }
            }
        }
        if (!$selected_item) {
            $selected_item = $items[0];
        }

        $this->load->model('product_model');
        $product = $this->product_model->get_by_id($selected_item['product_id']);

        // Check if existing review
        $existing_review = $this->db->where('product_id', (int)$selected_item['product_id'])
                                    ->where('user_id', (int)$this->current_user['id'])
                                    ->get('reviews')
                                    ->row_array();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('rating', 'Rating', 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[5]');
            $this->form_validation->set_rules('review', 'Review Description', 'required|trim|min_length[3]');

            if ($this->form_validation->run() === TRUE) {
                $rating      = (int) $this->input->post('rating');
                $review_text = $this->input->post('review', TRUE);
                $title       = $this->input->post('title', TRUE);

                // Handle file uploads
                $uploaded_images = [];
                if (!empty($existing_review['images'])) {
                    $uploaded_images = json_decode($existing_review['images'], true) ?: [];
                }

                if (!empty($_FILES['review_images']['name'][0])) {
                    $upload_path = FCPATH . 'website/assets/images/reviews/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, true);
                    }
                    $file_count = count($_FILES['review_images']['name']);
                    for ($i = 0; $i < $file_count; $i++) {
                        if ($_FILES['review_images']['error'][$i] === 0) {
                            $ext = strtolower(pathinfo($_FILES['review_images']['name'][$i], PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                                $new_file_name = 'rev_' . time() . '_' . uniqid() . '.' . $ext;
                                if (move_uploaded_file($_FILES['review_images']['tmp_name'][$i], $upload_path . $new_file_name)) {
                                    $uploaded_images[] = 'reviews/' . $new_file_name;
                                }
                            }
                        }
                    }
                }

                $customer_name = trim(($this->current_user['first_name'] ?? '') . ' ' . ($this->current_user['last_name'] ?? ''));
                if (empty($customer_name)) {
                    $customer_name = $order['customer_name'] ?: 'Verified Customer';
                }

                $review_data = [
                    'product_id'     => $selected_item['product_id'],
                    'user_id'        => $this->current_user['id'],
                    'order_number'   => $order_number,
                    'customer_name'  => $customer_name,
                    'customer_email' => $this->current_user['email'] ?? ($order['customer_email'] ?? ''),
                    'rating'         => $rating,
                    'title'          => $title,
                    'review'         => $review_text,
                    'images'         => !empty($uploaded_images) ? json_encode($uploaded_images) : NULL,
                    'status'         => 'approved',
                    'created_at'     => date('Y-m-d H:i:s')
                ];

                if ($existing_review) {
                    $this->db->where('id', $existing_review['id'])->update('reviews', $review_data);
                } else {
                    $this->db->insert('reviews', $review_data);
                }

                // Recalculate rating stats
                $stats = $this->db->select_avg('rating', 'avg_rating')
                                  ->where('product_id', $selected_item['product_id'])
                                  ->where('status', 'approved')
                                  ->get('reviews')
                                  ->row_array();
                $count = $this->db->where('product_id', $selected_item['product_id'])->where('status', 'approved')->count_all_results('reviews');

                $this->db->where('id', $selected_item['product_id'])->update('products', [
                    'rating'        => $stats['avg_rating'] ?: 5.0,
                    'reviews_count' => $count
                ]);

                $this->session->set_flashdata('success', 'Thank you! Your rating and review have been submitted successfully.');
                redirect('account/order/' . $order_number);
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        $prefill_rating = (int) ($this->input->get('rating') ?: ($existing_review['rating'] ?? 5));
        if ($prefill_rating < 1 || $prefill_rating > 5) {
            $prefill_rating = 5;
        }

        $data = [
            'title'           => 'Rate & Review - ' . $selected_item['product_title'] . ' - ' . $this->site_name,
            'active_page'     => 'account',
            'order'           => $order,
            'item'            => $selected_item,
            'product'         => $product,
            'existing_review' => $existing_review,
            'prefill_rating'  => $prefill_rating,
            'user'            => $this->user_model->get_by_id($this->current_user['id'])
        ];

        $this->render('account/rate_review', $data);
    }

    public function quick_rate()
    {
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $order_number = trim($this->input->post('order_number'));
        $product_id   = (int) $this->input->post('product_id');
        $rating       = (int) $this->input->post('rating');

        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Invalid rating']);
            return;
        }

        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order || $order['user_id'] != $this->current_user['id']) {
            echo json_encode(['success' => false, 'message' => 'Order not found']);
            return;
        }

        $status = strtolower($order['order_status']);
        if (!in_array($status, ['delivered', 'completed'])) {
            echo json_encode(['success' => false, 'message' => 'Ratings are only allowed after product delivery']);
            return;
        }

        // Check if existing review
        $existing = $this->db->where('product_id', $product_id)
                             ->where('user_id', $this->current_user['id'])
                             ->get('reviews')
                             ->row_array();

        $customer_name = trim(($this->current_user['first_name'] ?? '') . ' ' . ($this->current_user['last_name'] ?? ''));
        if (empty($customer_name)) {
            $customer_name = $order['customer_name'] ?: 'Customer';
        }

        $data = [
            'product_id'     => $product_id,
            'user_id'        => $this->current_user['id'],
            'order_number'   => $order_number,
            'customer_name'  => $customer_name,
            'customer_email' => $this->current_user['email'] ?? ($order['customer_email'] ?? ''),
            'rating'         => $rating,
            'review'         => !empty($existing['review']) ? $existing['review'] : 'Product delivered in great condition.',
            'status'         => 'approved',
            'created_at'     => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            $this->db->where('id', $existing['id'])->update('reviews', ['rating' => $rating]);
        } else {
            $this->db->insert('reviews', $data);
        }

        // Recalculate stats
        $stats = $this->db->select_avg('rating', 'avg_rating')
                          ->where('product_id', $product_id)
                          ->where('status', 'approved')
                          ->get('reviews')
                          ->row_array();
        $count = $this->db->where('product_id', $product_id)->where('status', 'approved')->count_all_results('reviews');
        $this->db->where('id', $product_id)->update('products', [
            'rating'        => $stats['avg_rating'] ?: 5.0,
            'reviews_count' => $count
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Rating saved successfully! You can write a detailed review anytime.',
            'rating'  => $rating
        ]);
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

        // Invoice can only be downloaded by customer after order has been delivered
        $status = strtolower($order['order_status']);
        if (!in_array($status, ['delivered', 'completed'])) {
            $this->session->set_flashdata('error', 'Invoice can only be downloaded after the order has been delivered.');
            redirect('account/order/' . $order_number);
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
            'title'              => 'Return & Refund Requests - ' . $this->site_name,
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
            $name = trim($this->input->post('name', TRUE) ?? '');
            $first_name = trim($this->input->post('first_name', TRUE) ?? '');
            $last_name  = trim($this->input->post('last_name', TRUE) ?? '');

            if (!empty($name) && empty($first_name)) {
                $parts = explode(' ', $name, 2);
                $first_name = $parts[0];
                $last_name = $parts[1] ?? '';
            }

            $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
            $this->form_validation->set_rules('postcode', 'Pincode', 'required|trim');
            $this->form_validation->set_rules('address_1', 'Address', 'required|trim');
            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('state', 'State', 'required|trim');

            if (empty($first_name)) {
                $this->form_validation->set_rules('name', 'Name', 'required|trim');
            }

            if ($this->form_validation->run() === TRUE) {
                $addr_id = $this->input->post('id');
                $address_type = strtoupper(trim($this->input->post('address_type', TRUE) ?: $this->input->post('company', TRUE) ?: 'HOME'));
                if (!in_array($address_type, ['HOME', 'WORK'])) {
                    $address_type = 'HOME';
                }

                $save = [
                    'user_id'         => $user_id,
                    'type'            => 'shipping',
                    'first_name'      => $first_name,
                    'last_name'       => $last_name,
                    'company'         => $address_type,
                    'address_1'       => $this->input->post('address_1', TRUE),
                    'address_2'       => $this->input->post('address_2', TRUE) ?: $this->input->post('locality', TRUE),
                    'landmark'        => $this->input->post('landmark', TRUE),
                    'city'            => $this->input->post('city', TRUE),
                    'state'           => $this->input->post('state', TRUE),
                    'postcode'        => $this->input->post('postcode', TRUE),
                    'country'         => $this->input->post('country', TRUE) ?: 'India',
                    'phone'           => $this->input->post('phone', TRUE),
                    'alternate_phone' => $this->input->post('alternate_phone', TRUE),
                    'is_default'      => 1
                ];

                if (!empty($addr_id)) {
                    $save['id'] = (int) $addr_id;
                }

                $saved_id = $this->user_model->save_address($save);
                $this->user_model->set_default_address($saved_id, $user_id);

                if ($this->input->is_ajax_request()) {
                    $this->json_response(['status' => 'success', 'message' => 'Address saved successfully.', 'id' => $saved_id]);
                    return;
                }

                $this->session->set_flashdata('success', 'Address saved successfully.');
                redirect('account/address');
            } else {
                if ($this->input->is_ajax_request()) {
                    $this->json_response(['status' => 'error', 'message' => validation_errors()], 422);
                    return;
                }
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        $addresses = $this->user_model->get_addresses($user_id);

        $data = [
            'title'              => 'Manage Addresses - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'address',
            'user'               => $this->user_model->get_by_id($user_id),
            'addresses'          => $addresses
        ];

        $this->render('account/address', $data);
    }

    public function get_address_ajax($id)
    {
        $address = $this->user_model->get_address_by_id($id, $this->current_user['id']);
        if (!$address) {
            $this->json_response(['status' => 'error', 'message' => 'Address not found.'], 404);
            return;
        }
        $this->json_response(['status' => 'success', 'address' => $address]);
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
            'title'              => 'My Wishlist - ' . $this->site_name,
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
            'title'              => 'Notifications - ' . $this->site_name,
            'active_page'        => 'account',
            'active_account_tab' => 'notifications',
            'user'               => $this->user_model->get_by_id($user_id),
            'notifications'      => $notifications
        ];

        $this->render('account/notifications', $data);
    }
}
