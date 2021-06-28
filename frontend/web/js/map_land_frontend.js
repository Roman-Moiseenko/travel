//ymaps.ready(init);
$(document).ready(function () {
    let mapLand;

    if (document.getElementById("map-land")) {
        let _init = 0;
        let _api = $('#ymap-params').data('api');
        let _lang = $('#ymap-params').data('lang');
        loadScript("https://api-maps.yandex.ru/2.1/?apikey=" + _api + "&lang=" + _lang, function () {
            ymaps.load(init);
        });
       /* $(document).ready(function () {
            if (_init === 1) return;
            _init = 1;
            setTimeout(() => {
                loadScript("https://api-maps.yandex.ru/2.1/?apikey=" + _api + "&lang=" + _lang, function () {
                    ymaps.load(init);
                });
            }, 1000);
        });*/
    }

    function init() {
        if (document.getElementById("map-land")) {
            mapLand = new ymaps.Map(document.getElementById("map-land"), {
                center: [54.74639455404805, 20.537801017695948],
                zoom: 10
            }, {
                restrictMapArea: [
                    [54.256, 19.586],
                    [55.317, 22.975]
                ]
            });
            mapLand.controls.remove('searchControl');
            mapLand.controls.remove('trafficControl');
            mapLand.controls.remove('geolocationControl');

            loadLands();

            function loadLands() {
                //Удаляем все нарисованные объекты
                mapLand.geoObjects.removeAll();
                $.post('/land/map/get-lands', {}, function (data) {
                    let collection = new ymaps.GeoObjectCollection(null, {});
                    let _result = JSON.parse(data);
                    for (let i = 0; i < _result.length; i++) {
                        collection.add(
                            new ymaps.Polygon(
                                [_result[i].coords]
                                , {
                                    hintContent: '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 16px;">' +
                                        _result[i].name + '</span></div>' + '<p style="font-size: 14px; color: rgba(41,78,107,0.93);">' + _result[i].min_price + ' руб./сотка</p>' +
                                        '<p><span style="font-size: 12px; color: rgba(41,78,107,0.93);">' + _result[i].count + ' участков</span></p>',
                                    balloonContent:
                                        '<p>Позвонить: +7-911-471-0701</p>',
                                }, {
                                    // Задаем опции геообъекта.
                                    // Цвет заливки.
                                    fillColor: '#00FF0066',
                                    // Ширина обводки.
                                    strokeWidth: 1
                                })
                        );
                    }
                    mapLand.geoObjects.add(collection);
                });
            }

        }

    }

    function loadScript(url, callback) {
        let script = document.createElement("script");
        if (script.readyState) {  //IE
            script.onreadystatechange = function () {
                if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  //Другие браузеры
            script.onload = function () {
                callback();
            };
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    }
});