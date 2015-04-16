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
$(document).ready(function() {
    $(document).on('click', '#change_contractor_btn', function(e){
        e.preventDefault();
        var form_data = $('#contractor_form').serialize();
        var method = $('#contractor_form').attr('method');
        var action = $('#contractor_form').attr('action');
        $.ajax({
            type: method,
            url: action,
            data: form_data,
            success: function(result){
                var res = $.parseJSON(result);
                console.log(res.result);
                //location.reload();
            },
            error: function(error){
                //
            }
        })
    })
})


