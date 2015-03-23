<?
/*
 * Users_model.php
 *
 * Copyright 2015 Ignat Vakorin <ignat@vakorin.net>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model{
    function get_users_total (){
        $query = $this->db->count_all_results('users');
        return $query;
    }
    function check_user ($data){
            $this->db->where($data);
            $check_name = $this->db->get('users');
            return $check_name ->data_seek();
    }
    function add_user($data){
        $query=$this->db->set($data)->insert('users');
        return $query;
    }
    function get_departments(){
        $this->db->select('department_name');
        $query = $this->db->get('departments');
        return $query->result_array();
    }

    function get_curator($data){
        $this->db->where('curator', $data);
        //$this->db->select('');
        $query = $this->db->get('contracts_journal');
        return $query->result_array();

    }
    function get_contract_number($data){
        $this->db->where($data);
        $query = $this->db->get('contracts_journal');
        return $query->result_array();
    }
    function get_agree_contract ($data){
        $this->db->where('member', $data);
        $this->db->where('status !=', 'interrupted');
        $this->db->where('voted', '0');
        $query = $this->db->get('contracts_negotiations');
        return $query->result_array();
    }
}


?>
