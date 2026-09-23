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

        // Check if single brand store mode
        $is_brand_store = FALSE;
        $brand_info = NULL;
        if (!empty($selected_brands) && count($selected_brands) === 1) {
            $brand_info = $this->brand_model->get_by_slug($selected_brands[0]);
            if ($brand_info && empty($raw_category_slug)) {
                $is_brand_store = TRUE;
            }
        }

        // If no explicit category was specified, resolve brand's root category so filters match the brand's industry/department
        if (empty($selected_category) && !empty($selected_brands)) {
            $brand_cats = $this->db->select('DISTINCT p.category_id', FALSE)
                                   ->from('products p')
                                   ->join('brands b', 'b.id = p.brand_id')
                                   ->where_in('b.slug', $selected_brands)
                                   ->where('p.status', 'published')
                                   ->get()->result_array();

            if (!empty($brand_cats)) {
                $brand_cat_ids = array_map('intval', array_column($brand_cats, 'category_id'));
                $root_cat = NULL;
                foreach ($brand_cat_ids as $bc_id) {
                    $trail = $this->category_model->get_breadcrumbs($bc_id);
                    if (!empty($trail[0])) {
                        $root_cat = $trail[0];
                        break;
                    }
                }

                if ($root_cat) {
                    $selected_category = $root_cat;
                }
            }
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

        // Infinite scroll batching (16 products per batch: 16 initially, 16 on scrolling)
        $limit = (int) ($this->input->get('limit') ?: 16);
        if ($limit <= 0 || $limit > 50) {
            $limit = 16;
        }

        if ($this->input->get('offset') !== NULL) {
            $offset = max(0, (int) $this->input->get('offset'));
            $page   = floor($offset / $limit) + 1;
        } else {
            $page   = max(1, (int) $this->input->get('page'));
            $offset = ($page - 1) * $limit;
        }

        $per_page       = $limit;
        $total_products = $this->product_model->count_products($filters);
        $products       = $this->product_model->get_products($filters, $per_page, $offset);
        $total_pages    = ceil($total_products / $per_page);
        $has_more       = ($offset + count($products)) < $total_products;

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
        $tax_mult = $this->product_model->get_tax_multiplier();
        $min_catalog_price = !empty($price_row['min_p']) ? (int) floor($price_row['min_p'] * $tax_mult) : 0;
        $max_catalog_price = !empty($price_row['max_p']) ? (int) ceil($price_row['max_p'] * $tax_mult) : 500;
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

        if ($is_brand_store && $brand_info) {
            $page_heading = $brand_info['name'] . ' Store';
            $breadcrumbs[] = ['name' => $brand_info['name'] . ' Store', 'slug' => ''];
        } else {
            $page_heading = $selected_category ? $selected_category['name'] : 'Shop All Products';
        }

        $is_append = ($this->input->get('append') == '1' || ($offset > 0 && !$this->input->get('page')));

        $data = [
            'title'              => $page_heading . ' - ' . $this->site_name,
            'active_page'        => 'shop',
            'currency_symbol'    => $this->currency_symbol ?? ($this->store_settings['currency_symbol'] ?? '$'),
            'products'           => $products,
            'total_products'     => $total_products,
            'has_more'           => $has_more,
            'offset'             => $offset,
            'limit'              => $limit,
            'is_append'          => $is_append,
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
            'is_brand_store'     => $is_brand_store,
            'brand_info'         => $brand_info,
            'current_page'       => $page,
            'total_pages'        => $total_pages,
            'per_page'           => $per_page
        ];

        if ($this->input->is_ajax_request() || $this->input->get('ajax') == '1') {
            $products_html = $this->load->view('shop/partials/product_grid', $data, TRUE);
            $meta_html     = $is_append ? '' : $this->load->view('shop/partials/meta_bar', $data, TRUE);

            $this->json_response([
                'status'          => 'success',
                'total_products'  => $total_products,
                'count'           => count($products),
                'offset'          => $offset + count($products),
                'has_more'        => $has_more,
                'products_html'   => $products_html,
                'meta_html'       => $meta_html
            ]);
            return;
        }

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
