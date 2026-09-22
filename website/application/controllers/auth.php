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
                        'user_avatar'     => $user['avatar'] ?? null,
                        'user_logged_in'  => TRUE
                    ]);

                    // Sync guest cart to database and restore cross-device cart
                    $this->cart_model->sync_session_to_db($user['id']);

                    $this->session->set_flashdata('success', 'Welcome back, ' . $user['first_name'] . '!');

                    // Redirect to home after login
                    $redirect_url = $this->session->userdata('redirect_url');
                    $this->session->unset_userdata('redirect_url');
                    if (!empty($redirect_url) && strpos($redirect_url, 'checkout') === false) {
                        redirect($redirect_url);
                    }
                    redirect('home');
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
                    'user_avatar'     => null,
                    'user_logged_in'  => TRUE
                ]);

                // Sync guest cart to database and restore cross-device cart
                $this->cart_model->sync_session_to_db($user_id);

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
            'user_avatar',
            'user_logged_in'
        ]);
        $this->session->unset_userdata('cart');
        $this->session->unset_userdata('applied_coupon');
        redirect('');
    }

    public function send_otp()
    {
        $identifier    = trim($this->input->post('identifier', TRUE));
        $email_context = trim($this->input->post('email', TRUE));

        if (empty($identifier)) {
            $this->json_response(['success' => false, 'message' => 'Please enter a valid mobile number or email address.']);
        }

        $is_email = filter_var($identifier, FILTER_VALIDATE_EMAIL) !== false;

        // If user submitted an email as the initial identifier
        if ($is_email) {
            $this->json_response([
                'success' => true,
                'step'    => 'ask_phone',
                'email'   => strtolower($identifier),
                'message' => 'Please enter your mobile number to continue.'
            ]);
        }

        // Otherwise it is a mobile number
        $clean_phone = preg_replace('/[^0-9+]/', '', $identifier);
        $digits = preg_replace('/[^0-9]/', '', $clean_phone);
        if (strlen($digits) < 7 || strlen($digits) > 15) {
            $this->json_response(['success' => false, 'message' => 'Please enter a valid mobile number (at least 7 to 10 digits).']);
        }

        $attached_email = (!empty($email_context) && filter_var($email_context, FILTER_VALIDATE_EMAIL))
            ? strtolower($email_context)
            : null;

        // Check if phone number already exists in database
        $existing_user = $this->user_model->get_by_phone($clean_phone);
        $phone_exists  = (bool)$existing_user;

        $otp = (string) mt_rand(100000, 999999);

        // Store in session
        $this->session->set_userdata('otp_auth', [
            'phone'          => $clean_phone,
            'attached_email' => $attached_email,
            'code'           => $otp,
            'phone_exists'   => $phone_exists,
            'user_id'        => $existing_user ? (int)$existing_user['id'] : null,
            'expires_at'     => time() + 600 // 10 minutes
        ]);

        $this->json_response([
            'success'      => true,
            'step'         => 'otp',
            'phone'        => $clean_phone,
            'email'        => $attached_email,
            'phone_exists' => $phone_exists,
            'demo_otp'     => $otp,
            'message'      => 'A 6-digit verification code has been sent to ' . html_escape($clean_phone) . '.'
        ]);
    }

    public function verify_otp()
    {
        $phone       = trim($this->input->post('phone', TRUE)) ?: trim($this->input->post('identifier', TRUE));
        $otp         = trim($this->input->post('otp', TRUE));
        $redirect_to = $this->input->post('redirect_to', TRUE) ?: site_url('home');

        if (empty($otp)) {
            $this->json_response(['success' => false, 'message' => 'Please enter the 6-digit verification code.']);
        }

        $otp_session = $this->session->userdata('otp_auth');
        if (!$otp_session || !isset($otp_session['code'])) {
            $this->json_response(['success' => false, 'message' => 'OTP expired or not requested. Please request a new code.']);
        }

        if (time() > $otp_session['expires_at']) {
            $this->session->unset_userdata('otp_auth');
            $this->json_response(['success' => false, 'message' => 'OTP code has expired. Please request a new code.']);
        }

        if ($otp_session['code'] !== $otp) {
            $this->json_response(['success' => false, 'message' => 'Invalid OTP code. Please enter the correct code.']);
        }

        // OTP is correct!
        // Case 1: Phone number ALREADY exists in database -> Immediately login
        if (!empty($otp_session['phone_exists']) && !empty($otp_session['user_id'])) {
            $user = $this->user_model->get_by_id($otp_session['user_id']);
            if (!$user) {
                $user = $this->user_model->get_by_phone($otp_session['phone']);
            }

            if ($user && $user['status'] !== 'active') {
                $this->json_response(['success' => false, 'message' => 'Your account has been deactivated.']);
            }

            // Clear temporary sessions
            $this->session->unset_userdata('otp_auth');
            $this->session->unset_userdata('pending_reg');

            // Log user in
            $this->session->set_userdata([
                'user_id'         => $user['id'],
                'user_first_name' => $user['first_name'],
                'user_last_name'  => $user['last_name'],
                'user_email'      => $user['email'],
                'user_phone'      => $user['phone'],
                'user_avatar'     => $user['avatar'] ?? null,
                'user_logged_in'  => TRUE
            ]);

            // Sync guest cart to database and restore cross-device cart
            $this->cart_model->sync_session_to_db($user['id']);

            $this->json_response([
                'success'  => true,
                'status'   => 'logged_in',
                'is_new'   => false,
                'message'  => 'Welcome back, ' . $user['first_name'] . '!',
                'redirect' => $redirect_to,
                'user'     => [
                    'id'         => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name'  => $user['last_name'],
                    'email'      => $user['email'],
                    'phone'      => $user['phone']
                ]
            ]);
        }

        // Case 2: Phone number is NEW
        // Mark mobile as verified in session
        $this->session->set_userdata('pending_reg', [
            'phone'          => $otp_session['phone'],
            'email'          => $otp_session['attached_email'] ?? null,
            'phone_verified' => true,
            'verified_at'    => time()
        ]);
        $this->session->unset_userdata('otp_auth');

        // Check if email was already provided (user entered email first)
        if (!empty($otp_session['attached_email'])) {
            // "if the phone number is new too then next otp verified then asked for enter name."
            $this->json_response([
                'success'  => true,
                'status'   => 'need_name',
                'is_new'   => true,
                'phone'    => $otp_session['phone'],
                'email'    => $otp_session['attached_email'],
                'message'  => 'Mobile verified! Please enter your name to complete registration.'
            ]);
        } else {
            // "if user input a new phone number then verify the otp after then if the user is new then asked for email and enter name after then login."
            $this->json_response([
                'success'  => true,
                'status'   => 'need_email_name',
                'is_new'   => true,
                'phone'    => $otp_session['phone'],
                'message'  => 'Mobile verified! Please enter your email and name to complete registration.'
            ]);
        }
    }

    public function complete_registration()
    {
        $pending = $this->session->userdata('pending_reg');
        if (!$pending || empty($pending['phone_verified']) || empty($pending['phone'])) {
            $this->json_response(['success' => false, 'message' => 'Verification session expired. Please start again with your mobile or email.']);
        }

        $name        = trim($this->input->post('name', TRUE));
        $first_name  = trim($this->input->post('first_name', TRUE));
        $last_name   = trim($this->input->post('last_name', TRUE));
        $post_email  = trim($this->input->post('email', TRUE));
        $redirect_to = $this->input->post('redirect_to', TRUE) ?: site_url('home');

        // Resolve Email
        $final_email = !empty($pending['email']) ? strtolower(trim($pending['email'])) : strtolower($post_email);
        if (empty($final_email) || !filter_var($final_email, FILTER_VALIDATE_EMAIL)) {
            $this->json_response(['success' => false, 'message' => 'Please provide a valid email address.']);
        }

        // Check if email is already taken
        $existing_user_email = $this->user_model->get_by_email($final_email);
        if ($existing_user_email) {
            $this->json_response(['success' => false, 'message' => 'An account with email ' . html_escape($final_email) . ' already exists. Please use another email address or sign in.']);
        }

        // Resolve First Name and Last Name
        if (empty($first_name)) {
            if (empty($name)) {
                $this->json_response(['success' => false, 'message' => 'Please enter your name.']);
            }
            $parts = explode(' ', $name, 2);
            $first_name = $parts[0];
            $last_name  = !empty($parts[1]) ? $parts[1] : '';
        }

        // Create new account
        $new_user_id = $this->user_model->register([
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $final_email,
            'phone'      => $pending['phone'],
            'password'   => password_hash('User@' . mt_rand(10000, 99999), PASSWORD_BCRYPT),
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if (!$new_user_id) {
            $this->json_response(['success' => false, 'message' => 'Failed to create account. Please try again.']);
        }

        $user = $this->user_model->get_by_id($new_user_id);

        // Clear pending session
        $this->session->unset_userdata('pending_reg');
        $this->session->unset_userdata('otp_auth');

        // Log user in
        $this->session->set_userdata([
            'user_id'         => $user['id'],
            'user_first_name' => $user['first_name'],
            'user_last_name'  => $user['last_name'],
            'user_email'      => $user['email'],
            'user_phone'      => $user['phone'],
            'user_avatar'     => null,
            'user_logged_in'  => TRUE
        ]);

        // Sync guest cart to database and restore cross-device cart
        $this->cart_model->sync_session_to_db($user['id']);

        $this->json_response([
            'success'  => true,
            'status'   => 'registered_and_logged_in',
            'message'  => 'Registration successful! Welcome to ' . $this->site_name . ', ' . $user['first_name'] . '.',
            'redirect' => $redirect_to,
            'user'     => [
                'id'         => $user['id'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'email'      => $user['email'],
                'phone'      => $user['phone']
            ]
        ]);
    }
}
