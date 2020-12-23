$(document).ready(function () {
    let tour_id = $("#number-tour").val(); //Текущий тур
    let booking_tours; //Массив туров по дням
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
        format: "dd/mm/yyyy",
        weekHeader: "Нед",
        titleFormat: "MM yyyy",
        weekStart: 1
    };
    //Устанавливаем datepicker
    $(function () {
        $("#datepicker-booking-tour").datepicker({
            format: "dd/mm/yyyy",
            //startDate: '+1d',
            language: "ru",
        });
    });
    $("#datepicker-booking-tour").datepicker({
        //startDate: '+1d',
        language: "ru",
        beforeShowDay: function (date) {
            if (booking_tours === undefined) return {enabled: true};
            let _y = date.getFullYear();
            let _m = date.getMonth() + 1;
            let _d = date.getDate();
            let tours = booking_tours[_y]; //Массив по текущему году
            if (tours === undefined) return {enabled: true};
            tours = tours[_m];
            if (tours === undefined) return {enabled: true}; //Массив по текущему месяцу
            tours = tours[_d];
            if (tours === undefined) return {enabled: true}; //Объект по текущему дню
            let dateSel = $("#datepicker-booking-tour").datepicker("getDate"); //Выбранная ячейка
            let content = _d + "<div style=\"font-size: small;\">бронь " + tours.count + " мест" + "</div>" + "<div style=\"font-size: small;\">своб. " + tours.free + " мест</div>";
            if (dateSel !== null && dateSel.getDate() === _d && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: "calendar-day-select", tooltip: "", content: content};
            }
            //Проверяем, сколько забронированно, и выбираем цвет
            //ни одной брони
            if (Number(tours.count) === 0) return {
                enabled: true,
                classes: "calendar-day-danger",
                tooltip: "",
                content: content
            };
            //полное бронирование
            if (Number(tours.free) === 0) return {
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
    if (document.getElementById("datepicker-booking-tour")) {
        $.post("/tour/booking/get-calendar", {tour_id: tour_id}, function (data) {
            console.log(data);
            booking_tours = JSON.parse(data);
            $("#datepicker-booking-tour").datepicker("update");
        });
    }
    $("#datepicker-booking-tour").datepicker().on("changeDate", function (e) {
        //получаем сведения о тек.дне
        if (e.date === undefined) return;
        let date_booking = e.date.getDate() + "-" + (e.date.getMonth() + 1) + "-" + e.date.getFullYear();
        $.post("/tour/booking/get-day",
            {date: date_booking, tour_id: tour_id},
            function (data) {
                $(".booking-day").html(data);
                $('#datepicker-booking-tour').datepicker('hide');
            });
    });
    $(document).on("click", ".give-out-tour", function () {
        let check = $(this).is(":checked");
        let _i = $(this).data("i");
        $(this).prop("disabled", true);
        let booking_number = $(this).data("number");
        //console.log(booking_number);
        $.post("/tour/booking/set-give-tour", {booking_number: booking_number}, function (data) {
            $("#error-set-give-" + _i).html(data);
        });
    });
});



