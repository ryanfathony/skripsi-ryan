<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topsis_model extends CI_Model
{
    public function getJoinStudent()
    {
        $this->db->select('dss_alternative_individual.code_alternative, dss_alternative_individual.alternative, dss_topsis_individual.score');
        $this->db->from('dss_topsis_individual');
        $this->db->join('dss_alternative_individual', 'dss_topsis_individual.code_alternative = dss_alternative_individual.code_alternative');
        $this->db->order_by('dss_topsis_individual.score', 'desc');
        return $this->db->get();
    }

    public function getJoinIpa()
    {
        $this->db->select('dss_alternative.nis, dss_alternative.name, dss_topsis_ipa.score');
        $this->db->from('dss_topsis_ipa');
        $this->db->join('dss_alternative', 'dss_topsis_ipa.nis = dss_alternative.nis');
        $this->db->order_by('dss_topsis_ipa.score', 'desc');
        return $this->db->get();
    }

    public function getJoinIps()
    {
        $this->db->select('dss_alternative.nis, dss_alternative.name, dss_topsis_ips.score');
        $this->db->from('dss_topsis_ips');
        $this->db->join('dss_alternative', 'dss_topsis_ips.nis = dss_alternative.nis');
        $this->db->order_by('dss_topsis_ips.score', 'desc');
        return $this->db->get();
    }

    public function getJoinBahasa()
    {
        $this->db->select('dss_alternative.nis, dss_alternative.name, dss_topsis_bahasa.score');
        $this->db->from('dss_topsis_bahasa');
        $this->db->join('dss_alternative', 'dss_topsis_bahasa.nis = dss_alternative.nis');
        $this->db->order_by('dss_topsis_bahasa.score', 'desc');
        return $this->db->get();
    }

    public function get($table, $where = array())
    {
        if (!empty($where) && is_array($where)) { //validasi ketika variabel $where tidak kosong dan berupa array
            foreach ($where as $column => $value) {
                $this->db->where($column, $value);
            }
        }
        return $this->db->get($table);
    }
}
