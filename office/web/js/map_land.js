ymaps.ready(init);

function init() {
    let land_name, land_slug, land_cost, land_id;
    let newPolygon;
    const CONTROLLER_LANDS ='/realtor/map/';


    if (document.getElementById("map-land")) {
        let mapLand = new ymaps.Map(document.getElementById("map-land"), {
            center: [54.74639455404805, 20.537801017695948],
            zoom: 10
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });
        mapLand.controls.remove('searchControl');
        mapLand.controls.remove('trafficControl');
        mapLand.controls.remove('geolocationControl');

        loadLands();


        $('body').on('click', '#start-land', function () {
            land_name = $('#land-name').val();
            land_slug = $('#land-slug').val();
            land_cost = $('#land-cost').val();
            land_id = $('#start-land').attr('data-id');
            console.log(land_id);
            if (Number(land_id) > 0) {
                $.post(CONTROLLER_LANDS + 'update-land', {
                    name: land_name,
                    slug: land_slug,
                    cost: land_cost,
                    id: land_id
                }, function (data) {
                    console.log(data);
                    loadLands();
                })
            } else {
                $('#caption-edit').html('Рисуем новый участок <span style="font-weight: 600; ">' + land_name + '</span>');
                $('#stop-land').show();

                newPolygon = new ymaps.Polygon([], {}, {
                    editorDrawingCursor: "crosshair",
                    editorMaxPoints: 25,
                    strokeOpacity: 1,
                    strokeWidth: 1
                });
                mapLand.geoObjects.add(newPolygon);
                let stateMonitor = new ymaps.Monitor(newPolygon.editor.state);
                stateMonitor.add("drawing", function (newValue) {
                    newPolygon.options.set("strokeColor", newValue ? '#FF0000' : '#0000FF');
                });
                newPolygon.editor.startDrawing();
            }
        });

        $('body').on('click', '#stop-land', function () {
            $('#caption-edit').html('');
            $('#stop-land').hide();

            newPolygon.editor.stopEditing();
            let coords = newPolygon.geometry.getCoordinates();

            $.post(CONTROLLER_LANDS + 'create-land', {
                name: land_name,
                slug: land_slug,
                cost: land_cost,
                coords: coords[0]
            }, function (data) {
                console.log(data);
                loadLands();
            });
        });

        $('body').on('click', '#add-land', function () {
            $('#land-name').val('');
            $('#land-slug').val('');
            $('#land-cost').val('');
            $('#start-land').attr('data-id', 0);
            $('#start-land').html('Начать рисовать');
        });

        $('body').on('click', '#edit-land', function () {
            $('#land-name').val($(this).data('name'));
            $('#land-slug').val($(this).data('slug'));
            $('#land-cost').val($(this).data('cost'));
            $('#start-land').attr('data-id', $(this).data('id'));
            $('#start-land').html('Сохранить');
        });

        $('body').on('click', '#remove-land', function () {
            let id = $(this).data('id');
            $.post(CONTROLLER_LANDS + 'remove-land', {id: id}, function (data) {
                console.log(data);
                loadLands();
            });
        });

        function loadLands() {
            //Удаляем все нарисованные объекты
            mapLand.geoObjects.removeAll();
            $.post(CONTROLLER_LANDS + 'get-lands', {}, function (data) {
                let collection = new ymaps.GeoObjectCollection(null, {});
                let _result = JSON.parse(data);
                for (let i = 0; i < _result.length; i++) {
                    collection.add(
                        new ymaps.Polygon(
                            [_result[i].coords]
                            , {
                                hintContent: '<div class="p-2 m-2"><span style="color: rgba(41,78,107,0.93); font-size: 16px;">' +
                                    _result[i].name + '</span></div>' + '<p style="font-size: 14px; color: rgba(41,78,107,0.93);">' + _result[i].slug + ' </p>' +
                                    '<p><span style="font-size: 12px; color: rgba(41,78,107,0.93);">' + _result[i].cost + ' руб.</span></p>',
                                balloonContent:
                                    '<p>' +
                                    '<button data-toggle="modal" data-target="#landModal" class="btn btn-default" id="edit-land" ' +
                                    'data-id="' + _result[i].id + '" data-name="' + _result[i].name + '" data-slug="' + _result[i].slug + '" data-cost="' + _result[i].cost + '"' +
                                    'style="font-size: 16px;  color: rgba(41,78,107,0.93);">Изменить описание</button></p>' +
                                    '<p><button class="btn btn-default" id="remove-land" data-id="' + _result[i].id + '" style="font-size: 16px;  color: rgba(41,78,107,0.93);">Удалить участок</button></p>' +
                                '<p><a href="/realtor/map/page?id='+ _result[i].id +'">Описание</a></p>',
                            }, {
                                // Задаем опции геообъекта.
                                // Цвет заливки.
                                fillColor: '#00FF0066',
                                // Ширина обводки.
                                strokeWidth: 1
                            })
                    );
                }
                mapLand.geoObjects.add(collection);
            });
        }

    }

}