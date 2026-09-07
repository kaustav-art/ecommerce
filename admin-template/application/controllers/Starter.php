<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Starter extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Starter Page | Materialize';
        $data['active_menu'] = 'starter';
        
        $this->render('starter', $data);
    }
}
