<?
/*
 * Contracts.php
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
class Contracts extends CI_Controller {

    private function jurist_email (){
        $result = $this->contracts_model->find_jurist();
        foreach ($result as $value){
            $result = $value['email'];
        }
        return $result;
    }

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

/*************************************************************************
 *                      ЖУРНАЛ ДОГОВОРОВ
 *
 ************************************************************************/

    public function index(){
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
//Загружаем модель договоров для создания запросов к БД
            $this->load->model('contracts_model');
// Получаем сведения о кураторе договора, данные берутся из ссессии активного пользователя
            //$title['curator'] = $this->session->userdata('email');
            $title['user'] = $this->user($this->session->userdata('email'));
////Разделитель для договора
            //$separator = '-';
//// Дата договора для регистрации в журнале договоров
            //$title['date'] = date('d.m.Y');
//Задаём переменные для отображения в виде (view)
            $title['jurist'] = $this->jurist($this->session->userdata('email'));
            $title['main'] = 'Контракты';
            $title['journal'] = 'Журнал договоров';
            $title['add_contractor'] = 'Добавить контрагента';
            $title['add_contract'] = 'Добавить договор';
            $title['contracts_list'] = 'Договоры';
////Получаем список литер договора для создания карточки договора
            //$title['letters_list'] = $this->contracts_model->get_letters();
////Получаем список видов договоров для создания карточки договора
            //$title['species'] = $this->contracts_model->get_species();
//// Создаём предворительный № договора, при отправке запроса на добавление договора номер может изменится, если был добавлен договор другим пользователем для создания карточки договора
            //$title['contract_number'] = 1+$this->contracts_model->get_contract_number().$separator.date('y');
////Полуаем список валют для создания карточки договора
            //$title['valute_list'] = $this->contracts_model->get_valutes();
//// Получаем виды закупки для создания карточки договора
            //$title['purchase_types'] = $this->contracts_model->purchase_types();
////Получаем методы закупки для создания карточки договора
            //$title['purchase_methods'] = $this->contracts_model->purchase_methods();
//// Получаем все договоры для создания журнала договоров
            $title['all_contracts'] = $this->contracts_model->get_all_contracts();
////Загружаем библиотеку фреймворка, для работы с формами
            $this->load->helper('form', 'url');
//// Загружаем виды (views)
            $this->load->view('head',$title);
            $this->load->view('contracts');
            $this->load->view('footer');
        }
        else{
            header('Location: /');
        }

    }
/*************************************************************************
 *                      Добавляем карточку контракта
 *
 ************************************************************************/
    public function add_contract () {
// Загружаем модель для работы с БД
        $this->load->model('contracts_model');
//Загружаем сепаратор для создания разделителя в номере договоров
        $separator = '-';
// Преобразуем в массив данные формы полученые через ajax
        $contract_data = [];
        parse_str($this->input->post('text'), $contract_data);

//Получаем дату договора у контрагена, конвертируем в UNIX формат, для более удобной работы в дальнейшем
        $contract_data['incoming_contract_date'] = strtotime($contract_data['incoming_contract_date']);
//Задаём дату контракта согласно времени создания карточки контракта
        $contract_data['incoming_date'] = time();
// Получаем срок действия контракта, конвертируем в UNIX формат
        $contract_data['validity'] = strtotime($contract_data['validity']);
        //Получаем актуальный номер контракта для внесения в базу, так как за время правки, кто-то мог уже добавить запись в базу данных, кроме того.
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Необходимо доделать сброс номера договора, если изменился год.
        $contract_data['contract_number'] = 1+$this->contracts_model->get_contract_number().$separator.date('y');
        // По умолчанию присваеваем всем договорам статус проект
        $contract_data['status'] = 'draft';
        // Меняем запятую на точку в десятичных у стоимости контракта, для внесения в базу данных
        $contract_data['contract_cost'] = str_replace(',','.', $contract_data['contract_cost']);
// Проверяем существует ли контрагент, если нет, возвращаем с ошибкой
        $result = $this->contracts_model->check_name($contract_data['contractor_name']);
        if ($result != '1'){
            $json_array = ['error' => 'Указан не существующий контрагент, введите корректное имя'];
            echo json_encode($json_array, JSON_UNESCAPED_UNICODE);
            return;
        }
// Если совпадений нет, записываем в БД и сообщаем пользователю номер контракта
        else{
            if (empty($contract_data['letter_type'])){
                $contract_data['letter_type'] = 'N/A';
            }
            $this->contracts_model->add_contract($contract_data);
            $json_array =  ['result' => "Контракт c номером ".$contract_data['contract_number'].'/'.$contract_data['letter_type']." сохранён, не забудьте указать номер на договоре", 'link' => $contract_data['contract_number']];
            echo json_encode($json_array, JSON_UNESCAPED_UNICODE);
        }
// Сохраняем файл
// Конфигурируем библиотеку file_upload
// Путь хранения файлов
        $config['upload_path'] = './upload/';
//Разрешённые типы файлов
        $config['allowed_types'] = 'doc|docx|pdf';
// Максимально допустимый размер файла
        $config['max_size'] = '4608';
// Получаем тип файла, для записи в БД
        $document_type = $this->input->post('file_type');
// Получаем номер договора, для создания ключа в таблице с типами файлов
        $contract_number = $contract_data['contract_number'];
// 0 - Проект договора, все документы для этого типа переименовываются в Проект договора с "контролем версий"
        $version = $this->contracts_model->get_file_rows($document_type, $contract_number);
        if ($version == '0'){
            $version = 1;
            $insert['file_version'] = $version;
            $config['file_name'] = 'Проект договора_№'.$contract_number.'_версия 1';
        }
        else{
            //$version = $this->contracts_model->get_file_rows($document_type, $contract_number);
            $version++;
            $insert['file_version'] = $version;
            $config['file_name'] = 'Проект договора_№'.$contract_number.'_версия_'.$version;
        }
// Загружаем библиотеку для загрузки файлов
        $this->load->library('upload', $config);
// Если с данными что-то не в порядке, генерируем информацию об ошибке используя стандартный набор информации от библиотеки
        if ( ! $this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error,JSON_UNESCAPED_UNICODE);
        }
// Если всё хорошо, то записываем данные в таблицу links_to_files
        else{
            $data = array('upload_data' => $this->upload->data());
// Получаем имя файла у пользователя
            $link_to_file = $config['upload_path'].$this->upload->data('file_name');
// Удаляем точку перед директроией храниния файлов, для более удобного запроса ссылки в БД в дальнейшем
            $insert['link_to_file'] =str_replace('./','/',$link_to_file);
// Присваиваем номер контракта
            $insert['contract_number'] = $contract_number;
// Указываем тип документа
            $insert['file_type'] = $document_type;
// Указываем имя файла
            $insert['file_name'] = $this->upload->data('file_name');
// Выполняем запись информации в БД и сообщаем пользователю о результатах
            $result = $this->contracts_model->add_link_to_file($insert);
            //echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
// Посылаем уведомление Юристу, о том, что поступил новый договор
        $user_email = $this->contracts_model->find_jurist();
        foreach ($user_email as $value){
            $user_email = $value['email'];
        }
        $this->load->helper('url');
        $message = 'В базу был добавлен новый договор <br> Для согласования перейдите по ссылке:'
                    .site_url('Contracts/contract_card/'.$contract_number);
        $this->load->library('email');
        $config['protocol'] = 'mail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['newline'] = '\r\n';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('contracts@pskovavia.ru', 'Договора Псковавиа');
        $this->email->subject('В базу был добавлен новый договор');
        $this->email->message($message);
        $this->email->to($user_email);
        $this->email->send();


    }
// Данная функция используется ТОЛЬКО для поиска контрагентов в базе по AJAX запросу со страницы contracts.php
    public function search_contractor(){
        $this->load->model('contracts_model');
        $name = $this->contracts_model->search_contractor($this->input->post('name'));
        echo json_encode($name, JSON_UNESCAPED_UNICODE);
    }
// Данная функция используется ТОЛЬКО для поиска сотрудников в базе по AJAX запросу со страниц contracts.php и contract_card.php
    public function search_users(){
        $this->load->model('contracts_model');
        $name = $this->contracts_model->search_users($this->input->post('name'));
        echo json_encode($name, JSON_UNESCAPED_UNICODE);
    }
/*************************************************************************
 *                      ДОБАВЛЯЕМ КОНТРАГЕНТА
 *
 ************************************************************************/
    public function add_contractor() {
// Проверяем сессию пользователя
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
        //  Добавляем контрагента, для последующей работы с ним
            $this->load->model('contracts_model');
            $title['user'] = $this->user($this->session->userdata('email'));
        // Собираем в массив и передаём заголовки страниц отображаемые у клиента
            $title['main'] = 'Контракты';
            $title['journal'] = 'Добавить контрагента';
        // Формируем из таблицы список возможных контрагентов (Заказчик, Постващик и тп.)
            $title['contractor_type'] = $this->contracts_model->get_contractor_type();
        // Загружаем form helper из ядра CI и страницы.
            $this->load->helper('form', 'url');
            $this->load->view('head',$title);
            $this->load->view('add_contractor');
            $this->load->view('footer');
        }
        else{
            header('Location: /');
        }


    }
    function added(){
// Проверяем сессию
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
        //   Получаем данные из формы, собираем их в массив, для последующей передачи модели, для внесения записи
        //   в таблицу.
            $contractor_data = $this->input->post(array('area','building','city',
                                'contact_person_name', 'contact_person_patronymic',
                                'contact_person_phone','contact_person_surname',
                                'email','phone','post_code','region',
                                'street','web_site', 'type', 'name'
                                ), TRUE);
// Вычищаем массив от кавычек
            $contractor_data = str_replace('"', '', $contractor_data);
            $contractor_data = str_replace('&quot', '', $contractor_data);
            $contractor_data = str_replace('«', '', $contractor_data);
            $contractor_data = str_replace('»', '', $contractor_data);
        //  Загружаем модель
            $this->load->model('contracts_model');
        //  Проверяем наличие записей в таблицах customers или supplires в зависимости от типа (type) контрагента
        //  также передаём имя (name) для проверки
            $result = $this->contracts_model->check_name($contractor_data['name']);
        //  Если количество совпадений равно "0", то вызываем в модели функцию записи в таблицу в противном случае
        //  сообщаем пользователю о том, что такой контрагент уже существует или же введены недопустимые параметры.
            if ($result == '0'){
                $sql = $this->contracts_model->add_contractor($contractor_data);
                $success=['success' => 'Контрагент '.$contractor_data['name'].' успешно добавлен'];
                echo json_encode($success, JSON_UNESCAPED_UNICODE);
            }
            else {
                $error = ['error' => 'Контрагент с именем '.$contractor_data['name'].' уже существует'];
                echo json_encode($error, JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            header('Location: /');
        }
    }
/*************************************************************************
 *                     КАРТОЧКА ДОГОВОРА
 *
 ************************************************************************/
// $number указывает на номер договора
    public function contract_card($number){
        if (!isset($number)){
                show_404();
            }
//Проверяем сессию пользователя
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
 // Загружаем библиотеку для работы с формами
            $this->load->helper('form', 'url');
// Загружаем модель для работы с базой данных
            $this->load->model('contracts_model');
            $title['user'] = $this->user($this->session->userdata('email'));
//Получаем всю информацию по номеру договора из таблицы contract_journal
            $data = $this->contracts_model->get_contract($number);
            if ($data == NULL){
                show_404();
            }
// Рпзбираем всю информацию через цикл
            foreach ($data as $value){
                $value;
            }
// Получаем информацию о кураторе договора
            $curator = $this->contracts_model->get_curator($value['curator']);
// Разбираем информацию через цикл
            foreach ($curator as $cur){
                $cur;
            }
// Получаем подробное описание валюты путём обработки записи из contracts_journal и поиска соответствия в таблиц valute
            $val = $this->contracts_model->get_valute_desc($value['valute']);
            foreach ($val as $v_value){
                $v_value;
            }
// Загаловки страницы
// Если пользователь является юристом, даём ему более широкие права доступа
            $title['jt'] = $this->jurist($this->session->userdata('email'));
            $title['letters_list'] = $this->contracts_model->get_letters();
            $title['main'] ='Контракты';
            $title['journal'] = 'Карточка договора';
            $title['user_email'] = $this->session->userdata('email');
// Получаем всю информацию о документах договора
            $title['files_types'] = $this->contracts_model->get_files_types();
            $files_list['contract_number'] = $number;
// Разбираем массив для полседующей генерации в виде различных данных, для разных типов документов
            for ($i='0'; $i<='4';){
                $files_list['file_type'] =$i;
                $title['files_list'.$i]=$this->contracts_model->get_files_list($files_list);
                $i++;
            }
            $all_lists = $this->contracts_model->all_negotiations($number, '0');
// Убираем все дублтрующиеся значения массива
            $all_lists = array_map("unserialize",array_unique(array_map("serialize",$all_lists)));
// Заново выставляем ключи массива, дабы избежать ошибок в работе цикла for в agree_list.php
            $title['all_lists'] = array_values($all_lists);
// Объеденяем массивы для передачи в вид
            $title = array_merge($title, $value, $v_value, $cur);
            $this->load->view('head',$title);
            $this->load->view('contract_card');
            $this->load->view('footer');
        }
        else{
            header('Location: /');
        }
    }
//ДОБАВЛЕНИЕ ЛИТЕРЫ К ДОГОВОРУ ЕСЛИ ОНА НЕ УСТАНОВЛЕНА
    function add_letter(){
        $this->load->model('contracts_model');
        $data = ['letter_type' => $this->input->post('letter'), 'jurist' => $this->input->post('jurist') ];
        $result = $this->contracts_model->add_letter($this->input->post('contract_number'), $data);
        if ($result == '1'){
            $success = ['success' => 'Литера успешно добавлена'];
            echo json_encode ($success, JSON_UNESCAPED_UNICODE);
        }
        else {
            $error = ['error' => 'Что-то пошло не так, свяжитесь с администратором'];
            echo json_encode ($error, JSON_UNESCAPED_UNICODE);
        }

    }

//ДОБАВЛЕНИЕ ФАЙЛОВ К ДОГОВОРУ
    function add_file(){
// Загружаем модель для запросов к БД
        $this->load->model('contracts_model');
// Конфигурируем библиотеку file_upload
// Путь хранения файлов
        $config['upload_path'] = './upload/';
//Разрешённые типы файлов
        $config['allowed_types'] = 'doc|docx|pdf';
// Максимально допустимый размер файла
        $config['max_size'] = '4608';
// Получаем тип файла, для записи в БД
        $document_type = $this->input->post('file_type');
// Получаем номер договора, для создания ключа в таблице с типами файлов
        $contract_number = $this->input->post('contract_number');
// 0 - Проект договора, все документы для этого типа переименовываются в Проект договора с "контролем версий"
        if ($document_type == '0'){
            $version = $this->contracts_model->get_file_rows($document_type, $contract_number);
            if ($version == '0'){
                $version = 1;
                $insert['file_version'] = $version;
                $config['file_name'] = 'Проект договора_№'.$contract_number.'_версия 1';
            }
            else{
                $version = $this->contracts_model->get_file_rows($document_type, $contract_number);
                $version++;
                $insert['file_version'] = $version;
                $config['file_name'] = 'Проект договора_№'.$contract_number.'_версия_'.$version;
            }
        }
        else {
        }
// Загружаем библиотеку для загрузки файлов
        $this->load->library('upload', $config);
// Если с данными что-то не в порядке, генерируем информацию об ошибке используя стандартный набор информации от библиотеки
        if ( ! $this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error,JSON_UNESCAPED_UNICODE);
        }
// Если всё хорошо, то записываем данные в таблицу links_to_files
        else{
            $data = array('upload_data' => $this->upload->data());
// Получаем имя файла у пользователя
            $link_to_file = $config['upload_path'].$this->upload->data('file_name');
// Удаляем точку перед директроией храниния файлов, для более удобного запроса ссылки в БД в дальнейшем
            $insert['link_to_file'] =str_replace('./','/',$link_to_file);
// Присваиваем номер контракта
            $insert['contract_number'] = $contract_number;
// Указываем тип документа
            $insert['file_type'] = $document_type;
// Указываем имя файла
            $insert['file_name'] = $this->upload->data('file_name');
// Выполняем запись информации в БД и сообщаем пользователю о результатах
            $result = $this->contracts_model->add_link_to_file($insert);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }
// Удаление файлов из договора
    function delete_file(){
// Загружаем моделть для создания запросов к БД
        $this->load->model('contracts_model');
// Получаем имя файла для удаления
        $file_name['file_name'] = $this->input->post('fname');
// Если имя файла не указано возвращаем информацию пользователю
// Необходимо ДОРАБОТАТЬ
        if (empty($file_name['file_name'])){
            return 'query was empty';
        }
        else {
// Удаляем все записи для этого файла из таблицы
        $delete_db_link = $this->contracts_model->delete_file($file_name);
// Удаляем файл с диска
        $del_file = unlink('upload/'.$file_name['file_name']);
// Сообщаем пользователю результат
        echo $delete_db_link;
        echo $del_file;
        }

    }
// Устанавливаем статус договора как подписаный
    function contract_signed (){
        $this->load->model('contracts_model');
        $contract_number = $this->input->post('contract_number');
        $data = ['status' => $this->input->post('status')];
        $result = $this->contracts_model->update_contract_status($data,$contract_number);
        if ($result == '1'){
             $this->load->helper('url');
            $message = 'Договор № '.$contract_number.' подписан.<br> Вы можете скачать подписанную копию договора перейдя по ссылке:'
                        .site_url('Contracts/contract_card/'.$contract_number);
            $this->load->library('email');
            $config['protocol'] = 'mail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['newline'] = '\r\n';
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from('contracts@pskovavia.ru', 'Договора Псковавиа');
            $this->email->subject('Договор № '.$contract_number.' подписан');
            $this->email->message($message);
            $this->email->to($this->input->post('curator_email'));
        $this->email->send();
            $success = ['success' => 'Ok'];
            echo json_encode ($success, JSON_UNESCAPED_UNICODE);
        }
        else {
            $error = ['error' => 'error'];
            echo json_encode ($error, JSON_UNESCAPED_UNICODE);
        }
    }
/*************************************************************************
 *                      СОГЛАСОВАНИЕ ДОГОВОРА
 *
 ************************************************************************/
    function push_negotiation_data(){
// Загружаем модель для последующей работ с БД
        $this->load->model('contracts_model');
// Получаем массив с номер договора, файлом для согласования и список согласующих лиц
        $data = $this->input->post();
// Убираем из массива все пустые значения если пристутствуют
        $clean_data = array_filter  ($data, function($element) {
                                        return !empty($element);
                                    });
        $clean_data = array_diff($data, array(''));
//Получаем номер последней ревизии листа согласования
        $list_number = $this->contracts_model->get_versions($clean_data ['contract_number']);
        foreach ($list_number as $value){
            $list_number = $value['revision'];
        }
// Если листов согласования ещё не было, создаём лист №1, если было, то к максимальному номеру ревизии добавляем 1
        if ($list_number == NULL){
            $insert_data ['revision'] = 1;
        }
        else {
            $insert_data ['revision'] = $list_number+1;
        }
//Считаем длину массива, -2 сделано для того, чтобы отбросить наименование файла и номер контракта
        $data_count = count($clean_data)-2;
// Узнаём общий статус согласования догвора, если предыдущее согласование не завершено, сообщаем пользователю о невозможности начать согласование, не завершив предыдущее
        $global_status = $this->contracts_model->get_global_status($clean_data['contract_number']);
        foreach ($global_status as $value){
            $global_status = $value['global_status'];
        }
        if ($global_status == 'inprocess'){
            $error = ['error' => 'Предыдущее согласование ещё не окончено'];
            echo json_encode ($error, JSON_UNESCAPED_UNICODE);
        }
// Если согласовании нет, обходим массив по количеству участников, для каждого создаём отдельную запись в таблице
        else {
// Email создаём тело письма
            $this->load->helper('url');
            $message = 'Начат процесс согласования Договора № '.$clean_data ['contract_number'].'<br>Для согласования перейдите по ссылке: '
            .site_url('Contracts/member_agree/'.$clean_data ['contract_number'].'/'.$insert_data ['revision']);
// Загружаем и конфигурируем модуль отправки электронной почты
            $this->load->library('email');
            $config['protocol'] = 'mail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['newline'] = '\r\n';
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from('contracts@pskovavia.ru', 'Договора Псковавиа');
            $this->email->subject('Начат процесс согласования договора №'.$clean_data ['contract_number']);
            $this->email->message($message);
            for ($i = 0; $i<$data_count;){
                $insert_data ['file_name'] = $clean_data['file_name'];
                $insert_data ['member'] = $clean_data['member-'.$i];
                $insert_data ['status'] = 'inprocess';
                $insert_data ['contract_number'] = $clean_data['contract_number'];
                $insert_data ['global_status'] = 'inprocess';
                $insert_data ['begin_time_stamp'] = time();
                $this->contracts_model->input_negotiation_data($insert_data);
// Информируем о начале согласования по почте
                $user_email = $this->contracts_model->get_email($clean_data['member-'.$i]);
                $this->email->to($user_email);
                $this->email->send();
                $i++;
            }
//Меняем статус договора в таблице contracts_journal, сообщаем пользователю о начале согласования;
            $upd_data['status'] = 'inprocess';
            $this->contracts_model->update_contract_status($upd_data, $clean_data['contract_number']);
            $success = ['result'=>'Согласование начато', 'revision'=>$insert_data ['revision']];
            echo json_encode($success, JSON_UNESCAPED_UNICODE);
        }
    }
/*          ЛИСТ СОГЛАСОВАНИЯ               */
    function agree_list ($number, $revision){
        if (empty($revision)){
            show_404('', 'FALSE');
        }
// Получаем статус сессии пользователя
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
//Загружаем модель для работы с БД
            $this->load->model('contracts_model');
//Передаём ревизию листа согласования
            $title ['revision']=$revision;
            $letter = $this->contracts_model->get_letter($number);
            foreach ($letter as $value){
                $letter = $value['letter_type'];
            }
            $list_data = $this->contracts_model->get_agree_list($number, $revision);
            if ($list_data == NULL){
               show_404();
            }
            $title['global_status'] = $list_data[0]['global_status'];
            $count_arr = count($list_data);
            $title['members'] = [];
            for ($i=0; $i<$count_arr; $i++){
                $title['members'][$i]['member']=$list_data[$i]['member'];
                $title['members'][$i]['status']=$list_data[$i]['status'];
                $title['members'][$i]['note']=$list_data[$i]['note'];
            }
            foreach ($list_data as $list_data){
                $list_data;
            }
            $file_name = $this->contracts_model->get_link_to_file ($list_data['file_name']);
            $title['file_name'] = $list_data['file_name'];
            foreach ($file_name as $fvalue){
                $lf['link_to_file'] = $fvalue['link_to_file'];
            }
            $contract_data = $this->contracts_model->get_contract($number);
            // Рпзбираем всю информацию через цикл
            foreach ($contract_data as $value){
                $value;
            }
            // Получаем информацию о кураторе договора
            $curator = $this->contracts_model->get_curator($value['curator']);
            // Разбираем информацию через цикл
            foreach ($curator as $cur){
                $cur;
            }
            $val = $this->contracts_model->get_valute_desc($value['valute']);
            foreach ($val as $v_value){
                $v_value;
            }
            $title['department'] = $this->contracts_model->get_department($value['initiator']);
            foreach ($title['department'] as $dvalue){
                $title['department'] = $dvalue['department'];
            }
            $all_lists = $this->contracts_model->all_negotiations($number, $revision);
// Убираем все дублтрующиеся значения массива
            $all_lists = array_map("unserialize",array_unique(array_map("serialize",$all_lists)));
// Заново выставляем ключи массива, дабы избежать ошибок в работе цикла for в agree_list.php
            $title['all_lists'] = array_values($all_lists);
            // Email текущего пользователя
            $title['uemail'] = $this->session->userdata('email');
            $title['user'] = $this->user($this->session->userdata('email'));
            $title['journal']= 'Лист согласования № ';
            $title['main']='Контракты';
            $title['jt'] = $this->jurist($this->session->userdata('email'));
            $title ['number']=$number;
            $title ['letter']=$letter;
            $data = array_merge($title, $cur, $value,$v_value, $lf);
            $this->load->view('head',$data);
            $this->load->view('agree_list');
            $this->load->view('footer');

        }
        else{
            header('Location: /');
        }
    }
// Используется только для прерывания согласования!
    function break_agree(){
        $this->load->model('contracts_model');
        $data = $this->input->post();
        $update = $this->contracts_model->break_agree($data);
    }
// СОГЛАСОВАНИЕ ДОГОВОРА ПОЛЬЗОВАТЕЛЕМ
    function member_agree ($number, $revision){
        if (empty($revision)){
            show_404('', 'FALSE');
        }
// Получаем статус сессии пользователя
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
//Загружаем модель для работы с БД
            $this->load->model('contracts_model');
            $title['user'] = $this->user($this->session->userdata('email'));
//Передаём ревизию листа согласования
            $title ['revision']=$revision;
            $letter = $this->contracts_model->get_letter($number);
            foreach ($letter as $value){
                $letter = $value['letter_type'];
            }
            $list_data = $this->contracts_model->get_agree_list($number, $revision);
            if ($list_data == NULL){
               show_404();
            }
            $title['global_status'] = $list_data[0]['global_status'];
            $user = $this->contracts_model->get_curator($this->session->userdata('email'));
            foreach ($user as $uvalue){
                $title['active_user'] = $uvalue['initials'];
            }
            // Убираем все дублтрующиеся значения массива
            $list_data = array_map("unserialize",array_unique(array_map("serialize",$list_data)));
// Заново выставляем ключи массива, дабы избежать ошибок в работе цикла for в agree_list.php
            $list_data = array_values($list_data);
            $found = 0;
            $list_datal = count($list_data);
            for ($i=0; $i<$list_datal; $i++){
                if (in_array( $title['active_user'], $list_data[$i] )){
                $found = 1;
                }
            }
            $voted_array = ['contract_number' => $number, 'revision' => $revision, 'member' =>$title['active_user']];
            $voted = $this->contracts_model->find_voted($voted_array);
// Убираем все дублтрующиеся значения массива
            $voted = array_map("unserialize",array_unique(array_map("serialize",$voted)));
// Заново выставляем ключи массива, дабы избежать ошибок в работе цикла for в agree_list.php
            $voted = array_values($voted);
            foreach ($voted as $vvalue){
                $title['voted'] = $vvalue['voted'];
            }
            $count_arr = count($list_data);
            foreach ($list_data as $list_data){
                $list_data;
            }
            $file_name = $this->contracts_model->get_link_to_file ($list_data['file_name']);
            $title['file_name'] = $list_data['file_name'];
            foreach ($file_name as $fvalue){
                $lf['link_to_file'] = $fvalue['link_to_file'];
            }
            $contract_data = $this->contracts_model->get_contract($number);
            // Рпзбираем всю информацию через цикл
            foreach ($contract_data as $value){
                $value;
            }
            // Получаем информацию о кураторе договора
            $curator = $this->contracts_model->get_curator($value['curator']);
            // Разбираем информацию через цикл
            foreach ($curator as $cur){
                $cur;
            }
            $val = $this->contracts_model->get_valute_desc($value['valute']);
            foreach ($val as $v_value){
                $v_value;
            }
            $title['department'] = $this->contracts_model->get_department($value['initiator']);
            foreach ($title['department'] as $dvalue){
                $title['department'] = $dvalue['department'];
            }
            $all_lists = $this->contracts_model->all_negotiations($number, $revision);
// Убираем все дублтрующиеся значения массива
            $all_lists = array_map("unserialize",array_unique(array_map("serialize",$all_lists)));
// Заново выставляем ключи массива, дабы избежать ошибок в работе цикла for в agree_list.php
            $title['all_lists'] = array_values($all_lists);
            // Email текущего пользователя
            $title['journal']= 'Лист согласования № ';
            $title['main']='Контракты';
            $title['user_permission'] = $found;
            $title ['number']=$number;
            $title ['letter']=$letter;
            $data = array_merge($title, $cur, $value,$v_value, $lf);
            $this->load->view('head',$data);
            $this->load->view('member_agree');
            $this->load->view('footer');

        }
        else{
            header('Location: /');
        }
    }
// С помощью AJAX обнавляем состояние состояние согласования договора
    function update_negotiation(){
//Загружаем модель для работы с БД
        $this->load->model('contracts_model');
        $data = $this->input->post();
        $where = ['contract_number' => $data['contract_number'], 'revision'=> $data['revision'], 'member'=>$data['member']];
        $update = ['voted' => $data['voted'], 'note'=>$data['note'], 'status' => $data['status']];
        if ($data['status'] == 'disagree'){
            $user_email = $this->jurist_email();
            $this->load->helper('url');
            $message = 'Получена отрицательная виза <br> Для просмотра перейдите по ссылке:'
                        .site_url('Contracts/agree_list/'.$data['contract_number'].'/'.$data['revision']).'<br>Замечания: '.$data['note'].'<br> От участника: '.$data['member'];
            $this->load->library('email');
            $config['protocol'] = 'mail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['newline'] = '\r\n';
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from('contracts@pskovavia.ru', 'Договора Псковавиа');
            $this->email->subject('Договор №'.$data['contract_number'].' получена отрицательная виза');
            $this->email->message($message);
            $this->email->to($user_email);
            $this->email->send();
        }
        $upd = $this->contracts_model->update_negotiation($where, $update);
        $where = ['contract_number' => $data['contract_number'], 'revision'=> $data['revision']];
        $count_total = $this->contracts_model->count_agree_total($where);
        $count_total = count($count_total);
        $where = ['contract_number' => $data['contract_number'], 'revision'=> $data['revision'], 'voted' => 1];
        $count_voted = $this->contracts_model->count_agree_total($where);
        $count_voted = count($count_voted);
        if ($count_voted == $count_total){
            $where = ['contract_number' => $data['contract_number'], 'revision'=> $data['revision'], 'status' => 'agreed'];
            $count_agreed = $this->contracts_model->count_agree_total($where);
            $count_agreed = count($count_agreed);
            if ($count_agreed == $count_voted){
                $status = ['status' => 'agreed'];
                $this->contracts_model->update_contract_status($status, $data['contract_number']);
                $where = ['contract_number' => $data['contract_number'], 'revision'=> $data['revision']];
                $update = ['global_status' => 'agreed'];
                $nupdate = $this->contracts_model->upd_global_status($where, $update);
                $user_email = $this->jurist_email();
                $this->load->helper('url');
                $message = 'Договор согласован <br> Открыть карточку договора:'
                            .site_url('Contracts/contract_card/'.$data['contract_number']);
                $this->load->library('email');
                $config['protocol'] = 'mail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['newline'] = '\r\n';
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from('contracts@pskovavia.ru', 'Договора Псковавиа');
                $this->email->subject('Договор №'.$data['contract_number'].' согласован');
                $this->email->message($message);
                $this->email->to($user_email);
                $this->email->send();
                }
            else {
                $status = ['status' => 'disagree'];
                $this->contracts_model->update_contract_status($status, $data['contract_number']);
                $where = ['contract_number' => $data['contract_number'], 'revision'=> $data['revision']];
                $update = ['global_status' => 'disagree'];
                $jupdate = $this->contracts_model->upd_global_status($where, $update);
                $user_email = $this->jurist_email();
                $this->load->helper('url');
                $message = 'Договор не согласован <br> Открыть карточку договора:'
                            .site_url('Contracts/contract_card/'.$data['contract_number']);
                $this->load->library('email');
                $config['protocol'] = 'mail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['newline'] = '\r\n';
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from('contracts@pskovavia.ru', 'Договора Псковавиа');
                $this->email->subject('Договор №'.$data['contract_number'].' не согласован');
                $this->email->message($message);
                $this->email->to($user_email);
                $this->email->send();
            }
        }
    }
/*************************************************************************
 *                     КОНТРАГЕНТЫ
 *
 ************************************************************************/
    function contractors_list(){
        $this->load->library('session');
        $check_auth = $this->session->userdata('logged_in');
        if ($check_auth == TRUE){
//Загружаем модель договоров для создания запросов к БД
            $this->load->model('contracts_model');
//Задаём переменные для отображения в виде (view)
            $title['jurist'] = $this->jurist($this->session->userdata('email'));
            $title['main'] = 'Контракты';
            $title['journal'] = 'Журнал контрагентов';
            $title['add_contractor'] = 'Добавить контрагента';
            $title['contracts_list'] = 'Контрагенты';
            $title['user'] = $this->user($this->session->userdata('email'));
// Получаем все договоры для создания журнала договоров
            $title['all_contractors'] = $this->contracts_model->get_all_contractors();
// Загружаем виды (views)
            $this->load->view('head',$title);
            $this->load->view('contractors');
            $this->load->view('footer');
        }
        else{
            header('Location: /');
        }
    }


}
?>
