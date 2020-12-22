$(document).ready(function() {


    function if_update_multi() {
        if (document.getElementById("multi-timer")) {
            let calendars = JSON.parse($("#multi-timer").data('calendar'));
            let _clicks = 0;
            update_multi();
            //получаем данные
            // рисуем таблицу


            //нажата ячейка
            $(".td-time").on("click", function () {
                _clicks++;
                if (_clicks === 1) {

                }
                if (_clicks === 2) {

                }

                if (_clicks > 2) {

                }
            });

            ///


            function update_multi() {
                let _t = "";
                _t = "<table class=\"multi-timer\">";
                _t += "<tr>99";
                console.log(calendars);

                _t += "</tr>";
                _t += "</table>";
                $("#multi-timer").html(_t);
            }


        }
        ;
    }
});