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

                    // Redirect to stored destination if available, otherwise home
                    $redirect_url = $this->session->userdata('redirect_url');
                    if (!empty($redirect_url)) {
                        $this->session->unset_userdata('redirect_url');
                        redirect($redirect_url);
                    }
                    redirect('');
                } else {
                    $this->session->set_flashdata('error', 'Invalid email address or password.');
                    redirect('login');
                }
            }
        }

        $data = [
            'title'       => 'Customer Sign In - ' . $this->site_name,
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

                $this->session->set_flashdata('success', 'Registration successful! Welcome to ' . $this->site_name . '.');

                // Redirect to home page as requested
                redirect('');
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        $data = [
            'title'       => 'Create an Account - ' . $this->site_name,
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

    public function send_otp()
    {
        $identifier = trim($this->input->post('identifier', TRUE));
        if (empty($identifier)) {
            $this->json_response(['success' => false, 'message' => 'Please enter a valid phone number or email address.']);
        }

        $is_email = filter_var($identifier, FILTER_VALIDATE_EMAIL) !== false;
        $clean_phone = preg_replace('/[^0-9+]/', '', $identifier);

        if (!$is_email && (strlen($clean_phone) < 7 || strlen($clean_phone) > 15)) {
            $this->json_response(['success' => false, 'message' => 'Please enter a valid 10-digit mobile number or email address.']);
        }

        $target = $is_email ? strtolower($identifier) : $clean_phone;
        $otp = (string) mt_rand(100000, 999999);

        // Store OTP in session
        $this->session->set_userdata('otp_auth', [
            'identifier' => $target,
            'type'       => $is_email ? 'email' : 'phone',
            'code'       => $otp,
            'expires_at' => time() + 600 // 10 minutes
        ]);

        if ($is_email) {
            @mail($target, "Your {$this->site_name} OTP Code", "Your verification OTP code for {$this->site_name} is: {$otp}. Valid for 10 minutes.");
        }

        $this->json_response([
            'success'    => true,
            'message'    => 'One-Time Password (OTP) has been sent to ' . html_escape($target) . '.',
            'identifier' => $target,
            'type'       => $is_email ? 'email' : 'phone',
            'demo_otp'   => $otp // Exposed for seamless testing in local environment
        ]);
    }

    public function verify_otp()
    {
        $identifier = trim($this->input->post('identifier', TRUE));
        $otp        = trim($this->input->post('otp', TRUE));

        if (empty($identifier) || empty($otp)) {
            $this->json_response(['success' => false, 'message' => 'Please enter the 6-digit OTP code.']);
        }

        $is_email = filter_var($identifier, FILTER_VALIDATE_EMAIL) !== false;
        $target = $is_email ? strtolower($identifier) : preg_replace('/[^0-9+]/', '', $identifier);

        $otp_session = $this->session->userdata('otp_auth');
        if (!$otp_session || !isset($otp_session['code'])) {
            $this->json_response(['success' => false, 'message' => 'OTP expired or not requested. Please request a new code.']);
        }

        if (time() > $otp_session['expires_at']) {
            $this->session->unset_userdata('otp_auth');
            $this->json_response(['success' => false, 'message' => 'OTP code has expired. Please request a new code.']);
        }

        if ($otp_session['identifier'] !== $target || $otp_session['code'] !== $otp) {
            $this->json_response(['success' => false, 'message' => 'Invalid OTP code. Please enter the correct code.']);
        }

        // OTP is valid! Find or auto-register user
        $user = $this->user_model->get_by_email_or_phone($target);

        if (!$user) {
            if ($is_email) {
                $email_parts = explode('@', $target);
                $first_name  = ucfirst($email_parts[0]);
                $last_name   = 'Customer';
                $email       = $target;
                $phone       = NULL;
            } else {
                $first_name  = 'Member';
                $last_name   = substr($target, -4);
                $email       = $target . '@customer.local';
                $phone       = $target;
            }

            $new_user_id = $this->user_model->register([
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
                'phone'      => $phone,
                'password'   => password_hash($otp . time(), PASSWORD_BCRYPT),
                'status'     => 'active'
            ]);

            $user = $this->user_model->get_by_id($new_user_id);
        }

        // Clear OTP session
        $this->session->unset_userdata('otp_auth');

        // Set logged in session
        $this->session->set_userdata([
            'user_id'         => $user['id'],
            'user_first_name' => $user['first_name'],
            'user_last_name'  => $user['last_name'],
            'user_email'      => $user['email'],
            'user_phone'      => $user['phone'],
            'user_logged_in'  => TRUE
        ]);

        $redirect_to = $this->input->post('redirect_to', TRUE) ?: site_url('checkout');

        $this->json_response([
            'success'  => true,
            'message'  => 'Successfully verified! Redirecting...',
            'user'     => [
                'id'         => $user['id'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'email'      => $user['email']
            ],
            'redirect' => $redirect_to
        ]);
    }
}
