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
            $this->session->set_flashdata('error', 'Your shopping cart is currently empty.');
            redirect('shop');
        }

        $shipping_method = $this->session->userdata('shipping_method') ?: 'standard';
        $summary = $this->cart_model->get_cart_summary($shipping_method);
        $gateways = $this->setting_model->get_active_gateways();

        // Customer default address if logged in
        $default_address = NULL;
        if ($this->is_logged_in()) {
            $default_address = $this->user_model->get_default_address($this->current_user['id'], 'shipping');
        }

        $data = [
            'title'           => 'Checkout - Modave',
            'active_page'     => 'checkout',
            'cart_items'      => $items,
            'cart_summary'    => $summary,
            'gateways'        => $gateways,
            'default_address' => $default_address,
            'shipping_method' => $shipping_method
        ];

        $this->render('checkout/index', $data);
    }

    public function process()
    {
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

            // Optional auto-registration during checkout
            $user_id = $this->current_user['id'] ?? NULL;
            if (!$user_id && $create_account) {
                // Check if email already registered
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

            // Save address if logged in and save_address checked
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

            // Create Order
            $order_number = $this->order_model->create_order($order_data, $items);

            // Clear session cart
            $this->cart_model->clear_cart();

            // Redirect based on gateway
            if ($payment_method === 'stripe') {
                redirect('payment/stripe/' . $order_number);
            } elseif ($payment_method === 'razorpay') {
                redirect('payment/razorpay/' . $order_number);
            } elseif ($payment_method === 'payu') {
                redirect('payment/payu/' . $order_number);
            } else {
                // COD
                redirect('payment/success/' . $order_number);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect('checkout');
        }
    }
}
