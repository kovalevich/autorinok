$(document).ready(function() {
    $('.timeline').on('click', 'a.mod-delete',function(e){
        var this_element = $('#' + e.currentTarget.id);
        var name = this_element.attr('data-name');
        var id = e.currentTarget.id
        Ply.dialog("confirm", "Удалить " + name + " из ленты?")
            .done(function (ui) {
                document.location.href = '/ajax/mod/delsubscription/id/' + id;
            })
        return false;
    });

    $('#control').on('click', 'a.add-subscription',function(e){
        var this_element = $('#' + e.currentTarget.id);
        var type = this_element.attr('data-type');
        var name = '', where = {};
        if(type == 'ad') {
            name = 'все автомобили';
            if(this_element.attr('data-brand')) {
                where['brand'] = this_element.attr('data-brand');
                name += ' ' + this_element.attr('data-brand-name');
            }
            if(this_element.attr('data-model')) {
                where['model'] = this_element.attr('data-model');
                name += ' ' + this_element.attr('data-model-name');
            }
            if(this_element.attr('data-year')) {
                var year = this_element.attr('data-year').split(';');
                where['year'] = this_element.attr('data-year');
                name += ' с ' + year[0] + ' по ' + year[1] + ' г.в.';
            }
            if(this_element.attr('data-price')) {
                where['price'] = this_element.attr('data-price');
                var price = this_element.attr('data-price').split(';');
                name += ' ' + price[0] + '-' + price[1] + '$';
            }
        }

        $.ajax({
            async: false,
            type: 'post',
            dataType: 'json',
            url: '/ajax/mod/addsubscription',
            data: {
                'type' : type,
                'name' : name,
                'where': JSON.stringify(where)
            },
            beforeSend: function() {
                this_element.html('загружаю...');
            },
            success: function(data) {
                if(data.success) {
                    $('#dyn-alert').html(
                        '<div class="alert alert-success top-general-alert">' +
                            data.success +
                            '<button type="button" class="close">&times;</button>' +
                            '</div>'
                    );
                    this_element.attr('disabled', true);
                    this_element.html('вы подписаны');
                }
                if(data.error) {
                    $('#dyn-alert').html(
                        '<div class="alert alert-danger top-general-alert">' +
                            data.error +
                            '<button type="button" class="close">&times;</button>' +
                            '</div>'
                    );
                    this_element.html('<i class="fa fa-clock-o"></i> добавить в ленту');
                }

                $(".top-general-alert").delay(100).slideDown("medium");
            }
        });
        return false;
    });
});