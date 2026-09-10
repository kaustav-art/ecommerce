<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class orders extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $this->require_permission('orders.view');

        $status = $this->input->get('status');
        $orders = $this->order_model->get_all(NULL, NULL, $status);

        $data = [
            'title'           => 'Orders Management | Admin',
            'active_menu'     => 'orders',
            'orders'          => $orders,
            'selected_status' => $status,
            'currency_symbol' => $this->setting_model->get('currency_symbol', '$')
        ];

        $this->render('orders/index', $data);
    }

    public function view($id)
    {
        $this->require_permission('orders.view');

        $order = $this->order_model->get_by_id($id);
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('orders');
        }

        $data = [
            'title'           => 'Order Details #' . $order['order_number'] . ' | Admin',
            'active_menu'     => 'orders',
            'order'           => $order,
            'currency_symbol' => $this->setting_model->get('currency_symbol', '$')
        ];

        $this->render('orders/view', $data);
    }

    public function update_status($id)
    {
        $this->require_permission('orders.manage');

        if ($this->input->method() === 'post') {
            $order_status   = $this->input->post('order_status', TRUE);
            $payment_status = $this->input->post('payment_status', TRUE);

            $this->order_model->update($id, [
                'order_status'   => $order_status,
                'payment_status' => $payment_status
            ]);

            $this->session->set_flashdata('success', 'Order status updated successfully.');
        }
        redirect('orders/view/' . $id);
    }

    public function invoice($id)
    {
        $this->require_permission('orders.view');

        $order = $this->order_model->get_by_id($id);
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('orders');
        }

        $data = [
            'title'           => 'Invoice #' . $order['order_number'],
            'order'           => $order,
            'site_name'       => $this->setting_model->get('site_name', 'Store'),
            'site_email'      => $this->setting_model->get('site_email', 'billing@ecommerce.com'),
            'site_address'    => $this->setting_model->get('site_address', '123 Commerce St'),
            'currency_symbol' => $this->setting_model->get('currency_symbol', '$')
        ];

        $this->render_blank('orders/invoice', $data);
    }
}
