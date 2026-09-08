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

        $total_orders      = $this->db->count_all('orders');
        $pending_orders    = $this->db->where('order_status', 'pending')->count_all_results('orders');
        $processing_orders = $this->db->where('order_status', 'processing')->count_all_results('orders');
        $shipped_orders    = $this->db->where('order_status', 'shipped')->count_all_results('orders');
        $completed_orders  = $this->db->where('order_status', 'delivered')->count_all_results('orders');
        $cancelled_orders  = $this->db->where('order_status', 'cancelled')->count_all_results('orders');
        $paid_orders       = $this->db->where('payment_status', 'paid')->count_all_results('orders');

        $avg_order_value = ($paid_orders > 0) ? ((float) $total_sales / $paid_orders) : 0;

        return [
            'total_sales'        => (float) $total_sales,
            'total_orders'       => (int) $total_orders,
            'pending_orders'     => (int) $pending_orders,
            'processing_orders'  => (int) $processing_orders,
            'shipped_orders'     => (int) $shipped_orders,
            'completed_orders'   => (int) $completed_orders,
            'cancelled_orders'   => (int) $cancelled_orders,
            'paid_orders'        => (int) $paid_orders,
            'avg_order_value'    => (float) $avg_order_value
        ];
    }

    public function get_monthly_sales_chart($months = 6)
    {
        $start_date = date('Y-m-01', strtotime("-" . ($months - 1) . " months"));
        $raw = $this->db->select("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) as revenue, COUNT(id) as total_orders")
                        ->from('orders')
                        ->where('created_at >=', $start_date . ' 00:00:00')
                        ->group_by('ym')
                        ->order_by('ym', 'ASC')
                        ->get()
                        ->result_array();

        $indexed = [];
        foreach ($raw as $r) {
            $indexed[$r['ym']] = [
                'revenue' => (float) $r['revenue'],
                'orders'  => (int) $r['total_orders']
            ];
        }

        $categories = [];
        $revenue_series = [];
        $orders_series = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $time = strtotime("-$i months");
            $ym = date('Y-m', $time);
            $label = date('M Y', $time);
            $categories[] = $label;
            $revenue_series[] = isset($indexed[$ym]) ? round($indexed[$ym]['revenue'], 2) : 0;
            $orders_series[] = isset($indexed[$ym]) ? $indexed[$ym]['orders'] : 0;
        }

        return [
            'categories' => $categories,
            'revenue'    => $revenue_series,
            'orders'     => $orders_series
        ];
    }

    public function get_order_status_distribution()
    {
        $raw = $this->db->select('order_status, COUNT(id) as count')
                        ->from('orders')
                        ->group_by('order_status')
                        ->get()
                        ->result_array();

        $distribution = [
            'delivered'  => 0,
            'shipped'    => 0,
            'processing' => 0,
            'pending'    => 0,
            'cancelled'  => 0
        ];

        foreach ($raw as $r) {
            if (isset($distribution[$r['order_status']])) {
                $distribution[$r['order_status']] = (int) $r['count'];
            }
        }

        return $distribution;
    }
}
