$(document).ready(function() {

    var form = new Form('search-full');

    form.slide();
    form.loadBrands();
    form.update();

    $('input.control').change(function(){
        form.checkInput(this);
    });
    $('.select').change(function(){
        form.checkInput(this);
    });
});

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

var Form = function(form_id)
{
    this.id = form_id;
    this.brand = $('#' + this.id  + ' #brand');
    this.model = $('#' + this.id  + ' #model');
    this.price = $('#' + this.id  + ' #price');
    this.year = $('#' + this.id  + ' #year');
    this.volume = $('#' + this.id  + ' #volume');
    this.a = $('#go_search');

    this.disableModels();
    this.model.select2({
        language: 'ru'
    });
};

Form.prototype.populate = function()
{
    if(this.params.brand != null)
    {
        this.loadModels(this.params.brand);
    }
    if(this.params.price != null) {
        values = this.params.price.split(';');
        max = values[1] > 50000 ? parseInt(values[1]) + 10000 : 50000;
        var slider = this.price.data("ionRangeSlider");
        slider.update({
            from: values[0],
            to: values[1],
            max: max
        });
    }
    if(this.params.year != null) {
        values = this.params.year.split(';');
        var slider = this.year.data("ionRangeSlider");
        slider.update({
            from: values[0],
            to: values[1]
        });
    }
    if(this.params.volume != null) {
        values = this.params.volume.split(';');
        var slider = this.volume.data("ionRangeSlider");
        slider.update({
            from: values[0],
            to: values[1]
        });
    }
    if(this.params.engine != null)
    {
        var eng = this.params.engine;
        while(eng.length){
            var last = eng.shift();
            $('#engine_' + last).prop('checked', true);

        }
    }
    if(this.params.transmission != null)
    {
        var trans = this.params.transmission;
        while(trans.length){
            var last = trans.shift();
            $('#transmission_' + last).prop('checked', true);

        }
    }

    if(this.params.body != null)
    {
        var body = this.params.body;
        while(body.length){
            var last = body.shift();
            $('#body_' + last).prop('checked', true);

        }
    }

    if(this.params.options != null)
    {
        var option = this.params.options;
        while(option.length){
            var last = option.shift();
            $('#option_' + last).prop('checked', true);

        }
    }
};


Form.prototype.checkInput = function (element)
{
    switch (element.id){
        case 'brand': {
            this.disableModels();
            this.loadModels(this.brand.find('option:selected').val());
            break;
        }
        case 'model': {
            break;
        }
        default: {
            break;
        }
    }
    this.update();
};

Form.prototype.update = function()
{
    this.updateList();
    this.updateCounter();
}

Form.prototype.updateCounter = function()
{
    var href = [];
    if(this.brand.find('option:selected').val() != -1) {
        href.push('brand=' + this.brand.find('option:selected').val());
    }
    if(this.model.find('option:selected').val() != -1) {
        href.push('model=' + this.model.find('option:selected').val());
    }
    if(this.price.val() != -1) {
        href.push('price=' + this.price.val());
    }
    if(this.year.val() != -1) {
        href.push('year=' + this.year.val());
    }
    if(this.volume.val() != -1) {
        href.push('volume=' + this.volume.val());
    }
    if(get_checked('engine[]') !== '') href.push(get_checked('engine[]'));
    if(get_checked('transmission[]') !== '') href.push(get_checked('transmission[]'));
    if(get_checked('body[]') !== '') href.push(get_checked('body[]'));
    if(get_checked('options[]') !== '') href.push(get_checked('options[]'));



    content = '<a href="' + this.a.attr('href') + '">Показать</a> <span id="counter"></span>';
    $(".fixed-container").attr('data-content', content);
    $(".fixed-container").popover('show');
    $('.arrow').attr('style', '');

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: auto_used_ajax_count + '?' + href.join('&'),
        beforeSend: function() {
            $('#count-indicator').html('<span class="fa fa-cog fa-spin"></span>');
        },
        success: function(data) {
            $('#count-indicator').html('Найдено ' + data.count['1'] + ' авто');
        }
    });
}

Form.prototype.updateList = function()
{
    var href = [];
    if(this.brand.find('option:selected').val() && this.brand.find('option:selected').val() != -1) {
        href.push('brand=' + this.brand.find('option:selected').val());
    }
    if(this.model.find('option:selected').val() && this.model.find('option:selected').val() != -1) {
        href.push('model=' + this.model.find('option:selected').val());
    }
    if(get_checked('engine[]') !== '') href.push(get_checked('engine[]'));
    if(this.price.val() != -1) {
        href.push('price=' + this.price.val());
    }
    if(this.year.val() != -1) {
        href.push('year=' + this.year.val());
    }
    if(this.volume.val() != -1) {
        href.push('volume=' + this.volume.val());
    }
    if(get_checked('transmission[]') !== '') href.push(get_checked('transmission[]'));
    if(get_checked('body[]') !== '') href.push(get_checked('body[]'));

    window.location.href = '#' + href.join('&');

    $.ajax({
        type: 'get',
        dataType: 'text',
        url: auto_used_ajax_ads + '?' + href.join('&'),
        beforeSend: function() {

        },
        success: function(data) {
            $('#search-result').html(data);
        }
    })
}

Form.prototype.loadBrands = function()
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
                sel = '';
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

Form.prototype.loadModels = function(brand)
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
                sel = '';
                if(Object.keys(data[i]['models']).length > 0) {
                    options += '<option value="' + data[i]['alias'] + '"' + sel + '>' + data[i]['name'] + '</option>';
                    for (var j in data[i]['models'])
                    {
                        sel = '';
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
            form.model.prop('disabled', false);
        }
    });
};

Form.prototype.disableModels = function()
{
    this.model.html('<option value="-1">любая</option>');
    this.model.prop('disabled', true);
};

Form.prototype.slide = function()
{
    var form = this;
    this.price.ionRangeSlider({
        min: 500,
        max: 60000,
        from: 5000,
        to: 15000,
        type: 'double',
        step: 500,
        postfix: " $",
        prefix: "Цена: ",
        decorate_both: false,
        grid: true,
        max_postfix: "+",
        onFinish: function (obj) {
            form.update();
        },
        onChange: function (obj)
        {
            if(obj.to == obj.max) {
                var slider = form.price.data("ionRangeSlider");
                slider.update({
                    to: obj.to,
                    max: obj.max + 10000
                });
            }
        }
    });
    this.year.ionRangeSlider({
        min: 1969,
        max: 2015,
        from: 1985,
        to: 2009,
        type: 'double',
        step: 1,
        postfix: " г.",
        grid: true,
        prefix: "год выпуска: ",
        decorate_both: false,
        onFinish: function (obj) {
            form.update();
        }
    });
    this.volume.ionRangeSlider({
        min: 0.8,
        max: 7,
        from: 1.5,
        to: 5.0,
        type: 'double',
        step: 0.1,
        postfix: " л.",
        grid: true,
        prefix: "Объем: ",
        decorate_both: false,
        onFinish: function (obj) {
            form.update();
        }
    });
};

get_checked = function(name)
{
    listCheck = [];
    $('input:checkbox[name="' + name + '"]:checked').each(function() {
        listCheck.push(name + '=' + $(this).val());
    });
    return listCheck.join('&');
}

