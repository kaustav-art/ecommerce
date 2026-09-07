<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class marketing_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Coupons
    public function get_coupons()
    {
        return $this->db->order_by('id', 'DESC')->get('coupons')->result_array();
    }

    public function get_coupon($id)
    {
        return $this->db->where('id', (int) $id)->get('coupons')->row_array();
    }

    public function save_coupon($data, $id = null)
    {
        if (!empty($id)) {
            return $this->db->where('id', (int) $id)->update('coupons', $data);
        }
        return $this->db->insert('coupons', $data);
    }

    public function delete_coupon($id)
    {
        return $this->db->where('id', (int) $id)->delete('coupons');
    }

    // Flash Sales
    public function get_flash_sales()
    {
        $sales = $this->db->order_by('id', 'DESC')->get('flash_sales')->result_array();
        foreach ($sales as &$s) {
            $s['products_count'] = $this->db->where('flash_sale_id', $s['id'])->count_all_results('flash_sale_products');
        }
        return $sales;
    }

    public function get_flash_sale($id)
    {
        $sale = $this->db->where('id', (int) $id)->get('flash_sales')->row_array();
        if ($sale) {
            $sale['products'] = $this->db->select('fsp.*, p.title, p.price, p.main_image, p.sku')
                                         ->from('flash_sale_products fsp')
                                         ->join('products p', 'p.id = fsp.product_id')
                                         ->where('fsp.flash_sale_id', $sale['id'])
                                         ->get()
                                         ->result_array();
        }
        return $sale;
    }

    public function save_flash_sale($data, $id = null, $product_ids = [], $sale_prices = [])
    {
        if (!empty($id)) {
            $this->db->where('id', (int) $id)->update('flash_sales', $data);
            $fs_id = $id;
        } else {
            $this->db->insert('flash_sales', $data);
            $fs_id = $this->db->insert_id();
        }

        if (!empty($product_ids) && $fs_id) {
            $this->db->where('flash_sale_id', $fs_id)->delete('flash_sale_products');
            foreach ($product_ids as $pid) {
                $p_price = isset($sale_prices[$pid]) ? (float)$sale_prices[$pid] : 0.00;
                $this->db->insert('flash_sale_products', [
                    'flash_sale_id' => $fs_id,
                    'product_id'    => (int) $pid,
                    'sale_price'    => $p_price,
                    'quantity_limit'=> 50,
                    'sold_count'    => 0
                ]);
            }
        }
        return $fs_id;
    }

    public function delete_flash_sale($id)
    {
        return $this->db->where('id', (int) $id)->delete('flash_sales');
    }

    // Newsletter Subscribers
    public function get_subscribers()
    {
        return $this->db->order_by('id', 'DESC')->get('newsletter_subscribers')->result_array();
    }

    public function delete_subscriber($id)
    {
        return $this->db->where('id', (int) $id)->delete('newsletter_subscribers');
    }
}
