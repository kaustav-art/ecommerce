<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setting_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    protected function tid()
    {
        $ci =& get_instance();
        return isset($ci->tenant_id) ? (int) $ci->tenant_id : 1;
    }

    public function get_all()
    {
        $tid = $this->tid();
        $rows = $this->db->where('tenant_id', 1)->get('settings')->result_array();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }
        if ($tid !== 1) {
            $t_rows = $this->db->where('tenant_id', $tid)->get('settings')->result_array();
            foreach ($t_rows as $r) {
                $settings[$r['setting_key']] = $r['setting_value'];
            }
        }
        return $settings;
    }

    public function get_by_group($group)
    {
        $tid = $this->tid();
        $rows = $this->db->where('tenant_id', 1)->where('setting_group', $group)->get('settings')->result_array();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }
        if ($tid !== 1) {
            $t_rows = $this->db->where('tenant_id', $tid)->where('setting_group', $group)->get('settings')->result_array();
            foreach ($t_rows as $r) {
                $settings[$r['setting_key']] = $r['setting_value'];
            }
        }
        return $settings;
    }

    public function get($key, $default = NULL)
    {
        $tid = $this->tid();
        $row = $this->db->where('tenant_id', $tid)->where('setting_key', $key)->get('settings')->row_array();
        if (!$row && $tid !== 1) {
            $row = $this->db->where('tenant_id', 1)->where('setting_key', $key)->get('settings')->row_array();
        }
        return $row ? $row['setting_value'] : $default;
    }

    public function set($key, $value, $group = 'general')
    {
        $tid = $this->tid();
        $exists = $this->db->where('tenant_id', $tid)->where('setting_key', $key)->count_all_results('settings');
        if ($exists) {
            return $this->db->where('tenant_id', $tid)->where('setting_key', $key)->update('settings', ['setting_value' => $value]);
        } else {
            return $this->db->insert('settings', [
                'tenant_id'     => $tid,
                'setting_key'   => $key,
                'setting_value' => $value,
                'setting_group' => $group
            ]);
        }
    }

    public function get_payment_gateways()
    {
        $tid = $this->tid();
        $rows = $this->db->where('tenant_id', $tid)->get('payment_gateways')->result_array();
        if (empty($rows) && $tid !== 1) {
            // Auto-clone default gateway definitions for this tenant
            $defaults = $this->db->where('tenant_id', 1)->get('payment_gateways')->result_array();
            foreach ($defaults as $def) {
                unset($def['id']);
                $def['tenant_id'] = $tid;
                $this->db->insert('payment_gateways', $def);
            }
            $rows = $this->db->where('tenant_id', $tid)->get('payment_gateways')->result_array();
        }
        foreach ($rows as &$row) {
            $row['credentials_decoded'] = json_decode($row['credentials'], true) ?: [];
        }
        return $rows;
    }

    public function get_payment_gateway($code)
    {
        $this->get_payment_gateways(); // Ensure cloned if missing
        $row = $this->db->where('tenant_id', $this->tid())->where('gateway_code', $code)->get('payment_gateways')->row_array();
        if ($row) {
            $row['credentials_decoded'] = json_decode($row['credentials'], true) ?: [];
        }
        return $row;
    }

    public function update_payment_gateway($code, $is_active, $environment, array $credentials)
    {
        $this->get_payment_gateways();
        return $this->db->where('tenant_id', $this->tid())->where('gateway_code', $code)->update('payment_gateways', [
            'is_active'   => (int) $is_active,
            'environment' => $environment,
            'credentials' => json_encode($credentials)
        ]);
    }
}
