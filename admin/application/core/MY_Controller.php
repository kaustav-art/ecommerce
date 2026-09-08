<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 * Base Controller for Admin Panel with RBAC security & layout rendering
 */
class MY_Controller extends CI_Controller {

    public $current_admin = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'html', 'form', 'text', 'security']);
        $this->load->library(['session', 'form_validation']);

        // Exclude 'auth' controller from forced login check
        $controller = strtolower($this->router->class);
        if ($controller !== 'auth') {
            if (!$this->is_logged_in()) {
                redirect('auth/login');
            }
            $this->current_admin = [
                'id'          => $this->session->userdata('admin_id'),
                'name'        => $this->session->userdata('admin_name'),
                'email'       => $this->session->userdata('admin_email'),
                'role_id'     => $this->session->userdata('admin_role_id'),
                'role_name'   => $this->session->userdata('admin_role_name'),
                'role_slug'   => $this->session->userdata('admin_role_slug'),
                'permissions' => (array) $this->session->userdata('admin_permissions')
            ];
        }
    }

    public function is_logged_in()
    {
        return (bool) $this->session->userdata('admin_logged_in');
    }

    public function can($permission_slug)
    {
        if (!$this->is_logged_in()) {
            return false;
        }
        if ($this->session->userdata('admin_role_slug') === 'super-admin') {
            return true;
        }
        $perms = (array) $this->session->userdata('admin_permissions');
        return in_array($permission_slug, $perms);
    }

    public function require_permission($permission_slug)
    {
        if (!$this->can($permission_slug)) {
            $this->session->set_flashdata('error', 'Access Denied: You do not have permission to access this resource.');
            redirect('dashboard');
        }
    }

    public function render($view, $data = [], $return = FALSE)
    {
        $data['title']          = isset($data['title']) ? $data['title'] : 'Admin Panel - Modave eCommerce';
        $data['active_menu']    = isset($data['active_menu']) ? $data['active_menu'] : 'dashboard';
        $data['active_submenu'] = isset($data['active_submenu']) ? $data['active_submenu'] : '';
        $data['current_admin']  = $this->current_admin;

        if (!isset($data['store_settings'])) {
            $this->load->model('setting_model');
            $data['store_settings'] = $this->setting_model->get_all();
        }

        if ($return) {
            $content  = $this->load->view('layouts/header', $data, TRUE);
            $content .= $this->load->view('layouts/sidebar', $data, TRUE);
            $content .= $this->load->view('layouts/navbar', $data, TRUE);
            $content .= $this->load->view($view, $data, TRUE);
            $content .= $this->load->view('layouts/footer', $data, TRUE);
            return $content;
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('layouts/navbar', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer', $data);
    }

    public function render_blank($view, $data = [], $return = FALSE)
    {
        $data['title'] = isset($data['title']) ? $data['title'] : 'Admin Panel';

        if (!isset($data['store_settings'])) {
            $this->load->model('setting_model');
            $data['store_settings'] = $this->setting_model->get_all();
        }

        if ($return) {
            $content  = $this->load->view('layouts/auth_header', $data, TRUE);
            $content .= $this->load->view($view, $data, TRUE);
            $content .= $this->load->view('layouts/auth_footer', $data, TRUE);
            return $content;
        }

        $this->load->view('layouts/auth_header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/auth_footer', $data);
    }

    public function json_response($data, $status = 200)
    {
        $this->output
             ->set_status_header($status)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
             ->_display();
        exit;
    }

    public function upload_image_file($field_name, $subfolder = 'products', $prefix = 'img')
    {
        if (empty($_FILES[$field_name]['name'])) {
            return null;
        }

        $target_dir = FCPATH . '../website/assets/images/' . trim($subfolder, '/') . '/';
        if (!is_dir($target_dir)) {
            @mkdir($target_dir, 0777, TRUE);
        }

        $config = [];
        $config['upload_path']   = $target_dir;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
        $config['max_size']      = 10240; // 10MB
        $config['file_name']     = $prefix . '_' . time() . '_' . rand(100, 999);

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $data = $this->upload->data();
            return trim($subfolder, '/') . '/' . $data['file_name'];
        }

        return false;
    }

    public function upload_multiple_images($field_name, $subfolder = 'products', $prefix = 'gallery')
    {
        if (empty($_FILES[$field_name]['name']) || !is_array($_FILES[$field_name]['name'])) {
            return [];
        }

        $target_dir = FCPATH . '../website/assets/images/' . trim($subfolder, '/') . '/';
        if (!is_dir($target_dir)) {
            @mkdir($target_dir, 0777, TRUE);
        }

        $uploaded_files = [];
        $files_count = count($_FILES[$field_name]['name']);

        $this->load->library('upload');

        for ($i = 0; $i < $files_count; $i++) {
            if (empty($_FILES[$field_name]['name'][$i])) {
                continue;
            }

            $_FILES['single_upload']['name']     = $_FILES[$field_name]['name'][$i];
            $_FILES['single_upload']['type']     = $_FILES[$field_name]['type'][$i];
            $_FILES['single_upload']['tmp_name'] = $_FILES[$field_name]['tmp_name'][$i];
            $_FILES['single_upload']['error']    = $_FILES[$field_name]['error'][$i];
            $_FILES['single_upload']['size']     = $_FILES[$field_name]['size'][$i];

            $config = [];
            $config['upload_path']   = $target_dir;
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
            $config['max_size']      = 10240;
            $config['file_name']     = $prefix . '_' . time() . '_' . $i . '_' . rand(100, 999);

            $this->upload->initialize($config);
            if ($this->upload->do_upload('single_upload')) {
                $data = $this->upload->data();
                $uploaded_files[] = trim($subfolder, '/') . '/' . $data['file_name'];
            }
        }

        return $uploaded_files;
    }
}
