<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class attribute_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $attributes = $this->db->order_by('name', 'ASC')->get('attributes')->result_array();
        foreach ($attributes as &$attr) {
            $attr['values'] = $this->get_values($attr['id']);
            $attr['values_count'] = count($attr['values']);
        }
        return $attributes;
    }

    public function get_by_id($id)
    {
        $attr = $this->db->where('id', (int) $id)->get('attributes')->row_array();
        if ($attr) {
            $attr['values'] = $this->get_values($attr['id']);
        }
        return $attr;
    }

    public function get_values($attribute_id)
    {
        return $this->db->where('attribute_id', (int) $attribute_id)
                        ->order_by('sort_order', 'ASC')
                        ->order_by('value', 'ASC')
                        ->get('attribute_values')
                        ->result_array();
    }

    public function create($data)
    {
        $this->db->insert('attributes', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('attributes', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int) $id)->delete('attributes');
    }

    public function add_value($attribute_id, $value, $color_code = NULL, $sort_order = 0)
    {
        $data = [
            'attribute_id' => (int) $attribute_id,
            'value'        => trim($value),
            'color_code'   => $color_code ? trim($color_code) : NULL,
            'sort_order'   => (int) $sort_order
        ];
        $this->db->insert('attribute_values', $data);
        return $this->db->insert_id();
    }

    public function delete_value($id)
    {
        return $this->db->where('id', (int) $id)->delete('attribute_values');
    }

    public function get_product_attributes($product_id)
    {
        return $this->db->select('pa.*, a.name, a.slug, a.type')
                        ->from('product_attributes pa')
                        ->join('attributes a', 'a.id = pa.attribute_id')
                        ->where('pa.product_id', (int) $product_id)
                        ->get()
                        ->result_array();
    }
}
