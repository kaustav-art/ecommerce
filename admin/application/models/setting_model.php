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

    public function get_by_group($group)
    {
        $rows = $this->db->where('setting_group', $group)->get('settings')->result_array();
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

    public function set($key, $value, $group = 'general')
    {
        $exists = $this->db->where('setting_key', $key)->count_all_results('settings');
        if ($exists) {
            return $this->db->where('setting_key', $key)->update('settings', ['setting_value' => $value]);
        } else {
            return $this->db->insert('settings', [
                'setting_key'   => $key,
                'setting_value' => $value,
                'setting_group' => $group
            ]);
        }
    }

    public function get_payment_gateways()
    {
        $rows = $this->db->get('payment_gateways')->result_array();
        foreach ($rows as &$row) {
            $row['credentials_decoded'] = json_decode($row['credentials'], true) ?: [];
        }
        return $rows;
    }

    public function get_payment_gateway($code)
    {
        $row = $this->db->where('gateway_code', $code)->get('payment_gateways')->row_array();
        if ($row) {
            $row['credentials_decoded'] = json_decode($row['credentials'], true) ?: [];
        }
        return $row;
    }

    public function update_payment_gateway($code, $is_active, $environment, array $credentials)
    {
        return $this->db->where('gateway_code', $code)->update('payment_gateways', [
            'is_active'   => (int) $is_active,
            'environment' => $environment,
            'credentials' => json_encode($credentials)
        ]);
    }
}
