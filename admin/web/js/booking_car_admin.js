$(document).ready(function () {
    let car_id = $("#number-car").val(); //Текущий тур
    let booking_cars; //Массив туров по дням
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
        monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        today: "Сегодня",
        clear: "Очистить",
        format: "dd/mm/yyyy",
        weekHeader: "Нед",
        titleFormat: "MM yyyy",
        weekStart: 1
    };
    //Устанавливаем datepicker
    $(function () {
        $("#datepicker-booking-car").datepicker({
            format: "dd/mm/yyyy",
            language: "ru",
        });
    });
    $("#datepicker-booking-car").datepicker({
        language: "ru",
        beforeShowDay: function (date) {
            if (booking_cars === undefined) return {enabled: true};
            let _y = date.getFullYear();
            let _m = date.getMonth() + 1;
            let _d = date.getDate();
            var cars = booking_cars[_y]; //Массив по текущему году
            if (cars === undefined) return {enabled: true};
            cars = cars[_m];
            if (cars === undefined) return {enabled: true}; //Массив по текущему месяцу
            cars = cars[_d];
            if (cars === undefined) return {enabled: true}; //Объект по текущему дню
            let dateSel = $("#datepicker-booking-car").datepicker("getDate"); //Выбранная ячейка
            let point = "";
            if (cars.begin) {
                point = "<i style=\"color: red\">*</i>"
            }

            let content = _d + point + "<div style=\"font-size: small;\">бронь " + cars.count + " авто" + "</div>" + "<div style=\"font-size: small;\">своб. " + cars.free + " авто</div>";
            if (dateSel !== null && dateSel.getDate() === _d && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                //Проверяем, сколько забронированно, и выбираем цвет
                //ни одной брони
                //не полное бронирование
                //полное бронирование

                return {enabled: true, classes: "calendar-day-select", tooltip: "", content: content};
            }
            if (Number(cars.count) === 0) return {
                enabled: true,
                classes: "calendar-day-danger",
                tooltip: "",
                content: content
            };
            if (Number(cars.free) === 0) return {
                enabled: true,
                classes: "calendar-day-success",
                tooltip: "",
                content: content
            };
            return {enabled: true, classes: "calendar-day-warning", tooltip: "", content: content};
        }
    });
    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById("datepicker-booking-car")) {
        $.post("/car/booking/get-calendar", {car_id: car_id}, function (data) {
            booking_cars = JSON.parse(data);
            $("#datepicker-booking-car").datepicker("update");

        });
    }
    $("#datepicker-booking-car").datepicker().on("changeDate", function (e) {
        //получаем сведения о тек.дне
        if (e.date === undefined) return;
        let date_booking = e.date.getDate() + "-" + (e.date.getMonth() + 1) + "-" + e.date.getFullYear();
        $.post("/car/booking/get-day",
            {date: date_booking, car_id: car_id},
            function (data) {
                $(".booking-day").html(data);
                $('#datepicker-booking-car').datepicker('hide');
            });
    });

    $(document).on("click", ".give-out-car", function () {
        let check = $(this).is(":checked");
        let _i = $(this).data("i");
        $(this).prop("disabled", true);
        let booking_number = $(this).data("number");
        $.post("/car/booking/set-give-car", {booking_number: booking_number}, function (data) {
            $("#error-set-give-" + _i).html(data);
        });
    });
});



