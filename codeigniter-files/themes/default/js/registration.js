/*
 * registration.js
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
 $(document).ready(function(){
    modal_body = $(".modal-body").html();
    modal_footer = $(".modal-footer").html();
    $('#signup-form').submit(function(e){
        e.preventDefault();
        var dept_value = $('select').val();
        if(dept_value == 'none'){
            alert ('Выбирете подразделение');
        }
        else {
            //отменяем стандартное действие при отправке формы
            e.preventDefault();
            //берем из формы метод передачи данных
            var method=$(this).attr('method');
            //получаем адрес скрипта на сервере, куда нужно отправить форму
            var action=$(this).attr('action');
            //получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
            //то есть в стандартном формате передачи данных формы
            var u_data=$(this).serialize();
            $.ajax({
                type: method,
                url: action,
                data: u_data,
                success: function(result){
                    var obj = $.parseJSON(result);
                    if (obj.fatal_error){
                        $('#signup-form').replaceWith('<p class="text-danger text-center">'+obj.fatal_error+'</p>');
                        $('#modal-close-btn').remove();
                        $('#modal-submit').text('Назад').attr('id','modal-back');
                    }
                    else if (obj.error){
                        $('#signup-form').replaceWith('<p class="text-danger text-center">'+obj.error+'</p>');
                        $('#modal-close-btn').remove();
                        $('#modal-submit').text('Назад').attr('id','modal-back');
                    }
                    else{
                        $('#signup-form').replaceWith('<p class="lead">'+obj.result+'</p><a class="btn btn-primary" href="/index.php/Users/cabinet">Авторизоваться</a>');
                        $('#modal-close-btn').remove();
                        $('#modal-submit').remove();
                    }

                },
                error: function (error){
                    $('#signup-form').replaceWith('<p class="text-danger text-center">Произошла ошибка, свяжитесь с администратором</p>');
                    $('#modal-close-btn').remove();
                    $('#modal-submit').text('Назад').attr('id','modal-back');
                }
            });
        }
    });
    $(document).on('click','#modal-back',function(){
        $('.modal-body').html(modal_body);
        $('.modal-footer').html(modal_footer);
    });
});

