<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class shop extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('category_model');
        $this->load->model('brand_model');
    }

    public function index($category_slug = NULL)
    {
        $raw_category_slug = $category_slug ?: $this->input->get('category');
        $selected_category = NULL;
        $breadcrumbs       = [];
        $top_subcategories = [];
        $category_ids      = [];

        if (!empty($raw_category_slug)) {
            $selected_category = $this->category_model->get_by_slug($raw_category_slug);
        }

        if ($selected_category) {
            $breadcrumbs = $this->category_model->get_breadcrumbs($selected_category['id']);

            $subcats = $this->category_model->get_subcategories($selected_category['id']);
            if (!empty($subcats)) {
                $top_subcategories = $subcats;
            } else {
                if (!empty($selected_category['parent_id'])) {
                    $top_subcategories = $this->category_model->get_subcategories($selected_category['parent_id']);
                } else {
                    $top_subcategories = $this->category_model->get_root_categories();
                }
            }

            $category_ids = $this->category_model->get_all_category_ids_including_descendants($selected_category['id']);
        } else {
            $top_subcategories = $this->category_model->get_root_categories();
        }

        // Parse brand filter
        $brand_param = $this->input->get('brand');
        $selected_brands = [];
        if (!empty($brand_param)) {
            if (is_array($brand_param)) {
                $selected_brands = array_values(array_filter($brand_param));
            } else {
                $selected_brands = [trim($brand_param)];
            }
        }

        // Parse attribute value filters
        $attr_params = $this->input->get('attrs');
        $attr_value_ids = [];
        if (!empty($attr_params) && is_array($attr_params)) {
            $attr_value_ids = array_values(array_filter(array_map('intval', $attr_params)));
        } elseif (!empty($attr_params) && is_numeric($attr_params)) {
            $attr_value_ids = [(int) $attr_params];
        }

        // Sorting: only allow A-Z, Z-A, price-low-high, price-high-low; default to a-z
        $sort_param = $this->input->get('sort');
        $valid_sorts = ['a-z', 'z-a', 'price-low-high', 'price-high-low'];
        $current_sort = in_array($sort_param, $valid_sorts) ? $sort_param : 'a-z';

        $filters = [
            'category_slug'  => empty($category_ids) ? $raw_category_slug : NULL,
            'category_ids'   => !empty($category_ids) ? $category_ids : NULL,
            'brand_slugs'    => $selected_brands,
            'brand_slug'     => !empty($selected_brands) ? $selected_brands[0] : NULL,
            'search'         => $this->input->get('q'),
            'min_price'      => $this->input->get('min_price'),
            'max_price'      => $this->input->get('max_price'),
            'sort'           => $current_sort,
            'on_sale'        => $this->input->get('on_sale') ? 1 : NULL,
            'in_stock'       => $this->input->get('in_stock') ? 1 : NULL,
            'rating'         => $this->input->get('rating') ? (float) $this->input->get('rating') : NULL,
            'attr_value_ids' => $attr_value_ids
        ];

        // Pagination
        $page     = max(1, (int) $this->input->get('page'));
        $per_page = 12;
        $offset   = ($page - 1) * $per_page;

        $total_products = $this->product_model->count_products($filters);
        $products       = $this->product_model->get_products($filters, $per_page, $offset);
        $total_pages    = ceil($total_products / $per_page);

        // Brands with respect to selected product category
        $brands = $this->brand_model->get_brands_by_category_ids($category_ids);

        // Price range for current category / catalog
        $price_query = $this->db->select('MIN(COALESCE(p.sale_price, p.price)) as min_p, MAX(COALESCE(p.sale_price, p.price)) as max_p')
                                ->from('products p')
                                ->where('p.status', 'published');
        if (!empty($category_ids)) {
            $price_query->where_in('p.category_id', $category_ids);
        }
        $price_row = $price_query->get()->row_array();
        $min_catalog_price = !empty($price_row['min_p']) ? (int) floor($price_row['min_p']) : 0;
        $max_catalog_price = !empty($price_row['max_p']) ? (int) ceil($price_row['max_p']) : 500;
        if ($min_catalog_price >= $max_catalog_price) {
            $min_catalog_price = 0;
            $max_catalog_price = max(100, $max_catalog_price);
        }

        // Dynamic attributes (Size, Color, Other variants) with respect to product category
        $attr_query = $this->db->select('a.id as attr_id, a.name as attr_name, a.slug as attr_slug, a.type as attr_type,
                                         av.id as val_id, av.value as val_value, av.color_code, av.sort_order,
                                         COUNT(DISTINCT p.id) as product_count')
                                ->from('attributes a')
                                ->join('attribute_values av', 'av.attribute_id = a.id')
                                ->join('product_variant_values pvv', 'pvv.attribute_value_id = av.id')
                                ->join('product_variants pv', 'pv.id = pvv.variant_id')
                                ->join('products p', 'p.id = pv.product_id AND p.status = "published"');

        if (!empty($category_ids)) {
            $attr_query->where_in('p.category_id', $category_ids);
        }

        $raw_attrs = $attr_query->group_by(['a.id', 'av.id'])
                                ->order_by('a.id', 'ASC')
                                ->order_by('av.sort_order', 'ASC')
                                ->order_by('av.id', 'ASC')
                                ->get()
                                ->result_array();

        $filter_sizes = [];
        $filter_colors = [];
        $other_variants = [];

        foreach ($raw_attrs as $ra) {
            $slug = strtolower($ra['attr_slug']);
            $type = strtolower($ra['attr_type']);
            if ($slug === 'size') {
                $filter_sizes[] = [
                    'id'            => $ra['val_id'],
                    'value'         => $ra['val_value'],
                    'product_count' => $ra['product_count']
                ];
            } elseif ($slug === 'color' || $type === 'color') {
                $filter_colors[] = [
                    'id'            => $ra['val_id'],
                    'value'         => $ra['val_value'],
                    'color_code'    => $ra['color_code'],
                    'product_count' => $ra['product_count']
                ];
            } else {
                if (!isset($other_variants[$ra['attr_id']])) {
                    $other_variants[$ra['attr_id']] = [
                        'id'     => $ra['attr_id'],
                        'name'   => $ra['attr_name'],
                        'slug'   => $ra['attr_slug'],
                        'type'   => $ra['attr_type'],
                        'values' => []
                    ];
                }
                $other_variants[$ra['attr_id']]['values'][] = [
                    'id'            => $ra['val_id'],
                    'value'         => $ra['val_value'],
                    'color_code'    => $ra['color_code'],
                    'product_count' => $ra['product_count']
                ];
            }
        }

        $page_heading = $selected_category ? $selected_category['name'] : 'Shop All Products';

        $data = [
            'title'              => $page_heading . ' - ' . $this->site_name,
            'active_page'        => 'shop',
            'products'           => $products,
            'total_products'     => $total_products,
            'brands'             => $brands,
            'selected_brands'    => $selected_brands,
            'filter_sizes'       => $filter_sizes,
            'filter_colors'      => $filter_colors,
            'other_variants'     => $other_variants,
            'min_catalog_price'  => $min_catalog_price,
            'max_catalog_price'  => $max_catalog_price,
            'filters'            => $filters,
            'selected_category'  => $selected_category,
            'breadcrumbs'        => $breadcrumbs,
            'top_subcategories'  => $top_subcategories,
            'page_heading'       => $page_heading,
            'current_page'       => $page,
            'total_pages'        => $total_pages,
            'per_page'           => $per_page
        ];

        $this->render('shop/index', $data);
    }

    public function autocomplete()
    {
        $q = trim($this->input->get('q', TRUE));
        if (strlen($q) < 1) {
            $this->json_response(['results' => []]);
            return;
        }

        $items = $this->product_model->search_autocomplete($q, 8);
        $symbol = $this->store_settings['currency_symbol'] ?? '$';

        $results = [];
        foreach ($items as $item) {
            $price = !empty($item['sale_price']) ? (float) $item['sale_price'] : (float) $item['price'];
            $results[] = [
                'id'            => $item['id'],
                'title'         => $item['title'],
                'sku'           => $item['sku'],
                'category_name' => $item['category_name'],
                'price_html'    => $symbol . number_format($price, 2),
                'url'           => site_url('product/' . $item['slug']),
                'image'         => base_url('assets/images/' . $item['main_image'])
            ];
        }

        $this->json_response(['results' => $results]);
    }
}
