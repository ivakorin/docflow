<?
/*
 * Contracts_model.php
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
class Contracts_model extends CI_Model{
/*ДОБАВЛЕНИЕ ПРОЕКТА КОНТРАКТА*/
    // Получаем возможные литеры договоров из таблицы letters
    function get_letters () {
        $this->db->select('letter');
        $letters = $this->db->get('letters');
        return $letters -> result_array();
    }
    // Получаем возможные типы договоров из таблицы contracts_species
    function get_species () {
        $this->db->select('species');
        $species = $this->db->get('contracts_species');
        return $species -> result_array();
    }
    function get_contract_number(){
        $number = $this->db->count_all('contracts_journal');
         return $number;
    }
    function search_contractor($data){
        $this->db->like('name',$data);
        $this->db->select('name');
        $name = $this->db->get('contractors');
        return $name -> result();

    }
    function search_users ($data){
        $this->db->like('initials', $data);
        $this->db->select('initials');
        $query = $this->db->get('users');
        return $query->result_array();
    }
    function get_valutes (){
        $this->db->select('valute_name');
        $valute = $this->db->get('valute');
        return $valute -> result_array();
    }
    function purchase_types(){
        $this->db->select('type');
        $types = $this->db->get('purchase_types');
        return $types -> result_array();
    }
    function  purchase_methods() {
        $this->db->select('type');
        $types = $this->db->get('purchase_methods');
        return $types -> result_array();
    }
    function add_contract($data){
        $this->db->set($data)->insert('contracts_journal');
    }
// Ищем юристов среди пользователей
    function find_jurist (){
        $this->db->where('jurist !=', '0');
        $this->db->select ('email');
        $query = $this->db->get('users');
        return $query -> result_array();
    }

/*ДОБАВЛЕНИЕ КОНТРАГЕНТА*/

    // Получаем список возможных типов контрагента из таблице contractor_type
    function get_contractor_type(){
        $this->db->select('description, type');
        $contractor_type = $this->db->get('contractor_type');
        return $contractor_type -> result_array();
    }
    // Проверяем совпадение наименований контрагента в таблицах customers || suppliers
    // в зависимости от типа
    function check_name ($name){
            $this->db->where('name', $name);
            $this->db->select('name');
            $check_name = $this->db->get('contractors');
            return $check_name -> num_rows();
    }
    // Добавляем контрагента
    function add_contractor($data){
            $sql = $this->db->set($data)->insert('contractors');
            return $sql;
    }
/*КАРТОЧКА ДОГОВОРА*/
    function get_contract($data){
        $this->db->where('contract_number', $data);
        $query = $this->db->get('contracts_journal');
        return $query -> result_array();
    }
    function jurist ($data){
        $this->db->where('email', $data);
        $this->db->select ('jurist');
        $query = $this->db->get('users');
        return $query->result_array();
    }
    function get_curator($data){
        $this->db->where('email', $data);
        $this->db->select('initials, email');
        $query = $this->db->get('users');
        return $query->result_array();
    }
    function get_valute_desc ($data){
        $this->db->where ('valute_name', $data);
        $this->db->select('valute_description');
        $query = $this->db->get('valute');

        return $query -> result_array();
    }
    function get_files_list($data){
        $this->db->where($data);
        $this->db->order_by('link_timestamp', 'DESC');
        $query=$this->db->get('links_to_files');
        return $query->result_array();
    }
//Добавление файлов к договору
    function get_file_rows($file, $contract){
        $this->db->where('file_type',$file);
        $this->db->where('contract_number', $contract);
        $this->db->from('links_to_files');
        $query = $this->db->count_all_results();
        return $query;
    }
    function add_link_to_file($data){
        $query = $this->db->insert('links_to_files', $data);
        return $query;
    }
// Удаление файлов договора
    function delete_file($data){
        $query = $this->db->delete('links_to_files', $data);
        return $query;
    }
// ДОБАВЛЕНИЕ ЛИТЕРЫ ДОГОВОРА
    function add_letter ($number, $data){
        $this->db->where('contract_number', $number);
        $query = $this->db->update('contracts_journal', $data);
        return $query;

    }
/*ЖУРНАЛ ДОГОВОРОВ*/
    function get_all_contracts(){
        $query = $this->db->get('contracts_journal');
        return $query -> result_array();
    }
    function get_files_types (){
        $this->db->select('file_type');
        $valute = $this->db->get('contract_files_types');
        return $valute -> result_array();
    }
/*************************************************************************
 *                      СОГЛАСОВАНИЕ ДОГОВОРА
 *
 ************************************************************************/
 //Добавляем лист согласования
    function input_negotiation_data ($data){
        $query = $this->db->set($data)->insert('contracts_negotiations');
        return $query;
    }
// Меняем статус договора в таблице contracts_journal
    function update_contract_status($data, $number){
        $this->db->where('contract_number',$number);
        $query = $this->db->update('contracts_journal',$data);
        return $query;
    }

// ЛИСТ СОГЛАСОВАНИЯ
//Получаем литеру договора
    function get_letter($data){
        $this->db->where('contract_number', $data);
        $this->db->select('letter_type');
        $query = $this->db->get('contracts_journal');
        return $query->result_array();
    }
//Получаем номер ревизии договора
    function get_versions($data){
        $this->db->where('contract_number', $data);
        $this->db->select_max('revision');
        $query = $this->db->get('contracts_negotiations');
        return $query->result_array();
    }
//Получаем ссылку на файл с проектом договора
    function get_link_to_file ($data){
        $this->db->where('file_name', $data);
        $this->db->select('link_to_file');
        $query = $this->db->get('links_to_files');
        return $query->result_array();
    }

    function get_global_status($data){
        $this->db->where('contract_number', $data);
        $this->db->select('global_status');
        $query = $this->db->get('contracts_negotiations');
        return $query->result_array();

    }

// Лист согласования, все данные для последующей обработки
    function get_agree_list($data, $revision){
        $this->db->where('contract_number', $data);
        $this->db->where('revision', $revision);
        $this->db->select('contract_number, revision, member, note, status, global_status,file_name');
        $query = $this->db->get('contracts_negotiations');
        return $query->result_array();
    }
    function get_department ($data){
        $this->db->where('initials', $data);
        $this->db->select('department');
        $query = $this->db->get('users');
        return $query -> result_array();

    }
//AJAX запрос на прерывание согласования договора
    function break_agree($data){
        $this->db->where($data);
        //$status = ['status'=>'interrupted', 'global_status' => 'interrupted'];
        $status = ['global_status' => 'interrupted'];
        $query = $this->db->update('contracts_negotiations',$status);
        $this->db->where($data);
        $this->db->where('status', 'inprocess');
        $status = ['status' => 'interrupted'];
        $query = $this->db->update('contracts_negotiations',$status);
        $this->db->where('contract_number',$data['contract_number']);
        $journal_status = ['status'=>'draft'];
        $this->db->update('contracts_journal',$journal_status);
        return $query;

    }
    function all_negotiations($data, $revision){
        $this->db->where('contract_number', $data);
        $this->db->where('revision !=',$revision);
        $this->db->select('revision, global_status');
        $query = $this->db->get('contracts_negotiations');
        return $query->result_array();
    }
    function find_voted ($data){
        $this->db->where($data);
        $this->db->select('voted');
        $query = $this->db->get('contracts_negotiations');
        return $query -> result_array();
    }
    function update_negotiation($where, $update){
        $this->db->where($where);
        $query = $this->db->update('contracts_negotiations', $update);
        return $query;
    }
    function count_agree_total($where){
        $this->db->where($where);
        $query = $this->db->get('contracts_negotiations');
        return $query->result_array();
    }
    function upd_global_status($data, $update){
        $this->db->where ($data);
        $query = $this->db->update('contracts_negotiations', $update);
        return $query;
    }
// Информируем получаем email для информирования о начале согласования
    function get_email($data){
        $this->db->where('initials', $data);
        $this->db->select('email');
        $query = $this->db->get('users');
        foreach ($query->result_array() as $value){
            return $value['email'];
        }
    }

// Договора для юриста
    function jurist_new_contracts (){
        $this->db->where('letter_type', 'N/A');
        $query = $this->db->get('contracts_journal');
        return $query -> result_array();
    }
    function jurist_contracts ($data){
        $this->db->where('jurist', $data);
        $query = $this->db->get('contracts_journal');
        return $query -> result_array();
    }
}


?>
