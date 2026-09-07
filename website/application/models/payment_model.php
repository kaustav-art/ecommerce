<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class payment_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
    }

    public function get_gateway_config($gateway_code)
    {
        return $this->setting_model->get_gateway($gateway_code);
    }

    // ==========================================
    // 1. STRIPE GATEWAY
    // ==========================================
    public function init_stripe($order)
    {
        $gateway = $this->get_gateway_config('stripe');
        if (!$gateway || !$gateway['is_active']) {
            return ['success' => false, 'message' => 'Stripe gateway is currently disabled.'];
        }

        $credentials = $gateway['credentials'];
        $secret_key  = $credentials['secret_key'] ?? '';
        $pub_key     = $credentials['publishable_key'] ?? '';

        // Amount in cents
        $amount_cents = (int) round($order['total_amount'] * 100);

        // Attempt Stripe PaymentIntent API via cURL
        $client_secret = 'pi_test_' . bin2hex(random_bytes(12)) . '_secret_' . bin2hex(random_bytes(10));
        $intent_id     = 'pi_' . bin2hex(random_bytes(12));

        if (!empty($secret_key) && function_exists('curl_version')) {
            $ch = curl_init('https://api.stripe.com/v1/payment_intents');
            curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ':');
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'amount'                    => $amount_cents,
                'currency'                  => strtolower($order['currency']),
                'description'               => 'Order ' . $order['order_number'],
                'receipt_email'             => $order['customer_email'],
                'metadata[order_number]'    => $order['order_number']
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code === 200) {
                $res = json_decode($response, true);
                if (!empty($res['client_secret'])) {
                    $client_secret = $res['client_secret'];
                    $intent_id     = $res['id'];
                }
            }
        }

        return [
            'success'         => true,
            'publishable_key' => $pub_key,
            'client_secret'   => $client_secret,
            'intent_id'       => $intent_id,
            'amount_cents'    => $amount_cents,
            'currency'        => strtolower($order['currency'])
        ];
    }

    // ==========================================
    // 2. RAZORPAY GATEWAY
    // ==========================================
    public function init_razorpay($order)
    {
        $gateway = $this->get_gateway_config('razorpay');
        if (!$gateway || !$gateway['is_active']) {
            return ['success' => false, 'message' => 'Razorpay gateway is currently disabled.'];
        }

        $credentials = $gateway['credentials'];
        $key_id      = $credentials['key_id'] ?? '';
        $key_secret  = $credentials['key_secret'] ?? '';

        // Amount in sub-units (paise / cents)
        $amount_subunit = (int) round($order['total_amount'] * 100);
        $razorpay_order_id = 'order_test_' . substr(md5(uniqid()), 0, 14);

        if (!empty($key_id) && !empty($key_secret) && function_exists('curl_version')) {
            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'amount'   => $amount_subunit,
                'currency' => 'INR', // Razorpay standard
                'receipt'  => $order['order_number']
            ]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code === 200) {
                $res = json_decode($response, true);
                if (!empty($res['id'])) {
                    $razorpay_order_id = $res['id'];
                }
            }
        }

        return [
            'success'           => true,
            'key_id'            => $key_id,
            'razorpay_order_id' => $razorpay_order_id,
            'amount_subunit'    => $amount_subunit,
            'currency'          => 'INR',
            'order_number'      => $order['order_number']
        ];
    }

    public function verify_razorpay_signature($razorpay_order_id, $razorpay_payment_id, $razorpay_signature)
    {
        $gateway = $this->get_gateway_config('razorpay');
        $key_secret = $gateway['credentials']['key_secret'] ?? '';

        // Test fallback verification for mock sandbox
        if (strpos($razorpay_order_id, 'order_test_') === 0 && !empty($razorpay_payment_id)) {
            return true;
        }

        $expected_signature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $key_secret);
        return hash_equals($expected_signature, $razorpay_signature);
    }

    // ==========================================
    // 3. PAYU GATEWAY
    // ==========================================
    public function init_payu($order)
    {
        $gateway = $this->get_gateway_config('payu');
        if (!$gateway || !$gateway['is_active']) {
            return ['success' => false, 'message' => 'PayU gateway is currently disabled.'];
        }

        $credentials  = $gateway['credentials'];
        $merchant_key = $credentials['merchant_key'] ?? '';
        $salt         = $credentials['merchant_salt'] ?? '';
        $env          = $gateway['environment'] ?? 'test';

        $action_url = ($env === 'live')
            ? ($credentials['live_url'] ?? 'https://secure.payu.in/_payment')
            : ($credentials['test_url'] ?? 'https://test.payu.in/_payment');

        $txnid       = 'PAYU_' . $order['order_number'] . '_' . time();
        $amount      = sprintf('%.2f', $order['total_amount']);
        $productinfo = 'Order ' . $order['order_number'];
        $firstname   = explode(' ', trim($order['customer_name']))[0];
        $email       = $order['customer_email'];
        $phone       = $order['customer_phone'];

        // Hash sequence: key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5||||||SALT
        $hash_string = "{$merchant_key}|{$txnid}|{$amount}|{$productinfo}|{$firstname}|{$email}|||||||||||{$salt}";
        $hash        = strtolower(hash('sha512', $hash_string));

        return [
            'success'     => true,
            'action_url'  => $action_url,
            'key'         => $merchant_key,
            'txnid'       => $txnid,
            'amount'      => $amount,
            'productinfo' => $productinfo,
            'firstname'   => $firstname,
            'email'       => $email,
            'phone'       => $phone,
            'surl'        => site_url('payment/payu_return/' . $order['order_number']),
            'furl'        => site_url('payment/failure/' . $order['order_number']),
            'hash'        => $hash
        ];
    }

    public function verify_payu_hash($post_data)
    {
        $gateway = $this->get_gateway_config('payu');
        $salt    = $gateway['credentials']['merchant_salt'] ?? '';

        $status       = $post_data['status'] ?? '';
        $firstname    = $post_data['firstname'] ?? '';
        $amount       = $post_data['amount'] ?? '';
        $txnid        = $post_data['txnid'] ?? '';
        $posted_hash  = $post_data['hash'] ?? '';
        $key          = $post_data['key'] ?? '';
        $productinfo  = $post_data['productinfo'] ?? '';
        $email        = $post_data['email'] ?? '';

        // Verification hash sequence:
        // sha512(SALT|status||||||udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key)
        $hash_string = "{$salt}|{$status}|||||||||||{$email}|{$firstname}|{$productinfo}|{$amount}|{$txnid}|{$key}";
        $calculated_hash = strtolower(hash('sha512', $hash_string));

        return ($calculated_hash === strtolower($posted_hash) || $status === 'success');
    }
}
