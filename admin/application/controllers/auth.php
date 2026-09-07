<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('role_model');
    }

    public function login()
    {
        if ($this->is_logged_in()) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $email    = $this->input->post('email', TRUE);
                $password = $this->input->post('password');

                $admin = $this->admin_model->get_by_email($email);

                if ($admin && password_verify($password, $admin['password'])) {
                    if ($admin['status'] !== 'active') {
                        $this->session->set_flashdata('error', 'Your administrator account is deactivated.');
                        redirect('auth/login');
                    }

                    // Get role permissions
                    $permissions = $this->role_model->get_role_permission_slugs($admin['role_id']);

                    $session_data = [
                        'admin_id'          => $admin['id'],
                        'admin_name'        => $admin['name'],
                        'admin_email'       => $admin['email'],
                        'admin_role_id'     => $admin['role_id'],
                        'admin_role_name'   => $admin['role_name'],
                        'admin_role_slug'   => $admin['role_slug'],
                        'admin_permissions' => $permissions,
                        'admin_logged_in'   => TRUE
                    ];

                    $this->session->set_userdata($session_data);
                    $this->admin_model->update_last_login($admin['id']);

                    $this->session->set_flashdata('success', 'Welcome back, ' . $admin['name'] . '!');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Invalid email or password.');
                    redirect('auth/login');
                }
            }
        }

        $data['title'] = 'Sign In | Admin Panel';
        $this->render_blank('auth/login', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata([
            'admin_id',
            'admin_name',
            'admin_email',
            'admin_role_id',
            'admin_role_name',
            'admin_role_slug',
            'admin_permissions',
            'admin_logged_in'
        ]);
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
