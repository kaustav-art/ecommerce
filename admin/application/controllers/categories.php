<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class categories extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function index()
    {
        $this->require_permission('categories.manage');

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Category Name', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $id        = $this->input->post('id');
                $parent_id = (int) $this->input->post('parent_id');
                $name      = $this->input->post('name', TRUE);
                $slug      = url_title($name, 'dash', TRUE);

                // Prevent circular parent relationship
                if (!empty($id)) {
                    if ((int)$id === $parent_id) {
                        $parent_id = 0;
                    } else {
                        $descendants = $this->category_model->get_descendant_ids($id);
                        if (in_array($parent_id, $descendants, true)) {
                            $parent_id = 0;
                        }
                    }
                }

                $data = [
                    'parent_id'   => $parent_id,
                    'name'        => $name,
                    'slug'        => $slug,
                    'description' => $this->input->post('description', TRUE),
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'sort_order'  => (int) $this->input->post('sort_order'),
                    'status'      => $this->input->post('status', TRUE) ?: 'active'
                ];

                if ($this->input->post('image')) {
                    $data['image'] = $this->input->post('image', TRUE);
                }

                if (!empty($id)) {
                    $this->category_model->update($id, $data);
                    $this->session->set_flashdata('success', 'Category updated successfully.');
                } else {
                    $this->category_model->create($data);
                    $this->session->set_flashdata('success', 'Category created successfully.');
                }
                redirect('categories');
            }
        }

        $data = [
            'title'          => 'Category Management | Admin',
            'active_menu'    => 'products',
            'active_submenu' => 'categories',
            'categories'     => $this->category_model->get_all(),
            'parent_options' => $this->category_model->get_parent_options()
        ];

        $this->render('categories/index', $data);
    }

    public function delete($id)
    {
        $this->require_permission('categories.manage');
        $this->category_model->delete($id);
        $this->session->set_flashdata('success', 'Category deleted successfully.');
        redirect('categories');
    }
}
