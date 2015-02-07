$(document).ready(function() {
    $('.editable').editable({
        url: '/ajax/mod/user',
        disabled: true,
        ajaxOptions: {
            type: 'post',
            dataType: 'json'
        }
    });

    $('#name').editable('option', 'validate', function(v) {
        if(!v) return 'Имя не может быть пустым';
    });

    $('.editable-select').editable({
        url: '/ajax/mod/user',
        source: {
            admin: 'Администратор',
            manager: 'Менеджер',
            user: 'Пользователь'
        }
    });
});