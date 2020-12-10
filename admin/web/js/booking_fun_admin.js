$(document).ready(function () {
    let fun_id = $("#number-fun").val(); //Текущее Развлечение
    let booking_funs; //Массив туров по дням
//Переводим
    if ($.fn.datepicker === undefined) return false;
    $.fn.datepicker.dates["ru"] = {
        closeText: "Закрыть",
        prevText: "Пред",
        nextText: "След ",
        days: ["воскресенье", 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        daysShort: ["вск", "пнд", "втр", "срд", "чтв", "птн", "сбт"],
        daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
        today: "Сегодня",
        clear: "Очистить",
        format: "mm/dd/yyyy",
        weekHeader: "Нед",
        titleFormat: "MM yyyy",
        weekStart: 1
    };
    //Устанавливаем datepicker
    $(function () {
        $("#datepicker-booking-fun").datepicker({
            format: "mm/dd/yyyy",
            //startDate: '+1d',
            language: "ru",
        });
    });
    $("#datepicker-booking-fun").datepicker({
        //startDate: '+1d',
        language: "ru",
        beforeShowDay: function (date) {
            if (booking_funs === undefined) return {enabled: true};
            let _y = date.getFullYear();
            let _m = date.getMonth() + 1;
            let _d = date.getDate();
            let funs = booking_funs[_y]; //Массив по текущему году
            if (funs === undefined) return {enabled: true};
            funs = funs[_m];
            if (funs === undefined) return {enabled: true}; //Массив по текущему месяцу
            funs = funs[_d];
            if (funs === undefined) return {enabled: true}; //Объект по текущему дню
            let dateSel = $("#datepicker-booking-fun").datepicker("getDate"); //Выбранная ячейка
            let content = _d + "<div style=\"font-size: small;\">бронь " + funs.count + " мест" + "</div>" + "<div style=\"font-size: small;\">своб. " + funs.free + " мест</div>";
            if (dateSel !== null && dateSel.getDate() === _d && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: "calendar-day-select", tooltip: "", content: content};
            }
            //Проверяем, сколько забронированно, и выбираем цвет
            //ни одной брони
            if (Number(funs.count) === 0) return {
                enabled: true,
                classes: "calendar-day-danger",
                tooltip: "",
                content: content
            };
            //полное бронирование
            if (Number(funs.free) === 0) return {
                enabled: true,
                classes: "calendar-day-success",
                tooltip: "",
                content: content
            };
            //не полное бронирование
            return {enabled: true, classes: "calendar-day-warning", tooltip: "", content: content};
        }
    });
    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById("datepicker-booking-fun")) {
        $.post("/fun/booking/get-calendar", {fun_id: fun_id}, function (data) {
            booking_funs = JSON.parse(data);
            $("#datepicker-booking-fun").datepicker("update");
        });
    }
    $("#datepicker-booking-fun").datepicker().on("changeDate", function (e) {
        //получаем сведения о тек.дне
        if (e.date === undefined) return;
        let date_booking = e.date.getDate() + "-" + (e.date.getMonth() + 1) + "-" + e.date.getFullYear();
        $.post("/fun/booking/get-day",
            {date: date_booking, fun_id: fun_id},
            function (data) {
                $(".booking-day").html(data);
            });
    });
    $(document).on("click", ".give-out-fun", function () {
        let check = $(this).is(":checked");
        let _i = $(this).data("i");
        $(this).prop("disabled", true);
        let booking_number = $(this).data("number");
        $.post("/fun/booking/set-give-fun", {booking_number: booking_number}, function (data) {
            $("#error-set-give-" + _i).html(data);
        });
    });
});



