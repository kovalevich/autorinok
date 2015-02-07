$(document).ready(function() {

    $('.logged-user').on('click', 'a.tab-checker',function(e){
        var url = this.attributes.href.value;
        var hash = url.substring(url.indexOf('#'));
        $('.nav-tabs a[href=' + hash + ']').tab('show');
        return false;
    });

    change_tab();

    $('#switch-editable-ads').on('change',function(){
        $('.editable-ads').editable('toggleDisabled')
    });

    $('#ads-table').on('click', 'a.mod-delete',function(e){
        Ply.dialog("confirm", "Удалить объявление навсегда?")
            .done(function (ui) {
                document.location.href = '/cars/delete/id/' + e.currentTarget.id;
            })
        return false;
    });
    $('#ads-table').on('click', 'a.mod-up',function(e){
        $.ajax({
            async: false,
            type: 'get',
            dataType: 'json',
            url: '/cars/up',
            data: {
                'id' : e.currentTarget.id
            },
            beforeSend: function() {
                $('#' + e.currentTarget.id).html('загружаю...');
            },
            success: function(data) {
                if(data.success) {
                    $('#dyn-alert').html(
                        '<div class="alert alert-success top-general-alert">' +
                            data.success +
                            '<button type="button" class="close">&times;</button>' +
                        '</div>'
                    );
                    $('#' + e.currentTarget.id).attr('disabled', true);
                    $('#' + e.currentTarget.id).html('поднято');
                }
                if(data.error) {
                    $('#dyn-alert').html(
                        '<div class="alert alert-danger top-general-alert">' +
                            data.error +
                            '<button type="button" class="close">&times;</button>' +
                            '</div>'
                    );
                    $('#' + e.currentTarget.id).html('<i class="fa fa-level-up"></i> поднять');
                }

                $(".top-general-alert").delay(100).slideDown("medium");
            }
        });
        return false;
    });
});

change_tab = function ()
{
    var active_tab = '#' + window.location.hash.substr(1);
    if(active_tab) {
        $('.nav-tabs a[href=' + active_tab + ']').tab('show');
    }
}