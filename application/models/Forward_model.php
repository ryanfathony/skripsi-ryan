<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forward_model extends CI_Model
{
    public function listingOne($table, $field, $where)
    {
        $query = $this->db->select('*')
            ->from($table)
            ->where($field, $where)
            ->get();
        return $query->row();
    }
}
