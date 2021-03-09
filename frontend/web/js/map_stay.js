ymaps.ready(init);

function init() {
    let  myPlacemark, coords;
    let stay_id = $('#data-stay').data('id');
    let date_from = $('#data-stay').data('date-from');
    let date_to = $('#data-stay').data('date-to');
    let guest = $('#data-stay').data('guest');
    let children = $('#data-stay').data('children');
    let children_age = new Array(8);
    children_age = [
        $('#data-stay').data('children-age1'),
        $('#data-stay').data('children-age2'),
        $('#data-stay').data('children-age3'),
        $('#data-stay').data('children-age4'),
        $('#data-stay').data('children-age5'),
        $('#data-stay').data('children-age6'),
        $('#data-stay').data('children-age7'),
        $('#data-stay').data('children-age8'),
    ];




    //console.log(children_age);
    if (document.getElementById("map-stay")) {
        let data_zoom = $('#map-stay').data('zoom');
        if (data_zoom === undefined) data_zoom = 10;
        let coord_la = $('#map-stay').data('latitude');
        let coord_lo = $('#map-stay').data('longitude');
        let _name = $('#map-stay').data('name');
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

        myPlacemark = new ymaps.Placemark(coords, {
            //TODO Сделать красоту
            hintContent: '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 18px;"> <p>' +_name + '</p></span> <span style="color: rgba(41,78,107,0.93); font-size: 20px;">00 000 РУБ.</span></div>'
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
        myMapView.geoObjects.add(myPlacemark);
        //
        $.post('/stays/stays/get-maps', {stay_id: stay_id, date_from:date_from, date_to: date_to, guest: guest, children: children, children_age: children_age}, function (data) {
            //console.log(data);
            let _result = JSON.parse(data);
            console.log(_result);

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



        //TODO !
        //Пост запрос на массив объектов схожих по параметрам
    }
}