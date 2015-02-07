$(document).ready(function() {
    $('.editable').editable({
        url: admin_edit_category_url,
        disabled: true,
        ajaxOptions: {
            type: 'post',
            dataType: 'json'
        }
    });

    $('.editable-title').editable('option', 'validate', function(v) {
        if(!v) return 'Заголовок не может быть пустым';
    });

    $('.editable-alias').editable('option', 'validate', function(v) {
        var err = false;
        if(!v) err = 'Алиас не может быть пустым';
        $.ajax({
            async: false,
            type: 'get',
            dataType: 'json',
            url: '/adminpanel/api/checkcategorialias/alias/' + v,
            beforeSend: function() {

            },
            success: function(data) {
                if(data.exist) err = 'Такой алиас уже занят';
            }
        });
        if(err) return err;
    });
    $('#switch-editable').on('change',function(){
        $('.editable').editable('toggleDisabled')
    });
    $('.editable-ispublic').editable({
        url: admin_edit_category_url,
        disabled: true,
        source: {1: 'публичная', '': 'скрытая'}
    });
    $('.table-responsive').on('click', 'a.mod-delete',function(e){
        Ply.dialog("confirm", "Удалить категорию навсегда?")
            .done(function (ui) {
                document.location.href = e.currentTarget.href;
            })
        return false;
    });
});