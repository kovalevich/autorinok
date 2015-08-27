
$(document).ready(function() {
	var from = $('#from');
	var from_esr = $('#main_search_from_esr');
	var from_exp = $('#main_search_from_exp');
	var to = $('#to');
	var to_esr = $('#main_search_to_esr');
	var to_exp = $('#main_search_to_exp');
	var form = $('#search-form');
	var result = $('#search-result');
	var eHumanDate = $('#date_input');
    var eOrigDate = $('#main_search_date');

	var keyboard = new Keyboard();

	from.on('focus', function(e){
		keyboard.setFocus($(this));
		result.html('');
		keyboard.show();
	});
	to.on('focus', function(){
		keyboard.setFocus($(this));
		result.html('');
		keyboard.show();
		$(this).select();
	});
	eHumanDate.on('focus', function(){
		keyboard.hide();
	});

	from.autocomplete({
        minLength: 2,
        source: root_ajax + 'http://rasp.rw.by/ru/ajax/autocomplete/search',
		open: function(event, ui) {
			$(this).data("ui-autocomplete").bindings.eq(1).width($(this).parent().outerWidth(true)-10);
		},
		select: function(event, ui) {
			$(this).siblings('[name=' + $(this).attr('name').replace('from', 'from_exp') + ']').val(ui.item.exp);
			$(this).siblings('[name=' + $(this).attr('name').replace('from', 'from_esr') + ']').val(ui.item.ecp);
		},
    });
    from.keyup(function(){
		$(this).siblings('[name=' + $(this).attr('name').replace('from', 'from_exp') + ']').val('');
		$(this).siblings('[name=' + $(this).attr('name').replace('from', 'from_esr') + ']').val('');
	});

	to.autocomplete({
        minLength: 2,
        source: root_ajax + 'http://rasp.rw.by/ru/ajax/autocomplete/search',
		open: function(event, ui) {
			$(this).data("ui-autocomplete").bindings.eq(1).width($(this).parent().outerWidth(true)-10);
		},
		select: function(event, ui) {
			$(this).siblings('[name=' + $(this).attr('name').replace('to', 'from_exp') + ']').val(ui.item.exp);
			$(this).siblings('[name=' + $(this).attr('name').replace('to', 'from_esr') + ']').val(ui.item.ecp);
		},
    });
    to.keyup(function(){
		$(this).siblings('[name=' + $(this).attr('name').replace('to', 'from_exp') + ']').val('');
		$(this).siblings('[name=' + $(this).attr('name').replace('to', 'from_esr') + ']').val('');
	});

	eHumanDate.datepicker({
		maxDate:+44,
		numberOfMonths: 3,
        onSelect: function(dateText, inst){
            eHumanDate.val(utils.dateToHumanDate(dateText));
            eOrigDate.val(dateText).change();
        }
    });

	eHumanDate.val(utils.dateToHumanDate(eOrigDate.val()) || '');

	var search_button = $('#search');

	$('#clear').on('click', function(){
		from.val('');
		to.val('');
		eHumanDate.val(utils.dateToHumanDate(Date()));
		result.html('');
		return false;
	});

	keyboard.togg_btn.on('click', function(){
		keyboard.board.toggle();
		return false;
	});

	keyboard.button.on('click', function(e){
		keyboard.focus.autocomplete( "search");
		if(keyboard.focus.selectionStart != keyboard.focus.selectionEnd)
			keyboard.focus.val('');
		if($(e.target).attr('id') == 'space') {
			keyboard.focus.val(keyboard.focus.val() + ' ');
			return false;
		}
		if($(e.target).attr('id') == 'delete') {
			keyboard.focus.val(keyboard.focus.val().substring(0, keyboard.focus.val().length - 1));
			return false;
		}
		keyboard.focus.val(keyboard.focus.val() + $(e.target).text());
		return false;
	});

	form.on('submit', function(){
		keyboard.hide();
		$.ajax({
            async: true,
            type: 'get',
            url: route,
            data: {
                'from' : from.val(),
                'to' : to.val(),
                'from_esr': from_esr.val(),
                'from_exp': from_exp.val(),
                'to_esr': to_esr.val(),
                'to_exp': to_exp.val(),
                'orig_date': eOrigDate.val()
            },
            beforeSend: function() {
                result.html('загружаю...');
            },
            success: function(data) {
                result.html(data)
            }
        });
		return false;
	})
	
});

var utils = {
    date: function(){
        var t = this, date, day, month, year;

        date = new Date();
        day = date.getDate();
        month = date.getMonth();
        year = date.getFullYear();

        date.today = new Date(year, month, day);
        date.yesterday = new Date(year, month, day - 1);
        date.tomorrow = new Date(year, month, day + 1);

        return date;
    }(),
    /* Ожидаемый формат даты: yyyy-mm-dd ~ 2000-01-31 */
    dateToHumanDate: function(date){
        var t = this;

        if(!date) return '';
		if(lang.date[date]) return lang.date[date];
        date = date.split('-');
		date = new Date(date[0],date[1]-1,date[2]);
        date = !isNaN(date) ? date : new Date();

        switch(date.toDateString()){
            case utils.date.today.toDateString():
                return lang.date.today; /* сегодня */
            case utils.date.tomorrow.toDateString():
                return lang.date.tomorrow; /* завтра */
            case utils.date.yesterday.toDateString():
                return lang.date.yesterday; /* вчера */
            default:
                return [date.getDate(), lang.months[date.getMonth()] || date.getMonth(), date.getFullYear()].join(' ');
        }
    }
};

var lang = $.extend({
    date: {
        today: 'сегодня',
            yesterday: 'вчера',
            tomorrow: 'завтра',
            everyday: 'на все дни'
    },
    months: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
}, app_lang);

var Keyboard = function()
{
	this.board = $('.keyboard');
	this.button = $('.keyboard button');
	this.focus = $('#from');
	this.togg_btn = $('.keyboard-on-off');
};

Keyboard.prototype.setFocus = function(obj)
{
	this.focus = obj;
	obj.val('');
}

Keyboard.prototype.show = function()
{
	this.board.show();
}

Keyboard.prototype.hide = function()
{
	this.board.hide();
}