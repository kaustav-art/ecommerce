<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Dashboard - Analytics | Materialize';
        $data['active_menu'] = 'dashboard';
        $data['active_submenu'] = 'analytics';

        // Page specific stylesheets
        $data['extra_css'] = '
            <link rel="stylesheet" href="' . base_url('assets/vendor/libs/apex-charts/apex-charts.css') . '" />
            <link rel="stylesheet" href="' . base_url('assets/vendor/libs/swiper/swiper.css') . '" />
            <link rel="stylesheet" href="' . base_url('assets/vendor/css/pages/cards-statistics.css') . '" />
        ';

        // Page specific scripts
        $data['extra_js'] = '
            <script src="' . base_url('assets/vendor/libs/apex-charts/apexcharts.js') . '"></script>
            <script src="' . base_url('assets/vendor/libs/swiper/swiper.js') . '"></script>
            <script src="' . base_url('assets/js/dashboards-analytics.js') . '"></script>
        ';

        $this->render('dashboard', $data);
    }
}
