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

            });
        }
        //TODO !
        //Пост запрос на массив объектов схожих по параметрам
    }
}