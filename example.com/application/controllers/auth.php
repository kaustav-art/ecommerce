<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 * In static template mode, there is no login page — user is always logged in
 * and navbar always displays the after-login dropdown menu.
 */
class auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        redirect('home');
    }

    public function register()
    {
        redirect('home');
    }

    public function logout()
    {
        redirect('home');
    }

    public function send_otp()
    {
        $this->json_response([
            'success'      => true,
            'step'         => 'otp',
            'phone'        => '+91 9876543210',
            'email'        => 'alex.morgan@example.com',
            'phone_exists' => true,
            'demo_otp'     => '123456',
            'message'      => 'Demo OTP is 123456.'
        ]);
    }

    public function verify_otp()
    {
        $user = Static_template_data::get('user');
        $this->json_response([
            'success'  => true,
            'status'   => 'logged_in',
            'is_new'   => false,
            'message'  => 'Welcome back, ' . $user['first_name'] . '!',
            'redirect' => site_url('home'),
            'user'     => $user
        ]);
    }

    public function complete_registration()
    {
        $user = Static_template_data::get('user');
        $this->json_response([
            'success'  => true,
            'status'   => 'registered_and_logged_in',
            'message'  => 'Welcome, ' . $user['first_name'] . '!',
            'redirect' => site_url('home'),
            'user'     => $user
        ]);
    }
}
