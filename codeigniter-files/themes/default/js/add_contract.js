/*
 * add_contract.js
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
    $('#contractor-date').datepicker()
    $('#validity-date').datepicker()
    letters = ''
    $('#contractor').keypress(function(event){
        if (event.which == "8"){
            letters = letters.substring(0, letters.length - 1)
            $('#dropdown-contractor').hide().removeAttr('style');
            $('#dropdown-contractor').empty();
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
                    url: '/index.php/Contracts/search_contractor',
                    type: 'POST',
                    data: params,
                    async: true,
                    success: function(result){
                        var obj = $.parseJSON(result);
                        $('#dropdown-contractor').empty();
                        for (i=0; i < obj.length; i++){
                            $('#dropdown-contractor').show().css({'z-index':'1024', 'width': '100%', 'margin-top':'-20px'});
                            $('#dropdown-contractor').append('<div class="contractor">'+obj[i].name+'</div>');
                        }
                        $('.contractor').click(function(){
                            $('#contractor').replaceWith('<input type="text" name="contractor_name" class="form-control" id="contractor" autocomplete="off" placeholder="Контрагент" required value="'+$(this).html()+'">');
                            $('#dropdown-contractor').hide().removeAttr('style');
                            $('#dropdown-contractor').empty();
                            letters = ''
                        });
                    }
                });
            }
        }
    })
    $('#add_contract').submit(function(e){
        e.preventDefault();
        var method = $(this).attr('method');
        var action = $(this).attr('action');
        //cn = $(':input[name="contract_number"]').val();
        //id = $(':input[name="incoming_date"]').val();
        //id = $(':input[name="incoming_date"]').val();
        var content = $(this).serialize();
        var fdata = new FormData();
        fdata.append ('userfile', $('#userfile')[0].files[0])
        fdata.append ('file_type', '0');
        fdata.append ('text', content);
        $.ajax({
            type: method,
            url: action,
            processData: false,
            contentType: false,
            data: fdata,
            success: function(result){
                var res = $.parseJSON(result);
                $('.modal-body').empty();
                $('.modal-title').replaceWith('<h4 class="modal-title" id="addContractorlabel">Контракт сохранён</h4>');
                $('.modal-body').append('<p class="lead">'+res.result+'</p><a class="btn btn-info btn-small" href="/index.php/Contracts/contract_card/'+res.link+'">Открыть карточку</a>');
                letters = ''

            }
        })

    });
    $('#initiator').keypress(function(event){
        //console.log(String.fromCharCode(event.which));
        if (event.which == "8"){
            letters = letters.substring(0, letters.length - 1)
            $('#dropdown-initiator').hide().removeAttr('style');
            $('#dropdown-initiator').empty();
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
                        $('#dropdown-initiator').empty();
                        for (i=0; i < obj.length; i++){
                            $('#dropdown-initiator').show().css({'z-index':'1024', 'width':'100%', 'margin-top':'-20px'});
                            $('#dropdown-initiator').append('<div class="initiator">'+obj[i].initials+'</div>');
                        }
                        $('.initiator').click(function(){
                            $('#initiator').replaceWith('<input type="text" name="initiator" required placeholder="Инициатор" class="form-control" id="initiator" value="'+$(this).html()+'">');
                            $('#dropdown-initiator').hide().removeAttr('style');
                            $('#dropdown-initiator').empty();
                            letters = ''

                        });
                    }
                });
            }
        }
    })
})

