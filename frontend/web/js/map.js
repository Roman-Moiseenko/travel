ymaps.ready(init);

function init() {
    var myPlacemark, myPlacemark2, myPlacemark3, coords, coords2, coords3;
    let suggest = 'bookingaddressform-address';
    let latitude = 'bookingaddressform-latitude';
    let longitude = 'bookingaddressform-longitude';


    if (document.getElementById("map-car-view")) {
        let count_ = $('#count-points').data('count');
        let x, y, t;
        let center_
        if (count_ !== 0) {
            center_ = [Number($('#latitude-1').val()), Number($('#longitude-1').val())];
        } else {
            center_ = [54.74639455404805, 20.537801017695948];
        }
        let mapCarView = new ymaps.Map(document.getElementById("map-car-view"), {
            center: center_,
            zoom: 10
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });
        mapCarView.controls.remove('searchControl');
        mapCarView.controls.remove('trafficControl');
        mapCarView.controls.remove('geolocationControl');
        //Проходим по элементам, если есть список, грузим в карту

        for (let i = 0; i < count_; i++) {
            t = $('#address-' + (i+1)).val();
            x = $('#latitude-' + (i+1)).val();
            y = $('#longitude-' + (i+1)).val();
            mapCarView.geoObjects.add(new ymaps.Placemark([x, y], {
                iconContent: i+1,
                iconCaption: '',
                balloonContent: t
            }, {
                preset: 'islands#violetIcon',//'islands#violetDotIconWithCaption',
                draggable: false
            }));
        }
    }

    if (document.getElementById("map")) {
        let data_zoom = $('this').attr('data-zoom');
        if (data_zoom === undefined) data_zoom = 10;
        var myMap = new ymaps.Map(document.getElementById("map"), {
            center: [54.74639455404805, 20.537801017695948],
            zoom: data_zoom
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });
        myMap.controls.remove('searchControl');
        myMap.controls.remove('trafficControl');
        myMap.controls.remove('geolocationControl');

        if ($('#' + latitude).val() !== '') {
            coords = [$('#' + latitude).val(), $('#' + longitude).val()];
            setData(coords);
            myMap.setCenter(coords);
        }

        var suggestView = new ymaps.SuggestView(suggest);
        suggestView.events.add('select', function () {
            geocode();
        });
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');
            setData(coords);
        });
    }
    if (document.getElementById("map-2")) {
        var myMap2 = new ymaps.Map(document.getElementById("map-2"), {
            center: [54.74639455404805, 20.537801017695948],
            zoom: 10
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });
        myMap2.controls.remove('searchControl');
        myMap2.controls.remove('trafficControl');
        myMap2.controls.remove('geolocationControl');

        if ($('#' + latitude + '-2').val() !== '') {
            coords2 = [$('#' + latitude + '-2').val(), $('#' + longitude + '-2').val()];
            setData2(coords2);
            myMap2.setCenter(coords2);
        }
        var suggestView2 = new ymaps.SuggestView(suggest + '-2');
        suggestView2.events.add('select', function () {
            geocode2();
        });
        myMap2.events.add('click', function (e) {
            var coords2 = e.get('coords');
            setData2(coords2);
        });
    }

    if (document.getElementById("map-view")) {
        let data_zoom = $('#map-view').attr('data-zoom');
        //
        if (data_zoom === undefined) data_zoom = 10;
        let coord_la = $('#' + latitude).val();
        let coord_lo = $('#' + longitude).val();
        coords = [coord_la, coord_lo];
        //alert(data_zoom);
        var myMapView = new ymaps.Map(document.getElementById("map-view"), {
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

        myMapView.setCenter(coords, 12);
        myPlacemark = new ymaps.Placemark(coords, {
            iconCaption: ''
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: false
        });
        myMapView.geoObjects.add(myPlacemark);
       // if ($('#' + suggest).val() === '')
        {
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                $('#' + suggest).val(firstGeoObject.getAddressLine());
                $('#address').html(firstGeoObject.getAddressLine());
            });
        }
    }

    if (document.getElementById("map-view-2")) {

        let coord_la2 = $('#' + latitude + '-2').val();
        let coord_lo2 = $('#' + longitude + '-2').val();
        coords2 = [coord_la2, coord_lo2];
        //alert(coords2);
        var myMapView2 = new ymaps.Map(document.getElementById("map-view-2"), {
            center: [coord_la2, coord_lo2],
            zoom: 10
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });

        myMapView2.controls.remove('searchControl');
        myMapView2.controls.remove('trafficControl');
        myMapView2.controls.remove('geolocationControl');


        myMapView2.setCenter(coords2, 12);
        myPlacemark2 = new ymaps.Placemark(coords2, {
            iconCaption: ''
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: false
        });
        myMapView2.geoObjects.add(myPlacemark2);
       // if ($('#' + suggest + '-2').val() === '')
        {
            ymaps.geocode(coords2).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                $('#' + suggest + '-2').val(firstGeoObject.getAddressLine());
                $('#address-2').html(firstGeoObject.getAddressLine());
            });
        }
    }

    if (document.getElementById("map-view-3")) {

        let coord_la3 = $('#' + latitude + '-3').val();
        let coord_lo3 = $('#' + longitude + '-3').val();
        coords3 = [coord_la3, coord_lo3];
        //alert(coords2);
        var myMapView3 = new ymaps.Map(document.getElementById("map-view-3"), {
            center: [coord_la3, coord_lo3],
            zoom: 10
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });

        myMapView3.controls.remove('searchControl');
        myMapView3.controls.remove('trafficControl');
        myMapView3.controls.remove('geolocationControl');


        myMapView3.setCenter(coords3, 12);
        myPlacemark3 = new ymaps.Placemark(coords3, {
            iconCaption: ''
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: false
        });
        myMapView3.geoObjects.add(myPlacemark3);
       // if ($('#' + suggest + '-3').val() === '')
        {
            ymaps.geocode(coords3).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                $('#' + suggest + '-3').val(firstGeoObject.getAddressLine());
                $('#address-3').html(firstGeoObject.getAddressLine());
            });
        }
    }

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
    function setData2(coords2) {
        // Если метка уже создана – просто передвигаем ее.
        if (myPlacemark2) {
            myPlacemark2.geometry.setCoordinates(coords2);
        }
        // Если нет – создаем.
        else {
            myPlacemark2 = createPlacemark(coords2);
            myMap2.geoObjects.add(myPlacemark2);
            // Слушаем событие окончания перетаскивания на метке.
            myPlacemark2.events.add('dragend', function () {
                coords2 = myPlacemark2.geometry.getCoordinates();
                getAddress2(coords2);
                fillInput2(coords2);
            });
        }
        getAddress2(coords2);
        fillInput2(coords2);
    }

    function fillInput(coords) {
        $('#' + latitude).val(coords[0]);
        $('#' + longitude).val(coords[1]);
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            $('#' + suggest).val(firstGeoObject.getAddressLine());
        });
    }
    function fillInput2(coords2) {
        $('#' + latitude + '-2').val(coords2[0]);
        $('#' + longitude + '-2').val(coords2[1]);
        ymaps.geocode(coords2).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            $('#' + suggest + '-2').val(firstGeoObject.getAddressLine());
        });
    }

    function fillInput3(coords3) {
        $('#' + latitude + '-3').val(coords3[0]);
        $('#' + longitude + '-3').val(coords3[1]);
        ymaps.geocode(coords3).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            $('#' + suggest + '-3').val(firstGeoObject.getAddressLine());
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
    function getAddress2(coords2) {
        myPlacemark2.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords2).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            myPlacemark2.properties
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
    function geocode2() {
        // Забираем запрос из поля ввода.
        var request = $('#'+suggest + '-2').val();

        // Геокодируем введённые данные.
        ymaps.geocode(request).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            var coords2 = firstGeoObject.geometry.getCoordinates();
            setData2(coords2);
            myMap2.setCenter(coords2);

        }, function (e) {
           // console.log(e);
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
