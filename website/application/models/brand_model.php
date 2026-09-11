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

    public function get_brands_by_category_ids($category_ids = [])
    {
        $this->db->select('b.id, b.name, b.slug, COUNT(DISTINCT p.id) as product_count')
                 ->from('brands b')
                 ->join('products p', 'p.brand_id = b.id AND p.status = "published"')
                 ->where('b.status', 'active');

        if (!empty($category_ids) && is_array($category_ids)) {
            $this->db->where_in('p.category_id', $category_ids);
        }

        return $this->db->group_by('b.id')
                        ->order_by('b.name', 'ASC')
                        ->get()
                        ->result_array();
    }

    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->where('status', 'active')->get('brands')->row_array();
    }
}
