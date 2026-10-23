<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('category_model');
        $this->load->model('brand_model');
        $this->load->model('banner_model');
    }

    public function index()
    {
        $banners        = $this->banner_model->get_active_banners();
        $products       = $this->product_model->get_products([], 16, 0);
        $total_products = $this->product_model->count_products([]);
        $brands         = $this->brand_model->get_all();
        $categories     = $this->category_model->get_root_categories();

        $deal_products = $this->product_model->get_products(['on_sale' => 1], 8, 0);
        if (empty($deal_products)) {
            $deal_products = array_slice($products, 0, 8);
        }

        $new_products = $this->product_model->get_products(['is_new' => 1], 8, 0);
        if (empty($new_products)) {
            $new_products = array_slice($products, 0, 8);
        }

        $featured_list = $this->product_model->get_featured(4);
        $featured_product = !empty($featured_list[0]) ? $featured_list[0] : (!empty($products[0]) ? $products[0] : null);
        if ($featured_product && !empty($featured_product['slug'])) {
            $full_fp = $this->product_model->get_by_slug($featured_product['slug']);
            if ($full_fp) {
                $featured_product = $full_fp;
            }
        }

        $data = [
            'title'            => $this->site_name . ' - Multipurpose eCommerce',
            'active_page'      => 'home',
            'banners'          => $banners,
            'products'         => $products,
            'deal_products'    => $deal_products,
            'new_products'     => $new_products,
            'featured_product' => $featured_product,
            'categories'       => $categories,
            'total_products'   => $total_products,
            'brands'           => $brands
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

        $products = $this->product_model->get_products([], $limit, $offset);
        $total    = $this->product_model->count_products([]);
        $has_more = ($offset + count($products)) < $total;

        $currency_symbol = $this->store_settings['currency_symbol'] ?? '$';

        $html = '';
        if (!empty($products)) {
            foreach ($products as $p) {
                $html .= $this->load->view('home/_product_card', [
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
