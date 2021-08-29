<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Moora_model extends CI_Model
{
    public function joinTable()
    {
        $query = "SELECT `moora_criteria`.*, `attribute_type`.`attribute`
                    FROM `moora_criteria` 
                    JOIN `attribute_type` ON `moora_criteria`.`attribute_id` = `attribute_type`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinAssessment()
    {
        $query = "SELECT `dss_assessment`.*, `dss_alternative`.`name`,`dss_criteria_ipa`.`criteria`
        FROM `dss_assessment`
        JOIN `dss_alternative` ON `dss_assessment`.`nis` = `dss_alternative`.`nis`
        JOIN `dss_criteria_ipa` ON `dss_assessment`.`code_criteria` = `dss_criteria_ipa`.`code_criteria`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinAssessmentStudent()
    {
        $query = "SELECT `dss_assessment_individual`.*, `dss_alternative_individual`.`alternative`, `dss_criteria_individual`.`criteria`
        FROM `dss_assessment_individual`
        JOIN `dss_alternative_individual` ON `dss_assessment_individual`.`code_alternative` = `dss_alternative_individual`.`code_alternative`
        JOIN `dss_criteria_individual` ON `dss_assessment_individual`.`code_criteria` = `dss_criteria_individual`.`code_criteria`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getJoinStudent()
    {
        $this->db->select('dss_alternative_individual.code_alternative, dss_alternative_individual.alternative, dss_moora_individual.score');
        $this->db->from('dss_moora_individual');
        $this->db->join('dss_alternative_individual', 'dss_moora_individual.code_alternative = dss_alternative_individual.code_alternative');
        $this->db->order_by('dss_moora_individual.score', 'desc');
        return $this->db->get();
    }

    public function joinTableIPA()
    {
        $query = "SELECT `dss_criteria_ipa`.*, `attribute_type`.`attribute`
                    FROM `dss_criteria_ipa` 
                    JOIN `attribute_type` ON `dss_criteria_ipa`.`attribute_id` = `attribute_type`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinAssessmentIPA()
    {
        $query = "SELECT `dss_assessment_ipa`.*, `dss_alternative`.`name`,`dss_criteria_ipa`.`criteria`
        FROM `dss_assessment_ipa`
        JOIN `dss_alternative` ON `dss_assessment_ipa`.`nis` = `dss_alternative`.`nis`
        JOIN `dss_criteria_ipa` ON `dss_assessment_ipa`.`code_criteria` = `dss_criteria_ipa`.`code_criteria`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getJoinIpa()
    {
        $this->db->select('dss_alternative.nis, dss_alternative.name, dss_moora_ipa.score');
        $this->db->from('dss_moora_ipa');
        $this->db->join('dss_alternative', 'dss_moora_ipa.nis = dss_alternative.nis');
        $this->db->order_by('dss_moora_ipa.score', 'desc');
        return $this->db->get();
    }

    public function joinTableIPS()
    {
        $query = "SELECT `dss_criteria_ips`.*, `attribute_type`.`attribute`
                    FROM `dss_criteria_ips` 
                    JOIN `attribute_type` ON `dss_criteria_ips`.`attribute_id` = `attribute_type`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinAssessmentIPS()
    {
        $query = "SELECT `dss_assessment_ips`.*, `dss_alternative`.`name`,`dss_criteria_ips`.`criteria`
        FROM `dss_assessment_ips`
        JOIN `dss_alternative` ON `dss_assessment_ips`.`nis` = `dss_alternative`.`nis`
        JOIN `dss_criteria_ips` ON `dss_assessment_ips`.`code_criteria` = `dss_criteria_ips`.`code_criteria`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getJoinIps()
    {
        $this->db->select('dss_alternative.nis, dss_alternative.name, dss_moora_ips.score');
        $this->db->from('dss_moora_ips');
        $this->db->join('dss_alternative', 'dss_moora_ips.nis = dss_alternative.nis');
        $this->db->order_by('dss_moora_ips.score', 'desc');
        return $this->db->get();
    }

    public function joinTableBahasa()
    {
        $query = "SELECT `dss_criteria_bahasa`.*, `attribute_type`.`attribute`
                    FROM `dss_criteria_bahasa` 
                    JOIN `attribute_type` ON `dss_criteria_bahasa`.`attribute_id` = `attribute_type`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinAssessmentBahasa()
    {
        $query = "SELECT `dss_assessment_bahasa`.*, `dss_alternative`.`name`,`dss_criteria_bahasa`.`criteria`
        FROM `dss_assessment_bahasa`
        JOIN `dss_alternative` ON `dss_assessment_bahasa`.`nis` = `dss_alternative`.`nis`
        JOIN `dss_criteria_bahasa` ON `dss_assessment_bahasa`.`code_criteria` = `dss_criteria_bahasa`.`code_criteria`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinTableIndividual()
    {
        $query = "SELECT `dss_criteria_individual`.*, `attribute_type`.`attribute`
                    FROM `dss_criteria_individual` 
                    JOIN `attribute_type` ON `dss_criteria_individual`.`attribute_id` = `attribute_type`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getJoinBahasa()
    {
        $this->db->select('dss_alternative.nis, dss_alternative.name, dss_moora_bahasa.score');
        $this->db->from('dss_moora_bahasa');
        $this->db->join('dss_alternative', 'dss_moora_bahasa.nis = dss_alternative.nis');
        $this->db->order_by('dss_moora_bahasa.score', 'desc');
        return $this->db->get();
    }

    public function joinTable2()
    {
        $query = "SELECT `moora_sqrt`.*, `moora_criteria`.`criteria`
                    FROM `moora_sqrt` 
                    JOIN `moora_criteria` ON `moora_sqrt`.`id_criteria` = `moora_criteria`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinTable3()
    {
        $query = "SELECT `moora_normalisasi`.*, `moora_alternative`.`alternative`,`moora_criteria`.`criteria`
        FROM `moora_normalisasi`
        JOIN `moora_alternative` ON `moora_normalisasi`.`id_alternative` = `moora_alternative`.`id`
        JOIN `moora_criteria` ON `moora_normalisasi`.`id_criteria` = `moora_criteria`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinTable4()
    {
        $query = "SELECT `moora_optimasi`.*, `moora_alternative`.`alternative`,`moora_criteria`.`criteria`
        FROM `moora_optimasi`
        JOIN `moora_alternative` ON `moora_optimasi`.`id_alternative` = `moora_alternative`.`id`
        JOIN `moora_criteria` ON `moora_optimasi`.`id_criteria` = `moora_criteria`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinTable5()
    {
        $query = "SELECT `moora_minmax`.*, `moora_alternative`.`alternative`
                    FROM `moora_minmax` 
                    JOIN `moora_alternative` ON `moora_minmax`.`id_alternative` = `moora_alternative`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinTable6()
    {
        $query = "SELECT `moora_assessment`.*, `moora_alternative`.`alternative`,`moora_criteria`.`criteria`
        FROM `moora_assessment`
        JOIN `moora_alternative` ON `moora_assessment`.`alternative_id` = `moora_alternative`.`id`
        JOIN `moora_criteria` ON `moora_assessment`.`criteria_id` = `moora_criteria`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function get_result()
    {
        $this->db->select('moora_alternative.id, moora_alternative.alternative, moora_result.score');
        $this->db->from('moora_result');
        $this->db->join('moora_alternative', 'moora_result.alternative_id = moora_alternative.id');
        $this->db->order_by('moora_result.score', 'desc');
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
