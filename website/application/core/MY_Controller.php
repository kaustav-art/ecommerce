<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Static_template_data.php';

/**
 * MY_Controller
 * Base Controller for Multi-Template E-Commerce Storefront
 * - Header Categories, Hero Banners, and Home Page Showcase Products are dynamically loaded
 *   from the Superadmin panel (`template_categories`, `template_hero_banners`, `template_products`).
 * - Inner pages (Shop, Common Product Details, Common Order Details, Cart, Checkout, Account)
 *   operate as a static template using Static_template_data.
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
        if ($this->session->userdata('preview_tpl')) {
            $this->session->unset_userdata('preview_tpl');
        }

        $preview_param = strtolower(trim((string) $this->input->get('preview_tpl')));
        if ($preview_param !== '' && $this->template_registry->is_valid($preview_param)) {
            $canonical_tpl         = $this->template_registry->get_canonical_key($preview_param);
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

        $this->tenant_id       = 1;
        $this->active_template = 'fashion';
        $this->tenant          = [
            'id'            => 1,
            'business_name' => 'Store',
            'slug'          => 'fashion-store',
            'template'      => 'fashion'
        ];
    }

    /**
     * Normalize image path for template1 views (which prepend 'assets/images/')
     * while preserving full relative paths for template2/template3.
     */
    public function normalize_tpl_image($path, $tpl_key = 'template1')
    {
        $path = ltrim(trim((string)$path), '/');
        if ($tpl_key === 'template1') {
            if (strpos($path, 'assets/images/') === 0) {
                return substr($path, strlen('assets/images/'));
            }
        }
        return $path;
    }

    /**
     * Fetch dynamic Categories from Superadmin (`template_categories`)
     */
    public function get_dynamic_template_categories($tpl_key = null)
    {
        $tpl_key = $tpl_key ?: $this->template_registry->get_tpl_key($this->active_template);
        $cats = [];
        if (isset($this->db) && $this->db->table_exists('template_categories')) {
            $rows = $this->db->where('template_key', $tpl_key)
                             ->where('status', 'active')
                             ->order_by('sort_order', 'ASC')
                             ->order_by('id', 'ASC')
                             ->get('template_categories')
                             ->result_array();
            foreach ($rows as $r) {
                $cnt_num = (int)preg_replace('/\D+/', '', (string)($r['subtitle'] ?? '12'));
                $cats[] = [
                    'id'            => (int)$r['id'],
                    'name'          => $r['name'],
                    'slug'          => $r['slug'],
                    'subtitle'      => $r['subtitle'] ?? '',
                    'image'         => $this->normalize_tpl_image($r['image'], $tpl_key),
                    'raw_image'     => $r['image'],
                    'product_count' => $cnt_num ?: 12,
                    'children'      => []
                ];
            }
        }
        if (empty($cats)) {
            $cats = array_slice(Static_template_data::get('category_tree'), 0, 10);
        }
        return $cats;
    }

    /**
     * Fetch dynamic Hero Banners from Superadmin (`template_hero_banners`)
     */
    public function get_dynamic_template_banners($tpl_key = null)
    {
        $tpl_key = $tpl_key ?: $this->template_registry->get_tpl_key($this->active_template);
        $banners = [];
        if (isset($this->db) && $this->db->table_exists('template_hero_banners')) {
            $rows = $this->db->where('template_key', $tpl_key)
                             ->where('status', 'active')
                             ->order_by('sort_order', 'ASC')
                             ->order_by('id', 'ASC')
                             ->get('template_hero_banners')
                             ->result_array();
            foreach ($rows as $hb) {
                $banners[] = [
                    'id'          => (int)$hb['id'],
                    'subtitle'    => $hb['badge'] ?? '',
                    'badge'       => $hb['badge'] ?? '',
                    'title'       => $hb['title'],
                    'description' => $hb['description'] ?? '',
                    'button_text' => $hb['button_text'] ?: 'Explore Collection',
                    'button_link' => $hb['button_url'] ?: 'shop',
                    'button_url'  => $hb['button_url'] ?: 'shop',
                    'link_url'    => $hb['button_url'] ?: 'shop',
                    'image'       => $this->normalize_tpl_image($hb['image'], $tpl_key),
                    'raw_image'   => $hb['image']
                ];
            }
        }
        if (empty($banners)) {
            $banners = Static_template_data::get('banners');
        }
        return $banners;
    }

    /**
     * Fetch dynamic Showcase Products from Superadmin (`template_products`)
     */
    public function get_dynamic_template_products($tpl_key = null)
    {
        $tpl_key = $tpl_key ?: $this->template_registry->get_tpl_key($this->active_template);
        $products = [];
        if (isset($this->db) && $this->db->table_exists('template_products')) {
            $rows = $this->db->where('template_key', $tpl_key)
                             ->where('status', 'active')
                             ->order_by('sort_order', 'ASC')
                             ->order_by('id', 'ASC')
                             ->get('template_products')
                             ->result_array();
            foreach ($rows as $tp) {
                $main_img  = $this->normalize_tpl_image($tp['image'], $tpl_key);
                $hover_raw = !empty($tp['hover_image']) ? $tp['hover_image'] : $tp['image'];
                $hover_img = $this->normalize_tpl_image($hover_raw, $tpl_key);

                $products[] = [
                    'id'                     => (int)$tp['id'],
                    'title'                  => $tp['name'],
                    'name'                   => $tp['name'],
                    'slug'                   => $tp['slug'],
                    'category_name'          => $tp['category_name'] ?? 'Featured',
                    'price'                  => (float)$tp['price'],
                    'sale_price'             => (!empty($tp['sale_price']) && (float)$tp['sale_price'] > 0) ? (float)$tp['sale_price'] : null,
                    'main_image'             => $main_img,
                    'primary_image'          => $main_img,
                    'image'                  => $main_img,
                    'hover_image'            => $hover_img,
                    'gallery_images_decoded' => [$hover_img],
                    'badge_text'             => $tp['badge_text'] ?? '',
                    'unit_value'             => $tp['unit_label'] ?? '',
                    'unit_label'             => $tp['unit_label'] ?? '',
                    'short_description'      => $tp['short_desc'] ?? '',
                    'description'            => $tp['short_desc'] ?? '',
                    'rating'                 => isset($tp['rating']) ? (float)$tp['rating'] : 4.8,
                    'reviews_count'          => isset($tp['reviews_count']) ? (int)$tp['reviews_count'] : 18,
                    'stock'                  => 25,
                    'stock_qty'              => 25,
                ];
            }
        }
        if (empty($products)) {
            $products = Static_template_data::get('products');
        }
        return $products;
    }

    public function is_logged_in()
    {
        return TRUE;
    }

    public function require_login()
    {
        return TRUE;
    }

    public function render($view, $data = [], $return = FALSE)
    {
        $dynamic_cats = $this->get_dynamic_template_categories();
        $all_products = Static_template_data::get('products');
        $addresses    = Static_template_data::get('addresses');

        $data['nav_categories']       = isset($data['nav_categories']) ? $data['nav_categories'] : $dynamic_cats;
        $data['category_tree']        = isset($data['category_tree']) ? $data['category_tree'] : $dynamic_cats;
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
