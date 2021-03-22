$(document).ready(function () {
    let stay_id = $("#number-stay").val(); //Текущий тур
    let booking_stays; //Массив туров по дням
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
        $("#datepicker-booking-stay").datepicker({
            format: "dd/mm/yyyy",
            language: "ru",
        });
    });
    $("#datepicker-booking-stay").datepicker({
        language: "ru",
        beforeShowDay: function (date) {
            if (booking_stays === undefined) return {enabled: true};
            let _y = date.getFullYear();
            let _m = date.getMonth() + 1;
            let _d = date.getDate();
            var stays = booking_stays[_y]; //Массив по текущему году
            if (stays === undefined) return {enabled: true};
            stays = stays[_m];
            if (stays === undefined) return {enabled: true}; //Массив по текущему месяцу
            stays = stays[_d];
            if (stays === undefined) return {enabled: true}; //Объект по текущему дню
            let dateSel = $("#datepicker-booking-stay").datepicker("getDate"); //Выбранная ячейка
            let point = "";
            if (stays.begin) {
                point = "<i style=\"color: red\">*</i>"
            }

            let content;
            if (stays.free === 1) {
                content = _d + point + "<div style=\"font-size: small;\">своб.</div>";
            } else {
                content = _d + point + "<div style=\"font-size: small;\">бронь</div>";
            }
            if (dateSel !== null && dateSel.getDate() === _d && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: "calendar-day-select", tooltip: "", content: content};
            }
            if (Number(stays.free) === 1) return {
                enabled: true,
                classes: "calendar-day-danger",
                tooltip: "",
                content: content
            };
            if (Number(stays.free) === 0) return {
                enabled: true,
                classes: "calendar-day-success",
                tooltip: "",
                content: content
            };
            return {enabled: true, classes: "calendar-day-warning", tooltip: "", content: content};
        }
    });
    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById("datepicker-booking-stay")) {
        $.post("/stay/booking/get-calendar", {stay_id: stay_id}, function (data) {
            //console.log(data);
            booking_stays = JSON.parse(data);
            $("#datepicker-booking-stay").datepicker("update");

        });
    }
    $("#datepicker-booking-stay").datepicker().on("changeDate", function (e) {
        //получаем сведения о тек.дне
        if (e.date === undefined) return;
        let date_booking = e.date.getDate() + "-" + (e.date.getMonth() + 1) + "-" + e.date.getFullYear();
        $.post("/stay/booking/get-day",
            {date: date_booking, stay_id: stay_id},
            function (data) {
            console.log(data);
                $(".booking-day").html(data);
                $('#datepicker-booking-stay').datepicker('hide');
            });
    });

    $(document).on("click", ".give-out-stay", function () {
        let check = $(this).is(":checked");
        let _i = $(this).data("i");
        $(this).prop("disabled", true);
        let booking_number = $(this).data("number");
        $.post("/stay/booking/set-give-stay", {booking_number: booking_number}, function (data) {
            $("#error-set-give-" + _i).html(data);
        });
    });
});



