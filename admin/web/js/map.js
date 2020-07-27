ymaps.ready(init);

function init() {
    var myPlacemark;
    let suggest = 'bookingaddressform-address';
    let latitude = 'bookingaddressform-latitude';
    let longitude = 'bookingaddressform-longitude';

    let coord_la = $('#' + latitude).val();
    let coord_lo = $('#' + longitude).val();
    if (coord_la === '' || coord_lo === '') {
        var new_coord = true;
        coord_la = 54.74639455404805;
        coord_lo = 20.537801017695948;
    }
    var myMap = new ymaps.Map('map', {
        center: [coord_la, coord_lo],
        zoom: 10
    }, {
        restrictMapArea: [
            [54.256,19.586],
            [55.317,22.975]
        ]
    });
    if (!new_coord) {
        var coords = [coord_la, coord_lo];
        setData(coords);
        myMap.setCenter(coords, 12);
    }

    myMap.controls.remove('searchControl');
    myMap.controls.remove('trafficControl');
    myMap.controls.remove('geolocationControl');

    var suggestView = new ymaps.SuggestView(suggest);
   // myMap.controls.add(suggestView);
    suggestView.events.add('select', function () {
        geocode();
    });
    // Слушаем клик на карте.
    myMap.events.add('click', function (e) {
        var coords = e.get('coords');
        setData(coords);

    });

    function setData(coords) {
        // Если метка уже создана – просто передвигаем ее.
        if (myPlacemark) {
            myPlacemark.geometry.setCoordinates(coords);
        }
        // Если нет – создаем.
        else {
            myPlacemark = createPlacemark(coords);
            myMap.geoObjects.add(myPlacemark);
            // Слушаем событие окончания перетаскивания на метке.
            myPlacemark.events.add('dragend', function () {
                coords = myPlacemark.geometry.getCoordinates();
                getAddress(coords);
                fillInput(coords);
            });
        }
        getAddress(coords);
        fillInput(coords);
    }

    function fillInput(coords) {
        $('#' + latitude).val(coords[0]);
        $('#' + longitude).val(coords[1]);
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            $('#' + suggest).val(firstGeoObject.getAddressLine());
        });
    }
    // Создание метки.
    function createPlacemark(coords) {
        return new ymaps.Placemark(coords, {
            iconCaption: 'поиск...'
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: true
        });
    }

    // Определяем адрес по координатам (обратное геокодирование).
    function getAddress(coords) {
        myPlacemark.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            myPlacemark.properties
                .set({
                    // Формируем строку с данными об объекте.
                    iconCaption: '',
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: firstGeoObject.getAddressLine()
                });
        });
    }

    function showResult(obj) {
        // Удаляем сообщение об ошибке, если найденный адрес совпадает с поисковым запросом.
        $('#'+suggest).removeClass('input_error');
        $('#notice').css('display', 'none');

        var mapContainer = $('#map'),
            bounds = obj.properties.get('boundedBy'),
            // Рассчитываем видимую область для текущего положения пользователя.
            mapState = ymaps.util.bounds.getCenterAndZoom(
                bounds,
                [mapContainer.width(), mapContainer.height()]
            ),
            // Сохраняем полный адрес для сообщения под картой.
            address = [obj.getCountry(), obj.getAddressLine()].join(', '),
            // Сохраняем укороченный адрес для подписи метки.
            shortAddress = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
        // Убираем контролы с карты.
        mapState.controls = [];
        // Создаём карту.
        createMap(mapState, shortAddress);

        // Выводим сообщение под картой.
        showMessage(address);
    }
    function geocode() {
        // Забираем запрос из поля ввода.
        var request = $('#'+suggest).val();

        // Геокодируем введённые данные.
        ymaps.geocode(request).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            var coords = firstGeoObject.geometry.getCoordinates();
            setData(coords);
            myMap.setCenter(coords);

        }, function (e) {
            console.log(e);
        });

    }
    function createMap(state, caption) {
        // Если карта еще не была создана, то создадим ее и добавим метку с адресом.
        if (!map) {
            map = new ymaps.Map('map', state);
            placemark = new ymaps.Placemark(
                map.getCenter(), {
                    iconCaption: caption,
                    balloonContent: caption
                }, {
                    preset: 'islands#redDotIconWithCaption'
                });
            map.geoObjects.add(placemark);
            // Если карта есть, то выставляем новый центр карты и меняем данные и позицию метки в соответствии с найденным адресом.
        } else {
            map.setCenter(state.center, state.zoom);
            placemark.geometry.setCoordinates(state.center);
            placemark.properties.set({iconCaption: caption, balloonContent: caption});
        }
    }
    function showError(message) {
        $('#notice').text(message);
        $('#'+suggest).addClass('input_error');
        $('#notice').css('display', 'block');
        // Удаляем карту.
        if (map) {
            map.destroy();
            map = null;
        }
    }
    function showMessage(message) {
        $('#messageHeader').text('Данные получены:');
        $('#message').text(message);
    }
}
