<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Controller
 * Renders the single common static Product Details page for all product links.
 */
class product extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->detail('common');
    }

    public function detail($slug = 'common')
    {
        // Always load the single common static product regardless of slug
        $product      = Static_template_data::get('common_product');
        $all_products = Static_template_data::get('products');

        $other_products = array_values(array_filter($all_products, function($p) use ($product) {
            return (int)$p['id'] !== (int)$product['id'];
        }));

        $related_products           = array_slice($other_products, 0, 8);
        $frequently_bought_together = array_slice($other_products, 0, 2);
        $recently_viewed_products   = array_slice($other_products, 2, 4);

        $data = [
            'title'                      => $product['title'] . ' - ' . $this->site_name,
            'active_page'                => 'shop',
            'product'                    => $product,
            'related_products'           => $related_products,
            'frequently_bought_together' => $frequently_bought_together,
            'recently_viewed_products'   => $recently_viewed_products,
            'is_in_wishlist'             => FALSE,
            'is_in_compare'              => FALSE
        ];

        $this->render('product/detail', $data);
    }

    public function get_variant_ajax()
    {
        $variant_id = (int) $this->input->get('variant_id');
        $product    = Static_template_data::get('common_product');
        $variants   = $product['variants'] ?? [];

        $matched = NULL;
        foreach ($variants as $v) {
            if ((int)$v['id'] === $variant_id) {
                $matched = $v;
                break;
            }
        }
        if (!$matched && !empty($variants[0])) {
            $matched = $variants[0];
        }

        if (!$matched) {
            $this->json_response(['success' => false, 'message' => 'Variant not found.'], 404);
            return;
        }

        $this->json_response([
            'success' => true,
            'variant' => [
                'id'             => $matched['id'],
                'product_id'     => $matched['product_id'],
                'title'          => $matched['title'],
                'sku'            => $matched['sku'],
                'price'          => (float) $matched['price'],
                'sale_price'     => !empty($matched['sale_price']) ? (float) $matched['sale_price'] : null,
                'stock_quantity' => (int) $matched['stock_quantity'],
                'stock_status'   => $matched['stock_status'],
                'image'          => !empty($matched['image']) ? base_url('assets/images/' . $matched['image']) : null,
                'highlights'     => !empty($matched['highlights']) ? (is_array($matched['highlights']) ? $matched['highlights'] : (json_decode($matched['highlights'], true) ?: [])) : [],
                'specifications' => !empty($matched['specifications']) ? (is_array($matched['specifications']) ? $matched['specifications'] : (json_decode($matched['specifications'], true) ?: [])) : []
            ]
        ]);
    }

    public function review()
    {
        $slug = $this->input->post('product_slug', TRUE) ?: 'v-neck-cotton-t-shirt';
        $this->session->set_flashdata('success', 'Thank you! Your review has been published (Template Demo Mode).');
        redirect('product/' . $slug);
    }
}
