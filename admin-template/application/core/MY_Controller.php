<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 * Base Controller for CodeIgniter 3 Admin Template
 */
class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load URL and Form helpers by default
        $this->load->helper(['url', 'html', 'form']);
    }

    /**
     * Render a standard page with full admin layout (Header, Sidebar, Navbar, View, Footer)
     *
     * @param string $view
     * @param array  $data
     * @param bool   $return
     */
    public function render($view, $data = [], $return = FALSE)
    {
        $data['title'] = isset($data['title']) ? $data['title'] : 'Materialize - Admin Template';
        $data['active_menu'] = isset($data['active_menu']) ? $data['active_menu'] : 'dashboard';
        $data['active_submenu'] = isset($data['active_submenu']) ? $data['active_submenu'] : '';

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

    /**
     * Render a blank or auth page (without sidebar & main navbar)
     *
     * @param string $view
     * @param array  $data
     * @param bool   $return
     */
    public function render_blank($view, $data = [], $return = FALSE)
    {
        $data['title'] = isset($data['title']) ? $data['title'] : 'Materialize - Admin';

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
}
