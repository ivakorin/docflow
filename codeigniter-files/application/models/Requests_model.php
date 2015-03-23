<?
/*
 * Requests_model.php
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
class Requests_model extends CI_Model{
    function get_internal_requests () {
        $list_of_request= $this->db->get('internal_requests');
        return $list_of_request -> result_array();
    }
    function add_new_request($reason, $department, $requested, $approved) {
        $date = date("d.m.Y");
        //$this->db->insert()
    }
    function get_field($field, $table) {
        $this->db->select($field);
        $departments_list = $this->db->get ($table);
        return $departments_list -> result_array();
    }
}
?>
