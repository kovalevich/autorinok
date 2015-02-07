/**
 * Created by evgen on 19.05.14.
 */
$(document).ready(function() {

    var add_form = new AddForm('add');
    add_form.loadBrands();
    add_form.slide();
    add_form.populate();
    setTimeout(function (){add_form.updatePreview()}, 1500);

    $('.select').change(function(){
        add_form.checkInput(this);
    });
    $('input').on('input propertychange', function(){
        add_form.checkInput(this);
    });

    $("#demo-wizard").on("change",function(e,t){
        if($("#step-"+t.step).length>0){
            var a=$("#step-" + t.step).parsley();
            if(a.validate(),!a.isValid())return!1
        }
        $btnNext=$(this).parents(".wizard-wrapper").find(".btn-next"),
        4==t.step && "next"==t.direction?$btnNext.text(" Разместить мое объвление").prepend('<i class="fa fa-check-circle"></i>').removeClass("btn-primary").addClass("btn-success"):$btnNext.text("Продолжить ").append('<i class="fa fa-arrow-right"></i>').removeClass("btn-success").addClass("btn-primary")}).on("finished",function(){$('#add').submit();}),$(".wizard-wrapper .btn-next").click(function(){$("#demo-wizard").wizard("next")}),$(".wizard-wrapper .btn-prev").click(function(){$("#demo-wizard").wizard("previous")
    });

    var r = new Flow({
        target: '/ajax/api/upload',
        chunkSize: 1024*1024,
        testChunks: false
    });
    // Flow.js isn't supported, fall back on a different method
    if (!r.support) {
        $('.flow-error').show();
        return ;
    }
    // Show a place for dropping/selecting files
    $('.flow-drop').show();
    r.assignDrop($('.flow-drop')[0]);
    r.assignBrowse($('.flow-browse')[0]);

    // Handle file add event
    r.on('fileAdded', function(file){
        if(file.file.type.indexOf('image/')) {
            file.cancel();
            return true;
        }
        // Show progress bar
        $('.flow-list').show();
        // Add the file to the list
        $('.flow-list').append(
            '<div class="col-sm-2 flow-file-' + file.uniqueIdentifier + '">' +
                '<div class="thumbnail">' +
                '<img class="flow-file-src" width="80px"/>' +
                '</div>' +
                '<div class="progress progress-striped file-progress">' +
                '<div class="progress-bar" role="progressbar">' +
                '<span class="sr-only">50% Complete</span>' +
                '</div>' +
                '</div>' +
                '<div class="btn-group">' +
                '<a class="btn btn-xs btn-danger flow-file-cancel" title="удалить">' +
                '<span class="fa fa-trash"></span>' +
                '</a>&nbsp;' +
                '</div>' +
                '</div>'
        );
        var $self = $('.flow-file-'+file.uniqueIdentifier);

        $self.find('.flow-file-cancel').on('click', function () {
            file.cancel();
            $self.remove();
        });
    });
    r.on('filesSubmitted', function(file) {
        r.upload();
    });
    r.on('complete', function(){

    });
    r.on('fileSuccess', function(file,message){
        var $self = $('.flow-file-'+file.uniqueIdentifier);
        $self.find('.flow-file-src').attr('src', '/data/uploads/' + file.name);
        $('.flow-file-'+file.uniqueIdentifier+' .file-progress').slideUp();
        var photos = $('#photos').val() ? $('#photos').val().split(':') : [];
        photos.push(file.name);
        $('#photos').val(photos.join(':'));
    });
    r.on('fileError', function(file, message){
        // Reflect that the file upload has resulted in error
        $('.flow-file-'+file.uniqueIdentifier+' .flow-file-progress').html('(file could not be uploaded: '+message+')');
    });
    r.on('fileProgress', function(file){
        $('.flow-file-'+file.uniqueIdentifier+' .sr-only')
            .html(Math.floor(file.progress()*100) + '%') ;
        $('.flow-file-'+file.uniqueIdentifier+' .progress-bar').css({width:Math.floor(file.progress()*100) + '%'});
    });
    r.on('uploadStart', function(){

    });
    r.on('catchAll', function() {
        //console.log.apply(console, arguments);
    });
    window.r = {
        cancel: function() {
            r.cancel();
            $('.flow-file').remove();
        },
        upload: function() {
            r.resume();
        },
        flow: r
    };

});

function readablizeBytes(bytes) {
    var s = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'];
    var e = Math.floor(Math.log(bytes) / Math.log(1024));
    return (bytes / Math.pow(1024, e)).toFixed(2) + " " + s[e];
}

var AddForm = function(form_id)
{
    this.id = form_id;
    this.brand = $('#' + this.id  + ' #brand');
    this.model = $('#' + this.id  + ' #model');
    this.body = $('#' + this.id  + ' #body');
    this.road = $('#' + this.id  + ' #road');
    this.vin = $('#' + this.id  + ' #vin');
    this.submit = $('#' + this.id  + ' #submit');
    this.description = $('#' + this.id  + ' #description');
    this.name = $('#' + this.id  + ' #name');
    this.country = $('#' + this.id  + ' #country');
    this.city = $('#' + this.id  + ' #city');
    this.phone = $('#' + this.id  + ' #phone');
    this.color = $('#' + this.id  + ' #color');
    this.models = null; // здесь будем хранить список моделей
    this.generation = $('#' + this.id  + ' #generation');
    this.engine = $('#' + this.id  + ' #engine');
    this.transmission = $('#' + this.id  + ' #transmission');
    this.price = $('#' + this.id  + ' #price');
    this.year = $('#' + this.id  + ' #year');
    this.volume = $('#' + this.id  + ' #volume');
    this.brand_span = $('#brand-span');
    this.model_span = $('#model-span');
    this.preview = $('#preview');
    this.a = $('#go_search');
    this.ads_count = $('#ads-count');
    this.auction = $('#input-auction');
    this.exchange = $('#input-exchange');
    this.notice = $('#notice');
    this.millage = $('#millage');
    this.params = populate;

    var form = this;
    $('.form-button').unbind().click(function(){
        $(this).toggleClass('label-default');
        switch (this.id){
            case 'auction': $(this).toggleClass('label-success'); break;
            case 'exchange': $(this).toggleClass('label-warning'); break;
            default : $(this).toggleClass('label-info'); break;
        }
        $('#input-' + this.id).val($(this).hasClass('label-default') ? 0 : 1);

        form.updatePreview();
        return false;
    });

    this.submit.unbind().click(function(){
        $('#' + form.id).submit();
    });

    $('.text-control').unbind().keyup(function(){
        form.updatePreview();
    });
    var options = '';
    for(var i in ini_options['colors']){
        options += '<option value="' + i + '">' + ini_options['colors'][i] + '</option>';
    }
    this.color.html(
        '<option value="-1">--</option>' +
            options
    );
    options = '';
    for(var i in ini_options['body']){
        options += '<option value="' + i + '">' + ini_options['body'][i] + '</option>';
    }
    this.body.html(
        '<option value="-1">--</option>' +
            options
    );

    options = '';
    for(var i in ini_options['road']){
        options += '<option value="' + i + '">' + ini_options['road'][i] + '</option>';
    }
    this.road.html(
        '<option value="-1">--</option>' +
            options
    );
};

AddForm.prototype.populate = function()
{
    if(this.params.id_brand != null)
    {
        this.loadModels(this.params.id_brand);
    }
    if(this.params.id_model != null) this.loadGenerations(this.params.id_model);

    if(this.params.volume != null) {
        this.volume.val(this.params.volume);
    }
    if(this.params.engine != null)
    {
        this.engine.find('[value='+this.params.engine+']').attr('selected', true);
    }
    if(this.params.road != null)
    {
        this.road.find('[value='+this.params.road+']').attr('selected', true);
    }
    if(this.params.transmission != null)
    {
        this.transmission.find('[value=' + this.params.transmission + ']').attr('selected', true);
    }
    if(this.params.color != null)
    {
        this.color.find('[value='+this.params.color+']').attr('selected', true);
    }
    if(this.params.body != null)
    {
        this.body.find('[value='+this.params.body+']').attr('selected', true);
    }
    if(this.params.name) this.name.val(this.params.name.stripTags());
    if(this.params.country) this.country.val(this.params.country.stripTags());
    if(this.params.city) this.city.val(this.params.city.stripTags());
    if(this.params.phone) this.phone.val(this.params.phone.stripTags());
    if(this.params.description) this.description.val(this.params.description.stripTags());
    if(this.params.vin) this.vin.val(this.params.vin.stripTags());
    if(this.params.auction == '1') $('#auction').click();
    if(this.params.exchange == '1') $('#exchange').click();

    //setTimeout(this.updatePreview(), 4000);
};

AddForm.prototype.checkInput = function (element)
{
    //console.log('check input');
    switch (element.id){
        case 'brand': {
            this.disableGenerations();
            this.disableModels();
            this.loadModels(this.brand.find('option:selected').val());
            break;
        }
        case 'model': {
            this.disableGenerations();
            this.loadGenerations(this.model.find('option:selected').val());
            break;
        }
        case 'generation': {
            this.updateYear();
            break;
        }
        default: {
            break;
        }
    }
    this.updatePreview();
};

AddForm.prototype.option = function(option)
{
    //console.log($('#option_' + option).prop("checked"));
    return $('#option_' + option).prop("checked");
};

AddForm.prototype.updatePreview = function()
{
    this.preview.hide();
    var brand = this.brand.find('option:selected').val() > -1 ? this.brand.find('option:selected').html() : '';
    var model = this.model.find('option:selected').val() > -1 ? this.model.find('option:selected').html() : '';
    model = model.replace(/(&nbsp;)+/g, '');
    var price = this.price.val();
    var year = this.year.val();
    var vin = this.vin.val();
    var description = this.description.val();
    var phone = this.phone.val();
    var name = this.name.val();
    var country = this.country.val();
    var city = this.city.val();
    var auction = this.auction.val() == 1 ? '<span class="label label-success">торг</span> ' : '';
    var exchange = this.exchange.val() == 1 ? '<span class="label label-warning">обмен</span>' : '';
    var millage = this.millage.val();
    var array = [];
    array.push(year + ' г.в.');
    array.push(millage + ' км');

    if(empty(brand) || empty(model) || empty(phone) || phone.length < 9) this.submit.attr('disabled', true);
    else this.submit.attr('disabled', false);

    if(this.color.find('option:selected').val() != -1) {
        array.push(this.color.find('option:selected').html());
    }
    engine = '';
    if(this.engine.find('option:selected').val() != -1) {
        engine += this.engine.find('option:selected').html() + ' ';
    }
    engine += this.volume.val() + ' л.';
    array.push(engine);
    if(this.transmission.find('option:selected').val() != -1) {
        array.push(this.transmission.find('option:selected').html());
    }
    if(this.body.find('option:selected').val() != -1) {
        array.push(this.body.find('option:selected').html());
    }
    if(this.road.find('option:selected').val() != -1) {
        array.push(this.road.find('option:selected').html() + ' привод');
    }
    var information = array.join(', ');

    var preview =
        '<div class="row ad-title">' +
            '<div class="col-md-8">' +
                '<h2>' + brand + ' ' + model + ' <small>\'' + year + '</small></h2>' +
                '<p class="sm">Объявление о продаже автомобиля ' + brand + ' ' + model + ' ' + year + ' года выпуска</p>' +
            '</div>' +
            '<div class="col-md-4">' +
                '<span class="label label-danger">$' + price + '</span> ' +
                auction + exchange +
            '</div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-sm-8">' +

            '</div>' +
            '<div class="col-md-4">' +
                '<h3>' + brand + ' ' + model + '</h3>' +
                information + (vin ? '<br/>VIN код: ' + vin.stripTags() : '') +

                '<ul class="options">';

    for (var i in ini_options['option'])
    {
        if (this.option(i)) {
            preview +=
                '<li><span class="glyphicon-thumbs-up glyphicon"></span> ' +
                    ini_options['option'][i];
                '</li>';
        }
    }

    preview +=
                '</ul>' +
                '<address>' +
                    '<span class="glyphicon glyphicon-user"></span> <strong>Данные о продавце</strong><br>' +
                    (country ? country.stripTags() + ' ' : '') +
                    (city ? city.stripTags() + ' ' : '') +
                    (name ? '<br/>' + name.stripTags() : '') +
                    (phone ? '<br/>+375 ' + phone.stripTags() : '') +
                '</address>' +
            '</div>' +
        '</div>' +
    '<div class="row">' +
        '<hr>' +
        '<p><em>' + (description ? description.stripTags() : '') + '</em></p>' +
    '</div>';

    if (brand && model) {
        this.preview.html(
            preview
        );
        this.preview.show();
    }

    if(!brand || !model) {
        this.notice.html(
            'Выберите марку и модель автомобиля!'
        )
    }
    else {
        this.notice.html(
            'Заполните как можно больше информации о вашем автомобиле и на ваше объявление будут обращать внимание!'
        )
    }
}

AddForm.prototype.loadBrands = function()
{
    var form = this;
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/ajax/api/brands',
        beforeSend: function() {
            form.brand.prop('disabled', true);
        },
        success: function(data) {
            popular = data['popular'];
            all = data['unpopular'];
            options = '<optgroup label="популярные">';
            for (var i = 0; i < popular.length; i++) {
                sel = form.params.id_brand == popular[i]['id'] ? ' selected' : '';
                options += '<option value="' + popular[i]['id'] + '"' + sel + '>' + popular[i]['name'] + '</option>';
            }
            options += '</optgroup>';
            options += '<optgroup label="все">';
            for (var i = 0; i < all.length; i++) {
                sel = form.params.id_brand == all[i]['id'] ? ' selected' : '';
                options += '<option value="' + all[i]['id'] + '"' + sel + '>' + all[i]['name'] + '</option>';
            }
            options += '</optgroup>';
            form.brand.html(
                '<option value="">выберите марку</option>' +
                    options
            );
            form.brand.prop('disabled', false);
            form.params.brand = false;
        }
    });
};

AddForm.prototype.loadModels = function(brand_id)
{
    var form = this;
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/ajax/api/models/id/' + brand_id,
        beforeSend: function() {
            form.model.prop('disabled', true);
        },
        success: function(data) {
            form.models = data;
            var options = '';
            for (var i in data) {
                sel = form.params.id_model == data[i]['id'] ? ' selected' : '';
                if(Object.keys(data[i]['submodels']).length > 0) {
                    options += '<option value="' + data[i]['id'] + '"' + sel + '>' + data[i]['name'] + '</option>';
                    for (var j in data[i]['submodels'])
                    {
                        sel = form.params.id_model == data[i]['submodels'][j]['id'] ? ' selected' : '';
                        options += '<option value="' + data[i]['submodels'][j]['id'] + '" class="child-model"' + sel + '> &nbsp; &nbsp; &nbsp;' + data[i]['submodels'][j]['name'] + '</option>';
                    }

                }
                else
                    options += '<option value="' + data[i]['id'] + '"' + sel +'>' + data[i]['name'] + '</option>';
            }
            form.model.html(
                '<option value="">выберите модель</option>' +
                    options
            );
            form.model.prop('disabled', false);
            form.params.model = false;
        }
    });
};

AddForm.prototype.loadGenerations = function(model_id)
{
    var form = this;
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/ajax/api/generations/model_id/' + model_id,
        beforeSend: function() {
            form.generation.prop('disabled', true);
        },
        success: function(data) {
            options = '';
            for (var i in data) {
                sel = form.params.generation == data[i]['id'] ? ' selected' : '';
                options += '<option value="' + data[i]['id'] + '"' + sel +'>' + data[i]['name'] + '</option>';
            }
            form.generation.html(
                '<option value="">выберите поколение</option>' +
                    options
            );
            form.generation.prop('disabled', false);
            form.params.generation = false;
        }
    });
};

AddForm.prototype.disableGenerations = function()
{
    this.generation.html('<option value="">выберите поколение</option>');
    this.generation.prop('disabled', true);
};

AddForm.prototype.disableModels = function()
{
    this.model.html('<option value="">выберите модель</option>');
    this.model.prop('disabled', true);
};

AddForm.prototype.slide = function()
{
    var form = this;
};

AddForm.prototype.updateYear = function()
{
    var form = this;
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/ajax/api/generations/generation_id/' + form.generation.find('option:selected').val(),
        beforeSend: function() {

        },
        success: function(data) {

        }
    });
}

plural = function(iNumber, one, two, five) {
    var sEnding, i;
    iNumber = iNumber % 100;
    if (iNumber>=11 && iNumber<=19) {
        return five;
    }
    else {
        i = iNumber % 10;
        switch (i)
        {
            case (1): sEnding = one; break;
            case (2):
            case (3):
            case (4): sEnding = two; break;
            default: sEnding = five;
        }
    }
    return sEnding;
}

function empty (mixedValue){
    return (mixedValue === undefined ||
        mixedValue === null || mixedValue === ""
        || mixedValue === "0" || mixedValue === 0
        || mixedValue === false);
}

String.prototype.stripTags = function() {
    return this.replace(/<\/?[^>]+>/g, '');
};




