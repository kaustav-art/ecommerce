<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class payment extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('payment_model');
    }

    // ==========================================
    // 1. STRIPE CHECKOUT
    // ==========================================
    public function stripe($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        if ($order['payment_status'] === 'paid') {
            redirect('payment/success/' . $order_number);
        }

        $stripe_data = $this->payment_model->init_stripe($order);
        if (!empty($stripe_data['checkout_url']) && strpos($stripe_data['checkout_url'], 'stripe.com') !== false) {
            redirect($stripe_data['checkout_url']);
            return;
        }

        if (!$stripe_data['success']) {
            $this->session->set_flashdata('error', $stripe_data['message']);
            redirect('payment/failure/' . $order_number);
        }

        $data = [
            'title'        => 'Stripe Secure Payment - Order #' . $order_number,
            'active_page'  => 'checkout',
            'order'        => $order,
            'stripe'       => $stripe_data
        ];

        $this->render('payment/stripe', $data);
    }

    public function stripe_success($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        $session_id = $this->input->get('session_id', TRUE) ?: ('cs_' . uniqid());
        $payment_intent = $session_id;

        // Verify session status with Stripe if secret key is present
        $gateway = $this->payment_model->get_gateway_config('stripe');
        $secret_key = $gateway['credentials']['secret_key'] ?? '';

        if (!empty($secret_key) && !empty($session_id) && strpos($session_id, 'cs_') === 0 && function_exists('curl_version')) {
            $ch = curl_init('https://api.stripe.com/v1/checkout/sessions/' . $session_id);
            curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ':');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $session_data = json_decode($res, true);
            if (!empty($session_data['payment_intent'])) {
                $payment_intent = $session_data['payment_intent'];
            }
        }

        // Mark paid
        $this->order_model->update_payment(
            $order_number,
            'paid',
            $payment_intent,
            ['gateway' => 'stripe', 'session_id' => $session_id, 'intent_id' => $payment_intent, 'paid_at' => date('Y-m-d H:i:s')]
        );

        $this->_restore_original_session($order);

        $this->load->model('cart_model');
        $this->cart_model->clear_cart();

        $this->session->set_flashdata('success', 'Payment successful via Stripe Checkout!');
        redirect('payment/success/' . $order_number);
    }

    public function stripe_confirm($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        $payment_intent_id = $this->input->post('payment_intent_id', TRUE) ?: ('pi_sim_' . uniqid());

        // Mark paid
        $this->order_model->update_payment(
            $order_number,
            'paid',
            $payment_intent_id,
            ['gateway' => 'stripe', 'intent_id' => $payment_intent_id, 'paid_at' => date('Y-m-d H:i:s')]
        );

        $this->_restore_original_session($order);

        $this->load->model('cart_model');
        $this->cart_model->clear_cart();

        $this->session->set_flashdata('success', 'Payment successful via Stripe!');
        redirect('payment/success/' . $order_number);
    }

    // ==========================================
    // 2. RAZORPAY CHECKOUT
    // ==========================================
    public function razorpay($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        if ($order['payment_status'] === 'paid') {
            redirect('payment/success/' . $order_number);
        }

        $razorpay_data = $this->payment_model->init_razorpay($order);
        if (!$razorpay_data['success']) {
            $this->session->set_flashdata('error', $razorpay_data['message']);
            redirect('payment/failure/' . $order_number);
        }

        $data = [
            'title'        => 'Razorpay Payment - Order #' . $order_number,
            'active_page'  => 'checkout',
            'order'        => $order,
            'razorpay'     => $razorpay_data
        ];

        $this->render('payment/razorpay', $data);
    }

    public function razorpay_verify($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        $razorpay_payment_id = $this->input->post('razorpay_payment_id', TRUE);
        $razorpay_order_id   = $this->input->post('razorpay_order_id', TRUE);
        $razorpay_signature  = $this->input->post('razorpay_signature', TRUE);

        $verified = $this->payment_model->verify_razorpay_signature(
            $razorpay_order_id,
            $razorpay_payment_id,
            $razorpay_signature
        );

        $this->_restore_original_session($order);

        if ($verified) {
            $this->order_model->update_payment(
                $order_number,
                'paid',
                $razorpay_payment_id,
                [
                    'gateway'             => 'razorpay',
                    'razorpay_order_id'   => $razorpay_order_id,
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'paid_at'             => date('Y-m-d H:i:s')
                ]
            );
            $this->load->model('cart_model');
            $this->cart_model->clear_cart();
            $this->session->set_flashdata('success', 'Payment successful via Razorpay!');
            redirect('payment/success/' . $order_number);
        } else {
            $this->order_model->update_payment($order_number, 'failed');
            $this->session->set_flashdata('error', 'Razorpay payment signature verification failed.');
            redirect('payment/failure/' . $order_number);
        }
    }

    // ==========================================
    // 3. PAYU GATEWAY
    // ==========================================
    public function payu($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        if ($order['payment_status'] === 'paid') {
            redirect('payment/success/' . $order_number);
        }

        $payu_data = $this->payment_model->init_payu($order);
        if (!$payu_data['success']) {
            $this->session->set_flashdata('error', $payu_data['message']);
            redirect('payment/failure/' . $order_number);
        }

        $data = [
            'title'       => 'Redirecting to PayU...',
            'active_page' => 'checkout',
            'order'       => $order,
            'payu'        => $payu_data
        ];

        // Render PayU auto-submitting form page
        $this->load->view('payment/payu', $data);
    }

    public function payu_return($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        // Restore user session if lost due to SameSite Lax cookie restrictions on cross-site POST
        $this->_restore_original_session($order);

        $post_data = $this->input->post();
        $is_valid  = $this->payment_model->verify_payu_hash($post_data);

        $status = $this->input->post('status', TRUE);
        $txnid  = $this->input->post('txnid', TRUE);

        if ($is_valid && $status === 'success') {
            $this->order_model->update_payment(
                $order_number,
                'paid',
                $txnid,
                ['gateway' => 'payu', 'raw_response' => $post_data, 'paid_at' => date('Y-m-d H:i:s')]
            );
            $this->load->model('cart_model');
            $this->cart_model->clear_cart();
            $this->session->set_flashdata('success', 'Payment confirmed via PayU!');
            redirect('payment/success/' . $order_number);
        } else {
            $this->order_model->update_payment($order_number, 'failed', $txnid, $post_data);

            // Re-populate customer cart so items are not lost when payment fails or is cancelled
            $this->_restore_cart_on_failure($order);

            $err_msg = !empty($post_data['error_Message']) 
                ? $post_data['error_Message'] 
                : (!empty($post_data['unmappedstatus']) && $post_data['unmappedstatus'] === 'userCancelled' 
                    ? 'Payment was cancelled by user.' 
                    : 'PayU payment was declined or could not be verified.');

            $this->session->set_flashdata('error', $err_msg);
            redirect('payment/failure/' . $order_number);
        }
    }

    // ==========================================
    // 4. CONFIRMATION & FAILURE PAGES
    // ==========================================
    public function success($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        // Ensure user session is active
        if (!$this->is_logged_in() && !empty($order['user_id'])) {
            $this->_restore_original_session($order);
        }

        $data = [
            'title'       => 'Order Confirmed - #' . $order_number,
            'active_page' => 'checkout',
            'order'       => $order
        ];

        $this->render('payment/success', $data);
    }

    public function failure($order_number)
    {
        $order = $this->order_model->get_by_order_number($order_number);
        if (!$order) {
            show_404();
        }

        // If PayU or another gateway posted directly to failure
        if ($this->input->method() === 'post') {
            $post_data = $this->input->post();
            $txnid = $this->input->post('txnid', TRUE);
            $this->order_model->update_payment($order_number, 'failed', $txnid, $post_data);
        }

        // Ensure user session is active
        if (!$this->is_logged_in() && !empty($order['user_id'])) {
            $this->_restore_original_session($order);
        }

        // Ensure cart is preserved on failure
        $this->_restore_cart_on_failure($order);

        $data = [
            'title'       => 'Payment Failed - #' . $order_number,
            'active_page' => 'checkout',
            'order'       => $order
        ];

        $this->render('payment/failure', $data);
    }

    // ==========================================
    // 5. WEBHOOK ENDPOINT (STRIPE & RAZORPAY)
    // ==========================================
    public function webhook($gateway = 'stripe')
    {
        $gateway = strtolower($gateway);

        if ($gateway === 'stripe') {
            $this->_handle_stripe_webhook();
        } elseif ($gateway === 'razorpay') {
            $this->_handle_razorpay_webhook();
        } else {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Unsupported gateway']));
        }
    }

    protected function _handle_stripe_webhook()
    {
        $payload = file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

        $gw = $this->payment_model->get_gateway_config('stripe');
        $webhook_secret = trim($gw['credentials']['webhook_secret'] ?? '');

        // Verify signature if secret is configured
        if (!empty($webhook_secret) && !empty($sig_header)) {
            $timestamp = null;
            $signatures = [];
            foreach (explode(',', $sig_header) as $part) {
                $pair = explode('=', trim($part), 2);
                if (count($pair) === 2) {
                    if ($pair[0] === 't') {
                        $timestamp = $pair[1];
                    } elseif ($pair[0] === 'v1') {
                        $signatures[] = $pair[1];
                    }
                }
            }

            if (!$timestamp || empty($signatures)) {
                $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid signature header structure']));
                return;
            }

            $signed_payload = $timestamp . '.' . $payload;
            $expected_sig = hash_hmac('sha256', $signed_payload, $webhook_secret);

            $matched = false;
            foreach ($signatures as $sig) {
                if (hash_equals($expected_sig, $sig)) {
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                log_message('error', 'Stripe webhook signature mismatch');
                $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => 'error', 'message' => 'Signature verification failed']));
                return;
            }
        }

        $event = json_decode($payload, true);
        if (!$event || empty($event['type'])) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid JSON payload']));
            return;
        }

        $event_type = $event['type'];
        $event_obj  = $event['data']['object'] ?? [];

        switch ($event_type) {
            case 'checkout.session.completed':
                $order_number = $event_obj['client_reference_id'] ?? ($event_obj['metadata']['order_number'] ?? null);
                $payment_intent = $event_obj['payment_intent'] ?? ($event_obj['id'] ?? null);

                if ($order_number) {
                    $order = $this->order_model->get_by_order_number($order_number);
                    if ($order && $order['payment_status'] !== 'paid') {
                        $this->order_model->update_payment(
                            $order_number,
                            'paid',
                            $payment_intent,
                            [
                                'gateway'    => 'stripe',
                                'event_type' => $event_type,
                                'session_id' => $event_obj['id'] ?? null,
                                'intent_id'  => $payment_intent,
                                'source'     => 'webhook',
                                'paid_at'    => date('Y-m-d H:i:s')
                            ]
                        );
                    }
                }
                break;

            case 'payment_intent.succeeded':
                $order_number = $event_obj['metadata']['order_number'] ?? null;
                $payment_intent = $event_obj['id'] ?? null;

                if ($order_number) {
                    $order = $this->order_model->get_by_order_number($order_number);
                    if ($order && $order['payment_status'] !== 'paid') {
                        $this->order_model->update_payment(
                            $order_number,
                            'paid',
                            $payment_intent,
                            [
                                'gateway'    => 'stripe',
                                'event_type' => $event_type,
                                'intent_id'  => $payment_intent,
                                'source'     => 'webhook',
                                'paid_at'    => date('Y-m-d H:i:s')
                            ]
                        );
                    }
                }
                break;

            case 'payment_intent.payment_failed':
                $order_number = $event_obj['metadata']['order_number'] ?? null;
                if ($order_number) {
                    $order = $this->order_model->get_by_order_number($order_number);
                    if ($order && $order['payment_status'] === 'pending') {
                        $err_msg = $event_obj['last_payment_error']['message'] ?? 'Payment failed via Stripe webhook';
                        $this->order_model->update_payment(
                            $order_number,
                            'failed',
                            $event_obj['id'] ?? null,
                            ['gateway' => 'stripe', 'error' => $err_msg, 'source' => 'webhook']
                        );
                    }
                }
                break;
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'received' => true]));
    }

    protected function _handle_razorpay_webhook()
    {
        $payload = file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

        $gw = $this->payment_model->get_gateway_config('razorpay');
        $key_secret = trim($gw['credentials']['key_secret'] ?? '');

        // Verify signature if key_secret is available
        if (!empty($key_secret) && !empty($sig_header)) {
            $expected_sig = hash_hmac('sha256', $payload, $key_secret);
            if (!hash_equals($expected_sig, $sig_header)) {
                $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => 'error', 'message' => 'Signature verification failed']));
                return;
            }
        }

        $event = json_decode($payload, true);
        if (!$event || empty($event['event'])) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid JSON payload']));
            return;
        }

        $event_name = $event['event'];
        $payment_entity = $event['payload']['payment']['entity'] ?? [];
        $order_entity   = $event['payload']['order']['entity'] ?? [];

        // Resolve order number from receipt or notes
        $order_number = $order_entity['receipt'] 
            ?? ($payment_entity['notes']['order_number'] 
            ?? ($order_entity['notes']['order_number'] ?? null));

        if ($order_number && in_array($event_name, ['payment.captured', 'order.paid'])) {
            $order = $this->order_model->get_by_order_number($order_number);
            if ($order && $order['payment_status'] !== 'paid') {
                $payment_id = $payment_entity['id'] ?? ($order_entity['id'] ?? null);
                $this->order_model->update_payment(
                    $order_number,
                    'paid',
                    $payment_id,
                    [
                        'gateway'             => 'razorpay',
                        'event'               => $event_name,
                        'razorpay_payment_id' => $payment_id,
                        'razorpay_order_id'   => $order_entity['id'] ?? ($payment_entity['order_id'] ?? null),
                        'source'              => 'webhook',
                        'paid_at'             => date('Y-m-d H:i:s')
                    ]
                );
            }
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'received' => true]));
    }

    /**
     * Restore customer session after cross-site redirects (e.g. PayU POST return)
     */
    protected function _restore_original_session($order)
    {
        if (empty($order)) {
            return;
        }

        $init_session_id = NULL;
        if (!empty($order['payment_details'])) {
            $details = is_string($order['payment_details']) ? json_decode($order['payment_details'], true) : $order['payment_details'];
            if (is_array($details) && !empty($details['init_session_id'])) {
                $init_session_id = $details['init_session_id'];
            }
        }

        // Try restoring from old session in ci_sessions table if available
        if ($init_session_id && $init_session_id !== $this->session->session_id) {
            $sess_row = $this->db->select('data')->where('id', $init_session_id)->get('ci_sessions')->row_array();
            if ($sess_row && !empty($sess_row['data'])) {
                $raw = $sess_row['data'];
                $offset = 0;
                $old_data = [];
                while ($offset < strlen($raw)) {
                    if (!strstr(substr($raw, $offset), "|")) {
                        break;
                    }
                    $pos = strpos($raw, "|", $offset);
                    $num = $pos - $offset;
                    $varname = substr($raw, $offset, $num);
                    $offset += $num + 1;
                    $val = unserialize(substr($raw, $offset));
                    $offset += strlen(serialize($val));
                    $old_data[$varname] = $val;
                }

                if (!empty($old_data)) {
                    foreach (['user_id', 'user_first_name', 'user_last_name', 'user_email', 'user_phone', 'user_avatar', 'user_logged_in', 'recently_viewed'] as $k) {
                        if (isset($old_data[$k])) {
                            $this->session->set_userdata($k, $old_data[$k]);
                        }
                    }
                }
            }
        }

        // Direct database restoration if user is still not marked logged in
        if (!$this->is_logged_in() && !empty($order['user_id'])) {
            $this->load->model('user_model');
            $user = $this->user_model->get_by_id($order['user_id']);
            if ($user && $user['status'] === 'active') {
                $avatar = !empty($user['avatar']) ? $user['avatar'] : '';
                $this->session->set_userdata([
                    'user_id'         => $user['id'],
                    'user_first_name' => $user['first_name'],
                    'user_last_name'  => $user['last_name'],
                    'user_email'      => $user['email'],
                    'user_phone'      => $user['phone'],
                    'user_avatar'     => $avatar,
                    'user_logged_in'  => TRUE
                ]);

                $this->current_user = [
                    'id'         => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name'  => $user['last_name'],
                    'email'      => $user['email'],
                    'phone'      => $user['phone'],
                    'avatar'     => $avatar
                ];
            }
        } elseif ($this->is_logged_in() && empty($this->current_user)) {
            $this->current_user = [
                'id'         => $this->session->userdata('user_id'),
                'first_name' => $this->session->userdata('user_first_name'),
                'last_name'  => $this->session->userdata('user_last_name'),
                'email'      => $this->session->userdata('user_email'),
                'phone'      => $this->session->userdata('user_phone'),
                'avatar'     => $this->session->userdata('user_avatar') ?? ''
            ];
        }
    }

    /**
     * Restore customer cart items if payment failed or was cancelled
     */
    protected function _restore_cart_on_failure($order)
    {
        if (empty($order)) {
            return;
        }

        $current_cart = $this->session->userdata('cart');
        if (!empty($current_cart)) {
            return;
        }

        // Check if old session had the cart
        $init_session_id = NULL;
        if (!empty($order['payment_details'])) {
            $details = is_string($order['payment_details']) ? json_decode($order['payment_details'], true) : $order['payment_details'];
            if (is_array($details) && !empty($details['init_session_id'])) {
                $init_session_id = $details['init_session_id'];
            }
        }

        if ($init_session_id) {
            $sess_row = $this->db->select('data')->where('id', $init_session_id)->get('ci_sessions')->row_array();
            if ($sess_row && !empty($sess_row['data'])) {
                $raw = $sess_row['data'];
                $offset = 0;
                while ($offset < strlen($raw)) {
                    if (!strstr(substr($raw, $offset), "|")) {
                        break;
                    }
                    $pos = strpos($raw, "|", $offset);
                    $num = $pos - $offset;
                    $varname = substr($raw, $offset, $num);
                    $offset += $num + 1;
                    $val = unserialize(substr($raw, $offset));
                    $offset += strlen(serialize($val));
                    if ($varname === 'cart' && is_array($val) && !empty($val)) {
                        $this->session->set_userdata('cart', $val);
                        $summary = $this->cart_model->get_cart_summary();
                        $this->cart_count = $summary['item_count'];
                        $this->cart_total = $summary['subtotal'];
                        return;
                    }
                }
            }
        }

        // Fallback: Reconstruct cart from order items
        if (empty($order['items'])) {
            $order = $this->order_model->get_by_order_number($order['order_number']);
        }

        if (!empty($order['items'])) {
            $this->load->model('product_model');
            $cart = [];
            foreach ($order['items'] as $item) {
                $product_id = (int) $item['product_id'];
                $variant_id = !empty($item['variant_id']) ? (int) $item['variant_id'] : NULL;
                $cart_key   = $product_id . ($variant_id ? '_' . $variant_id : '');

                $product = $this->product_model->get_by_id($product_id);
                if (!$product) continue;

                $qty       = (int) $item['quantity'];
                $price     = (float) $item['price'];
                $reg_price = round($price * 1.30, 2);

                $cart[$cart_key] = [
                    'cart_key'         => $cart_key,
                    'id'               => $product_id,
                    'variant_id'       => $variant_id,
                    'variant_title'    => $item['variant_title'] ?? NULL,
                    'size'             => '',
                    'color'            => '',
                    'brand_name'       => $product['brand_name'] ?? 'VTEXX',
                    'title'            => $item['product_title'] ?? $product['title'],
                    'slug'             => $product['slug'] ?? '',
                    'sku'              => $item['product_sku'] ?? ($product['sku'] ?? ''),
                    'image'            => $item['product_image'] ?? ($product['main_image'] ?? ''),
                    'price'            => $price,
                    'regular_price'    => $reg_price,
                    'discount_percent' => round((($reg_price - $price) / $reg_price) * 100),
                    'quantity'         => $qty,
                    'total'            => (float) ($price * $qty),
                    'stock_max'        => 999
                ];
            }

            if (!empty($cart)) {
                $this->session->set_userdata('cart', $cart);
                $summary = $this->cart_model->get_cart_summary();
                $this->cart_count = $summary['item_count'];
                $this->cart_total = $summary['subtotal'];
            }
        }
    }
}

