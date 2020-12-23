<?php


/* @var $this yii\web\View */
/* @var  $tour Tour */

$this->title = 'Бронирование ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
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

use booking\entities\booking\tours\Tour;
use booking\helpers\SysHelper; ?>
<div class="tours-view">
    <input type="hidden" id="number-tour" value="<?=$tour->id?>">
    <div class="card card-secondary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?php if (SysHelper::isMobile()):?>
                        <div id="datepicker-booking-tour"  class="input-group date">
                            <input type="text" class="form-control" id="datepicker_value" readonly>
                            <span class="input-group-addon form-control-sm"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    <?php else: ?>
                        <div id="datepicker-booking-tour">
                            <input type="hidden" id="datepicker_value" value="">
                        </div>
                    <?php endif; ?>
                    <span class="badge" style="background-color: #dddda1">нет бронирований</span>
                    <span class="badge" style="background-color: #89b7ca">имеются бронирования</span>
                    <span class="badge" style="background-color: #b3dfb1">100% бронирование</span>
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





