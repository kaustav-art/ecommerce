<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class role_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $roles = $this->db->order_by('id', 'ASC')->get('roles')->result_array();
        foreach ($roles as &$role) {
            $role['user_count'] = $this->db->where('role_id', $role['id'])->count_all_results('admins');
            $role['perm_count'] = $this->db->where('role_id', $role['id'])->count_all_results('role_permissions');
        }
        return $roles;
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get('roles')->row_array();
    }

    public function create($data)
    {
        $this->db->insert('roles', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int) $id)->update('roles', $data);
    }

    public function delete($id)
    {
        $role = $this->get_by_id($id);
        if ($role && $role['is_system'] == 1) {
            return false; // Cannot delete system role
        }
        return $this->db->where('id', (int) $id)->delete('roles');
    }

    public function get_all_permissions()
    {
        $rows = $this->db->order_by('module', 'ASC')->order_by('id', 'ASC')->get('permissions')->result_array();
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['module']][] = $row;
        }
        return $grouped;
    }

    public function get_role_permission_ids($role_id)
    {
        $rows = $this->db->select('permission_id')
                         ->where('role_id', (int) $role_id)
                         ->get('role_permissions')
                         ->result_array();
        return array_column($rows, 'permission_id');
    }

    public function get_role_permission_slugs($role_id)
    {
        $rows = $this->db->select('p.slug')
                         ->from('role_permissions rp')
                         ->join('permissions p', 'p.id = rp.permission_id')
                         ->where('rp.role_id', (int) $role_id)
                         ->get()
                         ->result_array();
        return array_column($rows, 'slug');
    }

    public function sync_permissions($role_id, array $permission_ids)
    {
        $this->db->where('role_id', (int) $role_id)->delete('role_permissions');
        if (!empty($permission_ids)) {
            $batch = [];
            foreach ($permission_ids as $pid) {
                $batch[] = [
                    'role_id'       => (int) $role_id,
                    'permission_id' => (int) $pid
                ];
            }
            $this->db->insert_batch('role_permissions', $batch);
        }
        return true;
    }
}
