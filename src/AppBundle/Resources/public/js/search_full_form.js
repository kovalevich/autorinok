$(document).ready(function() {

    var form = new Form('search-full');
    form.slide();
    form.populate();
    form.loadBrands();
    form.update(false);

    $('input.control').change(function(){
        form.checkInput(this);
    });
    $('.select').change(function(){
        form.checkInput(this);
    });

    $('#search-results').on('click', '.pagination a',function(e){
        var url = this.attributes.href.value;
        var hash = url.substring(url.indexOf('?'));
        window.location.hash = '#' + hash;
        form.update(false);
        return false;
    });

    $('#clear-engine').click(function(e){
        $('input:checkbox[name="engine[]"]').prop('checked', false);
        var slider = form.volume.data("ionRangeSlider");
        slider.update({
            from: 1,
            to: 5
        });
        form.update();
        return false;
    });
    $('#clear-price').click(function(e){
        $('input:checkbox[name="exchange"]').prop('checked', false);
        $('input:checkbox[name="auction"]').prop('checked', false);
        var slider = form.price.data("ionRangeSlider");
        slider.update({
            max: 100000,
            from: 500,
            to: 85000
        });
        form.update();
        return false;
    });
    $('#clear-body').click(function(e){
        $('input:checkbox[name="body[]"]').prop('checked', false);
        form.update();
        return false;
    });
    $('#clear-transmission').click(function(e){
        $('input:checkbox[name="transmission[]"]').prop('checked', false);
        form.update();
        return false;
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
    console.log(getParameter('engine[]'));
    if(getParameter('price')) {
        values = getParameter('price').split(';');
        max = values[1] > 50000 ? parseInt(values[1]) + 10000 : 50000;

        var slider = this.price.data("ionRangeSlider");
        slider.update({
            from: values[0],
            to: values[1],
            max: max
        });
    }
    if(getParameter('year')) {
        values = getParameter('year').split(';');
        var slider = this.year.data("ionRangeSlider");
        slider.update({
            from: values[0],
            to: values[1]
        });
    }
    if(getParameter('volume')) {
        values = getParameter('volume').split(';');
        var slider = this.volume.data("ionRangeSlider");
        slider.update({
            from: values[0],
            to: values[1]
        });
    }
    if(getParameter('engine[]') != null)
    {
        var eng = getParameter('engine[]');
        eng = eng.split(';');
        while(eng.length){
            var last = eng.shift();
            $('#engine_' + last).prop('checked', true);

        }
    }
    if(getParameter('transmission[]'))
    {
        var trans = getParameter('transmission[]');
        trans = trans.split(';');
        while(trans.length){
            var last = trans.shift();
            $('#transmission_' + last).prop('checked', true);

        }
    }

    if(getParameter('body[]') != null)
    {
        var body = getParameter('body[]');
        body = body.split(';');
        while(body.length){
            var last = body.shift();
            $('#body_' + last).prop('checked', true);

        }
    }

    if(getParameter('options[]') != null)
    {
        var option = getParameter('options[]');
        option = option.split(';');
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
    this.update(true);
};

Form.prototype.update = function(go_to_start_page)
{
    this.updateList(go_to_start_page);
}

Form.prototype.updateList = function(go_to_start_page)
{
    var href = [];
    $brand = getParameter('brand') !== undefined ? getParameter('brand') : this.brand.find('option:selected').val();

    if(getParameter('brand') && this.brand.find('option:selected').val() && getParameter('brand') !== this.brand.find('option:selected').val())
        $brand = this.brand.find('option:selected').val();
    if($brand && $brand != -1) {
        href.push('brand=' + $brand);
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
    if(getParameter('page') && go_to_start_page === false) href.push('page=' + getParameter('page'));

    window.location.hash = '#' + href.join('&');

    $.ajax({
        type: 'get',
        dataType: 'text',
        url: auto_used_ajax_ads + '?' + href.join('&'),
        beforeSend: function() {

        },
        success: function(data) {
            $('#search-results').html(data);
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
                form.loadModels(getParameter('brand'));
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
                sel = getParameter('model') == data[i]['alias'] ? 'selected' : '';
                if(Object.keys(data[i]['models']).length > 0) {
                    options += '<option value="' + data[i]['alias'] + '"' + sel + '>' + data[i]['name'] + '</option>';
                    for (var j in data[i]['models'])
                    {
                        sel = getParameter('model') == data[i]['models'][j]['alias'] ? 'selected' : '';;
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
