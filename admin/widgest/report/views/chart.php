<?php

use booking\forms\admin\ChartForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $canvas_id string */
/* @var $canvas_id_money string */

/* @var $model ChartForm */
/* @var $listYear array */

?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">График бронирований</h3>
                <div class="card-tools">
                    <!-- Collapse Button -->
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
                <?php ActiveForm::end(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <canvas id="<?= $canvas_id ?>"></canvas>
                    </div>
                    <div class="col-sm-6">
                        <canvas id="<?= $canvas_id_money ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>