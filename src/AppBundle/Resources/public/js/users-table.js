$(document).ready(function() {

    $('#users-table').dataTable( {
        serverSide: true,
        ajax: '/adminpanel/api/getusers',
        columns: [
            { "data": "id" },
            { "data": "name" },
            { "data": "email" },
            { "data": "created" },
            { "data": "role" }
        ]
    });

});