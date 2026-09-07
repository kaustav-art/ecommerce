<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class variant_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_product($product_id)
    {
        $variants = $this->db->where('product_id', (int) $product_id)
                             ->order_by('id', 'ASC')
                             ->get('product_variants')
                             ->result_array();

        foreach ($variants as &$v) {
            $v['values'] = $this->db->select('pvv.*, a.name as attribute_name, a.slug as attribute_slug, av.value as attribute_value, av.color_code')
                                    ->from('product_variant_values pvv')
                                    ->join('attributes a', 'a.id = pvv.attribute_id')
                                    ->join('attribute_values av', 'av.id = pvv.attribute_value_id')
                                    ->where('pvv.variant_id', $v['id'])
                                    ->get()
                                    ->result_array();
        }
        return $variants;
    }

    public function get_by_id($id)
    {
        $variant = $this->db->where('id', (int) $id)->get('product_variants')->row_array();
        if ($variant) {
            $variant['values'] = $this->db->select('pvv.*, a.name as attribute_name, av.value as attribute_value')
                                          ->from('product_variant_values pvv')
                                          ->join('attributes a', 'a.id = pvv.attribute_id')
                                          ->join('attribute_values av', 'av.id = pvv.attribute_value_id')
                                          ->where('pvv.variant_id', $variant['id'])
                                          ->get()
                                          ->result_array();
        }
        return $variant;
    }

    public function create($data, $attr_val_ids = [])
    {
        $this->db->insert('product_variants', $data);
        $variant_id = $this->db->insert_id();

        if ($variant_id && !empty($attr_val_ids)) {
            foreach ($attr_val_ids as $attr_id => $val_id) {
                if (!empty($val_id)) {
                    $this->db->insert('product_variant_values', [
                        'variant_id'         => $variant_id,
                        'attribute_id'       => (int) $attr_id,
                        'attribute_value_id' => (int) $val_id
                    ]);
                }
            }
        }
        return $variant_id;
    }

    public function update($id, $data, $attr_val_ids = null)
    {
        $res = $this->db->where('id', (int) $id)->update('product_variants', $data);

        if ($attr_val_ids !== null) {
            $this->db->where('variant_id', (int) $id)->delete('product_variant_values');
            foreach ($attr_val_ids as $attr_id => $val_id) {
                if (!empty($val_id)) {
                    $this->db->insert('product_variant_values', [
                        'variant_id'         => (int) $id,
                        'attribute_id'       => (int) $attr_id,
                        'attribute_value_id' => (int) $val_id
                    ]);
                }
            }
        }
        return $res;
    }

    public function delete($id)
    {
        return $this->db->where('id', (int) $id)->delete('product_variants');
    }
}
