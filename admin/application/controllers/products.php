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
        $this->load->model('attribute_model');
        $this->load->model('variant_model');
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

                // Handle Main Product Image upload
                $uploaded_main = $this->upload_image_file('main_image_file', 'products', 'prod');
                if ($uploaded_main === false) {
                    $this->session->set_flashdata('error', 'Main image upload error: ' . $this->upload->display_errors('', ''));
                    redirect('products/add');
                    return;
                }
                $main_image = $uploaded_main ?: ($this->input->post('default_main_image', TRUE) ?: 'products/womens/women-1.jpg');

                // Handle Additional Gallery Images upload
                $gallery_images = $this->upload_multiple_images('gallery_files', 'products', 'prod_gal');

                // Check if variants or attributes are assigned
                $size_vals        = $this->input->post('size_vals');
                $size_stocks      = $this->input->post('size_stock') ?: [];
                $size_sale_prices = $this->input->post('size_sale_price') ?: [];
                $attr_vals        = array_filter((array) $this->input->post('attr_vals'));
                $selected_sizes   = is_array($size_vals) ? array_filter($size_vals) : (!empty($size_vals) ? [$size_vals] : []);

                $has_variants = (!empty($selected_sizes) || !empty($attr_vals));

                $product_type = $has_variants ? 'variable' : ($this->input->post('product_type', TRUE) ?: 'simple');

                // Calculate initial stock: if sizes with individual stock are selected, sum them
                $initial_stock = (int) $this->input->post('stock_quantity');
                if ($has_variants && !empty($selected_sizes)) {
                    $sum_size_stock = 0;
                    foreach ($selected_sizes as $s_id) {
                        $sum_size_stock += isset($size_stocks[$s_id]) ? max(0, (int) $size_stocks[$s_id]) : 10;
                    }
                    $initial_stock = $sum_size_stock;
                }

                // Highlights processing
                $highlights = [];
                if ($this->input->post('enable_highlights')) {
                    $h_keys = $this->input->post('highlight_keys') ?: [];
                    $h_vals = $this->input->post('highlight_values') ?: [];
                    foreach ($h_keys as $idx => $k) {
                        $k = trim($k);
                        $v = isset($h_vals[$idx]) ? trim($h_vals[$idx]) : '';
                        if ($k !== '' || $v !== '') {
                            $highlights[] = ['key' => $k, 'value' => $v];
                        }
                    }
                }

                $insert_data = [
                    'category_id'         => (int) $this->input->post('category_id'),
                    'brand_id'            => $this->input->post('brand_id') ? (int) $this->input->post('brand_id') : NULL,
                    'product_type'        => $product_type,
                    'title'               => $title,
                    'slug'                => $slug,
                    'sku'                 => strtoupper($this->input->post('sku', TRUE)),
                    'price'               => (float) $this->input->post('price'),
                    'sale_price'          => $this->input->post('sale_price') ? (float) $this->input->post('sale_price') : NULL,
                    'tax_rate'            => (float) $this->input->post('tax_rate'),
                    'stock_quantity'      => $initial_stock,
                    'low_stock_threshold' => (int) $this->input->post('low_stock_threshold') ?: 5,
                    'max_purchase_quantity' => $this->input->post('max_purchase_quantity') ? max(1, (int) $this->input->post('max_purchase_quantity')) : 5,
                    'stock_status'        => $initial_stock > 0 ? 'in_stock' : 'out_of_stock',
                    'short_description'   => $this->input->post('short_description', TRUE),
                    'description'         => $this->input->post('description'),
                    'highlights'          => !empty($highlights) ? json_encode($highlights) : NULL,
                    'main_image'          => $main_image,
                    'gallery_images'      => json_encode($gallery_images),
                    'is_featured'         => $this->input->post('is_featured') ? 1 : 0,
                    'is_trending'         => $this->input->post('is_trending') ? 1 : 0,
                    'is_new'              => $this->input->post('is_new') ? 1 : 0,
                    'status'              => $this->input->post('status', TRUE) ?: 'published'
                ];

                $new_id = $this->product_model->create($insert_data);

                // Save specifications if enabled
                $specs = [];
                if ($this->input->post('enable_specifications')) {
                    $spec_names  = $this->input->post('spec_names') ?: [];
                    $spec_values = $this->input->post('spec_values') ?: [];
                    foreach ($spec_names as $idx => $name) {
                        $name = trim($name);
                        $val  = isset($spec_values[$idx]) ? trim($spec_values[$idx]) : '';
                        if ($name !== '' || $val !== '') {
                            $specs[] = ['name' => $name, 'value' => $val];
                        }
                    }
                }
                $this->product_model->save_specifications($new_id, $specs);

                // Process Assigned Attributes & Variants if enabled
                if ($has_variants && (!empty($selected_sizes) || !empty($attr_vals))) {
                    $all_attributes = $this->attribute_model->get_all();
                    $size_attr_id   = null;
                    $size_map       = [];
                    $color_name     = '';

                    foreach ($all_attributes as $attr) {
                        $is_size = (strcasecmp($attr['slug'], 'size') === 0 || strcasecmp($attr['name'], 'size') === 0);
                        if ($is_size) {
                            $size_attr_id = (int) $attr['id'];
                            if (!empty($attr['values'])) {
                                foreach ($attr['values'] as $val) {
                                    $size_map[$val['id']] = $val['value'];
                                }
                            }
                        }
                        if (isset($attr_vals[$attr['id']])) {
                            $selected_val_id = $attr_vals[$attr['id']];
                            if (!empty($attr['values'])) {
                                foreach ($attr['values'] as $val) {
                                    if ($val['id'] == $selected_val_id && (strcasecmp($attr['slug'], 'color') === 0 || strcasecmp($attr['name'], 'color') === 0)) {
                                        $color_name = $val['value'];
                                    }
                                }
                            }
                        }
                    }

                    // Save assigned attributes to product_attributes
                    $assigned_attrs = array_keys($attr_vals);
                    if (!empty($selected_sizes) && $size_attr_id) {
                        $assigned_attrs[] = $size_attr_id;
                    }
                    $this->attribute_model->save_product_attributes($new_id, $assigned_attrs);

                    // Build base variant title & SKU
                    $base_var_title = $insert_data['title'];
                    if (!empty($color_name)) {
                        $base_var_title .= ' - ' . $color_name;
                    }
                    $base_var_sku = $insert_data['sku'];

                    $created_var_count = 0;
                    if (!empty($selected_sizes) && $size_attr_id) {
                        // Create a variant for each size
                        foreach ($selected_sizes as $s_id) {
                            $s_name = $size_map[$s_id] ?? '';
                            $v_sku = $base_var_sku;
                            if (!empty($s_name) && !preg_match('/-' . preg_quote($s_name, '/') . '$/i', $v_sku)) {
                                $v_sku .= '-' . strtoupper($s_name);
                            }
                            $v_title = $base_var_title;
                            if (!empty($s_name) && !preg_match('/\/\s*' . preg_quote($s_name, '/') . '$/i', $v_title)) {
                                $v_title .= ' / ' . $s_name;
                            }

                            $v_stock  = isset($size_stocks[$s_id]) ? max(0, (int) $size_stocks[$s_id]) : 10;
                            $v_status = $v_stock > 0 ? 'in_stock' : 'out_of_stock';
                            $v_sale_price = (isset($size_sale_prices[$s_id]) && $size_sale_prices[$s_id] !== '') ? (float) $size_sale_prices[$s_id] : $insert_data['sale_price'];

                            $v_data = [
                                'product_id'     => $new_id,
                                'title'          => $v_title,
                                'sku'            => $v_sku,
                                'price'          => $insert_data['price'],
                                'sale_price'     => $v_sale_price,
                                'stock_quantity' => $v_stock,
                                'stock_status'   => $v_status,
                                'image'          => $main_image,
                                'gallery_images' => json_encode($gallery_images)
                            ];

                            $v_attrs = $attr_vals;
                            $v_attrs[$size_attr_id] = $s_id;

                            $this->variant_model->create($v_data, $v_attrs);
                            $created_var_count++;
                        }
                    } elseif (!empty($attr_vals)) {
                        // Single variant for non-size attributes
                        $v_data = [
                            'product_id'     => $new_id,
                            'title'          => $base_var_title,
                            'sku'            => $base_var_sku,
                            'price'          => $insert_data['price'],
                            'sale_price'     => $insert_data['sale_price'],
                            'stock_quantity' => $insert_data['stock_quantity'],
                            'stock_status'   => $insert_data['stock_status'],
                            'image'          => $main_image,
                            'gallery_images' => json_encode($gallery_images)
                        ];
                        $this->variant_model->create($v_data, $attr_vals);
                        $created_var_count++;
                    }

                    // Sync product stock
                    $this->variant_model->sync_product_stock($new_id);

                    $this->session->set_flashdata('success', 'Product created with ' . $created_var_count . ' variants for assigned attributes! You can manage them below.');
                    redirect('variants/product/' . $new_id);
                    return;
                }

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
            'brands'         => $this->brand_model->get_all(),
            'attributes'     => $this->attribute_model->get_all()
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
                // Handle Main Product Image upload
                $uploaded_main = $this->upload_image_file('main_image_file', 'products', 'prod');
                if ($uploaded_main === false) {
                    $this->session->set_flashdata('error', 'Main image upload error: ' . $this->upload->display_errors('', ''));
                    redirect('products/edit/' . $id);
                    return;
                }
                $main_image = $uploaded_main ?: ($this->input->post('current_main_image', TRUE) ?: $product['main_image']);

                // Handle Additional Gallery Images upload
                $new_gallery = $this->upload_multiple_images('gallery_files', 'products', 'prod_gal');
                if ($this->input->post('gallery_submitted')) {
                    $existing_gallery = $this->input->post('existing_gallery') ?: [];
                } else {
                    $existing_gallery = $this->input->post('existing_gallery');
                    if ($existing_gallery === null) {
                        $existing_gallery = json_decode($product['gallery_images'], true) ?: [];
                    }
                }
                $final_gallery = array_merge((array) $existing_gallery, $new_gallery);
                $final_gallery = array_values(array_unique(array_filter($final_gallery)));

                // Highlights processing
                $highlights = [];
                if ($this->input->post('enable_highlights')) {
                    $h_keys = $this->input->post('highlight_keys') ?: [];
                    $h_vals = $this->input->post('highlight_values') ?: [];
                    foreach ($h_keys as $idx => $k) {
                        $k = trim($k);
                        $v = isset($h_vals[$idx]) ? trim($h_vals[$idx]) : '';
                        if ($k !== '' || $v !== '') {
                            $highlights[] = ['key' => $k, 'value' => $v];
                        }
                    }
                }

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
                    'max_purchase_quantity' => $this->input->post('max_purchase_quantity') ? max(1, (int) $this->input->post('max_purchase_quantity')) : 5,
                    'stock_status'        => $this->input->post('stock_quantity') > 0 ? 'in_stock' : 'out_of_stock',
                    'short_description'   => $this->input->post('short_description', TRUE),
                    'description'         => $this->input->post('description'),
                    'highlights'          => !empty($highlights) ? json_encode($highlights) : NULL,
                    'main_image'          => $main_image,
                    'gallery_images'      => json_encode($final_gallery),
                    'is_featured'         => $this->input->post('is_featured') ? 1 : 0,
                    'is_trending'         => $this->input->post('is_trending') ? 1 : 0,
                    'is_new'              => $this->input->post('is_new') ? 1 : 0,
                    'status'              => $this->input->post('status', TRUE) ?: 'published'
                ];

                $this->product_model->update($id, $update_data);

                // Save specifications if enabled
                $specs = [];
                if ($this->input->post('enable_specifications')) {
                    $spec_names  = $this->input->post('spec_names') ?: [];
                    $spec_values = $this->input->post('spec_values') ?: [];
                    foreach ($spec_names as $idx => $name) {
                        $name = trim($name);
                        $val  = isset($spec_values[$idx]) ? trim($spec_values[$idx]) : '';
                        if ($name !== '' || $val !== '') {
                            $specs[] = ['name' => $name, 'value' => $val];
                        }
                    }
                }
                $this->product_model->save_specifications($id, $specs);

                $this->session->set_flashdata('success', 'Product updated successfully!');
                redirect('products');
            }
        }

        $data = [
            'title'               => 'Edit Product | Admin',
            'active_menu'         => 'products',
            'active_submenu'      => 'products_list',
            'product'             => $product,
            'highlights'          => !empty($product['highlights']) ? (json_decode($product['highlights'], true) ?: []) : [],
            'categories'          => $this->category_model->get_all(),
            'brands'              => $this->brand_model->get_all(),
            'attributes'          => $this->attribute_model->get_all(),
            'assigned_attributes' => $this->attribute_model->get_product_attributes($id),
            'variants_count'      => $this->db->where('product_id', (int) $id)->count_all_results('product_variants')
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

    public function delete_gallery_image()
    {
        $this->require_permission('products.manage');
        $product_id = (int) $this->input->post('product_id');
        $image_path = $this->input->post('image_path', TRUE);

        if (!$product_id || empty($image_path)) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
            exit;
        }

        $product = $this->product_model->get_by_id($product_id);
        if (!$product) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
            exit;
        }

        $gallery = json_decode($product['gallery_images'], true) ?: [];
        $updated_gallery = [];
        $found = false;
        foreach ($gallery as $img) {
            if ($img === $image_path) {
                $found = true;
            } else {
                $updated_gallery[] = $img;
            }
        }

        if ($found) {
            $this->product_model->update($product_id, [
                'gallery_images' => json_encode(array_values($updated_gallery)),
                'updated_at'     => date('Y-m-d H:i:s')
            ]);

            // If it's a dynamic uploaded file, delete from disk
            if (strpos($image_path, 'products/prod_gal_') === 0) {
                $file_path = FCPATH . '../website/assets/images/' . $image_path;
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status'          => 'success',
            'remaining_count' => count($updated_gallery),
            'message'         => 'Image removed from gallery'
        ]);
        exit;
    }
}
