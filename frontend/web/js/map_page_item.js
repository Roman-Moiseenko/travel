$(document).ready(function () {
    let check_if_load = 0;
    let item_id;
    let page_id;
    let myMapView;
    let data_zoom, coord_la, coord_lo, _name;


    $(document).on('click', '.loader_ymap', function () {
        data_zoom = $(this).data('zoom');
        if (data_zoom === undefined) data_zoom = 10;
        coord_la = $(this).data('latitude');
        coord_lo = $(this).data('longitude');
        item_id = $(this).data('item');
        _name = $(this).data('name');

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
        if (document.getElementById("map-item")) {
            coords = [coord_la, coord_lo];
            myMapView = new ymaps.Map(document.getElementById("map-item"), {
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
                    _name + '</p></span></div>'
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
            console.log('page: ' + page_id + ', item:' + item_id);
            $.post('/moving/moving/get-items', {
                //TODO перезагрузка параемтров
                page_id: page_id,
                item_id: item_id,

            }, function (data) {
                console.log(data);

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
                                _result[i].title + '</p></span></div>',
                            /* <a class="map-close" href="#i-' + _result[i].id + '" style="font-size: 16px;  color: rgba(41,78,107,0.93);"> </a> */
                            balloonContent: '<p>' + _result[i].title + '</p>' +
                                '<p><img src="' + _result[i].photo + '"></p>',
                        }, {
                           // iconLayout: 'default#image',
                            //iconImageHref: '/images/geo_all.png',
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
        page_id = $('#data-page').data('id');
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


