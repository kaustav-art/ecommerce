<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class banner_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_active_banners()
    {
        return $this->db->where('status', 'active')
                        ->order_by('sort_order', 'ASC')
                        ->order_by('id', 'DESC')
                        ->get('banners')
                        ->result_array();
    }
}
