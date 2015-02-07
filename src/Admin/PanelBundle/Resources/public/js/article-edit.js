$(document).ready(function() {

    $('#editor').redactor({
        buttonSource: true,
        lang: 'ru',
        imageUpload: '/adminpanel/api/upload',
        convertVideoLinks: true,
        minHeight: 600,
        maxHeight: 800,
        autosave: admin_edit_article_auto_save_url,
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
            $('.save-indicator').removeClass("fa-circle-o-notch").removeClass("fa-spin").addClass("fa-save");
        }
    });

    $('.editable').editable({
        url: admin_edit_article_url,
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

    $('.editable-category').editable({
        url: admin_edit_article_url,
        source: ajax_categories
    });

    $('.editable-type').editable({
        url: admin_edit_article_url,
        source: {1: 'Текст', 2: 'Фото', 3: 'Видео'}
    });

    $('.editable-home').editable({
        url: admin_edit_article_url,
        source: {1: 'Да', 0: 'Нет'}
    });

    $('#tags').editable({
        url: admin_edit_article_url,
        placeholder: 'mercedes, доллар, шины',
        placement: 'left',
        allowClear: true,
        select2:{
            id: function (e) {
                return e.tagName;
            },
            width: '230px',
            ajax: {
                url: ajax_tags,
                dataType: 'json',
                delay: 250,
                data: function (term, page) {
                    return { word: term };
                },
                results: function (data, page) {
                    return { results: data };
                },
                cache: true
            },
            formatResult: function (item) {
                return item.tagName;
            },
            formatSelection: function (item) {
                return item.tagName;
            },
            initSelection: function (element, callback) {
                return $.get(ajax_tags + '?mode=init', { word: element.val() }, function (data) {
                    callback(data);
                }, 'json');
            },
            minimumInputLength: 2,
            tags: true,
            tokenSeparators:[","," "]
        }
    });

});