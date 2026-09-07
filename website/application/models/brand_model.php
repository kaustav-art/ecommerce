<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class brand_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($active_only = TRUE)
    {
        if ($active_only) {
            $this->db->where('status', 'active');
        }
        $brands = $this->db->order_by('name', 'ASC')->get('brands')->result_array();
        foreach ($brands as &$b) {
            $b['product_count'] = $this->db->where('brand_id', $b['id'])->where('status', 'published')->count_all_results('products');
        }
        return $brands;
    }

    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->where('status', 'active')->get('brands')->row_array();
    }
}
