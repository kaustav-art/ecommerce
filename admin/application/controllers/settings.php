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
        $tab = $this->input->get('tab') ?: 'general';
        $this->_handle_settings($tab);
    }

    public function general()
    {
        $this->_handle_settings('general');
    }

    public function shipping()
    {
        $this->_handle_settings('shipping');
    }

    public function tax()
    {
        $this->_handle_settings('tax');
    }

    public function email()
    {
        $this->_handle_settings('email');
    }

    public function sms()
    {
        $this->_handle_settings('sms');
    }

    public function seo()
    {
        $this->_handle_settings('seo');
    }

    private function _handle_settings($group)
    {
        $this->require_permission('settings.manage');

        $allowed_groups = ['general', 'shipping', 'tax', 'email', 'sms', 'seo'];
        if (!in_array($group, $allowed_groups)) {
            $group = 'general';
        }

        if ($this->input->method() === 'post') {
            $submitted_group = $this->input->post('setting_group', TRUE) ?: $group;
            $post_data = $this->input->post(NULL, TRUE);

            // Handle Logo upload for general settings
            if ($submitted_group === 'general' && !empty($_FILES['site_logo_file']['name'])) {
                $logo_dir = FCPATH . '../website/assets/images/logo/';
                if (!is_dir($logo_dir)) {
                    @mkdir($logo_dir, 0777, TRUE);
                }
                $admin_logo_dir = FCPATH . 'assets/img/branding/';
                if (!is_dir($admin_logo_dir)) {
                    @mkdir($admin_logo_dir, 0777, TRUE);
                }

                $config = [
                    'upload_path'   => $logo_dir,
                    'allowed_types' => 'gif|jpg|jpeg|png|webp|svg',
                    'max_size'      => 5120,
                    'file_name'     => 'logo_' . time() . '_' . rand(100, 999)
                ];

                if (!isset($this->upload)) {
                    $this->load->library('upload', $config);
                } else {
                    $this->upload->initialize($config);
                }

                if ($this->upload->do_upload('site_logo_file')) {
                    $upload_data = $this->upload->data();
                    $logo_file_name = $upload_data['file_name'];
                    @copy($upload_data['full_path'], $admin_logo_dir . $logo_file_name);
                    @copy($upload_data['full_path'], $admin_logo_dir . 'logo.webp');
                    @copy($upload_data['full_path'], $logo_dir . 'logo.webp');

                    $this->setting_model->set('site_logo', $logo_file_name, 'general');
                } else {
                    $this->session->set_flashdata('error', 'Logo upload error: ' . $this->upload->display_errors('', ''));
                    redirect('settings/general');
                    return;
                }
            }

            // Handle Favicon upload for general settings
            if ($submitted_group === 'general' && !empty($_FILES['site_favicon_file']['name'])) {
                $fav_dir = FCPATH . '../website/assets/images/logo/';
                if (!is_dir($fav_dir)) {
                    @mkdir($fav_dir, 0777, TRUE);
                }
                $admin_fav_dir = FCPATH . 'assets/img/favicon/';
                if (!is_dir($admin_fav_dir)) {
                    @mkdir($admin_fav_dir, 0777, TRUE);
                }

                $fav_config = [
                    'upload_path'   => $fav_dir,
                    'allowed_types' => 'gif|jpg|jpeg|png|webp|svg|ico',
                    'max_size'      => 2048,
                    'file_name'     => 'favicon_' . time() . '_' . rand(100, 999)
                ];

                if (!isset($this->upload)) {
                    $this->load->library('upload', $fav_config);
                } else {
                    $this->upload->initialize($fav_config);
                }

                if ($this->upload->do_upload('site_favicon_file')) {
                    $fav_data = $this->upload->data();
                    $fav_file_name = $fav_data['file_name'];
                    @copy($fav_data['full_path'], $admin_fav_dir . $fav_file_name);
                    @copy($fav_data['full_path'], $admin_fav_dir . 'codeulas_logo_small.webp');
                    @copy($fav_data['full_path'], $fav_dir . 'codeulas_logo_small.webp');

                    $this->setting_model->set('site_favicon', $fav_file_name, 'general');
                } else {
                    $this->session->set_flashdata('error', 'Favicon upload error: ' . $this->upload->display_errors('', ''));
                    redirect('settings/general');
                    return;
                }
            }

            // Save text settings
            foreach ($post_data as $key => $val) {
                if ($key !== 'setting_group') {
                    $this->setting_model->set($key, $val, $submitted_group);
                }
            }

            // Ensure both currency and currency_code are synchronized
            if ($submitted_group === 'general' && isset($post_data['currency_code'])) {
                $this->setting_model->set('currency', $post_data['currency_code'], 'general');
            }

            $this->session->set_flashdata('success', ucfirst($submitted_group) . ' settings updated successfully.');
            redirect('settings/' . $submitted_group);
        }

        $titles = [
            'general'  => 'General Store Settings',
            'shipping' => 'Shipping Settings & Rates',
            'tax'      => 'Tax Calculation Rules',
            'email'    => 'Email (SMTP) Settings',
            'sms'      => 'SMS Notification Gateway',
            'seo'      => 'SEO & Meta Settings'
        ];

        $data = [
            'title'          => ($titles[$group] ?? 'Store Settings') . ' | Modave Admin',
            'page_heading'   => $titles[$group] ?? 'Store Settings',
            'active_menu'    => 'settings',
            'active_submenu' => $group,
            'active_tab'     => $group,
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
