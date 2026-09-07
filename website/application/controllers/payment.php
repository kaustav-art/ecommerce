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
            $this->session->set_flashdata('success', 'Payment confirmed via PayU!');
            redirect('payment/success/' . $order_number);
        } else {
            $this->order_model->update_payment($order_number, 'failed', $txnid, $post_data);
            $this->session->set_flashdata('error', 'PayU payment was declined or could not be verified.');
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

        $data = [
            'title'       => 'Payment Failed - #' . $order_number,
            'active_page' => 'checkout',
            'order'       => $order
        ];

        $this->render('payment/failure', $data);
    }
}
