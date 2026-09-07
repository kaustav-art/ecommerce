<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customers extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $this->require_permission('customers.view');

        $customers = $this->customer_model->get_all();

        $data = [
            'title'           => 'Customers List | Admin',
            'active_menu'     => 'customers',
            'customers'       => $customers,
            'currency_symbol' => $this->setting_model->get('currency_symbol', '$')
        ];

        $this->render('customers/index', $data);
    }

    public function view($id)
    {
        $this->require_permission('customers.view');

        $customer = $this->customer_model->get_by_id($id);
        if (!$customer) {
            $this->session->set_flashdata('error', 'Customer not found.');
            redirect('customers');
        }

        $data = [
            'title'           => 'Customer Profile: ' . $customer['first_name'] . ' ' . $customer['last_name'] . ' | Admin',
            'active_menu'     => 'customers',
            'customer'        => $customer,
            'currency_symbol' => $this->setting_model->get('currency_symbol', '$')
        ];

        $this->render('customers/view', $data);
    }

    public function toggle_status($id)
    {
        $this->require_permission('customers.manage');

        $customer = $this->customer_model->get_by_id($id);
        if ($customer) {
            $new_status = ($customer['status'] === 'active') ? 'banned' : 'active';
            $this->customer_model->update($id, ['status' => $new_status]);
            $this->session->set_flashdata('success', 'Customer status updated to ' . $new_status);
        }
        redirect('customers');
    }
}
