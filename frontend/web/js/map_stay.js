$(document).ready(function () {
    let check_if_load = 0;
    let stay_id;
    let date_from;
    let date_to;
    let guest;
    let children;
    let children_age = new Array(8);
    let myMapView;

    $(document).on('click', '.loader_ymap', function () {
        $('#map-stay').empty();
        if (check_if_load === 0) {
            check_if_load = 1;
            let _api = $('#ymap-params').data('api');
            let _lang = $('#ymap-params').data('lang');
            loadScript("https://api-maps.yandex.ru/2.1/?apikey=" + _api + "&lang=" + _lang, function () {
                loadPanel();
                ymaps.ready(['Panel']).then(init);
            });
        }
        if (check_if_load === 1) {
            if (myMapView != null) {
                myMapView.destroy();
                myMapView = null;
                $('#map-stay').empty();
                loadPanel();
                ymaps.ready(['Panel']).then(init);
            }
        }
    });

    function init() {
        let myPlacemark, coords;
        loadParams();
        if (document.getElementById("map-stay")) {
            let data_zoom = $('#map-stay').data('zoom');
            if (data_zoom === undefined) data_zoom = 10;
            let coord_la = $('#map-stay').data('latitude');
            let coord_lo = $('#map-stay').data('longitude');
            let _name = $('#map-stay').data('name');
            let _cost = $('#map-stay').attr('data-cost');
            coords = [coord_la, coord_lo];

            myMapView = new ymaps.Map(document.getElementById("map-stay"), {
                center: [coord_la, coord_lo],
                zoom: data_zoom
            }, {
                restrictMapArea: [
                    [54.256, 19.586],
                    [55.317, 22.975]
                ]
            });

            myMapView.controls.remove('searchControl');
            myMapView.controls.remove('trafficControl');
            myMapView.controls.remove('geolocationControl');
            myMapView.controls.remove('fullscreenControl');
            myMapView.setCenter(coords, data_zoom);

            myPlacemark = new ymaps.Placemark(coords, {
                //TODO Сделать красоту
                hintContent: '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 18px;"> <p>' +
                    _name + '</p></span> <span style="color: rgba(41,78,107,0.93); font-size: 20px;">' + _cost + '</span></div>'
            }, {
                iconLayout: 'default#image',
                iconImageHref: '/images/geo_main.png',
                iconImageSize: [25, 40],
                iconImageOffset: [-12, -40],
                draggable: false
            });
            myMapView.geoObjects.add(myPlacemark);
            let panel = new ymaps.Panel();
            myMapView.controls.add(panel, {
                float: 'left'
            });
            $.post('/stays/stays/get-maps', {
                //TODO перезагрузка параемтров
                stay_id: stay_id,
                date_from: date_from,
                date_to: date_to,
                guest: guest,
                children: children,
                children_age: children_age
            }, function (data) {
                // Создадим коллекцию геообъектов.
                let collection = new ymaps.GeoObjectCollection(null, {
                    // Запретим появление балуна.
                    hasBalloon: false,
                });

                let _result = JSON.parse(data);
                for (let i = 0; i < _result.length; i++) {
                    collection
                        .add(new ymaps.Placemark([_result[i].latitude, _result[i].longitude], {
                            hintContent: '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 18px;"> <p>' +
                                _result[i].name + '</p></span> <span style="color: rgba(41,78,107,0.93); font-size: 20px;">' + _result[i].cost + '</span></div>',
                            balloonContent: '<p><a href="' + _result[i].link + '" style="font-size: 16px;  color: rgba(41,78,107,0.93);">' + _result[i].name + '</a></p>' +
                                '<p><img src="' + _result[i].photo + '"></p>' +
                                '<p>' + _result[i].description + '</p>' + '<p style="font-size: 22px; color: rgba(41,78,107,0.93);">' + _result[i].cost + '</p>',
                        }, {
                            iconLayout: 'default#image',
                            iconImageHref: '/images/geo_all.png',
                            iconImageSize: [25, 40],
                            iconImageOffset: [-12, -40],
                            draggable: false
                        }));
                    collection.events.add('click', function (e) {
                        // Получим ссылку на геообъект, по которому кликнул пользователь.
                        var target = e.get('target');
                        // Зададим контент боковой панели.
                        panel.setContent(target.properties.get('balloonContent'));

                    });

                }
                myMapView.geoObjects.add(collection);

            });
            //TODO
            /*
                     var marker = new ymaps.Placemark(
                     //координаты
                     {
                        ...
                      },
                             {
                        hasBalloon: false,
                        href: 'http://google.ru/'
                        ...
                      }
                             );
                     marker.events.add('click', function (e) {
                      location = e.get('target').options.get('href');
                    });


            */
            //TODO !
            //Пост запрос на массив объектов схожих по параметрам
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

    function loadParams() {
        stay_id = $('#data-stay').data('id');
        date_from = $('#data-stay').attr('data-date-from');
        date_to = $('#data-stay').attr('data-date-to');
        guest = $('#data-stay').attr('data-guest');
        children = $('#data-stay').attr('data-children');
        children_age = [
            $('#data-stay').attr('data-children-age0'),
            $('#data-stay').attr('data-children-age1'),
            $('#data-stay').attr('data-children-age2'),
            $('#data-stay').attr('data-children-age3'),
            $('#data-stay').attr('data-children-age4'),
            $('#data-stay').attr('data-children-age5'),
            $('#data-stay').attr('data-children-age6'),
            $('#data-stay').attr('data-children-age7'),
        ];
    }

    function loadPanel() {
        ymaps.modules.define('Panel', [
            'util.augment',
            'collection.Item'
        ], function (provide, augment, item) {
            // Создаем собственный класс.
            var Panel = function (options) {
                Panel.superclass.constructor.call(this, options);
            };
            // И наследуем его от collection.Item.
            augment(Panel, item, {
                onAddToMap: function (map) {
                    Panel.superclass.onAddToMap.call(this, map);
                    this.getParent().getChildElement(this).then(this._onGetChildElement, this);
                    // Добавим отступы на карту.
                    // Отступы могут учитываться при установке текущей видимой области карты,
                    // чтобы добиться наилучшего отображения данных на карте.
                    map.margin.addArea({
                        top: 0,
                        left: '100px',
                        width: '250px',
                        height: '100%'
                    })
                },

                onRemoveFromMap: function (oldMap) {
                    if (this._$control) {
                        this._$control.remove();
                    }
                    Panel.superclass.onRemoveFromMap.call(this, oldMap);
                },

                _onGetChildElement: function (parentDomContainer) {
                    // Создаем HTML-элемент с текстом.
                    // По-умолчанию HTML-элемент скрыт.
                    this._$control = $('<div class="customControl-map-panel"><div class="content-map-panel"></div><div class="closeButton-map-panel"></div></div>').appendTo(parentDomContainer);
                    this._$content = $('.content-map-panel');
                    // При клике по крестику будем скрывать панель.
                    $('.closeButton-map-panel').on('click', this._onClose);
                },
                _onClose: function () {
                    $('.customControl-map-panel').css('display', 'none');
                },
                // Метод задания контента панели.
                setContent: function (text) {
                    // При задании контента будем показывать панель.
                    this._$control.css('display', 'flex');
                    this._$content.html(text);
                }
            });

            provide(Panel);
        });
    }
});


