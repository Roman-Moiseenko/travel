ymaps.ready(init);

function init() {
    let  myPlacemark, coords;

    if (document.getElementById("map-stay")) {
        let data_zoom = $('#map-stay').data('zoom');
        console.log(data_zoom);
        if (data_zoom === undefined) data_zoom = 10;
        let coord_la = $('#map-stay').data('latitude');
        let coord_lo = $('#map-stay').data('longitude');
        coords = [coord_la, coord_lo];

        var myMapView = new ymaps.Map(document.getElementById("map-stay"), {
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
        myMapView.container.enterFullscreen();
        let MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #6cc77f; font-weight: bold; background-color: white">Название Жилья. ЦЕНА. Фото!</div>'
        ),
        myPlacemark = new ymaps.Placemark(coords, {
            //TODO Сделать красоту
            hintContent: '<span style="color: red; height: 50px;"> <p>Название Жилья. ЦЕНА. Фото!</p></span>'
            //balloonContent: ,
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
            iconImageHref: '/images/geo_main.png', // 'images/geo_main.png',
            // Размеры метки.
            iconImageSize: [25, 40],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-12, -40],
//            preset: 'islands#violetDotIconWithCaption',
           // iconContentLayout: MyIconContentLayout,
            draggable: false
        });
        //TODO
        /** ссылка по метке
         *
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

        myMapView.geoObjects.add(myPlacemark);
        // if ($('#' + suggest).val() === '')
        {
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

            });
        }
        //TODO !
        //Пост запрос на массив объектов схожих по параметрам
    }
}