<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($limit = NULL, $offset = NULL)
    {
        $this->db->order_by('id', 'DESC');
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        $customers = $this->db->get('users')->result_array();
        foreach ($customers as &$c) {
            $c['orders_count'] = $this->db->where('user_id', $c['id'])->count_all_results('orders');
            $c['total_spent']  = (float) $this->db->select_sum('total_amount')->where('user_id', $c['id'])->where('payment_status', 'paid')->get('orders')->row()->total_amount;
        }
        return $customers;
    }

    public function count_all()
    {
        return $this->db->count_all('users');
    }

    public function get_by_id($id)
    {
        $customer = $this->db->where('id', (int) $id)->get('users')->row_array();
        if ($customer) {
            $customer['addresses'] = $this->db->where('user_id', $customer['id'])->get('user_addresses')->result_array();
            $customer['orders']    = $this->db->where('user_id', $customer['id'])->order_by('id', 'DESC')->get('orders')->result_array();
        }
        return $customer;
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('users', $data);
    }
}
