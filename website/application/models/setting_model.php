<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setting_model extends CI_Model {

    private $settings_cache = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        if ($this->settings_cache !== null) {
            return $this->settings_cache;
        }
        $rows = $this->db->get('settings')->result_array();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }
        $this->settings_cache = $settings;
        return $settings;
    }

    public function refresh_cache()
    {
        $this->settings_cache = null;
        return $this->get_all();
    }

    public function get($key, $default = NULL)
    {
        if ($this->settings_cache === null) {
            $this->get_all();
        }
        return isset($this->settings_cache[$key]) ? $this->settings_cache[$key] : $default;
    }

    public function get_active_gateways()
    {
        $rows = $this->db->where('is_active', 1)->get('payment_gateways')->result_array();
        foreach ($rows as &$row) {
            $row['credentials'] = json_decode($row['credentials'], true) ?: [];
        }
        return $rows;
    }

    public function get_gateway($code)
    {
        $row = $this->db->where('gateway_code', $code)->get('payment_gateways')->row_array();
        if ($row) {
            $row['credentials'] = json_decode($row['credentials'], true) ?: [];
        }
        return $row;
    }
}
