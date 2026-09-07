<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 * Base Controller for E-Commerce Storefront
 */
class MY_Controller extends CI_Controller {

    public $current_user = NULL;
    public $cart_count   = 0;
    public $cart_total   = 0.00;
    public $store_settings = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'html', 'form', 'text', 'string', 'security', 'date']);
        $this->load->library(['session', 'form_validation']);

        // Models
        $this->load->model('setting_model');
        $this->load->model('cart_model');

        // Current Customer
        if ($this->session->userdata('user_logged_in')) {
            $this->current_user = [
                'id'         => $this->session->userdata('user_id'),
                'first_name' => $this->session->userdata('user_first_name'),
                'last_name'  => $this->session->userdata('user_last_name'),
                'email'      => $this->session->userdata('user_email'),
                'phone'      => $this->session->userdata('user_phone')
            ];
        }

        // Store settings
        $this->store_settings = $this->setting_model->get_all();

        // Cart Summary
        $cart_summary = $this->cart_model->get_cart_summary();
        $this->cart_count = $cart_summary['item_count'];
        $this->cart_total = $cart_summary['subtotal'];
    }

    public function is_logged_in()
    {
        return (bool) $this->session->userdata('user_logged_in');
    }

    public function require_login()
    {
        if (!$this->is_logged_in()) {
            $this->session->set_userdata('redirect_url', current_url());
            $this->session->set_flashdata('error', 'Please log in to access this page.');
            redirect('auth/login');
        }
    }

    public function render($view, $data = [], $return = FALSE)
    {
        // Load categories for navigation
        $this->load->model('category_model');
        $data['nav_categories']  = $this->category_model->get_all();
        $data['category_tree']   = $this->category_model->get_tree();
        $data['current_user']    = $this->current_user;
        $data['cart_count']      = $this->cart_count;
        $data['cart_total']      = $this->cart_total;
        $data['cart_items']      = $this->cart_model->get_items();
        $data['store_settings']  = $this->store_settings;
        $data['currency_symbol'] = $this->store_settings['currency_symbol'] ?? '$';
        $data['currency_code']   = $this->store_settings['currency_code'] ?? 'USD';

        $data['title']       = isset($data['title']) ? $data['title'] : ($this->store_settings['site_name'] ?? 'Modave eCommerce');
        $data['active_page'] = isset($data['active_page']) ? $data['active_page'] : 'home';

        if ($return) {
            $content  = $this->load->view('layouts/header', $data, TRUE);
            $content .= $this->load->view('layouts/topbar', $data, TRUE);
            $content .= $this->load->view('layouts/navbar', $data, TRUE);
            $content .= $this->load->view($view, $data, TRUE);
            $content .= $this->load->view('layouts/footer', $data, TRUE);
            $content .= $this->load->view('layouts/modals', $data, TRUE);
            return $content;
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/topbar', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer', $data);
        $this->load->view('layouts/modals', $data);
    }

    public function json_response($data, $status = 200)
    {
        $this->output
             ->set_status_header($status)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
             ->_display();
        exit;
    }
}
