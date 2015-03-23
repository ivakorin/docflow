<?
/*
 * Requests.php
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
class Requests extends CI_Controller {
    public function index(){
        $title['title'] = "Список внутренних заявок";
        $this->load->model('requests_model');
        $this->load->view('head',$title);
        $requests['requests']=$this->requests_model->get_internal_requests();
        $this->load->view('requests',$requests);
        $this->load->view('left_filed');
        $this->load->view('footer');
    }
    public function add_request() {
        $title['title'] = "Добавить заявку";
        $this->load->helper('form','url');
        $this->load->model('requests_model');
        $this->load->view('head',$title);
        $departments_list['departments_list'] = $this->requests_model->
                                                get_field('department_name',
                                                         'departments');
        $this->load->view('add_request', $departments_list);
        $this->load->view('left_filed');
        $this->load->view('footer');

    }
    function added (){

    }
}
?>
