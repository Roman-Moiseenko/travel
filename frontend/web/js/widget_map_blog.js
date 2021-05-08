$(document).ready(function () {
    let myMapView;

    if (document.getElementById("widget-map-blog")) {
        let _init = 0;
        let _api = $('#ymap-params').data('api');
        let _lang = $('#ymap-params').data('lang');

        console.log('1');
        $(document).scroll(function () {
            if (_init === 1) return;
            _init = 1;
            setTimeout(() => {
                console.log('2');
                loadScript("https://api-maps.yandex.ru/2.1/?apikey=" + _api + "&lang=" + _lang, function () {
                    console.log('3');
                    ymaps.load(init);
                });
            }, 2000);

        });

    }

    function init() {
        let slug = $('#widget-map-blog').data('slug');
        let zoom = $('#widget-map-blog').data('zoom');
        if (zoom === undefined) zoom = 10;
        myMapView = new ymaps.Map(document.getElementById("widget-map-blog"), {
            center: [54.70685185623284, 20.509538208007516],
            zoom: zoom
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
        //myMapView.setCenter([54.70685185623284, 20.509538208007516], zoom);

        $.post('/post/widget-map', {slug: slug}, function (data) {

            let objectManager = new ymaps.ObjectManager({
                clusterize: true,
                gridSize: 32,
                clusterDisableClickZoom: true
            });
            objectManager.objects.options.set('preset', 'islands#redDotIcon');
            objectManager.clusters.options.set('preset', 'islands#redClusterIcons');
            myMapView.geoObjects.add(objectManager);
            //console.log(data);
            //return;

            let _result = JSON.parse(data);
            myMapView.setCenter([_result[0].latitude, _result[0].longitude]);

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
                            "balloonContentHeader": '<a href="' + _result[i].link + '" style="font-size: 16px;  color: rgba(41,78,107,0.93);" target="_blank" style="width: 200px">' + _result[i].caption + '</a>',
                            "balloonContentBody": '<p><img src="' + _result[i].photo + '"></p>',
                            "balloonContentFooter": '<p style="width: 200px"><i class="fas fa-map-marker-alt"></i> ' + _result[i].address + '</p>',
                            "clusterCaption": '<a href="' + _result[i].link + '" style="color: rgba(41,78,107,0.93);" target="_blank">' + _result[i].caption + '</a>',
                            "hintContent": '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 18px;"> <p>' +
                                _result[i].caption + '</p></span>'
                        }
                    };
                objectManager.add(obj);
            }
        });
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