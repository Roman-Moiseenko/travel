$(document).ready(function () {
    let myMapView;
    let check_if_load = 0;

    $(document).on('click', '.loader_ymap', function () {
        $('#map-foods').empty();
        if (check_if_load === 0) {
            check_if_load = 1;
            let _api = $('#ymap-params').data('api');
            let _lang = $('#ymap-params').data('lang');
            loadScript("https://api-maps.yandex.ru/2.1/?apikey=" + _api + "&lang=" + _lang, function () {
                //loadPanel();
                ymaps.load(init);
                //ymaps.ready(['Panel']).then(init);
            });
        }
        if (check_if_load === 1) {
            if (myMapView != null) {
                myMapView.destroy();
                myMapView = null;
                $('#map-foods').empty();
                //loadPanel();
                ymaps.load(init);//ready(['Panel']).then(init);
            }
        }
    });

    function init() {
        if (document.getElementById("map-foods")) {

            myMapView = new ymaps.Map(document.getElementById("map-foods"), {
                center: [54.74639455404805, 20.537801017695948],
                zoom: 10
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
            myMapView.setCenter([54.74639455404805, 20.537801017695948], 10);

            //let panel = new ymaps.Panel();
           /* myMapView.controls.add(panel, {
                float: 'left'
            });
*/
            let _get = getUrlVars();
            $.post('/food/map-foods', {kitchen_id: _get.kitchen_id, category_id: _get.category_id, city: _get.city}, function (data) {

                let objectManager = new ymaps.ObjectManager({
                    // Чтобы метки начали кластеризоваться, выставляем опцию.
                    clusterize: true,
                    // ObjectManager принимает те же опции, что и кластеризатор.
                    gridSize: 32,
                    clusterDisableClickZoom: true
                });
                objectManager.objects.options.set('preset', 'islands#greenDotIcon');
                objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
                myMapView.geoObjects.add(objectManager);
                //console.log(data);
                let _result = JSON.parse(data);
                let obj = {};
                obj.type = "FeatureCollection";
                obj.features = [];
                for (let i = 0; i < _result.length; i++) {
                    obj.features[i] =
                        {
                            "type": "Feature",
                            "id": i,
                            "geometry": {"type": "Point", "coordinates": [_result[i].latitude, _result[i].longitude]},
                            "properties": {
                                "balloonContentHeader": '<a href="' + _result[i].link + '" style="font-size: 16px;  color: rgba(41,78,107,0.93);" target="_blank">' + _result[i].name + '</a>',
                                "balloonContentBody": '<p><img src="' + _result[i].photo + '"></p>',
                                "balloonContentFooter": '<p><i class="fas fa-map-marker-alt"></i> ' + _result[i].address + '</p><p><i class="fas fa-phone-alt"></i> ' + _result[i].phone + '</p>',
                                "clusterCaption": '<strong>' + _result[i].name + '</strong>',
                                "hintContent": '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 18px;"> <p>' +
                                    _result[i].name + '</p></span>'
                            }
                        };
                    objectManager.add(obj);
                }
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

   /* function loadPanel() {
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
    }*/

    function getUrlVars()
    {
        let vars = [], hash;
        let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            hash[0] = hash[0].replace('%5B', '[');
            hash[0] = hash[0].replace('%5D', ']');
            hash[0] = hash[0].substring(hash[0].indexOf('[') + 1, hash[0].indexOf(']'))
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
});


