<?php


/* @var $this yii\web\View */
/* @var  $car Car */

$this->title = 'Бронирование ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Бронирование';
$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '#view_cancel', function () {
        let value = 1;
        if ($(this).is(':checked')) {value = 1;} else {value = 0;}
        $.post("/cabinet/preferences/set-params",
            {name_params: "view_cancel", value_params: value},
            function (data) {
            $("#error_data").html(data);
        });
    });
}); 
JS;

$this->registerJs($js);
use booking\entities\booking\cars\Car; ?>
<div class="cars-view">
    <input type="hidden" id="number-car" value="<?=$car->id?>">
    <div class="card card-secondary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div id="datepicker-booking-car">
                        <input type="hidden" id="datepicker_value" value="">
                    </div>
                    <span class="badge" style="background-color: #dddda1">нет бронирований</span>
                    <span class="badge" style="background-color: #89b7ca">имеются бронирования</span>
                    <span class="badge" style="background-color: #b3dfb1">100% бронирование</span>
                    <i style="color: red">*</i> - <span class="badge">день выдачи транспорта</span>
                    <input class="" type="checkbox" id="view_cancel" <?= $view_cancel ? 'checked' : '' ?>> <label for="view_cancel" style="font-weight: 500; color: #073138; font-size: 14px">показывать отмененные</label>
                    <span class="badge badge-danger" id="error_data"></span>
                </div>
                <div class="col-md-3">
                    <div class="booking-day"></div>
                </div>
            </div>
        </div>
    </div>
</div>





