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
}
