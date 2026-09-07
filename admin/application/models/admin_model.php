<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_email($email)
    {
        return $this->db->select('a.*, r.name as role_name, r.slug as role_slug')
                        ->from('admins a')
                        ->join('roles r', 'r.id = a.role_id', 'left')
                        ->where('a.email', $email)
                        ->get()
                        ->row_array();
    }

    public function get_by_id($id)
    {
        return $this->db->select('a.*, r.name as role_name, r.slug as role_slug')
                        ->from('admins a')
                        ->join('roles r', 'r.id = a.role_id', 'left')
                        ->where('a.id', (int) $id)
                        ->get()
                        ->row_array();
    }

    public function get_all()
    {
        return $this->db->select('a.*, r.name as role_name, r.slug as role_slug')
                        ->from('admins a')
                        ->join('roles r', 'r.id = a.role_id', 'left')
                        ->order_by('a.id', 'ASC')
                        ->get()
                        ->result_array();
    }

    public function create($data)
    {
        $this->db->insert('admins', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('admins', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int) $id)->delete('admins');
    }

    public function update_last_login($id)
    {
        $this->db->where('id', (int) $id)->update('admins', ['last_login' => date('Y-m-d H:i:s')]);
    }
}
