<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Static_template_data.php';

/**
 * MY_Controller
 * Base Controller for Multi-Template E-Commerce Storefront
 * Template 1 (Fashion) operates 100% statically from Static_template_data with zero DB dependencies.
 */
class MY_Controller extends CI_Controller {

    public $tenant_id       = 1;
    public $tenant          = [];
    public $active_template = 'fashion';
    public $is_preview_mode = FALSE;

    public $current_user    = NULL;
    public $cart_count      = 0;
    public $cart_total      = 0.00;
    public $store_settings  = [];
    public $site_name       = 'Store';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'html', 'form', 'text', 'string', 'security', 'date']);
        $this->load->library(['session', 'form_validation', 'template_registry']);

        // 1. Resolve Active Template
        $this->_resolve_tenant_and_template();

        // 2. Always set static logged-in customer (No login page; always show after-login dropdown menu)
        $this->current_user = Static_template_data::get('user');

        // 3. Static Store Settings
        $this->store_settings = Static_template_data::get('settings');
        $this->site_name      = !empty($this->store_settings['site_name']) ? $this->store_settings['site_name'] : 'Store';

        // 4. Static Cart Summary
        $cart_summary     = Static_template_data::get('cart_summary');
        $this->cart_count = (int) ($cart_summary['item_count'] ?? 2);
        $this->cart_total = (float) ($cart_summary['subtotal'] ?? 0.00);
    }

    protected function _resolve_tenant_and_template()
    {
        // Check if exiting preview mode
        if ($this->input->get('exit_preview')) {
            $this->session->unset_userdata('preview_tpl');
        }

        // Check if explicit preview_tpl parameter is passed
        $preview_param = strtolower(trim((string) $this->input->get('preview_tpl')));
        if ($preview_param !== '' && $this->template_registry->is_valid($preview_param)) {
            $this->session->set_userdata('preview_tpl', $preview_param);
        } else {
            $uri_seg1 = strtolower((string) $this->uri->segment(1));
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($uri_seg1 === '' || $uri_seg1 === 'home') && $preview_param === '') {
                $this->session->unset_userdata('preview_tpl');
            }
        }

        $active_preview = $this->session->userdata('preview_tpl');
        if (!empty($active_preview) && $this->template_registry->is_valid($active_preview)) {
            $canonical_tpl         = $this->template_registry->get_canonical_key($active_preview);
            $this->is_preview_mode = TRUE;
            $this->active_template = $canonical_tpl;
            $this->tenant_id       = 1;
            $this->tenant          = [
                'id'            => 1,
                'business_name' => ucfirst($canonical_tpl) . ' Store',
                'slug'          => 'fashion-store',
                'template'      => $canonical_tpl
            ];
            return;
        }

        // Default: Template 1 (Fashion)
        $this->tenant_id       = 1;
        $this->active_template = 'fashion';
        $this->tenant          = [
            'id'            => 1,
            'business_name' => 'Store',
            'slug'          => 'fashion-store',
            'template'      => 'fashion'
        ];
    }

    public function is_logged_in()
    {
        // Always logged in for static template mode (shows after-login dropdown menu)
        return TRUE;
    }

    public function require_login()
    {
        // No-op: no login page in template mode
        return TRUE;
    }

    public function render($view, $data = [], $return = FALSE)
    {
        $all_products = Static_template_data::get('products');
        $addresses    = Static_template_data::get('addresses');

        $data['nav_categories']       = isset($data['nav_categories']) ? $data['nav_categories'] : array_slice(Static_template_data::get('root_categories'), 0, 10);
        $data['category_tree']        = isset($data['category_tree']) ? array_slice($data['category_tree'], 0, 10) : array_slice(Static_template_data::get('category_tree'), 0, 10);
        $data['current_user']         = $this->current_user;
        $data['cart_count']           = $this->cart_count;
        $data['cart_total']           = $this->cart_total;
        $data['cart_items']           = isset($data['cart_items']) ? $data['cart_items'] : Static_template_data::get('cart_items');
        $data['wishlist_count']       = isset($data['wishlist_count']) ? $data['wishlist_count'] : 4;
        $data['recommended_products'] = isset($data['recommended_products']) ? $data['recommended_products'] : array_slice($all_products, 0, 4);
        $data['store_settings']       = $this->store_settings;
        $data['currency_symbol']      = $this->store_settings['currency_symbol'] ?? '$';
        $data['currency_code']        = $this->store_settings['currency_code'] ?? 'USD';
        $data['is_logged_in']         = TRUE;
        $data['site_name']            = $this->site_name;
        $data['tenant']               = $this->tenant;
        $data['tenant_id']            = $this->tenant_id;
        $data['active_template']      = $this->active_template;
        $data['is_preview_mode']      = $this->is_preview_mode;

        $data['user_addresses']       = isset($data['user_addresses']) ? $data['user_addresses'] : $addresses;
        $data['active_address']       = isset($data['active_address']) ? $data['active_address'] : (!empty($addresses[0]) ? $addresses[0] : NULL);

        $data['title']                = isset($data['title']) ? $data['title'] : $this->site_name;
        $data['active_page']          = isset($data['active_page']) ? $data['active_page'] : 'home';

        return $this->template_registry->render($this->active_template, $view, $data, $return);
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
