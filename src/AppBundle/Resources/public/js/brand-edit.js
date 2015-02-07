$(document).ready(function() {

    $('.editable').editable({
        url: '/adminpanel/mod/brand',
        ajaxOptions: {
            type: 'post',
            dataType: 'json'
        }
    });

    $('.editable-title').editable('option', 'validate', function(v) {
        if(!v) return 'Название не может быть пустым';
    });

    $('.create-new').on('save', function(e, params) {
        window.location.href = '/adminpanel/brand/' + params.response.id;
    });

    $('.create-new').on('shown', function(e, editable) {
        editable.input.$input.val('');
    });

});