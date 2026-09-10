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
        $banners           = $this->banner_model->get_active_banners();
        $featured_cats     = $this->category_model->get_featured();
        $new_arrivals      = $this->product_model->get_products(['is_new' => 1], 8);
        $best_sellers      = $this->product_model->get_products(['sort' => 'popular'], 8);
        $on_sale           = $this->product_model->get_products(['on_sale' => 1], 8);
        $featured_products = $this->product_model->get_featured(8);
        $trending_products = $this->product_model->get_trending(8);
        $brands            = $this->brand_model->get_all();

        // Fallbacks if tables have small datasets
        if (empty($featured_cats)) {
            $featured_cats = $this->category_model->get_root_categories();
        }
        if (empty($new_arrivals)) {
            $new_arrivals = $featured_products;
        }
        if (empty($best_sellers)) {
            $best_sellers = $trending_products;
        }
        if (empty($on_sale)) {
            $on_sale = $featured_products;
        }

        $data = [
            'title'             => $this->site_name . ' - Multipurpose eCommerce',
            'active_page'       => 'home',
            'banners'           => $banners,
            'featured_cats'     => $featured_cats,
            'new_arrivals'      => $new_arrivals,
            'best_sellers'      => $best_sellers,
            'on_sale'           => $on_sale,
            'trending_products' => $trending_products,
            'featured_products' => $featured_products,
            'brands'            => $brands
        ];

        $this->render('home/index', $data);
    }
}
