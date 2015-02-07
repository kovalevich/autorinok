var Form = function(form_id)
{
    this.id = form_id;
    this.brand = $('#' + this.id  + ' #brand');
    this.model = $('#' + this.id  + ' #model');
    this.price = $('#' + this.id  + ' #price');
    this.year = $('#' + this.id  + ' #year');
    this.volume = $('#' + this.id  + ' #volume');
    this.a = $('#go_search');
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
    this.a.attr('href', url + '?' + href.join('&'));
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
                options += '<option value="' + popular[i]['alias'] + '" id="' + popular[i]['id'] + '">' + popular[i]['name'] + '</option>';
            }
            options += '</optgroup>';
            options += '<optgroup label="все">';
            for (var i = 0; i < all.length; i++) {
                options += '<option value="' + all[i]['alias'] + '" id="' + all[i]['id'] + '">' + all[i]['name'] + '</option>';
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
                if(Object.keys(data[i]['submodels']).length > 0) {
                    options += '<option value="' + data[i]['alias'] + '">' + data[i]['name'] + '</option>';
                    for (var j in data[i]['submodels'])
                    {
                        options += '<option value="' + data[i]['submodels'][j]['alias'] + '" class="child-model"> &nbsp; &nbsp; &nbsp;' + data[i]['submodels'][j]['name'] + '</option>';
                    }

                }
                else
                    options += '<option value="' + data[i]['alias'] + '">' + data[i]['name'] + '</option>';
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
        max: 50000,
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
            if(obj.toNumber == obj.max) {
                form.price.ionRangeSlider("update", {
                    to: obj.toNumber,
                    max: obj.max + 10000
                });
            }
        }
    });
    this.year.ionRangeSlider({
        min: 1969,
        max: 2015,
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
};
