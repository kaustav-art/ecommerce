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

                // Handle variant main image file upload
                $uploaded_image = $this->upload_image_file('image_file', 'products', 'var');
                if ($uploaded_image === false) {
                    $this->session->set_flashdata('error', 'Variant image upload error: ' . $this->upload->display_errors('', ''));
                    redirect('variants/product/' . $product_id);
                    return;
                }
                $image_path = $uploaded_image ?: ($this->input->post('current_image', TRUE) ?: $product['main_image']);

                // Handle variant gallery images file upload
                $new_gallery = $this->upload_multiple_images('gallery_files', 'products', 'var_gal');
                if ($this->input->post('gallery_submitted')) {
                    $existing_gallery = $this->input->post('existing_gallery') ?: [];
                } else {
                    $existing_gallery = $this->input->post('existing_gallery');
                    if ($existing_gallery === null && !empty($id)) {
                        $cur_var = $this->variant_model->get_by_id($id);
                        $existing_gallery = !empty($cur_var['gallery_images']) ? (json_decode($cur_var['gallery_images'], true) ?: []) : [];
                    } else {
                        $existing_gallery = $existing_gallery ?: [];
                    }
                }
                $final_gallery = array_merge((array) $existing_gallery, $new_gallery);
                $final_gallery = array_values(array_unique(array_filter($final_gallery)));
                $gallery_json  = !empty($final_gallery) ? json_encode($final_gallery) : NULL;

                $attr_vals = $this->input->post('attr_vals') ?: [];
                $size_vals = $this->input->post('size_vals');

                // Look up Size attribute definition
                $all_attributes = $this->attribute_model->get_all();
                $size_attr_id = null;
                $size_map = [];
                foreach ($all_attributes as $attr) {
                    if (strcasecmp($attr['slug'], 'size') === 0 || strcasecmp($attr['name'], 'size') === 0) {
                        $size_attr_id = (int) $attr['id'];
                        if (!empty($attr['values'])) {
                            foreach ($attr['values'] as $val) {
                                $size_map[$val['id']] = $val['value'];
                            }
                        }
                        break;
                    }
                }

                $base_sku   = strtoupper(trim($this->input->post('sku', TRUE)));
                $base_title = trim($this->input->post('title', TRUE)) ?: ($product['title'] . ' Variant');
                $price      = (float) $this->input->post('price');
                $sale_price = $this->input->post('sale_price') ? (float) $this->input->post('sale_price') : NULL;
                $stock      = (int) $this->input->post('stock_quantity');

                if (!empty($id)) {
                    // --- EDIT EXISTING VARIANT ---
                    $single_size_id = !empty($size_vals) ? (is_array($size_vals) ? reset($size_vals) : $size_vals) : null;
                    if ($size_attr_id && !empty($single_size_id)) {
                        $attr_vals[$size_attr_id] = $single_size_id;
                    }

                    $data = [
                        'product_id'     => (int) $product_id,
                        'title'          => $base_title,
                        'sku'            => $base_sku,
                        'price'          => $price,
                        'sale_price'     => $sale_price,
                        'stock_quantity' => $stock,
                        'stock_status'   => $stock > 0 ? 'in_stock' : 'out_of_stock',
                        'image'          => $image_path,
                        'gallery_images' => $gallery_json
                    ];

                    $this->variant_model->update($id, $data, $attr_vals);
                    $this->session->set_flashdata('success', 'Variant updated successfully.');
                } else {
                    // --- ADD NEW VARIANT(S) ---
                    $selected_sizes = is_array($size_vals) ? array_filter($size_vals) : (!empty($size_vals) ? [$size_vals] : []);

                    if ($size_attr_id && count($selected_sizes) > 1) {
                        // MULTIPLE SIZES SELECTED
                        $created_count = 0;
                        foreach ($selected_sizes as $s_id) {
                            $s_name = $size_map[$s_id] ?? '';

                            // Append size to SKU if not already present
                            $v_sku = $base_sku;
                            if (!empty($s_name) && !preg_match('/-' . preg_quote($s_name, '/') . '$/i', $v_sku)) {
                                $v_sku .= '-' . strtoupper($s_name);
                            }

                            // Append size to title if not already present
                            $v_title = $base_title;
                            if (!empty($s_name) && !preg_match('/\/\s*' . preg_quote($s_name, '/') . '$/i', $v_title)) {
                                $v_title .= ' / ' . $s_name;
                            }

                            $v_data = [
                                'product_id'     => (int) $product_id,
                                'title'          => $v_title,
                                'sku'            => $v_sku,
                                'price'          => $price,
                                'sale_price'     => $sale_price,
                                'stock_quantity' => $stock,
                                'stock_status'   => $stock > 0 ? 'in_stock' : 'out_of_stock',
                                'image'          => $image_path,
                                'gallery_images' => $gallery_json
                            ];

                            $v_attrs = $attr_vals;
                            $v_attrs[$size_attr_id] = $s_id;

                            // Check if existing variant with this SKU exists
                            $existing = $this->db->where('product_id', (int) $product_id)
                                                 ->where('sku', $v_sku)
                                                 ->get('product_variants')
                                                 ->row_array();
                            if ($existing) {
                                $this->variant_model->update($existing['id'], $v_data, $v_attrs);
                            } else {
                                $this->variant_model->create($v_data, $v_attrs);
                            }
                            $created_count++;
                        }
                        $this->session->set_flashdata('success', $created_count . ' variants created successfully for selected sizes!');
                    } else {
                        // SINGLE SIZE OR NO SIZE
                        $v_sku = $base_sku;
                        $v_title = $base_title;
                        if ($size_attr_id && count($selected_sizes) === 1) {
                            $s_id = reset($selected_sizes);
                            $attr_vals[$size_attr_id] = $s_id;
                            $s_name = $size_map[$s_id] ?? '';
                            if (!empty($s_name) && !preg_match('/-' . preg_quote($s_name, '/') . '$/i', $v_sku)) {
                                $v_sku .= '-' . strtoupper($s_name);
                            }
                            if (!empty($s_name) && !preg_match('/\/\s*' . preg_quote($s_name, '/') . '$/i', $v_title)) {
                                $v_title .= ' / ' . $s_name;
                            }
                        }

                        $data = [
                            'product_id'     => (int) $product_id,
                            'title'          => $v_title,
                            'sku'            => $v_sku,
                            'price'          => $price,
                            'sale_price'     => $sale_price,
                            'stock_quantity' => $stock,
                            'stock_status'   => $stock > 0 ? 'in_stock' : 'out_of_stock',
                            'image'          => $image_path,
                            'gallery_images' => $gallery_json
                        ];

                        $this->variant_model->create($data, $attr_vals);
                        $this->session->set_flashdata('success', 'Variant created successfully.');
                    }
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

    public function delete_gallery_image()
    {
        $this->require_permission('products.manage');
        $variant_id = (int) $this->input->post('variant_id');
        $image_path = $this->input->post('image_path', TRUE);

        if (!$variant_id || empty($image_path)) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
            exit;
        }

        $variant = $this->variant_model->get_by_id($variant_id);
        if (!$variant) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Variant not found']);
            exit;
        }

        $gallery = json_decode($variant['gallery_images'], true) ?: [];
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
            $this->variant_model->update($variant_id, [
                'gallery_images' => !empty($updated_gallery) ? json_encode(array_values($updated_gallery)) : NULL,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);

            if (strpos($image_path, 'products/var_gal_') === 0) {
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
            'message'         => 'Variant gallery image removed'
        ]);
        exit;
    }
}
