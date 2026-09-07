<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class settings extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
    }

    public function index()
    {
        $this->require_permission('settings.manage');

        if ($this->input->method() === 'post') {
            $group = $this->input->post('setting_group', TRUE) ?: 'general';
            $post_data = $this->input->post(NULL, TRUE);

            foreach ($post_data as $key => $val) {
                if ($key !== 'setting_group') {
                    $this->setting_model->set($key, $val, $group);
                }
            }

            $this->session->set_flashdata('success', ucfirst($group) . ' settings updated successfully.');
            redirect('settings?tab=' . $group);
        }

        $active_tab = $this->input->get('tab') ?: 'general';

        $data = [
            'title'          => 'System & Store Settings | Admin',
            'active_menu'    => 'settings',
            'active_submenu' => 'store_settings',
            'active_tab'     => $active_tab,
            'settings'       => $this->setting_model->get_all()
        ];

        $this->render('settings/index', $data);
    }

    public function payment()
    {
        $this->require_permission('gateways.manage');

        if ($this->input->method() === 'post') {
            $gateway = $this->input->post('gateway', TRUE);

            if ($gateway === 'stripe') {
                $credentials = [
                    'publishable_key' => $this->input->post('stripe_publishable_key', TRUE),
                    'secret_key'      => $this->input->post('stripe_secret_key', TRUE),
                    'webhook_secret'  => $this->input->post('stripe_webhook_secret', TRUE)
                ];
                $this->setting_model->update_payment_gateway(
                    'stripe',
                    $this->input->post('stripe_active') ? 1 : 0,
                    $this->input->post('stripe_env', TRUE),
                    $credentials
                );
            } elseif ($gateway === 'razorpay') {
                $credentials = [
                    'key_id'     => $this->input->post('razorpay_key_id', TRUE),
                    'key_secret' => $this->input->post('razorpay_key_secret', TRUE)
                ];
                $this->setting_model->update_payment_gateway(
                    'razorpay',
                    $this->input->post('razorpay_active') ? 1 : 0,
                    $this->input->post('razorpay_env', TRUE),
                    $credentials
                );
            } elseif ($gateway === 'payu') {
                $credentials = [
                    'merchant_key'  => $this->input->post('payu_merchant_key', TRUE),
                    'merchant_salt' => $this->input->post('payu_merchant_salt', TRUE),
                    'test_url'      => 'https://test.payu.in/_payment',
                    'live_url'      => 'https://secure.payu.in/_payment'
                ];
                $this->setting_model->update_payment_gateway(
                    'payu',
                    $this->input->post('payu_active') ? 1 : 0,
                    $this->input->post('payu_env', TRUE),
                    $credentials
                );
            }

            $this->session->set_flashdata('success', strtoupper($gateway) . ' gateway configuration updated.');
            redirect('settings/payment');
        }

        $data = [
            'title'          => 'Payment Gateways Configuration | Admin',
            'active_menu'    => 'settings',
            'active_submenu' => 'payment_gateways',
            'gateways'       => $this->setting_model->get_payment_gateways()
        ];

        $this->render('settings/payment', $data);
    }
}
