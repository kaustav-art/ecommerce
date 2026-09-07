<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class wishlist_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_user($user_id)
    {
        return $this->db->select('w.id as wishlist_id, w.created_at as wishlisted_at, p.*, c.name as category_name, c.slug as category_slug')
                        ->from('wishlists w')
                        ->join('products p', 'p.id = w.product_id')
                        ->join('categories c', 'c.id = p.category_id', 'left')
                        ->where('w.user_id', (int) $user_id)
                        ->where('p.status', 'published')
                        ->order_by('w.id', 'DESC')
                        ->get()
                        ->result_array();
    }

    public function is_wishlisted($user_id, $product_id)
    {
        return $this->db->where('user_id', (int) $user_id)
                        ->where('product_id', (int) $product_id)
                        ->count_all_results('wishlists') > 0;
    }

    public function toggle($user_id, $product_id)
    {
        $existing = $this->db->where('user_id', (int) $user_id)
                             ->where('product_id', (int) $product_id)
                             ->get('wishlists')
                             ->row_array();

        if ($existing) {
            $this->db->where('id', $existing['id'])->delete('wishlists');
            return 'removed';
        } else {
            $this->db->insert('wishlists', [
                'user_id'    => (int) $user_id,
                'product_id' => (int) $product_id
            ]);
            return 'added';
        }
    }

    public function remove($user_id, $product_id)
    {
        return $this->db->where('user_id', (int) $user_id)
                        ->where('product_id', (int) $product_id)
                        ->delete('wishlists');
    }
}
