<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $categories = $this->db->order_by('sort_order', 'ASC')->order_by('id', 'ASC')->get('categories')->result_array();
        $cat_map = [];
        foreach ($categories as $cat) {
            $cat_map[$cat['id']] = $cat;
        }

        foreach ($categories as &$cat) {
            $cat['product_count'] = $this->db->where('category_id', $cat['id'])->count_all_results('products');
            $cat['breadcrumb_path'] = $this->build_path_string($cat['id'], $cat_map);
            $cat['parent_name'] = (!empty($cat['parent_id']) && isset($cat_map[$cat['parent_id']]))
                ? $cat_map[$cat['parent_id']]['name']
                : 'Top Level';
        }
        return $categories;
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get('categories')->row_array();
    }

    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->get('categories')->row_array();
    }

    public function get_parent_options($exclude_id = NULL)
    {
        $all = $this->db->order_by('sort_order', 'ASC')->order_by('name', 'ASC')->get('categories')->result_array();
        $cat_map = [];
        foreach ($all as $c) {
            $cat_map[$c['id']] = $c;
        }

        $excluded_ids = [];
        if (!empty($exclude_id)) {
            $excluded_ids[] = (int) $exclude_id;
            $descendants = $this->get_descendant_ids((int) $exclude_id);
            $excluded_ids = array_merge($excluded_ids, $descendants);
        }

        $result = [];
        foreach ($all as $c) {
            if (in_array((int)$c['id'], $excluded_ids, true)) {
                continue;
            }
            $c['full_path'] = $this->build_path_string($c['id'], $cat_map);
            $result[] = $c;
        }

        // Sort by full path for clean hierarchical dropdown
        usort($result, function ($a, $b) {
            return strcasecmp($a['full_path'], $b['full_path']);
        });

        return $result;
    }

    public function get_descendant_ids($parent_id)
    {
        $descendants = [];
        $children = $this->db->where('parent_id', (int) $parent_id)->get('categories')->result_array();
        foreach ($children as $child) {
            $descendants[] = (int) $child['id'];
            $sub = $this->get_descendant_ids((int) $child['id']);
            if (!empty($sub)) {
                $descendants = array_merge($descendants, $sub);
            }
        }
        return $descendants;
    }

    public function build_path_string($category_id, array $cat_map)
    {
        $trail = [];
        $curr_id = (int) $category_id;
        $seen = [];
        while ($curr_id > 0 && isset($cat_map[$curr_id]) && !isset($seen[$curr_id])) {
            $seen[$curr_id] = true;
            array_unshift($trail, $cat_map[$curr_id]['name']);
            $curr_id = (int) ($cat_map[$curr_id]['parent_id'] ?? 0);
        }
        return !empty($trail) ? implode(' > ', $trail) : '';
    }

    public function create($data)
    {
        $this->db->insert('categories', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('categories', $data);
    }

    public function delete($id)
    {
        // Re-parent children to 0 or delete
        $this->db->where('parent_id', (int) $id)->update('categories', ['parent_id' => 0]);
        return $this->db->where('id', (int) $id)->delete('categories');
    }
}
