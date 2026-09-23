<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function detail($slug)
    {
        $product = $this->product_model->get_by_slug($slug);
        if (!$product) {
            show_404();
        }

        $related_products = $this->product_model->get_related($product['category_id'], $product['id'], 8);
        $frequently_bought_together = $this->product_model->get_frequently_bought_together($product['id'], $product['category_id'], 2);

        // Recently viewed tracking (Session based)
        $recently_viewed_ids = $this->session->userdata('recently_viewed') ?: [];
        if (!is_array($recently_viewed_ids)) {
            $recently_viewed_ids = [];
        }
        $recently_viewed_ids = array_values(array_diff($recently_viewed_ids, [$product['id']]));
        array_unshift($recently_viewed_ids, (int) $product['id']);
        $recently_viewed_ids = array_slice($recently_viewed_ids, 0, 10);
        $this->session->set_userdata('recently_viewed', $recently_viewed_ids);

        // Fetch other recently viewed products to show on page (exclude current)
        $display_viewed_ids = array_values(array_diff($recently_viewed_ids, [$product['id']]));
        $display_viewed_ids = array_slice($display_viewed_ids, 0, 8);
        $recently_viewed_products = !empty($display_viewed_ids) ? $this->product_model->get_by_ids($display_viewed_ids) : [];

        // Wishlist & Compare status
        $is_in_wishlist = false;
        if ($this->is_logged_in()) {
            $this->load->model('wishlist_model');
            $is_in_wishlist = $this->wishlist_model->is_wishlisted($this->current_user['id'], $product['id']);
        }
        $compare_ids = $this->session->userdata('compare_products') ?: [];
        $is_in_compare = is_array($compare_ids) && in_array($product['id'], $compare_ids);

        $data = [
            'title'                      => $product['title'] . ' - ' . $this->site_name,
            'active_page'                => 'shop',
            'product'                    => $product,
            'related_products'           => $related_products,
            'frequently_bought_together' => $frequently_bought_together,
            'recently_viewed_products'   => $recently_viewed_products,
            'is_in_wishlist'             => $is_in_wishlist,
            'is_in_compare'              => $is_in_compare
        ];

        $this->render('product/detail', $data);
    }

    public function get_variant_ajax()
    {
        $variant_id = (int) $this->input->get('variant_id');
        if (!$variant_id) {
            $this->json_response(['success' => false, 'message' => 'Variant ID is required.'], 400);
            return;
        }

        $variant = $this->product_model->get_variant_by_id($variant_id);
        if (!$variant) {
            $this->json_response(['success' => false, 'message' => 'Variant not found.'], 404);
            return;
        }

        $this->json_response([
            'success' => true,
            'variant' => [
                'id'             => $variant['id'],
                'product_id'     => $variant['product_id'],
                'title'          => $variant['title'],
                'sku'            => $variant['sku'],
                'price'          => (float) $variant['price'],
                'sale_price'     => !empty($variant['sale_price']) ? (float) $variant['sale_price'] : null,
                'stock_quantity' => (int) $variant['stock_quantity'],
                'stock_status'   => $variant['stock_status'],
                'image'          => $variant['image'] ? base_url('assets/images/' . $variant['image']) : null,
                'highlights'     => !empty($variant['highlights']) ? (json_decode($variant['highlights'], true) ?: []) : [],
                'specifications' => !empty($variant['specifications']) ? (json_decode($variant['specifications'], true) ?: []) : []
            ]
        ]);
    }

    public function review()
    {
        if ($this->input->method() === 'post') {
            $product_id = (int) $this->input->post('product_id');
            $slug       = $this->input->post('product_slug', TRUE);

            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('rating', 'Rating', 'required|numeric|greater_than[0]|less_than_equal_to[5]');
            $this->form_validation->set_rules('review', 'Review', 'required|trim|min_length[5]');

            if ($this->form_validation->run() === TRUE) {
                $this->product_model->add_review([
                    'product_id'     => $product_id,
                    'user_id'        => $this->current_user['id'] ?? NULL,
                    'customer_name'  => $this->input->post('name', TRUE),
                    'customer_email' => $this->input->post('email', TRUE),
                    'rating'         => (int) $this->input->post('rating'),
                    'review'         => $this->input->post('review', TRUE),
                    'status'         => 'approved'
                ]);

                $this->session->set_flashdata('success', 'Thank you! Your review has been published.');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }

            redirect('product/' . $slug);
        }
        redirect('shop');
    }
}
