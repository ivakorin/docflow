<?
/*
 * Users.php
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

class Users extends CI_Controller {
    private function jurist ($data){
        $result = $this->contracts_model->jurist($data);
            foreach ($result as $value){
                $result = $value['jurist'];
            }
        return $result;
    }
    private function user($data){
        $this->load->model('contracts_model');
        $email = $data;
        $user = $this->contracts_model->get_curator($email);
        foreach ($user as $value){
            $result = $value['initials'];
        }
        return $result;
    }

    public function index (){
        $this->load->library('session');
        $email = $this->session->userdata('email');
        if (empty($email)){
            $title['user']='';
        }
        else {
            $title['user']=$this->user($email);
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('users_model');
        $title['main'] = 'Пользователь';
        $title['journal'] = 'Страница входа';
        $title['login_header'] = 'Пожалуйста войдите';
        $title['login_error'] = '';
        $rules['email'] = "required";
        $rules['password'] = "required";
        $this->form_validation->set_rules($rules);
        $title['departments_list'] = $this->users_model->get_departments();
        $this->load->view('head', $title);
        $this->load->view('login');
        $this->load->view('footer');
    }

    function registration(){
        $this->load->model('users_model');
        $reg_data = $this->input->post(array('first_name','patronymic','second_name','phone','department', 'position','email'));
        $reg_data['password'] = md5(md5($this->input->post('password')));
        $reg_data['initials'] = $reg_data['second_name'].' '.mb_substr($reg_data['first_name'], 0, 1, 'UTF-8').'.'.mb_substr($reg_data['patronymic'], 0, 1, 'UTF-8').'.';
        if ($this->users_model->get_users_total() == '0'){
            $reg_data['administrator'] = 1;
        }
        else{
            $reg_data['administrator'] = 0;
        }
        //Переменная $email создана для унификации запросов на регистрацию и проверку пользователя в функции check_user()
        $email = ['email' => $reg_data['email']];
        $check_user = $this->users_model->check_user($email);
        if ($check_user != '0'){
            $error = ['error' => "Такой пользователь уже существует"];
            echo json_encode ($error, JSON_UNESCAPED_UNICODE);
        }
        else {
            $add_user = $this->users_model->add_user($reg_data);
            if ($add_user == '1'){
                $success = ['result'=>"Пользователь создан"];
                echo json_encode($success, JSON_UNESCAPED_UNICODE);
            }
            else {
                $error = ['fatal_error' => "Произошла ошибка, свяжитесь с администратором"];
                echo json_encode ($error, JSON_UNESCAPED_UNICODE);
            }
        }
    }

    function login(){
        $this->load->library('session');
        $this->load->model('users_model');
        $user_data['email'] = $this->input->post('email');
        $user_data['password'] = md5(md5($this->input->post('password')));
        $check_user = $this->users_model->check_user($user_data);
        print_r($check_user);
        if ($check_user == '1'){
            $authdata = array('email' => $user_data['email'],
                              'logged_in' => true);
            $this->session->set_userdata($authdata);
            header('Location: /index.php/Users/cabinet');
        }
        else{
        $this->index();
        }
    }

    function cabinet (){
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == true) {
            $this->load->helper('form', 'url');
            $email = $this->session->userdata('email');
            $this->load->model('users_model');
            $this->load->model('contracts_model');
            $user = $this->contracts_model->get_curator($email);
            foreach ($user as $value){
                $title['user'] = $value['initials'];
            }
            $separator = '-';
            $title['purchase_methods'] = $this->contracts_model->purchase_methods();
            $title['purchase_types'] = $this->contracts_model->purchase_types();
            $title['valute_list'] = $this->contracts_model->get_valutes();
            $title['species'] = $this->contracts_model->get_species();
            $title['letters_list'] = $this->contracts_model->get_letters();
            $title['date'] = date('d.m.Y');
            $title['contract_number'] = 1+$this->contracts_model->get_contract_number().$separator.date('y');
            $data = ['curator' => $email];
            $title['all_contracts'] = $this->users_model->get_contract_number($data);
            $title['curator_count'] = count($title['all_contracts']);
            $data = ['initiator' => $value['initials']];
            $title['initiator'] = $this->users_model->get_contract_number($data);
            $title['initiator_count'] = count($title['initiator']);
            $title['for_agree'] = $this->users_model->get_agree_contract ($title['user']);
            $title['for_agree_count'] = count($title['for_agree']);
            $title['jurist_new_contracts'] = $this->contracts_model->jurist_new_contracts();
            $title['jurist_new_contracts_count'] = count($title['jurist_new_contracts']);
            $title['jurist_contracts'] = $this->contracts_model->jurist_contracts($this->session->userdata('email'));
            $title['jurist_contracts_count'] = count($title['jurist_contracts']);
            $title['jurist'] = $this->jurist($this->session->userdata('email'));
            $title['journal']= $value['initials'];
            $title['main']='Личный кабинет';
            $title['curator']=$email;
            $title['add_contract'] = 'Добавить договор';
            $this->load->view('head', $title);
            $this->load->view('cabinet');
            $this->load->view('footer');
        }
        else {
            header('Location: /');
        }
    }
}
?>
