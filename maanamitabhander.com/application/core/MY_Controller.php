<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Static_template_data.php';

/**
 * MY_Controller
 * Base Controller for Multi-Template E-Commerce Storefront
 * - 100% Database-Driven across Fashion (template1), Electronics (template2), and Grocery (template3).
 * - Supports both Superadmin Demo/Preview mode in `ecommerce_main` and standalone provisioned
 *   tenant domain folders (e.g. `ecommerce/example.com/`) with dedicated tenant databases.
 */
class MY_Controller extends CI_Controller {

    public $tenant_id       = 1;
    public $tenant          = [];
    public $active_template = 'fashion';
    public $is_preview_mode = FALSE;
    public $is_user_project = FALSE;

    public $current_user    = NULL;
    public $cart_count      = 0;
    public $cart_total      = 0.00;
    public $store_settings  = [];
    public $site_name       = 'Store';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'html', 'form', 'text', 'string', 'security', 'date']);
        $this->load->library(['session', 'form_validation', 'template_registry']);

        // 1. Resolve Active Tenant & Template from URL / Database
        $this->_resolve_tenant_and_template();

        // 2. Load customer profile:
        //    - In a user-taken project, load from session if logged in (or NULL for guest)
        //    - In Template Demo mode (website/), load demo user from Static_template_data
        if ($this->is_user_project) {
            if ($this->session->userdata('user_logged_in')) {
                $this->current_user = [
                    'id'         => (int) $this->session->userdata('user_id'),
                    'first_name' => $this->session->userdata('user_first_name'),
                    'last_name'  => $this->session->userdata('user_last_name'),
                    'email'      => $this->session->userdata('user_email'),
                    'phone'      => $this->session->userdata('user_phone'),
                    'avatar'     => $this->session->userdata('user_avatar') ?: ''
                ];
            } else {
                $this->current_user = NULL;
            }
        } else {
            $this->current_user = Static_template_data::get('user');
        }

        // 3. Load Store Settings from DB
        $this->store_settings = Static_template_data::get('settings');
        $this->site_name      = !empty($this->store_settings['site_name']) ? $this->store_settings['site_name'] : 'Store';

        // 4. Load Cart Summary from DB
        $cart_summary     = Static_template_data::get('cart_summary');
        $this->cart_count = (int) ($cart_summary['item_count'] ?? 0);
        $this->cart_total = (float) ($cart_summary['subtotal'] ?? 0.00);
    }

    protected function _resolve_tenant_and_template()
    {
        if ($this->session->userdata('preview_tpl')) {
            $this->session->unset_userdata('preview_tpl');
        }

        $db_name = isset($this->db->database) ? $this->db->database : 'ecommerce_main';
        $this->is_user_project = ($db_name !== 'ecommerce_main');
        $preview_param = strtolower(trim((string) $this->input->get('preview_tpl')));

        // Only honor ?preview_tpl= when browsing the master template demo in ecommerce_main
        if (!$this->is_user_project && $preview_param !== '' && $this->template_registry->is_valid($preview_param)) {
            $canonical_tpl         = $this->template_registry->get_canonical_key($preview_param);
            $this->is_preview_mode = TRUE;
            $this->active_template = $canonical_tpl;
            $this->tenant_id       = ($canonical_tpl === 'electronics') ? 3 : (($canonical_tpl === 'grocery') ? 2 : 1);
            $this->tenant = [
                'id'            => $this->tenant_id,
                'business_name' => ucfirst($canonical_tpl) . ' Store',
                'slug'          => $canonical_tpl . '-store',
                'template'      => $canonical_tpl
            ];
            return;
        }

        // Check if running inside a provisioned tenant database or `/s/{slug}` route
        $uri_seg1 = strtolower((string)$this->uri->segment(1));
        $uri_seg2 = strtolower((string)$this->uri->segment(2));
        if ($db_name === 'ecommerce_main' && $uri_seg1 === 's' && $uri_seg2 !== '' && $this->db->table_exists('saas_tenants')) {
            $t_row = $this->db->where('slug', $uri_seg2)->or_where('domain', $uri_seg2)->get('saas_tenants')->row_array();
            if ($t_row) {
                $this->tenant_id       = (int)$t_row['id'];
                $this->active_template = $this->template_registry->get_canonical_key($t_row['template'] ?? 'fashion');
                $this->tenant          = $t_row;
                $this->is_user_project = ($this->tenant_id > 3);
                return;
            }
        }

        // Standalone tenant database or default main database
        $this->tenant_id = 1;
        $tpl_from_settings = 'fashion';
        $site_name_setting = 'Store';

        if (isset($this->db) && $this->db->table_exists('settings')) {
            $rows = $this->db->where('tenant_id', $this->tenant_id)
                             ->where_in('setting_key', ['active_template', 'template', 'site_name'])
                             ->get('settings')
                             ->result_array();
            foreach ($rows as $r) {
                if (in_array($r['setting_key'], ['active_template', 'template'], true) && !empty($r['setting_value'])) {
                    $tpl_from_settings = $this->template_registry->get_canonical_key($r['setting_value']);
                }
                if ($r['setting_key'] === 'site_name' && !empty($r['setting_value'])) {
                    $site_name_setting = $r['setting_value'];
                }
            }
        }

        $this->active_template = $tpl_from_settings;
        $this->tenant          = [
            'id'            => $this->tenant_id,
            'business_name' => $site_name_setting,
            'slug'          => 'store',
            'template'      => $this->active_template
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
        } else {
            // For template2 and template3, if image is relative to assets/images/ (e.g. products/... or categories/...), prefix assets/images/
            if ($path !== '' && strpos($path, 'assets/') !== 0 && strpos($path, 'http') !== 0) {
                if (file_exists(FCPATH . 'assets/images/' . $path)) {
                    return 'assets/images/' . $path;
                }
            }
        }
        return $path;
    }

    /**
     * Fetch dynamic Categories from Database
     * - In provisioned tenant stores (or when tenant categories exist), reads from `categories` table
     *   so Admin Panel edits reflect immediately on the storefront.
     * - In Superadmin preview mode on `ecommerce_main`, syncs with `template_categories`.
     */
    public function get_dynamic_template_categories($tpl_key = null)
    {
        $tpl_key = $tpl_key ?: $this->template_registry->get_tpl_key($this->active_template);
        $db_name = isset($this->db->database) ? $this->db->database : 'ecommerce_main';
        $cats = [];

        // If running in a dedicated tenant DB, read directly from `categories` table (managed by Admin panel)
        if ($db_name !== 'ecommerce_main' && isset($this->db) && $this->db->table_exists('categories')) {
            $tree = Static_template_data::get('category_tree');
            if (!empty($tree)) {
                foreach ($tree as $c) {
                    $cats[] = [
                        'id'            => (int)$c['id'],
                        'name'          => $c['name'],
                        'slug'          => $c['slug'],
                        'subtitle'      => $c['description'] ?: ($c['product_count'] . ' Products'),
                        'image'         => $this->normalize_tpl_image($c['raw_image'] ?? $c['image'], $tpl_key),
                        'raw_image'     => $c['raw_image'] ?? $c['image'],
                        'product_count' => (int)($c['product_count'] ?? 12),
                        'children'      => $c['children'] ?? []
                    ];
                }
                return $cats;
            }
        }

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
     * Fetch dynamic Hero Banners from Database
     */
    public function get_dynamic_template_banners($tpl_key = null)
    {
        $tpl_key = $tpl_key ?: $this->template_registry->get_tpl_key($this->active_template);
        $db_name = isset($this->db->database) ? $this->db->database : 'ecommerce_main';
        $banners = [];

        // In dedicated tenant DB, read directly from `banners` table (managed by Admin panel)
        if ($db_name !== 'ecommerce_main' && isset($this->db) && $this->db->table_exists('banners')) {
            $rows = $this->db->where('tenant_id', $this->tenant_id)
                             ->where('status', 'active')
                             ->order_by('sort_order', 'ASC')
                             ->order_by('id', 'ASC')
                             ->get('banners')
                             ->result_array();
            foreach ($rows as $hb) {
                $banners[] = [
                    'id'          => (int)$hb['id'],
                    'subtitle'    => $hb['subtitle'] ?? '',
                    'badge'       => $hb['subtitle'] ?? '',
                    'title'       => $hb['title'],
                    'description' => $hb['subtitle'] ?? '',
                    'button_text' => $hb['button_text'] ?: 'Explore Collection',
                    'button_link' => $hb['button_link'] ?: 'shop',
                    'button_url'  => $hb['button_link'] ?: 'shop',
                    'link_url'    => $hb['button_link'] ?: 'shop',
                    'image'       => $this->normalize_tpl_image($hb['image'], $tpl_key),
                    'raw_image'   => $hb['image']
                ];
            }
            if (!empty($banners)) {
                return $banners;
            }
        }

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
     * Fetch dynamic Showcase Products from Database
     */
    public function get_dynamic_template_products($tpl_key = null)
    {
        $tpl_key = $tpl_key ?: $this->template_registry->get_tpl_key($this->active_template);
        $db_name = isset($this->db->database) ? $this->db->database : 'ecommerce_main';
        $products = [];

        // In dedicated tenant DB, read directly from `products` table (managed by Admin panel)
        if ($db_name !== 'ecommerce_main') {
            $db_prods = Static_template_data::get('products');
            if (!empty($db_prods)) {
                foreach ($db_prods as &$dp) {
                    $dp['image']         = $this->normalize_tpl_image($dp['main_image'], $tpl_key);
                    $dp['primary_image'] = $dp['image'];
                    $dp['hover_image']   = $this->normalize_tpl_image($dp['hover_image'] ?? $dp['main_image'], $tpl_key);
                }
                unset($dp);
                return $db_prods;
            }
        }

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

                $raw_unit  = trim((string)($tp['unit_label'] ?? ''));
                $clean_unit = $raw_unit;
                if ($raw_unit !== '' && $tpl_key === 'template3') {
                    if (preg_match('/^(\d+(?:\.\d+)?)\s*(kg|g|gm|ml|l|ltr|liter|litre|liters|litres|pc|pcs|piece|pieces)\b/i', $raw_unit, $um)) {
                        $u_word = $um[2];
                        if (stripos($u_word, 'piece') === 0) {
                            $u_word = ((float)$um[1] > 1) ? 'pcs' : 'pc';
                        }
                        $clean_unit = $um[1] . (in_array(strtolower($u_word), ['g', 'gm', 'ml'], true) ? strtolower($u_word) : ' ' . $u_word);
                    } elseif (preg_match('/^(\d+)\b/', $raw_unit, $um)) {
                        $clean_unit = $um[1] . (((int)$um[1] > 1) ? ' pcs' : ' pc');
                    }
                }

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
                    'unit_value'             => $clean_unit,
                    'unit_label'             => $clean_unit,
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
        if (!$this->is_user_project) {
            return TRUE;
        }
        return (bool) $this->session->userdata('user_logged_in');
    }

    public function require_login()
    {
        if (!$this->is_logged_in()) {
            $this->session->set_userdata('redirect_url', current_url());
            redirect('home');
        }
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
        $data['wishlist_count']       = isset($data['wishlist_count']) ? $data['wishlist_count'] : ($this->is_logged_in() ? 4 : 0);
        $data['recommended_products'] = isset($data['recommended_products']) ? $data['recommended_products'] : array_slice($all_products, 0, 4);
        $data['store_settings']       = $this->store_settings;
        $data['currency_symbol']      = $this->store_settings['currency_symbol'] ?? '$';
        $data['currency_code']        = $this->store_settings['currency_code'] ?? 'USD';
        $data['is_logged_in']         = $this->is_logged_in();
        $data['is_user_project']      = $this->is_user_project;
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
