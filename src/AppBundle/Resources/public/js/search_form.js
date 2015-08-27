$(document).ready(function() {

    var form = new Form('search');
    form.slide();
    form.loadBrands();
    form.update(false);

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
    this.a = $('#go_search');

    this.disableModels();
    this.model.select2({
        language: 'ru'
    });
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
    this.updateCount();
}

Form.prototype.updateCount = function()
{
    var href = [];

    $brand = -1;
    $model = -1;

    if(this.brand.find('option:selected').val())
        $brand = this.brand.find('option:selected').val();
    if($brand && $brand != -1) {
        href.push('brand=' + $brand);
    }

    if(this.model.find('option:selected').val() != -1)
        $model = this.model.find('option:selected').val();

    if($model && $model != -1) {
        href.push('model=' + $model);
    }

    if(this.price.val() != -1) {
        href.push('price=' + this.price.val());
    }
    if(this.year.val() != -1) {
        href.push('year=' + this.year.val());
    }

    $('#go_search').attr('href', auto_used + '#' + href.join('&'));
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
                sel = getParameter('brand') == data[i]['alias'] ? 'selected' : '';
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
            if(getParameter('brand') && getParameter('brand') != -1)
                form.loadModels(getParameter('brand'), getParameter('model'));
            form.brand.prop('disabled', false);
        }
    });
};

Form.prototype.loadModels = function(brand, checked_model)
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
        force_edges: true,
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
        force_edges: true,
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

getParameter = function(name)
{
    var vars = [], hash;
    var hashes = window.location.hash.slice(window.location.hash.indexOf('#') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        if(name == hash[0]) {
            if(hash[0] in vars){
                vars[hash[0]] += ';' + hash[1];
            }
            else {
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
        }
    }

    return vars[name];
}
