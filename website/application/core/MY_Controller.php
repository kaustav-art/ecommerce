<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 * Base Controller for Multi-Tenant, Multi-Template E-Commerce Storefront
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

        // 1. Resolve Tenant & Active Template BEFORE loading models
        $this->_resolve_tenant_and_template();

        // 2. Enforce Cart & Customer Isolation Across Tenants
        $sess_cart_tenant = (int) $this->session->userdata('cart_tenant_id');
        if ($sess_cart_tenant !== (int) $this->tenant_id) {
            $this->session->unset_userdata('cart');
            $this->session->unset_userdata('applied_coupon');
            $this->session->set_userdata('cart_tenant_id', (int) $this->tenant_id);
        }

        // 3. Load Models (which now read $this->tenant_id)
        $this->load->model('setting_model');
        $this->load->model('cart_model');

        // 4. Current Customer (scoped to current tenant)
        if ($this->session->userdata('user_logged_in')) {
            $user_tenant_id = (int) ($this->session->userdata('user_tenant_id') ?: 1);
            if ($user_tenant_id === (int) $this->tenant_id) {
                $avatar = $this->session->userdata('user_avatar');
                if ($avatar === NULL) {
                    $this->load->model('user_model');
                    $u_row = $this->user_model->get_by_id($this->session->userdata('user_id'));
                    $avatar = !empty($u_row['avatar']) ? $u_row['avatar'] : '';
                    $this->session->set_userdata('user_avatar', $avatar);
                }
                $this->current_user = [
                    'id'         => $this->session->userdata('user_id'),
                    'first_name' => $this->session->userdata('user_first_name'),
                    'last_name'  => $this->session->userdata('user_last_name'),
                    'email'      => $this->session->userdata('user_email'),
                    'phone'      => $this->session->userdata('user_phone'),
                    'avatar'     => $avatar
                ];
            }
        }

        // 5. Store settings
        $this->store_settings = $this->setting_model->get_all();
        if (!empty($this->tenant['business_name']) && (empty($this->store_settings['site_name']) || $this->tenant_id > 1)) {
            $this->store_settings['site_name'] = $this->store_settings['site_name'] ?? $this->tenant['business_name'];
        }
        $this->site_name = !empty($this->store_settings['site_name']) ? $this->store_settings['site_name'] : ($this->tenant['business_name'] ?? 'Store');

        // 6. Cart Summary
        $cart_summary = $this->cart_model->get_cart_summary();
        $this->cart_count = $cart_summary['item_count'];
        $this->cart_total = $cart_summary['subtotal'];
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
            $this->session->unset_userdata('active_tenant_slug');
        }

        // Check if a specific tenant slug is requested via route (/website/s/<slug>) or ?store=<slug>
        $route_slug = defined('SAAS_ROUTE_SLUG') ? SAAS_ROUTE_SLUG : '';
        $query_slug = strtolower(trim((string) $this->input->get('store')));
        $requested_slug = $route_slug ?: $query_slug;

        if ($requested_slug !== '') {
            // Visiting a specific tenant exits template demo preview
            $this->session->unset_userdata('preview_tpl');
            if ($requested_slug === 'default' || $requested_slug === 'fashion-store') {
                $this->session->unset_userdata('active_tenant_slug');
                $requested_slug = 'fashion-store';
            } else {
                $this->session->set_userdata('active_tenant_slug', $requested_slug);
            }
        } else {
            // If direct GET visit to /website/home or /website/ without /s/<slug>, ?store=, or ?preview_tpl=,
            // ensure http://localhost/ecommerce/website/home renders Default Fashion Store unless preview_tpl was explicitly passed
            $uri_seg1 = strtolower((string) $this->uri->segment(1));
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($uri_seg1 === '' || $uri_seg1 === 'home') && $preview_param === '') {
                $this->session->unset_userdata('preview_tpl');
                $this->session->unset_userdata('active_tenant_slug');
            }
        }

        // Active Demo Preview Mode
        $active_preview = $this->session->userdata('preview_tpl');
        if (!empty($active_preview) && $this->template_registry->is_valid($active_preview) && $requested_slug === '') {
            $this->is_preview_mode = TRUE;
            $this->active_template = $active_preview;
            // Use the demo tenant seeded for that template (1=fashion, 2=grocery, 3=electronics)
            $demo_tenant_map = ['fashion' => 1, 'grocery' => 2, 'electronics' => 3];
            $demo_tid = $demo_tenant_map[$active_preview] ?? 1;
            $t_row = $this->db->where('id', $demo_tid)->get('saas_tenants')->row_array();
            $this->tenant_id = $t_row ? (int) $t_row['id'] : 1;
            $this->tenant    = $t_row ?: ['id' => 1, 'business_name' => ucfirst($active_preview) . ' Demo Store', 'slug' => 'fashion-store', 'template' => $active_preview];
            return;
        }

        // Resolve Real Tenant from slug, session, or custom domain
        $slug_to_load = $requested_slug ?: (string) $this->session->userdata('active_tenant_slug');
        $tenant_row   = NULL;

        if ($slug_to_load !== '') {
            $tenant_row = $this->db->where('slug', $slug_to_load)
                                   ->or_where('domain', $slug_to_load)
                                   ->get('saas_tenants')
                                   ->row_array();
            if (!$tenant_row && $route_slug !== '') {
                show_error('The requested store "' . html_escape($route_slug) . '" does not exist.', 404, 'Store Not Found');
            }
        }

        // Check custom domain if HTTP_HOST is not localhost
        if (!$tenant_row && !empty($_SERVER['HTTP_HOST'])) {
            $host = strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST']));
            if (!in_array($host, ['localhost', '127.0.0.1'], true)) {
                $tenant_row = $this->db->where('domain', $host)
                                       ->or_where('slug', $host)
                                       ->get('saas_tenants')
                                       ->row_array();
            }
        }

        // Default fallback: Tenant 1 (Default Fashion Store)
        if (!$tenant_row) {
            $tenant_row = $this->db->where('id', 1)->get('saas_tenants')->row_array();
        }

        if ($tenant_row) {
            $this->tenant_id = (int) $tenant_row['id'];
            $this->tenant    = $tenant_row;
            $tpl = strtolower($tenant_row['template'] ?? 'fashion');
            $this->active_template = $this->template_registry->is_valid($tpl) ? $tpl : 'fashion';

            // Enforce Subscription & Tenant Status (Section 10) for non-default tenants
            if ($this->tenant_id > 1) {
                $status     = strtolower($tenant_row['status'] ?? 'active');
                $sub_status = strtolower($tenant_row['subscription_status'] ?? 'active');
                $expires_at = $tenant_row['subscription_expires_at'] ?? NULL;
                $is_expired = (!empty($expires_at) && strtotime($expires_at) < time());

                if ($status !== 'active' || in_array($sub_status, ['suspended', 'expired', 'cancelled', 'pending'], true) || $is_expired) {
                    $reason = ($status === 'suspended' || $sub_status === 'suspended') ? 'Store Suspended' : 'Subscription Expired';
                    $msg    = ($reason === 'Store Suspended')
                        ? 'This tenant store has been suspended by the platform administrator.'
                        : 'This store\'s SaaS subscription has expired or is inactive. Please renew your subscription in the tenant dashboard.';

                    if ($this->input->is_ajax_request() || $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->json_response(['status' => 'error', 'success' => false, 'message' => $msg], 403);
                    }
                    $this->output->set_status_header(503);
                    echo $this->load->view('errors/tenant_suspended', [
                        'tenant'  => $tenant_row,
                        'reason'  => $reason,
                        'message' => $msg
                    ], TRUE);
                    exit;
                }
            }
        } else {
            $this->tenant_id       = 1;
            $this->active_template = 'fashion';
            $this->tenant          = ['id' => 1, 'business_name' => 'Store', 'slug' => 'fashion-store', 'template' => 'fashion'];
        }
    }

    public function is_logged_in()
    {
        if (!$this->session->userdata('user_logged_in')) {
            return false;
        }
        $user_tid = (int) ($this->session->userdata('user_tenant_id') ?: 1);
        return $user_tid === (int) $this->tenant_id;
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
        $this->load->model('product_model');
        $data['nav_categories']       = $this->category_model->get_all();
        $data['category_tree']        = $this->category_model->get_tree();
        $data['current_user']         = $this->current_user;
        $data['cart_count']           = $this->cart_count;
        $data['cart_total']           = $this->cart_total;
        $data['cart_items']           = $this->cart_model->get_items();
        $wishlist_count = 0;
        if ($this->is_logged_in()) {
            $wishlist_count = $this->db->where('tenant_id', (int) $this->tenant_id)
                                       ->where('user_id', (int) $this->current_user['id'])
                                       ->count_all_results('wishlists');
        }
        $data['wishlist_count']       = $wishlist_count;
        $data['recommended_products'] = $this->product_model->get_products([], 4);
        $data['store_settings']       = $this->store_settings;
        $data['currency_symbol']      = $this->store_settings['currency_symbol'] ?? ($this->tenant['currency_symbol'] ?? '$');
        $data['currency_code']        = $this->store_settings['currency_code'] ?? ($this->tenant['currency_code'] ?? 'USD');
        $data['is_logged_in']         = $this->is_logged_in();
        $data['site_name']            = $this->site_name;
        $data['tenant']               = $this->tenant;
        $data['tenant_id']            = $this->tenant_id;
        $data['active_template']      = $this->active_template;
        $data['is_preview_mode']      = $this->is_preview_mode;

        // User & Delivery Addresses
        $this->load->model('user_model');
        $user_addresses = [];
        $active_address = NULL;
        if ($this->is_logged_in()) {
            $user_addresses = $this->user_model->get_addresses($this->current_user['id']);
            $selected_addr_id = $this->session->userdata('selected_address_id');
            if ($selected_addr_id) {
                foreach ($user_addresses as $addr) {
                    if ($addr['id'] == $selected_addr_id) {
                        $active_address = $addr;
                        break;
                    }
                }
            }
            if (!$active_address && !empty($user_addresses)) {
                $active_address = $user_addresses[0];
                foreach ($user_addresses as $addr) {
                    if (!empty($addr['is_default'])) {
                        $active_address = $addr;
                        break;
                    }
                }
            }
        } elseif ($this->session->userdata('guest_delivery_address')) {
            $active_address = $this->session->userdata('guest_delivery_address');
        }
        $data['user_addresses'] = $user_addresses;
        $data['active_address'] = $active_address;

        $data['title']       = isset($data['title']) ? $data['title'] : $this->site_name;
        $data['active_page'] = isset($data['active_page']) ? $data['active_page'] : 'home';

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
