<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function joinTable()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`, `activated`.`active`
                    FROM `user_sub_menu` 
                    JOIN `user_menu` ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                    JOIN `activated` ON `user_sub_menu`.`is_active` = `activated`.`id`
        ";
        return $this->db->query($query)->result_array();
    }
}
