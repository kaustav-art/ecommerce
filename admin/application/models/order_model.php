<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($limit = NULL, $offset = NULL, $status = NULL)
    {
        $this->db->select('*')->from('orders');
        if (!empty($status)) {
            $this->db->where('order_status', $status);
        }
        $this->db->order_by('id', 'DESC');
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    public function count_all($status = NULL)
    {
        if (!empty($status)) {
            $this->db->where('order_status', $status);
        }
        return $this->db->count_all_results('orders');
    }

    public function get_by_id($id)
    {
        $order = $this->db->where('id', (int) $id)->get('orders')->row_array();
        if ($order) {
            $order['items'] = $this->db->where('order_id', $order['id'])->get('order_items')->result_array();
        }
        return $order;
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('orders', $data);
    }

    public function get_recent_orders($limit = 5)
    {
        return $this->db->order_by('id', 'DESC')->limit($limit)->get('orders')->result_array();
    }

    public function get_metrics()
    {
        $total_sales = $this->db->select_sum('total_amount')
                                ->where('payment_status', 'paid')
                                ->get('orders')
                                ->row()
                                ->total_amount;

        $total_orders = $this->db->count_all('orders');
        $pending_orders = $this->db->where('order_status', 'pending')->count_all_results('orders');
        $completed_orders = $this->db->where('order_status', 'delivered')->count_all_results('orders');

        return [
            'total_sales'      => (float) $total_sales,
            'total_orders'     => (int) $total_orders,
            'pending_orders'   => (int) $pending_orders,
            'completed_orders' => (int) $completed_orders
        ];
    }
}
