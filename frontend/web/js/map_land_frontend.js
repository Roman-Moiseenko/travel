//ymaps.ready(init);
$(document).ready(function () {
    let mapLand;

    if (document.getElementById("map-land") || document.getElementById("map-lands")) {
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
            let id = $('#map-land').data('id');
            //Удаляем все нарисованные объекты

            $.post('/realtor/map/get-land', {id: id}, function (data) {
                //mapLand.geoObjects.removeAll();
                let _result = JSON.parse(data);
                console.log(_result);
                let x = _result.x;
                let y = _result.y;
                mapLand = new ymaps.Map(document.getElementById("map-land"), {
                    center: [x, y],
                    zoom: 16
                }, {
                    restrictMapArea: [
                        [54.256, 19.586],
                        [55.317, 22.975]
                    ]
                });
                mapLand.controls.remove('searchControl');
                mapLand.controls.remove('trafficControl');
                mapLand.controls.remove('geolocationControl');

                let collection = new ymaps.GeoObjectCollection(null, {});
                collection.add(
                    new ymaps.Polygon(
                        [_result.points]
                        , {
                            hintContent: '',
                            balloonContent:
                                '<p>' + _result.name + '</p>',
                        }, {
                            // Задаем опции геообъекта.
                            // Цвет заливки.
                            fillColor: '#00FF0066',
                            // Ширина обводки.
                            strokeWidth: 1
                        })
                );
                mapLand.geoObjects.add(collection);
            });
        }

        if (document.getElementById("map-lands")) {
            mapLand = new ymaps.Map(document.getElementById("map-lands"), {
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
            //Удаляем все нарисованные объекты
            // mapLand.geoObjects.removeAll();
            $.post('/realtor/map/get-lands', {}, function (data) {
                let _result = JSON.parse(data);
                for (let i = 0; i < _result.length; i++) {
                    let x = _result[i].coords.x;
                    let y = _result[i].coords.y;
                    mapLand.geoObjects.add(new ymaps.Placemark([x, y], {
                        iconContent: '',
                        iconCaption: _result[i].name,
                        balloonContent: '<div class="row"><div class="col-6"><img src="'+ _result[i].photo + '" width="160" height="160"/></div> ' +
                            '<div class="col-6"><div><p style="font-weight: 600; color: #0b3e6f; font-size: 22px;">' + _result[i].name + '</p></div>' +
                            '<div><p style="font-size: 20px">Инвестиции:<br>' + _result[i].cost + '</p></div>'+
                            '<div><p style="font-size: 16px"><a href="' + _result[i].url + '" TARGET="_blank">Перейти на страницу участка</a></p></div></div> </div>'
                    }, {
                        preset: 'islands#violetIcon',//'islands#violetDotIconWithCaption',
                        draggable: false
                    }));
                }
            });
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