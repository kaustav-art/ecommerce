<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class banners extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('banner_model');
    }

    public function index()
    {
        $this->require_permission('banners.manage');

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title', 'Banner Title', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $id = $this->input->post('id');

                $data = [
                    'title'       => $this->input->post('title', TRUE),
                    'subtitle'    => $this->input->post('subtitle', TRUE),
                    'button_text' => $this->input->post('button_text', TRUE) ?: 'Explore Collection',
                    'button_link' => $this->input->post('button_link', TRUE) ?: 'shop',
                    'sort_order'  => (int) $this->input->post('sort_order'),
                    'status'      => $this->input->post('status', TRUE) ?: 'active'
                ];

                // Check for file upload
                if (!empty($_FILES['image_file']['name'])) {
                    $config['upload_path']   = FCPATH . '../website/assets/images/slider/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
                    $config['max_size']      = 5120; // 5MB
                    $config['file_name']     = 'slider_' . time() . '_' . rand(100, 999);

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image_file')) {
                        $upload_data = $this->upload->data();
                        $data['image'] = 'slider/' . $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('banners');
                        return;
                    }
                } elseif ($this->input->post('image_path')) {
                    $data['image'] = trim($this->input->post('image_path', TRUE));
                }

                if (!empty($id)) {
                    $this->banner_model->update($id, $data);
                    $this->session->set_flashdata('success', 'Banner updated successfully.');
                } else {
                    if (empty($data['image'])) {
                        $data['image'] = 'slider/slider-women1.jpg'; // default fallback
                    }
                    $this->banner_model->create($data);
                    $this->session->set_flashdata('success', 'Banner created successfully.');
                }
                redirect('banners');
            }
        }

        $data = [
            'title'          => 'Banner & Slider Management | Admin',
            'active_menu'    => 'products',
            'active_submenu' => 'banners',
            'banners'        => $this->banner_model->get_all()
        ];

        $this->render('banners/index', $data);
    }

    public function delete($id)
    {
        $this->require_permission('banners.manage');
        $this->banner_model->delete($id);
        $this->session->set_flashdata('success', 'Banner deleted successfully.');
        redirect('banners');
    }

    public function toggle($id)
    {
        $this->require_permission('banners.manage');
        $banner = $this->banner_model->get_by_id($id);
        if ($banner) {
            $new_status = ($banner['status'] === 'active') ? 'inactive' : 'active';
            $this->banner_model->update($id, ['status' => $new_status]);
            $this->session->set_flashdata('success', 'Banner status updated.');
        }
        redirect('banners');
    }
}
