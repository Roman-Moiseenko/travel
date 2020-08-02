$(document).ready(function () {

    $.fn.datepicker.dates['ru'] = {
        closeText: "Закрыть",
        prevText: "Пред",
        nextText: "След ",
        days: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        daysShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        daysMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        months: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthsShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
        today: "Сегодня",
        clear: "Очистить",
        format: "mm/dd/yyyy",
        weekHeader: "Нед",
        titleFormat: "MM yyyy",
        weekStart: 0
    };
 /*   $.fn.datepicker.regional["ru"] = {
        closeText: 'Закрыть',
        prevText: 'Предыдущий',
        nextText: 'Следующий',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
*/
   // $.datepicker.setDefaults($.datepicker.regional.ru);
    // var date = new Date();
    //  date.setDate(date.getDate() + 1);
   // $.fn.datepicker.defaults.format = "mm/dd/yyyy";
   /* $(function () {

        $('#datepicker').datepicker({
            startDate: '+1d',
            locale: 'ru',
            language: "ru",
            onSelect: function (date) {
                $('#datepicker_value2').val(date);

            },
        });
    });

        var myDate = new Date('2020/08/20').toISOString();
        var myText = 'Корпоратив! Вася опять нажрется!';
        $('#datepicker').datepicker({
            beforeShowDay: function (date) {

                var dateSel = $("#datepicker").datepicker("getDate");
                console.log(dateSel.toISOString(), myDate);
                if (date.toISOString() === myDate) {
                    if (dateSel === null) {
                        return {enabled: true, classes: 'myClass', tooltip: myText};
                    } else {
                        if (dateSel.toISOString() !== myDate) {
                            return {enabled: true, classes: 'myClass', tooltip: myText};
                        }
                    }
                }
            },
        });

*/

    $(function () {
        $("#datepicker").datepicker({
            format: 'mm/dd/yyyy',
            startDate: '+1d',
            onSelect: function (date) {
                $('#datepicker_value').val(date);

            },
            language: "ru",
        });
        // $("#datepicker").datepicker("setDate", $('#datepicker_value').val());
    });

    var myDate = new Date('2020/08/20').toISOString();
    var myText = 'Корпоратив! Вася опять нажрется!';
   $('#datepicker').datepicker({
       startDate: '+1d',
       language: 'ru',
       title: 'Календарь',
        beforeShowDay: function (date) {
            var dateSel = $("#datepicker").datepicker("getDate");
            //console.log(dateSel.toISOString(), myDate);
            if (date.toISOString() === myDate) {
                if (dateSel === null) {
                    return {enabled: true, classes: 'myClass', tooltip: myText};
                } else {
                    if (dateSel.toISOString() !== myDate) {
                        return {enabled: true, classes: 'myClass', tooltip: myText}; }
                }
            }
        }
    });
    $('#datepicker').datepicker().on('changeDate', function (e) {
        // alert(e.date);
        console.log(e);
    });
});