/*
 * contract_card.js
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
$( document ).ready(function() {
    $(document).on('click', '#show-add-form', function(){
        $('#show-add-div').hide();
        $('#upload-form').show();
    });
    var agree_status = $('#agree_status').text();
    if (agree_status == 'В процессе согласования'){
        $('button[data-target="#beginAgree"]').hide();
    }
    letters = ''
    $('#add-member').hide();
    member_number = 0
    $('#member').replaceWith('<input type="text" name="member-'+member_number+'"placeholder="Имя участника" class="form-control" id="member'+member_number+'"value="" required>');
    contract = $(':input[name="contract_number"]').val();
    $('#upload_file').submit(function(e){
        e.preventDefault();
        var method=$(this).attr('method');
        var action=$(this).attr('action');
        var data=$('select option:selected').val();
        var fdata = new FormData();
        fdata.append ('userfile', $('#userfile')[0].files[0])
        fdata.append ('file_type', data);
        fdata.append ('contract_number', contract);
        $.ajax({
            type: method,
            url: action,
            processData: false,
            contentType: false,
            data: fdata,
            success: function (result) {
                var obj =$.parseJSON(result);
                if (obj.error){
                    $('#upload_file').before('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Внимание!</strong>'+obj.error+'</div>');
                }
                else{
                    $('#upload_file').before('<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Файл успешно добавлен.</div>');
                    SetTimeout: 10000;
                    location.reload();
                }
            },
            error: function (result) {
                alert(result);
            }
        });
    })
    $('.delete-contract-card').click(function(){
        var file_name = {fname:$(this).prev('a').children('.col-md-8').text()};
        var replace = $(this).prev('a');
        var del_btn = $(this);
        $('#delete-dialog').modal();
        $('#delete-document').click(function(){
            $.ajax({
                type: 'POST',
                url:'/index.php/Contracts/delete_file',
                data: file_name,
                success: function(result){
                    $(replace).replaceWith('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Файл удалён</div>');
                    $(del_btn).remove();
                    file_name = {};
                    location.reload();
                }
            });
        });
    })
    $(document).on('click','#add-member', function(e){
        e.preventDefault();
        var lempty = $('input:last').val();
        if (lempty == ''){
            $('#add-member').hide();
            $('#button-error').append('<p>Сначала нужно выбрать согласованта</p>');
        }
        else{
            var new_number = member_number+1
            $('#member'+member_number).clone().appendTo('#member-group').attr({'name':'member-'+new_number, 'id':'member'+new_number, 'value':''})
            member_number = member_number+1
            $('#add-member').hide();
            if (member_number > 3){
                $('#add-member').remove();
                $('#button-error').append('<p>Максимум можно выбрать 5 согласовантов</p>');
            }
        }
    })
    $(document).on ('keypress','input:focus',function(event){
        if (event.which == "8"){
            letters = letters.substring(0, letters.length - 1)
            $('#dropdown-member').hide().removeAttr('style');
            $('#dropdown-member').empty();
        }
        else if (event.which == "0"){
            letters=''
        }
        else {
            var letter = String.fromCharCode(event.which);
            letters +=letter
            var params = { name: letters}
            if (letters.length > "2"){
                setTimeout:1000
                $.ajax({
                    url: '/index.php/Contracts/search_users',
                    type: 'POST',
                    data: params,
                    async: true,
                    success: function(result){
                        var obj = $.parseJSON(result);
                        $('#dropdown-member').empty();
                        for (i=0; i < obj.length; i++){
                            $('#dropdown-member').show().css({'z-index':'1024', 'width':'100%', 'margin-top':'-15px'});
                            $('#dropdown-member').append('<div class="member">'+obj[i].initials+'</div>');
                        }
                        $('.member').click(function(){

                            $('#member'+member_number).replaceWith('<input type="text" name="member-'+member_number+'"placeholder="Имя участника" class="form-control" id="member'+member_number+'" value="'+$(this).html()+'"required>');
                            $('#dropdown-member').hide().removeAttr('style');
                            $('#dropdown-member').empty();
                            $('#add-member').show();
                            $('#button-error').empty();
                            letters = ''

                        });
                    }
                });
            }
        }
    })
    $('#agree-form').submit(function(e){
        e.preventDefault();
        var project_value = $('#project-select').val();
        console.log(project_value);
        if(project_value == 'none'){
            alert ('Выберете проект договора для согласования');
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
                    if (obj.error){
                        $('#agree-form').replaceWith('<p class="text-danger text-center">'+obj.error+'</p>');
                        $('#add-member').remove();
                    }
                    else{
                        $('#agree-form').replaceWith('<p class="lead">'+obj.result+'</p><a class="btn btn-primary" href="/index.php/Contracts/agree_list/'+contract+'/'+obj.revision+'">Перейти</a>');
                        $('#add-member').remove();
                    }

                }
            });
        }
    });
})


