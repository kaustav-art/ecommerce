<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $data['title'] = 'Login | Materialize';
        $this->render_blank('auth/login', $data);
    }

    public function logout()
    {
        // Add logout session destruction here when implementing authentication
        redirect('login');
    }
}
