<?php

use admin\widgest\report\chart\ChartJsWidget;
use booking\forms\admin\ChartForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $canvas_id integer */
/* @var $model ChartForm */
/* @var $listYear array */

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">График бронирований</h3>
        <div class="card-tools">
            <!-- Collapse Button -->
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
<?php $form = ActiveForm::begin([]); ?>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'year')->dropDownList($listYear, ['onchange' => 'submit()'])->label(false) ?>
    </div>
    <div class="col">
        <?= $form->field($model, 'month')
            ->radioList([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], [
                'class' => 'form_radio_group',
                'item' => function ($index, $label, $name, $checked, $value) {
                    return '<div class="form_radio_group-item">' .
                        Html::radio($name, $checked, ['value' => $value, 'class' => 'project-status-btn', 'id' => 'chart-month-' . $value, 'onchange' => 'submit()']) .
                        '<label for="chart-month-' . $value . '">' . ($value == 0 ? 'Все' : $value) . '</label>' .
                        '</div>';
                },
            ])->label(false)
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'confirmation')->checkbox(['onchange' => 'submit()'])->label('Подтверждено')?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'booking')->checkbox(['onchange' => 'submit()'])->label('Забронировано')?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'pay')->checkbox(['onchange' => 'submit()'])->label('Приобретено')?>
    </div>
</div>
<?php ActiveForm::end(); ?>

        <canvas id="<?= $canvas_id ?>"></canvas>
    </div>
</div>
