<?php


use booking\entities\booking\tours\Tour;

/* @var  $tour Tour */
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */

$js = <<<JS
    let tour_id = $tour->id;
    //Событие при выборе даты
    $(document).on('change', '#selling-calendar', function () {
            let _date = $(this).val();
            if (_date === "") {
                $('#select-time').html('');
            } else {
                $.post('/tour/selling/get-time', {date: _date, tour_id: tour_id },
                    function (data) {
                         $('#select-time').html(data);
                    });
            }
    });
    $(document).on('change', '#selling-tour-time', function() {
        let calendar_id = $(this).val();
        if (calendar_id == -1) {
            $('#list-count').html('');
        } else {
            $.post('/tour/selling/get-selling', {calendar_id: calendar_id},
                function (data) {
                    $('#list-count').html(data);
            });     
        }
    });
    $(document).on('click', '#selling-add', function() {
        let calendar_id  = $('#selling-tour-time').val();
        let _count  = $('#selling-count').val();
        $.post('/tour/selling/add-selling', {calendar_id: calendar_id, count: _count},
            function (data) {
            $('#list-count').html(data);
        });      
    });
    $(document).on('click', '#selling-remove', function() {
        let selling_id  = $(this).data('id');
        let calendar_id  = $('#selling-tour-time').val();
        $.post('/tour/selling/remove-selling', {selling_id: selling_id, calendar_id: calendar_id},
            function (data) {
                $('#list-count').html(data);
        });      
    });
    
JS;

$this->registerJs($js);
$this->title = 'Прямая продажа ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Прямая продажа';
?>

<div class="selling-tour">
    <div class="col-sm-3">
    <div class="card">
        <div class="card-body">
            <div>
                <label for="selling-calendar"><b><?= 'Установите дату' ?>:</b></label>
                    <input id="selling-calendar" type="date" class="form-control" value="0000-00-00"/>
            </div>
            <div id="select-time"></div>
        </div>
    </div>
    </div>
</div>

