<? defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Contents.php
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

class Contents extends CI_Controller {

    private function user($data){
        $this->load->model('contracts_model');
        $email = $data;
        $user = $this->contracts_model->get_curator($email);
        foreach ($user as $value){
            $result = $value['initials'];
        }
        return $result;
    }
    function help (){
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
            $title['user'] = $this->user($this->session->userdata('email'));
            $title['journal'] = 'Помощь';
            $title['main'] = 'Контент';
            $this->load->view('head', $title);
            $this->load->view('help');
            $this->load->view('footer');
        }
        else {
            header('Location: /');
        }

    }

}
?>
