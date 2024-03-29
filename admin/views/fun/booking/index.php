<?php


/* @var $this yii\web\View */
/* @var  $fun Fun */
/* @var $view_cancel bool */

$this->title = 'Бронирование ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
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

use booking\entities\booking\funs\Fun;
use booking\helpers\SysHelper;

?>
<div class="funs-view">
    <input type="hidden" id="number-fun" value="<?= $fun->id ?>">
    <div class="card card-secondary">
        <div class="card-body">
            <div class="row">
                <?php if (SysHelper::isMobile()): ?>
                <div id="datepicker-booking-fun" class="input-group date">
                    <input type="text" class="form-control" id="datepicker_value" readonly>
                    <span class="input-group-addon form-control-sm"><i class="glyphicon glyphicon-th"></i></span>
                </div>
                <div>
                <!-- ПОВТОР -->
                <span class="badge" style="background-color: #dddda1">нет бронирований</span>
                <span class="badge" style="background-color: #89b7ca">имеются бронирования</span>
                <span class="badge" style="background-color: #b3dfb1">100% бронирование</span>
                <input class="" type="checkbox" id="view_cancel" <?= $view_cancel ? 'checked' : '' ?>> <label
                        for="view_cancel" style="font-weight: 500; color: #073138; font-size: 14px">показывать
                    отмененные</label>
                <span class="badge badge-danger" id="error_data"></span>
            </div>
            <div class="booking-day"></div>
            <?php else: ?>
                <table width="100%" valign="top">
                    <tr valign="top">
                        <td width="640px">
                            <div id="datepicker-booking-fun">
                                <input type="hidden" id="datepicker_value" value="">
                            </div>
                            <!-- ПОВТОР -->
                            <span class="badge" style="background-color: #dddda1">нет бронирований</span>
                            <span class="badge" style="background-color: #89b7ca">имеются бронирования</span>
                            <span class="badge" style="background-color: #b3dfb1">100% бронирование</span>
                            <input class="" type="checkbox" id="view_cancel" <?= $view_cancel ? 'checked' : '' ?>>
                            <label for="view_cancel" style="font-weight: 500; color: #073138; font-size: 14px">показывать
                                отмененные</label>
                            <span class="badge badge-danger" id="error_data"></span>
                        </td>
                        <td class="p-2" valign="top">
                            <div class="booking-day"></div>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>





