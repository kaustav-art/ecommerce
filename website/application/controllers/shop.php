<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class shop extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index($category_slug = NULL)
    {
        $raw_category_slug = $category_slug ?: $this->input->get('category');
        $tpl_key           = $this->template_registry->get_tpl_key($this->active_template);

        if ($this->active_template !== 'fashion') {
            $dyn_cats       = $this->get_dynamic_template_categories($tpl_key);
            $all_categories = $dyn_cats;
            $root_categories= $dyn_cats;
            $all_products   = $this->get_dynamic_template_products($tpl_key);
        } else {
            $all_categories  = Static_template_data::get('all_categories');
            $root_categories = Static_template_data::get('root_categories');
            $all_products    = Static_template_data::get('products');
        }
        $brands            = Static_template_data::get('brands');
        $filter_sizes      = Static_template_data::get('filter_sizes');
        $filter_colors     = Static_template_data::get('filter_colors');

        $selected_category = NULL;
        $breadcrumbs       = [];
        $top_subcategories = $root_categories;

        if (!empty($raw_category_slug)) {
            foreach ($all_categories as $cat) {
                if (strcasecmp($cat['slug'], $raw_category_slug) === 0) {
                    $selected_category = $cat;
                    break;
                }
            }
            if (!$selected_category && $this->active_template !== 'fashion') {
                $selected_category = [
                    'id'            => 0,
                    'name'          => ucwords(str_replace('-', ' ', $raw_category_slug)),
                    'slug'          => $raw_category_slug,
                    'product_count' => count($all_products),
                ];
            }
        }

        if ($selected_category) {
            $breadcrumbs[] = $selected_category;
            $subcats = [];
            foreach ($all_categories as $cat) {
                if ((int)($cat['parent_id'] ?? 0) === (int)($selected_category['id'] ?? -1) && !empty($selected_category['id'])) {
                    $subcats[] = $cat;
                }
            }
            if (!empty($subcats)) {
                $top_subcategories = $subcats;
            }
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

        $is_brand_store = FALSE;
        $brand_info     = NULL;
        if (!empty($selected_brands) && count($selected_brands) === 1) {
            foreach ($brands as $b) {
                if (strcasecmp($b['slug'], $selected_brands[0]) === 0) {
                    $brand_info = $b;
                    break;
                }
            }
            if ($brand_info && empty($raw_category_slug)) {
                $is_brand_store = TRUE;
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

        // Sorting
        $sort_param   = $this->input->get('sort');
        $valid_sorts  = ['a-z', 'z-a', 'price-low-high', 'price-high-low'];
        $current_sort = in_array($sort_param, $valid_sorts) ? $sort_param : 'a-z';

        $products = $all_products;

        // Sort in memory
        usort($products, function($a, $b) use ($current_sort) {
            $pa = !empty($a['sale_price']) ? (float)$a['sale_price'] : (float)$a['price'];
            $pb = !empty($b['sale_price']) ? (float)$b['sale_price'] : (float)$b['price'];
            $ta = $a['title'] ?? ($a['name'] ?? '');
            $tb = $b['title'] ?? ($b['name'] ?? '');
            if ($current_sort === 'price-low-high') return $pa <=> $pb;
            if ($current_sort === 'price-high-low') return $pb <=> $pa;
            if ($current_sort === 'z-a') return strcasecmp($tb, $ta);
            return strcasecmp($ta, $tb);
        });

        $filters = [
            'category_slug'  => $raw_category_slug,
            'category_ids'   => $selected_category ? [$selected_category['id']] : NULL,
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

        $limit          = 16;
        $page           = 1;
        $offset         = 0;
        $per_page       = 16;
        $total_products = count($products);
        $total_pages    = 1;
        $has_more       = FALSE;
        $is_append      = FALSE;

        if ($is_brand_store && $brand_info) {
            $page_heading  = $brand_info['name'] . ' Store';
            $breadcrumbs[] = ['name' => $brand_info['name'] . ' Store', 'slug' => ''];
        } else {
            $page_heading = $selected_category ? $selected_category['name'] : 'Shop All Products';
        }

        $data = [
            'title'             => $page_heading . ' - ' . $this->site_name,
            'active_page'       => 'shop',
            'currency_symbol'   => $this->store_settings['currency_symbol'] ?? '$',
            'products'          => $products,
            'all_categories'    => $all_categories,
            'total_products'    => $total_products,
            'has_more'          => $has_more,
            'offset'            => $offset,
            'limit'             => $limit,
            'is_append'         => $is_append,
            'brands'            => $brands,
            'selected_brands'   => $selected_brands,
            'filter_sizes'      => $filter_sizes,
            'filter_colors'     => $filter_colors,
            'other_variants'    => [],
            'min_catalog_price' => 10,
            'max_catalog_price' => 300,
            'filters'           => $filters,
            'selected_category' => $selected_category,
            'breadcrumbs'       => $breadcrumbs,
            'top_subcategories' => $top_subcategories,
            'page_heading'      => $page_heading,
            'is_brand_store'    => $is_brand_store,
            'brand_info'        => $brand_info,
            'current_page'      => $page,
            'total_pages'       => $total_pages,
            'per_page'          => $per_page
        ];

        if ($this->input->is_ajax_request() || $this->input->get('ajax') == '1') {
            $products_html = $this->load->view('template1/shop/partials/product_grid', $data, TRUE);
            $meta_html     = $is_append ? '' : $this->load->view('template1/shop/partials/meta_bar', $data, TRUE);

            $this->json_response([
                'status'         => 'success',
                'total_products' => $total_products,
                'count'          => count($products),
                'offset'         => count($products),
                'has_more'       => FALSE,
                'products_html'  => $products_html,
                'meta_html'      => $meta_html
            ]);
            return;
        }

        $this->render('shop/index', $data);
    }

    public function autocomplete()
    {
        $q = trim((string) $this->input->get('q', TRUE));
        if (strlen($q) < 1) {
            $this->json_response(['results' => []]);
            return;
        }

        $symbol  = $this->store_settings['currency_symbol'] ?? '$';
        $results = [];
        $tpl_key = $this->template_folder ?? 'template1';

        $main_db_name = !empty($this->master_db_name) ? $this->master_db_name : $this->db->database;
        $check_p = $this->db->query("SHOW TABLES FROM `{$main_db_name}` LIKE 'template_products'")->row_array();
        if (!empty($check_p)) {
            $like_q = '%' . $this->db->escape_like_str($q) . '%';
            $tpl_rows = $this->db->query(
                "SELECT p.*, c.name AS cat_name
                 FROM `{$main_db_name}`.`template_products` p
                 LEFT JOIN `{$main_db_name}`.`template_categories` c ON c.id = p.category_id
                 WHERE p.template_key = ? AND p.status = 1
                   AND (p.title LIKE ? OR c.name LIKE ?)
                 ORDER BY p.sort_order ASC, p.id ASC
                 LIMIT 8",
                [$tpl_key, $like_q, $like_q]
            )->result_array();

            if (!empty($tpl_rows)) {
                foreach ($tpl_rows as $r) {
                    $price = (!empty($r['sale_price']) && (float) $r['sale_price'] > 0) ? (float) $r['sale_price'] : (float) $r['price'];
                    $img = $r['image'] ?? '';
                    $clean = ltrim($img, '/');
                    if (strpos($img, 'http://') === 0 || strpos($img, 'https://') === 0) {
                        $img_url = $img;
                    } elseif (strpos($clean, 'assets/') === 0) {
                        $img_url = base_url($clean);
                    } elseif (file_exists(FCPATH . 'assets/images/' . $clean)) {
                        $img_url = base_url('assets/images/' . $clean);
                    } elseif (file_exists(FCPATH . 'assets/templates/bazaro/img/' . $clean)) {
                        $img_url = base_url('assets/templates/bazaro/img/' . $clean);
                    } else {
                        $img_url = base_url('assets/images/' . $clean);
                    }
                    $results[] = [
                        'id'            => (int) $r['id'],
                        'title'         => $r['title'],
                        'sku'           => 'SKU-' . $r['id'],
                        'category_name' => $r['cat_name'] ?? 'Products',
                        'price_html'    => $symbol . number_format($price, 2),
                        'url'           => site_url('product/' . $r['slug']),
                        'image'         => $img_url
                    ];
                }
                $this->json_response(['results' => $results]);
                return;
            }
        }

        $all_products = Static_template_data::get('products');
        foreach ($all_products as $item) {
            if (stripos($item['title'], $q) !== FALSE || stripos($item['category_name'] ?? '', $q) !== FALSE) {
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
        }

        $this->json_response(['results' => array_slice($results, 0, 8)]);
    }
}
