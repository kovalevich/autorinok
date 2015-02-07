$(document).ready(function() {
    $('#control').on('click', 'a.add-subscription',function(e){
        var this_element = $('#' + e.currentTarget.id);
        var type = this_element.attr('data-type');
        var name = '', where = {};
        if(type == 'article') {
            if(this_element.attr('data-tags')) {
                where['tags'] = this_element.attr('data-tags');
                name = 'публикации на тему &#8220;' + this_element.attr('data-tags') + '&#8221;';
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