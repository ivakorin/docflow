/*
 * agree_list.js
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
    $(document).on('click','#break',function(){
        var number = $('#contract_number').text();
        var contract_revision = $('#list_revision').text();
        var params = {contract_number:number, revision:contract_revision}
        $.ajax({
            url: '/index.php/Contracts/break_agree',
            type: 'POST',
            data: params,
            async: true,
            success: function(result){
                location.reload();
            }
        });
    });
})
