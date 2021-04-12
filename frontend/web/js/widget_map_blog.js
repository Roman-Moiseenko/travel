ymaps.ready(init);

function init() {
    let myMapView;
    if (document.getElementById("widget-map-blog")) {
        let slug = $('#widget-map-blog').data('slug');

        myMapView = new ymaps.Map(document.getElementById("widget-map-blog"), {
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

        $.post('/post/widget-map', {slug: slug}, function (data) {

            let objectManager = new ymaps.ObjectManager({
                // Чтобы метки начали кластеризоваться, выставляем опцию.
                clusterize: true,
                // ObjectManager принимает те же опции, что и кластеризатор.
                gridSize: 32,
                clusterDisableClickZoom: true
            });
            objectManager.objects.options.set('preset', 'islands#redDotIcon');
            objectManager.clusters.options.set('preset', 'islands#redClusterIcons');
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
                            "clusterCaption": '<a href="' + _result[i].link + '" style="color: rgba(41,78,107,0.93);" target="_blank">' + _result[i].name + '</a>',
                            "hintContent": '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 18px;"> <p>' +
                                _result[i].name + '</p></span>'
                        }
                    };
                objectManager.add(obj);
            }
        });
    }
}
