<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_email($email)
    {
        return $this->db->where('email', $email)->get('users')->row_array();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get('users')->row_array();
    }

    public function register($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('users', $data);
    }

    public function get_addresses($user_id)
    {
        return $this->db->where('user_id', (int) $user_id)->get('user_addresses')->result_array();
    }

    public function get_default_address($user_id, $type = 'shipping')
    {
        return $this->db->where('user_id', (int) $user_id)
                        ->where('type', $type)
                        ->order_by('is_default', 'DESC')
                        ->get('user_addresses')
                        ->row_array();
    }

    public function save_address($data)
    {
        if (!empty($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            $this->db->where('id', $id)->update('user_addresses', $data);
            return $id;
        } else {
            $this->db->insert('user_addresses', $data);
            return $this->db->insert_id();
        }
    }

    public function delete_address($id, $user_id)
    {
        return $this->db->where('id', (int) $id)->where('user_id', (int) $user_id)->delete('user_addresses');
    }
}
