<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_products($filters = [], $limit = 12, $offset = 0)
    {
        $this->db->select('p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name')
                 ->from('products p')
                 ->join('categories c', 'c.id = p.category_id', 'left')
                 ->join('brands b', 'b.id = p.brand_id', 'left')
                 ->where('p.status', 'published');

        if (!empty($filters['category_ids']) && is_array($filters['category_ids'])) {
            $this->db->where_in('p.category_id', $filters['category_ids']);
        } elseif (!empty($filters['category_id'])) {
            $this->db->where('p.category_id', (int) $filters['category_id']);
        } elseif (!empty($filters['category_slug'])) {
            $this->db->where('c.slug', $filters['category_slug']);
        }
        if (!empty($filters['brand_id'])) {
            $this->db->where('p.brand_id', (int) $filters['brand_id']);
        }
        if (!empty($filters['brand_slugs']) && is_array($filters['brand_slugs'])) {
            $this->db->where_in('b.slug', $filters['brand_slugs']);
        } elseif (!empty($filters['brand_slug'])) {
            $this->db->where('b.slug', $filters['brand_slug']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('p.title', $filters['search']);
            $this->db->or_like('p.description', $filters['search']);
            $this->db->or_like('p.sku', $filters['search']);
            $this->db->group_end();
        }
        if (isset($filters['min_price']) && is_numeric($filters['min_price'])) {
            $this->db->where('COALESCE(p.sale_price, p.price) >=', (float) $filters['min_price']);
        }
        if (isset($filters['max_price']) && is_numeric($filters['max_price']) && $filters['max_price'] > 0) {
            $this->db->where('COALESCE(p.sale_price, p.price) <=', (float) $filters['max_price']);
        }
        if (!empty($filters['on_sale'])) {
            $this->db->where('p.sale_price IS NOT NULL', NULL, FALSE);
            $this->db->where('p.sale_price >', 0);
        }
        if (!empty($filters['rating']) && is_numeric($filters['rating'])) {
            $this->db->where('p.rating >=', (float) $filters['rating']);
        }
        if (!empty($filters['in_stock'])) {
            $this->db->where('p.stock_quantity >', 0);
        }
        if (!empty($filters['attr_value_ids']) && is_array($filters['attr_value_ids'])) {
            $val_ids = array_map('intval', $filters['attr_value_ids']);
            if (!empty($val_ids)) {
                $this->db->where("p.id IN (SELECT DISTINCT pv.product_id FROM product_variants pv JOIN product_variant_values pvv ON pvv.variant_id = pv.id WHERE pvv.attribute_value_id IN (" . implode(',', $val_ids) . "))", NULL, FALSE);
            }
        }
        if (isset($filters['is_new'])) {
            $this->db->where('p.is_new', (int) $filters['is_new']);
        }
        if (isset($filters['is_featured'])) {
            $this->db->where('p.is_featured', (int) $filters['is_featured']);
        }
        if (isset($filters['is_trending'])) {
            $this->db->where('p.is_trending', (int) $filters['is_trending']);
        }

        // Sorting
        $sort = isset($filters['sort']) ? $filters['sort'] : 'a-z';
        switch ($sort) {
            case 'price_low':
            case 'price-low-high':
                $this->db->order_by('COALESCE(p.sale_price, p.price)', 'ASC');
                break;
            case 'price_high':
            case 'price-high-low':
                $this->db->order_by('COALESCE(p.sale_price, p.price)', 'DESC');
                break;
            case 'z-a':
                $this->db->order_by('p.title', 'DESC');
                break;
            case 'a-z':
            default:
                $this->db->order_by('p.title', 'ASC');
                break;
        }

        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }

        $products = $this->db->get()->result_array();
        foreach ($products as &$prod) {
            $prod['gallery_images_decoded'] = json_decode($prod['gallery_images'], true) ?: [];
        }
        return $products;
    }

    public function count_products($filters = [])
    {
        $this->db->from('products p')
                 ->join('categories c', 'c.id = p.category_id', 'left')
                 ->join('brands b', 'b.id = p.brand_id', 'left')
                 ->where('p.status', 'published');

        if (!empty($filters['category_ids']) && is_array($filters['category_ids'])) {
            $this->db->where_in('p.category_id', $filters['category_ids']);
        } elseif (!empty($filters['category_id'])) {
            $this->db->where('p.category_id', (int) $filters['category_id']);
        } elseif (!empty($filters['category_slug'])) {
            $this->db->where('c.slug', $filters['category_slug']);
        }
        if (!empty($filters['brand_id'])) {
            $this->db->where('p.brand_id', (int) $filters['brand_id']);
        }
        if (!empty($filters['brand_slugs']) && is_array($filters['brand_slugs'])) {
            $this->db->where_in('b.slug', $filters['brand_slugs']);
        } elseif (!empty($filters['brand_slug'])) {
            $this->db->where('b.slug', $filters['brand_slug']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('p.title', $filters['search']);
            $this->db->or_like('p.sku', $filters['search']);
            $this->db->group_end();
        }
        if (isset($filters['min_price']) && is_numeric($filters['min_price'])) {
            $this->db->where('COALESCE(p.sale_price, p.price) >=', (float) $filters['min_price']);
        }
        if (isset($filters['max_price']) && is_numeric($filters['max_price']) && $filters['max_price'] > 0) {
            $this->db->where('COALESCE(p.sale_price, p.price) <=', (float) $filters['max_price']);
        }
        if (!empty($filters['on_sale'])) {
            $this->db->where('p.sale_price IS NOT NULL', NULL, FALSE);
            $this->db->where('p.sale_price >', 0);
        }
        if (!empty($filters['rating']) && is_numeric($filters['rating'])) {
            $this->db->where('p.rating >=', (float) $filters['rating']);
        }
        if (!empty($filters['in_stock'])) {
            $this->db->where('p.stock_quantity >', 0);
        }
        if (!empty($filters['attr_value_ids']) && is_array($filters['attr_value_ids'])) {
            $val_ids = array_map('intval', $filters['attr_value_ids']);
            if (!empty($val_ids)) {
                $this->db->where("p.id IN (SELECT DISTINCT pv.product_id FROM product_variants pv JOIN product_variant_values pvv ON pvv.variant_id = pv.id WHERE pvv.attribute_value_id IN (" . implode(',', $val_ids) . "))", NULL, FALSE);
            }
        }
        if (isset($filters['is_new'])) {
            $this->db->where('p.is_new', (int) $filters['is_new']);
        }
        if (isset($filters['is_featured'])) {
            $this->db->where('p.is_featured', (int) $filters['is_featured']);
        }
        if (isset($filters['is_trending'])) {
            $this->db->where('p.is_trending', (int) $filters['is_trending']);
        }

        return $this->db->count_all_results();
    }

    public function get_by_slug($slug)
    {
        $product = $this->db->select('p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, b.slug as brand_slug')
                            ->from('products p')
                            ->join('categories c', 'c.id = p.category_id', 'left')
                            ->join('brands b', 'b.id = p.brand_id', 'left')
                            ->where('p.slug', $slug)
                            ->where('p.status', 'published')
                            ->get()
                            ->row_array();

        if ($product) {
            $product['gallery_images_decoded'] = json_decode($product['gallery_images'], true) ?: [];
            $product['highlights_decoded']     = !empty($product['highlights']) ? (json_decode($product['highlights'], true) ?: []) : [];
            $product['reviews'] = $this->get_product_reviews($product['id']);
            $product['variants'] = $this->get_variants($product['id']);
            $product['attributes'] = $this->get_product_attributes_and_values($product['id']);
            $product['specifications'] = $this->get_specifications($product['id']);
        }
        return $product;
    }

    public function get_by_id($id)
    {
        $product = $this->db->select('p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name')
                            ->from('products p')
                            ->join('categories c', 'c.id = p.category_id', 'left')
                            ->join('brands b', 'b.id = p.brand_id', 'left')
                            ->where('p.id', (int) $id)
                            ->where('p.status', 'published')
                            ->get()
                            ->row_array();

        if ($product) {
            $product['gallery_images_decoded'] = json_decode($product['gallery_images'], true) ?: [];
            $product['highlights_decoded']     = !empty($product['highlights']) ? (json_decode($product['highlights'], true) ?: []) : [];
            $product['variants'] = $this->get_variants($product['id']);
            $product['attributes'] = $this->get_product_attributes_and_values($product['id']);
            $product['specifications'] = $this->get_specifications($product['id']);
        }
        return $product;
    }

    public function get_featured($limit = 8)
    {
        return $this->get_products(['is_featured' => 1], $limit);
    }

    public function get_trending($limit = 8)
    {
        $this->db->select('p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name')
                 ->from('products p')
                 ->join('categories c', 'c.id = p.category_id', 'left')
                 ->join('brands b', 'b.id = p.brand_id', 'left')
                 ->where('p.status', 'published')
                 ->where('p.is_trending', 1)
                 ->order_by('p.id', 'DESC')
                 ->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_related($category_id, $exclude_id, $limit = 4)
    {
        return $this->db->select('p.*, c.name as category_name, b.name as brand_name')
                        ->from('products p')
                        ->join('categories c', 'c.id = p.category_id', 'left')
                        ->join('brands b', 'b.id = p.brand_id', 'left')
                        ->where('p.category_id', (int) $category_id)
                        ->where('p.id !=', (int) $exclude_id)
                        ->where('p.status', 'published')
                        ->limit($limit)
                        ->get()
                        ->result_array();
    }

    public function get_product_reviews($product_id)
    {
        return $this->db->where('product_id', (int) $product_id)
                        ->where('status', 'approved')
                        ->order_by('id', 'DESC')
                        ->get('reviews')
                        ->result_array();
    }

    public function add_review($data)
    {
        $this->db->insert('reviews', $data);
        $review_id = $this->db->insert_id();

        // Recalculate rating and reviews_count
        $stats = $this->db->select_avg('rating', 'avg_rating')
                          ->select_max('id', 'count')
                          ->where('product_id', $data['product_id'])
                          ->where('status', 'approved')
                          ->get('reviews')
                          ->row_array();

        $count = $this->db->where('product_id', $data['product_id'])->where('status', 'approved')->count_all_results('reviews');

        $this->db->where('id', $data['product_id'])->update('products', [
            'rating'        => $stats['avg_rating'] ?: 5.0,
            'reviews_count' => $count
        ]);

        return $review_id;
    }

    public function get_variants($product_id)
    {
        $variants = $this->db->where('product_id', (int) $product_id)
                             ->order_by('id', 'ASC')
                             ->get('product_variants')
                             ->result_array();

        foreach ($variants as &$v) {
            $v['values'] = $this->db->select('pvv.*, a.name as attribute_name, a.slug as attribute_slug, a.type as attribute_type, av.value as attribute_value, av.color_code')
                                    ->from('product_variant_values pvv')
                                    ->join('attributes a', 'a.id = pvv.attribute_id')
                                    ->join('attribute_values av', 'av.id = pvv.attribute_value_id')
                                    ->where('pvv.variant_id', $v['id'])
                                    ->get()
                                    ->result_array();

            $attr_map = [];
            foreach ($v['values'] as $val) {
                $attr_map[$val['attribute_id']] = (int) $val['attribute_value_id'];
            }
            $v['attr_map'] = $attr_map;
        }
        return $variants;
    }

    public function get_product_attributes_and_values($product_id)
    {
        $attrs = $this->db->select('a.id, a.name, a.slug, a.type')
                          ->from('product_attributes pa')
                          ->join('attributes a', 'a.id = pa.attribute_id')
                          ->where('pa.product_id', (int) $product_id)
                          ->order_by('a.id', 'ASC')
                          ->get()
                          ->result_array();

        if (empty($attrs)) {
            $attrs = $this->db->select('DISTINCT a.id, a.name, a.slug, a.type', FALSE)
                              ->from('product_variant_values pvv')
                              ->join('product_variants pv', 'pv.id = pvv.variant_id')
                              ->join('attributes a', 'a.id = pvv.attribute_id')
                              ->where('pv.product_id', (int) $product_id)
                              ->order_by('a.id', 'ASC')
                              ->get()
                              ->result_array();
        }

        $result = [];
        foreach ($attrs as $a) {
            $values = $this->db->select('DISTINCT av.id, av.value, av.color_code, av.sort_order', FALSE)
                               ->from('product_variant_values pvv')
                               ->join('product_variants pv', 'pv.id = pvv.variant_id')
                               ->join('attribute_values av', 'av.id = pvv.attribute_value_id')
                               ->where('pv.product_id', (int) $product_id)
                               ->where('pvv.attribute_id', $a['id'])
                               ->order_by('av.sort_order', 'ASC')
                               ->order_by('av.id', 'ASC')
                               ->get()
                               ->result_array();

            if (!empty($values)) {
                $a['values'] = $values;
                $result[$a['slug']] = $a;
            }
        }
        return $result;
    }

    public function get_specifications($product_id)
    {
        return $this->db->where('product_id', (int) $product_id)
                        ->order_by('sort_order', 'ASC')
                        ->get('product_specifications')
                        ->result_array();
    }

    public function get_variant_by_id($variant_id)
    {
        $v = $this->db->where('id', (int) $variant_id)->get('product_variants')->row_array();
        if ($v) {
            $v['values'] = $this->db->select('pvv.*, a.name as attribute_name, a.slug as attribute_slug, av.value as attribute_value, av.color_code')
                                    ->from('product_variant_values pvv')
                                    ->join('attributes a', 'a.id = pvv.attribute_id')
                                    ->join('attribute_values av', 'av.id = pvv.attribute_value_id')
                                    ->where('pvv.variant_id', $v['id'])
                                    ->get()
                                    ->result_array();
        }
        return $v;
    }

    public function get_by_ids($ids)
    {
        if (empty($ids) || !is_array($ids)) {
            return [];
        }
        $clean_ids = [];
        foreach ($ids as $id) {
            $int_id = (int) $id;
            if ($int_id > 0) $clean_ids[] = $int_id;
        }
        if (empty($clean_ids)) return [];

        $products = $this->db->select('p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name')
                             ->from('products p')
                             ->join('categories c', 'c.id = p.category_id', 'left')
                             ->join('brands b', 'b.id = p.brand_id', 'left')
                             ->where_in('p.id', $clean_ids)
                             ->where('p.status', 'published')
                             ->get()
                             ->result_array();

        foreach ($products as &$p) {
            $p['gallery_images_decoded'] = json_decode($p['gallery_images'], true) ?: [];
            $p['specifications']         = $this->get_specifications($p['id']);
        }
        return $products;
    }

    public function search_autocomplete($query, $limit = 8)
    {
        if (empty($query)) return [];
        return $this->db->select('p.id, p.title, p.slug, p.sku, p.price, p.sale_price, p.main_image, c.name as category_name')
                        ->from('products p')
                        ->join('categories c', 'c.id = p.category_id', 'left')
                        ->where('p.status', 'published')
                        ->group_start()
                            ->like('p.title', $query)
                            ->or_like('p.sku', $query)
                        ->group_end()
                        ->limit($limit)
                        ->get()
                        ->result_array();
    }

    public function get_frequently_bought_together($product_id, $category_id, $limit = 2)
    {
        return $this->db->select('p.*, c.name as category_name, b.name as brand_name')
                        ->from('products p')
                        ->join('categories c', 'c.id = p.category_id', 'left')
                        ->join('brands b', 'b.id = p.brand_id', 'left')
                        ->where('p.category_id', (int) $category_id)
                        ->where('p.id !=', (int) $product_id)
                        ->where('p.status', 'published')
                        ->where('p.stock_quantity >', 0)
                        ->order_by('p.rating', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result_array();
    }
}
