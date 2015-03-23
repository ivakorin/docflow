/*
 * add_contractor.js
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
 $(function(){
    $('#add_contractor').submit(function(e){
        //отменяем стандартное действие при отправке формы
        e.preventDefault();
        //берем из формы метод передачи данных
        var m_method=$(this).attr('method');
        //получаем адрес скрипта на сервере, куда нужно отправить форму
        var m_action=$(this).attr('action');
        //получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
        //то есть в стандартном формате передачи данных формы
        var m_data=$(this).serialize();
        $.ajax({
            type: m_method,
            url: m_action,
            data: m_data,
            success: function(result){
                var obj = $.parseJSON(result);
                if (obj.error){
                    alert (obj.error)
                }
                else {
                $('#add_contractor').replaceWith('<p class="lead">'+obj.success+'</p><a class="btn btn-default" href="/index.php/Contracts/add_contractor">Добавить контрагента</a>');
                }
            }
        });
    });
});

