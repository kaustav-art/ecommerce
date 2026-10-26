<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class flash_sales extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('marketing_model');
        $this->load->model('product_model');
    }

    public function index()
    {
        $this->require_permission('settings.manage');

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title', 'Campaign Title', 'required|trim');
            $this->form_validation->set_rules('start_time', 'Start Date/Time', 'required|trim');
            $this->form_validation->set_rules('end_time', 'End Date/Time', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $id = $this->input->post('id');
                $title = $this->input->post('title', TRUE);
                $uploaded_banner = $this->upload_image_file('banner_file', 'collections', 'fs');
                if ($uploaded_banner === false) {
                    $this->session->set_flashdata('error', 'Banner upload error: ' . $this->upload->display_errors('', ''));
                    redirect('flash_sales');
                    return;
                }

                $banner = null;
                if ($uploaded_banner) {
                    $banner = $uploaded_banner;
                } elseif ($this->input->post('current_banner')) {
                    $banner = trim($this->input->post('current_banner', TRUE));
                }

                $data = [
                    'title'            => $title,
                    'slug'             => url_title($title, 'dash', TRUE),
                    'discount_percent' => (float) $this->input->post('discount_percent'),
                    'start_time'       => $this->input->post('start_time'),
                    'end_time'         => $this->input->post('end_time'),
                    'status'           => $this->input->post('status', TRUE) ?: 'active'
                ];
                if ($banner !== null) {
                    $data['banner'] = $banner;
                }

                $product_ids = $this->input->post('product_ids') ?: [];
                $sale_prices = $this->input->post('sale_prices') ?: [];

                $this->marketing_model->save_flash_sale($data, $id, $product_ids, $sale_prices);
                $this->session->set_flashdata('success', 'Flash sale campaign saved successfully.');
                redirect('flash_sales');
            }
        }

        $data = [
            'title'          => 'Flash Sales & Promotional Campaigns | Admin',
            'active_menu'    => 'marketing',
            'active_submenu' => 'flash_sales',
            'flash_sales'    => $this->marketing_model->get_flash_sales(),
            'products'       => $this->product_model->get_all(30)
        ];
        $this->render('flash_sales/index', $data);
    }

    public function delete($id)
    {
        $this->require_permission('settings.manage');
        $this->marketing_model->delete_flash_sale($id);
        $this->session->set_flashdata('success', 'Flash sale deleted.');
        redirect('flash_sales');
    }
}
