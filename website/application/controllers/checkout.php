<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class checkout extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cart_model');
        $this->load->model('order_model');
        $this->load->model('user_model');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $items = $this->cart_model->get_items();
        if (empty($items)) {
            redirect('cart');
        }

        // Require authentication: user cannot buy products or access checkout without logging in
        if (!$this->is_logged_in()) {
            $this->session->set_userdata('redirect_url', site_url('checkout'));
            $this->session->set_flashdata('info', 'Please sign in or enter your mobile/email to complete your purchase.');
            redirect('cart?login=1');
        }

        $shipping_method = $this->session->userdata('shipping_method') ?: 'standard';
        $summary = $this->cart_model->get_cart_summary($shipping_method);
        $gateways = $this->setting_model->get_active_gateways();

        // Calculate MRP and Savings from summary
        $mrp_total      = $summary['mrp_total'];
        $discount_total = $summary['mrp_discount'];
        $total_savings  = $summary['total_savings'];

        // Customer default address (User is logged in)
        $default_address = NULL;
        $selected_id = $this->session->userdata('selected_address_id');
        if ($selected_id) {
            $default_address = $this->user_model->get_address_by_id($selected_id, $this->current_user['id']);
        }
        if (!$default_address) {
            $default_address = $this->user_model->get_default_address($this->current_user['id'], 'shipping');
        }

        $data = [
            'title'           => 'Checkout - ' . $this->site_name,
            'active_page'     => 'checkout',
            'cart_items'      => $items,
            'cart_summary'    => $summary,
            'gateways'        => $gateways,
            'default_address' => $default_address,
            'shipping_method' => $shipping_method,
            'mrp_total'       => $mrp_total,
            'discount_total'  => $discount_total,
            'total_savings'   => $total_savings
        ];

        $this->render('checkout/index', $data);
    }

    public function payment()
    {
        $items = $this->cart_model->get_items();
        if (empty($items)) {
            redirect('cart');
        }

        // Require authentication
        if (!$this->is_logged_in()) {
            $this->session->set_userdata('redirect_url', site_url('checkout/payment'));
            $this->session->set_flashdata('info', 'Please sign in or enter your mobile/email to complete your purchase.');
            redirect('cart?login=1');
        }

        // User can ONLY access payment page if delivery address is present!
        $default_address = NULL;
        $selected_id = $this->session->userdata('selected_address_id');
        if ($selected_id) {
            $default_address = $this->user_model->get_address_by_id($selected_id, $this->current_user['id']);
        }
        if (!$default_address) {
            $default_address = $this->user_model->get_default_address($this->current_user['id'], 'shipping');
        }

        if (!$default_address) {
            $this->session->set_flashdata('error', 'Please add or select a delivery address before proceeding to payment.');
            redirect('checkout');
        }

        $shipping_method = $this->session->userdata('shipping_method') ?: 'standard';
        $summary = $this->cart_model->get_cart_summary($shipping_method);
        $gateways = $this->setting_model->get_active_gateways();

        $data = [
            'title'           => 'Payment - ' . $this->site_name,
            'active_page'     => 'checkout',
            'cart_items'      => $items,
            'cart_summary'    => $summary,
            'gateways'        => $gateways,
            'default_address' => $default_address,
            'shipping_method' => $shipping_method,
            'mrp_total'       => $summary['mrp_total'],
            'discount_total'  => $summary['mrp_discount'],
            'total_savings'   => $summary['total_savings']
        ];

        $this->render('checkout/payment', $data);
    }

    public function select_address()
    {
        if (!$this->is_logged_in()) {
            return $this->json_response(['success' => false, 'require_login' => true, 'message' => 'Please log in to select an address.'], 401);
        }

        $address_id = (int) $this->input->post('address_id', TRUE);
        $addr = $this->user_model->get_address_by_id($address_id, $this->current_user['id']);
        if ($addr) {
            $this->session->set_userdata('selected_address_id', $address_id);
            return $this->json_response([
                'success' => true,
                'address' => $addr,
                'message' => 'Delivery address selected.'
            ]);
        }
        return $this->json_response(['success' => false, 'message' => 'Address not found.'], 404);
    }

    public function get_addresses()
    {
        if (!$this->is_logged_in()) {
            return $this->json_response([
                'success'      => true,
                'addresses'    => [],
                'selected_id'  => null,
                'is_logged_in' => false
            ]);
        }

        $addresses = $this->user_model->get_addresses($this->current_user['id']);
        $selected_id = $this->session->userdata('selected_address_id');
        if (!$selected_id && !empty($addresses)) {
            $selected_id = $addresses[0]['id'];
            foreach ($addresses as $a) {
                if (!empty($a['is_default'])) {
                    $selected_id = $a['id'];
                    break;
                }
            }
        }

        return $this->json_response([
            'success'      => true,
            'addresses'    => $addresses,
            'selected_id'  => $selected_id,
            'is_logged_in' => true
        ]);
    }

    public function save_address()
    {
        if (!$this->is_logged_in()) {
            return $this->json_response(['success' => false, 'require_login' => true, 'message' => 'Please log in to save your delivery address.'], 401);
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
        $this->form_validation->set_rules('address_1', 'Street Address', 'required|trim');
        $this->form_validation->set_rules('city', 'City', 'required|trim');
        $this->form_validation->set_rules('state', 'State', 'required|trim');
        $this->form_validation->set_rules('postcode', 'Postal Code', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            return $this->json_response(['success' => false, 'message' => strip_tags(validation_errors())], 400);
        }

        $addr_data = [
            'type'       => 'shipping',
            'user_id'    => $this->current_user['id'],
            'first_name' => $this->input->post('first_name', TRUE),
            'last_name'  => $this->input->post('last_name', TRUE) ?: '',
            'company'    => $this->input->post('company', TRUE) ?: 'HOME',
            'phone'      => $this->input->post('phone', TRUE),
            'address_1'  => $this->input->post('address_1', TRUE),
            'address_2'  => $this->input->post('address_2', TRUE) ?: '',
            'city'       => $this->input->post('city', TRUE),
            'state'      => $this->input->post('state', TRUE),
            'postcode'   => $this->input->post('postcode', TRUE),
            'country'    => $this->input->post('country', TRUE) ?: 'India',
            'is_default' => $this->input->post('is_default') ? 1 : 0
        ];

        $addr_id = $this->user_model->save_address($addr_data);
        if (!empty($addr_data['is_default'])) {
            $this->user_model->set_default_address($addr_id, $this->current_user['id']);
        }
        $this->session->set_userdata('selected_address_id', $addr_id);
        $addr_data['id'] = $addr_id;

        return $this->json_response([
            'success' => true,
            'address' => $addr_data,
            'message' => 'Delivery address saved successfully!'
        ]);
    }

    public function create_order_ajax()
    {
        // Enforce user authentication to buy product
        if (!$this->is_logged_in()) {
            return $this->json_response([
                'success'       => false,
                'require_login' => true,
                'message'       => 'Please sign in or enter your mobile/email to complete your purchase.'
            ], 401);
        }

        $items = $this->cart_model->get_items();
        if (empty($items)) {
            return $this->json_response(['success' => false, 'message' => 'Cart is empty.'], 400);
        }

        $payment_method = $this->input->post('payment_method', TRUE) ?: 'razorpay';
        if (!in_array($payment_method, ['cod', 'stripe', 'razorpay', 'payu'])) {
            $payment_method = 'razorpay';
        }

        $shipping_method = $this->input->post('shipping_method', TRUE) ?: ($this->session->userdata('shipping_method') ?: 'standard');
        $summary = $this->cart_model->get_cart_summary($shipping_method);

        // Resolve Address for authenticated user
        $active_addr = NULL;
        $sel_id = $this->session->userdata('selected_address_id');
        if ($sel_id) {
            $active_addr = $this->user_model->get_address_by_id($sel_id, $this->current_user['id']);
        }
        if (!$active_addr) {
            $active_addr = $this->user_model->get_default_address($this->current_user['id'], 'shipping');
        }

        // If still no address, fall back to user profile or input data
        if (!$active_addr) {
            $first_name = $this->input->post('first_name', TRUE) ?: ($this->current_user['first_name'] ?? 'Customer');
            $last_name  = $this->input->post('last_name', TRUE) ?: ($this->current_user['last_name'] ?? '');
            $phone      = $this->input->post('phone', TRUE) ?: ($this->current_user['phone'] ?? '');
            $email      = $this->current_user['email'] ?? ($this->input->post('email', TRUE) ?: 'customer@example.com');
            $address_1  = $this->input->post('address_1', TRUE) ?: 'Main Street';
            $address_2  = $this->input->post('address_2', TRUE) ?: '';
            $city       = $this->input->post('city', TRUE) ?: 'New Delhi';
            $state      = $this->input->post('state', TRUE) ?: 'Delhi';
            $postcode   = $this->input->post('postcode', TRUE) ?: '110001';
            $country    = $this->input->post('country', TRUE) ?: 'India';
            $company    = $this->input->post('company', TRUE) ?: 'HOME';
        } else {
            $first_name = $active_addr['first_name'];
            $last_name  = $active_addr['last_name'] ?? '';
            $phone      = $active_addr['phone'] ?? ($this->current_user['phone'] ?? '');
            $email      = $this->current_user['email'] ?? ($this->input->post('email', TRUE) ?: 'customer@example.com');
            $address_1  = $active_addr['address_1'];
            $address_2  = $active_addr['address_2'] ?? '';
            $city       = $active_addr['city'];
            $state      = $active_addr['state'];
            $postcode   = $active_addr['postcode'];
            $country    = $active_addr['country'] ?? 'India';
            $company    = $active_addr['company'] ?? 'HOME';
        }

        $full_name = trim($first_name . ' ' . $last_name);
        $shipping_str = implode("\n", array_filter([
            $full_name . ' (' . $company . ')',
            $address_1,
            $address_2,
            $city . ', ' . $state . ' ' . $postcode,
            $country,
            'Phone: ' . $phone
        ]));

        $user_id = $this->current_user['id'];

        $order_data = [
            'user_id'          => $user_id,
            'customer_name'    => $full_name,
            'customer_email'   => $email,
            'customer_phone'   => $phone,
            'shipping_address' => $shipping_str,
            'billing_address'  => $shipping_str,
            'subtotal'         => $summary['subtotal'],
            'discount_amount'  => $summary['discount'],
            'shipping_fee'     => $summary['shipping'],
            'tax_amount'       => $summary['tax'],
            'total_amount'     => $summary['total'],
            'currency'         => $this->store_settings['currency_code'] ?? 'USD',
            'payment_method'   => $payment_method,
            'payment_status'   => 'pending',
            'order_status'     => 'pending',
            'notes'            => $this->input->post('order_notes', TRUE) ?: ''
        ];

        // Create Order
        $order_number = $this->order_model->create_order($order_data, $items);
        $order = $this->order_model->get_by_order_number($order_number);

        $this->load->model('payment_model');

        if ($payment_method === 'razorpay') {
            $razorpay_data = $this->payment_model->init_razorpay($order);
            return $this->json_response([
                'success'      => true,
                'gateway'      => 'razorpay',
                'order_number' => $order_number,
                'order'        => $order,
                'razorpay'     => $razorpay_data
            ]);
        } elseif ($payment_method === 'stripe') {
            $stripe_data = $this->payment_model->init_stripe($order);
            $redirect_url = !empty($stripe_data['checkout_url']) ? $stripe_data['checkout_url'] : site_url('payment/stripe/' . $order_number);
            return $this->json_response([
                'success'      => true,
                'gateway'      => 'stripe',
                'order_number' => $order_number,
                'order'        => $order,
                'redirect_url' => $redirect_url,
                'stripe'       => $stripe_data
            ]);
        } elseif ($payment_method === 'payu') {
            $payu_data = $this->payment_model->init_payu($order);
            return $this->json_response([
                'success'      => true,
                'gateway'      => 'payu',
                'order_number' => $order_number,
                'order'        => $order,
                'payu'         => $payu_data
            ]);
        } else {
            // COD
            $this->cart_model->clear_cart();
            return $this->json_response([
                'success'      => true,
                'gateway'      => 'cod',
                'order_number' => $order_number,
                'redirect_url' => site_url('payment/success/' . $order_number)
            ]);
        }
    }

    public function verify_razorpay_ajax()
    {
        $this->load->model('payment_model');
        $order_number = $this->input->post('order_number', TRUE);
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            return $this->json_response(['success' => false, 'message' => 'Order not found.'], 404);
        }

        $payment_id = $this->input->post('razorpay_payment_id', TRUE);
        $order_id   = $this->input->post('razorpay_order_id', TRUE);
        $signature  = $this->input->post('razorpay_signature', TRUE);

        $verified = $this->payment_model->verify_razorpay_signature($order_id, $payment_id, $signature);
        if ($verified) {
            $this->order_model->update_payment(
                $order_number,
                'paid',
                $payment_id,
                [
                    'gateway'             => 'razorpay',
                    'razorpay_order_id'   => $order_id,
                    'razorpay_payment_id' => $payment_id,
                    'paid_at'             => date('Y-m-d H:i:s')
                ]
            );
            $this->cart_model->clear_cart();
            return $this->json_response([
                'success'      => true,
                'order_number' => $order_number,
                'redirect_url' => site_url('payment/success/' . $order_number)
            ]);
        } else {
            $this->order_model->update_payment($order_number, 'failed');
            return $this->json_response(['success' => false, 'message' => 'Razorpay payment verification failed.'], 400);
        }
    }

    public function confirm_stripe_ajax()
    {
        $this->load->model('payment_model');
        $order_number = $this->input->post('order_number', TRUE);
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            return $this->json_response(['success' => false, 'message' => 'Order not found.'], 404);
        }

        $payment_intent_id = $this->input->post('payment_intent_id', TRUE) ?: ('pi_sim_' . uniqid());

        $this->order_model->update_payment(
            $order_number,
            'paid',
            $payment_intent_id,
            [
                'gateway'   => 'stripe',
                'intent_id' => $payment_intent_id,
                'paid_at'   => date('Y-m-d H:i:s')
            ]
        );
        $this->cart_model->clear_cart();

        return $this->json_response([
            'success'      => true,
            'order_number' => $order_number,
            'redirect_url' => site_url('payment/success/' . $order_number)
        ]);
    }

    public function process()
    {
        if (!$this->is_logged_in()) {
            $this->session->set_userdata('redirect_url', site_url('checkout'));
            $this->session->set_flashdata('info', 'Please sign in to complete your purchase.');
            redirect('cart?login=1');
        }

        $items = $this->cart_model->get_items();
        if (empty($items)) {
            redirect('cart');
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
        $this->form_validation->set_rules('address_1', 'Street Address', 'required|trim');
        $this->form_validation->set_rules('city', 'City', 'required|trim');
        $this->form_validation->set_rules('state', 'State', 'required|trim');
        $this->form_validation->set_rules('postcode', 'Postal Code', 'required|trim');
        $this->form_validation->set_rules('country', 'Country', 'required|trim');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required|in_list[cod,stripe,razorpay,payu]');

        // Account creation validation if guest checked "create account"
        $create_account = $this->input->post('create_account');
        if (!$this->is_logged_in() && $create_account) {
            $this->form_validation->set_rules('password', 'Account Password', 'required|min_length[6]');
        }

        if ($this->form_validation->run() === TRUE) {
            $shipping_method = $this->input->post('shipping_method', TRUE) ?: ($this->session->userdata('shipping_method') ?: 'standard');
            $summary = $this->cart_model->get_cart_summary($shipping_method);

            $first_name = $this->input->post('first_name', TRUE);
            $last_name  = $this->input->post('last_name', TRUE);
            $email      = $this->input->post('email', TRUE);
            $phone      = $this->input->post('phone', TRUE);
            $full_name  = $first_name . ' ' . $last_name;

            $user_id = $this->current_user['id'] ?? NULL;
            if (!$user_id && $create_account) {
                $existing = $this->user_model->get_by_email($email);
                if (!$existing) {
                    $new_user_id = $this->user_model->create([
                        'first_name' => $first_name,
                        'last_name'  => $last_name,
                        'email'      => $email,
                        'phone'      => $phone,
                        'password'   => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                        'status'     => 'active'
                    ]);
                    if ($new_user_id) {
                        $user_id = $new_user_id;
                        $this->session->set_userdata([
                            'user_logged_in'  => true,
                            'user_id'         => $user_id,
                            'user_email'      => $email,
                            'user_first_name' => $first_name,
                            'user_last_name'  => $last_name
                        ]);
                    }
                }
            }

            $shipping_address = implode("\n", array_filter([
                $full_name,
                $this->input->post('address_1', TRUE),
                $this->input->post('address_2', TRUE),
                $this->input->post('city', TRUE) . ', ' . $this->input->post('state', TRUE) . ' ' . $this->input->post('postcode', TRUE),
                $this->input->post('country', TRUE),
                'Phone: ' . $phone
            ]));

            $payment_method = $this->input->post('payment_method', TRUE);

            $order_data = [
                'user_id'          => $user_id,
                'customer_name'    => $full_name,
                'customer_email'   => $email,
                'customer_phone'   => $phone,
                'shipping_address' => $shipping_address,
                'billing_address'  => $shipping_address,
                'subtotal'         => $summary['subtotal'],
                'discount_amount'  => $summary['discount'],
                'shipping_fee'     => $summary['shipping'],
                'tax_amount'       => $summary['tax'],
                'total_amount'     => $summary['total'],
                'currency'         => $this->store_settings['currency_code'] ?? 'USD',
                'payment_method'   => $payment_method,
                'payment_status'   => 'pending',
                'order_status'     => 'pending',
                'notes'            => $this->input->post('order_notes', TRUE)
            ];

            if ($user_id && $this->input->post('save_address')) {
                $this->user_model->save_address([
                    'user_id'    => $user_id,
                    'type'       => 'shipping',
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'address_1'  => $this->input->post('address_1', TRUE),
                    'city'       => $this->input->post('city', TRUE),
                    'state'      => $this->input->post('state', TRUE),
                    'postcode'   => $this->input->post('postcode', TRUE),
                    'country'    => $this->input->post('country', TRUE),
                    'phone'      => $phone,
                    'is_default' => 1
                ]);
            }

            $order_number = $this->order_model->create_order($order_data, $items);
            $this->cart_model->clear_cart();

            if ($payment_method === 'stripe') {
                redirect('payment/stripe/' . $order_number);
            } elseif ($payment_method === 'razorpay') {
                redirect('payment/razorpay/' . $order_number);
            } elseif ($payment_method === 'payu') {
                redirect('payment/payu/' . $order_number);
            } else {
                redirect('payment/success/' . $order_number);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect('checkout');
        }
    }
}
