<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Layouts Controller - Super Admin Control Panel
 * Governs Multi-Theme Architecture and Template 2 Layout Customizers (Layout 1, 2, 3)
 */
class Layouts extends Superadmin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $root_dir = realpath(FCPATH . '../') ? realpath(FCPATH . '../') . DIRECTORY_SEPARATOR : dirname(FCPATH) . DIRECTORY_SEPARATOR;
        $root_dir = realpath(FCPATH . '../') ? realpath(FCPATH . '../') . DIRECTORY_SEPARATOR : dirname(FCPATH) . DIRECTORY_SEPARATOR;
        $tpl_upload_dir = $root_dir . 'uploads' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        $tpl1_upload_dir = $root_dir . 'uploads' . DIRECTORY_SEPARATOR . 'template1' . DIRECTORY_SEPARATOR;
        $tpl2_upload_dir = $root_dir . 'uploads' . DIRECTORY_SEPARATOR . 'template2' . DIRECTORY_SEPARATOR;

        if (!is_dir($tpl_upload_dir)) {
            @mkdir($tpl_upload_dir, 0755, true);
        }
        if (!is_dir($tpl1_upload_dir)) {
            @mkdir($tpl1_upload_dir, 0755, true);
        }
        if (!is_dir($tpl2_upload_dir)) {
            @mkdir($tpl2_upload_dir, 0755, true);
        }

        if ($this->input->method() === 'post') {
            $action = $this->input->post('action', TRUE);
            $active_tab = $this->input->post('active_tab', TRUE) ?: 'multi-theme';
            $target_tpl = in_array($active_tab, array('template1', 'template2')) ? $active_tab : 'template2';
            $active_layout = (int)$this->input->post('active_layout') ?: 1;
            $active_section = $this->input->post('active_section', TRUE) ?: 'hero';

            // Helper to handle single file upload into uploads/{target_tpl}/
            $handle_file_upload = function($field_name, $prefix) use ($root_dir, $target_tpl) {
                if (!empty($_FILES[$field_name]['name']) && $_FILES[$field_name]['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION));
                    $allowed = array('jpg', 'jpeg', 'png', 'gif', 'svg', 'webp');
                    if (in_array($ext, $allowed)) {
                        $target_folder = $root_dir . 'uploads' . DIRECTORY_SEPARATOR . $target_tpl . DIRECTORY_SEPARATOR;
                        if (!is_dir($target_folder)) {
                            @mkdir($target_folder, 0755, true);
                        }
                        $new_name = $prefix . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
                        $target_path = $target_folder . $new_name;
                        if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $target_path)) {
                            return 'uploads/' . $target_tpl . '/' . $new_name;
                        }
                    }
                }
                return null;
            };

            // ==========================================
            // 1. MULTI-THEME ARCHITECTURE ACTIONS
            // ==========================================
            if ($action === 'save_template') {
                $template_id = (int)$this->input->post('template_id');
                $tpl_key = strtolower(trim(preg_replace('/[^a-zA-Z0-9_]/', '', $this->input->post('template_key'))));
                if (!$tpl_key) $tpl_key = 'template_' . time();

                $features_raw = trim($this->input->post('features'));
                $features_arr = array();
                if ($features_raw !== '') {
                    $lines = preg_split('/\r\n|\r|\n|,/', $features_raw);
                    foreach ($lines as $ln) {
                        $ln = trim($ln);
                        if ($ln !== '') $features_arr[] = $ln;
                    }
                }

                $tpl_data = array(
                    'template_key' => $tpl_key,
                    'name' => trim($this->input->post('name')),
                    'badge' => trim($this->input->post('badge')),
                    'icon' => trim($this->input->post('icon', TRUE)) ?: 'fa-solid fa-crown',
                    'short_desc' => trim($this->input->post('short_desc')),
                    'features' => !empty($features_arr) ? json_encode($features_arr) : NULL,
                    'demo_url' => trim($this->input->post('demo_url')),
                    'sort_order' => (int)$this->input->post('sort_order', TRUE) ?: 1,
                    'status' => $this->input->post('status') === 'inactive' ? 'inactive' : 'active'
                );

                if ($template_id > 0) {
                    $this->db->where('id', $template_id)->update('marketplace_templates', $tpl_data);
                    $this->session->set_flashdata('success', 'Template updated successfully!');
                } else {
                    $this->db->insert('marketplace_templates', $tpl_data);
                    $template_id = $this->db->insert_id();

                    $this->db->insert('marketplace_template_layouts', array(
                        'template_id' => $template_id,
                        'template_key' => $tpl_key,
                        'layout_number' => 1,
                        'layout_name' => 'Layout 1: ' . $tpl_data['name'],
                        'preview_image' => 'uploads/no-image.jpg',
                        'demo_url' => 'website/?preview_tpl=' . $tpl_key . '&preview_layout=1',
                        'sort_order' => 1,
                        'status' => 'active'
                    ));
                    $this->session->set_flashdata('success', 'Template created successfully with Layout 1!');
                }
                redirect(superadmin_url('layouts?tab=multi-theme'));
                return;
            }

            if ($action === 'delete_template') {
                $template_id = (int)$this->input->post('template_id');
                if ($template_id > 0) {
                    $this->db->where('template_id', $template_id)->delete('marketplace_template_layouts');
                    $this->db->where('id', $template_id)->delete('marketplace_templates');
                    $this->session->set_flashdata('success', 'Template and its layouts deleted.');
                }
                redirect(superadmin_url('layouts?tab=multi-theme'));
                return;
            }

            if ($action === 'save_layout') {
                $layout_id = (int)$this->input->post('layout_id');
                $template_id = (int)$this->input->post('template_id');
                $parent_tpl = $this->db->where('id', $template_id)->get('marketplace_templates')->row();
                $tpl_key = $parent_tpl ? $parent_tpl->template_key : 'template1';

                $preview_image = trim($this->input->post('preview_image_url'));
                if (!empty($_FILES['layout_preview_file']['name']) && $_FILES['layout_preview_file']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['layout_preview_file']['name'], PATHINFO_EXTENSION));
                    $allowed = array('jpg', 'jpeg', 'png', 'gif', 'svg', 'webp');
                    if (in_array($ext, $allowed)) {
                        $new_name = 'layout_' . $tpl_key . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
                        $target_path = $tpl_upload_dir . $new_name;
                        if (move_uploaded_file($_FILES['layout_preview_file']['tmp_name'], $target_path)) {
                            $preview_image = 'uploads/templates/' . $new_name;
                        }
                    }
                }
                if (empty($preview_image)) {
                    $preview_image = 'uploads/no-image.jpg';
                }

                $layout_number = (int)$this->input->post('layout_number') ?: 1;
                $layout_name = trim($this->input->post('layout_name')) ?: ('Layout ' . $layout_number);
                $demo_url = trim($this->input->post('demo_url')) ?: ('website/?preview_tpl=' . $tpl_key . '&preview_layout=' . $layout_number);

                $layout_data = array(
                    'template_id' => $template_id,
                    'template_key' => $tpl_key,
                    'layout_number' => $layout_number,
                    'layout_name' => $layout_name,
                    'preview_image' => $preview_image,
                    'demo_url' => $demo_url,
                    'sort_order' => (int)$this->input->post('sort_order') ?: $layout_number,
                    'status' => $this->input->post('status') === 'inactive' ? 'inactive' : 'active'
                );

                if ($layout_id > 0) {
                    $this->db->where('id', $layout_id)->update('marketplace_template_layouts', $layout_data);
                    $this->session->set_flashdata('success', 'Layout updated successfully!');
                } else {
                    $this->db->insert('marketplace_template_layouts', $layout_data);
                    $this->session->set_flashdata('success', 'Layout added successfully!');
                }
                redirect(superadmin_url('layouts?tab=multi-theme'));
                return;
            }

            if ($action === 'delete_layout') {
                $layout_id = (int)$this->input->post('layout_id');
                if ($layout_id > 0) {
                    $this->db->where('id', $layout_id)->delete('marketplace_template_layouts');
                    $this->session->set_flashdata('success', 'Layout deleted successfully.');
                }
                redirect(superadmin_url('layouts?tab=multi-theme'));
                return;
            }

            if ($action === 'save_theme_section') {
                $badge = trim($this->input->post('landing_templates_badge'));
                $title = trim($this->input->post('landing_templates_title'));
                $subtitle = trim($this->input->post('landing_templates_subtitle'));

                if ($badge !== '') set_setting('landing_templates_badge', $badge, 'landing');
                if ($title !== '') set_setting('landing_templates_title', $title, 'landing');
                if ($subtitle !== '') set_setting('landing_templates_subtitle', $subtitle, 'landing');

                $this->session->set_flashdata('success', 'Multi-Theme section headers updated successfully!');
                redirect(superadmin_url('layouts?tab=multi-theme'));
                return;
            }

            // ==========================================
            // 2. TEMPLATE CUSTOMIZATION ACTIONS (TEMPLATE 1 & TEMPLATE 2)
            // ==========================================
            $redirect_tpl = function($sec = 'hero') use ($target_tpl, $active_layout) {
                redirect(superadmin_url('layouts?tab=' . $target_tpl . '&layout=' . $active_layout . '&section=' . $sec));
                exit;
            };

            // Hero Banner (Single / Legacy & Multi-Slide Support)
            if ($action === 'save_hero_banner') {
                $badge = trim($this->input->post('hero_badge'));
                $title = trim($this->input->post('hero_title'));
                $desc = trim($this->input->post('hero_desc'));
                $btn_text = trim($this->input->post('hero_btn_text'));
                $btn_url = trim($this->input->post('hero_btn_url'));

                set_tpl_setting($target_tpl, $active_layout, 'hero', 'hero_badge', $badge);
                set_tpl_setting($target_tpl, $active_layout, 'hero', 'hero_title', $title);
                set_tpl_setting($target_tpl, $active_layout, 'hero', 'hero_desc', $desc);
                set_tpl_setting($target_tpl, $active_layout, 'hero', 'hero_btn_text', $btn_text);
                set_tpl_setting($target_tpl, $active_layout, 'hero', 'hero_btn_url', $btn_url);

                $uploaded_img = $handle_file_upload('hero_image_file', $target_tpl . '_hero_l' . $active_layout);
                if ($uploaded_img) {
                    set_tpl_setting($target_tpl, $active_layout, 'hero', 'hero_image', $uploaded_img);
                } elseif ($this->input->post('hero_image_url') !== NULL) {
                    $url_val = trim($this->input->post('hero_image_url'));
                    if ($url_val !== '') {
                        set_tpl_setting($target_tpl, $active_layout, 'hero', 'hero_image', $url_val);
                    }
                }

                $this->session->set_flashdata('success', 'Layout ' . $active_layout . ' Hero Banner updated successfully!');
                $redirect_tpl('hero');
            }

            if ($action === 'save_hero_slide') {
                $slide_id = (int)$this->input->post('slide_id');
                $layout_num = (int)$this->input->post('layout_number') ?: $active_layout;
                $badge = trim($this->input->post('badge'));
                $title = trim($this->input->post('title'));
                $desc = trim($this->input->post('description'));
                $btn_text = trim($this->input->post('button_text')) ?: 'Book Appointment';
                $btn_url = trim($this->input->post('button_url')) ?: 'booking';
                $sort_order = (int)$this->input->post('sort_order') ?: 1;
                $status = $this->input->post('status') === 'inactive' ? 'inactive' : 'active';

                $image = trim($this->input->post('image_url'));
                $uploaded_img = $handle_file_upload('image_file', $target_tpl . '_hero_slide_' . time());
                if ($uploaded_img) {
                    $image = $uploaded_img;
                }
                if (empty($image)) {
                    $image = ($target_tpl === 'template1') ? 'assets/template1/images/slider-01.jpg' : 'assets/template2/images/resources/main-slider-img-1-1.png';
                }

                $bg_image = trim($this->input->post('background_image_url'));
                $uploaded_bg = $handle_file_upload('background_image_file', $target_tpl . '_hero_bg_' . time());
                if ($uploaded_bg) {
                    $bg_image = $uploaded_bg;
                }

                $slide_data = array(
                    'template_key' => $target_tpl,
                    'layout_number' => $layout_num,
                    'badge' => $badge,
                    'title' => $title,
                    'description' => $desc,
                    'button_text' => $btn_text,
                    'button_url' => $btn_url,
                    'image' => $image,
                    'background_image' => $bg_image,
                    'sort_order' => $sort_order,
                    'status' => $status
                );

                if ($slide_id > 0) {
                    $this->db->where('id', $slide_id)->update('template_hero_banners', $slide_data);
                    $this->session->set_flashdata('success', 'Hero Banner slide updated successfully!');
                } else {
                    $this->db->insert('template_hero_banners', $slide_data);
                    $this->session->set_flashdata('success', 'New Hero Banner slide added successfully!');
                }

                // Sync first slide to template_layout_settings as well
                set_tpl_setting($target_tpl, $layout_num, 'hero', 'hero_badge', $badge);
                set_tpl_setting($target_tpl, $layout_num, 'hero', 'hero_title', $title);
                set_tpl_setting($target_tpl, $layout_num, 'hero', 'hero_desc', $desc);
                set_tpl_setting($target_tpl, $layout_num, 'hero', 'hero_btn_text', $btn_text);
                set_tpl_setting($target_tpl, $layout_num, 'hero', 'hero_btn_url', $btn_url);
                if (!empty($image)) {
                    set_tpl_setting($target_tpl, $layout_num, 'hero', 'hero_image', $image);
                }

                $redirect_tpl('hero');
            }

            if ($action === 'delete_hero_slide') {
                $slide_id = (int)$this->input->post('slide_id');
                if ($slide_id > 0) {
                    $this->db->where('id', $slide_id)->delete('template_hero_banners');
                    $this->session->set_flashdata('success', 'Hero Banner slide deleted successfully.');
                }
                $redirect_tpl('hero');
            }

            // Featured Skincare / Works Section
            if ($action === 'save_featured_skincare_headers') {
                $tagline = trim($this->input->post('featured_tagline'));
                $title = trim($this->input->post('featured_title'));
                $target_layout = (int)$this->input->post('active_layout') ?: $active_layout;
                set_tpl_setting($target_tpl, $target_layout, 'featured_skincare', 'tagline', $tagline);
                set_tpl_setting($target_tpl, $target_layout, 'featured_skincare', 'title', $title);

                $this->session->set_flashdata('success', 'Section headers updated!');
                $redirect_tpl('skincare');
            }

            if ($action === 'save_featured_item') {
                $item_id = (int)$this->input->post('item_id');
                $title = trim($this->input->post('title'));
                $short_desc = trim($this->input->post('short_desc'));
                $sort_order = (int)$this->input->post('sort_order') ?: 0;
                $status = $this->input->post('status') === 'inactive' ? 'inactive' : 'active';
                $layout_num = (int)$this->input->post('layout_number') ?: (int)$this->input->post('active_layout') ?: $active_layout;
                $button_text = trim($this->input->post('button_text')) ?: ($layout_num === 2 ? 'View Work' : 'Book Now');
                $button_link = trim($this->input->post('button_link')) ?: 'booking';

                $thumbnail = trim($this->input->post('thumbnail_url'));
                $uploaded = $handle_file_upload('thumbnail_file', $target_tpl . '_feat_' . time());
                if ($uploaded) {
                    $thumbnail = $uploaded;
                }
                if (empty($thumbnail)) {
                    $thumbnail = ($target_tpl === 'template1') ? 'assets/template1/images/demo-1/service/service-img-01.jpg' : (($layout_num === 2) ? 'assets/template2/images/work/work-1-1.jpg' : 'assets/template2/images/resources/feature-1-1.jpg');
                }

                $item_data = array(
                    'template_key' => $target_tpl,
                    'layout_number' => $layout_num,
                    'title' => $title,
                    'short_desc' => $short_desc,
                    'thumbnail' => $thumbnail,
                    'button_text' => $button_text,
                    'button_link' => $button_link,
                    'sort_order' => $sort_order,
                    'status' => $status
                );

                if ($item_id > 0) {
                    $this->db->where('id', $item_id)->update('template_featured_items', $item_data);
                    $this->session->set_flashdata('success', 'Item updated successfully!');
                } else {
                    $this->db->insert('template_featured_items', $item_data);
                    $this->session->set_flashdata('success', 'Item added successfully!');
                }
                $redirect_tpl('skincare');
            }

            if ($action === 'delete_featured_item') {
                $item_id = (int)$this->input->post('item_id');
                if ($item_id > 0) {
                    $this->db->where('id', $item_id)->delete('template_featured_items');
                    $this->session->set_flashdata('success', 'Featured Skincare item deleted.');
                }
                $redirect_tpl('skincare');
            }

            // About Us
            if ($action === 'save_about_us') {
                $tagline = trim($this->input->post('about_tagline'));
                $title = trim($this->input->post('about_title'));
                $desc = trim($this->input->post('about_desc'));
                $exp = trim($this->input->post('about_experience'));
                set_tpl_setting($target_tpl, $active_layout, 'about', 'about_tagline', $tagline);
                set_tpl_setting($target_tpl, $active_layout, 'about', 'about_title', $title);
                set_tpl_setting($target_tpl, $active_layout, 'about', 'about_desc', $desc);
                set_tpl_setting($target_tpl, $active_layout, 'about', 'about_experience', $exp);
                if ($this->input->post('about_author_name') !== NULL) {
                    $author = trim($this->input->post('about_author_name'));
                    set_tpl_setting($target_tpl, $active_layout, 'about', 'about_author_name', $author);
                }
                if ($this->input->post('about_author_role') !== NULL) {
                    $role = trim($this->input->post('about_author_role'));
                    set_tpl_setting($target_tpl, $active_layout, 'about', 'about_author_role', $role);
                }

                $img1 = $handle_file_upload('about_image_1_file', $target_tpl . '_about1_l' . $active_layout);
                if ($img1) {
                    set_tpl_setting($target_tpl, $active_layout, 'about', 'about_image_1', $img1);
                } elseif ($this->input->post('about_image_1_url') !== NULL && trim($this->input->post('about_image_1_url')) !== '') {
                    set_tpl_setting($target_tpl, $active_layout, 'about', 'about_image_1', trim($this->input->post('about_image_1_url')));
                }

                $img2 = $handle_file_upload('about_image_2_file', $target_tpl . '_about2_l' . $active_layout);
                if ($img2) {
                    set_tpl_setting($target_tpl, $active_layout, 'about', 'about_image_2', $img2);
                } elseif ($this->input->post('about_image_2_url') !== NULL && trim($this->input->post('about_image_2_url')) !== '') {
                    set_tpl_setting($target_tpl, $active_layout, 'about', 'about_image_2', trim($this->input->post('about_image_2_url')));
                }

                $this->session->set_flashdata('success', 'Layout ' . $active_layout . ' About Us section updated!');
                $redirect_tpl('about');
            }

            // Services (We Offer)
            if ($action === 'save_services_headers') {
                $tagline = trim($this->input->post('services_tagline'));
                $title = trim($this->input->post('services_title'));
                $desc = trim($this->input->post('services_desc'));
                set_tpl_setting($target_tpl, $active_layout, 'services_header', 'tagline', $tagline);
                set_tpl_setting($target_tpl, $active_layout, 'services_header', 'title', $title);
                set_tpl_setting($target_tpl, $active_layout, 'services_header', 'desc', $desc);

                $this->session->set_flashdata('success', 'Services section headers updated!');
                $redirect_tpl('services');
            }

            if ($action === 'save_service') {
                $service_id = (int)$this->input->post('service_id');
                $title = trim($this->input->post('title'));
                $slug = trim($this->input->post('slug'));
                if (empty($slug)) {
                    $slug = url_title($title, 'dash', TRUE);
                }
                $icon = trim($this->input->post('icon')) ?: 'icon-botox';
                $short_desc = trim($this->input->post('short_desc'));
                $description = $this->input->post('description', FALSE); // HTML rich text from Summernote (preserve raw HTML formatting)
                $price = (float)$this->input->post('price');
                $duration = trim($this->input->post('duration')) ?: '60 mins';
                $sort_order = (int)$this->input->post('sort_order') ?: 0;
                $status = $this->input->post('status') === 'inactive' ? 'inactive' : 'active';
                $layout_scope = (int)$this->input->post('layout_number') ?: (int)$this->input->post('active_layout') ?: $active_layout;

                $thumbnail = trim($this->input->post('thumbnail_url'));
                $uploaded_thumb = $handle_file_upload('thumbnail_file', $target_tpl . '_svc_thumb_' . time());
                if ($uploaded_thumb) {
                    $thumbnail = $uploaded_thumb;
                }
                if (empty($thumbnail)) {
                    $thumbnail = ($target_tpl === 'template1') ? 'assets/template1/images/demo-1/service/service-img-01.jpg' : 'assets/template2/images/services/services-1-1.jpg';
                }

                $banner_img = trim($this->input->post('banner_image_url'));
                $uploaded_banner = $handle_file_upload('banner_image_file', $target_tpl . '_svc_banner_' . time());
                if ($uploaded_banner) {
                    $banner_img = $uploaded_banner;
                }
                if (empty($banner_img)) {
                    $banner_img = ($target_tpl === 'template1') ? 'assets/template1/images/demo-1/about-img.jpg' : 'assets/template2/images/services/service-details-img4.jpg';
                }

                $service_data = array(
                    'template_key' => $target_tpl,
                    'layout_number' => $layout_scope,
                    'title' => $title,
                    'slug' => $slug,
                    'icon' => $icon,
                    'thumbnail' => $thumbnail,
                    'banner_image' => $banner_img,
                    'short_desc' => $short_desc,
                    'description' => $description,
                    'price' => $price,
                    'duration' => $duration,
                    'sort_order' => $sort_order,
                    'status' => $status
                );

                if ($service_id > 0) {
                    $this->db->where('id', $service_id)->update('template_services', $service_data);
                    $this->session->set_flashdata('success', 'Service updated successfully!');
                } else {
                    $this->db->insert('template_services', $service_data);
                    $this->session->set_flashdata('success', 'Service created successfully!');
                }
                $redirect_tpl('services');
            }

            if ($action === 'delete_service') {
                $service_id = (int)$this->input->post('service_id');
                if ($service_id > 0) {
                    $this->db->where('id', $service_id)->delete('template_services');
                    $this->session->set_flashdata('success', 'Service deleted successfully.');
                }
                $redirect_tpl('services');
            }

            // Testimonials
            if ($action === 'save_testimonials_headers') {
                $tagline = trim($this->input->post('testimonials_tagline'));
                $title = trim($this->input->post('testimonials_title'));
                set_tpl_setting($target_tpl, $active_layout, 'testimonials_header', 'tagline', $tagline);
                set_tpl_setting($target_tpl, $active_layout, 'testimonials_header', 'title', $title);

                $this->session->set_flashdata('success', 'Testimonials section headers updated!');
                $redirect_tpl('testimonials');
            }

            if ($action === 'save_testimonial') {
                $testimonial_id = (int)$this->input->post('testimonial_id');
                $client_name = trim($this->input->post('client_name'));
                $designation = trim($this->input->post('designation'));
                $rating = max(1, min(5, (int)$this->input->post('rating') ?: 5));
                $review = trim($this->input->post('review'));
                $sort_order = (int)$this->input->post('sort_order') ?: 0;
                $status = $this->input->post('status') === 'inactive' ? 'inactive' : 'active';
                $layout_scope = (int)$this->input->post('layout_number');

                $avatar = trim($this->input->post('avatar_url'));
                $uploaded_avatar = $handle_file_upload('avatar_file', $target_tpl . '_testi_' . time());
                if ($uploaded_avatar) {
                    $avatar = $uploaded_avatar;
                }
                if (empty($avatar)) {
                    $avatar = ($target_tpl === 'template1') ? 'assets/template1/images/demo-1/testimonial/tesimonial-01.jpg' : 'assets/template2/images/testimonial/testimonial-v1-img1.jpg';
                }

                $testimonial_data = array(
                    'template_key' => $target_tpl,
                    'layout_number' => $layout_scope,
                    'client_name' => $client_name,
                    'designation' => $designation,
                    'rating' => $rating,
                    'review' => $review,
                    'avatar' => $avatar,
                    'sort_order' => $sort_order,
                    'status' => $status
                );

                if ($testimonial_id > 0) {
                    $this->db->where('id', $testimonial_id)->update('template_testimonials', $testimonial_data);
                    $this->session->set_flashdata('success', 'Testimonial updated successfully!');
                } else {
                    $this->db->insert('template_testimonials', $testimonial_data);
                    $this->session->set_flashdata('success', 'Testimonial added successfully!');
                }
                $redirect_tpl('testimonials');
            }

            if ($action === 'delete_testimonial') {
                $testimonial_id = (int)$this->input->post('testimonial_id');
                if ($testimonial_id > 0) {
                    $this->db->where('id', $testimonial_id)->delete('template_testimonials');
                    $this->session->set_flashdata('success', 'Testimonial deleted successfully.');
                }
                $redirect_tpl('testimonials');
            }

            // FAQs
            if ($action === 'save_faqs_headers') {
                $tagline = trim($this->input->post('faq_tagline'));
                $title = trim($this->input->post('faq_title'));
                set_tpl_setting($target_tpl, $active_layout, 'faq_header', 'tagline', $tagline);
                set_tpl_setting($target_tpl, $active_layout, 'faq_header', 'title', $title);

                $this->session->set_flashdata('success', 'FAQ section headers updated!');
                $redirect_tpl('faqs');
            }

            if ($action === 'save_faq') {
                $faq_id = (int)$this->input->post('faq_id');
                $question = trim($this->input->post('question'));
                $answer = trim($this->input->post('answer'));
                $sort_order = (int)$this->input->post('sort_order') ?: 0;
                $status = $this->input->post('status') === 'inactive' ? 'inactive' : 'active';
                $layout_scope = (int)$this->input->post('layout_number') ?: (int)$this->input->post('active_layout') ?: $active_layout;

                $faq_data = array(
                    'template_key' => $target_tpl,
                    'layout_number' => $layout_scope,
                    'question' => $question,
                    'answer' => $answer,
                    'sort_order' => $sort_order,
                    'status' => $status
                );

                if ($faq_id > 0) {
                    $this->db->where('id', $faq_id)->update('template_faqs', $faq_data);
                    $this->session->set_flashdata('success', 'FAQ updated successfully!');
                } else {
                    $this->db->insert('template_faqs', $faq_data);
                    $this->session->set_flashdata('success', 'FAQ added successfully!');
                }
                $redirect_tpl('faqs');
            }

            if ($action === 'delete_faq') {
                $faq_id = (int)$this->input->post('faq_id');
                if ($faq_id > 0) {
                    $this->db->where('id', $faq_id)->delete('template_faqs');
                    $this->session->set_flashdata('success', 'FAQ deleted successfully.');
                }
                $redirect_tpl('faqs');
            }

            // Blogs / Latest News
            if ($action === 'save_blogs_headers') {
                $tagline = trim($this->input->post('blog_tagline'));
                $title = trim($this->input->post('blog_title'));
                $desc = trim($this->input->post('blog_desc'));
                set_tpl_setting($target_tpl, $active_layout, 'blog_header', 'tagline', $tagline);
                set_tpl_setting($target_tpl, $active_layout, 'blog_header', 'title', $title);
                set_tpl_setting($target_tpl, $active_layout, 'blog_header', 'desc', $desc);

                $this->session->set_flashdata('success', 'Blog section headers updated!');
                $redirect_tpl('blogs');
            }

            if ($action === 'save_blog') {
                $blog_id = (int)$this->input->post('blog_id');
                $title = trim($this->input->post('title'));
                $slug = trim($this->input->post('slug'));
                if (empty($slug)) {
                    $slug = url_title($title, 'dash', TRUE);
                }
                $author = trim($this->input->post('author_name')) ?: 'Admin';
                $pub_date = trim($this->input->post('published_date')) ?: date('Y-m-d');
                $short_desc = trim($this->input->post('short_desc'));
                $content = $this->input->post('content', FALSE); // HTML rich text from Summernote
                $tags = trim($this->input->post('tags'));
                $sort_order = (int)$this->input->post('sort_order') ?: 0;
                $status = $this->input->post('status') === 'inactive' ? 'inactive' : 'active';
                $layout_scope = (int)$this->input->post('layout_number');
                if ($layout_scope <= 0) {
                    $layout_scope = (int)$active_layout;
                }

                $thumbnail = trim($this->input->post('thumbnail_url'));
                $uploaded_thumb = $handle_file_upload('thumbnail_file', $target_tpl . '_blog_' . time());
                if ($uploaded_thumb) {
                    $thumbnail = $uploaded_thumb;
                }
                if (empty($thumbnail)) {
                    $thumbnail = ($target_tpl === 'template1') ? 'assets/template1/images/demo-1/blog/blog-img-01.jpg' : 'assets/template2/images/blog/blog-v1-img1.jpg';
                }

                $blog_data = array(
                    'template_key' => $target_tpl,
                    'layout_number' => $layout_scope,
                    'title' => $title,
                    'slug' => $slug,
                    'thumbnail' => $thumbnail,
                    'author_name' => $author,
                    'published_date' => $pub_date,
                    'short_desc' => $short_desc,
                    'content' => $content,
                    'tags' => $tags,
                    'sort_order' => $sort_order,
                    'status' => $status
                );

                if ($blog_id > 0) {
                    $this->db->where('id', $blog_id)->update('template_blogs', $blog_data);
                    $this->session->set_flashdata('success', 'Blog article updated successfully!');
                } else {
                    $this->db->insert('template_blogs', $blog_data);
                    $this->session->set_flashdata('success', 'Blog article published successfully!');
                }
                $redirect_tpl('blogs');
            }

            if ($action === 'delete_blog') {
                $blog_id = (int)$this->input->post('blog_id');
                if ($blog_id > 0) {
                    $this->db->where('id', $blog_id)->delete('template_blogs');
                    $this->session->set_flashdata('success', 'Blog article deleted successfully.');
                }
                $redirect_tpl('blogs');
            }
        }

        // ==========================================
        // DATA PREPARATION FOR VIEW
        // ==========================================
        $data = array();
        $tab_param = $this->input->get('tab', TRUE);
        $data['active_tab'] = (!empty($tab_param) && in_array($tab_param, array('template1', 'template2'))) ? $tab_param : 'multi-theme';
        $curr_target_tpl = in_array($data['active_tab'], array('template1', 'template2')) ? $data['active_tab'] : 'template2';
        $data['active_layout'] = (int)$this->input->get('layout') ?: 1;
        if (!in_array($data['active_layout'], array(1, 2, 3))) {
            $data['active_layout'] = 1;
        }
        $data['active_section'] = $this->input->get('section', TRUE) ?: 'hero';

        // Load templates and layouts for Architecture tab
        $templates = array();
        if ($this->db->table_exists('marketplace_templates')) {
            $templates = $this->db->order_by('sort_order', 'ASC')->order_by('id', 'ASC')->get('marketplace_templates')->result();
            foreach ($templates as $t) {
                $t->layouts = $this->db->where('template_id', $t->id)->order_by('sort_order', 'ASC')->order_by('layout_number', 'ASC')->get('marketplace_template_layouts')->result();
            }
        }
        $data['templates'] = $templates;

        // Load Template Customizer data (for active template)
        $data['hero_slides'] = $this->db->where('template_key', $curr_target_tpl)
                                        ->where('layout_number', $data['active_layout'])
                                        ->order_by('sort_order', 'ASC')
                                        ->get('template_hero_banners')
                                        ->result();
        $data['featured_items'] = $this->db->where('template_key', $curr_target_tpl)
                                           ->where('layout_number', $data['active_layout'])
                                           ->order_by('sort_order', 'ASC')
                                           ->get('template_featured_items')
                                           ->result();
        if (empty($data['featured_items'])) {
            $data['featured_items'] = $this->db->where('template_key', $curr_target_tpl)
                                               ->order_by('sort_order', 'ASC')
                                               ->get('template_featured_items')
                                               ->result();
        }

        $data['services_list'] = $this->db->where('template_key', $curr_target_tpl)
                                          ->where('layout_number', $data['active_layout'])
                                          ->order_by('sort_order', 'ASC')
                                          ->get('template_services')
                                          ->result();
        if (empty($data['services_list'])) {
            $data['services_list'] = $this->db->where('template_key', $curr_target_tpl)
                                              ->order_by('sort_order', 'ASC')
                                              ->get('template_services')
                                              ->result();
        }

        $data['testimonials_list'] = $this->db->where('template_key', $curr_target_tpl)->order_by('sort_order', 'ASC')->get('template_testimonials')->result();

        $data['faqs_list'] = $this->db->where('template_key', $curr_target_tpl)
                                      ->where('layout_number', $data['active_layout'])
                                      ->order_by('sort_order', 'ASC')
                                      ->get('template_faqs')
                                      ->result();
        if (empty($data['faqs_list'])) {
            $data['faqs_list'] = $this->db->where('template_key', $curr_target_tpl)
                                          ->order_by('sort_order', 'ASC')
                                          ->get('template_faqs')
                                          ->result();
        }

        $data['blogs_list'] = $this->db->where('template_key', $curr_target_tpl)
                                       ->where('layout_number', $data['active_layout'])
                                       ->order_by('sort_order', 'ASC')
                                       ->get('template_blogs')
                                       ->result();

        $page_title = ($curr_target_tpl === 'template1') ? 'Template 1 Customizer' : 'Template 2 Customizer';
        if ($data['active_tab'] === 'multi-theme') {
            $page_title = 'Configure Layouts & Multi-Theme Architecture';
        }
        $this->render('configure_layouts/index', $data, $page_title);
    }
}
