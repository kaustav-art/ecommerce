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

        // Parse attribute value filters
        $attr_params = $this->input->get('attrs');
        $attr_value_ids = [];
        if (!empty($attr_params) && is_array($attr_params)) {
            $attr_value_ids = array_map('intval', $attr_params);
        } elseif (!empty($attr_params) && is_numeric($attr_params)) {
            $attr_value_ids = [(int) $attr_params];
        }

        $filters = [
            'category_slug'  => empty($category_ids) ? $raw_category_slug : NULL,
            'category_ids'   => !empty($category_ids) ? $category_ids : NULL,
            'brand_slug'     => $this->input->get('brand'),
            'search'         => $this->input->get('q'),
            'min_price'      => $this->input->get('min_price'),
            'max_price'      => $this->input->get('max_price'),
            'sort'           => $this->input->get('sort') ?: 'best-selling',
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

        $categories = $this->category_model->get_all();
        $brands     = $this->brand_model->get_all();

        // Load all attributes and their values for the filter offcanvas
        $filter_attributes = $this->db->select('a.*')->from('attributes a')->order_by('a.id', 'ASC')->get()->result_array();
        foreach ($filter_attributes as &$fa) {
            $fa['values'] = $this->db->where('attribute_id', $fa['id'])->order_by('sort_order', 'ASC')->get('attribute_values')->result_array();
        }

        $page_heading = $selected_category ? $selected_category['name'] : 'Shop All Products';

        $data = [
            'title'             => $page_heading . ' - ' . $this->site_name,
            'active_page'       => 'shop',
            'products'          => $products,
            'total_products'    => $total_products,
            'categories'        => $categories,
            'brands'            => $brands,
            'filter_attributes' => $filter_attributes,
            'filters'           => $filters,
            'selected_category' => $selected_category,
            'breadcrumbs'       => $breadcrumbs,
            'top_subcategories' => $top_subcategories,
            'page_heading'      => $page_heading,
            'current_page'      => $page,
            'total_pages'       => $total_pages,
            'per_page'          => $per_page
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
