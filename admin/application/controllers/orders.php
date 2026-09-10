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
            $order_status    = $this->input->post('order_status', TRUE);
            $payment_status  = $this->input->post('payment_status', TRUE);
            $courier_name    = trim($this->input->post('courier_name', TRUE));
            $tracking_number = trim($this->input->post('tracking_number', TRUE));
            $tracking_url    = trim($this->input->post('tracking_url', TRUE));

            // Auto-generate standard tracking URL if courier and AWB provided but URL is empty
            if (!empty($tracking_number) && empty($tracking_url)) {
                $c_lower = strtolower($courier_name);
                if (strpos($c_lower, 'xpress') !== false) {
                    $tracking_url = 'https://www.xpressbees.com/shipment/tracking?awbNo=' . urlencode($tracking_number);
                } elseif (strpos($c_lower, 'delhivery') !== false) {
                    $tracking_url = 'https://www.delhivery.com/track/package/' . urlencode($tracking_number);
                } elseif (strpos($c_lower, 'dtdc') !== false) {
                    $tracking_url = 'https://www.dtdc.in/tracking.asp';
                } elseif (strpos($c_lower, 'blue') !== false) {
                    $tracking_url = 'https://www.bluedart.com/tracking';
                } elseif (strpos($c_lower, 'ekart') !== false) {
                    $tracking_url = 'https://ekartlogistics.com/shipmenttrack/' . urlencode($tracking_number);
                } elseif (strpos($c_lower, 'shadowfax') !== false) {
                    $tracking_url = 'https://tracker.shadowfax.in/#/track?awb=' . urlencode($tracking_number);
                } elseif (strpos($c_lower, 'speed') !== false || strpos($c_lower, 'post') !== false) {
                    $tracking_url = 'https://www.indiapost.gov.in/_layouts/15/dpt.cept.tracking/trackconsignment.aspx';
                }
            }

            $update_data = [
                'order_status'    => $order_status,
                'payment_status'  => $payment_status,
                'courier_name'    => !empty($courier_name) ? $courier_name : NULL,
                'tracking_number' => !empty($tracking_number) ? $tracking_number : NULL,
                'tracking_url'    => !empty($tracking_url) ? $tracking_url : NULL
            ];

            if ($order_status === 'shipped') {
                $update_data['shipped_at'] = date('Y-m-d H:i:s');
            } elseif ($order_status === 'delivered') {
                $update_data['delivered_at'] = date('Y-m-d H:i:s');
            }

            $this->order_model->update($id, $update_data);

            $this->session->set_flashdata('success', 'Order status & courier dispatch details updated successfully.');
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

        // Admin can download invoice at any time after the order is confirmed
        $is_confirmed = in_array(strtolower($order['order_status']), ['processing', 'shipped', 'delivered', 'completed']);
        if (!$is_confirmed) {
            $this->session->set_flashdata('error', 'Invoice can only be downloaded after the order has been confirmed.');
            redirect('orders/view/' . $id);
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
