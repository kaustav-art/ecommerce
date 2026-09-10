<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class compare extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function index()
    {
        $compare_ids = $this->session->userdata('compare_products') ?: [];
        $products = [];
        $all_specs = [];

        if (!empty($compare_ids) && is_array($compare_ids)) {
            $products = $this->product_model->get_by_ids($compare_ids);

            // Collect all unique specification names across these products
            foreach ($products as $p) {
                if (!empty($p['specifications'])) {
                    foreach ($p['specifications'] as $s) {
                        if (!in_array($s['spec_name'], $all_specs)) {
                            $all_specs[] = $s['spec_name'];
                        }
                    }
                }
            }
        }

        $data = [
            'title'        => 'Product Comparison - ' . $this->site_name,
            'active_page'  => 'compare',
            'products'     => $products,
            'all_specs'    => $all_specs
        ];

        $this->render('compare/index', $data);
    }

    public function add($product_id)
    {
        $product_id = (int) $product_id;
        $product = $this->product_model->get_by_id($product_id);

        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'shop');
        }

        $compare_ids = $this->session->userdata('compare_products') ?: [];
        if (!is_array($compare_ids)) {
            $compare_ids = [];
        }

        if (in_array($product_id, $compare_ids)) {
            $this->session->set_flashdata('info', 'This product is already in your comparison list.');
            redirect('compare');
        }

        if (count($compare_ids) >= 4) {
            $this->session->set_flashdata('error', 'You can compare up to 4 products at a time. Please remove one first.');
            redirect('compare');
        }

        $compare_ids[] = $product_id;
        $this->session->set_userdata('compare_products', $compare_ids);

        $this->session->set_flashdata('success', "Added {$product['title']} to comparison.");
        redirect('compare');
    }

    public function remove($product_id)
    {
        $product_id = (int) $product_id;
        $compare_ids = $this->session->userdata('compare_products') ?: [];

        if (is_array($compare_ids)) {
            $compare_ids = array_values(array_diff($compare_ids, [$product_id]));
            $this->session->set_userdata('compare_products', $compare_ids);
        }

        $this->session->set_flashdata('success', 'Product removed from comparison.');
        redirect('compare');
    }

    public function clear()
    {
        $this->session->unset_userdata('compare_products');
        $this->session->set_flashdata('success', 'Comparison list cleared.');
        redirect('compare');
    }
}
