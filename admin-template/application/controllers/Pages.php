<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'html', 'form']);
    }

    /**
     * Render any of the 147 template pages dynamically
     *
     * @param string $page
     */
    public function view($page = 'dashboards-analytics')
    {
        // Strip extensions if provided in URL
        $page = str_replace(['.html', '.php'], '', $page);

        if (empty($page) || $page === 'index') {
            $page = 'dashboards-analytics';
        }

        $view_path = APPPATH . 'views/pages/' . $page . '.php';

        if (!file_exists($view_path)) {
            show_404();
            return;
        }

        $this->load->view('pages/' . $page);
    }
}
