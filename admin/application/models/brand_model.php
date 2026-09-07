<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class brand_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $brands = $this->db->order_by('name', 'ASC')->get('brands')->result_array();
        foreach ($brands as &$b) {
            $b['product_count'] = $this->db->where('brand_id', $b['id'])->count_all_results('products');
        }
        return $brands;
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get('brands')->row_array();
    }

    public function create($data)
    {
        $this->db->insert('brands', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('brands', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int) $id)->delete('brands');
    }
}
