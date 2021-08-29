<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher_model extends CI_Model
{
    public function joinTable()
    {
        $query = "SELECT `user`.*, `user_role`.`role`, `activated`.`active`
                    FROM `user` 
                    JOIN `user_role` ON `user`.`role_id` = `user_role`.`id`
                    JOIN `activated` ON `user`.`is_active` = `activated`.`id`
                    WHERE `user`.`role_id` != 1 AND `user`.`role_id` != 2
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinTableMoora()
    {
        $query = "SELECT `dss_moora_history`.*, `user`.`name`, `dss_alternative_individual`.`alternative`
                    FROM `dss_moora_history`
                    JOIN `user` ON `dss_moora_history`.`user_id` = `user`.`id`
                    JOIN `dss_alternative_individual` ON `dss_moora_history`.`code_alternative` = `dss_alternative_individual`.`code_alternative`
                    WHERE `dss_moora_history`.`user_id` != 1
        ";
        return $this->db->query($query)->result_array();
    }

    public function joinTableTopsis()
    {
        $query = "SELECT `dss_topsis_history`.*, `user`.`name`, `dss_alternative_individual`.`alternative`
                    FROM `dss_topsis_history`
                    JOIN `user` ON `dss_topsis_history`.`user_id` = `user`.`id`
                    JOIN `dss_alternative_individual` ON `dss_topsis_history`.`code_alternative` = `dss_alternative_individual`.`code_alternative`
                    WHERE `dss_topsis_history`.`user_id` != 1
        ";
        return $this->db->query($query)->result_array();
    }
}
