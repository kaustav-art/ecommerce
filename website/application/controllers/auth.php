<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function login()
    {
        // If already logged in, redirect to home page
        if ($this->is_logged_in()) {
            redirect('');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $email    = $this->input->post('email', TRUE);
                $password = $this->input->post('password');

                $user = $this->user_model->get_by_email($email);

                if ($user && password_verify($password, $user['password'])) {
                    if ($user['status'] !== 'active') {
                        $this->session->set_flashdata('error', 'Your account has been deactivated.');
                        redirect('login');
                    }

                    $this->session->set_userdata([
                        'user_id'         => $user['id'],
                        'user_first_name' => $user['first_name'],
                        'user_last_name'  => $user['last_name'],
                        'user_email'      => $user['email'],
                        'user_phone'      => $user['phone'],
                        'user_logged_in'  => TRUE
                    ]);

                    $this->session->set_flashdata('success', 'Welcome back, ' . $user['first_name'] . '!');

                    // Redirect to home page as requested
                    redirect('');
                } else {
                    $this->session->set_flashdata('error', 'Invalid email address or password.');
                    redirect('login');
                }
            }
        }

        $data = [
            'title'       => 'Customer Sign In - Modave',
            'active_page' => 'login'
        ];

        $this->render('auth/login', $data);
    }

    public function register()
    {
        // If already logged in, redirect to home page
        if ($this->is_logged_in()) {
            redirect('');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run() === TRUE) {
                $first_name = $this->input->post('first_name', TRUE);
                $last_name  = $this->input->post('last_name', TRUE);
                $email      = $this->input->post('email', TRUE);
                $password   = $this->input->post('password');

                $user_id = $this->user_model->register([
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'email'      => $email,
                    'password'   => password_hash($password, PASSWORD_BCRYPT),
                    'phone'      => $this->input->post('phone', TRUE),
                    'status'     => 'active'
                ]);

                $this->session->set_userdata([
                    'user_id'         => $user_id,
                    'user_first_name' => $first_name,
                    'user_last_name'  => $last_name,
                    'user_email'      => $email,
                    'user_phone'      => $this->input->post('phone', TRUE),
                    'user_logged_in'  => TRUE
                ]);

                $this->session->set_flashdata('success', 'Registration successful! Welcome to Modave.');

                // Redirect to home page as requested
                redirect('');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        $data = [
            'title'       => 'Create an Account - Modave',
            'active_page' => 'register'
        ];

        $this->render('auth/register', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata([
            'user_id',
            'user_first_name',
            'user_last_name',
            'user_email',
            'user_phone',
            'user_logged_in'
        ]);
        $this->session->set_flashdata('success', 'You have been signed out.');
        redirect('');
    }
}
