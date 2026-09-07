<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class products extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('category_model');
        $this->load->model('brand_model');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $this->require_permission('products.view');

        $category_id = $this->input->get('category_id');
        $search      = $this->input->get('q');
        $type        = $this->input->get('type');

        $data = [
            'title'           => 'Product Management | Admin',
            'active_menu'     => 'products',
            'active_submenu'  => 'products_list',
            'products'        => $this->product_model->get_all(NULL, NULL, $category_id, $search, $type),
            'categories'      => $this->category_model->get_all(),
            'currency_symbol' => $this->setting_model->get('currency_symbol', '$'),
            'selected_cat'    => $category_id,
            'search_query'    => $search
        ];

        $this->render('products/index', $data);
    }

    public function add()
    {
        $this->require_permission('products.manage');

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title', 'Product Title', 'required|trim');
            $this->form_validation->set_rules('sku', 'SKU', 'required|trim|is_unique[products.sku]');
            $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
            $this->form_validation->set_rules('price', 'Base Price', 'required|numeric');
            $this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $title = $this->input->post('title', TRUE);
                $slug  = url_title($title, 'dash', TRUE);

                // Handle unique slug
                $orig_slug = $slug;
                $i = 1;
                while ($this->db->where('slug', $slug)->count_all_results('products') > 0) {
                    $slug = $orig_slug . '-' . $i++;
                }

                $main_image = $this->input->post('main_image', TRUE);
                if (empty($main_image)) {
                    $main_image = 'products/womens/women-1.jpg';
                }

                $insert_data = [
                    'category_id'         => (int) $this->input->post('category_id'),
                    'brand_id'            => $this->input->post('brand_id') ? (int) $this->input->post('brand_id') : NULL,
                    'product_type'        => $this->input->post('product_type', TRUE) ?: 'simple',
                    'title'               => $title,
                    'slug'                => $slug,
                    'sku'                 => strtoupper($this->input->post('sku', TRUE)),
                    'price'               => (float) $this->input->post('price'),
                    'sale_price'          => $this->input->post('sale_price') ? (float) $this->input->post('sale_price') : NULL,
                    'tax_rate'            => (float) $this->input->post('tax_rate'),
                    'stock_quantity'      => (int) $this->input->post('stock_quantity'),
                    'low_stock_threshold' => (int) $this->input->post('low_stock_threshold') ?: 5,
                    'stock_status'        => $this->input->post('stock_quantity') > 0 ? 'in_stock' : 'out_of_stock',
                    'short_description'   => $this->input->post('short_description', TRUE),
                    'description'         => $this->input->post('description'),
                    'main_image'          => $main_image,
                    'is_featured'         => $this->input->post('is_featured') ? 1 : 0,
                    'is_trending'         => $this->input->post('is_trending') ? 1 : 0,
                    'is_new'              => $this->input->post('is_new') ? 1 : 0,
                    'status'              => $this->input->post('status', TRUE) ?: 'published'
                ];

                $new_id = $this->product_model->create($insert_data);

                // Save specifications
                $spec_names  = $this->input->post('spec_names') ?: [];
                $spec_values = $this->input->post('spec_values') ?: [];
                $specs = [];
                foreach ($spec_names as $idx => $name) {
                    if (!empty($name) && isset($spec_values[$idx])) {
                        $specs[] = ['name' => $name, 'value' => $spec_values[$idx]];
                    }
                }
                $this->product_model->save_specifications($new_id, $specs);

                $this->session->set_flashdata('success', 'Product created successfully!');
                
                if ($insert_data['product_type'] === 'variable') {
                    redirect('variants/product/' . $new_id);
                } else {
                    redirect('products');
                }
            }
        }

        $data = [
            'title'          => 'Add Product | Admin',
            'active_menu'    => 'products',
            'active_submenu' => 'products_add',
            'categories'     => $this->category_model->get_all(),
            'brands'         => $this->brand_model->get_all()
        ];

        $this->render('products/add', $data);
    }

    public function edit($id)
    {
        $this->require_permission('products.manage');

        $product = $this->product_model->get_by_id($id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('products');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title', 'Product Title', 'required|trim');
            $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
            $this->form_validation->set_rules('price', 'Base Price', 'required|numeric');
            $this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $main_image = $this->input->post('main_image', TRUE) ?: $product['main_image'];

                $update_data = [
                    'category_id'         => (int) $this->input->post('category_id'),
                    'brand_id'            => $this->input->post('brand_id') ? (int) $this->input->post('brand_id') : NULL,
                    'product_type'        => $this->input->post('product_type', TRUE) ?: 'simple',
                    'title'               => $this->input->post('title', TRUE),
                    'price'               => (float) $this->input->post('price'),
                    'sale_price'          => $this->input->post('sale_price') ? (float) $this->input->post('sale_price') : NULL,
                    'tax_rate'            => (float) $this->input->post('tax_rate'),
                    'stock_quantity'      => (int) $this->input->post('stock_quantity'),
                    'low_stock_threshold' => (int) $this->input->post('low_stock_threshold') ?: 5,
                    'stock_status'        => $this->input->post('stock_quantity') > 0 ? 'in_stock' : 'out_of_stock',
                    'short_description'   => $this->input->post('short_description', TRUE),
                    'description'         => $this->input->post('description'),
                    'main_image'          => $main_image,
                    'is_featured'         => $this->input->post('is_featured') ? 1 : 0,
                    'is_trending'         => $this->input->post('is_trending') ? 1 : 0,
                    'is_new'              => $this->input->post('is_new') ? 1 : 0,
                    'status'              => $this->input->post('status', TRUE) ?: 'published'
                ];

                $this->product_model->update($id, $update_data);

                // Save specifications
                $spec_names  = $this->input->post('spec_names') ?: [];
                $spec_values = $this->input->post('spec_values') ?: [];
                $specs = [];
                foreach ($spec_names as $idx => $name) {
                    if (!empty($name) && isset($spec_values[$idx])) {
                        $specs[] = ['name' => $name, 'value' => $spec_values[$idx]];
                    }
                }
                $this->product_model->save_specifications($id, $specs);

                $this->session->set_flashdata('success', 'Product updated successfully!');
                redirect('products');
            }
        }

        $data = [
            'title'          => 'Edit Product | Admin',
            'active_menu'    => 'products',
            'active_submenu' => 'products_list',
            'product'        => $product,
            'categories'     => $this->category_model->get_all(),
            'brands'         => $this->brand_model->get_all()
        ];

        $this->render('products/edit', $data);
    }

    public function delete($id)
    {
        $this->require_permission('products.delete');
        $this->product_model->delete($id);
        $this->session->set_flashdata('success', 'Product deleted successfully.');
        redirect('products');
    }
}
