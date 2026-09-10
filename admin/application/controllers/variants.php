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

                $group_variant_ids_str = $this->input->post('group_variant_ids');
                $group_variant_ids     = !empty($group_variant_ids_str) ? array_filter(array_map('intval', explode(',', $group_variant_ids_str))) : [];
                $size_stocks           = $this->input->post('size_stock') ?: [];
                $selected_sizes        = is_array($size_vals) ? array_filter($size_vals) : (!empty($size_vals) ? [$size_vals] : []);

                if (!empty($group_variant_ids)) {
                    // --- EDIT GROUPED VARIANT (MULTIPLE SIZES) ---
                    $existing_variants = $this->db->where_in('id', $group_variant_ids)->get('product_variants')->result_array();
                    $existing_by_size  = [];
                    foreach ($existing_variants as $ev) {
                        $pv_val = $this->db->where('variant_id', $ev['id'])->where('attribute_id', $size_attr_id)->get('product_variant_values')->row_array();
                        if ($pv_val) {
                            $existing_by_size[$pv_val['attribute_value_id']] = $ev;
                        }
                    }

                    $processed_var_ids = [];
                    if ($size_attr_id && !empty($selected_sizes)) {
                        foreach ($selected_sizes as $s_id) {
                            $s_name = $size_map[$s_id] ?? '';
                            $v_sku = $base_sku;
                            if (!empty($s_name) && !preg_match('/-' . preg_quote($s_name, '/') . '$/i', $v_sku)) {
                                $v_sku .= '-' . strtoupper($s_name);
                            }
                            $v_title = $base_title;
                            if (!empty($s_name) && !preg_match('/\/\s*' . preg_quote($s_name, '/') . '$/i', $v_title)) {
                                $v_title .= ' / ' . $s_name;
                            }
                            $s_stock = isset($size_stocks[$s_id]) ? max(0, (int) $size_stocks[$s_id]) : $stock;

                            $v_data = [
                                'product_id'     => (int) $product_id,
                                'title'          => $v_title,
                                'sku'            => $v_sku,
                                'price'          => $price,
                                'sale_price'     => $sale_price,
                                'stock_quantity' => $s_stock,
                                'stock_status'   => $s_stock > 0 ? 'in_stock' : 'out_of_stock',
                                'image'          => $image_path,
                                'gallery_images' => $gallery_json
                            ];
                            $v_attrs = $attr_vals;
                            $v_attrs[$size_attr_id] = $s_id;

                            if (isset($existing_by_size[$s_id])) {
                                $this->variant_model->update($existing_by_size[$s_id]['id'], $v_data, $v_attrs);
                                $processed_var_ids[] = (int) $existing_by_size[$s_id]['id'];
                            } else {
                                $new_v_id = $this->variant_model->create($v_data, $v_attrs);
                                $processed_var_ids[] = (int) $new_v_id;
                            }
                        }

                        // Remove sizes that were unchecked from the group
                        $removed_var_ids = array_diff($group_variant_ids, $processed_var_ids);
                        if (!empty($removed_var_ids)) {
                            $this->variant_model->delete_multiple($removed_var_ids, $product_id);
                        }
                    } else {
                        // Group had sizes but now no sizes selected - update primary variant
                        $primary_id = reset($group_variant_ids);
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
                        $this->variant_model->update($primary_id, $data, $attr_vals);

                        $other_ids = array_diff($group_variant_ids, [$primary_id]);
                        if (!empty($other_ids)) {
                            $this->variant_model->delete_multiple($other_ids, $product_id);
                        }
                    }

                    $this->variant_model->sync_product_stock($product_id);
                    $this->session->set_flashdata('success', 'Variant group updated successfully.');

                } elseif (!empty($id)) {
                    // --- EDIT EXISTING SINGLE VARIANT ---
                    $single_size_id = !empty($size_vals) ? (is_array($size_vals) ? reset($size_vals) : $size_vals) : null;
                    if ($size_attr_id && !empty($single_size_id)) {
                        $attr_vals[$size_attr_id] = $single_size_id;
                        if (isset($size_stocks[$single_size_id])) {
                            $stock = max(0, (int) $size_stocks[$single_size_id]);
                        }
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
                    $this->variant_model->sync_product_stock($product_id);
                    $this->session->set_flashdata('success', 'Variant updated successfully.');

                } else {
                    // --- ADD NEW VARIANT(S) ---
                    if ($size_attr_id && !empty($selected_sizes)) {
                        // SIZES SELECTED WITH INDIVIDUAL STOCKS
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

                            $s_stock = isset($size_stocks[$s_id]) ? max(0, (int) $size_stocks[$s_id]) : $stock;

                            $v_data = [
                                'product_id'     => (int) $product_id,
                                'title'          => $v_title,
                                'sku'            => $v_sku,
                                'price'          => $price,
                                'sale_price'     => $sale_price,
                                'stock_quantity' => $s_stock,
                                'stock_status'   => $s_stock > 0 ? 'in_stock' : 'out_of_stock',
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
                        $this->variant_model->sync_product_stock($product_id);
                        $this->session->set_flashdata('success', $created_count . ' variants created successfully with managed stock by size!');
                    } else {
                        // NO SIZE ATTRIBUTE SELECTED
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

                        $this->variant_model->create($data, $attr_vals);
                        $this->variant_model->sync_product_stock($product_id);
                        $this->session->set_flashdata('success', 'Variant created successfully.');
                    }
                }

                // Ensure assigned attributes in product_attributes are kept in sync
                $assigned_attr_ids = array_keys($attr_vals);
                if (!empty($selected_sizes) && $size_attr_id) {
                    $assigned_attr_ids[] = $size_attr_id;
                }
                if (!empty($assigned_attr_ids)) {
                    $existing_attrs = array_column($this->attribute_model->get_product_attributes($product_id), 'attribute_id');
                    $all_attrs = array_unique(array_merge($existing_attrs, $assigned_attr_ids));
                    $this->attribute_model->save_product_attributes($product_id, $all_attrs);
                }

                // Ensure product type is marked as variable
                $this->product_model->update($product_id, ['product_type' => 'variable']);

                redirect('variants/product/' . $product_id);
            }
        }

        $variants       = $this->variant_model->get_by_product($product_id);
        $variant_groups = $this->variant_model->get_grouped_by_product($product_id);
        $attributes     = $this->attribute_model->get_all();

        $data = [
            'title'          => 'Variants for ' . html_escape($product['title']) . ' | Admin',
            'active_menu'    => 'products',
            'active_submenu' => 'products_list',
            'product'        => $this->product_model->get_by_id($product_id), // fresh data with updated stock
            'variants'       => $variants,
            'variant_groups' => $variant_groups,
            'attributes'     => $attributes
        ];
        $this->render('variants/product', $data);
    }

    public function delete($product_id, $variant_id)
    {
        $this->require_permission('products.manage');
        $this->variant_model->delete($variant_id);
        $this->variant_model->sync_product_stock($product_id);
        $this->session->set_flashdata('success', 'Variant deleted.');
        redirect('variants/product/' . $product_id);
    }

    public function delete_group($product_id)
    {
        $this->require_permission('products.manage');
        $var_ids_str = $this->input->post('variant_ids') ?: $this->input->get('variant_ids');
        $var_ids = array_filter(array_map('intval', explode(',', $var_ids_str)));

        if (!empty($var_ids)) {
            $this->variant_model->delete_multiple($var_ids, $product_id);
            $this->session->set_flashdata('success', 'Variant group (' . count($var_ids) . ' sizes) deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'No variant IDs provided.');
        }
        redirect('variants/product/' . $product_id);
    }

    public function update_size_stocks()
    {
        $this->require_permission('products.manage');
        $product_id = (int) $this->input->post('product_id');
        $stocks     = $this->input->post('stocks'); // array: variant_id => qty

        if (!$product_id || empty($stocks) || !is_array($stocks)) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
            exit;
        }

        foreach ($stocks as $v_id => $qty) {
            $int_v_id = (int) $v_id;
            $int_qty  = max(0, (int) $qty);
            $status   = $int_qty > 0 ? 'in_stock' : 'out_of_stock';
            $this->db->where('id', $int_v_id)
                     ->where('product_id', $product_id)
                     ->update('product_variants', [
                         'stock_quantity' => $int_qty,
                         'stock_status'   => $status,
                         'updated_at'     => date('Y-m-d H:i:s')
                     ]);
        }

        $total_stock = $this->variant_model->sync_product_stock($product_id);

        header('Content-Type: application/json');
        echo json_encode([
            'status'      => 'success',
            'message'     => 'Stock quantities updated successfully!',
            'total_stock' => $total_stock
        ]);
        exit;
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
