<?php


use booking\entities\booking\cars\Car;

/* @var  $car Car */
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */

$js = <<<JS
    let car_id = $car->id;
    //Событие при выборе даты
    $(document).on('change', '#selling-calendar', function () {
            let _date = $(this).val();
            if (_date === "") {
                $('#list-count').html('');
            } else {
                $.post('/car/selling/get-selling', {date: _date, car_id: car_id },
                    function (data) {
                         $('#list-count').html(data);
                    });
            }
    });
    
    $(document).on('click', '#selling-add', function() {
        let calendar_id  = $('#calendar-id').data('id');
        let _count  = $('#selling-count').val();
        $.post('/car/selling/add-selling', {calendar_id: calendar_id, count: _count},
            function (data) {
            $('#list-count').html(data);
        });      
    });
    $(document).on('click', '#selling-remove', function() {
        let selling_id  = $(this).data('id');
        let calendar_id  = $('#calendar-id').data('id');
        $.post('/car/selling/remove-selling', {selling_id: selling_id, calendar_id: calendar_id},
            function (data) {
                $('#list-count').html(data);
        });      
    });
    
JS;

$this->registerJs($js);
$this->title = 'Прямая продажа ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Прямая продажа';
?>

<div class="selling-car">
    <div class="col-sm-3">
    <div class="card">
        <div class="card-body">
            <div class="pb-2">
                <label for="selling-calendar"><b><?= 'Установите дату' ?>:</b></label>
                    <input id="selling-calendar" type="date" class="form-control" value="0000-00-00"/>
            </div>
            <div id="list-count"></div>
        </div>
    </div>
    </div>
</div>

