/**
 * Created by evgen on 19.05.14.
 */
$(document).ready(function() {

    var add_form = new AddForm('add');
    add_form.loadBrands();

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
    //this.params = populate;

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

    this.disableModels();
    this.model.select2({
        language: 'ru'
    });
    
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
};

AddForm.prototype.option = function(option)
{
    //console.log($('#option_' + option).prop("checked"));
    return $('#option_' + option).prop("checked");
};

function formatResult(item) {
    if(!item.id) {
        // return `text` for optgroup
        return item.text;
    }
    var picture = item.element[0].getAttribute('data-picture') !== 'null' ?
        '<img src="' + item.element[0].getAttribute('data-picture') + '" width="25px"/> ' : '';
    // return item template
    return '<span>' + picture + item.text + '</span>';
}

AddForm.prototype.loadBrands = function()
{
    var form = this;
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: auto_catalog_ajax_brands,
        beforeSend: function() {
            form.brand.prop('disabled', true);
        },
        success: function(data) {
            options = '';
            for (var i = 0; i < data.length; i++) {
                sel = false ? 'selected' : '';
                options += '<option value="' + data[i]['alias'] + '" ' + sel + ' id="' + data[i]['id'] + '" data-picture="' + data[i]['picture'] + '">' + data[i]['name'] + '</option>';
            }
            form.brand.html(
                '<option value="-1" data-picture="null">любая</option>' +
                    options
            );
            form.brand.select2({
                formatResult: formatResult,
                language: 'ru'
            });
            form.brand.prop('disabled', false);
        }
    });
};

AddForm.prototype.loadModels = function(brand, checked_model)
{
    var form = this;
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: auto_catalog_ajax_models + '/' + brand,
        beforeSend: function() {
            form.model.prop('disabled', true);
        },
        success: function(data) {
            var options = '';
            for (var i in data) {

                sel = getParameter('model') == data[i]['alias'] ? 'selected' : '';
                if(Object.keys(data[i]['models']).length > 0) {
                    options += '<option value="' + data[i]['alias'] + '" ' + sel + '>' + data[i]['name'] + '</option>';
                    for (var j in data[i]['models'])
                    {
                        sel = getParameter('model') == data[i]['models'][j]['alias'] ? 'selected' : '';
                        options += '<option value="' + data[i]['models'][j]['alias'] + '" class="child-model"' + sel + '> &nbsp; &nbsp; &nbsp;' + data[i]['models'][j]['name'] + '</option>';
                    }

                }
                else
                    options += '<option value="' + data[i]['alias'] + '"' + sel +'>' + data[i]['name'] + '</option>';
            }
            form.model.html(
                '<option value="-1">любая</option>' +
                    options
            );
            form.model.select2({
                language: 'ru'
            });
            form.model.prop('disabled', false);
        }
    });
};

getParameter = function(key){
    if(popolate_params[key] !== undefined)
        return popolate_params[key];
    else 
        return null;
}

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




