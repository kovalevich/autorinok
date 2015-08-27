app_lang = {
    date: {
        today: 'сегодня',
        yesterday: 'вчера',
        tomorrow: 'завтра',
        everyday: 'на все дни'
    },
    months: ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря']
};

/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
$.datepicker.regional['ru'] = {
    minDate: 0,
    maxDate: +140,
    closeText: 'Закрыть',
    prevText: '&#x3c;Пред',
    nextText: 'След&#x3e;',
    currentText: 'Сегодня',
    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'],
    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
    weekHeader: 'Нед',
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    duration: 50,
    beforeShow: function(input, inst) {
        $(window).on('resize', function(){
            $(input).datepicker('hide');
        });
    }
};
$.datepicker.setDefaults($.datepicker.regional['ru']);