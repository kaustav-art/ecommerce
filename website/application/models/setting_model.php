<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setting_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $rows = $this->db->get('settings')->result_array();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }
        return $settings;
    }

    public function get($key, $default = NULL)
    {
        $row = $this->db->where('setting_key', $key)->get('settings')->row_array();
        return $row ? $row['setting_value'] : $default;
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
