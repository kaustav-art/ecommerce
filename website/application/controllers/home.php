<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tpl_key = $this->template_registry->get_tpl_key($this->active_template);

        // Load Superadmin Template Customizer Section Headings
        $tpl_settings = [];
        if (isset($this->db) && $this->db->table_exists('template_layout_settings')) {
            $s_rows = $this->db->where('template_key', $tpl_key)->get('template_layout_settings')->result_array();
            foreach ($s_rows as $sr) {
                $tpl_settings[$sr['section_key']][$sr['setting_key']] = $sr['setting_value'];
            }
        }

        // Load dynamic Hero Banners, Categories, and Products from Superadmin panel
        $banners        = $this->get_dynamic_template_banners($tpl_key);
        $categories     = $this->get_dynamic_template_categories($tpl_key);
        $products       = $this->get_dynamic_template_products($tpl_key);
        $total_products = count($products);
        $brands         = Static_template_data::get('brands');

        $deal_products = array_values(array_filter($products, function($p) {
            return !empty($p['sale_price']);
        }));
        if (empty($deal_products)) {
            $deal_products = array_slice($products, 0, 8);
        }

        $new_products        = array_slice($products, 0, 8);
        $featured_products   = array_slice($products, 0, 8);
        $sale_products       = $deal_products;
        $bestseller_products = array_slice($products, 0, 8);
        $featured_product    = !empty($products[0]) ? $products[0] : Static_template_data::get('common_product');

        $data = [
            'title'               => $this->site_name . ' - Multipurpose eCommerce',
            'active_page'         => 'home',
            'tpl_settings'        => $tpl_settings,
            'banners'             => $banners,
            'products'            => $products,
            'deal_products'       => $deal_products,
            'new_products'        => $new_products,
            'featured_products'   => $featured_products,
            'sale_products'       => $sale_products,
            'bestseller_products' => $bestseller_products,
            'featured_product'    => $featured_product,
            'categories'          => $categories,
            'nav_categories'      => $categories,
            'category_tree'       => $categories,
            'total_products'      => $total_products,
            'brands'              => $brands
        ];

        $this->render('home/index', $data);
    }

    public function load_more()
    {
        $offset = (int) $this->input->get('offset');
        $limit  = (int) ($this->input->get('limit') ?: 16);
        if ($limit <= 0 || $limit > 50) {
            $limit = 16;
        }
        if ($offset < 0) {
            $offset = 0;
        }

        $tpl_key      = $this->template_registry->get_tpl_key($this->active_template);
        $all_products = $this->get_dynamic_template_products($tpl_key);
        $products     = array_slice($all_products, $offset, $limit);
        $total        = count($all_products);
        $has_more     = ($offset + count($products)) < $total;

        $currency_symbol = $this->store_settings['currency_symbol'] ?? '$';

        $html = '';
        if (!empty($products)) {
            foreach ($products as $p) {
                $html .= $this->load->view('template1/home/_product_card', [
                    'p'               => $p,
                    'currency_symbol' => $currency_symbol
                ], TRUE);
            }
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode([
                 'status'   => 'success',
                 'count'    => count($products),
                 'has_more' => $has_more,
                 'html'     => $html
             ]));
    }
}
