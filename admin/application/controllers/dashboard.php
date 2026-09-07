<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('product_model');
        $this->load->model('customer_model');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $this->require_permission('dashboard.view');

        $metrics = $this->order_model->get_metrics();
        $total_customers = $this->customer_model->count_all();
        $total_products  = $this->product_model->count_all();
        $low_stock_count = $this->product_model->get_low_stock_count(10);
        $recent_orders   = $this->order_model->get_recent_orders(5);
        $recent_customers = $this->customer_model->get_all(5);

        $data = [
            'title'            => 'eCommerce Dashboard | Admin',
            'active_menu'      => 'dashboard',
            'metrics'          => $metrics,
            'total_customers'  => $total_customers,
            'total_products'   => $total_products,
            'low_stock_count'  => $low_stock_count,
            'recent_orders'    => $recent_orders,
            'recent_customers' => $recent_customers,
            'currency_symbol'  => $this->setting_model->get('currency_symbol', '$')
        ];

        $this->render('dashboard/index', $data);
    }
}
