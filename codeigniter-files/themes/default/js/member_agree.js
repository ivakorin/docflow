/*
 * member_agree.js
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
    $('#disagree').click(function(e){
        e.preventDefault();
        var textarea = $('#textarea').val();
        console.log(textarea)
        if (textarea == ''){
            $('.modal-body').append('<div class="alert alert-danger" role="alert">Необходимо внести замечание</div>');
        }
        else {
            $('.alert').remove();
            var u_data=$('#update_status').serialize();
            $.ajax({
                type: "POST",
                url: "/index.php/Contracts/update_negotiation",
                data: u_data,
                success: function(result){
                    location.reload();
                }
            });
        }
    });
    $('#agreed').click(function(){
        var user = $('input[name="member"]').val();
        var number = $('input[name="contract_number"]').val();
        var rev = $('input[name="revision"]').val();
        var vot = $('input[name="voted"]').val();
        var stat = 'agreed';
        var bnote = ''
        var data = {member:user, contract_number:number, revision:rev, voted:vot, status:stat, note:bnote}
        $.ajax({
                type: "POST",
                url: "/index.php/Contracts/update_negotiation",
                data: data,
                success: function(result){
                    location.reload();
                }
            });
    });
})
