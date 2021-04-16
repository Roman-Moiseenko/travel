ymaps.ready(init);

function init() {
    let array_coords = [];
    let array_playcemark = [];
    let count_point;
    let mapShop;

    if (document.getElementById("map-shop-ad-view")) {
        let count_ = $('#count-points').data('count');
        let x, y, t;
        let center_;
        if (count_ !== 0) {
            center_ = [Number($('#latitude-1').val()), Number($('#longitude-1').val())];
        } else {
            center_ = [54.74639455404805, 20.537801017695948];
        }
        let mapShopView = new ymaps.Map(document.getElementById("map-shop-ad-view"), {
            center: center_,
            zoom: 10
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });
        mapShopView.controls.remove('searchControl');
        mapShopView.controls.remove('trafficControl');
        mapShopView.controls.remove('geolocationControl');
        //Проходим по элементам, если есть список, грузим в карту

        for (let i = 0; i < count_; i++) {
            t = $('#address-' + (i + 1)).val();
            x = $('#latitude-' + (i + 1)).val();
            y = $('#longitude-' + (i + 1)).val();
            mapShopView.geoObjects.add(new ymaps.Placemark([x, y], {
                iconContent: i + 1,
                iconCaption: '',
                balloonContent: t
            }, {
                preset: 'islands#violetIcon',//'islands#violetDotIconWithCaption',
                draggable: false
            }));
        }
    }

    if (document.getElementById("map-shop-ad")) {
        count_point = $('#map-points').data('count');
        let x, y, t, c, p;
        let center_;
        if (count_point !== 0) {
            center_ = [Number($('#latitude-1').val()), Number($('#longitude-1').val())];
        } else {
            center_ = [54.74639455404805, 20.537801017695948];
        }
        mapShop = new ymaps.Map(document.getElementById("map-shop-ad"), {
            center: center_,
            zoom: 10
        }, {
            restrictMapArea: [
                [54.256, 19.586],
                [55.317, 22.975]
            ]
        });
        mapShop.controls.remove('searchControl');
        mapShop.controls.remove('trafficControl');
        mapShop.controls.remove('geolocationControl');

        //Проходим по элементам, если есть список, грузим в карту
        //Заполняем данные из формы на странице
        for (let i = 1; i <= count_point; i++) {
            t = $('#address-' + (i)).val();
            x = $('#latitude-' + (i)).val();
            y = $('#longitude-' + (i)).val();
            c = $('#city-' + (i)).val();
            p = $('#phone-' + (i)).val();
            array_coords[i] = [Number(x), Number(y), t, p, c];
            array_playcemark[i] = new ymaps.Placemark(array_coords[i], {
                iconContent: i,
                balloonContent: t
            }, {
                preset: 'islands#violetIcon',
                draggable: true
            });
            array_playcemark[i].id = i;
            setDataShop(array_coords[i], i);
            mapShop.geoObjects.add(array_playcemark[i]);
            array_playcemark[i].events.add('dragend', function (e) {
                let _id_dragent = e.originalEvent.target.id;
                let coords = array_playcemark[_id_dragent].geometry.getCoordinates();
                array_coords[_id_dragent][0] = coords[0];
                array_coords[_id_dragent][1] = coords[1];
                array_playcemark[_id_dragent].properties.set('iconCaption', 'поиск...');
                setDataShop(coords, _id_dragent);
            });
        }

        mapShop.events.add('click', function (e) {
            count_point++;
            array_coords[count_point] = e.get('coords');

            array_playcemark[count_point] = new ymaps.Placemark(array_coords[count_point], {
                iconContent: count_point
            }, {
                preset: 'islands#violetIcon',
                draggable: true
            });
            array_playcemark[count_point].id = count_point;
            setDataShop(array_coords[count_point], count_point);
            mapShop.geoObjects.add(array_playcemark[count_point]);
            // Слушаем событие окончания перетаскивания на метке.
            array_playcemark[count_point].events.add('dragend', function (e) {
                let coords = array_playcemark[e.originalEvent.target.id].geometry.getCoordinates();
                array_coords[e.originalEvent.target.id] = coords;
                array_playcemark[e.originalEvent.target.id].properties.set('iconCaption', 'поиск...');
                setDataShop(coords, e.originalEvent.target.id);
            });

        });
    }

    function setDataShop(coords, id) {
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);

                array_coords[id][2] = firstGeoObject.getAddressLine();
                array_coords[id][4] = firstGeoObject.getLocalities()[0];

            array_playcemark[id].properties
                .set({
                    iconCaption: '',
                    balloonContent: firstGeoObject.getAddressLine()
                });
            FillPoints();
        });
    }

    function FillPoints() {
        $('#map-points').html('');
        let s = '';
        let btn_remove = '';
        for (let i = 1; i <= count_point; i++) {
            if (array_coords[i][3] === undefined) array_coords[i][3] = '';
            if (array_coords[i][4] === undefined) array_coords[i][4] = '';
            if (i === count_point) btn_remove = '<span class="glyphicon glyphicon-trash" style="cursor: pointer" id="remove-points"></span>';
            s = s +
                '                    <div class="row">\n' +
                '                        <div class="col-7">\n' +
                '                            <input name="AdInfoAddressForm[' + (i - 1) + '][address]" class="form-control" width="100%" value="' + getChangeAddress(array_coords[i][2]) + '" readonly>\n' +
                '                        </div>\n' +
                '                        <div class="col-4">\n' +
                '                            <input name="AdInfoAddressForm[' + (i - 1) + '][phone]" class="form-control input-phone" data-id="'+ i + '" width="100%" value="' + (array_coords[i][3]) + '">\n' +
                '                        </div>\n' +
                '                        <div class="col-1">\n' +
                '                        ' + btn_remove + '\n' +
                '                        </div>\n' +
                '                        <div class="col-1">\n' +
                '                            <input name="AdInfoAddressForm[' + (i - 1) + '][longitude]" class="form-control" width="100%" value="' + array_coords[i][1] + '" type="hidden">\n' +
                '                            <input name="AdInfoAddressForm[' + (i - 1) + '][latitude]" class="form-control" width="100%" value="' + array_coords[i][0] + '" type="hidden">\n' +
                '                            <input name="AdInfoAddressForm[' + (i - 1) + '][city]" class="form-control" width="100%" value="' + array_coords[i][4] + '" type="hidden">\n' +
                '                        </div>\n' +
                '                    </div>';
        }
        $('#map-points').html(s);
    }

    $('body').on('click', '#remove-points', function () {
        delete (array_coords[count_point]);
        mapShop.geoObjects.remove(array_playcemark[count_point]);
        //array_playcemark[count_point].destroy();
        delete (array_playcemark[count_point]);
        count_point--;
        FillPoints();
    });

    $(document).on('change', '.input-phone', function () {
        let _phone = $(this).val();
        let _id = $(this).data('id');
        array_coords[_id][3] = _phone;
    });

    //TODO Сделать проверку на ввод телефона

    ////Убираем из адреса Страну и Область
    function getChangeAddress(_address) {
        let m_dev;
        let _country;
        for (let jx = 0; jx < 2; jx++) {
            m_dev = _address.indexOf(',');
            if (m_dev !== -1) {
                _country = _address.slice(0, m_dev);
                if (_country === "Россия" || _country === "Калининградская область") {
                    _address = _address.slice(m_dev + 1, _address.length);
                    _address = _address.trimStart();
                }
            }
        }
        return _address;
    }

    //Вытаскиваем название нас.пункта без типа
    function getCityAddress(_city) {
        let n_dev = _city.indexOf(' ');
        if (n_dev !== -1) _city = _city.slice(n_dev + 1, _city.length);
        return _city;
    }

}