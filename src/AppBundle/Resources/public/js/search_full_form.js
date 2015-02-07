$(document).ready(function() {

    var form = new Form('search-full', search_params);
    form.loadBrands();
    form.slide();
    form.populate();
    $('input.control').change(function(){
        form.checkInput(this);
    });
    $('.select').change(function(){
        form.checkInput(this);
    });

    $(".fixed-container").popover({
        trigger:"manual",
        container: '.container-for-button',
        html: true
    });

    $.lockfixed(".container-for-button",{offset: {top: 150, bottom: 500}});
});

var Form = function(form_id, params)
{
    this.id = form_id;
    this.brand = $('#' + this.id  + ' #brand');
    this.model = $('#' + this.id  + ' #model');
    this.price = $('#' + this.id  + ' #price');
    this.year = $('#' + this.id  + ' #year');
    this.volume = $('#' + this.id  + ' #volume');
    this.params = params;
    this.a = $('#go_search');
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
    var href = [], url = '/cars/1';
    if(this.brand.find('option:selected').val() != -1) {
        url += '/' + this.brand.find('option:selected').val();
    }
    if(this.model.find('option:selected').val() != -1) {
        url += '/' + this.model.find('option:selected').val();
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

    this.a.attr('href', url + '?' + href.join('&'));
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
        url: '/ajax/api/getcount?' + href.join('&'),
        beforeSend: function() {
            $('#counter').html('<img src="/assets/img/loading.gif" alt="загрузка"/>');
        },
        success: function(data) {
            $('#counter').html(data.count + ' авто');
        }
    });
}

Form.prototype.loadBrands = function()
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
                sel = form.params.brand == popular[i]['alias'] ? ' selected' : '';
                options += '<option value="' + popular[i]['alias'] + '" ' + sel + ' id="' + popular[i]['id'] + '">' + popular[i]['name'] + '</option>';
            }
            options += '</optgroup>';
            options += '<optgroup label="все">';
            for (var i = 0; i < all.length; i++) {
                sel = form.params.brand == all[i]['alias'] ? ' selected' : '';
                options += '<option value="' + all[i]['alias'] + '"  ' + sel + ' id="' + all[i]['id'] + '">' + all[i]['name'] + '</option>';
            }
            options += '</optgroup>';
            form.brand.html(
                '<option value="-1">любая</option>' +
                    options
            );
            form.brand.prop('disabled', false);
        }
    });
};

Form.prototype.loadModels = function(brand_id)
{
    var form = this;
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/ajax/api/models/alias/' + brand_id,
        beforeSend: function() {
            form.model.prop('disabled', true);
        },
        success: function(data) {
            form.models = data;
            var options = '';
            for (var i in data) {
                sel = form.params.model == data[i]['alias'] ? ' selected' : '';
                if(Object.keys(data[i]['submodels']).length > 0) {
                    options += '<option value="' + data[i]['alias'] + '"' + sel + '>' + data[i]['name'] + '</option>';
                    for (var j in data[i]['submodels'])
                    {
                        sel = form.params.model == data[i]['submodels'][j]['alias'] ? ' selected' : '';
                        options += '<option value="' + data[i]['submodels'][j]['alias'] + '" class="child-model"' + sel + '> &nbsp; &nbsp; &nbsp;' + data[i]['submodels'][j]['name'] + '</option>';
                    }

                }
                else
                    options += '<option value="' + data[i]['alias'] + '"' + sel +'>' + data[i]['name'] + '</option>';
            }
            form.model.html(
                '<option value="-1">все</option>' +
                    options
            );
            form.model.prop('disabled', false);
        }
    });
};

Form.prototype.disableModels = function()
{
    this.model.html('<option value="-1">все</option>');
    this.model.prop('disabled', true);
};

Form.prototype.slide = function()
{
    var form = this;
    this.price.ionRangeSlider({
        min: 500,
        max: 60000,
        from: 1000,
        to: 15000,
        type: 'double',
        step: 500,
        postfix: " $",
        grid: true,
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
        max: 2014,
        from: 1989,
        to: 2009,
        type: 'double',
        step: 1,
        postfix: " г.",
        grid: true,
        onFinish: function (obj) {
            form.update();
        }
    });
    this.volume.ionRangeSlider({
        min: 1,
        max: 7,
        from: 1.5,
        to: 3.0,
        type: 'double',
        step: 0.5,
        postfix: " л.",
        grid: true,
        onFinish: function (obj) {
            form.update();
        }
    });
};

get_checked = function(name)
{
    listCheck = [];
    $('input:checkbox[name="' + name + '"]:checked').each(function() {
        listCheck .push(name + '=' + $(this).val());
    });
    return listCheck.join('&');
}

