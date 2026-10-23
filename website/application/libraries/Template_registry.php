<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template_registry
 * Central abstraction for managing and rendering the 3 SaaS storefront templates:
 * 1. fashion     (Template 1 - Existing Modave Fashion Storefront)
 * 2. electronics (Template 2 - Bazaro Electronics Storefront)
 * 3. grocery     (Template 3 - Bazaro Grocery Supermarket Storefront)
 */
class Template_registry {

    protected $CI;
    protected $templates = [];

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->register_defaults();
    }

    protected function register_defaults()
    {
        $this->templates = [
            'fashion' => [
                'key'         => 'fashion',
                'name'        => 'Fashion Store',
                'header_view' => 'layouts/header',
                'navbar_view' => 'layouts/navbar',
                'footer_view' => 'layouts/footer',
                'modals_view' => 'layouts/modals',
                'home_view'   => 'home/index',
                'assets_path' => 'assets/',
            ],
            'electronics' => [
                'key'         => 'electronics',
                'name'        => 'Electronics Store',
                'header_view' => 'templates/electronics/header',
                'navbar_view' => null, // integrated in header
                'footer_view' => 'templates/electronics/footer',
                'modals_view' => 'layouts/modals',
                'home_view'   => 'templates/electronics/home',
                'assets_path' => 'assets/templates/bazaro/',
            ],
            'grocery' => [
                'key'         => 'grocery',
                'name'        => 'Grocery Store',
                'header_view' => 'templates/grocery/header',
                'navbar_view' => null, // integrated in header
                'footer_view' => 'templates/grocery/footer',
                'modals_view' => 'layouts/modals',
                'home_view'   => 'templates/grocery/home',
                'assets_path' => 'assets/templates/bazaro/',
            ],
        ];
    }

    public function is_valid($key)
    {
        return isset($this->templates[strtolower((string)$key)]);
    }

    public function get($key)
    {
        $key = strtolower((string)$key);
        return $this->templates[$key] ?? $this->templates['fashion'];
    }

    public function get_all()
    {
        return $this->templates;
    }

    /**
     * Resolve view file for the active template.
     * For home/index, dispatches to the template's dedicated homepage view.
     * For inner views, checks if a template-specific override exists, otherwise reuses the core ecommerce view inside the template's layout.
     */
    public function resolve_view($template_key, $view)
    {
        $tpl = $this->get($template_key);
        if ($view === 'home/index') {
            return $tpl['home_view'];
        }
        if ($tpl['key'] !== 'fashion') {
            $override = 'templates/' . $tpl['key'] . '/' . $view;
            if (file_exists(APPPATH . 'views/' . $override . '.php')) {
                return $override;
            }
        }
        return $view;
    }

    public function render($template_key, $view, $data = [], $return = FALSE)
    {
        $tpl = $this->get($template_key);
        $resolved_view = $this->resolve_view($tpl['key'], $view);
        $is_bazaro_home = ($tpl['key'] !== 'fashion' && $view === 'home/index');

        $data['active_template']      = $tpl['key'];
        $data['active_template_meta'] = $tpl;
        $data['tpl_assets']           = base_url($tpl['assets_path']);

        if ($return) {
            $content = '';
            if (!empty($tpl['header_view'])) {
                $content .= $this->CI->load->view($tpl['header_view'], $data, TRUE);
            }
            if (!empty($tpl['navbar_view'])) {
                $content .= $this->CI->load->view($tpl['navbar_view'], $data, TRUE);
            }
            $content .= $this->CI->load->view($resolved_view, $data, TRUE);
            if (!empty($data['is_preview_mode'])) {
                $content .= $this->CI->load->view('layouts/demo_preview_bar', $data, TRUE);
            }
            if (!empty($tpl['footer_view'])) {
                $content .= $this->CI->load->view($tpl['footer_view'], $data, TRUE);
            }
            if (!empty($tpl['modals_view']) && !$is_bazaro_home) {
                $content .= $this->CI->load->view($tpl['modals_view'], $data, TRUE);
            }
            return $content;
        }

        if (!empty($tpl['header_view'])) {
            $this->CI->load->view($tpl['header_view'], $data);
        }
        if (!empty($tpl['navbar_view'])) {
            $this->CI->load->view($tpl['navbar_view'], $data);
        }
        $this->CI->load->view($resolved_view, $data);
        if (!empty($data['is_preview_mode'])) {
            $this->CI->load->view('layouts/demo_preview_bar', $data);
        }
        if (!empty($tpl['footer_view'])) {
            $this->CI->load->view($tpl['footer_view'], $data);
        }
        if (!empty($tpl['modals_view']) && !$is_bazaro_home) {
            $this->CI->load->view($tpl['modals_view'], $data);
        }
    }
}
