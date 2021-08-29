<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function joinTable()
    {
        $query = "SELECT `user`.*, `user_role`.`role`, `activated`.`active`
                    FROM `user` 
                    JOIN `user_role` ON `user`.`role_id` = `user_role`.`id`
                    JOIN `activated` ON `user`.`is_active` = `activated`.`id`
        ";
        return $this->db->query($query)->result_array();
    }
}
