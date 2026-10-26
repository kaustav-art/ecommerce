<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Controller
 * Renders the database-driven Product Details page across all 3 templates.
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
        $all_products = Static_template_data::get('products');
        $product      = Static_template_data::get('common_product');

        $clean_slug = trim((string)$slug);
        if ($clean_slug !== '' && $clean_slug !== 'common' && !empty($all_products)) {
            foreach ($all_products as $p) {
                if ((!empty($p['slug']) && strcasecmp($p['slug'], $clean_slug) === 0) || (is_numeric($clean_slug) && (int)$p['id'] === (int)$clean_slug)) {
                    $product = $p;
                    break;
                }
            }
        }

        if ($this->active_template === 'grocery') {
            $grc_products = $this->get_dynamic_template_products('template3');
            if (!empty($grc_products)) {
                $matched_grc = null;
                foreach ($grc_products as $gp) {
                    if (!empty($gp['slug']) && strcasecmp($gp['slug'], $clean_slug) === 0) {
                        $matched_grc = $gp;
                        break;
                    }
                }
                if (!$matched_grc && !empty($product['slug'])) {
                    foreach ($grc_products as $gp) {
                        if (!empty($gp['slug']) && strcasecmp($gp['slug'], $product['slug']) === 0) {
                            $matched_grc = $gp;
                            break;
                        }
                    }
                }
                if ($matched_grc) {
                    $product = array_merge($product, $matched_grc);
                }
            }
        }

        $other_products = array_values(array_filter($all_products, function($p) use ($product) {
            return (int)($p['id'] ?? 0) !== (int)($product['id'] ?? -1);
        }));

        $related_products           = array_slice($other_products, 0, 8);
        $frequently_bought_together = array_slice($other_products, 0, 2);
        $recently_viewed_products   = array_slice($other_products, 2, 4);

        $data = [
            'title'                      => ($product['title'] ?? 'Product Details') . ' - ' . $this->site_name,
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
        $variant_id   = (int) $this->input->get('variant_id');
        $all_products = Static_template_data::get('products');
        $matched      = NULL;

        foreach ($all_products as $p) {
            if (!empty($p['variants'])) {
                foreach ($p['variants'] as $v) {
                    if ((int)$v['id'] === $variant_id) {
                        $matched = $v;
                        break 2;
                    }
                }
            }
        }

        if (!$matched) {
            $product  = Static_template_data::get('common_product');
            $variants = $product['variants'] ?? [];
            if (!empty($variants[0])) {
                $matched = $variants[0];
            }
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
        $slug = $this->input->post('product_slug', TRUE) ?: 'common';
        $this->session->set_flashdata('success', 'Thank you! Your review has been submitted.');
        redirect('product/' . $slug);
    }
}
