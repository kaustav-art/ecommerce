<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class variants extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('variant_model');
        $this->load->model('product_model');
        $this->load->model('attribute_model');
    }

    public function product($product_id)
    {
        $this->require_permission('products.manage');
        $product = $this->product_model->get_by_id($product_id);
        if (!$product) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('sku', 'Variant SKU', 'required|trim');
            $this->form_validation->set_rules('price', 'Variant Price', 'required|numeric');
            $this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $id = $this->input->post('id');
                $data = [
                    'product_id'     => (int) $product_id,
                    'title'          => $this->input->post('title', TRUE) ?: ($product['title'] . ' Variant'),
                    'sku'            => strtoupper($this->input->post('sku', TRUE)),
                    'price'          => (float) $this->input->post('price'),
                    'sale_price'     => $this->input->post('sale_price') ? (float) $this->input->post('sale_price') : NULL,
                    'stock_quantity' => (int) $this->input->post('stock_quantity'),
                    'stock_status'   => $this->input->post('stock_quantity') > 0 ? 'in_stock' : 'out_of_stock',
                    'image'          => $this->input->post('image', TRUE) ?: $product['main_image']
                ];

                $attr_vals = $this->input->post('attr_vals') ?: [];

                if (!empty($id)) {
                    $this->variant_model->update($id, $data, $attr_vals);
                    $this->session->set_flashdata('success', 'Variant updated successfully.');
                } else {
                    $this->variant_model->create($data, $attr_vals);
                    $this->session->set_flashdata('success', 'Variant created successfully.');
                }

                // Ensure product type is marked as variable
                $this->product_model->update($product_id, ['product_type' => 'variable']);

                redirect('variants/product/' . $product_id);
            }
        }

        $variants   = $this->variant_model->get_by_product($product_id);
        $attributes = $this->attribute_model->get_all();

        $data = [
            'title'          => 'Variants for ' . html_escape($product['title']) . ' | Admin',
            'active_menu'    => 'products',
            'active_submenu' => 'products_list',
            'product'        => $product,
            'variants'       => $variants,
            'attributes'     => $attributes
        ];
        $this->render('variants/product', $data);
    }

    public function delete($product_id, $variant_id)
    {
        $this->require_permission('products.manage');
        $this->variant_model->delete($variant_id);
        $this->session->set_flashdata('success', 'Variant deleted.');
        redirect('variants/product/' . $product_id);
    }
}
