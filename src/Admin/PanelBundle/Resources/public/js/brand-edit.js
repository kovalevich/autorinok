$(document).ready(function() {

    $('#editor').redactor({
        buttonSource: true,
        lang: 'ru',
        imageUpload: upload_image,
        convertVideoLinks: true,
        minHeight: 600,
        maxHeight: 800,
        autosave: admin_edit_brand_auto_save_url,
        autosaveInterval: 3,
        autosaveName: 'value',
        buttons: ['html', 'formatting', 'bold', 'italic', 'deleted',
            'unorderedlist', 'orderedlist', 'outdent', 'indent',
            'image', 'video', 'link', 'alignment', 'horizontalrule'],
        plugins: ['fullscreen', 'table', 'video'],
        changeCallback: function()
        {
            $('.save-indicator').removeClass("fa-save").addClass("fa-circle-o-notch").addClass("fa-spin");
        },
        autosaveCallback: function(name, json)
        {
            $('#filling').html(json.filling);
            $('.save-indicator').removeClass("fa-circle-o-notch").removeClass("fa-spin").addClass("fa-save");
        }
    });

    $('.editable').editable({
        url: admin_edit_brand_url,
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
            url: '/adminpanel/api/checkpublicationalias/alias/' + v,
            beforeSend: function() {

            },
            success: function(data) {
                if(data.exist) err = 'Такой алиас уже занят';
            }
        });
        if(err) return err;
    });

    $("#synonyms").editable({
        url: admin_edit_brand_url,
        ajaxOptions: {
            type: 'post',
            dataType: 'json'
        },
        select2: {
            width: '230px',
            tags: true,
            tokenSeparators: [',', ';']
        }
    });

    var years = [];
    for(var i = 1969; i < 2015; i++)
    {
        years.push({
            value: i, text: i
        })
    }

    $(".editable-year").editable({
        url: admin_edit_brand_url,
        source: years
    });

});