<?php


use booking\entities\booking\cars\Car;
use yii\helpers\Url;

/* @var  $car Car */
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $object_id int */

$js = <<<JS
    let car_id = $car->id;
    //Событие при выборе даты
    $(document).on('change', '#selling-calendar', function () {
            let _date = $(this).val();
            if (_date === "") {
                $('#list-count').html('');
            } else {
                $.post('/selling-car/get-selling', {date: _date, car_id: car_id },
                    function (data) {
                         $('#list-count').html(data);
                    });
            }
    });
    $(document).on('click', '#selling-add', function() {
        let calendar_id  = $('#calendar-id').data('id');
        let _count  = $('#selling-count').val();
        $.post('/selling-car/add-selling', {calendar_id: calendar_id, count: _count},
            function (data) {
            $('#list-count').html(data);
        });      
    });
    $(document).on('click', '#selling-remove', function() {
        let selling_id  = $(this).data('id');
        let calendar_id  = $('#calendar-id').data('id');
        $.post('/selling-car/remove-selling', {selling_id: selling_id, calendar_id: calendar_id},
            function (data) {
                $('#list-count').html(data);
        });      
    });
    
JS;

$this->registerJs($js);
$this->title = 'Прямая продажа ' . $car->name;
?>
<div class="d-flex p-2 justify-content-center" style="background-color: #85c17c; color: #134b18; font-size: 26px; font-weight: 600; text-align:  center;">
    <?= '<a class="link-head" href="' . Url::to(['/give/view', 'id' => $object_id]). '"><i class="fas fa-reply"></i></a>&#160;' . $car->name ?>
</div>
<div class="selling-car pt-2">
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

